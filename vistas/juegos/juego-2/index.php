<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <title>Penguin</title>
    <style type="text/css">
    body {
        margin: 0;
        padding: 0;
        background-color: black;
        overflow: hidden;
    }
    </style>
</head>

<body>

    <?php if (isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] === "ok"): ?>
    <input type="hidden" value="<?php echo $_SESSION["id"]; ?>" id="idAlumno">
    <?php else: ?>
    <input type="hidden" value="invitado" id="idAlumno">
    <p class="text-center p-0 m-0" style="font-size:12px">INVITADO</p>
    <?php endif; ?>

    <script src="juegos/juego-2/src/phaser.min.js"></script>
    <script src="juegos/juego-2/src/GamePlay.js"></script>
</body>

</html>