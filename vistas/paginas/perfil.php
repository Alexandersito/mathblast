<?php

if (isset($_GET["pagina"])) {
    
    $variableGET = $_GET["pagina"];

    if ($variableGET == 'perfil') {

        if (isset($_SESSION["validarSesion"])) {
            $item = "id";
            $valor = $_SESSION["id"];
        
            $alumno = ModeloAlumnos::getAlumnoDetails($_SESSION["id"]);
            // echo '<pre class="bg-white">';print_r($alumno);echo '</pre>';
            
        }
        
    }else{
        
        preg_match('/(\d+)/', $variableGET, $matches);
        $idAlumnoTercero = $matches[1];

        $alumno = ModeloAlumnos::getAlumnoDetails($idAlumnoTercero);
        // echo '<pre class="bg-white">';print_r($alumno);echo '</pre>';
    }

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

<div class="d-flex justify-content-between">
    <div class="profile-container mt-4 relative">

        <div class="profile-pic-section">
            <img src="<?php echo $servidor.$alumno['img_alumno'] ?>" alt="Foto del Alumno" class="profile-pic">
        </div>

        <div class="profile-info-section ">
            <p>Número de Orden: <span><?php echo $alumno['numero_orden'] ?></span></p>
            <p>Global MMR: <span><?php echo $alumno['mmr_global'] ?></span></p>
            <div class="profile-details">
                <h2 class="letra-lilita">Detalles del Perfil</h2>
                <p>Nombre: <span><?php echo $alumno['nombre_alumno'] ?></span></p>
                <p>Apellidos: <span><?php echo $alumno['apellidos_alumno'] ?></span></p>
            </div>
        </div>

        <h5 class="absolute <?php echo $colorMMR ?> letra-lilita" style="font-size: 70px;
        right: 50px;
        padding: 10px 20px; 
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); "><?php echo $alumno['nombre_aula'] ?></h5>

    </div>

    <a href="<?php echo $ruta ?>">
        <img style="width: 200px;
    height: 200px;margin-top: 35px;" src="img/logo.png" class="img-fluid" alt="">
    </a>

</div>

<h1 class="m-0 p-0 letra-lilita mt-4">Estadísticas de Juego</h1>

<div class="estadisticas">
    <div class="game-profile-container">

        <input type="hidden" value="<?php echo $alumno['id_alumno']; ?>" id="idAlumno">

        <div id="charts-container"></div>

    </div>
</div>