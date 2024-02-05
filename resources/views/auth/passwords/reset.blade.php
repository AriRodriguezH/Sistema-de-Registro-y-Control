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
    <title>MGSI Restablecimiento de contraseña</title>
</head>
<body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>

    <section class="login-content">

        <div class="logo text-center">
            <img class="rounded img-fluid mx-auto d-block" src="{{ asset('assests/img/imagen.png')}}" style="width: 150px; height: 115px"/>
            <h1 style="font-family:'Segoe UI'" >MGSI</h1>
        </div>


        <div class="login-box p-5">
            <h3 class="login-head">{{ __('Restaurar Contraseña') }}</h3>
            
            <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group ">
                        <label for="email" class="control-label">{{ __('Correo Institucional') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group ">
                    <label for="password" class="control-label">{{ __('Nueva contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group ">
                        <label for="password-confirm" class="control-label">{{ __('Confirmar nueva contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="form-group btn-container">
                        <button  type="submit" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i>
                            {{ __('Reset Password') }}</button>
                    </div>
            </form>
        </div>
    </section>
</body>
</html>