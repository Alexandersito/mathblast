var bloquearJuego = 1;

$(".game").click(function (e) {
    e.preventDefault();

    var id = $(this).attr("data-id");

    /*=============================================
    AJAX
    =============================================*/
    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: urlPrincipal + "ajax/juegos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {

            console.log(respuesta.estado)
            bloquearJuego = respuesta.estado
            bloquearPlay(bloquearJuego, respuesta.estado)

            // Capturar los elementos por su ID
            var modalImg = $('#modal-img');
            var modalTitle = $('#modal-title');
            var modalDescription = $('#modal-description');
            var rutaGame = $('#ruta-game');
            var rutaRecursos = $('#ruta-recursos');

            // Ejemplo de cómo cambiar sus propiedades
            modalImg.attr('src', respuesta.img);
            modalTitle.text(respuesta.tema);
            modalDescription.text(respuesta.descripcion);


            var realRuta = convertirAUrlAmigable(respuesta.tema)
            rutaGame.attr('href', urlPrincipal + realRuta.toLowerCase());

            rutaRecursos.attr('href', urlPrincipal + convertirAUrlAmigable(respuesta.nombre));

            return bloquearJuego

        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });

    // ===========================================================================

    document.getElementById('overlay').style.display = 'flex';

    document.getElementById('overlay').addEventListener('click', function (event) {
        if (event.target === this) {
            document.getElementById('overlay').style.display = 'none';
        }
    });
});

function bloquearPlay(bloquearJuego, estado) {
    bloquearJuego = estado
}

$("#ruta-game").click(function (e) {

    if (bloquearJuego == 0) {

        console.log("DESACTIVADO")
        e.preventDefault();
        swal({
            type: "error",
            title: "¡ERROR!",
            text: "¡El juego esta en actualización o mantenimiento!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"

        })

    } else {
        console.log("ACTIVADO")
    }

})


