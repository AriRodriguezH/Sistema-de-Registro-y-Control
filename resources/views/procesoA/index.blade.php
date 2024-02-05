@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('content_header')

@if (!empty($proceso))
<h4 class="font-weight-bold text-center">{{ $proceso->identificador }}. {{ $proceso->nombreProceso }}</h4>
<br>
@endif
{{ Breadcrumbs::render('procesoA') }}
@stop

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            @can('crear-procesos')
            <a class="btn btn-primary" href="{{ route('procesoA.create') }}"><i class="fas fa-plus-square"></i> <i style="padding-left: 5px;"></i>Nuevo</a>
            @endcan
        </div>
    </div>
    <div class="col-md-9">
        <div class="form-group d-flex justify-content-end">
            <input type="text" class="form-control col-md-4" id="searchYear" pattern="[0-9]{1,4}" maxlength="4" placeholder="Buscar año:" inputmode="numeric">
            <button type="button" class="btn btn-secondary ml-2" id="sortAscBtn"><i class="fas fa-arrow-up"></i></button>
            <button type="button" class="btn btn-secondary ml-2" id="sortDescBtn"><i class="fas fa-arrow-down"></i></button>
        </div>
    </div>
</div>
<div id="noResults" class="alert alert-info" style="display: none;">Sin resultados</div>

@if(session('success_edit'))
<div class="alert alert-success">
    {{ session('success_edit') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-body">

        <br>
        <div class="row">

            <div class="col-md-12 card-container">
                @if(Auth::user()->hasRole('Administrador'))
                @foreach($publicaciones as $publicacion)
                @if($publicacion->proceso_id === 1)
                <div class="card card-success collapsed-card mb-4">
                    <div class="card-header">
                        {{ $publicacion->anioRegistro }}
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                            <a href="{{ route('procesoA.editar', $publicacion->id) }}" class="btn btn-tool">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('procesoA.calificar', ['id' => $publicacion->id]) }}" class="btn btn-tool">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="#" class="btn btn-tool delete-publication" data-id="{{$publicacion->id}}">
                                    <i class="fas fa-trash"></i>
                                </a>

                                <form id="delete-form-{{$publicacion->id}}" action="{{ route('procesoA.destroy', $publicacion->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                        </div>
                    </div>
                    <div class="card-body text-success">
                        <ul>
                            @foreach($publicacion->documentacion as $documentacion)
                            <li>Semestre: {{ $documentacion->semestre }}</li>
                            <ul>
                                <li>{{ $documentacion->descripcion }}</li>
                            </ul>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                @endforeach
                @else
                @foreach($publicaciones as $publicacion)
                @if($publicacion->proceso_id === 1)

                <div class="card card-success collapsed-card mb-4">
                    <div class="card-header">
                        {{ $publicacion->anioRegistro }}
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body text-success">
                        <ul>
                            @foreach($publicacion->documentacion as $documentacion)
                            <li>Semestre: {{ $documentacion->semestre }}</li>
                            <ul>
                                <li>{{ $documentacion->descripcion }}
                                    @if(!Auth::user()->hasRole('Administrador'))
                                    <br>
                                    <a href="{{ route('procesoA.responder', ['id' => $publicacion->id, 'documentacionId' => $documentacion->id]) }}">Ver Asignación</a>

                                    @endif
                                </li>
                            </ul>
                            @endforeach
                        </ul>
                    </div>

                </div>

                @endif
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet"  href="{{ asset('assests/css/sweetalert2.min.css')}}">
@stop

@section('js')
<script src="{{ asset('assests/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('assests/js/procesos/busqueda_filtrado.js') }}"></script>
<script src="{{ asset('assests/js/procesos/alerta_eliminacion_publicacion.js') }}"></script>
<script src="{{ asset('assests/js/sweetalert2.all.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.agregar-documentacion').click(function() {
            var postId = $(this).data('id');
            window.location.href = '/documentacion/create?post_id=' + postId;
        });
    });
</script>
@stop