@extends('layouts.app')

@section('content')

    <div>
        <h1 class="mb-4">Editar Reporte</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Página 1: Datos del Denunciante -->

            <div id="page1" class="form-page">

                <h2>Datos del Denunciante</h2>

                <div class="form-group">
                    <label for="first_name">Nombre(s):</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $report->first_name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Apellido Paterno:</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $report->last_name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="mother_last_name">Apellido Materno:</label>
                    <input type="text" class="form-control" name="mother_last_name" id="mother_last_name" value="{{ old('mother_last_name', $report->mother_last_name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="birth_date">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ old('birth_date', $report->birth_date) }}" required>
                </div>

                <div class="form-group">
                    <label for="gender">Género:</label>
                    <select class="form-control" name="gender" id="gender" required>
                        <option value="Masculino" {{ $report->gender == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ $report->gender == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ $report->gender == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="education">Escolaridad:</label>
                    <select class="form-control" name="education" id="education" required>
                        <option value="Sin escolaridad" {{ $report->education =='Sin escolaridad' ? 'selected' : '' }}>Sin escolaridad</option>
                        <option value="Primaria" {{ $report->education =='Primaria' ? 'selected' : '' }}>Primaria</option>
                        <option value="Secundaria" {{ $report->education =='Secundaria' ? 'selected' : '' }}>Secundaria</option>
                        <option value="Bachillerato/Preparatoria" {{ $report->education =='Bachillerato/Preparatoria' ? 'selected' : '' }}>Bachillerato/Preparatoria</option>
                        <option value="Licenciatura" {{ $report->education =='Licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                        <option value="Maestría" {{ $report->education =='Maestría' ? 'selected' : '' }}>Maestría</option>
                        <option value="Doctorado" {{ $report->education =='Doctorado' ? 'selected' : '' }}>Doctorado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="birth_place">Lugar de Nacimiento:</label>
                    <input type="text" class="form-control" name="birth_place" id="birth_place" value="{{ old('birth_place', $report->birth_place) }}" required>
                </div>

                <div class="form-group">
                    <label for="age">Edad:</label>
                    <input type="number" class="form-control" name="age" id="age" value="{{ old('age', $report->age) }}" required>
                </div>

                <div class="form-group">
                    <label for="civil_status">Estado Civil:</label>
                    <select class="form-control" name="civil_status" id="civil_status" required>
                        <option value="Soltero" {{ $report->civil_status == 'Soltero' ? 'selected' : '' }}>Soltero</option>
                        <option value="Casado" {{ $report->civil_status == 'Casado' ? 'selected' : '' }}>Casado</option>
                        <option value="Divorciado" {{ $report->civil_status == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                        <option value="Viudo" {{ $report->civil_status == 'Viudo' ? 'selected' : '' }}>Viudo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="curp">CURP:</label>
                    <input type="text" class="form-control" name="curp" id="curp" value="{{ old('curp', $report->curp) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono:</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $report->phone) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo:</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $report->email) }}" required>
                </div>

                <button type="button" class="btn btn-primary" onclick="nextPage(2)">Siguiente</button>

            </div>

        <!-- Página 2: Datos de Domicilio -->

            <div id="page2" class="form-page" style="display: none;">
                <h2>¿Cuándo sucedió el hecho con apariencia de delito?</h2>

                <div class="form-group">
                    <label for="state">Estado:</label>
                    <input type="text" class="form-control" name="state" id="state" value="{{ old('state', $report->state) }}" required>
                </div>

                <div class="form-group">
                    <label for="municipality">Municipio:</label>
                    <input type="text" class="form-control" name="municipality" id="municipality" value="{{ old('municipality', $report->municipality) }}" required>
                </div>

                <div class="form-group">
                    <label for="colony">Colonia:</label>
                    <input type="text" class="form-control" name="colony" id="colony" value="{{ old('colony', $report->colony) }}" required>
                </div>

                <div class="form-group">
                    <label for="code_postal">Código Postal:</label>
                    <input type="text" class="form-control" name="code_postal" id="code_postal" value="{{ old('code_postal', $report->code_postal) }}" required>
                </div>

                <div class="form-group">
                    <label for="street">Calle:</label>
                    <input type="text" class="form-control" name="street" id="street" value="{{ old('street', $report->street) }}" required>
                </div>

                <div class="form-group">
                    <label for="ext_number">No. Exterior:</label>
                    <input type="text" class="form-control" name="ext_number" id="ext_number" value="{{ old('ext_number', $report->ext_number) }}" required>
                </div>

                <div class="form-group">
                    <label for="int_number">No. Interior:</label>
                    <input type="text" class="form-control" name="int_number" id="int_number" value="{{ old('int_number', $report->int_number) }}" >
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevPage(1)">Anterior</button>
                <button type="button" class="btn btn-primary" onclick="nextPage(3)">Siguiente</button>

            </div>

        <!-- Página 3: Datos del Hecho -->

            <div id="page2" class="form-page" style="display: none;">
                <h2>Datos del Hecho</h2>

                <div class="form-group">
                    <label for="incident_date_time">¿Cuándo sucedió el hecho con apariencia de delito? (Fecha y Hora):</label>
                    <input type="datetime-local" class="form-control" name="incident_date_time" id="incident_date_time" value="{{ old('incident_date_time', $report->incident_date_time) }}" required>
                </div>

                <div class="form-group">
                    <label for="incident_state">¿En que Estado sucedio el hecho con aparencia de delito?:</label>
                    <input type="text" class="form-control" name="incident_state" id="incident_state" value="{{ old('incident_state', $report->incident_state) }}" required>
                </div>

                <div class="form-group">
                    <label for="incident_municipality">¿En que Municipio sucedio el hecho con aparencia de delito?:</label>
                    <input type="text" class="form-control" name="incident_municipality" id="incident_municipality" value="{{ old('incident_municipality', $report->incident_municipality) }}" required>
                </div>

                <div class="form-group">
                    <label for="incident_colony">¿En que Colonia sucedio el hecho con aparencia de delito?:</label>
                    <input type="text" class="form-control" name="incident_colony" id="incident_colony" value="{{ old('incident_colony', $report->incident_municipality) }}" required>
                </div>

                <div class="form-group">
                    <label for="incident_code_postal">Código Postal cercano donde sucedieron los hechos:</label>
                    <input type="text" class="form-control" name="incident_code_postal" id="incident_code_postal" value="{{ old('incident_code_postal', $report->incident_code_postal) }}" required>
                </div>

                <div class="form-group">
                    <label for="incident_street">Calle donde sucedieron los hehcos con aparencia de delito:</label>
                    <input type="text" class="form-control"  name="incident_street" id="incident_street" value="{{ old('incident_street', $report->incident_street) }}" required>
                </div>

                <div class="form-group">
                    <label for="incident_ext_number">No. Exterior:</label>
                    <input type="text" class="form-control" name="incident_ext_number" id="incident_ext_number" value="{{ old('incident_ext_number', $report->incident_ext_number) }}" required>
                </div>

                <div class="form-group">
                    <label for="incident_int_number">No. Interior:</label>
                    <input type="text" class="form-control" name="incident_int_number" id="incident_int_number" value="{{ old('incident_int_number', $report->incident_int_number) }}" >
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevPage(1)">Anterior</button>
                <button type="button" class="btn btn-primary" onclick="nextPage(3)">Siguiente</button>


            </div>

            <!-- Página 3: Relato de los Hechos y Categoría de Delito -->

            <div id="page3" class="form-page" style="display: none;">
                <h2>Relato de los Hechos</h2>

                <div class="form-group">
                    <label for="suffered_damage">¿Sufrió algún daño?</label>
                    <select class="form-control" name="suffered_damage" id="suffered_damage" required>
                        <option value="No" {{ $report->suffered_damage == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Sí" {{ $report->suffered_damage == 'Sí' ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="witnesses">¿Hubo testigos en el lugar?</label>
                    <select class="form-control" name="witnesses" id="witnesses" required>
                        <option value="No" {{ $report->witnesses == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Sí" {{ $report->witnesses == 'Sí' ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="emergency_call">¿Llamó a un número de emergencia?</label>
                        <select id="emergency_call" name="emergency_call" class="form-control" required>
                            <option value="No" {{ $report->emergency_call == 'No' ? 'selected' : '' }}>No</option>
                            <option value="Sí" {{ $report->emergency_call == 'Sí' ? 'selected' : '' }}>Si</option>
                        </select>
                </div>

                <div class="form-group" id="emergency_number_group" style="display: none;">
                    <label for="emergency_number">Número de Emergencia (si llamó):</label>
                    <input type="text" class="form-control" name="emergency_number" id="emergency_number" value="{{ $report->emergency_number }}">
                </div>

                <div class="form-group">
                    <label for="detailed_account">Relato detallado de los hechos:</label>
                    <textarea class="form-control" name="detailed_account" id="detailed_account" rows="5" required>{{ old('detailed_account', $report->detailed_account) }}</textarea>
                </div>

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
                        <!-- Las subcategorías se cargarán mediante AJAX -->
                    </select>
                </fieldset>

                <!-- Botones para navegar entre páginas y enviar el formulario -->
                <button type="button" class="btn btn-secondary" onclick="prevPage(2)">Anterior</button>
                <button type="submit" class="btn btn-primary mt-3">Actualizar Reporte</button>

            </div>

    </form>

        <script>
            // Función para cambiar a la siguiente página del formulario
            function nextPage(page) {
                document.querySelectorAll('.form-page').forEach((el) => el.style.display = 'none');
                document.getElementById('page' + page).style.display = 'block';
            }

            // Función para volver a la página anterior del formulario
            function prevPage(page) {
                document.querySelectorAll('.form-page').forEach((el) => el.style.display = 'none');
                document.getElementById('page' + page).style.display = 'block';
            }
        </script>


        <!-- Script para manejar la carga de subcategorías mediante AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var categoryId = $('#category').val(); // Obtiene la categoría seleccionada al cargar
            var selectedSubcategoryId = {{ $report->subcategory_id ?? 'null' }}; // Obtiene la subcategoría seleccionada

            // Función para cargar las subcategorías
            function loadSubcategories(categoryId, selectedSubcategoryId = null) {
                $.ajax({
                    url: '/subcategories/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('#subcategory').empty(); // Limpia las subcategorías
                        $('#subcategory').append('<option value="">Seleccione una subcategoría</option>');
                        $.each(data, function(index, subcategory) {
                            $('#subcategory').append(
                                '<option value="' + subcategory.id + '"' +
                                (subcategory.id == selectedSubcategoryId ? ' selected' : '') +
                                '>' + subcategory.name + '</option>'
                            );
                        });
                    }
                });
            }

            // Carga las subcategorías al cambiar la categoría
            $('#category').change(function() {
                loadSubcategories($(this).val());
            });

            // Carga las subcategorías al cargar la página si ya hay una categoría seleccionada
            if (categoryId) {
                loadSubcategories(categoryId, selectedSubcategoryId);
            }
        });
    </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var emergencyCall = document.getElementById('emergency_call');
                var emergencyNumberGroup = document.getElementById('emergency_number_group');
                var emergencyNumberInput = document.getElementById('emergency_number');

                // Muestra u oculta el campo según la opción seleccionada
                function toggleEmergencyNumber() {
                    if (emergencyCall.value === 'Sí') {
                        emergencyNumberGroup.style.display = 'block';
                    } else {
                        emergencyNumberGroup.style.display = 'none';
                        emergencyNumberInput.value = ''; // Limpia el campo cuando se selecciona "No"
                    }
                }

                // Ejecuta la función cuando cambie la selección
                emergencyCall.addEventListener('change', toggleEmergencyNumber);

                // Ejecuta la función en la carga para reflejar el estado actual
                toggleEmergencyNumber();
            });
        </script>

@endsection


