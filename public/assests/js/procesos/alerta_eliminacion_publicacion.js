$('.delete-publication').click(function () {
    var publicacionId = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro de eliminar este año de publicación?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: '#0d6efd', // Color del botón "Sí, eliminar" a rojo (#dc3545)
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#dc3545', // Color del botón "CAncelar" a rojo (#dc3545)
        customClass: {
            confirmButton: 'btn btn-danger', // botón aceptar
            cancelButton: 'btn btn-primary' //  botón Cancelar
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, enviar el formulario de eliminación
            document.getElementById('delete-form-' + publicacionId).submit();
        }
    });
});