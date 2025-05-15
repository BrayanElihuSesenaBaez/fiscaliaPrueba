<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title> <!-- TITULO DE LA PAGINA -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Agregar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
            body {
            background-color: {{ $settings->background_color }};
            color: {{ $settings->text_color }};
        }
        /* Estilo general de la main page*/
        .sidebar {
            border-right: 1px solid #ddd; /* Línea de separación del ladp derecho de la barra lateral */
        }

        .sidebar .nav-item {
            position: relative; /* Posicionamiento de la línea */
        }

        .sidebar .nav-item:not(:last-child)::after {
            content: ""; /* Se crea una línea */
            display: block;
            height: 1px; /* Es la altura de la línea */
            background-color: #ddd; /* Se le asigna un color a la línea */
            margin: 0.5rem 0; /* Se le pone un espaciado a las líneas */
        }

        .navbar-brand {
            margin: 0 auto; /* Centra el texto */
            text-align: center; /* Asegura que el texto esté centrado */
            width: 100%; /* Usa el ancho */
        }

        /* Se les agrega diseño a los botones de la barra lateral */
        .sidebar .nav-link {
            color: #ffffff; /* Color del texto de los enlaces */
            background-color: #9B1B30; /* Color de fondo de los enlaces */
            border: 1px solid #9B1B30; /* Borde para los enlaces */
            padding: 10px; /* Espaciado interno de los enlaces */
            border-radius: 4px; /* Bordes redondeados */
            transition: background-color 0.3s, border-color 0.3s; /* Transición */
        }

        .sidebar .nav-link:hover {
            background-color: #9B1B30; /* Muestra un color de fondo del enlace al pasar el ratón */
            border-color: #9B1B30; /* Muestra un color del borde del enlace al pasar el ratón */
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse; /* Se colapsan bordes de la tabla */
            width: 100%; /* Se le da un ancho completo a la tabla */
        }

        th, td {
            border: 1px solid #2d2d29; /* Se le asigna un color del borde de la tabla */
            padding: 8px; /* Se le da un espaciado interno de las celdas */
            text-align: left; /* Alinear texto a la izquierda */
        }

        th {
            background-color: #f2f2f2; /* Color de fondo de la tabla */
        }
        .btn-custom {
            background-color: #9B1B30;
            border-color: #9B1B30;
            color: white;
        }
        .btn-custom:hover {
            background-color: #7A0E20;
            border-color: #7A0E20;
            color: #FFF;
        }

        .btn-custom {
            background-color: #9B1B30;
            border-color: #9B1B30;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #7e1224;
            border-color: #7e1224;
        }


        .input-custom {
            border-radius: 25px;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #9B1B30; /* Morado */
            transition: border-color 0.3s ease;
        }

        .input-custom:focus {
            border-color: #7e1224;
            outline: none;
        }


        .input-group-text {
            background-color: #9B1B30;
            color: white;
            border-radius: 25px 0 0 25px;
        }

        .btn-custom {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .btn-custom:hover {
            transform: scale(1.05);
        }

        .table-user-list {
            border: 0.1cm solid #f9f9f9;
        }

        .table-user-list th {
            background-color: #4d6160;
            color: white;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
        }
        .table thead {
            background-color: #4d6160;
            color: white;
        }
        .table th, .table td {
            padding: 12px 15px;
            text-align: center;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 13px;
            border-radius: 5px;
        }
        .table td, .table th {
            border-radius: 5px;
        }
        .table-user-list {
            opacity: 0;
            animation: fadeIn 0.8s forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 0;
                transform: translateY(20px);
            }
            100%{
                opacity: 1;
                transform: translateY(0);
            }
        }
        .page-content {
            animation: fadeIn 1s ease-out;
        }
        .table-animated {
            opacity: 0;
            animation: fadeIn 0.8s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        .nav-item{
            transition: transform 0.3s ease-in-out;
        }
        .nav-item:hover{
            transform: scale(1.05);
        }
        .btn-primary{
            transition: transform 0.3s ease-in-out;
        }
        .btn-primary:hover{
            transform: scale(1.05);
        }

        .btn-primary:focus, .btn-primary:active {
            background: #9B1B30 !important;
            border-color: #9B1B30 !important;
            box-shadow: none;
        }
        .btn-warning{
            background: ;
        }
        .btn-danger{
            background: ;
        }

        #sidebarMenu {
            top: 50px;
            left: -2px;
            height: 100vh;
            overflow-y: auto;
            z-index: 1040;
            border-right: 1px solid #ddd;
        }
        .mb3 .btn-primary{
            background-color: {{$settings->button_color}}
        }
        .mb-3 .input-group .btn{
            transition: transform 0.3s ease-in-out;
        }
        .mb-3 .input-group .btn:hover{
            transform: scale(1.05);
        }
        .btn-animated {
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }

        .btn-animated:hover {
            transform: scale(1.05);
        }
        /*-----------*/
        /* Estilo para los inputs de color */
        .form-control-color {
            padding: 0.1rem 0.1rem;
            font: 2rem;

            height: 70px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .form-control-color:focus {
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
        .logout-btn {
            position: relative;
            z-index: 1050;
        }
        .navbar {
            position: relative;
            z-index: 1040;
        }

        .navbar .logout-btn {
            z-index: 1051;
        }

        .input-group {
            position: relative;
            z-index: 1030;
        }
        .mb-3 {
            margin-top: 1.5rem;
        }


    </style>

</head>
    <body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand">
                    {{ 'Fiscalía General' }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown logout-btn">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" id="logout-link">
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

        <!-- Layout principal con una barra lateral izquierda-->
        <div class="container-fluid">
            <div class="row">
                @if(Auth::check())
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar position-fixed">
                        <div class="position-sticky">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ url('dashboard') }}" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white; transition: background-color 0.3s, border-color 0.3s;">
                                        <span data-feather="home"></span>
                                        Lista de Reportes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('reports.create') }}" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white; transition: background-color 0.3s, border-color 0.3s;">
                                        <span data-feather="file-plus"></span>
                                        Crear Reporte
                                    </a>
                                </li>
                                @if(Auth::user()->hasRole('Fiscal General'))
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{ route('users.index') }}" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white; transition: background-color 0.3s, border-color 0.3s;">
                                            <span data-feather="users"></span>
                                            Menú de Usuarios
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{ route('pdf_design.index') }}" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white; transition: background-color 0.3s, border-color 0.3s;">
                                            <span data-feather="image"></span>
                                            Gestión de Logotipos para el PDF
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{ route('color') }}" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white; transition: background-color 0.3s, border-color 0.3s;">
                                            <span data-feather="droplet"></span>
                                            Color de página
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                @endif

                <!-- Contenido principal -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')

                    <!-- Muestra la pantalla de inicio -->
                    @if (!View::hasSection('content'))
                        <div class="blank-page">
                            <h2>Bienvenido al sistema</h2>
                        </div>
                    @endif
                </main>

            </div>
        </div>
    </div>

    </body>


    <script src="https://unpkg.com/feather-icons"></script> <!-- Script para iconos Feather -->
    <script>
        feather.replace();
    </script>


    <script>
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault();  // Evita el comportamiento por defecto del enlace
            document.getElementById('logout-form').submit();  // Envía el formulario
        });
    </script>

</html>


