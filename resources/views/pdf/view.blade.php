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
                <td>{{ $expedient_number  }}</td>
            </tr>
        </table>
    </div>

    <!-- Sección 2: Datos de quien realiza la puesta a disposición -->

    <div class="section">
        <div class="section-title">Sección 2: Datos de quien realiza la puesta a disposición</div>
        <table>
            <tr>
                <th>Apellido Paterno</th>
                <td>{{ $last_name }}</td>
            </tr>
            <tr>
                <th>Apellido Materno</th>
                <td>{{ $mother_last_name }}</td>
            </tr>
            <tr>
                <th>Nombre(s)</th>
                <td>{{ $first_name }}</td>
            </tr>
            <tr>
                <th>Institución</th>
                <td>{{ $institution_name }}</td>
            </tr>
            <tr>
                <th>Grado o Rango</th>
                <td>{{ $rank }}</td>
            </tr>
            <tr>
                <th>Unidad de Intervención</th>
                <td>{{ $unit }}</td>
            </tr>
        </table>
    </div>

    <!-- Sección 3: Categoría de Delito -->

    <div class="section">
        <div class="section-title">Sección 3: Categoría de Delito</div>
        <table>
            <tr>
                <th>Categoría</th>
                <td>{{ $category->name  }}</td>
            </tr>
            <tr>
                <th>Subcategoría</th>
                <td>{{ $subcategory->name }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Sección 4: Descripcción de delito</div>
        <table>
            <th>Descripcción</th>
            <td> {{ $description }}</td>
        </table>
    </div>
</body>
</html>





