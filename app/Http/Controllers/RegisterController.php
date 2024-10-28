<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller{


    public function register(Request $request){

        //Valida los datos de entrada del formulario de registro
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        //Crea y guarda un nuevo usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Autentica al usuario registrado
        Auth::login($user);

        //Redirige al usuario en funcion de su rol
        return redirect()->route(Auth::user()->hasRole('Fiscal General') ? 'dashboard' : 'inicio');
    }
}
