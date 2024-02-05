@extends('adminlte::page')

@section('title', 'MGSI')

@section('content_header')
<h4 class="font-weight-bold text-center">Grafica Proceso J</h4>
<br>
{{ Breadcrumbs::render('graficaDocumentacionCompletaJ') }}
@stop

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <!-- Primera columna: Gráfica de Documentaciones Entregadas con estatus "Completa"e Incompleta por Año -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Gráfica de Documentaciones Entregadas con estatus "Completa"</div>
                <div class="card-body">
                    <canvas id="graficaDocumentacion" style="max-width: 900px; max-height: 245px;"></canvas>
                </div>
            </div>
        </div>
        <!-- Segunda columna: Gráfica de Cumplimiento por Semestre -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Gráfica de Cumplimiento por Semestre</div>
                <div class="card-body">
                    <canvas id="barChart" style="max-width: 900px; max-height: 245px;"></canvas>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="d-flex justify-content-center mb-2"> <!-- Alinear al lado derecho -->
                <a href="{{ url('/generar-pdfJ') }}" target="_blank" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Descargar Reporte
                </a>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- Pasar los datos desde PHP a JavaScript -->
<script>
    var anios = @json(array_keys($anioCompletas));
    var completas = @json(array_values($anioCompletas));
    var incompletas = @json(array_values($anioIncompletas));
    var porcentajes = @json(array_values($porcentajeCompletas));

    // Datos proporcionados desde el controlador para la gráfica de barras
    var aniosBar = @json(array_keys($datosGraficaBar));
    var datosBarras = @json(array_values($datosGraficaBar));
</script>

<!-- Incluir el script para la gráfica de documentación -->
<script src="{{ asset('assests/js/chart.js') }}"></script>
<script src="{{ asset('assests/js/charts/graficaDocumentacionesProcesos.js') }}"></script>
<script src="{{ asset('assests/js/barChart.js') }}"></script>
@stop