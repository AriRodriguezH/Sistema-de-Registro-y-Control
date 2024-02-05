$('#archivos').on('change', function() {
    var nombresArchivos = '';
    var archivosSeleccionados = $(this)[0].files;
    for (var i = 0; i < archivosSeleccionados.length; i++) {
        nombresArchivos += archivosSeleccionados[i].name + '<br>';
    }
    $('#archivosSeleccionados').html(nombresArchivos);
    // Actualizar el texto del label con los nombres de los archivos seleccionados
    $(this).next('.custom-file-label').html(archivosSeleccionados.length + ' archivo(s) seleccionado(s)');
});