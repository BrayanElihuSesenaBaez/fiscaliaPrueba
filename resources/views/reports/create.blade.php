@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Registrar Reporte de Delito</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data"> <!-- Formulario para registrar el reporte -->
            @csrf

            <!-- Página 1: Datos del Denunciante -->
            <div id="page1" class="form-page">
                <h2>Datos del Denunciante</h2>

                <!-- Campos de Datos del Denunciante -->
                <div class="form-group">
                    <label for="report_date">Fecha del Reporte:</label>
                    <input type="datetime-local" name="report_date" id="report_date" class="form-control" required>
                </div >

                <div class="form-group">
                    <label for="first_name">Nombre(s):</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Apellido Paterno:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="mother_last_name">Apellido Materno:</label>
                    <input type="text" id="mother_last_name" name="mother_last_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="birth_date">Fecha de Nacimiento:</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="gender">Género:</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="education">Escolaridad:</label>
                    <select id="education" name="education" class="form-control" required>
                        <option value="Sin escolaridad">Sin escolaridad</option>
                        <option value="Primaria">Primaria</option>
                        <option value="Secundaria">Secundaria</option>
                        <option value="Bachillerato/Preparatoria">Bachillerato/Preparatoria</option>
                        <option value="Licenciatura">Licenciatura</option>
                        <option value="Maestría">Maestría</option>
                        <option value="Doctorado">Doctorado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="birth_place">Lugar de Nacimiento:</label>
                    <input type="text" id="birth_place" name="birth_place" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="age">Edad:</label>
                    <input type="number" id="age" name="age" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="civil_status">Estado Civil:</label>
                    <select id=civil_status" name="civil_status" class="form-control" required>
                        <option value="soltero">Soltero</option>
                        <option value="casado">Casado</option>
                        <option value="divorciado">Divorciado</option>
                        <option value="viudo">Viudo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="curp">CURP:</label>
                    <input type="text" id="curp" name="curp" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div>
                    <label for="state">Estado:</label>
                    <input type="text" id="state" name="state" class="form-control" required>
                </div>

                <div>
                    <label for="municipality">Municipio:</label>
                    <input type="text" id="municipality" name="municipality" class="form-control" required>
                </div>

                <div>
                    <label for="colony">Colonia:</label>
                    <input type="text" id="colony" name="colony" class="form-control" required>
                </div>

                <div>
                    <label for="code_postal">Código Postal:</label>
                    <input type="text" id="code_postal" name="code_postal" class="form-control" required>
                </div>

                <div>
                    <label for="street">Calle:</label>
                    <input type="text" id="street" name="street" class="form-control" required>
                </div>

                <div>
                    <label for="ext_number">Número Exterior:</label>
                    <input type="text" id="ext_number" name="ext_number" class="form-control" required>
                </div>

                <div>
                    <label for="int_number">Número Interior:</label>
                    <input type="text" id="int_number" name="int_number" class="form-control">
                </div>

                <button type="button" class="btn btn-primary" onclick="nextPage(2)">Siguiente</button>
            </div>

            <!-- Página 2: Datos del Domicilio del Hecho -->
            <div id="page2" class="form-page" style="display: none;">
                <h2>¿Cuándo sucedió el hecho con apariencia de delito?</h2>

                <div class="form-group">
                    <label for="incident_date_time">Fecha y Hora:</label>
                    <input type="datetime-local" id="incident_date_time" name="incident_date_time" class="form-control" required>
                </div>

                <h3>Datos del Domicilio donde sucedieron los hechos</h3>

                <div class="form-group">
                    <label for="incident_state">Estado:</label>
                    <input type="text" id="incident_state" name="incident_state" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="incident_municipality">Municipio:</label>
                    <input type="text" id="incident_municipality" name="incident_municipality" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="incident_colony">Colonia:</label>
                    <input type="text" id="incident_colony" name="incident_colony" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="incident_code_postal">Código Postal:</label>
                    <input type="text" id="incident_code_postal" name="incident_code_postal" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="incident_street">Calle:</label>
                    <input type="text" id="incident_street" name="incident_street" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="incident_ext_number">No. Exterior:</label>
                    <input type="text" id="incident_ext_number" name="incident_ext_number" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="incident_int_number">No. Interior:</label>
                    <input type="text" id="incident_int_number" name="incident_int_number" class="form-control">
                </div>

                <div id="map" style="width:100%; height:300px; background-color: #eaeaea;">
                    <p>Mapa de ubicación</p>
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevPage(1)">Anterior</button>
                <button type="button" class="btn btn-primary" onclick="nextPage(3)">Siguiente</button>
            </div>

            <!-- Página 3: Relato de los Hechos y Categoría de Delito -->
            <div id="page3" class="form-page" style="display: none;">
                <h2>Relato de los Hechos</h2>

                <div class="form-group">
                    <label for="suffered_damage">¿Sufrió algún daño?</label>
                    <select id="suffered_damage" name="suffered_damage" class="form-control" required>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="witnesses">¿Hubo testigos en el lugar?</label>
                    <select id="witnesses" name="witnesses" class="form-control" required>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="emergency_call">¿Llamó a un número de emergencia?</label>
                    <select id="emergency_call" name="emergency_call" class="form-control" required>
                        <option value="No">No</option>
                        <option value="Sí">Si</option>
                    </select>
                </div>

                <div class="form-group" id="emergency_number_group" style="display: none;">
                    <label for="emergency_number">Número de Emergencia (si llamó):</label>
                    <input type="text" class="form-control" name="emergency_number" id="emergency_number">
                </div>

                <div class="form-group">
                    <label for="detailed_account">Relate los hechos a detalle:</label>
                    <textarea id="detailed_account" name="detailed_account" class="form-control" required></textarea>
                </div>

                <fieldset>
                    <legend>Categoría de Delito</legend>

                    <label for="category">Categoría:</label>
                    <select name="category_id" id="category" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label for="subcategory">Subcategoría:</label>
                    <select name="subcategory_id" id="subcategory" class="form-control" required>
                        <!-- Las subcategorías se cargarán mediante AJAX -->
                    </select>

                </fieldset>


                <!-- Botones para navegar entre páginas y enviar el formulario -->
                <button type="button" class="btn btn-secondary" onclick="prevPage(2)">Anterior</button>
                <button type="submit" class="btn btn-success">Guardar Reporte</button>
            </div>
        </form>
    </div>

    <script>
        // Función para cambiar a la siguiente página del formulario
        function nextPage(page) {
            document.querySelectorAll('.form-page').forEach((el) => el.style.display = 'none');// Obtiene la página actual y oculta la pagina actual
            document.getElementById('page' + page).style.display = 'block';  // Muestra la siguiente página
        }

        // Función para volver a la página anterior del formulario
        function prevPage(page) {
            document.querySelectorAll('.form-page').forEach((el) => el.style.display = 'none');
            document.getElementById('page' + page).style.display = 'block'; // Muestra la página anterior
        }
    </script>


    <!-- Script para manejar la carga de subcategorías mediante AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#category').change(function() {// Cambia el ID de "category"
                var categoryId = $(this).val(); // Y obtiene la categoría seleccionada

                // Realizar una solicitud AJAX para obtener las subcategorías
                $.ajax({
                    url: '/subcategories/' + categoryId, // Obtiene las subcategorías
                    type: 'GET',
                    success: function(data) {
                        $('#subcategory').empty(); // Limpiar las subcategorías
                        $('#subcategory').append('<option value="">Seleccione una subcategoría</option>'); // Opción predeterminada
                        $.each(data, function(index, subcategory) {
                            $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                    }
                });
            });
        });

    </script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('emergency_call').addEventListener('change', function () { // Añade un listener para el cambio en el campo "emergency_call"
                var emergencyNumberGroup = document.getElementById('emergency_number_group'); // Obtiene el grupo de números de emergencia
                if (this.value === 'Sí') {
                    emergencyNumberGroup.style.display = 'block';// Muestra el grupo
                } else {
                    emergencyNumberGroup.style.display = 'none';// Oculta el grupo
                }
            });
        });
    </script>
@endsection


