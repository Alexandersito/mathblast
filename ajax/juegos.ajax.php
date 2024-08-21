<?php

require_once "../controladores/juegos.controlador.php";
require_once "../modelos/juegos.modelo.php";


class AjaxJuegos{

	public $id;
	public $idAlumno;

	public function ajaxTraerJuego(){

		$valor = $this->id;

		$respuesta = ControladorJuegos::ctrMostrarJuego($valor);

		echo json_encode($respuesta);

	}

	public function ajaxTraerEstadisticas(){

		$valor = $this->idAlumno;

		$respuesta = ModeloJuegos::mdlTraerEstadisticas($valor);

		echo json_encode($respuesta);

	}

}

if(isset($_POST["id"])){

	$id = new AjaxJuegos();
	$id -> id = $_POST["id"];
	$id -> ajaxTraerJuego();

}

if(isset($_POST["idAlumno"])){

	$idAlumno = new AjaxJuegos();
	$idAlumno -> idAlumno = $_POST["idAlumno"];
	$idAlumno -> ajaxTraerEstadisticas();

}