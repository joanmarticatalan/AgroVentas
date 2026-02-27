<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Localizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        $localizaciones = Localizacion::all();
        return view('registro', compact('localizaciones'));
    }

        public function register(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'password'    => 'required|string|min:8|confirmed',
            'telefono'    => 'required|string|max:20',
            'tipoCliente' => 'required|in:comprador,vendedor,compraventa',
        ]);

        $localizacion_id = null;

        if ($request->filled('localizacion_id')) {
            $localizacion_id = $request->localizacion_id;
        }

        elseif (
            $request->filled('nueva_provincia') &&
            $request->filled('nueva_codigoPostal') &&
            $request->filled('nueva_nombreCalle') &&
            $request->filled('nueva_numero')
        ) {

            $locValidated = $request->validate([
                'nueva_provincia'     => 'required|string|max:50',
                'nueva_codigoPostal'  => 'required|string|max:5|regex:/^[0-9]{5}$/',
                'nueva_nombreCalle'   => 'required|string|max:50',
                'nueva_numero'        => 'required|string|max:5',
                'nueva_puerta'        => 'nullable|string|max:10',
            ]);


            $localizacion = Localizacion::create([
                'provincia'    => $locValidated['nueva_provincia'],
                'codigoPostal' => $locValidated['nueva_codigoPostal'],
                'nombreCalle'  => $locValidated['nueva_nombreCalle'],
                'numero'       => $locValidated['nueva_numero'],
                'puerta'       => $locValidated['nueva_puerta'] ?? null,
            ]);

            $localizacion_id = $localizacion->id;
        }

        $user = User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'password'        => Hash::make($validated['password']),
            'telefono'        => $validated['telefono'],
            'tipoCliente'     => $validated['tipoCliente'],
            'localizacion_id' => $localizacion_id,
        ]);

        Auth::login($user);

        
        return redirect()->route('todos.productos')
                         ->with('success', 'Registro completado con éxito.');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('todos.productos');
        }

        return back()->withErrors(['email' => 'Las credenciales no coinciden.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}