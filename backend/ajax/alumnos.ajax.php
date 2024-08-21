<?php

require_once "../controladores/alumnos.controlador.php";
require_once "../modelos/alumnos.modelo.php";

class AjaxAlumnos{

	/*=============================================
	Editar alumno
	=============================================*/	

	public $idAlumno;

	public function ajaxMostrarAlumnos(){

		$valor = $this->idAlumno;

		$respuesta = ModeloAlumnos::mdlMostrarAlumno($valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	Activar o desactivar administrador
	=============================================*/	

	public $idAdmin;
	public $estadoAdmin;

	public function ajaxActivarAdministrador(){

		$tabla = "profesor";

		$item1 = "id";
		$valor1 = $this->idAdmin;

		$item2 = "estado";
		$valor2 = $this->estadoAdmin;

		$respuesta = ModeloAdministradores::mdlActualizarAdministrador($tabla, $item1, $valor1, $item2, $valor2);

		echo $respuesta;

	}

	/*=============================================
	Eliminar Administrador
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarAlumno(){

		$respuesta = ControladorAlumnos::ctrEliminarAlumno($this->idEliminar);

		echo $respuesta;

	}

}

/*=============================================
Editar Administrador
=============================================*/
if(isset($_POST["idAlumno"])){

	$editar = new AjaxAlumnos();
	$editar -> idAlumno = $_POST["idAlumno"];
	$editar -> ajaxMostrarAlumnos();

}

/*=============================================
Activar o desactivar administrador
=============================================*/	

if(isset($_POST["estadoAdmin"])){

	$activarAdmin = new AjaxAdministradores();
	$activarAdmin -> idAdmin = $_POST["idAdmin"];
	$activarAdmin -> estadoAdmin = $_POST["estadoAdmin"];
	$activarAdmin -> ajaxActivarAdministrador();

}

/*=============================================
Eliminar Administrador
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxAlumnos();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarAlumno();

}