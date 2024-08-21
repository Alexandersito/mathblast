/*=============================================
Tabla Aulas
=============================================*/

// $.ajax({

//     "url":"ajax/tablaBanner.ajax.php",
//     success: function(respuesta){

//      console.log("respuesta", respuesta);

//     }

// })

$(".tablaAulas").DataTable({
  "ajax": "ajax/tablaAulas.ajax.php",
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
Editar Banner
=============================================*/

$(document).on("click", ".editarAula", function () {

  var idAula = $(this).attr("idAula");

  var datos = new FormData();
  datos.append("idAula", idAula);

  $.ajax({

    url: "ajax/aulas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      $('input[name="editarId"]').val(respuesta["id"]);
      $('input[name="editarNombre"]').val(respuesta["Aula"]);
      $('.editarPerfilOption').val(respuesta["id_profesor"]);
      $('.editarPerfilOption').html(respuesta["Profesor"]);

    }

  })

})

/*=============================================
Activar o desactivar aula
=============================================*/

$(document).on("click", ".btnActivarAula", function () {

  var idAula = $(this).attr("idAula");
  var estadoAula = $(this).attr("estadoAula");
  var boton = $(this);

  var datos = new FormData();
  datos.append("idAulas", idAula);
  datos.append("estadoAula", estadoAula);

  $.ajax({

    url: "ajax/aulas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      console.log(respuesta)

      if (respuesta == "ok") {

        if (estadoAula == 0) {

          $(boton).removeClass('btn-info');
          $(boton).addClass('btn-dark');
          $(boton).html('Desactivado');
          $(boton).attr('estadoAula', 1);

        } else {

          $(boton).addClass('btn-info');
          $(boton).removeClass('btn-dark');
          $(boton).html('Activado');
          $(boton).attr('estadoAula', 0);

        }

      }

    }

  })

})

/*=============================================
Eliminar Banner
=============================================*/

$(document).on("click", ".eliminarAula", function () {

  var idAula = $(this).attr("idAula");

  swal({
    title: '¿Está seguro de eliminar este aula?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, eliminar aula!'
  }).then(function (result) {

    if (result.value) {

      var datos = new FormData();
      datos.append("idEliminar", idAula);

      $.ajax({

        url: "ajax/aulas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          console.log(respuesta)


          if (respuesta == "ok") {
            swal({
              type: "success",
              title: "¡CORRECTO!",
              text: "El aula ha sido borrado correctamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
            }).then(function (result) {

              window.location = "aulas";

            })

          }

        }

      })

    }

  })

})


