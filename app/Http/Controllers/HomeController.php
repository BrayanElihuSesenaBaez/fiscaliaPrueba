<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Se verifica el rol del usuario autenticado
        if (Auth::user()->hasRole('Fiscal General')) {
            return view('dashboard');  // Vista para el Fiscal General
        } else {
            return view('app_user');  // Vista para los demás roles
        }
    }
}
