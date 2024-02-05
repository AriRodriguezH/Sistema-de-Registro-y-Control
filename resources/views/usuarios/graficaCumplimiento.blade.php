@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('content_header')
<h4 class="font-weight-bold text-center mx-auto">Gráfica General de Cumplimiento de Procesos</h4>
<br>
{{ Breadcrumbs::render('graficaCumplimiento') }}
@stop

@section('content')
<div class="container">
    <canvas id="graficaCumplimientoTodosProcesos" width="800" height="500"></canvas>
</div>
        
<div class="container">
    <div class="d-flex justify-content-center mb-2">
        <a href="#" onclick="capturarImagenYGenerarPDF();" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Descargar Reporte
        </a>
    </div>
</div>
    


@stop

@section('css')
<link rel="stylesheet" href="{{  asset('assests/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('assests/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{ asset('assests/css/main.json')}}">
@stop

@section('js')
<script src="{{ asset('assests/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assests/js/es_es.json') }}"></script>
<script  src="{{ asset('assests/js/html2canvas.js') }}"></script>
<script  src="{{ asset('assests/js/html2canvas.min.js') }}"></script>
<script src="{{ asset('assests/js/chart.js') }}"></script>
<script src="{{ asset('assests/js/charts/graficaDocumentacionesCompleta.js') }}"></script>

<script>
    var datosGrafica = @json($datosGrafica);
    var years = @json($years);
    var coloresProcesos = @json($coloresProcesos);
</script>

<script>
function capturarImagenYGenerarPDF() {
    html2canvas(document.getElementById('graficaCumplimientoTodosProcesos')).then(function (canvas) {
        // Captura la imagen en formato JPG
        var image = canvas.toDataURL('image/jpeg');

        // Envia la imagen capturada al controlador
        fetch('{{ url('/guardar-imagen-linea') }}', {
            method: 'POST',
            body: JSON.stringify({ image: image }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Redirige al controlador que genera el PDF y pasa el nombre de la imagen
                window.open('{{ url('/generar-pdfCompleto2/') }}' + '/' + result.nombreImagen, '_blank');

                // Una vez que se ha descargado el PDF con éxito, envia una solicitud para eliminar la imagen
                fetch('{{ url('/eliminar-imagen-linea') }}', {
                    method: 'POST',
                    body: JSON.stringify({ nombreImagen: result.nombreImagen }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            } else {
                alert('Error al guardar la imagen.');
            }
        })
        .catch(error => {
            alert('Error al guardar la imagen: ' + error);
        });
    });
}
</script>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($resultados as $resultado)
                var ctx = document.getElementById('chart-{{ $resultado['identificador'] }}-{{ $resultado['anio'] }}-{{ $resultado['semestre'] }}').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Cumplimiento', 'Restante'],
                        datasets: [{
                            data: [{{ $resultado['porcentajeCumplimiento'] }}, {{ 100 - $resultado['porcentajeCumplimiento'] }}],
                            backgroundColor: ['#36A2EB', '#FFCE56'],
                        }],
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Porcentaje de Cumplimiento',
                        },
                    },
                });
            @endforeach
        });
    </script>
@stop