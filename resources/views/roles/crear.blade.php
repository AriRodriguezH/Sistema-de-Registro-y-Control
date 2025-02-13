@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h4 class="font-weight-bold text-center">Alta de roles</h4>
<br>
{{ Breadcrumbs::render('crearRol') }}

@stop

@section('content')

<div class="card card-primary">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>¡Revise los campos y coloque por lo menos un permiso!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="" style="font-size: 13px;">Nombre del Rol:</label>
                    {!! Form::text('name', null, array('class' => 'form-control', 'maxlength' => 25, 'required' => 'required', 'autocomplete' => 'off')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="" style="font-size: 13px;">Permisos para este Rol:</label>
                    <br />
                    @php
                    $permissionsChunks = $permission->chunk(count($permission) / 3);
                    $order = ['ver', 'crear', 'editar', 'borrar'];
                    @endphp
                    <div class="row">
                        @foreach ($order as $permType)
                        <div class="col-md-3">
                            @foreach ($permissionsChunks as $chunk)
                            @foreach ($chunk as $value)
                            @if (strpos($value->name, $permType) === 0)
                            <label style="font-size: 13px;">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name','style' => 'font-size: 13px;')) }}
                                {{ $value->name }}</label>
                            <br />
                            @endif
                            @endforeach
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <a href="{{ url()->previous() }}" class="btn btn-danger mr-2" tabindex="6" style="font-size: 13px;">Cancelar</a>
                    <button type="submit" class="btn btn-primary" style="font-size: 13px;">Guardar</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

@section('js')

@stop