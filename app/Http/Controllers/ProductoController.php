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

        //ACI HE DE VALIDAR LES COSES QUE ENTREN

        $imagenPath = null;
    
        if ($request->hasFile('imagen')) {
            // Guarda la imagen en storage/app/public/productos
            $imagenPath = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create([
            'user_id' => Auth::id(),
            'nombre' => $request->nombre,
            'variedad' => $request->variedad,
            'stock' => $request->stock,
            'fechaProduccion'=> $request->fecha,
            'localizacion_id' => $request->localizacion_id,
            'imagen' => $imagenPath // Guardamos la ruta del archivo
        ]);
        
        return redirect()->back()->with('success', 'Producto creado');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //MIRAR BE LA VALIDADCIÓ
        $request->validate([
            'name' => 'required|max:255',        
            'price' => 'required|numeric|min:0',
            'stock'=>'required|numeric|min:1', 
            'categoria' => 'required|exists:categories,id', 
        ]);

        $product = Producto::findOrFail($id);
        //CAMBIAR PER LES QUE TOQUEN
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->categoria; 

        $product->save();

        return redirect()->route('products')->with('success', 'Producto actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Producto::findOrFail($id);
        $product->delete();
        return redirect()->route('products')->with('success', 'Producto eliminado');
    }

    public function verStock($id)
    {
        $productos= Producto::where('user_id',$id);
        return view('stockproducto',['productos'=>$productos]);
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
    
}
