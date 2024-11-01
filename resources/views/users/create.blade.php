@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Crear Usuario</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}"> <!-- Formulario que envía datos al metodo store del controlador de users -->
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" required placeholder="Ingrese su nombre" maxlength="30">
            </div>

            <!-- Nuevos campos del formulario -->
            <div class="form-group">
                <label for="firstLastName">Apellido Paterno</label>
                <input type="text" class="form-control" name="firstLastName" id="firstLastName" required placeholder="Ingrese su Apellido Paterno" maxlength="30">
            </div>

            <div class="form-group">
                <label for="secondLastName">Apellido Materno</label>
                <input type="text" class="form-control" name="secondLastName" id="secondLastName" required placeholder="Ingrese su apellido materno" maxlength="30">
            </div>

            <div class="form-group">
                <label for="birthDate">Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="birthDate" id="birthDate" required>
            </div>

            <div class="form-group">
                <label for="curp">CURP</label>
                <input type="text" class="form-control" name="curp" id="curp" required placeholder="Ingrese su CURP (18 dígitos como mínimo)" pattern=".{18}" title="El CURP debe tener exactamente 18 caracteres" maxlength="18">
            </div>

            <div class="form-group">
                <label for="rfc">RFC</label>
                <input type="text" class="form-control" name="rfc" id="rfc" required placeholder="Ingrese su RFC (12 a 13 caracteres)" pattern="^[A-Z]{3,4}\d{6}[A-Z0-9]{2,3}$" title="El RFC puede tener de 12 a 13 caracteres" maxlength="13">
            </div>

            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" class="form-control" name="phone" id="phone" required placeholder="Ingrese su teléfono" pattern="\d{10,15}" title="El teléfono debe tener entre 10 a 15 dígitos" maxlength="15" >
            </div>

            <div class="form-group">
                <label for="state">Estado</label>
                <input type="text" class="form-control" name="state" id="state" required placeholder="Ingrese su estado" maxlength="100">
            </div>

            <div class="form-group">
                <label for="municipality">Municipio</label>
                <input type="text" class="form-control" name="municipality" id="municipality" required placeholder="Ingrese su municipio" maxlength="100">
            </div>

            <div class="form-group">
                <label for="colony">Colonia</label>
                <input type="text" class="form-control" name="colony" id="colony" required placeholder="Ingrese su colonia" maxlength="100">
            </div>

            <div class="form-group">
                <label for="code_postal">Código Postal</label>
                <input type="text" class="form-control" name="code_postal" id="code_postal" required placeholder="Ingrese su código postal" pattern="\d{5}" title="El código postal debe tener exactamente 5 dígitos" maxlength="5">
            </div>

            <div class="form-group">
                <label for="street">Calle</label>
                <input type="text" class="form-control" name="street" id="street" required placeholder="Ingrese su calle" maxlength="100">
            </div>

            <!-- -->

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" id="email" required placeholder="Ingrese su correo electrónico" maxlength="100">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" required placeholder="Ingrese una contraseña">
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


