@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4">Lista de Reportes</h1>

        <form method="GET" action="{{ route('reports.index') }}"> <!-- Formulario para buscar reportes -->
            <div class="form-group">
                <input type="text" name="keyword" class="form-control" placeholder="Buscar por número de expediente, fecha o nombre de la víctima">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <!-- Tabla de reportes -->
        <table class="table table-hover mt-4"> <!-- Lista los reportes -->
            <thead>
            <tr>
                <th>Número de Expediente</th>
                <th>Fecha</th>
                <th>Nombre Completo</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->expedient_number }}</td>
                    <td>{{ $report->report_date }}</td>
                    <td>{{ $report->first_name }} {{ $report->last_name }} {{ $report->mother_last_name }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $report->pdf_path) }}" class="btn btn-sm btn-info" target="_blank">Ver PDF</a>
                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE') <!-- Especifica que la solicitud es de tipo DELETE -->
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este reporte?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

