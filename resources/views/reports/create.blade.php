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

        <style>
            label .required {
                color: red;
                margin-left: 2px;
            }
            .is-invalid {
                border-color: #dc3545;
                background-color: #f8d7da;
            }
            .is-invalid:focus {
                border-color: #dc3545;
                box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            }
            .error-message {
                color: #dc3545;
                font-size: 0.875em;
                margin-top: 5px;
            }
        </style>

        <form class="report-form" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data"> <!-- Formulario para registrar el reporte -->
            @csrf

            <!-- Página 1: Datos del Denunciante -->
            <div id="page1" class="form-page">
                <h2>Datos del Denunciante</h2>

                <!-- Campos de Datos del Denunciante -->
                <div class="form-group">
                    <label for="report_date">Fecha del Reporte: </label>
                    <input type="datetime-local" name="report_date" id="report_date" class="form-control" required value="{{ $currentDate }}" readonly> <!-- Campo de entrada  de solo lectura -->
                </div >

                <div class="form-group">
                    <label for="first_name">Nombre(s): <span class="required" style="color: red;">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                    <small id="error-first_name" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="last_name">Primer Apellido: <span class="required" style="color: red;">*</span> </label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required>
                    <small id="error-last_name" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="mother_last_name">Segundo Apellido: <span class="required" style="color: red;">*</span> </label>
                    <input type="text" id="mother_last_name" name="mother_last_name" class="form-control" required>
                    <small id="error-mother_last_name" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="birth_date">Fecha de Nacimiento:<span class="required" style="color: red;">*</span> </label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control" required onchange="validateBirthDateAndCalculateAge()">
                    <small id="birth_date_error" class="text-danger" style="display: none;">La fecha de nacimiento no puede ser en el futuro ni la fecha actual.</small>
                    <small id="error-birth_date" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="age">Edad:</label>
                    <input type="number" id="age" name="age" class="form-control" required readonly>
                </div>

                <div class="form-group">
                    <label for="gender">Género: <span class="required" style="color: red;">*</span> </label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="" disabled selected>Seleccione el género</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <small id="error-gender" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>


                <div class="form-group">
                    <label for="education">Escolaridad: <span class="required" style="color: red;">*</span> </label>
                    <select id="education" name="education" class="form-control" required>
                        <option value="" disabled selected>Seleccione la escolaridad</option>
                        <option value="Sin escolaridad">Sin escolaridad</option>
                        <option value="Primaria">Primaria</option>
                        <option value="Secundaria">Secundaria</option>
                        <option value="Bachillerato/Preparatoria">Bachillerato/Preparatoria</option>
                        <option value="Licenciatura">Licenciatura</option>
                        <option value="Maestría">Maestría</option>
                        <option value="Doctorado">Doctorado</option>
                    </select>
                    <small id="error-education" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="birth_place">Lugar de Nacimiento: <span class="required" style="color: red;">*</span> </label>
                    <div class="row">
                        <div class="col-md-6">
                            <select id="birth_state" class="form-control" required>
                                <option value="" disabled selected>Seleccione un estado</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select id="birth_municipality" name="birth_place" class="form-control" required>
                                <option value="" disabled selected>Seleccione un municipio</option>
                            </select>
                        </div>
                    </div>
                    <small id="error-birth_place" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="civil_status">Estado Civil: <span class="required" style="color: red;">*</span> </label>
                    <select id="civil_status" name="civil_status" class="form-control" required>
                        <option value="" disabled selected>Seleccione el estado civil</option>
                        <option value="soltero">Soltero</option>
                        <option value="casado">Casado</option>
                        <option value="divorciado">Divorciado</option>
                        <option value="viudo">Viudo</option>
                    </select>
                    <small id="error-civil_status" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="curp">CURP: <span class="required" style="color: red;">*</span> </label>
                    <input type="text" id="curp" name="curp" class="form-control" required>
                    <small id="error-curp" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono:<span class="required" style="color: red;">*</span> </label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                    <small id="error-phone" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="email">Correo:<span class="required" style="color: red;">*</span> </label>
                    <input type="email" id="email" name="email" class="form-control" required>
                    <small id="error-email" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <!-- Estado y Municipio del Denunciante -->
                <div class="form-group">
                    <label for="residence_state">Estado:<span class="required" style="color: red;">*</span> </label>
                    <select id="residence_state" name="residence_state_id" class="form-control" required>
                        <option value="" disabled selected>Seleccione un municipio</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    <small id="error-residence_state" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="residence_municipality">Municipio:<span class="required" style="color: red;">*</span> </label>
                    <select id="residence_municipality" name="residence_municipality_id" class="form-control" required>
                        <option value="">Seleccione un municipio</option>
                    </select>
                    <small id="error-residence_municipality" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="residence_city">Localidad/Ciudad:<span class="required" style="color: red;">*</span> </label>
                    <select id="residence_city" name="residence_city" class="form-control" required>
                        <option value="">Seleccione una localidad</option>
                    </select>
                    <small id="error-residence_city" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="residence_code_postal">Código Postal:<span class="required" style="color: red;">*</span> </label>
                    <select id="residence_code_postal" name="residence_code_postal" class="form-control" required>
                        <option value="">Seleccione un código postal</option>
                    </select>
                    <small id="error-residence_code_postal" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="residence_colony">Colonia:<span class="required" style="color: red;">*</span> </label>
                    <select id="residence_colony" name="residence_colony" class="form-control" required>
                        <option value="">Seleccione una colonia</option>
                    </select>
                    <small id="error-residence_colony" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="street">Calle:<span class="required" style="color: red;">*</span> </label>
                    <input type="text" id="street" name="street" class="form-control" required>
                    <small id="error-street" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>

                <div class="form-group">
                    <label for="ext_number">Número Exterior:</label>
                    <input type="text" id="ext_number" name="ext_number" class="form-control">
                </div>

                <div class="form-group">
                    <label for="int_number">Número Interior:</label>
                    <input type="text" id="int_number" name="int_number" class="form-control">
                </div>

                <button type="button" class="btn btn-primary" onclick="nextPage(2)">Siguiente</button>
            </div>

            <div id="page2" class="form-page" style="display: none; padding: 20px; flex-direction: column; gap: 20px;">
                <h2>¿Cuándo sucedió el hecho con apariencia de delito?</h2>

                <div class="form-group">
                    <label for="incident_date_time">Fecha y Hora: <span class="required" style="color: red;">*</span> </label>
                    <input type="datetime-local" id="incident_date_time" name="incident_date_time" class="form-control" required>
                </div>

                <h3>Datos del Domicilio donde sucedieron los hechos</h3>

                <div class="form-group">
                    <label for="incident_state">Estado: <span class="required" style="color: red;">*</span> </label>
                    <select id="incident_state" name="incident_state_id" class="form-control" required>
                        <option value="" disabled selected>Seleccione un municipio</option>
                    @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_municipality">Municipio: <span class="required" style="color: red;">*</span> </label>
                    <select id="incident_municipality" name="incident_municipality_id" class="form-control" required>
                        <option value="">Seleccione un municipio</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_city">Localidad/Ciudad:<span class="required" style="color: red;">*</span> </label>
                    <select id="incident_city" name="incident_city" class="form-control">
                        <option value="">Seleccione una localidad</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_code_postal">Código Postal: <span class="required" style="color: red;">*</span> </label>
                    <select id="incident_code_postal" name="incident_code_postal" class="form-control" required>
                        <option value="">Seleccione un código postal</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_colony">Colonia: <span class="required" style="color: red;">*</span> </label>
                    <select id="incident_colony" name="incident_colony" class="form-control" required>
                        <option value="">Seleccione una colonia</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_street">Calle: <span class="required" style="color: red;">*</span> </label>
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

            <div id="page3" class="form-page" style="display: none;">
                <h2>Relato de los Hechos</h2>

                <div class="form-group">
                    <label for="suffered_damage">¿Sufrió algún daño? <span class="required" style="color: red;">*</span> </label>
                    <select id="suffered_damage" name="suffered_damage" class="form-control" required>
                        <option value="" disabled selected>Seleccione una opción
                        <option value="No">No</option>
                        <option value="Sí">Sí</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="has_witnesses">¿Hubo testigos en el lugar? <span class="required" style="color: red;">*</span> </label>
                    <select id="witnessSelect" name="has_witnesses" class="form-control" onchange="toggleNumWitnessesContainer()" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="no">No</option>
                        <option value="yes">Sí</option>
                    </select>
                </div>

                <div class="form-group" id="numWitnessesContainer" style="display: none;">
                    <label for="numWitnesses">Número de testigos:</label>
                    <div class="input-group">
                        <input type="number" id="numWitnesses" name="numWitnesses" min="1" max="15" class="form-control" placeholder="Ingrese el número de testigos" onchange="generateWitnessForms(this.value)">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="openWitnessModal()">Agregar Testigos</button>
                        </div>
                    </div>
                </div>

                <!-- Modal de testigos -->
                <div id="witnessModal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Información de Testigos</h5>
                            </div>
                            <div class="modal-body" id="witnessFormContainer"></div>
                            <div class="modal-footer d-flex justify-content-between">
                                <!-- Botón de cerrar a la izquierda -->
                                <button type="button" class="btn btn-secondary" onclick="closeWitnessModal()">Cerrar ventana</button>
                                <!-- Botón de guardar a la derecha -->
                                <button type="button" class="btn btn-primary" onclick="saveWitnessData()">Guardar Testigos</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="emergency_call">¿Llamó a un número de emergencia? <span class="required" style="color: red;">*</span> </label>
                    <select id="emergency_call" name="emergency_call" class="form-control" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="No">No</option>
                        <option value="Sí">Si</option>
                    </select>
                </div>

                <div class="form-group" id="emergency_number_group" style="display: none;">
                    <label for="emergency_number">¿A qué número de emergencia llamó?:</label>
                    <select id="emergency_number" name="emergency_number" class="form-control" required>
                        <option value="" disabled selected>Seleccione un número</option>
                        <option value="911">911</option>
                        <option value="086">086</option>
                    </select>
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
                    <select name="subcategory_id" id="subcategory" class="form-control" required></select>
                </fieldset>

                <!-- Tabla para visualizar y editar los testigos registrados -->
                <div id="witnessTableContainer" style="display: none; margin-top: 20px;">
                    <h4>Testigos Registrados</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Parentesco</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="witnessTableBody"></tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevPage(2)">Anterior</button>
                <button type="button" class="btn btn-primary" onclick="nextPage(4)">Siguiente</button>
            </div>

            <div id="page4" class="form-page" style="display: none; height: 100vh; padding: 20px; flex-direction: column; gap: 20px;">
                <h2>Relato de los Hechos</h2>
                <div class="form-group" style="flex: 1; display: flex; flex-direction: column; height: 70%;">
                    <label for="detailed_account" style="margin-bottom: 10px;">Relate los hechos a detalle: <span class="required" style="color: red;">*</span> </label>
                    <textarea id="detailed_account" name="detailed_account"
                              class="form-control"
                              style="flex: 1; resize: none; padding: 10px; font-size: 16px;"
                              required></textarea>
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevPage(3)">Anterior</button>
                <button type="submit" class="btn btn-success">Guardar Reporte</button>
            </div>
        </form>
    </div>

    <script>
        function validateCurrentPage(page) {
            const currentPage = document.getElementById('page' + page);
            const inputs = currentPage.querySelectorAll('input, select, textarea');
            let isValid = true;

            inputs.forEach((input) => {
                const errorElement = document.getElementById('error-' + input.id);

                if (!input.checkValidity()) {
                    input.classList.add('is-invalid');
                    if (errorElement) errorElement.style.display = 'block';
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                    if (errorElement) errorElement.style.display = 'none';
                }
            });

            return isValid;
        }

        function nextPage(page) {
            const currentPageIndex = page - 1;

            if (validateCurrentPage(currentPageIndex)) {
                changePage(page);
            }
        }

        function previousPage(page) {
            changePage(page - 1);
        }

        function changePage(page) {
            document.querySelectorAll('.form-page').forEach((el) => el.style.display = 'none');
            document.getElementById('page' + page).style.display = 'block';
        }

    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#category').change(function() {
                var categoryId = $(this).val();

                $.ajax({
                    url: '/subcategories/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('#subcategory').empty();
                        $('#subcategory').append('<option value="">Seleccione una subcategoría</option>');
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
            var emergencyCallSelect = document.getElementById('emergency_call');
            var emergencyNumberGroup = document.getElementById('emergency_number_group');
            var emergencyNumberSelect = document.getElementById('emergency_number');

            function toggleEmergencyNumber() {
                if (emergencyCallSelect.value === 'Sí') {
                    emergencyNumberGroup.style.display = 'block';
                    emergencyNumberSelect.setAttribute('required', 'required');
                } else {
                    emergencyNumberGroup.style.display = 'none';
                    emergencyNumberSelect.removeAttribute('required');
                }
            }
            emergencyCallSelect.addEventListener('change', toggleEmergencyNumber);
            toggleEmergencyNumber();
        });
    </script>

    <script>
        function toggleNumWitnessesContainer() {
            const witnessSelect = document.getElementById('witnessSelect');
            const numWitnessesContainer = document.getElementById('numWitnessesContainer');
            const witnessTableContainer = document.getElementById('witnessTableContainer');

            if (witnessSelect.value === 'yes') {
                numWitnessesContainer.style.display = 'block';
                witnessTableContainer.style.display = 'block';
            } else {
                numWitnessesContainer.style.display = 'none';
                witnessTableContainer.style.display = 'none';
                clearWitnessForms();
            }
        }

        function generateWitnessForms(num) {
            const numWitnesses = parseInt(num) || 0;
            const witnessFormContainer = document.getElementById('witnessFormContainer');
            const witnessTableBody = document.getElementById('witnessTableBody');

            // Limpiar formularios y tabla
            witnessFormContainer.innerHTML = '';
            witnessTableBody.innerHTML = '';

            const relationshipOptions = [
                'Madre', 'Padre', 'Hermana', 'Hermano', 'Hermanastra', 'Hermanastro', 'Madrastra', 'Padrastro',
                'Media hermana', 'Medio hermano', 'Esposa', 'Esposo', 'Concubina', 'Concubino', 'Amasia', 'Amasio',
                'Hija', 'Hijo', 'Hija adoptiva', 'Hijo adoptivo', 'Hijastra', 'Hijastra', 'Hija de crianza', 'Hijo de crianza',
                'Abuela', 'Abuelo', 'Bisabuela', 'Bisabuelo', 'Tatarabuela', 'Tatarabuelo', 'Nieta', 'Nieto',
                'Bisnieta', 'Bisnieto', 'Tataranieta', 'Tataranieto', 'Tía', 'Tío', 'Sobrina', 'Sobrino', 'Prima',
                'Primo', 'Suegra', 'Suegro', 'Consuegra', 'Consuegro', 'Nuera', 'Nuero', 'Yerno', 'Cuñada', 'Cuñado',
                'Concuñada', 'Concuñado', 'Madrina', 'Padrino', 'Ahijada', 'Ahijado', 'Comadre', 'Compadre', 'Otro familiar',
                'Sin Parentesco', 'Tutora', 'Tutor', 'Tutelada', 'Tutelado', 'Trabajador domestico', 'Huesped'
            ];

            for (let i = 1; i <= numWitnesses; i++) {
                // Crear formulario emergente
                const witnessForm = `
            <div class="witness-form">
                <h5>Testigo ${i}</h5>
                <div class="form-group">
                    <label for="modal-witness-full_name-${i}">Nombre Completo:</label>
                    <input type="text" class="form-control" id="modal-witness-full_name-${i}" name="modal_witnesses[${i}][full_name]" required>
                </div>
                <div class="form-group">
                    <label for="modal-witness-phone-${i}">Número de Teléfono:</label>
                    <input type="text" class="form-control" id="modal-witness-phone-${i}" name="modal_witnesses[${i}][phone]" required>
                </div>
                <div class="form-group">
                    <label for="modal-witness-relationship-${i}">Parentesco:</label>
                    <select class="form-control" id="modal-witness-relationship-${i}" name="modal_witnesses[${i}][relationship]" required>
                        <option value="">Seleccione una opción...</option>
                        ${relationshipOptions.map(option => `<option value="${option}">${option}</option>`).join('')}
                    </select>
                </div>
                <div class="form-group">
                    <label for="modal-witness-incident_description-${i}">Descripción del Suceso:</label>
                    <textarea class="form-control" id="modal-witness-incident_description-${i}" name="modal_witnesses[${i}][incident_description]" rows="3"></textarea>
                </div>
            </div>
        `;
                witnessFormContainer.innerHTML += witnessForm;

                // Crear fila en la tabla
                const tableRow = `
            <tr id="witness-row-${i}">
                <td>${i}</td>
                <td><input type="hidden" name="witnesses[${i}][full_name]" value="" id="hidden-witness-full_name-${i}">
                    <span id="display-witness-full_name-${i}">-</span></td>
                <td><input type="hidden" name="witnesses[${i}][phone]" value="" id="hidden-witness-phone-${i}">
                    <span id="display-witness-phone-${i}">-</span></td>
                <td><input type="hidden" name="witnesses[${i}][relationship]" value="" id="hidden-witness-relationship-${i}">
                    <span id="display-witness-relationship-${i}">-</span></td>
                <td><textarea class="form-control" name="witnesses[${i}][incident_description]" id="hidden-witness-incident_description-${i}" style="display:none;"></textarea>
                    <span id="display-witness-incident_description-${i}">-</span></td>
                <td><button type="button" class="btn btn-primary btn-sm" onclick="editWitnessRow(${i})">Editar</button></td>
            </tr>
        `;
                witnessTableBody.innerHTML += tableRow;
            }

            // Mostrar el modal para ingresar datos
            openWitnessModal();
        }

        function saveWitnessData() {
            const witnessFormContainer = document.getElementById('witnessFormContainer');
            let isValid = true;

            // Validar que todos los campos necesarios estén llenos
            Array.from(witnessFormContainer.querySelectorAll('.witness-form')).forEach((form, index) => {
                const i = index + 1;
                const fullName = form.querySelector(`[name="modal_witnesses[${i}][full_name]"]`).value;
                const phone = form.querySelector(`[name="modal_witnesses[${i}][phone]"]`).value;
                const relationship = form.querySelector(`[name="modal_witnesses[${i}][relationship]"]`).value;
                const incidentDescription = form.querySelector(`[name="modal_witnesses[${i}][incident_description]"]`).value;

                // Verificar si algún campo está vacío
                if (!fullName || !phone || !relationship) {
                    isValid = false;
                }

                // Si todo es valido actualizar los valores en la tabla
                if (isValid) {
                    document.getElementById(`hidden-witness-full_name-${i}`).value = fullName;
                    document.getElementById(`hidden-witness-phone-${i}`).value = phone;
                    document.getElementById(`hidden-witness-relationship-${i}`).value = relationship;
                    document.getElementById(`hidden-witness-incident_description-${i}`).value = incidentDescription;

                    document.getElementById(`display-witness-full_name-${i}`).innerText = fullName || '-';
                    document.getElementById(`display-witness-phone-${i}`).innerText = phone || '-';
                    document.getElementById(`display-witness-relationship-${i}`).innerText = relationship || '-';
                    document.getElementById(`display-witness-incident_description-${i}`).innerText = incidentDescription || '-';
                }
            });

            if (!isValid) {
                alert("Por favor, complete todos los campos requeridos para cada testigo.");
            } else {
                // Cerrar el modal solo si los datos son válidos
                closeWitnessModal();
            }
        }

        function editWitnessRow(index) {
            // Editar datos en el modal
            openWitnessModal();
            const form = document.getElementById('witnessFormContainer');
            form.querySelector(`[name="modal_witnesses[${index}][full_name]"]`).value =
                document.getElementById(`hidden-witness-full_name-${index}`).value;
            form.querySelector(`[name="modal_witnesses[${index}][phone]"]`).value =
                document.getElementById(`hidden-witness-phone-${index}`).value;
            form.querySelector(`[name="modal_witnesses[${index}][relationship]"]`).value =
                document.getElementById(`hidden-witness-relationship-${index}`).value;
            form.querySelector(`[name="modal_witnesses[${index}][incident_description]"]`).value =
                document.getElementById(`hidden-witness-incident_description-${index}`).value;
        }

        function openWitnessModal() {
            const modal = document.getElementById('witnessModal');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';  // Para evitar que se pueda hacer scroll mientras el modal está abierto
        }

        function closeWitnessModal() {
            const modal = document.getElementById('witnessModal');
            modal.style.display = 'none';
            document.body.style.overflow = '';  // Restaurar el scroll cuando el modal se cierra
        }
    </script>

    <script>
        $(document).ready(function() {
            function loadMunicipalities(stateId, municipalitySelector) {
                $.ajax({
                    url: '/get-municipalities/' + stateId,
                    type: 'GET',
                    success: function(data) {
                        $(municipalitySelector).empty().append('<option value="">Seleccione un municipio</option>');
                        $.each(data, function(index, municipality) {
                            $(municipalitySelector).append('<option value="' + municipality.id + '">' + municipality.name + '</option>');
                        });
                    }
                });
            }

            function loadZipCodes(municipalityId, postalSelector, citySelector) {
                $.ajax({
                    url: '/get-zipcodes/' + municipalityId,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        $(postalSelector).empty().append('<option value="">Seleccione un código postal</option>');
                        $.each(data.zipCodes, function(index, zipCode) {
                            $(postalSelector).append('<option value="' + zipCode.zip_code + '">' + zipCode.zip_code + '</option>');
                        });
                        $(citySelector).empty().append('<option value="">Seleccione una localidad</option>');
                        if (data.cities.length > 0) {
                            $.each(data.cities, function(index, city) {
                                $(citySelector).append('<option value="' + city.name + '">' + city.name + '</option>');
                            });
                        } else {
                            $(citySelector).append('<option value="No hay">No hay localidades</option>');
                        }
                    }
                });
            }

            function loadColonies(zipCode, colonySelector) {
                $.ajax({
                    url: '/get-colonies/' + zipCode,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        $(colonySelector).empty().append('<option value="">Seleccione una colonia</option>');
                        if (data.settlements.length > 0) {
                            $.each(data.settlements, function(index, settlement) {
                                var settlementType = settlement.settlement_type ? settlement.settlement_type.type : 'Sin tipo';
                                var settlementDisplay = settlementType + ' - ' + settlement.name;
                                $(colonySelector).append('<option value="' + settlement.name + '">' + settlementDisplay + '</option>');
                            });
                        } else {
                            $(colonySelector).append('<option value="">No se encontraron colonias</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al cargar las colonias:", error);
                    }
                });
            }
            $('#residence_state').change(function() {
                var stateId = $(this).val();
                loadMunicipalities(stateId, '#residence_municipality');
            });
            $('#residence_municipality').change(function() {
                var municipalityId = $(this).val();
                loadZipCodes(municipalityId, '#residence_code_postal', '#residence_city');
            });
            $('#residence_code_postal').change(function() {
                var zipCode = $(this).val();
                loadColonies(zipCode, '#residence_colony');
            });
            $('#incident_state').change(function() {
                var stateId = $(this).val();
                loadMunicipalities(stateId, '#incident_municipality');
            });
            $('#incident_municipality').change(function() {
                var municipalityId = $(this).val();
                loadZipCodes(municipalityId, '#incident_code_postal', '#incident_city');
            });
            $('#incident_code_postal').change(function() {
                var zipCode = $(this).val();
                loadColonies(zipCode, '#incident_colony');
            });
        });
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const reportDateInput = document.getElementById('report_date');
            if (reportDateInput.value) {
                const localDate = new Date(reportDateInput.value);
                const offset = localDate.getTimezoneOffset();
                localDate.setMinutes(localDate.getMinutes() - offset);
                const formattedDate = localDate.toISOString().slice(0, 16);
                reportDateInput.value = formattedDate;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            function loadMunicipalities(stateId) {
                $.ajax({
                    url: '/get-municipalities/' + stateId,
                    type: 'GET',
                    success: function(data) {
                        $('#birth_municipality').empty().append('<option value="" disabled selected>Seleccione un municipio</option>');
                        $.each(data, function(index, municipality) {
                            $('#birth_municipality').append('<option value="' + municipality.id + '">' + municipality.name + '</option>');
                        });
                    }
                });
            }
            $('#birth_state').change(function() {
                const stateId = $(this).val();
                if (stateId) {
                    loadMunicipalities(stateId);
                } else {
                    $('#birth_municipality').empty().append('<option value="" disabled selected>Seleccione un municipio</option>');
                }
            });
        });
    </script>

    <script>
        function validateBirthDateAndCalculateAge() {
            const birthDate = document.getElementById('birth_date').value;
            const ageField = document.getElementById('age');
            const errorField = document.getElementById('birth_date_error');

            if (birthDate) {
                const birthDateObj = new Date(birthDate);
                const today = new Date();

                // Validar que la fecha de nacimiento no sea en el futuro ni la fecha actual
                if (birthDateObj >= today) {
                    errorField.style.display = 'block';
                    ageField.value = ''; // Limpiar el campo de edad si la fecha es inválida
                    return;
                } else {
                    errorField.style.display = 'none';
                }

                // Calcular la edad si la fecha es válida
                let age = today.getFullYear() - birthDateObj.getFullYear();
                const monthDifference = today.getMonth() - birthDateObj.getMonth();

                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDateObj.getDate())) {
                    age--;
                }

                ageField.value = age; // Asignar la edad al campo de edad
            }
        }
    </script>

@endsection


