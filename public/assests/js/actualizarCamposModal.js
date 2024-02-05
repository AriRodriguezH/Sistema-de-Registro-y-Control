$(document).ready(function() {
    // Función para validar y actualizar los campos "Cumplimiento" y "Estado de la Documentación"
    function actualizarCampos(porcentajeCumplimiento, cumplimientoElement, estadoDocumentacionElement) {
        if (porcentajeCumplimiento >= 75) {
            cumplimientoElement.val("Si");
            estadoDocumentacionElement.val("Concluido");
        } else {
            cumplimientoElement.val("No");
            estadoDocumentacionElement.val("Faltante");
        }
    }

    // Manejar el evento de cambio en el campo "Porcentaje de Cumplimiento"
    $('#porcentajeCumplimientoInputCrear, #porcentajeCumplimientoInputEditar').on('input', function() {
        var inputText = $(this).val();
        var sanitizedInput = inputText.replace(/[^\d]/g, ''); // Mantener solo dígitos
        $(this).val(sanitizedInput); // Actualizar el valor del campo con la entrada validada

        var porcentajeCumplimiento = parseInt(sanitizedInput, 10);
        var cumplimientoElement = $(this).closest('.modal-content').find('#cumplimientoSelectCrear, #cumplimientoSelectEditar');
        var estadoDocumentacionElement = $(this).closest('.modal-content').find('#estadoDocumentacionSelectCrear, #estadoDocumentacionSelectEditar');

        actualizarCampos(porcentajeCumplimiento, cumplimientoElement, estadoDocumentacionElement);
    });

    // Inicialización para establecer los valores iniciales al cargar la página
    $('#porcentajeCumplimientoInputCrear, #porcentajeCumplimientoInputEditar').each(function() {
        var porcentajeCumplimiento = parseInt($(this).val(), 10);
        var cumplimientoElement = $(this).closest('.modal-content').find('#cumplimientoSelectCrear, #cumplimientoSelectEditar');
        var estadoDocumentacionElement = $(this).closest('.modal-content').find('#estadoDocumentacionSelectCrear, #estadoDocumentacionSelectEditar');

        actualizarCampos(porcentajeCumplimiento, cumplimientoElement, estadoDocumentacionElement);
    });
});
