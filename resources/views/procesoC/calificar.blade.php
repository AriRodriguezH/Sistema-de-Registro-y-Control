@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h4 class="font-weight-bold text-center mx-auto">Calificar publicación</h4>
    <a href="{{ route('procesoC.index', ['return_url' => url()->current()]) }}" class="btn" style="background-color: #AAADAD; color: #FFFFFF; padding-left: 10px;" tabindex="6">
        <i class="fas fa-chevron-left" style="margin-right: 5px;"></i>
        Volver
    </a>
</div>
<br>
{{ Breadcrumbs::render('calificarProcesoC') }}

@stop

@section('content')

<div class="card">
<div class="card-header" style="padding-top: 20px; text-align: center;"><h4>Publicación: {{ $publicacion->anioRegistro }}</h4></div>
    <div class="card-body">
    <div class="attachment-section">
            <h6>Archivos adjuntos de la Publicación:</h6>

            <div class="card card-warning collapsed-card mb-4">
                <div class="card-header"style="font-size: 5px;">
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i style="font-size: 10px;" class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body ">
                    @foreach ($documentaciones as $documentacion)
                    <label style="font-size: 14px;">Semestre: {{ $documentacion->semestre }}</label>
                    @if ($documentacion->archivo_path)
                    @foreach (explode('|', $documentacion->archivo_path) as $archivoPath)
                    <li>
                        <a href="{{ asset('storage/' . $archivoPath) }}" target="_blank">{{ basename($archivoPath) }}</a>
                    </li>
                    @endforeach
                    @else
                    <p style="font-size: 13px;">No se han subido archivos adjuntos para esta documentación.</p>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        @php $tableCount = 1; @endphp <!-- Variable  para generar identificadores únicos para cada tabla.-->

        @foreach($publicacion->documentacion->groupBy('semestre') as $semestre => $documentaciones)
        <h5>Semestre: {{ $semestre }}</h5>

        <div class="table-responsive-sm" style="margin-bottom: 60px;">
            <table class="table table-striped table-bordered mt-4" width="100%" id="documentacionTable{{ $tableCount }}">
                <thead style="background-color: #2e7555!important;" class="text-white">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Estado</th>
                        <th>Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documentaciones as $documentacion)
                    @php
                    $usuariosRespondieron = $documentacion->respuestas->pluck('users_id')->toArray();
                    @endphp

                    @foreach($documentacion->usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->apellidoP }}</td>
                        <td>{{ $usuario->apellidoM }}</td>
                        <td>
                            @if(in_array($usuario->id, $usuariosRespondieron))
                            Respondido
                            @else
                            Sin entregar
                            @endif
                        </td>
                        <td>
                            @if (in_array($usuario->id, $usuariosRespondieron))
                            @php
                            $respuesta = $documentacion->respuestas->where('users_id', $usuario->id)->first();
                            $archivos = explode('|', $respuesta->archivo_path);
                            @endphp

                            @if (count($archivos) > 1)
                            <a href="{{ route('procesoC.descargarArchivos', ['id' => $respuesta->id]) }}">Descargar archivos (ZIP)</a><br>
                            @else
                            <a href="{{ route('procesoC.descargarArchivos', ['id' => $respuesta->id, 'archivo' => $archivos[0]]) }}">Descargar archivo</a><br>
                            @endif

                            @endif
                        </td>
                        <td>
                            @if(in_array($usuario->id, $usuariosRespondieron))
                            @php
                            $calificacion = $respuesta->calificacion;
                            @endphp
                            @if($calificacion)
                            <a href="#" data-toggle="modal" data-target="#verCalificacionModal{{ $calificacion->id }}">Ver calificación</a>
                            <br>
                            <a href="#" data-toggle="modal" data-target="#editarCalificacionModal{{ $calificacion->id }}">Editar calificación</a>
                            @else
                            <a href="#" data-toggle="modal" data-target="#calificarRespuestaModal" data-respuesta-id="{{ $respuesta->id }}" data-usuario-id="{{ $respuesta->usuario->id }}">Calificar respuesta</a>
                            @endif
                            @endif
                        </td>
                        
                    </tr>

                    <!-- Ventana modal para calificar respuesta -->
                    <div class="modal fade" id="calificarRespuestaModal" tabindex="-1" role="dialog" aria-labelledby="calificarRespuestaModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="calificarRespuestaModalLabel">Calificar respuesta</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {!! Form::open(['route' => 'procesoC.calificarRespuesta', 'method' => 'POST']) !!}
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label('porcentajeCumplimiento', 'Porcentaje de Cumplimiento:', ['class' => 'mr-2']) !!}
                                        <a href="#" data-toggle="tooltip" title="El porcentaje requerido para una documentación completa es de mínimo 80." class="ml-2">
                                            <i class="fas fa-question-circle"></i>
                                        </a>                                         
                                        {!! Form::number('porcentajeCumplimiento', null, ['class' => 'form-control', 'required', 'min' => 0, 'max' => 100, 'autocomplete' => 'off', 'oninput' => "if (this.value > 100) this.value = 100;", 'id' => 'porcentajeCumplimientoInputCrear']) !!}          
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('cumplimiento', 'Cumplimiento:') !!}
                                        {!! Form::text('cumplimiento', null, ['class' => 'form-control', 'required', 'id' => 'cumplimientoSelectCrear', 'readonly' => true]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('estadoDocumentacion', 'Estado de la Documentación:') !!}
                                        {!! Form::text('estadoDocumentacion', null, ['class' => 'form-control', 'required', 'id' => 'estadoDocumentacionSelectCrear', 'readonly' => true]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('comentario', 'Comentarios:') !!}
                                        {!! Form::textarea('comentario', null, ['class' => 'form-control']) !!}
                                    </div>
                                    {!! Form::hidden('respuesta_id', '', ['id' => 'respuestaIdInput']) !!}
                                    {!! Form::hidden('users_id', '', ['id' => 'usuarioIdInput']) !!}
                                </div>
                                <div class="modal-footer">
                                    {!! Form::button('Cerrar', ['type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                                    {!! Form::submit('Calificar', ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>


                    <!-- Ventana modal para ver calificación -->
                    @if (isset($calificacion))
                    <div class="modal fade" id="verCalificacionModal{{ $calificacion->id }}" tabindex="-1" role="dialog" aria-labelledby="verCalificacionModal{{ $calificacion->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content model-lg">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="verCalificacionModal{{ $calificacion->id }}Label">Ver Calificación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <p>Cumplimiento:
                                                @if ($calificacion->cumplimiento == 'Si')
                                                <i class="text-success">Si</i> <i class="fas fa-check text-success"> </i> <!-- Icono de paloma -->
                                                @else
                                                <i class="fas fa-times text-danger"> No</i> <!-- Icono de tache -->
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p>Porcentaje de cumplimiento: {{ $calificacion->porcentajeCumplimiento }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p>Estado de la documentación:
                                             @if ($calificacion->estadoDocumentacion == 'Concluido')
                                                <i class="fas fa-check-circle text-success"> Concluido</i> <!-- Icono de concluido -->
                                                @else
                                                <i class="fas fa-exclamation-circle text-danger"> Faltante</i> <!-- Icono de faltante -->
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p>Comentarios: {{ $calificacion->comentario }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center ">
                                            <canvas id="donutChart{{ $calificacion->id }}" style="max-width: 900px; max-height: 200px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Ventana modal para editar calificación -->
                    @if (isset($calificacion))
                    <div class="modal fade" id="editarCalificacionModal{{ $calificacion->id }}" tabindex="-1" role="dialog" aria-labelledby="editarCalificacionModal{{ $calificacion->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarCalificacionModal{{ $calificacion->id }}Label">Editar calificación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {!! Form::open(['route' => ['procesoC.actualizarCalificacion', 'calificacionId' => $calificacion->id], 'method' => 'POST']) !!}
                                {!! Form::token() !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label('porcentajeCumplimiento', 'Porcentaje de Cumplimiento:', ['class' => 'mr-2']) !!}
                                        <a href="#" data-toggle="tooltip" title="El porcentaje requerido para una documentación completa es de mínimo 80." class="ml-2">
                                            <i class="fas fa-question-circle"></i>
                                        </a>                                         
                                        {!! Form::number('porcentajeCumplimiento', $calificacion->porcentajeCumplimiento, ['class' => 'form-control', 'required', 'min' => 0, 'max' => 100, 'autocomplete' => 'off', 'oninput' => "if (this.value > 100) this.value = 100;", 'id' => 'porcentajeCumplimientoInputEditar']) !!}          
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('cumplimiento', 'Cumplimiento:') !!}
                                        {!! Form::text('cumplimiento', $calificacion->cumplimiento, ['class' => 'form-control', 'required', 'id' => 'cumplimientoSelectEditar', 'readonly' => true]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('estadoDocumentacion', 'Estado de la Documentación:') !!}
                                        {!! Form::text('estadoDocumentacion', $calificacion->estadoDocumentacion, ['class' => 'form-control', 'required', 'id' => 'estadoDocumentacionSelectEditar', 'readonly' => true]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('comentario', 'Comentarios:') !!}
                                        {!! Form::textarea('comentario', $calificacion->comentario, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::button('Cerrar', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                                    {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4"></div> <!-- Agrega un espacio en blanco para separar las tablas -->

        @php $tableCount++; @endphp

        @endforeach

    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="{{  asset('assests/css/jquery-ui.css') }}">
<link rel="stylesheet"  href="{{ asset('assests/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet"  href="{{ asset('assests/css/main.json')}}">
@stop

@section('js')
<script src="{{ asset('assests/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assests/js/es_es.json') }}"></script>
<script src="{{ asset('assests/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assests/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assests/js/jquery.ui.datepicker-es.js') }}"></script>
<script src="{{ asset('assests/js/chart.js') }}"></script>
<script src="{{ asset('assests/js/actualizarCamposModal.js') }}"></script>
<script src="{{ asset('assests/js/procesos/actualizar_calificacion.js') }}"></script>



<script>
    $(document).ready(function() {
        @php $tableCount = 1;
        @endphp

        @foreach($publicacion->documentacion->groupBy('semestre') as $semestre => $documentaciones)
        $('#documentacionTable{{ $tableCount }}').DataTable({
            "language": {
                "url": "{{ asset('assests/js/es_es.json') }}"
                },
        });
        @php $tableCount++;
        @endphp
        @endforeach
    });
</script>

<script>
    $(document).ready(function() {
        @foreach($publicacion->documentacion->groupBy('semestre') as $semestre => $documentaciones)
        @foreach($documentaciones as $documentacion)
        @foreach($documentacion->usuarios as $usuario)
        @php
        $respuesta = $documentacion->respuestas->where('users_id', $usuario->id)->first();
        $calificacion = $respuesta ? $respuesta->calificacion : null;
        @endphp

        @if($calificacion)
        var donutData{{ $calificacion->id }} = {
            labels: ['Cumplimiento', 'Faltante'],
            datasets: [{
                data: [{{ $calificacion->porcentajeCumplimiento }}, {{ 100 - $calificacion->porcentajeCumplimiento }}],
                backgroundColor: ['{{ $calificacion->porcentajeCumplimiento >= 80 ? 'rgba(0, 255, 35, 100)' : 'red' }}', 'rgba(237, 237, 237, 93)']
            }]
        };

        var donutOptions{{ $calificacion->id }} = {
            responsive: true,
            cutoutPercentage: 40,
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var currentValue = dataset.data[tooltipItem.index];
                        return currentValue + '%';
                    }
                }
            }
        };

        var donutChart{{ $calificacion->id }} = new Chart(document.getElementById('donutChart{{ $calificacion->id }}'), {
            type: 'doughnut',
            data: donutData{{ $calificacion->id }},
            options: donutOptions{{ $calificacion->id }}
        });
        @endif
        @endforeach
        @endforeach
        @endforeach
    });
</script>

@stop