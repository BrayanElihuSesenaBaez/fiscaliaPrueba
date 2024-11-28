<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller{

    //Maneja el cierre de sesion de un usuario
    public function logout(Request $request){

        //Cierra la sesion del usuario actual
        Auth::logout();

        //Invalida la sesion actual para asegurar que no se reutilce
        $request->session()->invalidate();

        //Regenera el token CSRF para la siguiente sesion
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
