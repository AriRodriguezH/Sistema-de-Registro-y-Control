document.addEventListener('DOMContentLoaded', function () {
    // Escucha el evento 'change' en el campo de archivo con id 'archivos'
    document.getElementById('archivos').addEventListener('change', function () {
        validarArchivos();
    });

    function validarArchivos() {
        const inputField = document.getElementById('archivos');
        const errorAlert = document.getElementById('archivos_error');
        const files = inputField.files;
        const validExtensions = ['.pdf', '.doc', '.docx', '.xlsx'];
        let isValid = true;

        // Verifica archivos en 'archivos'
        for (const file of files) {
            if (file) { // Verifica si se seleccionó algún archivo
                const extension = '.' + file.name.split('.').pop().toLowerCase();
                if (!validExtensions.includes(extension)) {
                    isValid = false;
                    break; // Sale del bucle si encuentra un archivo no válido
                }
            }
        }

        // Muestra u oculta la alerta de error según la validación
        errorAlert.style.display = isValid ? 'none' : 'block';

        // Habilita o deshabilita el botón de 'Guardar cambios' basado en la validación de archivos
        const editarRespuestaBtn = document.getElementById('editar-respuesta-btn');
        editarRespuestaBtn.disabled = !isValid;
    }
});