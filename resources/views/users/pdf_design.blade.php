@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestión de Logotipos para el PDF</h1>

        <!-- Formulario para subir logos -->
        <form action="{{ route('pdfdesign.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="logo" class="form-label">Subir Logotipo</label>
                <input type="file" name="logo" id="logo" accept="image/*" class="form-control" onchange="previewLogo(event)" required>
            </div>
            <div class="mb-3">
                <!-- Contenedor para previsualización -->
                <img id="logoPreview" style="max-width: 200px; display: none;" class="img-thumbnail">
            </div>
            <button type="submit" class="btn btn-primary">Subir Logo</button>
        </form>

            <h2>Logotipos Subidos</h2>
            <div class="row">
                @foreach ($logos as $logo)
                    <div class="col-md-4">
                        <img src="{{ route('pdf_design.showImage', $logo->id) }}" alt="{{ $logo->name }}" class="img-thumbnail">
                        <p>{{ $logo->name }}</p>
                        <form action="{{ route('pdf_design.destroy', $logo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                @endforeach

            </div>

    </div>

    <!-- Formulario para seleccionar logo para el encabezado y pie de página -->
    <h2>Selecciona los Logos para el Encabezado y Pie de Página</h2>

    <form action="{{ route('pdfdesign.updateSelection') }}" method="POST">
        @csrf
        <div class="row">
            @foreach ($logos as $logo)
                <div class="col-md-4">
                    <!-- Vista previa del logo -->
                    <img src="{{ route('pdf_design.showImage', $logo->id) }}" alt="{{ $logo->name }}" class="img-thumbnail">
                    <p>{{ $logo->name }}</p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="header_logos[]" value="{{ $logo->id }}" id="headerLogo{{ $logo->id }}">
                        <label class="form-check-label" for="headerLogo{{ $logo->id }}">
                            Incluir en encabezado
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="footer_logos[]" value="{{ $logo->id }}" id="footerLogo{{ $logo->id }}">
                        <label class="form-check-label" for="footerLogo{{ $logo->id }}">
                            Incluir en pie de página
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Guardar Selección</button>
    </form>


    <!-- Script para previsualizar el logo antes de subir -->
    <script>
        function previewLogo(event) {
            const input = event.target;
            const preview = document.getElementById('logoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection









