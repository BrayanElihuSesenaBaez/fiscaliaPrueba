<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{

    // Mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Manejar el inicio de sesión
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Intentar iniciar sesión
        if (Auth::attempt($credentials)) {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Redirigir según el rol del usuario
            if ($user->hasRole('Fiscal General')) {
                return redirect()->route('dashboard'); // Redirige a la vista de lista de usuarios
            }

            // Redirigir a una ruta predeterminada para otros roles
            return redirect('home');
        }

        // Si las credenciales son incorrectas
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
    }

    // Manejar el cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
