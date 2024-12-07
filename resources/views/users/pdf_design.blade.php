@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Gestión de Logotipos para el PDF</h1>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3 class="card-title">Subir Logotipo</h3>
                <form action="{{ route('pdfdesign.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="logo" class="form-label">Selecciona un archivo</label>
                        <div class="d-flex align-items-center">
                            <input type="file" name="logo" id="logo" accept="image/*" class="form-control me-3" onchange="previewLogo(event)" required>
                            <img id="logoPreview" style="width: 50px; display: none;" class="img-thumbnail">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload"></i> Subir Logo
                    </button>
                </form>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3 class="card-title">Logotipos Subidos</h3>
                <div class="row g-3">
                    @foreach ($logos as $logo)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="card text-center shadow-sm">
                                <img src="{{ route('pdf_design.showImage', $logo->id) }}" alt="{{ $logo->name }}" class="card-img-top logo-thumbnail">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate">{{ $logo->name }}</h5>
                                    <form action="{{ route('pdf_design.destroy', $logo->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title">Selecciona los Logos</h3>
                <form action="{{ route('pdfdesign.updateSelection') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h4>Encabezado</h4>
                            <div class="row g-3">
                                @foreach ($logos as $logo)
                                    <div class="col-6 col-sm-4">
                                        <div class="card text-center shadow-sm">
                                            <img src="{{ route('pdf_design.showImage', $logo->id) }}" alt="{{ $logo->name }}" class="card-img-top logo-thumbnail">
                                            <div class="card-body">
                                                <input type="checkbox" name="header_logos[]" value="{{ $logo->id }}" id="headerLogo{{ $logo->id }}">
                                                <label for="headerLogo{{ $logo->id }}">Seleccionar</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4>Pie de Página</h4>
                            <div class="row g-3">
                                @foreach ($logos as $logo)
                                    <div class="col-6 col-sm-4">
                                        <div class="card text-center shadow-sm">
                                            <img src="{{ route('pdf_design.showImage', $logo->id) }}" alt="{{ $logo->name }}" class="card-img-top logo-thumbnail">
                                            <div class="card-body">
                                                <input type="checkbox" name="footer_logos[]" value="{{ $logo->id }}" id="footerLogo{{ $logo->id }}">
                                                <label for="footerLogo{{ $logo->id }}">Seleccionar</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-save"></i> Guardar Selección
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewLogo(event) {
            const input = event.target;
            const preview = document.getElementById('logoPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <style>
        .logo-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: contain;
            background-color: #f8f9fa;
            margin: auto;
            border: 1px solid #eaeaea;
            padding: 5px;
        }
        .card {
            border-radius: 8px;
            overflow: hidden;
        }
        .card .card-body {
            padding: 10px;
        }
        .card-title {
            font-size: 0.9rem;
            font-weight: bold;
        }
        .btn i {
            margin-right: 5px;
        }
        .row.g-3 > div {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card.text-center {
            max-width: 150px;
            margin: auto;
        }
    </style>
@endsection














