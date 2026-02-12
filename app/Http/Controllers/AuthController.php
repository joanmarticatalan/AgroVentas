<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Localizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formularios
    public function showRegister() {
        $localizaciones = Localizacion::all(); // Necesario para el select del formulario
        return view('registro', compact('localizaciones'));
    }

    public function showLogin() {
        return view('login');
    }

    // Lógica de Registro
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required|string|max:20',
            'tipoCliente' => 'required|in:particular,empresa', // Ajusta según tus tipos
            'localizacion_id' => 'required|exists:localizaciones,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'tipoCliente' => $request->tipoCliente,
            'localizacion_id' => $request->localizacion_id,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    // Lógica de Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['email' => 'Las credenciales no coinciden.']);
    }
}