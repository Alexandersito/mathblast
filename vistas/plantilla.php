<?php
session_start();

$ruta = ControladorRuta::ctrRuta();
$servidor = ControladorRuta::ctrServidor();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Blast</title>

    <base href="vistas/">

    <!-- Coloca la ruta a tu imagen como el atributo href -->
    <link rel="icon" href="img/icono.png" type="image/png">

    <!-- CSS de Bootstrap (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Dependencia de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts de Bootstrap (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Incluye el CSS de Bootstrap -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet"> -->

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">


    <!-- ICONOS DE FONT AWESOME -->
    <script src="https://kit.fontawesome.com/3fb3f6418b.js" crossorigin="anonymous"></script>
    <!-- ICONOS DE REMIXICON -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- LILITA ONE -->
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SWEET ALERT 2 -->
    <!-- https://sweetalert2.github.io/ -->
    <script src="js/plugins/sweetalert2.all.js"></script>

    <!-- ESTILOS CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php

    function convertirAUrlAmigable($cadena) {
        // Convertir a minúsculas
        $cadena = strtolower($cadena);

        // Reemplazar caracteres acentuados por sus equivalentes sin tilde
        $cadena = strtr($cadena, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
            'ñ' => 'n', 'Ñ' => 'n'
        ]);

        // Reemplazar espacios por guiones
        $cadena = str_replace(' ', '-', $cadena);

        return $cadena;
    }

    if (isset($_GET["pagina"])) {

        $rutasJuegos = ControladorJuegos::ctrMostrarJuegos();
        // echo '<pre class="bg-white">';print_r($rutasJuegos);echo '</pre>';

        $mmrGlobal = ControladorAlumnos::ctrMostrarMMR();

        foreach ($rutasJuegos as $key => $value) {

            $realRuta = convertirAUrlAmigable($value['tema']);
            $realRutaRecursos = convertirAUrlAmigable($value['nombre']);
            
            if ($_GET["pagina"] == $realRutaRecursos) {

                include "paginas/recursos.php";

            }elseif ($_GET["pagina"] == $realRuta) {

                include "paginas/juegos.php";
            }

        }

        foreach ($mmrGlobal as $key => $value) {
            
            if ($_GET["pagina"] == convertirAUrlAmigable($value['nombre_completo']).$value['id']) {
                include "paginas/perfil.php";
            }

        }

        if ($_GET["pagina"] == "perfil" && isset($_SESSION["validarSesion"])) {
            include "paginas/perfil.php";
        }

        if ($_GET["pagina"] == "salir") {
            include "paginas/salir.php";
        }
       
    } else {
        include "paginas/inicio.php";
    }

?>

</body>

<input type="hidden" value="<?php echo $ruta; ?>" id="urlPrincipal">
<input type="hidden" value="<?php echo $servidor; ?>" id="urlServidor">

<script src="js/script.js"></script>
<script src="js/graficos.js"></script>
<script src="js/juegos.js"></script>
<script src="js/chat.js"></script>

<!-- Incluye el JS de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>

</html>