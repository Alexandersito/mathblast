<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/ruta.controlador.php";

require_once "controladores/inicio.controlador.php";
require_once "modelos/inicio.modelo.php";

require_once "controladores/administradores.controlador.php";
require_once "modelos/administradores.modelo.php";

require_once "controladores/aulas.controlador.php";
require_once "modelos/aulas.modelo.php";

require_once "controladores/alumnos.controlador.php";
require_once "modelos/alumnos.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();