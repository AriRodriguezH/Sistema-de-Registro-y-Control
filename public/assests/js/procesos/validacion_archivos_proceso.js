document.addEventListener('DOMContentLoaded', function () {
    // Habilita el botón de envío al cargar la página
    const enviarBtn = document.getElementById('enviar-btn');
    enviarBtn.disabled = false;

    // Escucha el evento 'change' en el campo de archivo con id 'archivos_0'
    document.getElementById('archivos_0').addEventListener('change', function () {
        validarArchivos();
    });

    // Escucha el evento 'change' en el campo de archivo con id 'archivos_1'
    document.getElementById('archivos_1').addEventListener('change', function () {
        validarArchivos();
    });

    function validarArchivos() {
        const inputField0 = document.getElementById('archivos_0');
        const inputField1 = document.getElementById('archivos_1');
        const errorAlert0 = document.getElementById('archivos_0_error');
        const errorAlert1 = document.getElementById('archivos_1_error');
        const files0 = inputField0.files;
        const files1 = inputField1.files;
        const validExtensions = ['.pdf', '.doc', '.docx', '.xls', '.xlsx'];
        let isValid0 = true;
        let isValid1 = true;

        // Verifica archivos en 'archivos_0'
        for (const file of files0) {
            if (file) { // Verifica si se seleccionó algún archivo
                const extension = '.' + file.name.split('.').pop().toLowerCase();
                if (!validExtensions.includes(extension)) {
                    isValid0 = false;
                    break; // Sale del bucle si encuentra un archivo no válido
                }
            }
        }

        // Verifica archivos en 'archivos_1'
        for (const file of files1) {
            if (file) { // Verifica si se seleccionó algún archivo
                const extension = '.' + file.name.split('.').pop().toLowerCase();
                if (!validExtensions.includes(extension)) {
                    isValid1 = false;
                    break; // Sale del bucle si encuentra un archivo no válido
                }
            }
        }

        // Muestra u oculta las alertas de error según la validación
        errorAlert0.style.display = isValid0 ? 'none' : 'block';
        errorAlert1.style.display = isValid1 ? 'none' : 'block';

        // Deshabilita el botón de envío si al menos uno de los campos tiene archivos no permitidos
        enviarBtn.disabled = !(isValid0 && isValid1);
    }
});