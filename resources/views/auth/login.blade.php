<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Enlace para estilos de Booststrap -->
        <link rel="stylesheet" href="node_modeles/boostrap/css">
        <link rel="stylesheet" href="node_modeles/boostrap/js">
    </head>
    <style>
        .bg-morena {
            background-color: rgba(242,243,245,1);
        }
        .text-morena {
            color: {{ $settings->button_color }};

        }
        .btn-morena {
            background-color: {{ $settings->button_color }};
            border-color: {{ $settings->button_color }};
            color: #fff;
            transition: all 0.3s ease-in-out;
        }
        .btn-morena:active {
            transform: scale(0.95);
        }
        .btn-morena:hover {
            background-color: {{ $settings->button_color }};
            border-color: {{ $settings->button_color }};
            transform: scale(1.1);
        }
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }


        .card {
            animation: fadeInUp 0.9s ease-out;
        }
        #loading {
            margin-left: 10px;
        }

    </style>

<body>
<div class="bg-morena text-white d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg" style="width: 100%; max-width: 400px; height: auto;">


    <div class="container">
        <h2 class="text-center text-morena mb-4">Iniciar Sesión</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label text-morena">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="👤 Escribe tu correo" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-morena">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="🔒 Escribe tu contraseña" required>
            </div>

            <button type="submit" class="btn btn-morena w-100 text-white" id="submit-btn">
                Iniciar Sesión
            </button>


        </form>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>  <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> <!-- Popper.js para herramientas de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- JavaScript de Bootstrap -->
</body>
</html>
