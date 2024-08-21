/*=============================================
Tabla Administradores
=============================================*/
// $.ajax({

// 	"url":"ajax/tablaAdministradores.ajax.php",
// 	success: function(respuesta){

// 		console.log("respuesta", respuesta);

// 	}

// })

var idBackend = $("#idBackend").val();

$(".tablaAlumnos").DataTable({
    "ajax": {
        "url": "ajax/tablaAlumnos.ajax.php",
        "type": "POST", // Cambia el método a POST
        "data": function (d) {
            // Añade el parámetro idBackend a los datos que se envían
            d.idBackend = idBackend;
        }
    },
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language": {

        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_",
        "sInfoEmpty": "Mostrando registros del 0 al 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

    }

});

/*=============================================
Editar alumno
=============================================*/

$(document).on("click", ".editarAlumno", function () {

    var idAlumno = $(this).attr("idAlumno");

    var datos = new FormData();
    datos.append("idAlumno", idAlumno);

    $.ajax({
        url: "ajax/alumnos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta)

            $('input[name="editarId"]').val(respuesta["id"]);
            $('input[name="editarNombre"]').val(respuesta["nombre"]);
            $('input[name="editarApellidos"]').val(respuesta["apellidos"]);
            $('input[name="editarNumeroOrden"]').val(respuesta["numero_orden"]);
            $('input[name="passwordActual"]').val(respuesta["password"]);

        }

    })

})

/*=============================================
Eliminar Administrador
=============================================*/

$(document).on("click", ".eliminarAlumno", function () {

    var idAlumno = $(this).attr("idAlumno");

    swal({
        title: '¿Está seguro de eliminar este alumno?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar alumno!'
    }).then(function (result) {

        if (result.value) {

            var datos = new FormData();
            datos.append("idEliminar", idAlumno);

            $.ajax({

                url: "ajax/alumnos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {

                    if (respuesta == "ok") {

                        swal({
                            type: "success",
                            title: "¡CORRECTO!",
                            text: "El alumno ha sido borrado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then(function (result) {

                            window.location = "alumnos";

                        })

                    }

                }

            })

        }

    })

})

/*=============================================
agregar partida
=============================================*/

$(document).on("click", ".crearPartida", function () {

    var idAlumno = $(this).attr("idAlumno");

    var datos = new FormData();
    datos.append("idAlumno", idAlumno);

    $.ajax({
        url: "ajax/alumnos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {

            $('input[name="alumnoId"]').val(respuesta["id"]);
            $('input[name="paraAlumno"]').val(respuesta["nombre"] + " " + respuesta["apellidos"]);

        }

    })

})