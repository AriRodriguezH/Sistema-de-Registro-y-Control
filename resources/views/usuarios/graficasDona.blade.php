@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('content_header')
<h4 class="font-weight-bold text-center mx-auto">Gráficas generales del cumplimiento de procesos</h4>
<br>
{{ Breadcrumbs::render('graficaCumplimiento') }}
@stop

@section('content')

<div class="container">
    <div class="d-flex justify-content-end mb-2 mr-5">
        <a href="#" onclick="capturarImagenesYGenerarPDF2();" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Descargar Reporte
        </a>
    </div>
</div>


<div class="container" style="display: flex; flex-wrap: wrap; justify-content: space-around;">
    @foreach ($resultados as $resultado)
        <div class="chart-container" style="text-align: center; margin: 15px; width: 200px;">
            <h3>{{ $resultado['identificador'] }} - Año {{ $resultado['anio'] }} - Semestre {{ $resultado['semestre'] }}</h3>
            <canvas class="chart-canvas" id="chart-{{ $resultado['identificador'] }}-{{ $resultado['anio'] }}-{{ $resultado['semestre'] }}" data-identificador="{{ $resultado['identificador'] }}" data-anio="{{ $resultado['anio'] }}"></canvas>
            <p style="margin-top: 10px;">Cumplimiento: {{ $resultado['porcentajeCumplimiento'] }}%</p>
        </div>
    @endforeach
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
    function capturarImagenesYGenerarPDF2() {
        var promises = [];

        // Itera sobre todos los contenedores de gráficas y captura las imágenes
        document.querySelectorAll('.chart-container').forEach(function(container, index) {
            promises.push(html2canvas(container).then(function (capturedCanvas) {
                // Captura la imagen en formato JPG con un nombre único
                return {
                    image: capturedCanvas.toDataURL('image/jpeg'),
                };
            }));
        });

        // Cuando todas las imágenes se hayan capturado, continúa con el proceso
        Promise.all(promises).then(function(imagesWithInfo) {
            // Extrae las imágenes para enviar al controlador
            var images = imagesWithInfo.map(function(imageWithInfo) {
                return imageWithInfo.image;
            });

            // Envia las imágenes al controlador
            fetch('{{ url('/guardar-imagenes2') }}', {
                method: 'POST',
                body: JSON.stringify({
                    images: images,
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                   // Redirige al controlador que genera el PDF y pasa los nombres de las imágenes
            var pdfWindow = window.open('{{ url('/generar-pdfCompleto/') }}' + '/' + result.nombresImagenes.join(','), '_blank');

            // Espera un breve período y luego intenta eliminar las imágenes
            setTimeout(function() {
                // Envía una solicitud para eliminar las imágenes
                fetch('{{ url('/eliminar-imagenes2') }}', {
                    method: 'POST',
                    body: JSON.stringify({ nombresImagenes: result.nombresImagenes }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            }, 5000); // Espera 5 segundos, ajusta este valor según sea necesario

                            } else {
                                alert('Error al guardar las imágenes.');
                            }
                        })
                        .catch(error => {
                            alert('Error al guardar las imágenes: ' + error);
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
                            backgroundColor: ['#084D2B', '#D10808'],
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