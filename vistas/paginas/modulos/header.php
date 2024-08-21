<?php

$juegos = ControladorJuegos::ctrMostrarJuegos();
// echo '<pre class="bg-white">';print_r($juegos);echo '</pre>';

if (isset($_SESSION["validarSesion"])) {
    $item = "id";
    $valor = $_SESSION["id"];

    $alumno = ModeloAlumnos::getAlumnoDetails($_SESSION["id"]);
    // echo '<pre class="bg-white">';print_r($alumno);echo '</pre>';

    $colorMMR = "";

    if ($alumno['mmr_global'] < 500) {
        $colorMMR = "bg-success";
    } elseif ($alumno['mmr_global'] >= 500 && $alumno['mmr_global'] < 1000) {
        $colorMMR = "bg-warning";
    } elseif ($alumno['mmr_global'] >= 1000) {
        $colorMMR = "bg-danger";
    }
}

?>

<header class="container-fluid mt-3">

    <div class="row align-items-center">

        <!-- GAMES -->
        <div class="col-5 games-column m-0 p-3">

            <?php foreach ($juegos as $key => $value): ?>
            <!-- Imágenes de juegos -->
            <img class="game" src="<?php echo $value['img']; ?>" data-id="<?php echo $value['id']; ?>">
            <?php endforeach ?>

        </div>

        <!-- LOGO -->
        <div class="col-2">
            <a href="<?php echo $ruta ?>">
                <img src="img/logo.png" class="logo img-fluid" />
            </a>
        </div>

        <!-- USER -->
        <div class="col-5 user-column user-profile relative " style="color:white;">

            <?php if (isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] === "ok"): ?>

            <a href="<?php echo $ruta ?>perfil">
                <img src="<?php echo $servidor.$alumno["img_alumno"]?>" alt="Alexander Saavedra Quillahuaman">
            </a>

            <span class="mb-1 px-3 negrita <?php echo $colorMMR?>"
                style="font-size:18px;border-radius:2px;">[<?php echo $alumno["mmr_global"]?>]</span>

            <p class="letra-lilita" id="user-name">
                <span class="first-line"><?php echo $alumno["nombre_alumno"]?></span>
                <span class="second-line"><?php echo $alumno["apellidos_alumno"]?></span>
            </p>

            <!-- Botón de Salir -->
            <a href="<?php echo $ruta ?>salir" class="btn-salir bg-info">Salir</a>

            <?php else: ?>

            <button class="letra-lilita absolute centrado iniciar-sesion">
                <i class="fas fa-user mr-3"></i> Iniciar Sesión
            </button>

            <?php endif; ?>

        </div>
    </div>

</header>

<!-- Overlay Login -->
<div id="overlayLogin" class="overlay-login">
    <div class="overlay-login-content centrado-vertical">
        <h2 class="text-center letra-lilita">Inicio de Sesión</h2>

        <form method="post">

            <div class="form-group">
                <label for="orderNumber" class="letra-lilita">Número de Orden</label>
                <input type="text" class="form-control" id="orderNumber" name="ingresoAlumno" required>
            </div>

            <div class="form-group">
                <label for="seccionAlumno" class="letra-lilita">Sección</label>
                <input type="text" class="form-control" id="seccionAlumno" name="seccionAlumno" required>
            </div>

            <div class="form-group position-relative">

                <label for="password" class="letra-lilita">Contraseña</label>
                <input type="password" class="form-control" id="password" name="ingresoPassword" required>

                <i class="toggle-password bi bi-eye-slash position-absolute"
                    style="right: 10px; top: 75%; transform: translateY(-50%); cursor: pointer;color: black;font-size: 20px;"></i>
            </div>

            <input type="submit" class="btn btn-primary btn-block letra-lilita mt-4" value="Ingresar">

            <?php

				$ingresoAlumno = new ControladorAlumnos();
				$ingresoAlumno -> ctrIngresoAlumno();

			?>

        </form>

    </div>
</div>

<!--=======================================================================================================================================-->
<!---->
<!--=======================================================================================================================================-->

<div id="overlay" class="overlay">
    <div class="modal-content">
        <img id="modal-img" src="#" alt="Game Image">
        <h1 id="modal-title" class="letra-lilita">
            Números consecutivos
        </h1>
        <p id="modal-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante
            dapibus diam.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed
            cursus ante dapibus diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.
            Praesent libero. Sed cursus ante dapibus diam.Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.
        </p>
        <div class="container d-flex justify-content-between p-0 m-0 mt-3">

            <a id="ruta-game" href="juegos/juego-1/index.html">
                <button class="letra-lilita">
                    <i class="fas fa-gamepad"></i>
                    <?php if (isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] === "ok"): ?>
                    Jugar
                    <?php else: ?>
                    Modo Invitado
                    <?php endif; ?>
                </button>
            </a>

            <a id="ruta-recursos" href="<?php echo $ruta ?>recursos">
                <button class="letra-lilita">
                    <i class="fas fa-book"></i> Recursos
                </button>
            </a>

        </div>
    </div>
</div>