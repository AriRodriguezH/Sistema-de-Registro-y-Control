$(document).ready(function() {
    @foreach($publicacion->documentacion->groupBy('semestre') as $semestre => $documentaciones)
    @foreach($documentaciones as $documentacion)
    @foreach($documentacion->usuarios as $usuario)
    @php
    $respuesta = $documentacion->respuestas->where('users_id', $usuario->id)->first();
    $calificacion = $respuesta ? $respuesta->calificacion : null;
    @endphp

    @if($calificacion)
    var donutData{{ $calificacion->id }} = {
        labels: ['Cumplimiento', 'Faltante'],
        datasets: [{
            data: [{{ $calificacion->porcentajeCumplimiento }}, {{ 100 - $calificacion->porcentajeCumplimiento }}],
            backgroundColor: ['{{ $calificacion->porcentajeCumplimiento >= 50 ? 'rgba(0, 255, 35, 100)' : 'red' }}', 'rgba(237, 237, 237, 93)']
        }]
    };

    var donutOptions{{ $calificacion->id }} = {
        responsive: true,
        cutoutPercentage: 40,
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var currentValue = dataset.data[tooltipItem.index];
                    return currentValue + '%';
                }
            }
        }
    };

    var donutChart{{ $calificacion->id }} = new Chart(document.getElementById('donutChart{{ $calificacion->id }}'), {
        type: 'doughnut',
        data: donutData{{ $calificacion->id }},
        options: donutOptions{{ $calificacion->id }}
    });
    @endif
    @endforeach
    @endforeach
    @endforeach
});