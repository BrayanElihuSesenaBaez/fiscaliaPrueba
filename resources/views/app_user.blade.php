<!-- Se crea una vista a la cual va ligada a la pagina principal "layouts.app.blade", dicho vista es la pagina que se les muestra a los roles --
        los cuales no tienen el rol de Fiscal General-->
@extends('layouts.app')

@section('content')
    <!-- Muestra un texto en la pagina de inicio saludando al usuario por si nombre -->
    <h2>Bienvenido, {{ Auth::user()->name }}</h2>

@endsection
