<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Delito</title>
    <style>
body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .section {

            font-family: var(--bs-body-font-family);
            font-size: var(--bs-body-font-size);
            color: #212529;
            margin-bottom: 15px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: inherit;

        }
        .table-no-border td {
            border: none;
        }
        header {
            padding: 10px;
            margin-bottom: 125px;
        }
        .header:after{
            content: "";
            display: table;
            clear: both;
        }
        .logo {
            position: absolute;
            max-width: 100%;
            max-height: 100%;
            cursor: grab;
            border: 1px dashed #aaa;
            background-color: rgba(255, 255, 255, 0.8);
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }
        /*Este es el apartado de las letras rojas*/
        .infHeader{
            left: -323px;
            text-align: center;
            margin-top: 115px;

        }
        .infHeader h1{
            font-family: "Gibson";
            display:inline-block;
            font-size: 1.15em;
            font-weight: bold;
            color: #4A001F;
            margin-top: 0;
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
            text-transform: uppercase;
            text-align: center;
            padding: 5px 0;
        }
        .infHeader div {
            font-size: 0.9em;
            color: #343a40;
            line-height: 1.2;
            margin-top: 2px
        }
        /*aqui termina */
        #project{
            color: #212529;
            display: inline-block;
            text-align: left;
            width: 70%;
            font-size: 1em;
            margin-top: 30px;
        }
        #project2{
            color:#212529;
            display: inline-block;
            text-align: left;
            width: 60%;
            font-size: 1em;
            margin-top: 20px;
        }
        #project span, #project2 span {
            font-weight: bold;
            color: #333;
        }

        #project div, #project2 div {
            margin-bottom: 5px;
        }
        /*aqui va lo de la tablita superior derecha*/
        .table-right{

            float: right;
            margin: 10px 0;
            padding: 10px;
            width: 300px;
            height: 20px;
            margin-right: -10px;
        }
        .table-right th,
        .table-right td {
            border: 1px solid #000;
            padding: 7px;
            text-align: left;
        }

        .table-right th {
            background-color: #f2f2f2;
        }
        .act{
            text-align: center;
            margin: auto;
        }
        .parrafo{
            border: 1px solid black;
            text-align: left;
            width: auto;
            height: auto;
        }
        .parrafo p{
            text-align: left;
        }

        #company {
        position: absolute;
        top: 80px;
        right: 20px;
        padding: 10px;
        }
        .sect1{
            border: 1px solid black;
        }
        .sect{
            border: 1px solid black;
        }
        .sect1, td{
            text-align: center;
        }
        #sect2, h3, p{
            text-align: center;
        }
        .sect3{

        }
        .sect3, h2{
            text-align: center;
        }
        .sect4{
            border: 1px solid black;
        }
        .sect5, td{
            text-align: left;
        }
    </style>

