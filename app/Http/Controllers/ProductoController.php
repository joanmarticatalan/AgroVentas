<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\User;
use App\Models\Localizacion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Producto::all();
        $localizaciones=Localizacion::all();
        //$usuarios=User::where('tipoCliente','vendedor');
        $usuarios=User::all();
        return view('products', ['products' => $products,'usuarios'=>$usuarios,'localizaciones'=>$localizaciones]);
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
        // Opcional: eliminar imagen asociada
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto = Producto::findOrFail($id);
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
