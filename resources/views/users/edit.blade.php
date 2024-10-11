@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Editar Usuario</h2>

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña (dejar en blanco para no cambiar)</label>
                <input type="password" class="form-control" name="password" id="password">
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
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Regresar</a>
        </form>
    </div>
@endsection


