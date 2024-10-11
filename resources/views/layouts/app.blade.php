<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        /* Estilo general */
        .sidebar {
            border-right: 1px solid #ddd; /* Línea de separación a la derecha de la barra lateral */
        }

        .sidebar .nav-item {
            position: relative; /* Para el posicionamiento de la línea */
        }

        .sidebar .nav-item:not(:last-child)::after {
            content: ""; /* Creando la línea */
            display: block;
            height: 1px; /* Altura de la línea */
            background-color: #ddd; /* Color de la línea */
            margin: 0.5rem 0; /* Espaciado de la línea */
        }

        .navbar-brand {
            margin: 0 auto; /* Centra el texto */
            text-align: center; /* Asegura que el texto esté centrado */
            width: 100%; /* Usa todo el ancho */
        }


        /* Asegura que los botones dentro de la barra lateral también estén estilizados */
        .sidebar .nav-link {
            color: #ffffff; /* Color del texto de los enlaces */
            background-color: #212650; /* Color de fondo de los enlaces */
            border: 1px solid #212650; /* Borde para los enlaces */
            padding: 10px; /* Espaciado interno de los enlaces */
            border-radius: 4px; /* Bordes redondeados */
            transition: background-color 0.3s, border-color 0.3s; /* Transición suave */
        }

        .sidebar .nav-link:hover {
            background-color: #AB8A3F; /* Color de fondo del enlace al pasar el ratón */
            border-color: #AB8A3F; /* Color del borde del enlace al pasar el ratón */
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse; /* Colapsar bordes de la tabla */
            width: 100%; /* Ancho completo de la tabla */
        }

        th, td {
            border: 1px solid #AB8A3F; /* Color del borde de la tabla */
            padding: 8px; /* Espaciado interno de las celdas */
            text-align: left; /* Alinear texto a la izquierda */
        }

        th {
            background-color: #f2f2f2; /* Color de fondo de las cabeceras de la tabla */
        }

    </style>

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ Auth::user()->hasRole('Fiscal General') ? url('dashboard') : url('home') }}">
                {{ __('Fiscalía de Zacatecas') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto"></ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Layout principal con barra lateral -->
    <div class="container-fluid">
        <div class="row">
            <!-- Mostrar la barra lateral solo si el usuario es Fiscal General -->
            @if(Auth::check())
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky">
                        <ul class="nav flex-column">
                            <!-- Opciones para Fiscal General -->
                            @if(Auth::user()->hasRole('Fiscal General'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">
                                        <span data-feather="users"></span>
                                        Lista de Usuarios
                                    </a>
                                </li>
                            @endif

                            <!-- Opciones disponibles para todos los fiscales -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reports.create') }}">
                                    <span data-feather="file-text"></span>
                                    Crear Reporte
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            @endif

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content') <!-- Aquí se cargará el contenido de las vistas correspondientes -->

                <!-- Pantalla de inicio en blanco si no se carga otra vista -->
                @if (!View::hasSection('content'))
                    <div class="blank-page">
                        <h2>Bienvenido al sistema</h2>
                        <p>Selecciona una opción en la barra lateral para comenzar.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>

</body>
</html>


