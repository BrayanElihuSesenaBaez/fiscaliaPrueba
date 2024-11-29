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
                    <input type="datetime-local" name="report_date" id="report_date" class="form-control" required value="{{ $currentDate }}" readonly> <!-- Campo de entrada  de solo lectura -->
                </div >


                <div class="form-group">
                    <label for="first_name">Nombre(s):</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Primer Apellido:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="mother_last_name">Segundo Apellido:</label>
                    <input type="text" id="mother_last_name" name="mother_last_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="birth_date">Fecha de Nacimiento:</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="gender">Género:</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="" disabled selected>Seleccione el género</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="education">Escolaridad:</label>
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
                </div>

                <div class="form-group">
                    <label for="birth_place">Lugar de Nacimiento:</label>
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
                </div>


                <div class="form-group">
                    <label for="age">Edad:</label>
                    <input type="number" id="age" name="age" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="civil_status">Estado Civil:</label>
                    <select id="civil_status" name="civil_status" class="form-control" required>
                        <option value="" disabled selected>Seleccione el estado civil</option>
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

                <!-- Estado y Municipio del Denunciante -->
                <div class="form-group">
                    <label for="residence_state">Estado:</label>
                    <select id="residence_state" name="residence_state_id" class="form-control" required>
                        <option value="" disabled selected>Seleccione un municipio</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="residence_municipality">Municipio:</label>
                    <select id="residence_municipality" name="residence_municipality_id" class="form-control" required>
                        <option value="">Seleccione un municipio</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="residence_city">Localidad/Ciudad:</label>
                    <select id="residence_city" name="residence_city" class="form-control">
                        <option value="">Seleccione una localidad</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="residence_code_postal">Código Postal:</label>
                    <select id="residence_code_postal" name="residence_code_postal" class="form-control" required>
                        <option value="">Seleccione un código postal</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="residence_colony">Colonia:</label>
                    <select id="residence_colony" name="residence_colony" class="form-control" required>
                        <option value="">Seleccione una colonia</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="street">Calle:</label>
                    <input type="text" id="street" name="street" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ext_number">Número Exterior:</label>
                    <input type="text" id="ext_number" name="ext_number" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="int_number">Número Interior:</label>
                    <input type="text" id="int_number" name="int_number" class="form-control">
                </div>

                <button type="button" class="btn btn-primary" onclick="nextPage(2)">Siguiente</button>
            </div>

            <!-- Página 2: Datos del Domicilio del Hecho -->
            <div id="page2" class="form-page" style="display: none; padding: 20px; flex-direction: column; gap: 20px;">
                <h2>¿Cuándo sucedió el hecho con apariencia de delito?</h2>

                <div class="form-group">
                    <label for="incident_date_time">Fecha y Hora:</label>
                    <input type="datetime-local" id="incident_date_time" name="incident_date_time" class="form-control" required>
                </div>

                <h3>Datos del Domicilio donde sucedieron los hechos</h3>

                <!-- Estado y Municipio del Hecho -->
                <div class="form-group">
                    <label for="incident_state">Estado:</label>
                    <select id="incident_state" name="incident_state_id" class="form-control" required>
                        <option value="" disabled selected>Seleccione un municipio</option>
                    @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_municipality">Municipio:</label>
                    <select id="incident_municipality" name="incident_municipality_id" class="form-control" required>
                        <option value="">Seleccione un municipio</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_city">Localidad/Ciudad:</label>
                    <select id="incident_city" name="incident_city" class="form-control">
                        <option value="">Seleccione una localidad</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_code_postal">Código Postal:</label>
                    <select id="incident_code_postal" name="incident_code_postal" class="form-control" required>
                        <option value="">Seleccione un código postal</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="incident_colony">Colonia:</label>
                    <select id="incident_colony" name="incident_colony" class="form-control" required>
                        <option value="">Seleccione una colonia</option>
                    </select>
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
                        <option value="" disabled selected>Seleccione una opción
                        <option value="No">No</option>
                        <option value="Sí">Sí</option>
                    </select>
                </div>

                <!-- Se enlaza a un script los campos de Testigos, mostrando una ventana emergente de cuantos testigos hubo y se muestran los campos del script-->
                <div class="form-group">
                    <label for="has_witnesses">¿Hubo testigos en el lugar?</label>
                    <select id="witnessSelect" name="has_witnesses" class="form-control" onchange="toggleNumWitnessesContainer()" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="no">No</option>
                        <option value="yes">Sí</option>
                    </select>
                </div>

                <!-- Campo para ingresar el número de testigos -->
                <div class="form-group" id="numWitnessesContainer" style="display: none;">
                    <label for="numWitnesses">Número de testigos:</label>
                    <input type="number" id="numWitnesses" name="numWitnesses" min="1" max="15" class="form-control" placeholder="Ingrese el número de testigos" onchange="generateWitnessForms(this.value)">
                </div>

                <!-- Ventana emergente para los formularios de cada testigo -->
                <div id="witnessModal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Información de Testigos</h5>
                                <button type="button" class="close" onclick="closeWitnessModal()" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="witnessFormContainer">
                                <!-- Se muestran los fomrularios de los testigos dinamicamente -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="saveWitnessData()">Guardar Testigos</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="emergency_call">¿Llamó a un número de emergencia?</label>
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
                    <select name="subcategory_id" id="subcategory" class="form-control" required>
                        <!-- Las subcategorías se cargarán mediante AJAX -->
                    </select>

                </fieldset>

                <!-- Botones para navegar entre páginas y enviar el formulario -->
                <button type="button" class="btn btn-secondary" onclick="prevPage(2)">Anterior</button>
                <button type="button" class="btn btn-primary" onclick="nextPage(4)">Siguiente</button>
            </div>

            <div id="page4" class="form-page" style="display: none; height: 100vh; padding: 20px; flex-direction: column; gap: 20px;">
                <h2>Relato de los Hechos</h2>

                <!-- Área de texto que ocupa casi toda la página -->
                <div class="form-group" style="flex: 1; display: flex; flex-direction: column; height: 70%;">
                    <label for="detailed_account" style="margin-bottom: 10px;">Relate los hechos a detalle:</label>
                    <textarea id="detailed_account" name="detailed_account"
                              class="form-control"
                              style="flex: 1; resize: none; padding: 10px; font-size: 16px;"
                              required></textarea>
                </div>

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
            var emergencyCallSelect = document.getElementById('emergency_call');
            var emergencyNumberGroup = document.getElementById('emergency_number_group');
            var emergencyNumberSelect = document.getElementById('emergency_number');

            // Función para mostrar u ocultar el grupo de número de emergencia y modificar el atributo required
            function toggleEmergencyNumber() {
                if (emergencyCallSelect.value === 'Sí') {
                    emergencyNumberGroup.style.display = 'block';  // Muestra el grupo
                    emergencyNumberSelect.setAttribute('required', 'required');  // Hace que sea obligatorio
                } else {
                    emergencyNumberGroup.style.display = 'none';  // Oculta el grupo
                    emergencyNumberSelect.removeAttribute('required');  // Elimina la obligatoriedad
                }
            }

            // Detecta cambios en el select de emergencia
            emergencyCallSelect.addEventListener('change', toggleEmergencyNumber);

            // Llamada inicial para ajustar el estado del formulario al cargar
            toggleEmergencyNumber();
        });
    </script>

    <!-- Script -->
    <script>
        // Función para mostrar u ocultar el contenedor de número de testigos según la selección
        function toggleNumWitnessesContainer() {
            const witnessSelect = document.getElementById('witnessSelect');
            const numWitnessesContainer = document.getElementById('numWitnessesContainer');

            if (witnessSelect.value === 'yes') {
                numWitnessesContainer.style.display = 'block';
                // Agregar el event listener solo cuando el contenedor es visible
                addNumWitnessesListener();
            } else {
                numWitnessesContainer.style.display = 'none';
                document.getElementById('numWitnesses').value = ''; // Limpiar el valor si se elige "No"
                clearWitnessForms(); // Limpiar los formularios de testigos
            }
        }

        // Función para agregar el eventListener al campo numWitnesses
        function addNumWitnessesListener() {
            const numWitnesses = document.getElementById('numWitnesses');
            if (numWitnesses) {
                numWitnesses.addEventListener('input', function () {
                    generateWitnessForms(this.value); // Generar formularios de testigos cuando cambia el número
                });
            }
        }

        // Función para generar los formularios de cada testigo según el número especificado
        function generateWitnessForms(num) {
            const numWitnesses = parseInt(num) || 0;
            const witnessFormContainer = document.getElementById('witnessFormContainer');
            witnessFormContainer.innerHTML = ''; // Limpiar formularios anteriores

            for (let i = 1; i <= numWitnesses; i++) {
                const witnessForm = `
        <div class="witness-form">
            <h5>Testigo ${i}</h5>
            <div class="form-group">
                <label for="witnesses[${i}][full_name]">Nombre Completo:</label>
                <input type="text" class="form-control" id="witnesses[${i}][full_name]" name="witnesses[${i}][full_name]" required>
            </div>
            <div class="form-group">
                <label for="witnesses[${i}][phone]">Número de Teléfono:</label>
                <input type="text" class="form-control" id="witnesses[${i}][phone]" name="witnesses[${i}][phone]" required>
            </div>
            <div class="form-group">
                <label for="witnesses[${i}][relationship]">Parentesco con la víctima:</label>
                <input type="text" class="form-control" id="witnesses[${i}][relationship]" name="witnesses[${i}][relationship]" required>
            </div>
            <div class="form-group">
                <label for="witnesses[${i}][incident_description]">Descripción del Suceso:</label>
                <textarea class="form-control" id="witnesses[${i}][incident_description]" name="witnesses[${i}][incident_description]" rows="3"></textarea>
            </div>
        </div>
    `;
                witnessFormContainer.innerHTML += witnessForm;
            }
            openWitnessModal();
        }

        // Limpiar los formularios de testigos
        function clearWitnessForms() {
            document.getElementById('witnessFormContainer').innerHTML = '';
        }

        // Función para abrir la ventana emergente de testigos
        function openWitnessModal() {
            const witnessModal = document.getElementById('witnessModal');
            witnessModal.style.display = 'block';
        }

        // Función para cerrar la ventana emergente de testigos
        function closeWitnessModal() {
            const witnessModal = document.getElementById('witnessModal');
            witnessModal.style.display = 'none';
        }

        // Función para guardar los datos de testigos en el formulario
        function saveWitnessData() {
            const witnesses = [];

            document.querySelectorAll('.witness-form').forEach((form, index) => {
                const fullNameInput = form.querySelector(`input[name="witnesses[${index + 1}][full_name]"]`);
                const phoneInput = form.querySelector(`input[name="witnesses[${index + 1}][phone]"]`);
                const relationshipInput = form.querySelector(`input[name="witnesses[${index + 1}][relationship]"]`);
                const descriptionInput = form.querySelector(`textarea[name="witnesses[${index + 1}][description]"]`);

                if (fullNameInput && phoneInput && relationshipInput && descriptionInput) {
                    witnesses.push({
                        full_name: fullNameInput.value,
                        phone: phoneInput.value,
                        relationship: relationshipInput.value,
                        description: descriptionInput.value
                    });
                }
            });

            // Los datos de testigos se enviarán directamente con el formulario sin necesidad de un campo oculto
            closeWitnessModal(); // Cierra el modal después de guardar los datos
        }

        // Prevenir el envío de formulario o cualquier acción no deseada al presionar Enter en el modal
        document.getElementById('witnessModal').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });

        // Cargar la función de toggleNumWitnessesContainer al cargar la página
        document.addEventListener('DOMContentLoaded', function () {
            toggleNumWitnessesContainer(); // Llama a la función al cargar la página
        });
    </script>

    <!-- JavaScript para cargar municipios dinámicamente -->
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
                        console.log(data); // Verifica los datos recibidos
                        $(postalSelector).empty().append('<option value="">Seleccione un código postal</option>');

                        // Asegúrate de que 'data.zipCodes' contiene objetos con la propiedad 'zip_code'
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
                    url: '/get-colonies/' + zipCode, // Ruta para obtener colonias
                    type: 'GET',
                    success: function(data) {
                        console.log(data); // Verifica los datos recibidos
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
                var stateId = $(this).val(); // Este valor debe ser el ID correcto
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


    <!-- Se crea este script ya que los navegadores toman en automatico la hora UTC -->
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const reportDateInput = document.getElementById('report_date');

            // Se ajusta la fecha localmente
            if (reportDateInput.value) {
                const localDate = new Date(reportDateInput.value); // Convierte el valor del campo a objeto Date
                const offset = localDate.getTimezoneOffset(); // Se obtiene la diferencia en minutos con respecto a UTC

                // Se ajusta la hora en el campo para que se envie en la zona horaria local
                localDate.setMinutes(localDate.getMinutes() - offset);

                // Formateamos la fecha en el formato correcto para el campo datetime-local
                const formattedDate = localDate.toISOString().slice(0, 16); // Formato: "YYYY-MM-DDTHH:MM"

                // Asignamos la fecha ajustada al campo
                reportDateInput.value = formattedDate;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Función para cargar municipios
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

            // Cambiar municipios según el estado seleccionado
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


@endsection


