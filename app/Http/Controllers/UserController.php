<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'array', // Acepta un array de roles
        ]);

        //Crea al nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Sincroniza los roles si se especifican
        if ($request->roles) {
            $user->syncRoles($request->roles);
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
    public function update(Request $request, $id){
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'roles' => 'required|array',
        ]);

        // Encuentra al usuario por ID
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Sincroniza los roles del usuario
        $roles = $request->input('roles'); // Arreglo con los nombres de los roles
        $user->syncRoles($roles);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }


    // Elimina un usuario
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    //Constructor para aplicar middleware (Es un constructor que en este caso solo los usuarios con este rol pueden acceder a los metodos del controlador)
    public function __construct(){
        $this->middleware('role:Fiscal General'); // Solo el Fiscal General puede acceder a estas acciones
    }
}
