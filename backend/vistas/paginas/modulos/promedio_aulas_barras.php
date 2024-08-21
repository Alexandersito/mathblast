<?php
$promedioAula = ControladorInicio::ctrPromedioAula();
$labels = [];
$promedios = [];

foreach ($promedioAula as $fila) {
    $labels[] = $fila['aula'];
    $promedios[] = round($fila['promedio_mmr']);
}

$labels = json_encode($labels); // Convertir a JSON para usar en JavaScript
$promedios = json_encode($promedios);

?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Bar Chart
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
        <canvas id="bar-chart" style="width: 100%; height: 287px;"></canvas>
    </div>
</div>


<script>
$(function() {
    var labels = <?php echo $labels; ?>;
    var promedios = <?php echo $promedios; ?>;

    var barChartData = {
        labels: labels,
        datasets: [{
            label: 'Promedio MMR por Aula',
            backgroundColor: 'rgba(60,141,188,0.5)', // Color de fondo (azul transparente)
            borderColor: 'rgba(60,141,188,1)', // Contorno (azul sólido)
            borderWidth: 2, // Grosor del contorno
            data: promedios
        }]
    };

    var ctx = document.getElementById('bar-chart').getContext('2d');
    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false,
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                grid: {
                    display: true
                },
                beginAtZero: true
            }
        }
    };

    new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    });
});
</script>