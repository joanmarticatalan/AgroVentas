<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use App\Models\Producto;
use App\Models\Localizacion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(): View
    {
        $usuarios = User::with('localizacion')
            ->latest()
            ->get();

        $resumen = [
            'usuarios' => User::count(),
            'admins' => User::where('tipoCliente', 'admin')->count(),
            'vendedores' => User::whereIn('tipoCliente', ['vendedor', 'compraventa'])->count(),
            'productos' => Producto::count(),
            'pedidos' => Pedido::count(),
        ];

        return view('gestionusuarios', compact('usuarios', 'resumen'));
    }

    public function create(): View
    {
        $localizaciones = Localizacion::orderBy('provincia')->get();

        return view('usuarios.crear', compact('localizaciones'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users',
            'password'        => 'required|string|min:8|confirmed',
            'telefono'        => 'required|string|max:20',
            'tipoCliente'     => 'required|in:comprador,vendedor,compraventa,admin',
            'localizacion_id' => 'nullable|exists:localizaciones,id',
        ]);

        User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'password'        => Hash::make($validated['password']),
            'telefono'        => $validated['telefono'],
            'tipoCliente'     => $validated['tipoCliente'],
            'localizacion_id' => $validated['localizacion_id'] ?? null,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user): View
    {
        $user->load('localizacion');

        return view('usuarios.ver', compact('user'));
    }

    public function edit(User $user): View
    {
        $localizaciones = Localizacion::orderBy('provincia')->get();

        return view('usuarios.editar', compact('user', 'localizaciones'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
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

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
            'tipoCliente' => $validated['tipoCliente'],
            'localizacion_id' => $validated['localizacion_id'] ?? null,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario actualizado.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ((int) $user->id === (int) auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar tu propio usuario administrador.');
        }

        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado.');
    }
}
