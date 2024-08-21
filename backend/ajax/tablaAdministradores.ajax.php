<?php 


require_once "../controladores/administradores.controlador.php";
require_once "../modelos/administradores.modelo.php";

class TablaAdmin{

	/*=============================================
	Tabla Administradores
	=============================================*/ 

	public function mostrarTabla(){

		$respuesta = ControladorAdministradores::ctrMostrarAdministradores(null, null);

		if(count($respuesta) == 0){

			$datosJson = '{"data":[]}';

			echo $datosJson;

			return;

		}

		$datosJson = '{
	
		"data":[';

		foreach ($respuesta as $key => $value) {
			
			if($value["id"] != 1){

				if($value["estado"] == 0){

					$estado = "<button class='btn btn-dark btn-sm btnActivar' estadoAdmin='1' idAdmin='".$value["id"]."'>Desactivado</button>";

				}else{

					$estado = "<button class='btn btn-info btn-sm btnActivar' estadoAdmin='0' idAdmin='".$value["id"]."'>Activado</button>";
				}

			}else{

				$estado = "<button class='btn btn-info btn-sm'>Activado</button>";
			}


			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarAdministrador' data-toggle='modal' data-target='#editarAdministrador' idAdministrador='".$value["id"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarAdministrador' idAdministrador='".$value["id"]."'><i class='fas fa-trash-alt'></i></button></div>";
		
		$datosJson .='[
				      "'.($key+1).'",
				      "'.$value["dni"].'",
					  "'.$value["nombre"].'",
					  "'.$value["apellidos"].'",
				      "'.$value["usuario"].'",
				      "'.$value["cargo"].'",
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
Tabla Administradores
=============================================*/ 

$tabla = new TablaAdmin();
$tabla -> mostrarTabla();