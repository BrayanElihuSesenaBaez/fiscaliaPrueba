<!-- Se crea una vista a la cual va ligada a la pagina principal "layouts.app.blade", dicho vista es la pagina que se les muestra --
        al usuario con rol de Fiscal General-->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <main class="col-md-9 col-lg-9">

            <div class="mb-3">
                <form action="{{ route('reports.index') }}" method="GET" class="w-100">
                    <div class="input-group">
                        @if(Auth::user()->hasRole('Fiscal General'))
                            <input type="text" name="query" class="form-control" placeholder="Buscar por número de expediente, fecha (YYYY-MM-DD) o usuario">
                        @else
                            <input type="text" name="query" class="form-control" placeholder="Buscar por número de expediente o fecha (YYYY-MM-DD)">
                        @endif

                        <button class="btn" type="submit" style="background-color: {{ $settings->button_color }}; border-color: {{ $settings->button_color }}; color: white;" >
                            Buscar
                        </button>
                    </div>
                </form>

                @if(request('query'))
                    <div class="mt-2">
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Restablecer búsqueda</a>
                    </div>
                @endif
            </div>

            @if(isset($reports) && $reports->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Número de Expediente</th>
                        <th>Fecha del Reporte</th>
                        <th>Nombre de la victima</th>
                        @if(Auth::user()->hasRole('Fiscal General'))
                            <th>Creado por</th>
                        @endif
                        <th>Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->expedient_number }}</td>
                            <td>{{ $report->report_date }}</td>
                            <td>{{ $report->first_name }} {{ $report->last_name }} {{ $report->mother_last_name }}</td>
                            @if(Auth::user()->hasRole('Fiscal General'))
                                <td>
                                    @if($report->user)
                                        <a href="#" data-bs-toggle="tooltip" title="Creado por: {{ $report->user->name }} {{ $report->user->firstLastName }} {{ $report->user->secondLastName }}">
                                            <i class="fas fa-user"></i>
                                        </a>
                                    @else
                                        Desconocido
                                    @endif
                                </td>
                            @endif

                            <td>
                                <a href="{{ route('reports.view', ['report' => $report->expedient_number]) }}" class="btn btn-sm btn-success">Ver Reporte</a>
                                <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-warning">Editar</a>
{{--                                <!-- Solo mostrar el botón y el modal de eliminación si el usuario es Fiscal General -->--}}
{{--                                @if(Auth::user()->hasRole('Fiscal General'))--}}
{{--                                    <!-- Botón para activar el modal -->--}}
{{--                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $report->id }}">--}}
{{--                                        Eliminar--}}
{{--                                    </button>--}}

{{--                                    <!-- Modal -->--}}
{{--                                    <div class="modal fade" id="confirmDeleteModal-{{ $report->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">--}}
{{--                                        <div class="modal-dialog">--}}
{{--                                            <div class="modal-content">--}}
{{--                                                <div class="modal-header">--}}
{{--                                                    <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Eliminación</h5>--}}
{{--                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-body">--}}
{{--                                                    ¿Estás seguro de que deseas eliminar este reporte?--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-footer">--}}
{{--                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>--}}
{{--                                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form-{{ $report->id }}').submit();">Eliminar</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <!-- Formulario de eliminación -->--}}
{{--                                    <form action="{{ route('reports.destroy', $report->id) }}" method="POST" id="delete-form-{{ $report->id }}" style="display:none;">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                    </form>--}}
{{--                                @endif--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $reports->links() }}
                </div>
            @else
                <p>No se encontraron reportes.</p>
            @endif
        </main>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

@endsection





