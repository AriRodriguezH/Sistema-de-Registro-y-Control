@extends('adminlte::page')

@section('title', 'MGSI')

@section('content_header')
<h1 class="font-weight-bold text-center"> Proceso H</h1>
{{ Breadcrumbs::render('crearprocesoH') }}

@stop

@section('content')


@if ($errors->has('anioRegistro'))
<div class="alert alert-danger">
    {{ $errors->first('anioRegistro') }}
</div>
@endif

@if ($errors->has('semestre_0'))
<div class="alert alert-danger">
    {{ $errors->first('semestre_0') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->has('semestre_1'))
<div class="alert alert-danger">
    {{ $errors->first('semestre_1') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->has('descripcion_0'))
<div class="alert alert-danger">
    {{ $errors->first('descripcion_0') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->has('descripcion_1'))
<div class="alert alert-danger">
    {{ $errors->first('descripcion_1') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">

    <div class="card-body">
        {!! Form::open(array('route' => 'procesoH.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
        @csrf

        <div class="mb-3">
            {!! Form::hidden('tipoProcesoId', $tipoProcesoId) !!}

            <div class="form-group">
                <label style="font-size: 13px;" for="datepicker">Selecciona el año:</label>
                <div class="input-group">
                    {!! Form::text('anioRegistro', null, ['id' => 'datepicker', 'class' => 'form-control','style' => 'font-size: 13px;', 'placeholder' => 'Seleccionar año', 'readonly' => 'readonly']) !!}
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('semestre_0', 'Semestre:',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('semestre_0', 1, ['class' => 'form-control','style' => 'font-size: 13px;', 'id' => 'semestre_0', 'required', 'autocomplete' => 'off','readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('descripcion_0', 'Descripción Semestre 1:',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('descripcion_0', 'Enero-Junio', ['class' => 'form-control','style' => 'font-size: 13px;', 'id' => 'descripcion_0', 'rows' => 4, 'required', 'autocomplete' => 'off', 'readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('archivos_0', 'Archivos Semestre 1:',['style' => 'font-size: 13px;']) }}
                        <div class="custom-file">
                            {{ Form::file('archivos_0[]', ['class' => 'custom-file-input','style' => 'font-size: 13px;', 'multiple', 'accept' => '.pdf,.doc,.docx,.xls,.xlsx', 'id' => 'archivos_0', 'data-browse' => 'Seleccionar']) }}
                            <label style="font-size: 13px;" class="custom-file-label" for="archivos_0">Seleccionar archivos</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('semestre_1', 'Semestre:',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('semestre_1', 2, ['class' => 'form-control','style' => 'font-size: 13px;', 'id' => 'semestre_1', 'required', 'autocomplete' => 'off','readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('descripcion_1', 'Descripción Semestre 2:',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('descripcion_1', 'Julio-Diciembre', ['class' => 'form-control','style' => 'font-size: 13px;', 'id' => 'descripcion_1', 'rows' => 4, 'required', 'autocomplete' => 'off', 'readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('archivos_1', 'Archivos Semestre 2:',['style' => 'font-size: 13px;']) }}
                        <div class="custom-file">
                            {{ Form::file('archivos_1[]', ['class' => 'custom-file-input','style' => 'font-size: 13px;', 'multiple', 'accept' => '.pdf,.doc,.docx,.xls,.xlsx', 'id' => 'archivos_1','data-browse' => 'Seleccionar']) }}
                            <label style="font-size: 13px;" class="custom-file-label" for="archivos_1">Seleccionar archivos</label>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-danger" style="font-size: 13px;" tabindex="6">Cancelar</a>
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary', 'tabindex' => '3','style' => 'font-size: 13px;']) !!}

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
<script src="{{ asset('assests/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assests/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assests/js/jquery.ui.datepicker-es.js') }}"></script>
<script src="{{ asset('assests/js/procesos/actu_subida_archivo.js') }}"></script>
<script src="{{ asset('assests/js/procesos/seleccion-anio.js') }}"></script>

@stop