@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1>Bienvenido, {{ Auth::user()->name }}!</h1>
            </main>
        </div>
    </div>
@endsection

