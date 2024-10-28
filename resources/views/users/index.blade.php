@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Lista de Usuarios</h2>

        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Crear Nuevo Usuario</a> <!-- Enlace para crear un nuevo usuario -->

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-user-list"> <!-- Tabla para listar los usuarios existentes-->
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td> <!-- Muestra los roles del usuario -->
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection




