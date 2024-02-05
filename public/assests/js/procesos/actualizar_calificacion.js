// Actualizar los valores de los campos ocultos cuando se hace clic en el enlace "Calificar respuesta"
$(document).ready(function() {
    //ligación a la ventana modal calificarRespuestaModal
    $('#calificarRespuestaModal').on('show.bs.modal', function(event) {
        //obtiene el elemento que desencadenó la apertura del modal, luego el elemento se almacena en la variable link.
        var link = $(event.relatedTarget);

        //se intenta obtener el valor de un atributo de datos llamado respuesta-id
        var respuestaId = link.data('respuesta-id');

        //se intenta obtener el valor de un atributo de datos llamado usuario-id
        var usuarioId = link.data('usuario-id');

        /**Se selecciona un elemento con el ID respuestaIdInput y usuarioIdInput en la vista, despues
         *  se establece su valor utilizando el valor previamente obtenido en las variables*/
        $('#respuestaIdInput').val(respuestaId);
        $('#usuarioIdInput').val(usuarioId);
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // Definir la función para actualizar los campos "Cumplimiento" y "Estado de la Documentación"
    function actualizarCamposModal(modalSuffix) {
        var porcentajeInput = document.getElementById('porcentajeCumplimientoInput' + modalSuffix);
        var cumplimientoSelect = document.getElementById('cumplimientoSelect' + modalSuffix);
        var estadoDocumentacionSelect = document.getElementById('estadoDocumentacionSelect' + modalSuffix);

        var porcentaje = parseFloat(porcentajeInput.value);
        if (porcentaje >= 70) {
            cumplimientoSelect.value = 'Si';
            estadoDocumentacionSelect.value = 'Concluido';
        } else {
            cumplimientoSelect.value = 'No';
            estadoDocumentacionSelect.value = 'Faltante';
        }
    }

    // Escuchar cambios en el campo "Porcentaje de Cumplimiento" del modal de crear
    var porcentajeInputCrear = document.getElementById('porcentajeCumplimientoInputCrear');
    porcentajeInputCrear.addEventListener('input', function() {
        actualizarCamposModal('Crear');
    });

    // Escuchar cambios en el campo "Porcentaje de Cumplimiento" del modal de editar
    var porcentajeInputEditar = document.getElementById('porcentajeCumplimientoInputEditar');
    porcentajeInputEditar.addEventListener('input', function() {
        actualizarCamposModal('Editar');
    });

    // Llamar a la función para que los campos se actualicen al cargar el modal de crear
    actualizarCamposModal('Crear');

    // Llamar a la función para que los campos se actualicen al cargar el modal de editar
    actualizarCamposModal('Editar');
});
