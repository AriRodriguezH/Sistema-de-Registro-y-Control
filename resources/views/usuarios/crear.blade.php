    @extends('adminlte::page')

    @section('title', 'MGSI')

    @section('content_header')
    <h4 class="font-weight-bold text-center">Alta de Usuarios</h4>
    <br>
    {{ Breadcrumbs::render('crearUsuario') }}
    @stop

    @section('content') 

    <div class="card card-primary">
        <div class="card-body">

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>¡Revise y llene los campos correctamente!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            {!! Form::open(array('route' => 'usuarios.store','method'=>'POST')) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" style="font-size: 13px;">Nombre</label>
                        {!! Form::text('nombre', null, array('class' => 'form-control', 'maxlength' => 150, 'required' => 'required', 'autocomplete' => 'off')) !!}
                        @if ($errors->has('nombre'))
                        <label class="control-label has-error" style="color: red;">
                            {{ $errors->first('nombre') }}
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="apellidoP" style="font-size: 13px;">Apellido Paterno</label>
                        {!! Form::text('apellidoP', null, array('class' => 'form-control','maxlength' => 150, 'required' => 'required', 'autocomplete' => 'off')) !!}
                        @if ($errors->has('apellidoP'))
                        <label class="control-label has-error" style="color: red;">
                            {{ $errors->first('apellidoP') }}
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="apellidoM"style="font-size: 13px;">Apellido Materno</label>
                        {!! Form::text('apellidoM', null, array('class' => 'form-control','maxlength' => 150, 'required' => 'required', 'autocomplete' => 'off')) !!}
                        @if ($errors->has('apellidoM'))
                        <label class="control-label has-error" style="color: red;">
                            {{ $errors->first('apellidoM') }}
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombreUsuario"style="font-size: 13px;">Nombre Usuario</label>
                        {!! Form::text('nombreUsuario', null, array('class' => 'form-control','maxlength' => 150, 'required' => 'required', 'autocomplete' => 'off')) !!}
                        @if ($errors->has('nombreUsuario'))
                        <label class="control-label has-error" style="color: red;">
                            {{ $errors->first('nombreUsuario') }}
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email"style="font-size: 13px;">Correo</label>
                        {!! Form::email('email', null, array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) !!}
                        @if ($errors->has('email'))
                        <label class="control-label has-error" style="color: red;">
                            {{ $errors->first('email') }}
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="password"style="font-size: 13px;">Contraseña</label>
                        <a data-toggle="tooltip" title="La contraseña debe de tener entre 8 y 15 caracteres, al menos un número, al menos una letra minúscula, al menos una letra mayúscula y al menos un caracter especial." class="ml-2" style="font-size: 13px;">
                            <i class="fas fa-question-circle"></i>
                        </a>
                        {!! Form::password('password', array('class' => 'form-control', 'required' => 'required')) !!}
                        @if ($errors->has('password'))
                        <label class="control-label has-error" style="color: red;">
                            {{ $errors->first('password') }}
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="confirm-password" style="font-size: 13px;">Confirmar Contraseña</label>
                        {!! Form::password('confirm-password', array('class' => 'form-control', 'required' => 'required')) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""  style="font-size: 13px;">Roles</label>
                        {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'required' => 'required', 'style' => 'font-size: 13px;']) !!}
                        @if ($errors->has('roles'))
                        <label class="control-label has-error" style="color: red;">
                            {{ $errors->first('roles') }}
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group d-flex align-items-center justify-content-center h-100 mb-0">
                        <div class="custom-control custom-switch">
                            {!! Form::hidden('estado', 0) !!}
                            {!! Form::checkbox('estado', 1, null, ['id' => 'estado', 'class' => 'custom-control-input']) !!}
                            {!! Form::label('estado', 'Bloquear Usuario', ['class' => 'custom-control-label', 'style' => 'font-size: 13px']) !!}
                            <a data-toggle="tooltip" title="Seleccionar si se desea bloquear al usuario que se dará de alta." class="ml-2" style="font-size: 13px;">
                                <i class="fas fa-question-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group d-none">
                        <label for="intentoSesion">Intentos</label>
                        {!! Form::text('intentoSesion', $user->intentoSesion ?? 0, ['class' => 'form-control', 'maxlength' => 150, 'required' => 'required', 'autocomplete' => 'off', 'id' => 'intentos']) !!}
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

    @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @stop

    @section('js')
    <script src="{{ asset('assests/js/procesos/intentos_bloquear.js')}}"></script>
    @stop