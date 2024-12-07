<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

    public function __construct(){
        $this->middleware('role:Fiscal General');
    }

    public function index(){
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create(){
        $roles = Role::where('name', '!=', 'Fiscal General')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8',
            'firstLastName' => 'required|string|max:30',
            'secondLastName' => 'required|string|max:30',
            'curp' => 'required|string|size:18',
            'birthDate' => 'required|date',
            'phone' => 'required|string|min:10|max:15',
            'state' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'colony' => 'required|string|max:255',
            'code_postal' => 'required|digits:5',
            'street' => 'required|string|max:255',
            'rfc' => 'required|string|regex:/^[A-Z]{3,4}\d{6}[A-Z0-9]{2,3}$/|min:12|max:13',
            'roles' => 'array',
        ]);

        $user = new User();
        $user->fill($validatedData);
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles'));
        }
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'required|array',

            'firstLastName' => 'required|string|max:255',
            'secondLastName' => 'required|string|max:255',
            'curp' => 'required|string|size:18',
            'birthDate' => 'required|date',
            'phone' => 'required|string|max:15',
            'state' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'colony' => 'required|string|max:255',
            'code_postal' => 'required|digits:5',
            'street' => 'required|string|max:255',
            'rfc' => 'required|string|regex:/^[A-Z]{3,4}\d{6}[A-Z0-9]{2,3}$/|min:12|max:13',

        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        if (isset($validatedData['roles'])) {
            $user->syncRoles($validatedData['roles']);
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
