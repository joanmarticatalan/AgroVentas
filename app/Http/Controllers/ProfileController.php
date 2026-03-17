<?php

namespace App\Http\Controllers;

use App\Models\Localizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $localizaciones = Localizacion::all();
        return view('perfil', compact('user', 'localizaciones'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'telefono'        => 'required|string|max:20',
            'localizacion_id' => 'nullable|exists:localizaciones,id',
            'tipoCliente'     => 'sometimes|in:comprador,vendedor,compraventa,admin',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('perfil.editar')
                         ->with('success', 'Perfil actualizado correctamente.');
    }
}