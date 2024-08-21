<?php

class ControladorAdministradores{

	/*=============================================
	Ingreso Administradores
	=============================================*/

	public function ctrIngresoAdministradores(){

		if(isset($_POST["ingresoUsuario"])){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingresoUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingresoPassword"])){

			   	$encriptarPassword = crypt($_POST["ingresoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			   	$tabla = "profesor";
			    $item = "usuario";
			    $valor = $_POST["ingresoUsuario"];

				$respuesta = ModeloAdministradores::mdlMostrarAdministradores($tabla, $item, $valor);
				
				if($respuesta["usuario"] == $_POST["ingresoUsuario"] && $respuesta["password"] == $encriptarPassword){

					if($respuesta["estado"] == 1){

						$_SESSION["validarSesionBackend"] = "ok";
				 		$_SESSION["idBackend"] = $respuesta["id"];

				 		echo '<script>

							window.location = "inicio";

				 		</script>';

			 		}else{

			 			echo "<div class='alert alert-danger mt-3 small'>ERROR: El usuario está desactivado</div>";

			 		}

				}else{

					echo "<div class='alert alert-danger mt-3 small'>ERROR: Usuario y/o contraseña incorrectos</div>";
				}	

			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";

			}

		}

	}

	/*=============================================
	Mostrar Administradores
	=============================================*/

	static public function ctrMostrarAdministradores($item, $valor){

		$tabla = "profesor";

		$respuesta = ModeloAdministradores::mdlMostrarAdministradores($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	Registro de administrador
	=============================================*/

	public function ctrRegistroAdministrador(){

		if(isset($_POST["registroNombre"])){

			if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["registroNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroPassword"])){

			   	$encriptarPassword = crypt($_POST["registroPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array("dni" => $_POST["registroDni"],
							   "nombre" => $_POST["registroNombre"],
							   "apellidos" => $_POST["registroApellidos"],
							   "usuario" =>  $_POST["registroUsuario"],
							   "password" => $encriptarPassword,
							   "cargo" => $_POST["registroCargo"]);

				
				$respuesta = ModeloAdministradores::mdlRegistroAdministradores($datos);
				
				if($respuesta == "ok"){

					echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "El administrador ha sido creado correctamente",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
						}).then(function(result){
								    window.location = "administradores";
						});

					</script>';

				}


			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
			}

		}


	}

	/*=============================================
	Editar administrador
	=============================================*/

	public function ctrEditarAdministrador(){

		if(isset($_POST["editarNombre"])){

			if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["editarNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarUsuario"])){

			   	if($_POST["editarPassword"] != ""){

			   		if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

			   			$password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');  			

			   		}else{

			   			echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";

			   			return;

			   		}

			   	}else{

			   		$password = $_POST["passwordActual"];
			   	}

				$datos = array("id"=> $_POST["editarId"],
							   "dni" => $_POST["editarDni"],
							   "nombre" => $_POST["editarNombre"],
							   "apellidos" => $_POST["editarApellidos"],
							   "usuario" =>  $_POST["editarUsuario"],
							   "password" => $password,
							   "cargo" => $_POST["editarCargo"]);

				$respuesta = ModeloAdministradores::mdlEditarAdministrador($datos);
				
				if($respuesta == "ok"){

					echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "El administrador ha sido editado correctamente",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){
							window.location = "administradores";
						});

					</script>';

				}


			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
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