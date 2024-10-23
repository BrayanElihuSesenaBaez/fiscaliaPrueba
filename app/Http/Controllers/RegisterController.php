<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request){
        //Se registra el usuario con un nombre, email y contraseña
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        //Se crea y se guarda el usuario creado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Se autentica el usuario
        Auth::login($user);

        //Segun el rol es donde se redirige
        return redirect()->route(Auth::user()->hasRole('Fiscal General') ? 'dashboard' : 'inicio');
    }
}
