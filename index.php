<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/ruta.controlador.php";

require_once "controladores/juegos.controlador.php";
require_once "modelos/juegos.modelo.php";

require_once "controladores/alumnos.controlador.php";
require_once "modelos/alumnos.modelo.php";

require_once "controladores/chat.controlador.php";
require_once "modelos/chat.modelo.php";

require_once "modelos/partidas.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();