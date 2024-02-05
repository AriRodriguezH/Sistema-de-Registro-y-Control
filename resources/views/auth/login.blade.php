<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assests/css/main.css')}}">
  <!-- Font-icon css-->
  <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.0-web/css/all.min.css') }}">

  <title>MGSI-Login</title>
</head>

<body>
  <!-- Section: Design Block -->
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content ">
    <div class="logo text-center">
      <img class="rounded img-fluid mx-auto d-block" src="{{ asset('assests/img/imagen.png')}}" style="width: 150px; height: 115px" />
      <h1 style="font-family:'Segoe UI'">SRCCMGSI</h1>
    </div>
    <div class="login-box p-5">
    <h3 class="login-head">
      <i class="fa-solid fa-user" style="margin-right: 10px;"></i>
      INICIO DE SESIÓN
    </h3>
      {!! Form::open(array('route' => 'login','method'=>'POST')) !!}

      @csrf

      @if ($errors->has('nombreUsuario'))
      <div class="alert alert-danger">
        {{ $errors->first('nombreUsuario') }}
      </div>
      @endif
      
      <div class="form-group ">
        <label class="control-label">NOMBRE DE USUARIO</label>
        {!! Form::text('nombreUsuario', null, array('class' => 'form-control', 'maxlength' => 250, 'required' => 'required', 'autocomplete' => 'off')) !!}
      </div>
      
      <div class="form-group">
        <label class="control-label">CONTRASEÑA</label>
        {!! Form::password('password', array('class' => 'form-control', 'required' => 'required')) !!}
            @if ($errors->has('password'))
            <label class="control-label has-error" style="color: red;">
                {{ $errors->first('password') }}
            </label>
            @endif
      </div>

      <div class="form-group">
        <div class="utility">
          <p class="semibold-text mb-2">
            @if (Route::has('password.request'))
            <a class="semibold-text mb-2" href="{{ route('password.request') }}" data-toggle="flip"> {{ __('¿Olvidó su contraseña?') }}</a>
            @endif
          </p>
        </div>
      </div>
  
      <div class="form-group btn-container">
        <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw" type="submit"></i>{{ __('Iniciar Sesión') }}</button>
      </div>

      {!! Form::close() !!}
    </div>
  </section>
  <!-- Section: Design Block -->
  <!-- Bootstrap JavaScript Libraries -->
  <script src="public/assests/js/jquery-3.2.1.min.js"></script>
  <script src="public/assests/js/popper.min.js"></script>
  <script src="public/assests/js/bootstrap.min.js"></script>
  <script src="public/assests/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="public/assests/js/plugins/pace.min.js"></script>
  <script type="text/javascript">
    // Login Page Flipbox control
  </script>
</body>

</html>