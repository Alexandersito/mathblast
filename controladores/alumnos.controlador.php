<?php

Class ControladorAlumnos{

	static public function ctrMostrarAlumno($item, $valor){

		$tabla = "alumno";

		$respuesta = ModeloAlumnos::mdlMostrarAlumno($tabla, $item, $valor);

		return $respuesta;

	}

    /*=============================================
	INGRESO DE alumno DIRECTO
	=============================================*/

	public function ctrIngresoAlumno(){

		if(isset($_POST["ingresoAlumno"])){

			 if(strlen($_POST["ingresoAlumno"]) < 4 && 
             preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingresoPassword"])){

    			// $encriptarPassword = crypt($_POST["ingresoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$encriptarPassword = password_hash($_POST["ingresoPassword"], PASSWORD_BCRYPT);

    			$numero_orden = $_POST["ingresoAlumno"];
    			$seccion = $_POST["seccionAlumno"];

                $respuesta = ModeloAlumnos::validarIngreso($numero_orden,$seccion);

    			if ($respuesta) {

					if(password_verify($_POST["ingresoPassword"], $respuesta["password"])){

						$_SESSION["validarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id_alumno"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["apellidos"] = $respuesta["apellidos"];
						$_SESSION["img"] = $respuesta["img"];
						$_SESSION["numero_orden"] = $respuesta["numero_orden"];
	
						$ruta = ControladorRuta::ctrRuta();
	
						echo '<script>
					
							window.location = "'.$ruta.'";				
	
						</script>';
	
					}else{
	
					echo'<script>
	
						swal({
								type:"error",
								  title: "¡ERROR!",
								  text: "¡Contraseña Incorrecta!",
								  showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){
							history.back();
						});
	
					</script>';
	
				   }
				   
				}else{
	
					echo'<script>
	
						swal({
								type:"error",
								  title: "¡ERROR!",
								  text: "¡Ese número de orden y/o sección no existe!",
								  showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){
							history.back();
						});
	
					</script>';
	
				   }

			}else{

				echo'<script>

					swal({
							type:"error",
						  	title: "¡CORREGIR!",
						  	text: "¡No se permiten caracteres especiales!",
						  	showConfirmButton: true,
							confirmButtonText: "Cerrar"
						  
					}).then(function(result){
						history.back();
					});

				</script>';
			}

		}

	}
    
	/*=============================================
	MMR DE LOS ALUMNOS
	=============================================*/

	static public function ctrMostrarMMR(){

		$respuesta = ModeloAlumnos::mdlMostrarMRR();

		return $respuesta;

	}
}