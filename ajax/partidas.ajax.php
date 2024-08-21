<?php

require_once "../modelos/partidas.modelo.php";

class AjaxPartidas {

    public $idAlumno;
    public $idJuego;
    public $puntajeJuego;
    public $mmr_cambio;

    public function ajaxInsertarPartida() {

        $idAlumno = $this->idAlumno;
        $idJuego = $this->idJuego;
        $puntajeJuego = $this->puntajeJuego;
        $mmr_cambio = $this->mmr_cambio;

        $respuesta = ModeloPartida::mdlInsertarPartida($idAlumno, $idJuego, $puntajeJuego, $mmr_cambio);

        echo json_encode($respuesta);

    }

}

if(isset($_POST["idAlumno"]) && isset($_POST["idJuego"])) {
    $partida = new AjaxPartidas();
    $partida->idAlumno = $_POST["idAlumno"];
    $partida->idJuego = $_POST["idJuego"];
    $partida->puntajeJuego = $_POST["puntajeJuego"];
    $partida->mmr_cambio = $_POST["mmr_cambio"];
    $partida->ajaxInsertarPartida();
}