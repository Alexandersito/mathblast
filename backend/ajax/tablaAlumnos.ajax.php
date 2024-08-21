<?php 

require_once "../controladores/alumnos.controlador.php";
require_once "../modelos/alumnos.modelo.php";

require_once "../controladores/ruta.controlador.php";

class TablaAlumno{

	/*=============================================
	Tabla Administradores
	=============================================*/ 

	public function mostrarTabla(){

		$respuesta = ControladorAlumnos::ctrMostrarAlumnos($_POST['idBackend']);
		$ruta = ControladorRuta::ctrRuta();
		$rutaBackend = ControladorRuta::ctrRutaBackend();

		if(count($respuesta) == 0){

			$datosJson = '{"data":[]}';

			echo $datosJson;

			return;

		}

		$datosJson = '{
	
		"data":[';

		foreach ($respuesta as $key => $value) {

		 // Crear la URL amigable
		 $urlAmigable = convertirAUrlAmigable($value["nombre"]." ".$value["apellidos"]);
    
		 // Crear la variable con el HTML de la imagen
		 $imagen = "<a href='".$ruta.$urlAmigable.$value["id"]."' target='_blank'><img src='".$value["img"]."' class='img-thumbnail' width='40px'></a>";
			
		$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarAlumno' data-toggle='modal' data-target='#editarAlumno' idAlumno='".$value["id"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarAlumno' idAlumno='".$value["id"]."'><i class='fas fa-trash-alt'></i></button></div>";

		$partida = "<button class='btn btn-primary w-100 btn-sm crearPartida' data-toggle='modal' data-target='#crearPartida' idAlumno='".$value["id"]."'><i class='fas fa-plus text-white'></i></button>";
		
		$datosJson .='[
				      "'.($key+1).'",
					  "'.$imagen.'", 
					  "'.$value["nombre"].'",
					  "'.$value["apellidos"].'",
				      "'.$value["numero_orden"].'",
                      "'.$value["mmr_global"].'",
				      "'.$value["aula"].'",
                      "'.$partida.'",
				      "'.$acciones.'"
				    ],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .= ']}';


		echo $datosJson;

	}

}

function convertirAUrlAmigable($cadena) {
	// Convertir a minúsculas
	$cadena = strtolower($cadena);

	// Reemplazar caracteres acentuados por sus equivalentes sin tilde
	$cadena = strtr($cadena, [
		'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
		'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
		'ñ' => 'n', 'Ñ' => 'n'
	]);

	// Reemplazar espacios por guiones
	$cadena = str_replace(' ', '-', $cadena);

	return $cadena;
}

/*=============================================
Tabla Administradores
=============================================*/ 

$tabla = new TablaAlumno();
$tabla -> mostrarTabla();