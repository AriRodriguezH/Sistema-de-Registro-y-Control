@extends('adminlte::page')

@section('title', 'MGSI')

@section('content_header')
<h1 class="font-weight-bold text-center">Editar Proceso A</h1>
<br>
{{ Breadcrumbs::render('editarPublicacionA') }}
@stop

@section('content')

@if ($errors->has('anioRegistro'))
<div class="alert alert-danger">
    {{ $errors->first('anioRegistro') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-body">
        {!! Form::model($publicacion, ['route' => ['procesoA.update', $publicacion->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
        @csrf

        <div class="mb-3">
            {!! Form::hidden('tipoProcesoId', $tipoProcesoId) !!}

            <div class="card-header">Editar Publicación - ID: {{ $publicacion->id }}</div>

            <div class="form-group">
                <label style="font-size: 13px;" for="datepicker">Año:</label>
                <div class="input-group">
                    {!! Form::text('anioRegistro', null, ['id' => 'datepicker', 'class' => 'form-control','style' => 'font-size: 13px;', 'placeholder' => 'Seleccionar año', 'readonly' => 'readonly', 'required' => 'required']) !!}
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </div>
            </div>

            @foreach ($documentacion as $i => $documento)
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('semestre_'.$documento->id, 'Semestre',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('semestre_'.$documento->id, $documento->semestre, ['class' => 'form-control','style' => 'font-size: 13px;','readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('descripcion_'.$documento->id, 'Descripcion',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('descripcion_'.$documento->id, $documento->descripcion, ['class' => 'form-control','style' => 'font-size: 13px;','readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('archivos_'.$documento->id, 'Archivos Adjuntos:',['style' => 'font-size: 13px;']) }}
                        <div class="custom-file">
                            {{ Form::file('archivos_'.$documento->id.'[]', ['class' => 'custom-file-input','style' => 'font-size: 13px;', 'multiple', 'accept' => '.pdf,.doc,.docx,.xls,.xlsx', 'id' => 'archivos_'.$documento->id, 'data-browse' => 'Seleccionar']) }}
                            <label style="font-size: 13px;" class="custom-file-label" for="archivos_{{ $documento->id }}">Seleccionar archivos</label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url()->previous() }}" class="btn btn-danger" style="font-size: 13px;" tabindex="6">Cancelar</a>
                    {!! Form::submit('Actualizar', ['class' => 'btn btn-primary','style' => 'font-size: 13px;']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="{{  asset('assests/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{  asset('assests/css/bootstrap-datepicker.min.css') }}">
@stop

@section('js')
<script src="{{ asset('assests/js/procesos/actu_subida_archivo.js') }}"></script>
<script src="{{ asset('assests/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assests/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assests/js/jquery.ui.datepicker-es.js') }}"></script>
<script src="{{ asset('assests/js/procesos/seleccion-anio.js') }}"></script>

@stop