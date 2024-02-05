// Función para generar colores de forma dinámica
function generarColor(opacidad) {
    
    var letras = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letras[Math.floor(Math.random() * 16)];
    }
    return color + opacidad;
}

// Generar una paleta de colores
var colores = [];
for (var i = 0; i < anios.length; i++) {
    colores.push(generarColor('99')); // Aquí '99' representa la opacidad del color, puedes ajustarlo si lo deseas
}

// Obtener el contexto del canvas para la gráfica
var ctx = document.getElementById('graficaDocumentacion').getContext('2d');
// Ajustar el tamaño del canvas al contenedor
var container = document.getElementById('graficaDocumentacion').parentElement;
var canvas = document.getElementById('graficaDocumentacion');

canvas.width = container.clientWidth;
canvas.height = container.clientHeight;

// Crear la gráfica de dona
var graficaDocumentacion = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: anios,
        datasets: [{
            data: porcentajes,
            backgroundColor: colores,
            borderColor: colores,
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: false, // Establecer maintainAspectRatio en false
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        var label = context.label || '';

                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            var anio = anios[context.dataIndex];
                            var totalDocumentaciones = completas[context.dataIndex] + incompletas[context.dataIndex];
                            label += completas[context.dataIndex] + ' documentación(es) completa(s) de ' + totalDocumentaciones + ' entregadas en ' + anio;
                        }
                        return label;
                    },
                    afterLabel: function (context) {
                        var porcentaje = porcentajes[context.dataIndex];
                        if (Number.isInteger(porcentaje)) {
                            porcentaje = porcentaje.toFixed(0);
                        } else {
                            porcentaje = porcentaje.toFixed(2);
                        }
                        porcentaje += '%';
                        return 'Porcentaje: ' + porcentaje;
                    }
                }
            }
        }
    }
});
