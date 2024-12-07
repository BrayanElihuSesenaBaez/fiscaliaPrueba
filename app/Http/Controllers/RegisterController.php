<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller{


    public function register(Request $request){

        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8',

            'firstLastName' => 'required|string|max:25',
            'secondLastName' => 'required|string|max:25',
            'curp' => 'required|string|max:18|unique:users',
            'birthDate' => 'required|date',
            'phone' => 'required|string|max:15|unique:users',
            'state' => 'required|string|max:50',
            'municipality' => 'required|string|max:50',
            'colony' => 'required|string|max:50',
            'code_postal' => 'required|string|max:5',
            'street' => 'required|string|max:50',
            'rfc' => 'required|string|max:13|unique:users',

            'roles' => 'array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

            'firstLastName' => $request->firstLastName,
            'secondLastName' =>  $request->secondLastName,
            'curp' =>  $request->curp,
            'birthDate' =>  $request->birthDate,
            'phone' =>  $request->phone,
            'state' => $request->state,
            'municipality' => $request->municipality,
            'colony' => $request->colony,
            'code_postal' => $request->code_postal,
            'street' => $request->street,
            'rfc' => $request->rfc,
        ]);

        Auth::login($user);

        return redirect()->route(Auth::user()->hasRole('Fiscal General') ? 'dashboard' : 'inicio');
    }
}
