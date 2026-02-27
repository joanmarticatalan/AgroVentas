<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Localizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with('localizacion')->get();
        return view('gestionusuarios', compact('usuarios'));
    }

    public function create()
    {
        $localizaciones = Localizacion::all();
        return view('usuarios.crear', compact('localizaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users',
            'password'        => 'required|string|min:8|confirmed',
            'telefono'        => 'required|string|max:20',
            'tipoCliente'     => 'required|in:comprador,vendedor,compraventa,admin',
            'localizacion_id' => 'nullable|exists:localizaciones,id',
        ]);

        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'telefono'        => $request->telefono,
            'tipoCliente'     => $request->tipoCliente,
            'localizacion_id' => $request->localizacion_id,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user)
    {
        return view('usuarios.ver', compact('user'));
    }

    public function edit(User $user)
    {
        $localizaciones = Localizacion::all();
        return view('usuarios.editar', compact('user', 'localizaciones'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'telefono'        => 'required|string|max:20',
            'tipoCliente'     => 'required|in:comprador,vendedor,compraventa,admin',
            'localizacion_id' => 'nullable|exists:localizaciones,id',
        ]);

        $data = $request->only('name', 'email', 'telefono', 'tipoCliente', 'localizacion_id');

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario actualizado.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado.');
    }
}