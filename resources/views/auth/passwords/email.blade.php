<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assests/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.0-web/css/all.min.css') }}">
    <title>MGSI-¿Olvidó su contraseña?</title>
</head>
<body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>

    <section class="login-content">

        <div class="logo text-center">
            <img class="rounded img-fluid mx-auto d-block" src="{{ asset('assests/img/imagen.png')}}" style="width: 150px; height: 115px"/>
            <h1 style="font-family:'Segoe UI'" >SRCCMGSI</h1>
        </div>


        <div class="login-box p-5">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidó su contraseña?</h3>

            <div class="form-group">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form  method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group ">
                    <label for="email" class="control-label">{{ __('Correo Institucional') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror " name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="form-group btn-container">
                        <button  type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>{{ __('Restablecer Contraseña') }}</button>
                    </div>

                    <div class="form-group mt-3">
                        <p class="semibold-text mb-0"><a href="{{ route('login') }}" ><i class="fa fa-angle-left fa-fw"></i> Regresar a Login</a></p>
                    </div>
            </form>
            </div>
        </div>
    </section>
</body>
</html>