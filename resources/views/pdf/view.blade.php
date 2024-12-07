<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Delito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 612px;
            height: 792px;
            margin: 0;
            padding: 20px;
            flex-direction: column;
            align-items: center;
        }
        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        .logo {
            position: absolute;
            max-width: 100%;
            max-height: 100%;
            cursor: grab;
            border: 1px dashed #aaa;
            background-color: rgba(255, 255, 255, 0.8);
        }

        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50pt;
        }

    </style>

</head>
<body>
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

<div class="section">
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


<!-- Sección 1: Datos del Registro -->
    <div class="section">
        <div class="section-title">Sección 1: Datos del Registro</div>
        <table>
            <tr>
                <th>Fecha y Hora de Registro</th>
                <td>{{ $report_date ?? 'Fecha no disponible' }}</td>
            </tr>
            <tr>
                <th>Número de Expediente</th>
                <td>{{ $expedient_number ?? 'Número no disponible' }}</td>
            </tr>
        </table>
    </div>

    <!-- Sección 2: Datos de quien realiza la puesta a disposición -->
    <div class="section">
        <div class="section-title">Sección 2: Datos de quien realiza la puesta a disposicion</div>
        <table>
            <tr><th>Nombre(s)</th><td>{{ $first_name ?? 'Nombre no disponible' }}</td></tr>
            <tr><th>Apellido Paterno</th><td>{{ $last_name ?? 'Apellido no disponible' }}</td></tr>
            <tr><th>Apellido Materno</th><td>{{ $mother_last_name ?? 'Apellido no disponible' }}</td></tr>
            <tr><th>CURP</th><td>{{ $curp ?? 'CURP no disponible' }}</td></tr>
            <tr><th>Teléfono</th><td>{{ $phone ?? 'Teléfono no disponible' }}</td></tr>
            <tr><th>Correo Electrónico</th><td>{{ $email ?? 'Correo no disponible' }}</td></tr>
        </table>
    </div>

    <!-- Sección 3: Datos de Domicilio -->
    <div class="section">
        <div class="section-title">Sección 3: Datos de Domicilio</div>
        <table>
            <tr><th>Estado</th><td>{{ $residence_state ?? 'Estado no disponible' }}</td></tr>
            <tr><th>Municipio</th><td>{{ $residence_municipality ?? 'Municipio no disponible' }}</td></tr>
            <tr><th>Localidad/Ciudad</th><td>{{ $residence_city ?? 'Localidad/Ciudad no disponible' }}</td></tr>
            <tr><th>Código Postal</th><td>{{ $residence_code_postal ?? 'Código Postal no disponible' }}</td></tr>
            <tr><th>Colonia</th><td>{{ $residence_colony ?? 'Colonia no disponible' }}</td></tr>
            <tr><th>Calle</th><td>{{ $street ?? 'Calle no disponible' }}</td></tr>
            <tr><th>No. Exterior</th><td>{{ $ext_number ?? 'Número no disponible' }}</td></tr>
            <tr><th>No. Interior</th><td>{{ $int_number ?? 'Número no disponible' }}</td></tr>
        </table>
    </div>

    <!-- Sección 4: Lugar de los Hechos -->
    <div class="section">
        <div class="section-title">Sección 4: Lugar de los Hechos</div>
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
    </div>

    <!-- Sección 5: Relato de los Hechos -->
    <div class="section">
        <div class="section-title">Sección 5: Relato de los Hechos</div>
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
    </div>


    <!-- Sección 6: Categoría de Delito -->
    <div class="section">
        <div class="section-title">Sección 6: Categoría de Delito</div>
        <table>
            <tr><th>Categoría</th><td>{{ $category_name ?? 'Categoría no disponible' }}</td></tr>
            <tr><th>Subcategoría</th><td>{{ $subcategory_name ?? 'Subcategoría no disponible' }}</td></tr>
        </table>
    </div>

    <!-- Sección 7: Relato de los Hechos -->
    <div class="section">
        <div class="annex-title">Sección 7: Relato de los Hechos</div>
        <div style="font-size: 12px; white-space: pre-line; word-wrap: break-word; text-align: justify; color: #000;">
            {{ $detailed_account ?? 'Relato no disponible' }}
        </div>
    </div>

    <!-- Anexo de Testigos en Nueva Página -->
    @if(is_array($witnesses ?? []) && count($witnesses ?? []) > 0)
        <div class="annex-title">Anexo de Testigos</div>
        <ul>
            @foreach($witnesses ?? [] as $index => $witness)
                <li>
                    <strong>Testigo {{ $index + 0 }}:</strong><br>
                    Nombre: {{ $witness['full_name'] ?? 'Nombre no disponible' }}<br>
                    Teléfono: {{ $witness['phone'] ?? 'Teléfono no disponible' }}<br>
                    Parentesco: {{ $witness['relationship'] ?? 'Parentesco no disponible' }}<br>
                    Descripción: {{ $witness['incident_description'] ?? 'Descripción no disponible' }}<br><br>
                </li>
            @endforeach
        </ul>
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






