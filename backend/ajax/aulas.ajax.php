<?php

require_once "../controladores/aulas.controlador.php";
require_once "../modelos/aulas.modelo.php";

class AjaxAulas{

	/*=============================================
	Editar Aulas
	=============================================*/	

	public $idAula;

	public function ajaxMostrarAulas(){

		$valor = $this->idAula;

		$respuesta = ModeloAulas::mdlMostrarAulas($valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	Activar o desactivar administrador
	=============================================*/	

	public $idAulas;
	public $estadoAula;

	public function ajaxActivarAula(){

		$tabla = "aula_anio";

		$item1 = "id";
		$valor1 = $this->idAulas;

		$item2 = "activo";
		$valor2 = $this->estadoAula;

		$respuesta = ModeloAulas::mdlActualizarAula($tabla, $item1, $valor1, $item2, $valor2);

		echo $respuesta;

	}

	/*=============================================
	Eliminar aula
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarAula(){

		$respuesta = ModeloAulas::mdlEliminarAula($this->idEliminar);

		echo $respuesta;

	}

}

/*=============================================
Editar aula
=============================================*/
if(isset($_POST["idAula"])){

	$editar = new AjaxAulas();
	$editar -> idAula = $_POST["idAula"];
	$editar -> ajaxMostrarAulas();

}

/*=============================================
Activar o desactivar aula
=============================================*/	

if(isset($_POST["estadoAula"])){

	$activarAula = new AjaxAulas();
	$activarAula -> idAulas = $_POST["idAulas"];
	$activarAula -> estadoAula = $_POST["estadoAula"];
	$activarAula -> ajaxActivarAula();

}

/*=============================================
Eliminar aula
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxAulas();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarAula();

}