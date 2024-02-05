@extends('adminlte::page')

@section('title', 'MGSI')

@section('content_header')
{{ Breadcrumbs::render('home') }}

@stop

@section('content')
<!-- GRÁFICA-->
<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Gráfica del Cumplimiento Total del MGSI</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="chart" style="width: 100%; height: 400px; overflow: hidden; margin: 0 auto;">
                <canvas id="graficaCumplimientoTodosProcesos" style="width: 100%; height: 100%;"></canvas>
            </div>
        </div>
    </div>


    <!-- TARJETAS DE INICIO -->
    <div class="card-body">
        <div class="row">

            @php
            use App\Models\User;
            $cant_usuarios = User::count();
            @endphp

            @can('ver-usuarios')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="width: 240px; height: 140px; position: relative;">
                    <div class="inner">
                        <h1><span>{{$cant_usuarios}}</span></h1>
                        <h6> Usuarios </h6>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users f-left"></i>
                    </div>
                    <a href="usuarios" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endcan

            @php
            use Spatie\Permission\Models\Role;
            $cant_roles = Role::count();
            @endphp

            @can('ver-rol')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success" style="width: 240px; height: 140px; position: relative;">
                    <div class="inner">
                        <h1><span>{{$cant_roles}}</span></h1>
                        <h6>Roles</h6>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-lock f-left"></i>
                    </div>
                    <a href="roles" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endcan

            <!-- CARDS DE LOS PROCESOS -->

            <div class="col-lg-3 col-6">
                <div class="small-box " style="background-color: #008077; width: 240px; height: 140px; position: relative; ">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">A. Objetivos, requerimientos y estrategias</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-object-group"></i>
                    </div>
                    <a href="procesoA" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#6E736D; width: 240px; height: 140px; position: relative;">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">B. Identificación de los procesos y activos esenciales de la CONDUSEF</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-copy"></i>
                    </div>
                    <a href="procesoB" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#6A33A1; width: 240px; height: 140px; position: relative;">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">C. Análisis de Riesgos</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-eye"></i>
                    </div>
                    <a href="procesoC" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>



            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#CC392F; width: 240px; height: 140px; position: relative;">
                <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px; ">D. Implementación de los controles mínimos de Seguridad de la Información</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-file-contract"></i>
                    </div>
                    <a href="procesoD" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#B53F65; width: 240px; height: 140px; position: relative;">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">E. Programa de gestión de vulnerabilidades.</h6>
                    </div>
                    <div class="icon">
                        <i class="fa fa-balance-scale"></i>
                    </div>
                    <a href="procesoE" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#10873E; width: 240px; height: 140px; position: relative;">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">F. Protocolo de respuesta ante incidentes de Seguridad de la Información</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-user-shield"></i>
                    </div>
                    <a href="procesoF" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#FF6315; width: 240px; height: 140px; position: relative;">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">G. Plan de Continuidad de Operaciones y Plan de Recuperación ante Desastres</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-file-signature"></i>
                    </div>
                    <a href="procesoG" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#DEA702; width: 240px; height: 140px; position: relative;">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">H. Supervisión y evaluación</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-check-double"></i>
                    </div>
                    <a href="procesoH" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#0D16BF; width: 240px; height: 140px; position: relative;">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">I. Programa de Formación, Concientización y Capacitación en materia de Seguridad de la Información</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-sitemap"></i>
                    </div>
                    <a href="procesoI" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box" style="background-color:#C900A8; width: 240px; height: 140px; position: relative;">
                    <div class="inner" style="color: white; font-weight: 700; text-align: center; padding: 10px;">
                        <h6 style="margin: 10px;">J. Programa de implementación del MGSI</h6>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-book"></i>
                    </div>
                    <a href="procesoJ" class="small-box-footer" style="width: 240px; height: 30px; position: absolute; bottom: 0;">
                        Ver más
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @stop

        @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
        @stop

        @section('js')
        <!-- ChartJS -->
        <script src="{{ asset('assests/js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{ asset('assests/js/chart.js') }}"></script>
        <script src="{{ asset('assests/js/charts/graficaDocumentacionesCompleta.js') }}"></script>

        <script>
        var datosGrafica = @json($datosGrafica);
        var years = @json($years);
        var coloresProcesos = @json($coloresProcesos);
        </script>
        @stop