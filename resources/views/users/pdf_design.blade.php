@extends('layouts.app')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <div class="container">
        <h1>Gestión de Logotipos para el PDF</h1>
        <form action="{{ route('pdf_design.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nombre del logotipo:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="logo">Seleccionar logotipo:</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Logotipo</button>
        </form>

        <h2>Logotipos actuales</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Logotipo</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logosDetails as $logo)
                <tr>
                    <td>{{ $logo->name }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $logo->file_path) }}" alt="{{ $logo->name }}" style="width: 100px;">
                        <img src="{{ Storage::url($logo->file_path) }}" alt="{{ $logo->name }}" style="width: 100px;">

                    </td>
                    <td>
                        <form action="{{ route('pdf_design.destroy', $logo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Selección de logotipos para encabezado -->
        <h2>Seleccionar logotipos para el encabezado</h2>
        <div style="display: flex; flex-wrap: wrap;">
            @foreach($logosDetails as $logo)
                <div style="margin: 10px; text-align: center;">
                    <img src="{{ Storage::url($logo->file_path) }}" alt="{{ $logo->name }}" style="width: 100px; height: auto; margin-bottom: 5px;">
                    <div>
                        <input
                            type="checkbox"
                            name="header_logos[]"
                            value="{{ $logo->file_path }}"
                            {{ in_array($logo->file_path, $selectedHeaderLogos) ? 'checked' : '' }}
                        >
                        {{ $logo->name }}
                    </div>
                </div>
            @endforeach
        </div>

        <h2>Seleccionar logotipos para el pie de página</h2>
        <div style="display: flex; flex-wrap: wrap;">
            @foreach($logosDetails as $logo)
                <div style="margin: 10px; text-align: center;">
                    <img src="{{ Storage::url($logo->file_path) }}" alt="{{ $logo->name }}" style="width: 100px; height: auto; margin-bottom: 5px;">
                    <div>
                        <input
                            type="checkbox"
                            name="footer_logos[]"
                            value="{{ $logo->file_path }}"
                            {{ in_array($logo->file_path, $selectedFooterLogos) ? 'checked' : '' }}
                        >
                        {{ $logo->name }}
                    </div>
                </div>
            @endforeach
        </div>


        <button type="submit" class="btn btn-primary">Guardar Selección</button>
        </form>

        <!-- Vista previa del diseño del PDF -->
        <h1>Vista Previa del Diseño del PDF</h1>

        <h3>Encabezado:</h3>
        <div style="display: flex; flex-wrap: wrap;">
            @foreach(session('selected_header_logos', []) as $logoPath)
                <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo" width="100" style="margin-bottom: 10px;">
            @endforeach

        </div>

        <h3>Pie de Página:</h3>
        <div style="display: flex; flex-wrap: wrap;">
            @foreach(session('selected_footer_logos', []) as $logoPath)
                <div style="margin: 10px;">
                    <img src="{{ Storage::url($logoPath) }}" alt="Logo" width="100" style="margin-bottom: 10px;">
                </div>
            @endforeach
        </div>

        <!-- Generar Vista Previa -->
        <form action="{{ route('pdf_design.generateDesignPreview') }}" method="POST">
            @csrf
            @foreach(session('selected_header_logos', []) as $logoPath)
                <input type="hidden" name="header_logos[]" value="{{ $logoPath }}">
            @endforeach
            @foreach(session('selected_footer_logos', []) as $logoPath)
                <input type="hidden" name="footer_logos[]" value="{{ $logoPath }}">
            @endforeach
            <button type="submit" class="btn btn-primary">Generar Vista Previa del PDF</button>
        </form>
    </div>
@endsection







