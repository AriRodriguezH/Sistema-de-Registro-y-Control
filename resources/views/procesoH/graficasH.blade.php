@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('content_header')
<h4 class="font-weight-bold text-center">Grafica Proceso H</h4>
<br>
{{ Breadcrumbs::render('graficaDocumentacionCompletaH') }}
@stop

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <!-- Primera columna: Gráfica de Documentaciones Entregadas con estatus "Completa"e Incompleta por Año -->
        <div class="col-md-6">
            <div class="card">
            <div class="card-header">Gráfica de Documentaciones con estatus "Completa"</div>
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
        <div class="d-flex justify-content-center mb-2">
            <a href="#" onclick="capturarImagenYGenerarPDF();" class="btn btn-danger">
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

<!-- capturador de las imagenes de gráfica para PDF -->
<script>
function capturarImagenYGenerarPDF() {
    Promise.all([
        html2canvas(document.getElementById('graficaDocumentacion')),
        html2canvas(document.getElementById('barChart'))
    ]).then(([canvas1, canvas2]) => {
        // Captura las imágenes en formato JPG
        var image1 = canvas1.toDataURL('image/jpeg');
        var image2 = canvas2.toDataURL('image/jpeg');

        // Envia ambas imágenes al controlador
        fetch('{{ url('/guardar-imagenes') }}', {
            method: 'POST',
            body: JSON.stringify({ image1: image1, image2: image2 }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Redirige al controlador que genera el PDF y pasa el nombre de las imagenes
                window.open('{{ url('/generar-pdfH/') }}' + '/' + result.nombreImagen1 + '/' + result.nombreImagen2, '_blank');

                // Una vez que se ha descargado el PDF con éxito, enviar una solicitud para eliminar las imágenes
                fetch('{{ url('/eliminar-imagenes') }}', {
                    method: 'POST',
                    body: JSON.stringify({ nombreImagen1: result.nombreImagen1, nombreImagen2: result.nombreImagen2 }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            } else {
                alert('Error al guardar las imagen 1 y/o imagen 2.');
            }
        })
        .catch(error => {
            alert('Error al guardar las imágenes: ' + error);
        });
    });
}
</script>

<!-- Incluir el script para la gráfica de documentación -->
<script src="{{ asset('assests/js/chart.js') }}"></script>
<script  src="{{ asset('assests/js/html2canvas.js') }}"></script>
<script  src="{{ asset('assests/js/html2canvas.min.js') }}"></script>
<script src="{{ asset('assests/js/charts/graficaDocumentacionesDona.js') }}"></script>
<script src="{{ asset('assests/js/charts/graficaDocumentacionesBarra.js') }}"></script>
<script src="{{ asset('assests/js/barChart.js') }}"></script>
@stop