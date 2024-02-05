@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('content_header')
<h4 class="font-weight-bold text-center">Cambiar contraseña</h4>
<br>
{{ Breadcrumbs::render('cambiarContrasena') }}
@stop

@section('content')

@if (session('success_cambio_contrasenia')) <!--Alerta de Actualización exitosa de Contraseña-->
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success_cambio_contrasenia') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>¡Revise y llene los campos correctamente!</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card card-primary">
    <div class="form-horizontal">
        <div class="form-group">
            <div class="card-body">

                {!! Form::open(['route' => 'cambiarContrasena.post']) !!}
                <div class="form-group has-feedback">
                    <label for="contrasenia_actual" style="font-size: 15px;">Contraseña actual</label>
                    {!! Form::password('contrasenia_actual', ['class' => 'form-control', 'required' => 'required']) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('contrasenia_actual'))
                    <label class="control-label has-error" style="color: red;">
                        {{ $errors->first('contrasenia_actual') }}
                    </label>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <label for="contrasenia_nueva" style="font-size: 15px;">Ingrese su nueva contraseña</label>
                    {!! Form::password('contrasenia_nueva', ['class' => 'form-control', 'required' => 'required']) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('contrasenia_nueva'))
                    <label class="control-label has-error" style="color: red;">
                        {{ $errors->first('contrasenia_nueva') }}
                    </label>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <label for="contrasenia_nueva_confirmation" style="font-size: 15px;">Confirme su nueva contraseña</label>
                    {!! Form::password('contrasenia_nueva_confirmation', ['class' => 'form-control','required' => 'required']) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('contrasenia_nueva_confirmation'))
                    <label class="control-label has-error" style="color: red;">
                        {{ $errors->first('contrasenia_nueva_confirmation') }}
                    </label>
                    @endif
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')

@stop