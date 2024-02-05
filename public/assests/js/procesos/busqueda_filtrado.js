$(document).ready(function() {

    function sortAsc() {
    const cards = $('.card-container .card');
    cards.sort(function (cardA, cardB) {
    const yearA = parseInt($(cardA).find('.card-header').text().trim());
    const yearB = parseInt($(cardB).find('.card-header').text().trim());
    return yearB - yearA;
});

// Limpiamos el contenido del contenedor antes de agregar las tarjetas ordenadas
$('.card-container').empty();

// Agregamos las tarjetas ordenadas una por una al contenedor
cards.each(function () {
    $(this).removeClass('maximize-card'); // Restablecer tamaño original
    $('.card-container').append($(this));
});
}

function sortDesc() {
const cards = $('.card-container .card');
cards.sort(function (cardA, cardB) {
    const yearA = parseInt($(cardA).find('.card-header').text().trim());
    const yearB = parseInt($(cardB).find('.card-header').text().trim());
    return yearA - yearB;
});

// Limpiamos el contenido del contenedor antes de agregar las tarjetas ordenadas
$('.card-container').empty();

// Agregamos las tarjetas ordenadas una por una al contenedor
cards.each(function () {
    $(this).removeClass('maximize-card'); // Restablecer tamaño original
    $('.card-container').append($(this));
});
}


        $('#sortAscBtn').on('click', function() {
            sortAsc();
        });

        $('#sortDescBtn').on('click', function() {
            sortDesc();
        });

        $('#searchYear').on('keypress', function(event) {
            // Obtener el código ASCII del carácter ingresado
            var charCode = event.which ? event.which : event.keyCode;

            // Permitir solo números (códigos ASCII del 48 al 57)
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        });

        $('#searchYear').on('keyup', function() {
            var searchYear = $(this).val();
            // Ocultar el mensaje de error "Sin resultados"
            $('#noResults').hide();

            // Verificar si el valor es un número
            if ($.isNumeric(parseFloat(searchYear))) {
                var noResultsFound = true; // Variable para rastrear si se encontraron resultados
                $('.card').each(function() {
                    var cardYear = $(this).find('.card-header').text().trim();
                    if (cardYear.includes(searchYear)) {
                        $(this).show();
                        noResultsFound = false;
                    } else {
                        $(this).hide();
                    }
                });

                // Mostrar el mensaje "Sin resultados" solo si no se encontraron coincidencias
                $('#noResults').toggle(noResultsFound);
            } else if (searchYear === '') {
                // Si el campo está vacío, mostrar todas las cartas nuevamente
                $('.card').show();
            } else {
                // Si el valor ingresado no es un número, ocultar todas las tarjetas y mostrar el mensaje "Sin resultados"
                $('#noResults').show();
                $('.card').hide();
            }
        });
    });