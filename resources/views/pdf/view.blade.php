<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte de Delito</title>

        <!-- Estilos CSS para el PDF -->
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
            }
            .table-no-border td {
                border: none;
            }
        </style>
    </head>


    <body>
        <div class="header">
            <h1>Reporte de Delito</h1>
        </div>
        <!-- Sección 1: Datos del Registro -->
        <div class="section">
            <div class="section-title">Sección 1: Datos del Registro</div>
            <table>
                <tr>
                    <th>Fecha y Hora de Registro</th>
                    <td>{{ $report_date }}</td>
                </tr>
                <tr>
                    <th>Número de Expediente</th>
                    <td>{{ $expedient_number }}</td>
                </tr>
            </table>
        </div>

        <!-- Sección 2: Datos de quien realiza la puesta a disposición -->
        <div class="section">
            <div class="section-title">Sección 2: Datos de quien realiza la puesta a disposición</div>
            <table>
                <tr>
                    <th>Nombre(s)</th>
                    <td>{{ $first_name }}</td>
                </tr>
                <tr>
                    <th>Apellido Paterno</th>
                    <td>{{ $last_name }}</td>
                </tr>
                <tr>
                    <th>Apellido Materno</th>
                    <td>{{ $mother_last_name }}</td>
                </tr>
                <tr>
                    <th>CURP</th>
                    <td>{{ $curp }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $phone }}</td>
                </tr>
                <tr>
                    <th>Correo Electrónico</th>
                    <td>{{ $email }}</td>
                </tr>
            </table>
        </div>

        <!-- Sección 3: Datos de Domicilio -->
        <div class="section">
            <div class="section-title">Sección 3: Datos de Domicilio</div>
            <table>
                <tr>
                    <th>Estado</th>
                    <td>{{ $state }}</td>
                </tr>
                <tr>
                    <th>Municipio</th>
                    <td>{{ $municipality }}</td>
                </tr>
                <tr>
                    <th>Colonia</th>
                    <td>{{ $colony }}</td>
                </tr>
                <tr>
                    <th>Código Postal</th>
                    <td>{{ $code_postal }}</td>
                </tr>
                <tr>
                    <th>Calle</th>
                    <td>{{ $street }}</td>
                </tr>
                <tr>
                    <th>No. Exterior</th>
                    <td>{{ $ext_number }}</td>
                </tr>
                <tr>
                    <th>No. Interior</th>
                    <td>{{ $int_number }}</td>
                </tr>
            </table>
        </div>

        <!-- Sección 4: Datos del Hecho -->
        <div class="section">
            <div class="section-title">Sección 4: Lugar de los Hechos</div>
            <table>
                <tr>
                    <th>¿Cuándo sucedió el hecho?</th>
                    <td>{{ $incident_date_time }}</td>
                </tr>
                <tr>
                    <th>Estado donde sucedió</th>
                    <td>{{ $incident_state }}</td>
                </tr>
                <tr>
                    <th>Municipio donde sucedió</th>
                    <td>{{ $incident_municipality }}</td>
                </tr>
                <tr>
                    <th>Colonia donde sucedió</th>
                    <td>{{ $incident_colony }}</td>
                </tr>
                <tr>
                    <th>Código Postal donde sucedió</th>
                    <td>{{ $incident_code_postal }}</td>
                </tr>
                <tr>
                    <th>Calle donde sucedió</th>
                    <td>{{ $incident_street }}</td>
                </tr>
                <tr>
                    <th>No. Exterior donde sucedió</th>
                    <td>{{ $incident_ext_number }}</td>
                </tr>
                <tr>
                    <th>No. Interior donde sucedió</th>
                    <td>{{ $incident_int_number }}</td>
                </tr>
            </table>
        </div>

        <!-- Sección 5: Relato de los Hechos -->
        <div class="section">
            <div class="section-title">Sección 5: Relato de los Hechos</div>
            <table>
                <tr>
                    <th>¿Sufrió algún daño?</th>
                    <td>{{ $suffered_damage }}</td>
                </tr>
                <tr>
                    <th>¿Hubo testigos?</th>
                    <td>{{ $witnesses }}</td>
                </tr>
                <tr>
                    <th>¿Llamó a un número de emergencia?</th>
                    <td>{{ $emergency_call }}</td>
                </tr>
                <tr>
                    <th>Número de emergencia</th>
                    <td>{{ $emergency_number }}</td>
                </tr>
                <tr>
                    <th>Relato detallado de los hechos</th>
                    <td>{{ $detailed_account }}</td>
                </tr>
            </table>
        </div>

        <!-- Sección 6: Categoría de Delito -->
        <div class="section">
            <div class="section-title">Sección 6: Categoría de Delito</div>
            <table>
                <tr>
                    <th>Categoría</th>
                    <td>{{ $category_name }}</td>
                </tr>
                <tr>
                    <th>Subcategoría</th>
                    <td>{{ $subcategory_name }}</td>
                </tr>
            </table>
        </div>
    </body>
</html>





