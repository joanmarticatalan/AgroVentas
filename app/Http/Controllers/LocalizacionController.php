<?php

namespace App\Http\Controllers;

use App\Models\Localizacion;
use Illuminate\Http\Request;

class LocalizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        
        $validated = $request->validate([
            'provincia'     => 'required|string|max:50',
            'codigoPostal'  => 'required|string|max:5|regex:/^[0-9]{5}$/', // 5 dígitos numéricos
            'nombreCalle'   => 'required|string|max:50',
            'numero'        => 'required|string|max:5',
            'puerta'        => 'nullable|string|max:10',
        ]);

        
        Localizacion::create($validated);

        return redirect()->route('localizaciones.index')
                         ->with('success', 'Localización creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Localizacion $localizacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localizacion $localizacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
       public function update(Request $request, Localizacion $localizacion)
    {
        
        $validated = $request->validate([
            'provincia'     => 'required|string|max:50',
            'codigoPostal'  => 'required|string|max:5|regex:/^[0-9]{5}$/',
            'nombreCalle'   => 'required|string|max:50',
            'numero'        => 'required|string|max:5',
            'puerta'        => 'nullable|string|max:10',
        ]);

        
        $localizacion->update($validated);

        return redirect()->route('localizaciones.index')
                         ->with('success', 'Localización actualizada correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localizacion $localizacion)
    {
        //
    }
}
