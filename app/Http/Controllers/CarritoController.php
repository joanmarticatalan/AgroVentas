<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function all()
    {
        $carrito = collect(session()->get('carrito', []))
            ->map(fn (array $linea): array => $this->normalizarLineaCarrito($linea))
            ->all();

        return view('carrito', ['carro' => $carrito]);
    }

    public function add(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $datos = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1'],
        ]);

        $carrito = session()->get('carrito', []);
        $lineaActual = $this->normalizarLineaCarrito($carrito[$id] ?? null, $producto);
        $cantidadTotal = $lineaActual['cantidad'] + (int) $datos['cantidad'];

        if ($cantidadTotal > (int) $producto->stock) {
            return redirect()
                ->back()
                ->withErrors([
                    'cantidad' => 'La cantidad solicitada supera el stock disponible.',
                ])
                ->withInput();
        }

        $carrito[$id] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'cantidad' => $cantidadTotal,
            'precio' => (float) $producto->precio,
        ];

        session()->put('carrito', $carrito);

        return redirect()->back();
    }

    public function deleteOne($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $linea = $this->normalizarLineaCarrito($carrito[$id]);
            $linea['cantidad']--;

            if ($linea['cantidad'] <= 0) {
                unset($carrito[$id]);
            } else {
                $carrito[$id] = $linea;
            }

            session()->put('carrito', $carrito);
        }

        return redirect()->back();
    }

    public function deleteAll()
    {
        session()->forget('carrito');

        return redirect()->back();
    }

    private function normalizarLineaCarrito(?array $linea, ?Producto $producto = null): array
    {
        return [
            'id' => $linea['id'] ?? $producto?->id,
            'nombre' => $linea['nombre'] ?? $linea['name'] ?? $producto?->nombre,
            'cantidad' => (int) ($linea['cantidad'] ?? $linea['quantity'] ?? 0),
            'precio' => (float) ($linea['precio'] ?? $linea['price'] ?? $producto?->precio ?? 0),
        ];
    }
}
