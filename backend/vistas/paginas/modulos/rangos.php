<?php
// $topAlumnos = ControladorInicio::ctrTopAlumnos();

$totalAlumnos = count($topAlumnos);

// 2. Contar alumnos en cada rango de MMR
$countRango1 = 0; // MMR < 500
$countRango2 = 0; // 500 <= MMR <= 1000
$countRango3 = 0; // MMR > 1000

foreach ($topAlumnos as $alumno) {
    if ($alumno['mmr_global'] <500) {
        $countRango1++;
    } elseif ($alumno['mmr_global'] <= 1000) {
        $countRango2++;
    } else {
        $countRango3++;
    }
}

// 3. Calcular porcentajes
$porcentajeRango1 = ($totalAlumnos > 0) ? ($countRango1 / $totalAlumnos) * 100 : 0;
$porcentajeRango2 = ($totalAlumnos > 0) ? ($countRango2 / $totalAlumnos) * 100 : 0;
$porcentajeRango3 = ($totalAlumnos > 0) ? ($countRango3 / $totalAlumnos) * 100 : 0;

// Redondear a dos decimales
$porcentajeRango1 = round($porcentajeRango1);
$porcentajeRango2 = round($porcentajeRango2);
$porcentajeRango3 = round($porcentajeRango3);

// echo '<pre class="bg-white">';print_r($totalAlumnos);echo '</pre>';

?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-bar"></i>
            Alumnos por Rango
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="progress-group">
            <span class="progress-text">Experto</span>
            <span class="float-right"><b><?php echo $countRango3 ?></b> alumnos</span>
            <div class="progress">
                <div class="progress-bar bg-danger" style="width: <?php echo $porcentajeRango3?>%"></div>
            </div>
        </div>
        <div class="progress-group">
            <span class="progress-text">Intermedio</span>
            <span class="float-right"><b><?php echo $countRango2 ?></b> alumnos</span>
            <div class="progress">
                <div class="progress-bar bg-warning" style="width: <?php echo $porcentajeRango2?>%"></div>
            </div>
        </div>
        <div class="progress-group">
            <span class="progress-text">Novato</span>
            <span class="float-right"><b><?php echo $countRango1 ?></b> alumnos</span>
            <div class="progress">
                <div class="progress-bar bg-success" style="width: <?php echo $porcentajeRango1?>%"></div>
            </div>
        </div>
    </div>
</div>