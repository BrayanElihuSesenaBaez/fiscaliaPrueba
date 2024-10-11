<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        $users = User::all(); // O cualquier lógica para obtener los usuarios
        return view('users.index', compact('users'));
    }

    // Mostrar formulario para crear un nuevo usuario
    public function create()
    {
        $roles = Role::where('name', '!=', 'Fiscal General')->get();
        return view('users.create', compact('roles'));
    }

    // Guardar el nuevo usuario en la base de datos
    // Metodo para crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'array', // Acepta un array de roles
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }


    // Mostrar formulario para editar un usuario existente
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Actualizar el usuario en la base de datos
    // Metodo para crear o actualizar un usuario
    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'roles' => 'required|array', // Asegúrate de que se envíe un arreglo de roles
        ]);

        // Encuentra al usuario
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Sincroniza los roles usando los nombres en vez de IDs
        $roles = $request->input('roles'); // Esto debe ser un arreglo con los nombres de los roles
        $user->syncRoles($roles);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }


    // Eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function __construct()
    {
        $this->middleware('role:Fiscal General'); // Solo el Fiscal General puede acceder a estas acciones
    }

}
