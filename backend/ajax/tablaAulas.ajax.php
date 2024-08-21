<?php 


require_once "../controladores/aulas.controlador.php";
require_once "../modelos/aulas.modelo.php";

class TablaAula{

	/*=============================================
	Tabla Aula
	=============================================*/ 

	public function mostrarTabla(){

		$respuesta = ControladorAulas::ctrMostrarAulas(NULL);

		if(count($respuesta) == 0){

			$datosJson = '{"data":[]}';

			echo $datosJson;

			return;

		}

		$datosJson = '{
	
		"data":[';

		foreach ($respuesta as $key => $value) {
			

            if($value["Estado"] == 0){

                $estado = "<button class='btn btn-dark btn-sm btnActivarAula' estadoAula='1' idAula='".$value["id"]."'>Desactivado</button>";

            }else{

                $estado = "<button class='btn btn-info btn-sm btnActivarAula' estadoAula='0' idAula='".$value["id"]."'>Activado</button>";
            }

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarAula' data-toggle='modal' data-target='#editarAula' idAula='".$value["id"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarAula' idAula='".$value["id"]."'><i class='fas fa-trash-alt'></i></button></div>";
		
		$datosJson .='[
				      "'.($key+1).'",
				      "'.$value["Aula"].'",
					  "'.$value["Profesor"].'",
					  "'.$value["Alumnos"].'",
				      "'.$value["Anio"].'",
				      "'.$estado.'",
				      "'.$acciones.'"
				    ],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .= ']}';


		echo $datosJson;

	}

}

/*=============================================
Tabla Aula
=============================================*/ 

$tabla = new TablaAula();
$tabla -> mostrarTabla();