@extends('adminlte::page')

@section('title', 'MGSI')

@section('content_header')
<h4 class="font-weight-bold text-center">Datos Generales</h4>
<br>
{{ Breadcrumbs::render('verPerfil') }}
@stop

@section('content')

<div class="card card-primary">
    <div class="form-horizontal">
        <div class="form-group">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label " style="font-size: 15px;" for="name">Nombre</label>
                        {{ Form::text('nombre', Auth::user()->nombre, ['class' => 'form-control', 'id' => 'nombre','readonly' => 'true']) }}
                    </div>

                    <div class="col-md-4">
                        <label class="control-label " style="font-size: 15px;" for="apellidoP">Apellido Paterno</label>
                        {{ Form::text('apellidoP', Auth::user()->apellidoP, ['class' => 'form-control', 'id' => 'apellidoP','readonly' => 'true']) }}
                    </div>

                    <div class="col-md-4">
                        <label class="control-label " style="font-size: 15px;" for="apellidoM">Apellido Materno</label>
                        {{ Form::text('apellidoM', Auth::user()->apellidoM, ['class' => 'form-control', 'id' => 'apellidoM','readonly' => 'true']) }}
                    </div>
                </div>

                <br>

                <div class="row">
                    <div div class="col-md-4">
                        <label class="control-label " style="font-size: 15px;" for="nombreUsuario">Nombre de Usuario</label>
                        {{ Form::text('nombreUsuario', Auth::user()->nombreUsuario, ['class' => 'form-control', 'id' => 'nombreUsuario','readonly' => 'true']) }}
                    </div>

                    <div class="col-md-4">
                        <label class="control-label " style="font-size: 15px;" for="email">Correo Institucional</label>
                        {{ Form::email('email', Auth::user()->email, ['class' => 'form-control', 'id' => 'email','readonly' => 'true']) }}
                    </div>

                    <div class="col-md-4">
                        <label class="control-label " style="font-size: 15px;" for="rol">Rol</label>
                        {{ Form::text('roles', Auth::user()->roles()->pluck('name')->first(), ['class' => 'form-control', 'readonly' => 'readonly']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop