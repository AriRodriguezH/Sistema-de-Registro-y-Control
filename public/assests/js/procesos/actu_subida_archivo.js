// Actualizar etiqueta de archivo al seleccionar archivos
$('#archivos_0').on('change', function() {
    var fileList = $(this)[0].files;
    var labelText = fileList.length > 1 ? fileList.length + ' archivos seleccionados' : fileList[0].name;
    $(this).next('.custom-file-label').html(labelText);
});



// Actualizar etiqueta de archivo al seleccionar archivos
$(document).ready(function() {
    // Actualizar etiqueta de archivo al seleccionar archivos
    $('input[type="file"]').change(function(e) {
        var fileList = e.target.files;
        var label = $(this).siblings('.custom-file-label');
        var labelText = fileList.length > 1 ? fileList.length + ' archivos seleccionados' : fileList[0].name;
        label.text(labelText);
    });
});