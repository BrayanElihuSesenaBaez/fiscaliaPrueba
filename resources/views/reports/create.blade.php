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
            #incidentDescriptionModal {
                position: absolute;
                top: 20px;
                left: 70%;
                z-index: 1050;
                overflow: visible;
            }
            #witnessModal {
                position: absolute;
                top: 20px;
                left: 20%;
                z-index: 1040;
                overflow: visible;
            }
            #incidentDescriptionTextarea {
                resize: both;
                overflow: auto;
            }
            body.modal-open {
                overflow: hidden;
            }
            .modal-content {
                overflow-y: auto;
                max-height: 80vh;
            }

        </style>

        <form class="report-form" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Página 1: Datos del Denunciante -->
            <div id="page1" class="form-page">
                <h2>Datos del Denunciante</h2>

                <!-- Campos de Datos del Denunciante -->
                <div class="form-group">
                    <label for="report_date">Fecha del Reporte: </label>
                    <input type="datetime-local" name="report_date" id="report_date" class="form-control" required value="{{ $currentDate }}" readonly>
                </div >
                <hr>

                <div class="form-group">
                    <label for="first_name">Nombre(s): <span class="required" style="color: red;">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control capitalize" required maxlength="50" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+"
                           placeholder="Ingrese su nombre(s)"
                           title="Solo se permiten letras y espacios (máximo 50 caracteres).">
                    <small id="error-first_name" class="error-message" style="display: none; color: red;">
                        Este campo debe contener solo letras y tener un máximo de 50 caracteres.
                    </small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="last_name">Primer Apellido: <span class="required" style="color: red;">*</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-control capitalize" required maxlength="50" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+"
                           placeholder="Ingrese su apellido paterno"
                           title="Solo se permiten letras y espacios (máximo 50 caracteres).">
                    <small id="error-last_name" class="error-message" style="display: none; color: red;">
                        Este campo debe contener solo letras y tener un máximo de 50 caracteres.
                    </small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="mother_last_name">Segundo Apellido: <span class="required" style="color: red;">*</span></label>
                    <input type="text" id="mother_last_name" name="mother_last_name" class="form-control capitalize" required maxlength="50" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+"
                           placeholder="Ingrese su apellido materno"
                           title="Solo se permiten letras y espacios (máximo 50 caracteres).">
                    <small id="error-mother_last_name" class="error-message" style="display: none; color: red;">
                        Este campo debe contener solo letras y tener un máximo de 50 caracteres.
                    </small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="birth_date">Fecha de Nacimiento: <span class="required" style="color: red;">*</span></label>
                    <input type="text" id="birth_date" name="birth_date" class="form-control" required placeholder="Selecciona tu fecha">
                    <small id="birth_date_error" class="error-message" style="display: none; color: red;">
                        La fecha de nacimiento no puede ser en el futuro.
                    </small>
                </div>

                <hr>
                <div class="form-group">
                    <label for="age">Edad:</label>
                    <input type="number" id="age" name="age" class="form-control" required readonly placeholder="Edad calculada al poner su fecha de nacimiento">
                </div>
                <hr>
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
                <hr>

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
                <hr>
                <!-- Campos de Lugar de Nacimiento -->

                <div class="form-group">
                    <label for="birth_option" class="form-label">Lugar de Nacimiento:</label>
                    <div class="btn-group w-100" role="group" aria-label="Lugar de nacimiento">
                        <input type="radio" class="btn-check" name="birth_option" id="birth_unknown" value="unknown" checked>
                        <label class="btn btn-outline-primary" for="birth_unknown">Desconocido</label>

                        <input type="radio" class="btn-check" name="birth_option" id="birth_specify" value="specify">
                        <label class="btn btn-outline-primary" for="birth_specify">Especificar</label>
                    </div>
                </div>
                <hr>
                <div id="birth_details" style="display: none;">
                    <div class="form-group mt-3">
                        <label for="birth_state" class="form-label">Estado:</label>
                        <select id="birth_state" class="form-select">
                            <option value="" disabled selected>Seleccione un estado</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <div class="form-group mt-3">
                        <label for="birth_municipality" class="form-label">Municipio:</label>
                        <select id="birth_municipality" name="birth_place" class="form-select" disabled>
                            <option value="" disabled selected>Seleccione un municipio</option>
                        </select>
                    </div>
                </div>

                <small id="error-birth_place" class="text-danger d-none">Este campo es obligatorio.</small>
                <!--  -->
                <hr>
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
                <hr>
                <div class="form-group">
                    <label for="curp">CURP: <span class="required" style="color: red;">*</span></label>
                    <input type="text" id="curp" name="curp" class="form-control" style="text-transform: uppercase;" required maxlength="18" placeholder="Ingresa tu CURP">
                    <small id="error-curp" class="error-message" style="display: none; color: red;">
                        El CURP ingresado no es válido. Debe tener 18 caracteres y seguir el formato correcto.
                    </small>
                </div>
                <hr>

                <div class="form-group">
                    <label for="phone">Teléfono: <span class="required" style="color: red;">*</span></label>
                    <input type="text" id="phone" name="phone" class="form-control" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                           placeholder="Ingresa tu número de 10 dígitos">
                    <small id="error-phone" class="error-message" style="display: none; color: red;">
                        El número debe tener exactamente 10 dígitos.
                    </small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="email">Correo: <span class="required" style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" required
                        placeholder="Ingresa tu correo electrónico">
                    <small id="error-email" class="error-message" style="display: none; color: red;">
                        Ingresa un correo electrónico válido.
                    </small>
                </div>
                <hr>

                <div class="section-title">
                    <h4 style="border-bottom: 2px solid #007bff; padding-bottom: 5px; color: #007bff; font-weight: bold;">
                        Información sobre el lugar de residencia
                    </h4>
                    <p>Complete los campos siguientes con los datos del lugar donde reside el denunciante.</p>
                </div>

                <div class="form-group">
                    <label for="residence_state">Estado de residencia: <span class="required" style="color: red;">*</span></label>
                    <select id="residence_state" name="residence_state_id" class="form-control" required>
                        <option value="" disabled selected>Seleccione un estado</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    <small id="error-residence_state" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="residence_municipality">Municipio de residencia: <span class="required" style="color: red;">*</span></label>
                    <select id="residence_municipality" name="residence_municipality_id" class="form-control" required>
                        <option value="">Seleccione un municipio</option>
                    </select>
                    <small id="error-residence_municipality" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>
                <hr>

                <div class="form-group">
                    <label for="residence_city">Localidad/Ciudad: <span class="required" style="color: red;">*</span></label>
                    <select id="residence_city" name="residence_city" class="form-control" required>
                        <option value="">Seleccione una localidad</option>
                    </select>
                    <small id="error-residence_city" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="residence_code_postal">Código Postal: <span class="required" style="color: red;">*</span></label>
                    <select id="residence_code_postal" name="residence_code_postal" class="form-control" required>
                        <option value="">Seleccione un código postal</option>
                    </select>
                    <small id="error-residence_code_postal" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="residence_colony">Colonia: <span class="required" style="color: red;">*</span></label>
                    <select id="residence_colony" name="residence_colony" class="form-control" required>
                        <option value="">Seleccione una colonia</option>
                    </select>
                    <small id="error-residence_colony" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="street">Calle:<span class="required" style="color: red;">*</span> </label>
                    <input type="text" id="street" name="street" class="form-control" required
                           placeholder="Escriba el nombre de la calle donde vive">
                    <small id="error-street" class="error-message" style="display: none;">Este campo es obligatorio.</small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="ext_number">Número Exterior:</label>
                    <input type="text" id="ext_number" name="ext_number" class="form-control"
                           placeholder="Escriba el número exterior de su domicilio (si aplica)">
                </div>
                <hr>
                <div class="form-group">
                    <label for="int_number">Número Interior:</label>
                    <input type="text" id="int_number" name="int_number" class="form-control"
                           placeholder="Escriba el número interior de su domicilio (si aplica)">
                </div>
                <hr>
                <button type="button" class="btn" onclick="nextPage(2)" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;">Siguiente</button>
            </div>

            <div id="page2" class="form-page" style="display: none; padding: 20px; flex-direction: column; gap: 20px;">
                <div class="section-title">
                    <h4 style="border-bottom: 2px solid #007bff; padding-bottom: 5px; color: #007bff; font-weight: bold;">
                        ¿Cuándo sucedió el hecho con apariencia de delito?
                    </h4>
                    <p>Complete los campos siguientes con los datos relacionados al incidente.</p>
                </div>

                <div class="form-group">
                    <label for="incident_date_time">Fecha y Hora: <span class="required" style="color: red;">*</span></label>
                    <input type="datetime-local" id="incident_date_time" name="incident_date_time" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="know_location">¿Recuerda o sabe el lugar exacto donde sucedió el hecho? <span class="required" style="color: red;">*</span></label>
                    <select id="know_location" name="know_location" class="form-control" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="yes">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div id="location-details" style="display: none;">
                    <div class="section-title">
                        <h4 style="border-bottom: 2px solid #007bff; padding-bottom: 5px; color: #007bff; font-weight: bold;">
                            Datos del Domicilio donde sucedieron los hechos
                        </h4>
                    </div>

                    <div class="form-group">
                        <label for="incident_state">Estado: <span class="required" style="color: red;">*</span></label>
                        <select id="incident_state" name="incident_state_id" class="form-control">
                            <option value="" disabled selected>Seleccione el estado donde ocurrió el hecho</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="incident_municipality">Municipio: <span class="required" style="color: red;">*</span> </label>
                        <select id="incident_municipality" name="incident_municipality_id" class="form-control">
                            <option value="">Seleccione el municipio donde ocurrió el hecho</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="incident_city">Localidad/Ciudad:<span class="required" style="color: red;">*</span> </label>
                        <select id="incident_city" name="incident_city" class="form-control">
                            <option value="">Seleccione la localidad o ciudad donde ocurrió el hecho</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="incident_code_postal">Código Postal: <span class="required" style="color: red;">*</span> </label>
                        <select id="incident_code_postal" name="incident_code_postal" class="form-control">
                            <option value="">Seleccione el código postal del lugar del hecho</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="incident_colony">Colonia: <span class="required" style="color: red;">*</span> </label>
                        <select id="incident_colony" name="incident_colony" class="form-control">
                            <option value="">Seleccione la colonia del lugar del hecho</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="incident_street">Calle: <span class="required" style="color: red;">*</span> </label>
                        <input type="text" id="incident_street" name="incident_street" class="form-control"
                               placeholder="Ingrese el nombre de la calle del lugar del hecho">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="incident_ext_number">No. Exterior:</label>
                        <input type="text" id="incident_ext_number" name="incident_ext_number" class="form-control"
                               placeholder="Ingrese el número exterior (opcional)">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="incident_int_number">No. Interior:</label>
                        <input type="text" id="incident_int_number" name="incident_int_number" class="form-control"
                               placeholder="Ingrese el número interior (opcional)">
                    </div>
                </div>

                <!--  -->
                <hr>
                <div class="form-group">
                    <label for="vehicle_related">¿El incidente está relacionado con su o un vehículo?</label>
                    <select id="vehicle_related" name="vehicle_related" class="form-control">
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="no">No</option>
                        <option value="yes">Sí</option>
                    </select>
                </div>

                <div id="vehicle-section" style="display: none;">
                    <div class="section-title">
                        <h4 style="border-bottom: 2px solid #007bff; padding-bottom: 5px; color: #007bff; font-weight: bold;">
                            Información del Vehículo
                        </h4>
                    </div>

                    <div class="section-title">
                        <h5 style="border-bottom: 1px solid #17a2b8; padding-bottom: 5px; color: #17a2b8; font-weight: bold;">
                            Información General del Vehículo
                        </h5>
                    </div>
                    <div class="form-group">
                        <label for="tipoUso">Tipo de Vehículo:</label>
                        <select id="tipoUso" name="tipoUso" class="form-control">
                            <option value="" disabled selected>Seleccione el tipo de vehículo</option>
                            <option value="particular">Vehículo Particular</option>
                            <option value="motocicleta">Motocicleta</option>
                            <option value="camion">Camión</option>
                            <option value="autobus">Autobús</option>
                            <option value="remolque">Remolque</option>
                            <option value="comercial">Vehículo Comercial</option>
                            <option value="emergencia">Vehículo de Emergencia</option>
                            <option value="agricola">Vehículo Agrícola</option>
                            <option value="recreativo">Vehículo Recreativo</option>
                            <option value="electrico">Vehículo Eléctrico</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="clase">Clase ??</label>
                        <input type="text" id="clase" name="clase" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" id="marca" name="marca" class="form-control" maxlength="50" pattern="^[A-Za-z0-9À-ÿ\s-]+$"
                               placeholder="Ingrese la marca del vehículo (Ejemplo: Toyota, Ford, Nissan, Volkswagen)"
                               title="La marca solo debe contener letras, números, espacios y/o guiones">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="submarca">Submarca</label>
                        <input type="text" id="submarca" name="submarca" class="form-control" maxlength="50" pattern="^[A-Za-z0-9\s\-]+$"
                               placeholder="Ingrese la submarca del vehículo (En caso de ser necesario)"
                               title="La submarca debe contener solo letras, números, espacios y guiones.">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input type="text" id="modelo" name="modelo" class="form-control" maxlength="50" pattern="^[A-Za-z0-9À-ÿ\s\-\.\']+$"
                               placeholder="Ingrese el modelo del vehículo (Ejemplo: Corolla, Civic, F-150)"
                               title="El modelo solo debe contener letras, números, espacios, guiones, puntos y apóstrofes.">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="text" id="color" name="color" class="form-control" maxlength="30" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+$"
                               placeholder="Ingrese el color del vehículo (Ejemplo: Rojo, Azul Marino, Negro Mate)"
                               title="El color debe contener solo letras, acentos, espacios y guiones.">
                    </div>
                    <hr>
                    <!--    -->
                    <div class="section-title">
                        <h5 style="border-bottom: 1px solid #17a2b8; padding-bottom: 5px; color: #17a2b8; font-weight: bold;">
                            Información sobre Placas
                        </h5>
                    </div>
                    <div class="form-group">
                        <label for="estadoPlaca">Estado de la Placa</label>
                        <select id="estadoPlaca" name="estadoPlaca" class="form-control" required>
                            <option value="" disabled selected>Seleccione un estado</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->name }}">{{ $state->name }}</option>
                            @endforeach
                            <option value="Placa Extranjera">Placa Extranjera</option>
                        </select>
                    </div>
                    <hr>
                    <div id="placaExtranjeraField" class="form-group" style="display: none;">
                        <label for="placaExtranjera">Placa Extranjera</label>
                        <input type="text" id="placaExtranjera" name="placaExtranjera" class="form-control"
                               placeholder="Ingrese la placa extranjera">
                        <small id="placaExtranjeraHelp" class="form-text text-muted">
                            Ingrese el número de placa completa del vehículo si tiene una placa extranjera.
                        </small>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="placaPermiso">Placa de Permiso</label>
                        <input type="text" id="placaPermiso" name="placaPermiso" class="form-control" maxlength="10" pattern="^[A-Za-z0-9\-]+$"
                               placeholder="Ingrese la placa de permiso (Ejemplo: ABC-1234)"
                               title="La placa de permiso debe contener solo letras, números y guiones, con una longitud máxima de 10 caracteres.">
                    </div>
                    <hr>

                    <!--    -->
                    <div class="section-title">
                        <h5 style="border-bottom: 1px solid #17a2b8; padding-bottom: 5px; color: #17a2b8; font-weight: bold;">
                            Identificación del Vehículo
                        </h5>
                    </div>
                    <div class="form-group">
                        <label for="numeroSerie">Número de Serie:</label>
                        <input type="text" id="numeroSerie" name="numeroSerie" class="form-control" maxlength="20" pattern="^[A-HJ-NPR-Z0-9]{11,20}$"
                               placeholder="Ingrese el número de serie del vehículo (Ejemplo: 1HGCM82633A123456)"
                               title="El número de serie debe contener entre 11 y 20 caracteres alfanuméricos y en mayúsculas.">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="numeroMotor">Número de Motor</label>
                        <input type="text" id="numeroMotor" name="numeroMotor" class="form-control" maxlength="20" pattern="^[A-Za-z0-9\s\-]+$"
                               placeholder="Ingrese el número de motor del vehículo"
                               title="El número de motor debe contener solo letras, números, espacios y guiones, con una longitud entre 10 y 20 caracteres.">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="NRPV">NRPV</label>
                        <input type="text" id="NRPV" name="NRPV" class="form-control" maxlength="20" pattern="^[A-Za-z0-9\-]+$"
                               placeholder="Ingrese el NRPV del vehículo (Ejemplo: ABC12345-6789)"
                               title="El NRPV debe contener solo letras, números y guiones, y tener una longitud máxima de 20 caracteres.">
                    </div>
                    <hr>

                    <!--    -->
                    <div class="section-title">
                        <h5 style="border-bottom: 1px solid #17a2b8; padding-bottom: 5px; color: #17a2b8; font-weight: bold;">
                            Origen del Vehículo
                        </h5>
                    </div>
                    <div class="form-group">
                        <label for="procedenciaVehiculo">Procedencia del Vehículo</label>
                        <input type="text" id="procedenciaVehiculo" name="procedenciaVehiculo" class="form-control" maxlength="50" pattern="^[A-Za-zÀ-ÿ\s\-]+$"
                               placeholder="Ingrese la procedencia del vehículo (Ejemplo: México, Estados Unidos)"
                               title="La procedencia del vehículo debe contener solo letras (incluyendo acentos y ñ), números, espacios y guiones.">
                    </div>

                    <hr>

                    <!--    -->
                    <div class="section-title">
                        <h5 style="border-bottom: 1px solid #17a2b8; padding-bottom: 5px; color: #17a2b8; font-weight: bold;">
                            Información Adicional
                        </h5>
                    </div>
                    <div class="form-group">
                        <label for="aseguradora">Aseguradora</label>
                        <input type="text" id="aseguradora" name="aseguradora" class="form-control" maxlength="100" pattern="^[A-Za-zÀ-ÿ\s\.]+$"
                               placeholder="Ingrese el nombre de la aseguradora (Ejemplo: AXA, MetLife, Grupo Nacional Provincial)"
                               title="El nombre de la aseguradora solo debe contener letras, espacios y puntos, con una longitud máxima de 100 caracteres.">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="señasParticulares">Señas Particulares</label>
                        <textarea id="señasParticulares" name="señasParticulares" class="form-control" maxlength="500"
                                  placeholder="Ingrese las señas particulares del vehículo (Ejemplo: rayón en el costado derecho, abolladura en el parachoques)"
                                  title="Las señas particulares pueden contener letras, números, espacios y signos de puntuación, con una longitud máxima de 500 caracteres."
                                  oninput="autoExpand(this)"></textarea>
                    </div>
                    <hr>
                </div>
                <hr>

                <div id="map" style="width:100%; height:300px; background-color: #eaeaea;">
                    <p>Mapa de ubicación</p>
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevPage(1)">Anterior</button>
                <button type="button" class="btn" onclick="nextPage(3)" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;">Siguiente</button>
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
                <hr>
                <div class="form-group">
                    <label for="has_witnesses">¿Hubo testigos en el lugar? <span class="required" style="color: red;">*</span> </label>
                    <select id="witnessSelect" name="has_witnesses" class="form-control" onchange="toggleNumWitnessesContainer()" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="no">No</option>
                        <option value="yes">Sí</option>
                    </select>
                </div>
                <hr>
                <div class="form-group" id="numWitnessesContainer" style="display: none;">
                    <label for="numWitnesses">Número de testigos:</label>
                    <div class="input-group">
                        <input type="number" id="numWitnesses" name="numWitnesses" min="1" max="15" class="form-control" placeholder="Ingrese el número de testigos" onchange="generateWitnessForms(this.value)">
                        <div class="input-group-append">
                            <button class="btn" type="button" onclick="openWitnessModal()" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;">Agregar Testigos</button>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Modal de testigos -->
                <div id="witnessModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
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
                                <button type="button" class="btn" onclick="saveWitnessData()" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;">Guardar Testigos</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para Descripción del Suceso -->
                <div id="incidentDescriptionModal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Descripción del Suceso</h5>
                            </div>
                            <div class="modal-body">
                                <textarea class="form-control" id="incidentDescriptionTextarea" rows="5" placeholder="Ingrese la descripción del suceso"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="closeIncidentDescriptionModal()">Cancelar</button>
                                <button type="button" class="btn" onclick="saveIncidentDescription()" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;">Guardar</button>
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
                    <hr>
                    <label for="subcategory">Subcategoría:</label>
                    <select name="subcategory_id" id="subcategory" class="form-control" required></select>
                </fieldset>
                <hr>

                <div id="witnessCardsContainer" style="display: none; margin-top: 20px;">
                    <h4>Testigos Registrados <button class="btn btn-secondary btn-sm" onclick="editWitnesses()">Editar Testigos</button></h4>
                    <div class="card-container" style="display: flex; flex-wrap: wrap; gap: 10px;">
                    </div>
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevPage(2)">Anterior</button>
                <button type="button" class="btn" onclick="nextPage(4)" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;">Siguiente</button>
            </div>

            <div id="page4" class="form-page" style="display: none; height: 100vh; padding: 20px; flex-direction: column; gap: 20px;">
                <h2>Relato de los Hechos</h2>
                <div class="form-group" style="flex: 1; display: flex; flex-direction: column; height: 70%;">
                    <label for="detailed_account" style="margin-bottom: 10px;">Relate los hechos a detalle: <span class="required" style="color: red;">*</span></label>
                    <textarea id="detailed_account" name="detailed_account"
                              class="form-control"
                              style="flex: 1; resize: none; padding: 10px; font-size: 16px; width: 100%; min-height: 100px;"
                              required></textarea>
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevPage(3)">Anterior</button>
                <button type="submit" class="btn" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;">Guardar Reporte</button>
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

            // Guarda los datos de la página actual en localStorage
            saveData(currentPageIndex);

            // Valida la página actual antes de avanzar
            if (validateCurrentPage(currentPageIndex)) {
                changePage(page);
            }
        }

        function prevPage(page) {
            // Guarda los datos de la página anterior en localStorage
            saveData(page);

            changePage(page); // Cambia a la página anterior
        }

        function changePage(page) {
            // Esconde todas las páginas y muestra solo la actual
            document.querySelectorAll('.form-page').forEach((el) => el.style.display = 'none');
            document.getElementById('page' + page).style.display = 'block';

            restoreData(page); // Restaura los datos al mostrar la página
        }

        function saveData(page) {
            const currentPage = document.getElementById('page' + page);
            const inputs = currentPage.querySelectorAll('input, select, textarea');

            inputs.forEach((input) => {
                localStorage.setItem(input.id, input.value);
            });
        }

        function restoreData(page) {
            const currentPage = document.getElementById('page' + page);
            const inputs = currentPage.querySelectorAll('input, select, textarea');

            inputs.forEach((input) => {
                const savedValue = localStorage.getItem(input.id);
                if (savedValue !== null) {
                    input.value = savedValue;
                }
            });
        }

        // Llama a restoreData cuando se muestra una página
        document.addEventListener('DOMContentLoaded', () => {
            const initialPage = 1; // Empieza en la página 1
            changePage(initialPage);
        });

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

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        let currentWitnessIndex = null;

        function toggleNumWitnessesContainer() {
            const witnessSelect = document.getElementById('witnessSelect');
            const numWitnessesContainer = document.getElementById('numWitnessesContainer');
            const witnessCardsContainer = document.getElementById('witnessCardsContainer');

            if (witnessSelect.value === 'yes') {
                numWitnessesContainer.style.display = 'block';
                witnessCardsContainer.style.display = 'block';
            } else {
                numWitnessesContainer.style.display = 'none';
                witnessCardsContainer.style.display = 'none';
                clearWitnessForms();
            }
        }

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

        function generateWitnessForms(num) {
            const numWitnesses = parseInt(num) || 0;
            const witnessFormContainer = document.getElementById('witnessFormContainer');
            const cardsContainer = document.querySelector('#witnessCardsContainer .card-container');

            witnessFormContainer.innerHTML = '';
            cardsContainer.innerHTML = '';

            for (let i = 1; i <= numWitnesses; i++) {
                const witnessForm = `
                <div class="witness-form" id="witness-form-${i}">
                    <h5>Testigo ${i}</h5>
                    <div class="form-group">
                        <label for="modal-witness-full_name-${i}">Nombre Completo:</label>
                        <input type="text" class="form-control" id="modal-witness-full_name-${i}" name="witnesses[${i}][full_name]" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-witness-phone-${i}">Número de Teléfono:</label>
                        <input type="text" class="form-control" id="modal-witness-phone-${i}" name="witnesses[${i}][phone]" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-witness-relationship-${i}">Parentesco:</label>
                        <select class="form-control" id="modal-witness-relationship-${i}" name="witnesses[${i}][relationship]" required>
                            <option value="">Seleccione una opción...</option>
                            ${relationshipOptions.map(option => `<option value="${option}">${option}</option>`).join('')}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Descripción del Suceso:</label>
                        <button type="button" class="btn btn-secondary" onclick="openIncidentDescriptionModal(${i})">
                            Llenar Descripción del Suceso
                        </button>
                        <input type="hidden" id="hidden-witness-incident_description-${i}" name="witnesses[${i}][incident_description]" value="">
                    </div>
                </div>
            `;
                witnessFormContainer.innerHTML += witnessForm;

                const card = `
                <div class="card" id="witness-card-${i}" style="border: 1px solid #ddd; padding: 10px; width: 200px;">
                    <h6>Testigo ${i}</h6>
                    <p><strong>Nombre:</strong> <span id="display-witness-full_name-${i}">-</span></p>
                    <p><strong>Teléfono:</strong> <span id="display-witness-phone-${i}">-</span></p>
                    <p><strong>Parentesco:</strong> <span id="display-witness-relationship-${i}">-</span></p>
                    <p><strong>Descripción:</strong>
                        <span id="display-witness-incident_description-${i}">
                            <em>Haga clic en "Editar Testigos" para ver más detalles.</em> <!-- ??? -->
                        </span>
                    </p>
                </div>
            `;
                cardsContainer.innerHTML += card; // <---
            }

            openWitnessModal();
        }

        function openIncidentDescriptionModal(index) {
            currentWitnessIndex = index;
            const descriptionField = document.getElementById(`hidden-witness-incident_description-${index}`);
            document.getElementById('incidentDescriptionTextarea').value = descriptionField ? descriptionField.value : '';
            document.getElementById('incidentDescriptionModal').style.display = 'block';
        }

        function closeIncidentDescriptionModal() {
            const modal = document.getElementById('incidentDescriptionModal');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }

        function saveIncidentDescription() {
            const description = document.getElementById('incidentDescriptionTextarea').value;
            const descriptionField = document.getElementById(`hidden-witness-incident_description-${currentWitnessIndex}`);
            descriptionField.value = description;
            document.getElementById(`display-witness-incident_description-${currentWitnessIndex}`).innerHTML =
                '<em>Haga clic en "Editar Testigos" para ver más detalles.</em>'; // <-----
            closeIncidentDescriptionModal();
        }

        function openWitnessModal() {
            const modal = document.getElementById('witnessModal');
            modal.style.display = 'block';
            document.body.classList.add('modal-open');
        }

        function closeWitnessModal() {
            const modal = document.getElementById('witnessModal');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }

        function saveWitnessData() {
            const witnessForms = document.querySelectorAll('.witness-form');
            witnessForms.forEach((form, index) => {
                const witnessIndex = index + 1;
                const fullNameField = form.querySelector(`#modal-witness-full_name-${witnessIndex}`);
                const phoneField = form.querySelector(`#modal-witness-phone-${witnessIndex}`);
                const relationshipField = form.querySelector(`#modal-witness-relationship-${witnessIndex}`);
                const descriptionField = form.querySelector(`#hidden-witness-incident_description-${witnessIndex}`);

                const fullName = fullNameField.value;
                const phone = phoneField.value;
                const relationship = relationshipField.value;
                const description = descriptionField.value;

                document.getElementById(`display-witness-full_name-${witnessIndex}`).innerText = fullName;
                document.getElementById(`display-witness-phone-${witnessIndex}`).innerText = phone;
                document.getElementById(`display-witness-relationship-${witnessIndex}`).innerText = relationship;
                document.getElementById(`display-witness-incident_description-${witnessIndex}`).innerHTML =description;
            });

            closeWitnessModal();
        }

        function editWitnesses() {
            const cardsContainer = document.querySelector('#witnessCardsContainer .card-container');
            const witnessForms = document.querySelectorAll('.witness-form');
            witnessForms.forEach((form, index) => {
                const witnessIndex = index + 1;
                const fullName = document.getElementById(`display-witness-full_name-${witnessIndex}`).innerText;
                const phone = document.getElementById(`display-witness-phone-${witnessIndex}`).innerText;
                const relationship = document.getElementById(`display-witness-relationship-${witnessIndex}`).innerText;
                const description = document.getElementById(`display-witness-incident_description-${witnessIndex}`).innerText;

                form.querySelector(`#modal-witness-full_name-${witnessIndex}`).value = fullName;
                form.querySelector(`#modal-witness-phone-${witnessIndex}`).value = phone;
                form.querySelector(`#modal-witness-relationship-${witnessIndex}`).value = relationship;
                form.querySelector(`#hidden-witness-incident_description-${witnessIndex}`).value = description;
            });

            openWitnessModal();
        }

        $(document).ready(function() {
            $('#incidentDescriptionModal').draggable();
            $('#witnessModal').draggable();
            document.getElementById('incidentDescriptionTextarea').addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
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
        $(document).ready(function () {
            function loadMunicipalities(stateId) {
                $.ajax({
                    url: '/get-municipalities/' + stateId,
                    type: 'GET',
                    success: function (data) {
                        $('#birth_municipality')
                            .empty()
                            .append('<option value="" disabled selected>Seleccione un municipio</option>');
                        $.each(data, function (index, municipality) {
                            $('#birth_municipality').append(
                                '<option value="' + municipality.id + '">' + municipality.name + '</option>'
                            );
                        });
                        $('#birth_municipality').removeAttr('disabled');
                    }
                });
            }

            $('input[name="birth_option"]').change(function () {
                if ($(this).val() === 'specify') {
                    $('#birth_details').slideDown();
                    $('#birth_state').attr('required', true);
                    $('#birth_municipality').attr('required', true);
                } else {
                    $('#birth_details').slideUp();
                    $('#birth_state').removeAttr('required');
                    $('#birth_municipality').removeAttr('required');
                    $('#birth_state').val('');
                    $('#birth_municipality').empty().append('<option value="" disabled selected>Seleccione un municipio</option>').attr('disabled', true);
                }
            });

            $('#birth_state').change(function () {
                const stateId = $(this).val();
                if (stateId) {
                    loadMunicipalities(stateId);
                } else {
                    $('#birth_municipality')
                        .empty()
                        .append('<option value="" disabled selected>Seleccione un municipio</option>')
                        .attr('disabled', true);
                }
            });
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            flatpickr('#birth_date', {
                dateFormat: 'Y-m-d',
                maxDate: 'today',
                yearSelectorType: 'dropdown',
                locale: 'es',
                onChange: function (selectedDates, dateStr, instance) {
                    validateBirthDateAndCalculateAge();
                }
            });
        });

        function validateBirthDateAndCalculateAge() {
            const birthDate = document.getElementById('birth_date').value;
            const ageField = document.getElementById('age');
            const errorField = document.getElementById('birth_date_error');

            if (birthDate) {
                const birthDateObj = new Date(birthDate);
                const today = new Date();

                if (birthDateObj >= today) {
                    errorField.style.display = 'block';
                    ageField.value = '';
                    return;
                } else {
                    errorField.style.display = 'none';
                }

                let age = today.getFullYear() - birthDateObj.getFullYear();
                const monthDifference = today.getMonth() - birthDateObj.getMonth();

                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDateObj.getDate())) {
                    age--;
                }

                ageField.value = age;
            }
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const knowLocationSelect = document.getElementById('know_location');
            const locationDetails = document.getElementById('location-details');

            knowLocationSelect.addEventListener('change', function () {
                if (this.value === 'yes') {
                    locationDetails.style.display = 'block';
                } else {
                    locationDetails.style.display = 'none';
                    // Opcional: limpiar los valores de los campos
                    const fields = locationDetails.querySelectorAll('input, select');
                    fields.forEach(field => field.value = '');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const vehicleRelatedSelect = document.getElementById('vehicle_related');
            const vehicleSection = document.getElementById('vehicle-section');
            const estadoPlacaSelect = document.getElementById('estadoPlaca');
            const placaExtranjeraField = document.getElementById('placaExtranjeraField');
            const placaExtranjeraInput = document.getElementById('placaExtranjera');
            const estadoPlacaHelp = document.getElementById('estadoPlacaHelp');
            const placaExtranjeraHelp = document.getElementById('placaExtranjeraHelp');

            // Mostrar u ocultar la sección del vehículo
            function toggleVehicleSection(value) {
                const fields = document.querySelectorAll('#vehicle-section input, #vehicle-section select');
                if (value === 'yes') {
                    vehicleSection.style.display = 'block';
                } else {
                    vehicleSection.style.display = 'none';
                    fields.forEach(field => field.value = ''); // Limpiar los valores si se oculta
                }
            }

            // Mostrar el campo de placa extranjera si es necesario
            function checkForeignPlate(value) {
                if (value === 'Placa Extranjera') {
                    placaExtranjeraField.style.display = 'block';
                    estadoPlacaHelp.textContent = "Si la placa es extranjera, ingrese el número de placa correspondiente.";
                } else {
                    placaExtranjeraField.style.display = 'none';
                    placaExtranjeraInput.value = ''; // Limpiar si no es extranjera
                    estadoPlacaHelp.textContent = "Seleccione el estado de la placa del vehículo.";
                }
            }

            vehicleRelatedSelect.addEventListener('change', function () {
                toggleVehicleSection(this.value);
            });

            estadoPlacaSelect.addEventListener('change', function () {
                checkForeignPlate(this.value);
            });

            toggleVehicleSection(vehicleRelatedSelect.value);
            checkForeignPlate(estadoPlacaSelect.value);
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function capitalizeWords(input) {
                return input
                    .split(' ')
                    .map(word =>
                        word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
                    )
                    .join(' ');
            }

            const fields = document.querySelectorAll('.capitalize');

            fields.forEach(field => {
                field.addEventListener('input', () => {
                    const cursorPosition = field.selectionStart;
                    field.value = capitalizeWords(field.value);
                    field.setSelectionRange(cursorPosition, cursorPosition);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const curpInput = document.getElementById('curp');
            const errorCurp = document.getElementById('error-curp');

            const curpRegex = /^[A-Z]{4}\d{6}[HM][A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}[A-Z\d]\d$/;

            curpInput.addEventListener('input', () => {
                curpInput.value = curpInput.value.toUpperCase();

                if (curpInput.value.length === 18 && curpRegex.test(curpInput.value)) {
                    errorCurp.style.display = 'none';
                    curpInput.setCustomValidity('');
                } else if (curpInput.value.length > 0) {
                    errorCurp.style.display = 'block';
                    curpInput.setCustomValidity('CURP inválido');
                } else {
                    errorCurp.style.display = 'none';
                    curpInput.setCustomValidity('');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const phoneInput = document.getElementById('phone');
            const errorPhone = document.getElementById('error-phone');

            phoneInput.addEventListener('input', () => {
                phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '');

                if (phoneInput.value.length === 10) {
                    errorPhone.style.display = 'none';
                    phoneInput.setCustomValidity('');
                } else if (phoneInput.value.length > 0) {
                    errorPhone.style.display = 'block';
                    phoneInput.setCustomValidity('El número debe tener exactamente 10 dígitos.');
                } else {
                    errorPhone.style.display = 'none';
                    phoneInput.setCustomValidity('');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const emailInput = document.getElementById('email');
            const errorEmail = document.getElementById('error-email');

            emailInput.addEventListener('input', () => {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailPattern.test(emailInput.value)) {
                    errorEmail.style.display = 'none';
                    emailInput.setCustomValidity('');
                } else if (emailInput.value.length > 0) {
                    errorEmail.style.display = 'block';
                    emailInput.setCustomValidity('Ingresa un correo electrónico válido.');
                } else {
                    errorEmail.style.display = 'none';
                    emailInput.setCustomValidity('');
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tipoUso = document.getElementById('tipoUso');
            const estadoPlacaSelect = document.getElementById('estadoPlaca');
            const numeroSerie = document.getElementById('numeroSerie');
            const placaExtranjeraField = document.getElementById('placaExtranjeraField');
            const estadoPlacaHelp = document.getElementById('estadoPlacaHelp');

            function ajustarValidacionNumeroSerie() {
                const tipoVehiculo = tipoUso.value;
                const estadoPlaca = estadoPlacaSelect.value;

                if (estadoPlaca === 'Placa Extranjera') {
                    numeroSerie.setAttribute('pattern', '^[A-Za-z0-9]{1,20}$');
                    numeroSerie.setAttribute('maxlength', '20');
                    numeroSerie.setAttribute('title', 'El número de serie debe contener entre 1 y 20 caracteres alfanuméricos.');
                } else {
                    switch (tipoVehiculo) {
                        case 'particular':
                        case 'camion':
                        case 'autobus':
                        case 'comercial':
                            numeroSerie.setAttribute('pattern', '^[A-HJ-NPR-Z0-9]{17}$');
                            numeroSerie.setAttribute('maxlength', '17');
                            numeroSerie.setAttribute('title', 'El número de serie debe contener exactamente 17 caracteres alfanuméricos (sin I, O, Q).');
                            break;
                        case 'motocicleta':
                            numeroSerie.setAttribute('pattern', '^[A-HJ-NPR-Z0-9]{11,17}$');
                            numeroSerie.setAttribute('maxlength', '17');
                            numeroSerie.setAttribute('title', 'El número de serie debe contener entre 11 y 17 caracteres alfanuméricos (sin I, O, Q).');
                            break;
                        case 'remolque':
                            numeroSerie.setAttribute('pattern', '^[A-HJ-NPR-Z0-9]{11,20}$');
                            numeroSerie.setAttribute('maxlength', '20');
                            numeroSerie.setAttribute('title', 'El número de serie debe contener entre 11 y 20 caracteres alfanuméricos (sin I, O, Q).');
                            break;
                        case 'emergencia':
                        case 'agricola':
                        case 'recreativo':
                        case 'electrico':
                            numeroSerie.setAttribute('pattern', '^[A-HJ-NPR-Z0-9]{11,20}$');
                            numeroSerie.setAttribute('maxlength', '20');
                            numeroSerie.setAttribute('title', 'El número de serie debe contener entre 11 y 20 caracteres alfanuméricos (sin I, O, Q).');
                            break;
                        default:
                            numeroSerie.setAttribute('pattern', '^[A-HJ-NPR-Z0-9]{11,20}$');
                            numeroSerie.setAttribute('maxlength', '20');
                            numeroSerie.setAttribute('title', 'El número de serie debe contener entre 11 y 20 caracteres alfanuméricos (sin I, O, Q).');
                            break;
                    }
                }
            }

            function checkForeignPlate(value) {
                if (value === 'Placa Extranjera') {
                    placaExtranjeraField.style.display = 'block';
                    estadoPlacaHelp.textContent = "Si la placa es extranjera, ingrese el número de placa correspondiente.";
                } else {
                    placaExtranjeraField.style.display = 'none';
                    document.getElementById('placaExtranjera').value = '';
                    estadoPlacaHelp.textContent = "Seleccione el estado de la placa del vehículo.";
                }
            }

            tipoUso.addEventListener('change', ajustarValidacionNumeroSerie);
            estadoPlacaSelect.addEventListener('change', function() {
                checkForeignPlate(this.value);
                ajustarValidacionNumeroSerie();
            });

            ajustarValidacionNumeroSerie();
            checkForeignPlate(estadoPlacaSelect.value);

            numeroSerie.addEventListener('input', function () {
                this.value = this.value.toUpperCase();
            });
        });
    </script>

    <script>
        function autoExpand(field) {
            field.style.height = 'auto';
            field.style.height = (field.scrollHeight) + 'px';
        }
    </script>
@endsection
