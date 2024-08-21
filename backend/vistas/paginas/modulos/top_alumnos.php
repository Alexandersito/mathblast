<?php
$topAlumnos = ControladorInicio::ctrTopAlumnos();
// echo '<pre class="bg-white">';print_r($promedioAula);echo '</pre>';

?>

<div class="card card-info card-outline">
    <div class="card-header border-transparent">
        <h3 class="card-title">Top 3 Alumnos</h3>
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
                        <th>Avatar</th>
                        <th>Nombre</th>
                        <th>MMR</th>
                        <th>Profesor</th>
                        <th>Aula</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($topAlumnos, 0, 3) as $key => $value): ?>

                    <?php
                        
                        $colorMMR = "";

                        if ($value["mmr_global"] < 500) {
                            $colorMMR = "badge-success";
                        } elseif ($value["mmr_global"] >= 500 && $value["mmr_global"] < 1000) {
                            $colorMMR = "badge-warning";
                        } elseif ($value["mmr_global"] >= 1000) {
                            $colorMMR = "badge-danger";
                        }
                        
                    ?>

                    <tr>
                        <td>
                            <img src="<?php echo $rutaBackend.$value["img"]; ?>" alt="Product Image"
                                class="img-size-50 rounded-circle">
                        </td>
                        <td><?php echo $value["nombre_completo"]; ?></td>
                        <td>
                            <span class="badge <?php echo $colorMMR; ?> px-4 py-2 w-100" style="font-size: 15px;">
                                <?php echo round($value["mmr_global"]); ?>
                            </span>
                        </td>
                        <td>
                            <?php echo $value["profesor"]; ?>
                        </td>
                        <td><?php echo $value["aula"]; ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    </div>

</div>