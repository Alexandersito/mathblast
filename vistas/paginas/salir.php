<?php
// session_start();
session_destroy();
header("Location:".$ruta); // Redirige a la página de inicio o a la que desees
exit();
?>