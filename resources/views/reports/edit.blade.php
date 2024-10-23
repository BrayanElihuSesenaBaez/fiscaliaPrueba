@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Editar Reporte</h1>

    @if (session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <form action="{{ route('reports.update', $report->id) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset>
            <legend>Sección 1: Información General</legend>

            <label for="report_date">Fecha del Reporte</label>
            <input type="date" class="form-control" id="report_date" name="report_date" value="{{ old('report_date', $report->report_date) }}" required>

            <label for="expedient_number">Número de expediente:</label>
            <input type="text" class="form-control" name="expedient_number" id="expedient_number" value="{{ old('expedient_number', $report->expedient_number) }}" required>

            <h3>Datos de quien realiza la puesta a disposición</h3>
            <label for="last_name">Apellido Paterno:</label>
            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $report->last_name) }}" required>

            <label for="mother_last_name">Apellido Materno:</label>
            <input type="text" class="form-control" name="mother_last_name" id="mother_last_name" value="{{ old('mother_last_name', $report->mother_last_name) }}" required>

            <label for="first_name">Nombre(s):</label>
            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $report->first_name) }}" required>

            <div class="form-group">
                <label for="institution_id">Institución:</label>
                <select name="institution_id" id="institution_id" class="form-control" required>
                    <option value="" disabled>Selecciona una institución</option>
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}" {{ $institution->id == old('institution_id', $report->institution_id) ? 'selected' : '' }}>
                            {{ $institution->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <label for="rank">¿Cuál es su grado o rango?</label>
            <input type="text" class="form-control" name="rank" id="rank" value="{{ old('rank', $report->rank) }}" required>

            <label for="unit">¿En qué unidad arribó al lugar de la intervención?</label>
            <input type="text" class="form-control" name="unit" id="unit" value="{{ old('unit', $report->unit) }}" required>
        </fieldset>

        <!-- Sección 2: Categoría de delito -->
        <fieldset>
            <legend>Categoría de Delito</legend>

            <label for="category">Categoría:</label>
            <select name="category_id" id="category" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $report->category_id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <label for="subcategory">Subcategoría:</label>
            <select name="subcategory_id" id="subcategory" class="form-control" required>
                <!-- Las subcategorías se cargarán aquí mediante AJAX -->
            </select>

            <label for="description">Descripción:</label>
            <input type="text" class="form-control" name="description" id="description" value="{{ old('description', $report->description) }}" required>
        </fieldset>

        <button type="submit" class="btn btn-primary">Actualizar Reporte</button>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

    <!-- Script para manejar la carga de subcategorías mediante AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#category').change(function() {
                var categoryId = $(this).val();

                // Realizar una solicitud AJAX para obtener las subcategorías
                $.ajax({
                    url: '/subcategories/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('#subcategory').empty(); // Limpiar las subcategorías
                        $('#subcategory').append('<option value="">Seleccione una subcategoría</option>');
                        $.each(data, function(index, subcategory) {
                            $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection


