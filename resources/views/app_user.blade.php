{{-- app_user.blade.php --}}
@extends('layouts.app')

@section('content')
    <h2>Bienvenido, {{ Auth::user()->name }}</h2>

    <p>Has iniciado sesión como {{ Auth::user()->roles->pluck('name')->implode(', ') }}.</p>
@endsection
