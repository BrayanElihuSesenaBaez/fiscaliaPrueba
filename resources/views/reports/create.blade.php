<h1>Crear Reporte</h1>

@if (session('success'))
    <p>{{ session('success') }}</p> <!-- Mensaje de éxito al guardar el reporte -->
@endif

<form action="{{ route('reports.store') }}" method="POST">
    @csrf

    <fieldset>
        <legend>Sección 1: Información General</legend>

        <label for="report_date">Fecha del Reporte</label>
        <input type="date" class="form-control" id="report_date" name="report_date" required>

        <label for="expedient_number">Número de expediente:</label>
        <input type="text" name="expedient_number" id="expedient_number">

        <h3>Datos de quien realiza la puesta a disposición</h3>
        <label for="last_name">Apellido Paterno:</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="mother_last_name">Apellido Materno:</label>
        <input type="text" name="mother_last_name" id="mother_last_name" required>

        <label for="first_name">Nombre(s):</label>
        <input type="text" name="first_name" id="first_name" required>

        <div class="form-group">
            <label for="institution_id">Institución:</label>
            <select name="institution_id" id="institution_id" required>
                <option value="" disabled selected>Selecciona una institución</option>
                @foreach ($institutions as $institution)
                    <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                @endforeach
            </select>

        </div>

        <label for="rank">¿Cuál es su grado o rango?</label>
        <input type="text" name="rank" id="rank" required>

        <label for="unit">¿En qué unidad arribó al lugar de la intervención?</label>
        <input type="text" name="unit" id="unit" required>
    </fieldset>

    <!-- Sección 2: Categoría de delito -->
    <fieldset>
        <legend>Categoría de Delito</legend>

        <label for="category">Categoría:</label>
        <select name="category_id" id="category" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="subcategory">Subcategoría:</label>
        <select name="subcategory_id" id="subcategory" required>
            <!-- Las subcategorías se cargarán aquí mediante AJAX -->
        </select>

        <label for="description">Descripción:</label>
        <input type="text" name="description" id="description" required>
    </fieldset>

    <button type="submit">Guardar Reporte</button>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</form>

<!-- Enlace para generar el PDF después de guardar el reporte -->
@if (session('reportId')) <!-- Asegúrate de que el ID del reporte esté presente -->
<a href="{{ url('/reports/' . session('reportId') . '/pdf') }}" class="btn btn-primary">Generar PDF</a>
@endif

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

        // Script para manejar la visualización del campo para otra institución
        $('#institution_id').change(function() {
            if ($(this).val() === 'otra') {
                $('#other_institution').show(); // Mostrar campo para otra institución
            } else {
                $('#other_institution').hide(); // Ocultar campo si no es "Otra"
            }
        });
    });
</script>


