@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Crear Usuario</h2>

        <form method="POST" action="{{ route('users.store') }}">
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
                <table class="table">
                    <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Seleccionar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}">
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


