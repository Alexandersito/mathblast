<?php

class ControladorAlumnos{

    /*=============================================
	Mostrar Alumnos
	=============================================*/

	static public function ctrMostrarAlumnos($id){

		$respuesta = ModeloAlumnos::mdlMostrarAlumnos($id);

		return $respuesta;

	}

	/*=============================================
	Registro de Alumno
	=============================================*/

	public function ctrRegistroAlumno(){

		if(isset($_POST["registroNombre"]) && isset($_POST["profesorId"])){

			$numeroRepetido = ModeloAlumnos::mdlMostrarAlumnos($_POST["profesorId"]);
			$numeroOrdenRepetido = false;

			foreach ($numeroRepetido as $alumno) {
				if ($alumno["numero_orden"] == $_POST["registroNumeroOrden"]) {
					$numeroOrdenRepetido = true;
					break;
				}
			}

			if ($numeroOrdenRepetido) {
				
				echo'<script>

							swal({
									type:"error",
									title: "ERROR!",
									text: "Número de orden repetido",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
							}).then(function(result){
										window.location = "alumnos";
							});

						</script>';
				
			} else {

				if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["registroNombre"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroNumeroOrden"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroPassword"])){

					// $encriptarPassword = crypt($_POST["registroPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$encriptarPassword = password_hash($_POST["registroPassword"], PASSWORD_BCRYPT);


					$datos = array("nombre" => $_POST["registroNombre"],
								"apellidos" => $_POST["registroApellidos"],
								"numero_orden" =>  $_POST["registroNumeroOrden"],
								"password" => $encriptarPassword,
								"img" => $_POST["registroImg"],
								"aula" => $_POST["aulaId"]);

					
					$respuesta = ModeloAlumnos::mdlRegistroAlumnos($datos);
					
					if($respuesta == "ok"){

						echo'<script>

							swal({
									type:"success",
									title: "¡CORRECTO!",
									text: "El alumno ha sido creado correctamente",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
							}).then(function(result){
										window.location = "alumnos";
							});

						</script>';

					}


				}else{

					echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
				}

			}

		}

	}

	/*=============================================
	editar de Alumno
	=============================================*/

	public function ctrEditarAlumno(){

		if(isset($_POST["editarNombre"])){

			$numeroRepetido = ModeloAlumnos::mdlMostrarAlumnos($_POST["profesorId"]);
			$numeroOrdenRepetido = false;

			foreach ($numeroRepetido as $alumno) {
				if ($alumno["numero_orden"] == $_POST["editarNumeroOrden"] && $alumno["id"] != $_POST["editarId"]) {
					$numeroOrdenRepetido = true;
					break;
				}
			}

			if ($numeroOrdenRepetido) {
				
				echo'<script>

							swal({
									type:"error",
									title: "ERROR!",
									text: "Número de orden repetido",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
							}).then(function(result){
										window.location = "alumnos";
							});

						</script>';
				
			}else{

				if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["editarNombre"])){

					if($_POST["editarPassword"] == ""){
 
					 $password = $_POST["passwordActual"];
 
					}else{
 
					 if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){
 
						 // $password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');  	
					  $password = password_hash($_POST["editarPassword"], PASSWORD_BCRYPT);
					  // $password = $_POST["editarPassword"];  		
 
					 }else{
 
						 echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
 
						 return;
 
					 }
					}
 
				 $datos = array("id"=> $_POST["editarId"],
								"nombre" => $_POST["editarNombre"],
								"apellidos" => $_POST["editarApellidos"],
								"numero_orden" =>  $_POST["editarNumeroOrden"],
								"password" => $password);
 
				 $respuesta = ModeloAlumnos::mdlEditarAlumno($datos);
				 
				 if($respuesta == "ok"){
 
					 echo'<script>
 
						 swal({
								 type:"success",
								   title: "¡CORRECTO!",
								   text: "El alumno ha sido editado correctamente",
								   showConfirmButton: true,
								 confirmButtonText: "Cerrar"
							   
						 }).then(function(result){
							 window.location = "alumnos";
						 });
 
					 </script>';
 
				 }
 
 
			 }else{
 
				 echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
			 }

			}

			

		}
	
	}
	

	/*=============================================
	Eliminar alumno
	=============================================*/

	static public function ctrEliminarAlumno($id){

		$tabla = "alumno";

		$respuesta = ModeloAlumnos::mdlEliminarAlumno($tabla, $id);

		return $respuesta;

	}

	/*=============================================
	agregar partida
	=============================================*/

	static public function ctrAgregarPartida(){

		if(isset($_POST['alumnoId']) && isset($_POST['registroJuego']) && isset($_POST['registroPuntaje'])){
	
			$registroPuntaje = $_POST['registroPuntaje'];
			$mmr = self::logMMR($registroPuntaje);

			if ($mmr == 0) {
				
				echo'<script>

				swal({
						type:"error",
						  title: "ERROR DE PUNTAJE!",
						  text: "El parece que no pusiste bien el puntaje, por favor revisa bien el puntaje",
						  showConfirmButton: true,
						confirmButtonText: "Cerrar"
					  
					}).then(function(result){
						window.location = "alumnos";
					});

				</script>';

			}else{

				$datos = array(
					"alumnoId" => $_POST['alumnoId'],
					"registroJuego" => $_POST['registroJuego'],
					"registroPuntaje" => $registroPuntaje,
					"mmr" => $mmr
				);
		
				$respuesta = ModeloAlumnos::mdlAgregarPartida($datos);
		
				if($respuesta == "ok"){
	 
					echo'<script>
	
						swal({
								type:"success",
								  title: "¡CORRECTO!",
								  text: "Se ha agregado la partida correctamente",
								  showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){
							window.location = "alumnos";
						});
	
					</script>';
	
				}

			}
	
			
	
		} else {
			return "error";
		}
	}
	

	static public function logMMR($puntaje) {
		if ($puntaje >= 100) {
			$centena = floor($puntaje / 100) * 100;
			return $centena / 10;
		} elseif ($puntaje <= -100) {
			$centena = ceil($puntaje / 100) * 100;
			return $centena / 10;
		} else {
			return 0;
		}
	}
	
	

}