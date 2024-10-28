<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Estilo a la hoja de Bootstrap -->
    </head>

    <body>
        <div class="container">
            <h2 class="mt-5">Registro de Usuario</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}"> <!-- Formulario para registrar un nuevo usuario -->
                @csrf <!-- Protección contra CSRF -->
                <div class="form-group">
                    <label for="name">Nombre Completo</label>
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
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> <!-- Popper.js para herramientas de Bootstrap -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- JavaScript de Bootstrap -->
    </body>

</html>

