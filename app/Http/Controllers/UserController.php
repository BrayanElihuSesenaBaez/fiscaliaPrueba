<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

    public function __construct(){
        $this->middleware('role:Fiscal General'); // Solo el Fiscal General puede acceder a estas acciones
    }

    // Muestra una lista de usuarios existentes en la base de datos
    public function index(){
        $users = User::all(); //Obtiene todos os usuarios
        return view('users.index', compact('users'));
    }

    // Muestra el formulario para crear un nuevo usuario
    public function create(){
        //Obtiene todos los roles excepto el rol de 'Fiscal General'
        $roles = Role::where('name', '!=', 'Fiscal General')->get();
        return view('users.create', compact('roles'));
    }

    // Metodo para crear y guardar a un nuevo usuario en la base de datos
    public function store(Request $request){
        //Validación de datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8',
            //Campos nuevos agregados
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
            //
            'roles' => 'array', // Acepta un array de roles
        ]);

        //Simplificacion de code
        $user = new User();
        $user->fill($validatedData);
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        // Asignación de roles
        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles'));
        }
        //Muestra mensaje de confirmacion
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }


    // Muestra el formulario para editar un usuario existente
    public function edit($id){
        $user = User::findOrFail($id);
        $roles = Role::all();//Obtiene todos los roles
        return view('users.edit', compact('user', 'roles'));
    }

    // Actualiza un usuario en la base de datos
    public function update(Request $request, User $user){
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'required|array',

            //Campos nuevos agregados
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

        // Cambie code
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


    // Elimina un usuario
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
