<?php

require_once "../controladores/chat.controlador.php";
require_once "../modelos/chat.modelo.php";

class AjaxChat {

    public $idAlumno;
    public $chatInput;

    public function ajaxInsertarChat() {
        $idAlumno = $this->idAlumno;
        $chatInput = $this->chatInput;

        $respuesta = ModeloChat::mdlInsertarChat($idAlumno, $chatInput);

        echo json_encode($respuesta);
    }

    public function ajaxActualizarChat() {

        $respuesta = ModeloChat::mdlMostrarChat();

        echo json_encode($respuesta);
    }

}

if(isset($_POST["idAlumno"]) && isset($_POST["chatInput"])) {
    $chat = new AjaxChat();
    $chat->idAlumno = $_POST["idAlumno"];
    $chat->chatInput = $_POST["chatInput"];
    $chat->ajaxInsertarChat();
}

if(isset($_POST["actualizarChat"])) {
    $actualizar = new AjaxChat();
    $actualizar->ajaxActualizarChat();
}