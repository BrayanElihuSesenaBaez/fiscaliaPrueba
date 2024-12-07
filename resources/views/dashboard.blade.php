<!-- Se crea una vista a la cual va ligada a la pagina principal "layouts.app.blade", dicho vista es la pagina que se les muestra --
        al usuario con rol de Fiscal General-->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <main class="col-md-9 col-lg-9">

            <div class="mb-3">
                <form action="{{ route('reports.search') }}" method="GET" class="w-100">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="Buscar por número de expediente o fecha (YYYY-MM-DD)">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>

            @if(isset($reports) && $reports->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Número de Expediente</th>
                        <th>Fecha del Reporte</th>
                        <th>Nombre de la victima</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->expedient_number }}</td>
                            <td>{{ $report->report_date }}</td>
                            <td>{{ $report->first_name }} {{ $report->last_name }} {{ $report->mother_last_name }}</td>
                            <td>
                                <a href="{{ route('reports.view', ['report' => $report->expedient_number]) }}" class="btn btn-sm btn-primary">Ver Reporte</a>
                                <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este reporte?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p>No se encontraron reportes.</p>
            @endif
        </main>
    </div>
</div>
@endsection





