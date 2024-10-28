@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Crear Usuario</h2>

        <form method="POST" action="{{ route('users.store') }}"> <!-- Formulario que envía datos al metodo store del controlador de users -->
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label>Roles</label>
                <table class="table"> <!-- Tabla listada con los roles disponibles -->
                    <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Seleccionar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role) <!-- Muestra los roles disponibles -->
                        <tr>
                            <td>{{ $role->name }}</td> <!-- Muestra el nombre del rol -->
                            <td>
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"> <!-- Checkbox para seleccionar el rol -->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Crear Usuario</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Regresar</a>
        </form>
    </div>
@endsection


