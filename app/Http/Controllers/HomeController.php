<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    //Muestra una vista principal basada en el rol del usuario
    public function index(){
        // Verifica el rol del usuario autenticado
        if (Auth::user()->hasRole('Fiscal General')) {
            return view('dashboard');  // Redirige a la vista 'dashboard' si es el rol de 'Fiscal General'
        } else {
            return view('app_user');  // Redirige a la vista de 'app_user' para otros roles
        }
    }
}
