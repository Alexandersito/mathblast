<?php

Class ControladorChat{

	static public function ctrMostrarChat(){

		$respuesta = ModeloChat::mdlMostrarChat();

		return $respuesta;

	}

}