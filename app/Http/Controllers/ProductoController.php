<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\User;
use App\Models\Localizacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'q' => $this->normalizeQueryString($request->query('q')),
            'localizacion_id' => $this->normalizeQueryString($request->query('localizacion_id')),
            'precio_min' => $this->normalizeQueryString($request->query('precio_min')),
            'precio_max' => $this->normalizeQueryString($request->query('precio_max')),
            'disponibilidad' => $this->normalizeAvailability($request->query('disponibilidad')),
            'fecha_desde' => $this->normalizeQueryString($request->query('fecha_desde')),
            'fecha_hasta' => $this->normalizeQueryString($request->query('fecha_hasta')),
            'sort' => $this->normalizeSort($request->query('sort')),
            'invalid_ranges' => [],
        ];

        $precioMin = $this->normalizeDecimal($filters['precio_min']);
        $precioMax = $this->normalizeDecimal($filters['precio_max']);
        $fechaDesde = $this->normalizeDate($filters['fecha_desde']);
        $fechaHasta = $this->normalizeDate($filters['fecha_hasta']);

        $hasInvalidPriceRange = $precioMin !== null && $precioMax !== null && $precioMin > $precioMax;
        $hasInvalidDateRange = $fechaDesde !== null && $fechaHasta !== null && $fechaDesde->gt($fechaHasta);

        if ($hasInvalidPriceRange) {
            $filters['invalid_ranges'][] = 'precio';
            $precioMin = null;
            $precioMax = null;
        }

        if ($hasInvalidDateRange) {
            $filters['invalid_ranges'][] = 'fecha';
            $fechaDesde = null;
            $fechaHasta = null;
        }

        $productsQuery = Producto::query()
            ->with(['vendedor', 'localizacion'])
            ->when($filters['q'], function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('nombre', 'like', '%' . $search . '%')
                        ->orWhere('variedad', 'like', '%' . $search . '%');
                });
            })
            ->when($filters['localizacion_id'], function ($query, $localizacionId) {
                $query->where('localizacion_id', $localizacionId);
            })
            ->when($filters['disponibilidad'] === 'available', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->when($precioMin !== null, function ($query) use ($precioMin) {
                $query->where('precio', '>=', $precioMin);
            })
            ->when($precioMax !== null, function ($query) use ($precioMax) {
                $query->where('precio', '<=', $precioMax);
            })
            ->when($fechaDesde !== null, function ($query) use ($fechaDesde) {
                $query->whereDate('fechaProduccion', '>=', $fechaDesde->toDateString());
            })
            ->when($fechaHasta !== null, function ($query) use ($fechaHasta) {
                $query->whereDate('fechaProduccion', '<=', $fechaHasta->toDateString());
            });

        $this->applySorting($productsQuery, $filters['sort']);

        $products = $productsQuery->get();

        $localizaciones = Localizacion::all();

        return view('products', [
            'products' => $products,
            'localizaciones' => $localizaciones,
            'filters' => $filters,
        ]);
    }

    private function normalizeQueryString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $trimmedValue = trim($value);

        return $trimmedValue === '' ? null : $trimmedValue;
    }

    private function normalizeAvailability(mixed $value): string
    {
        return $value === 'available' ? 'available' : 'all';
    }

    private function normalizeSort(mixed $value): string
    {
        return in_array($value, ['recent', 'price_asc', 'price_desc', 'name_asc'], true)
            ? $value
            : 'recent';
    }

    private function normalizeDecimal(?string $value): ?float
    {
        if ($value === null || ! is_numeric($value)) {
            return null;
        }

        $decimalValue = (float) $value;

        return $decimalValue >= 0 ? $decimalValue : null;
    }

    private function normalizeDate(?string $value): ?Carbon
    {
        if ($value === null) {
            return null;
        }

        try {
            return Carbon::parse($value)->startOfDay();
        } catch (\Throwable) {
            return null;
        }
    }

    private function applySorting($query, string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('precio'),
            'price_desc' => $query->orderByDesc('precio'),
            'name_asc' => $query->orderBy('nombre'),
            default => $query->orderByDesc('created_at'),
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre'           => 'required|string|max:25',
            'variedad'         => 'required|string|max:50',
            'stock'            => 'required|integer|min:0',
            'precio'           => 'required|numeric|min:0',
            'fecha'            => 'required|date',          
            'localizacion_id'  => 'required|exists:localizaciones,id',
            'imagen'           => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        
        $imagenPath = $request->file('imagen')->store('productos', 'public');

        
        Producto::create([
            'user_id'          => auth()->id(),
            'nombre'           => $validated['nombre'],
            'variedad'         => $validated['variedad'],
            'stock'            => $validated['stock'],
            'precio'           => $validated['precio'],
            'fechaProduccion'  => $validated['fecha'],
            'localizacion_id'  => $validated['localizacion_id'],
            'imagen'           => $imagenPath,
        ]);

        return redirect()->route('todos.productos')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $localizaciones = Localizacion::all();
        return view('editar', compact('producto', 'localizaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        
        if ($producto->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para modificar este producto.');
        }

        
        $validated = $request->validate([
            'nombre'           => 'required|string|max:25',
            'variedad'         => 'required|string|max:50',
            'stock'            => 'required|integer|min:0',
            'precio'           => 'required|numeric|min:0',
            'fecha'            => 'required|date',
            'localizacion_id'  => 'required|exists:localizaciones,id',
            'imagen'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        
        $data = [
            'nombre'           => $validated['nombre'],
            'variedad'         => $validated['variedad'],
            'stock'            => $validated['stock'],
            'precio'           => $validated['precio'],
            'fechaProduccion'  => $validated['fecha'],
            'localizacion_id'  => $validated['localizacion_id'],
        ];

        
        if ($request->hasFile('imagen')) {
            
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

       
        $producto->update($data);

        return redirect()->route('todos.productos')
            ->with('success', 'Producto actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('todos.productos')->with('success', 'Producto eliminado correctamente');
    }

    public function verinfo($id)
    {
        $producto= Producto::findOrFail($id);
        $user=User::findOrFail($producto->user_id);
        return view('infoproducto',['producto'=>$producto,'user'=>$user]);
    }
    public function verNuevoProducto()
    {
        $localizaciones=Localizacion::all();
        return view('nuevoproducto',['localizaciones'=>$localizaciones]);
    }
    public function verMisProductos()
    {
        $productos= Producto::where('user_id',auth()->id())->get();
        return view('misproductos',['productos'=>$productos]);
    }       
    
}
