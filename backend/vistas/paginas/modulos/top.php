<?php
$analiticas = ControladorInicio::ctrAnaliticas();
// echo $analiticas;
// echo '<pre class="bg-white">';print_r($analiticas);echo '</pre>';
?>

<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Alumnos</span>
            <span class="info-box-number">
                <?php echo $analiticas['total_alumnos']?>
            </span>
        </div>

    </div>

</div>

<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chalkboard-teacher"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Profesores</span>
            <span class="info-box-number"><?php echo $analiticas['total_profesores']?></span>
        </div>

    </div>

</div>

<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-school"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Aulas</span>
            <span class="info-box-number"><?php echo $analiticas['total_aulas']?></span>
        </div>

    </div>

</div>

<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-gamepad"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Juegos</span>
            <span class="info-box-number"><?php echo $analiticas['total_juegos']?></span>
        </div>

    </div>

</div>