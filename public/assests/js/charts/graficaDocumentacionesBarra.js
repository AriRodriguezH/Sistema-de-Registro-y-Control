
// Obtener el contexto del canvas para la gráfica de barras
var ctxBar = document.getElementById('barChart').getContext('2d');
// Ajustar el tamaño del canvas al contenedor
var containerBar = document.getElementById('barChart').parentElement;
var canvasBar = document.getElementById('barChart');

canvasBar.width = containerBar.clientWidth;
canvasBar.height = containerBar.clientHeight;

// Crear la gráfica de barras
var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: aniosBar,
        datasets: [
            {
                label: '1er Semestre',
                data: datosBarras.map(dato => dato.primerSemestre),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: '2do Semestre',
                data: datosBarras.map(dato => dato.segundoSemestre),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        maintainAspectRatio: false, // Establecer maintainAspectRatio en false
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function (value) {
                        return value.toLocaleString().replace(',', '.'); // Reemplazar comas por puntos
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        var formattedValue = context.formattedValue.replace(',', '.'); // Reemplazar comas por puntos
                        if (context.datasetIndex === 0) {
                            return 'Cumplimiento promedio 1er Semestre: ' + formattedValue;
                        } else {
                            return 'Cumplimiento promedio 2do Semestre: ' + formattedValue;
                        }
                    }
                }
            }
        }
    }
});

