<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use App\Models\Localizacion;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::id();
        $user = User::find($id);
        $pedidos = Pedido::with('productos')->where('user_id', $id)->get();

        return view('pedidos', ['pedidos' => $pedidos, 'usuario' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }

    public function validateOrder(Request $request)
    {
        $cart = session()->get('carrito');

        if (! is_array($cart) || $cart === []) {
            return redirect()->route('carrito.all')->with('error', 'El carrito está vacío');
        }

        $validated = $request->validate([
            'tipoEnvio' => ['required', Rule::in(['EnvioCasa', 'A recoger'])],
            'direccion_opcion' => ['required', Rule::in(['actual', 'nueva'])],
            'localizacion_id' => ['nullable', 'integer', 'exists:localizaciones,id'],
            'nueva_nombreCalle' => ['nullable', 'string', 'max:50', 'required_if:direccion_opcion,nueva'],
            'nueva_numero' => ['nullable', 'string', 'max:5', 'required_if:direccion_opcion,nueva'],
            'nueva_puerta' => ['nullable', 'string', 'max:10'],
            'nueva_codigoPostal' => ['nullable', 'regex:/^\d{5}$/', 'required_if:direccion_opcion,nueva'],
            'nueva_provincia' => ['nullable', 'string', 'max:50', 'required_if:direccion_opcion,nueva'],
        ]);

        $products = Producto::query()
            ->whereIn('id', collect($cart)->pluck('id')->all())
            ->get()
            ->keyBy('id');

        if ($products->count() !== count($cart)) {
            return redirect()->back()->with('error', 'Uno o más productos de tu carrito ya no están disponibles.');
        }

        foreach ($cart as $line) {
            $producto = $products->get($line['id']);

            if ($producto->stock < $line['quantity']) {
                return redirect()->back()->with('error', 'No hay suficiente stock de: '.$producto->nombre);
            }
        }

        $user = Auth::user();

        if ($validated['direccion_opcion'] === 'actual') {
            if (! $user->localizacion_id || (int) $validated['localizacion_id'] !== (int) $user->localizacion_id) {
                return redirect()->back()->with('error', 'Debes usar una dirección válida para completar el pedido.');
            }
        }

        try {
            DB::transaction(function () use ($cart, $products, $validated, $user): void {
                $localizacionId = $validated['direccion_opcion'] === 'actual'
                    ? $user->localizacion_id
                    : Localizacion::create([
                        'provincia' => $validated['nueva_provincia'],
                        'codigoPostal' => $validated['nueva_codigoPostal'],
                        'nombreCalle' => $validated['nueva_nombreCalle'],
                        'numero' => $validated['nueva_numero'],
                        'puerta' => $validated['nueva_puerta'],
                    ])->id;

                $porVendedor = [];

                foreach ($cart as $line) {
                    $producto = $products->get($line['id']);
                    $porVendedor[$producto->user_id][] = [
                        'producto' => $producto,
                        'cantidad' => (int) $line['quantity'],
                    ];
                }

                // Se mantiene el agrupado por vendedor para generar un pedido por proveedor.
                foreach ($porVendedor as $lineas) {
                    $total = collect($lineas)->sum(function (array $linea): float {
                        return (float) $linea['producto']->precio * $linea['cantidad'];
                    });

                    $pedido = new Pedido;
                    $pedido->user_id = Auth::id();
                    $pedido->fecha = Carbon::now()->toDateString();
                    $pedido->tipoEnvio = $validated['tipoEnvio'];
                    $pedido->estado = Pedido::ESTADO_EN_CURSO;
                    $pedido->localizacion_id = $localizacionId;
                    $pedido->precio_total = $total;
                    $pedido->save();

                    foreach ($lineas as $linea) {
                        /** @var Producto $producto */
                        $producto = $linea['producto'];
                        $producto->decrement('stock', $linea['cantidad']);

                        $actualLinea = new Linea;
                        $actualLinea->pedido_id = $pedido->id;
                        $actualLinea->producto_id = $producto->id;
                        $actualLinea->cantidad = $linea['cantidad'];
                        $actualLinea->precio_unitario = $producto->precio;
                        $actualLinea->save();
                    }
                }
            });

            session()->forget('carrito');

            return redirect()->route('pedidos.usuario')->with('success', '¡Compra realizada con éxito!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error al procesar el pedido: '.$e->getMessage());
        }
    }

    public function pedidosVendedor()
    {
        $user = Auth::user();

        $pedidos = Pedido::with(['cliente', 'productos'])->whereHas('productos', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('pedidosVendedor', ['pedidos' => $pedidos]);
    }

    public function updateEstado(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'estado' => ['required', Rule::in([Pedido::ESTADO_ENVIADO, Pedido::ESTADO_LISTO_RECOGER])],
        ]);

        $sellerId = Auth::id();
        $belongsToSeller = $pedido->productos()->where('productos.user_id', $sellerId)->exists();

        if (! $belongsToSeller) {
            abort(403);
        }

        if (! $pedido->canTransitionTo($validated['estado'])) {
            return redirect()
                ->route('pedidos.vendedor')
                ->with('error', 'Este pedido ya no se puede actualizar con ese estado.');
        }

        $pedido->update([
            'estado' => $validated['estado'],
        ]);

        return redirect()
            ->route('pedidos.vendedor')
            ->with('success', 'Estado del pedido actualizado correctamente.');
    }

    public function checkout()
    {
        $cart = session()->get('carrito');

        if (! is_array($cart) || $cart === []) {
            return redirect()->route('carrito.all')->with('error', 'El carrito está vacío');
        }

        $user = Auth::user();
        $localizacion = $user->localizacion;
        $products = Producto::query()
            ->whereIn('id', collect($cart)->pluck('id')->all())
            ->get(['id', 'user_id'])
            ->keyBy('id');

        $sellerCount = collect($cart)
            ->map(fn (array $line) => $products->get($line['id'])?->user_id)
            ->filter()
            ->unique()
            ->count();

        $orderTotal = round(collect($cart)->sum(function (array $line): float {
            return (float) $line['price'] * (int) $line['quantity'];
        }), 2);

        return view('checkout', [
            'cart' => $cart,
            'user' => $user,
            'localizacion' => $localizacion,
            'sellerCount' => $sellerCount,
            'orderTotal' => $orderTotal,
            'defaultAddressOption' => $localizacion ? 'actual' : 'nueva',
        ]);
    }
}
