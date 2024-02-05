document.addEventListener("DOMContentLoaded", function() {
    
    var ctx = document.getElementById('graficaCumplimientoTodosProcesos').getContext('2d');

    var labels = years; // Utilizamos los años obtenidos

    var datasets = [];

    // Crear un dataset por cada conjunto de porcentajes de cumplimiento
    datosGrafica.forEach((dato, index) => {
        var datasetData = labels.map(anio => {
            var porcentajeTotal = dato.porcentajes[anio] ? dato.porcentajes[anio]['porcentajeTotal'] : 0;
            return porcentajeTotal;
        });

        datasets.push({
            label: dato.identificador,
            data: datasetData,
            borderColor: coloresProcesos[index], // Usamos el color correspondiente al proceso
            borderWidth: 2,
            pointRadius: 4, // Ajustamos el tamaño del punto en la línea
            fill: false,
            data_semestre1: labels.map(anio => {
                var semestre1 = dato.porcentajes[anio] ? dato.porcentajes[anio]['semestre1'] : 0;
                return semestre1;
            }),
            data_semestre2: labels.map(anio => {
                var semestre2 = dato.porcentajes[anio] ? dato.porcentajes[anio]['semestre2'] : 0;
                return semestre2;
            }),
        });
    });

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets,
        },
        options: {
            responsive: true, // La gráfica será responsiva
            maintainAspectRatio: false, // Mantendrá la relación de aspecto original
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Año',
                    },
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Porcentaje de Cumplimiento',
                    },
                    min: -5,
                    suggestedMax: 105, // Utiliza suggestedMax en lugar de max
                    ticks: {
                        stepSize: 10,
                        callback: function(value, index, values) {
                            return value >= 0 && value <= 100 ? value + '%' : ''; // Mostrar solo desde 0% hasta 100%
                        }
                    }
                }
            },
            layout: {
                padding: {
                    top: 30,
                    right: 30,
                    bottom: 30,
                    left: 30
                }
            },
            // Agregar la configuración regional para el formato de números
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null && !isNaN(context.parsed.y)) {
                                label += 'Porcentaje total: ' + new Intl.NumberFormat('en-US', { maximumFractionDigits: 3 }).format(context.parsed.y)+'%'+'\n'+'\n';
                            }

                            var semestre1 = context.dataset.data_semestre1[context.dataIndex];
                            var semestre2 = context.dataset.data_semestre2[context.dataIndex];
                            if (semestre1 !== undefined && semestre2 !== undefined) {
                                label += '\n'+'Semestre 1: ' + new Intl.NumberFormat('en-US', { maximumFractionDigits: 3 }).format(semestre1)+'%'+'\n'+'\n';
                                label += '\nSemestre 2: ' + new Intl.NumberFormat('en-US', { maximumFractionDigits: 3 }).format(semestre2)+'%'+'\n'+'\n';
                            }
                            return label;
                        },
                    },
                },
            },
        },
    });
});