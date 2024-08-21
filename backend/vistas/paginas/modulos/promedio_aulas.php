<?php
$promedioAula = ControladorInicio::ctrPromedioAula();
// echo '<pre class="bg-white">';print_r($promedioAula);echo '</pre>';

?>

<div class="card card-dark card-outline">
    <div class="card-header border-transparent">
        <h3 class="card-title">Promedio de MMR por Aula</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div class="card-body p-0" style="display: block;">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Aula</th>
                        <th>Promedio MMR</th>
                        <th>Profesor</th>
                        <th>Alumnos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promedioAula as $key => $value): ?>

                    <?php
                        
                        $colorMMR = "";

                        if ($value["promedio_mmr"] < 500) {
                            $colorMMR = "badge-success";
                        } elseif ($value["promedio_mmr"] >= 500 && $value["promedio_mmr"] < 1000) {
                            $colorMMR = "badge-warning";
                        } elseif ($value["promedio_mmr"] >= 1000) {
                            $colorMMR = "badge-danger";
                        }
                        
                    ?>

                    <tr>
                        <td><?php echo $value["aula"]; ?></td>
                        <td><span class="badge <?php echo $colorMMR; ?> px-4 py-2 w-100" style="font-size: 15px;">
                                <?php echo round($value["promedio_mmr"]); ?>
                            </span></td>
                        <td><?php echo $value["profesor"]; ?></td>
                        <td>
                            <?php echo $value["total_alumnos"]; ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    </div>

</div>