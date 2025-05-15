@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Configuración de Colores</h1>

        <!-- Mostrar mensaje de éxito si se actualizó -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="background_color" class="form-label">Color de Fondo</label>
                    <input type="color" name="background_color" id="background_color" value="{{ old('background_color', $settings->background_color) }}" class="form-control form-control-color">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="text_color" class="form-label">Color de Texto</label>
                    <input type="color" name="text_color" id="text_color" value="{{ old('text_color', $settings->text_color) }}" class="form-control form-control-color">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="button_color" class="form-label">Color de Botones</label>
                    <input type="color" name="button_color" id="button_color" value="{{ old('button_color', $settings->button_color) }}" class="form-control form-control-color">
                </div>
{{--                <a style="color: red">aun esta por verse estos colores</a>--}}
{{--                <div class="col-md-6 mb-3">--}}
{{--                    <label for="btn_primary" class="form-label">Color </label>--}}
{{--                    <input type="color" name="btn_primary" id="btn_primary" value="{{ old('btn_primary', $settings->btn_primary) }}" class="form-control form-control-color">--}}
{{--                </div>--}}
            </div>

{{--            <div class="row">--}}
{{--                <div class="col-md-6 mb-3">--}}
{{--                    <label for="login_button_color" class="form-label">Color</label>--}}
{{--                    <input type="color" name="login_button_color" id="login_button_color" value="{{ old('login_button_color', $settings->login_button_color) }}" class="form-control form-control-color">--}}
{{--                </div>--}}

{{--                <div class="col-md-6 mb-3">--}}
{{--                    <label for="login_text_color" class="form-label">Color de</label>--}}
{{--                    <input type="color" name="login_text_color" id="login_text_color" value="{{ old('login_text_color', $settings->login_text_color) }}" class="form-control form-control-color">--}}
{{--                </div>--}}
{{--            </div>--}}

            <button type="submit" class="btn btn-animated" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;">Guardar Cambios</button>
        </form>
    </div>
@endsection

