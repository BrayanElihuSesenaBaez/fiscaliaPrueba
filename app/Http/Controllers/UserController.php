<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
    // Mustra una lista de usuarios existentes en la base de datos
    public function index(){
        $users = User::all(); //Lógica para obtener todos los usuarios
        return view('users.index', compact('users'));
    }

    // Muestra el formulario para crear un nuevo usuario
    public function create(){
        //Donde el unico rol que puede crear usuarios es quien tiene el rol de Fiscal General
        $roles = Role::where('name', '!=', 'Fiscal General')->get();
        //Retorna a la vista users.create
        return view('users.create', compact('roles'));
    }

    // Guardar el nuevo usuario en la base de datos

    // Metodo para crear un nuevo usuario
    public function store(Request $request){
        //Campos donde se crea el usuario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'array', // Acepta un array de roles
        ]);

        //Crea al usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }
        //Muestra mensaje de confirmacion
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }


    // Mostrar formulario para editar un usuario existente
    public function edit($id){
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Actualizar el usuario en la base de datos
    // Metodo para crear o actualizar un usuario
    public function update(Request $request, $id){
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'roles' => 'required|array',
        ]);

        // Encuentra al usuario
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Sincroniza a los usuarios mediante sus roles usando los nombres en vez de IDs
        $roles = $request->input('roles'); // Arreglo con los nombres de los roles
        $user->syncRoles($roles);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }


    // Eliminar un usuario
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function __construct(){
        $this->middleware('role:Fiscal General'); // Solo el Fiscal General puede acceder a estas acciones
    }
}
