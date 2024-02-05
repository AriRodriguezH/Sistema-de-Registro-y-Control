<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assests/css/main.css')}}">
    <!-- Font-icon css font-awesome.min.css-->
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.0-web/css/all.min.css') }}">
    <title>MGSI-Login</title>
    <p>URL actual: {{ url()->current() }}</p>
</head>

<body>
    <!-- Section: Design Block -->
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content ">

        <div class="logo text-center">
            <img class="rounded img-fluid mx-auto d-block" src="{{ asset('assests/img/imagen.png')}}" style="width: 150px; height: 115px" />
            <h1 style="font-family:'Segoe UI'">MGSI</h1>
        </div>
        
        <<div class="login-box p-5" style="width: 400px; height: 300px;">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>¡Usuario Bloqueado!</h3>

            <div class="form-group">
                <h5 class="text-danger text-justify">Has excedido el número de intentos permitidos, por favor contáctate con el administrador para volver a tener acceso.</h5>
            </div>

            <div class="form-group mt-5 mb-0 position-absolute bottom-0 end-0">
                <p class="semibold-text"><a href="{{ url('/') }}"><i class="fa fa-angle-left fa-fw"></i> Regresar a Login</a></p>
            </div>
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