</head>
<body>
    <header class="clearfix">


        {{-- Encabezado --}}
        <div class="header">
            @foreach ($logos as $logo)
                @if ($logo->section == 'header')
                <div
                    class="logo"
                    style="top: {{ $logo->position_y ?? 0 }}px;
                                left: {{ $logo->position_x ?? 0 }}px;
                                width: {{ $logo->width ?? 50 }}px;
                                height: {{ $logo->height ?? 50 }}px;">
                    <img src="data:{{ $logo->mime_type }};base64,{{ base64_encode($logo->image_data) }}" alt="Logo">
                </div>
                @endif
            @endforeach
        </div>

        <div id="company" class="infHeader">
            <div>
                <h1>PROCURADURIA GENERAL DEL ESTADO FISCALIA DISTRITO ALTO
                </h1>
            </div>
        </div>

        <div>
            <table class="table-right">
                <thead>
                    <tr><th>Número de Expediente</th><td>{{ $expedient_number ?? 'Número no disponible' }}</td></tr>
                    <tr><th>Fecha y Hora de Registro</th><td>{{ $report_date ?? 'Fecha no disponible' }}</td></tr>
                    <tr><th>Categoría</th><td>{{ $category_name ?? 'Categoría no disponible' }}</td></tr>
                    <tr><th>Subcategoría</th><td>{{ $subcategory_name ?? 'Subcategoría no disponible' }}</td></tr>
                </thead>
            </table>
        </div>

    </header>

    <br><br><br><br><br>
    <h1 class="act">ACTA DE DENUNCIA</h1>
    <br>
    <div class="parrafo">
        <div class="parrafo">
            <table>
                <tr>
                    <p>Con fundamentos en el articulo 21 parráfo I de la ConstituciónPolitica de los Estados unidos Mexícanos; articulio 109 del codigó Nacional
                        de procedimientos penales.</p>
                </tr>
            </table>
        </div>
    </div>
    <br>


    <div class="sect1">
        <br>
        <div class="section-title">Sección: Datos del Fiscal</div>

        <table>
            <tr>
                <th>Nombre Completo</th>
                <td>{{ Auth::user()->name }} {{ Auth::user()->firstLastName }} {{ Auth::user()->secondLastName }}</td>
            </tr>
            <tr>
                <th>Correo Electrónico</th>
                <td>{{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <th>Puesto</th>
                <td>{{ Auth::user()->role ?? 'Puesto no disponible' }}</td>
            </tr>
        </table>
    </div>

    <div id="sect1" class="sect">
        <table>
            <h3>GENERALES DEL DENUNCIANTE O QUELLANTE</h3>
            <P>Se puede mantener en reserva, con fundamento en el articulo 16, párrafo 2 de La Constitución Politica de los Estados Unidos Mexicanos y
                109 del código de procedimientos penales.</P>
        </table>
    </div>

    <div>
        <table>
            <tr><th>Nombre Completo</th><td>{{ ($first_name ?? '') . ' ' . ($last_name ?? '') . ' ' . ($mother_last_name ?? '') ?: 'Nombre no disponible' }}</td></tr>
            <tr><th>Fecha de Nacimiento</th><td>{{ $birth_date ?? 'Fecha de nacimiento no disponible' }}</td></tr>
            <tr><th>Edad</th><td>{{ $age ?? 'Edad no disponible' }}</td></tr>
            <tr><th>Género</th><td>{{ $gender ?? 'Género no disponible' }}</td></tr>
            <tr><th>Escolaridad</th><td>{{ $education ?? 'Escolaridad no disponible' }}</td></tr>
            <!-- lugar de naciemiento -->
            <tr><th>Estado Civil</th><td>{{ $civil_status ?? 'Estado civil no disponible' }}</td></tr>
            <tr><th>CURP</th><td>{{ $curp ?? 'CURP no disponible' }}</td></tr>
            <tr><th>Teléfono</th><td>{{ $phone ?? 'Teléfono no disponible' }}</td></tr>
            <tr><th>Correo Electrónico</th><td>{{ $email ?? 'Correo no disponible' }}</td></tr>

            <!-- -->

            <tr><th>Estado</th><td>{{ $residence_state ?? 'Estado no disponible' }}</td></tr>
            <tr><th>Municipio</th><td>{{ $residence_municipality ?? 'Municipio no disponible' }}</td></tr>
            <tr><th>Localidad/Ciudad</th><td>{{ $residence_city ?? 'Localidad/Ciudad no disponible' }}</td></tr>
            <tr><th>Código Postal</th><td>{{ $residence_code_postal ?? 'Código Postal no disponible' }}</td></tr>
            <tr><th>Colonia</th><td>{{ $residence_colony ?? 'Colonia no disponible' }}</td></tr>
            <tr><th>Calle</th><td>{{ $street ?? 'Calle no disponible' }}</td></tr>
            <tr><th>No. Exterior</th><td>{{ $ext_number ?? 'Número no disponible' }}</td></tr>
            <tr><th>No. Interior</th><td>{{ $int_number ?? 'Número no disponible' }}</td></tr>
        </table>
    </div><br>

    <div id="sect1" class="sect">
        <table>
            <h3>LUGAR DE LOS HECHOS</h3>
        </table>
    </div>
    <!-- CAMPOS -->
    <div>
        <table>
            <tr><th>¿Cuándo sucedió el hecho?</th><td>{{ $incident_date_time ?? 'Fecha no disponible' }}</td></tr>
            <tr><th>Estado donde sucedió</th><td>{{ $incident_state ?? 'Estado no disponible' }}</td></tr>
            <tr><th>Municipio donde sucedió</th><td>{{ $incident_municipality ?? 'Municipio no disponible' }}</td></tr>
            <tr><th>Localidad/Ciudad</th><td>{{ $incident_city ?? 'Localidad/Ciudad no disponible' }}</td></tr>
            <tr><th>Código Postal donde sucedió</th><td>{{ $incident_code_postal ?? 'Código Postal no disponible' }}</td></tr>
            <tr><th>Colonia donde sucedió</th><td>{{ $incident_colony ?? 'Colonia no disponible' }}</td></tr>
            <tr><th>Calle donde sucedió</th><td>{{ $incident_street ?? 'Calle no disponible' }}</td></tr>
            <tr><th>No. Exterior donde sucedió</th><td>{{ $incident_ext_number ?? 'Número no disponible' }}</td></tr>
            <tr><th>No. Interior donde sucedió</th><td>{{ $incident_int_number ?? 'Número no disponible' }}</td></tr>
        </table>
    </div><br>

    <div id="sect1" class="sect">
        <table>
            <h3>RELATO DE LOS HECHOS</h3>
        </table>
    </div>
    <!-- CAMPOS -->
    <div>
        <table>
            <tr><th>¿Sufrió algún daño?</th><td>{{ $suffered_damage ?? 'No disponible' }}</td></tr>
                <tr><th>¿Hubo testigos?</th><td>{{ $has_witnesses ?? 'No disponible' }}</td></tr>

                @if(($has_witnesses ?? 'No') === 'Sí' && is_array($witnesses))
                    <tr><th>Número de testigos</th><td>{{ count($witnesses) }}</td></tr>
                @endif

                <tr><th>¿Llamó a un número de emergencia?</th><td>{{ $emergency_call ?? 'No disponible' }}</td></tr>

                @if(($emergency_call ?? 'No') === 'Sí')
                    <tr><th>Número de emergencia</th><td>{{ $emergency_number ?? 'Número no disponible' }}</td></tr>
                @endif
        </table>
    </div><br>

    <div class="sect3">
        <h2>NARRACIÓN CIRCUNSTANCIADA DEL HECHO REALIZADA POR EL DENUNCIANTE</h2>
    </div>

    <div class="sect4">
        <table>
            <td>
                <div style="font-size: 12px; white-space: pre-line; word-wrap: break-word; text-align: justify; color: #000;">
                    {{ $detailed_account ?? 'Relato no disponible' }}
                </div>
            </td>
        </table>
    </div>

    <!-- Anexo de Testigos en Nueva Página -->
    @if(is_array($witnesses) && count($witnesses) > 0)
    <div class="annex-title">Anexo de Testigos</div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Parentesco</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($witnesses as $index => $witness)
                <tr>
                    <td>{{ $index + 0 }}</td>
                    <td>{{ $witness['full_name'] ?? 'Nombre no disponible' }}</td>
                    <td>{{ $witness['phone'] ?? 'Teléfono no disponible' }}</td>
                    <td>{{ $witness['relationship'] ?? 'Parentesco no disponible' }}</td>
                    <td>{{ $witness['incident_description'] ?? 'Descripción no disponible' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
   @endif


    @if($vehicles && count($vehicles) > 0)
        <div class="annex-title">Anexo de Vehículo</div>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Marca</th>
                <th>Submarca</th>
                <th>Modelo</th>
                <th>Color</th>
                <th>Placa</th>
                <th>Número de Serie</th>
                <th>Aseguradora</th>
                <th>Señas Particulares</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vehicles as $index => $vehicle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $vehicle->marca ?? 'Marca no disponible' }}</td>
                    <td>{{ $vehicle->submarca ?? 'Submarca no disponible' }}</td>
                    <td>{{ $vehicle->modelo ?? 'Modelo no disponible' }}</td>
                    <td>{{ $vehicle->color ?? 'Color no disponible' }}</td>
                    <td>{{ $vehicle->placa ?? 'Placa no disponible' }}</td>
                    <td>{{ $vehicle->numeroSerie ?? 'Número de serie no disponible' }}</td>
                    <td>{{ $vehicle->aseguradora ?? 'Aseguradora no disponible' }}</td>
                    <td>{{ $vehicle->señasParticulares ?? 'Señas particulares no disponibles' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif





    {{-- Pie de página --}}
    <div class="footer">
        @foreach ($logos as $logo)
            @if ($logo->section == 'footer')
            <div
                class="logo"
                style="top: {{ $logo->position_y ?? 0 }}px;
                            left: {{ $logo->position_x ?? 0 }}px;
                            width: {{ $logo->width ?? 50 }}px;
                            height: {{ $logo->height ?? 50 }}px;">
                <img src="data:image/png;base64,{{ base64_encode($logo->image_data) }}" alt="Logo">
            </div>
            @endif
        @endforeach
    </div>
</body>
</html>






