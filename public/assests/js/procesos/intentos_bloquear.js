var checkboxEstado = document.getElementById('estado');
var inputIntentos = document.getElementById('intentos');

checkboxEstado.addEventListener('change', function() {
    inputIntentos.value = this.checked ? 3 : 0;
});