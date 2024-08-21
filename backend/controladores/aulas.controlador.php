<?php

class ControladorAulas{

	/*=============================================
	Mostrar Aulas
	=============================================*/

	static public function ctrMostrarAulas($id){

		$respuesta = ModeloAulas::mdlMostrarAulas($id);

		return $respuesta;

	}

	// =============================================*/
	// Crear Aula
	// =============================================*/

	static public function ctrCrearAula(){
        
        if(isset($_POST["registroNombre"]) && isset($_POST["registroProfesor"])){

            $nombre = $_POST["registroNombre"];
            $id_profesor = $_POST["registroProfesor"];

            $respuesta = ModeloAulas::mdlCrearAula($nombre, $id_profesor);

            if($respuesta == "ok"){
                echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "El aula ha sido creado correctamente",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
						}).then(function(result){
							window.location = "aulas";
						});

					</script>';
            } else {
                echo "<div class='alert alert-danger mt-3 small'>ERROR: Ingrese bien los datos</div>";
            }
        }
    }

	/*=============================================
	Editar aula
	=============================================*/

	public function ctrEditarAula(){

		if(isset($_POST["editarNombre"]) && isset($_POST["editarProfesor"])){

            $nombre = $_POST["editarNombre"];
            $id_profesor = $_POST["editarProfesor"];
			$idAula = $_POST["editarId"];

            $respuesta = ModeloAulas::mdlEditarAula($nombre, $id_profesor, $idAula);

            if($respuesta == "ok"){
                echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "El aula ha sido editado correctamente",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
						}).then(function(result){
							window.location = "aulas";
						});

					</script>';
            } else {
                echo "<div class='alert alert-danger mt-3 small'>ERROR: Ingrese bien los datos</div>";
            }
        }

	}

	/*=============================================
	Eliminar Administrador
	=============================================*/

	static public function ctrEliminarAdministrador($id){

		$tabla = "profesor";

		$respuesta = ModeloAdministradores::mdlEliminarAdministrador($tabla, $id);

		return $respuesta;

	}

}