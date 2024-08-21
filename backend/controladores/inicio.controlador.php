<?php

class ControladorInicio{

    /*=============================================
	ANALITICAS
	=============================================*/

	static public function ctrAnaliticas(){

		$respuesta = ModeloInicio::mdlAnaliticas();
		
		return $respuesta;

	}

    static public function ctrPromedioAula(){

		$respuesta = ModeloInicio::mdlPromedioAula();
		
		return $respuesta;

	}

    static public function ctrTopAlumnos(){

		$respuesta = ModeloInicio::mdlTopAlumnos();
		
		return $respuesta;

	}

}