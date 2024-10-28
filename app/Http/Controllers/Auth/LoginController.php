<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{

    // Formulaio del inicio de sesion
    public function showLoginForm(){
        return view('auth.login');
    }

    // Funcion que maneja el inicio de sesión
    public function login(Request $request){
        //Obtiene las datos del usuario (email y password) del formulario de inicio de sesion
        $credentials = $request->only('email', 'password');

        // Intentica al usuario con las datos proporcionados
        if (Auth::attempt($credentials)) {
            // Obtiene al usuario autenticado
            $user = Auth::user();

            // Verifica el rol del usuario y redirige a la pagina correspondiente
            if ($user->hasRole('Fiscal General')) {
                return redirect()->route('dashboard');
            }

            // Redirige a una ruta predeterminada (home) su ek usuario tiene otro rol
            return redirect('home');
        }

        // Si son incorrectos los datos, regresa al formulario mostrando un mesaje de error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
    }

    // Maneja el cierre de sesión de un usuario
    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }
}
