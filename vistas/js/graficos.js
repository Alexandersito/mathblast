// if (window.location.pathname.includes("perfil")) {
//     traerEstadisticas();
// }



var idAlumno = $('#idAlumno').val()
console.log(idAlumno)
/*=============================================
AJAX
=============================================*/
var datos = new FormData();
datos.append("idAlumno", idAlumno);

$.ajax({
    url: urlPrincipal + "ajax/juegos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
        console.log(respuesta);

        var juegos = {};
        respuesta.forEach(function (partida) {
            if (!juegos[partida.tema]) {
                juegos[partida.tema] = {
                    img: partida.img,
                    tema: partida.tema,
                    mmr_total: partida.mmr_total,
                    partidas: []
                };
            }
            juegos[partida.tema].partidas.push({
                puntaje: partida.puntaje,
                mmr_cambio: partida.mmr_cambio,
                fecha: partida.fecha
            });
        });

        Object.keys(juegos).forEach(function (tema) {
            var juego = juegos[tema];

            var gameContainer = $('<div class="game-profile-container"></div>');
            gameContainer.append(`
                <div class="game-info">
                    <img class="demo" src="${juego.img}" alt="Imagen del Juego">
                    <h2 class="letra-lilita">${juego.tema}</h2>
                    <p class="text-danger">[${juego.mmr_total}]</p>
                </div>
                <div class="game-chart">
                    <div class="chart-container">
                        <canvas id="chart-${tema}"></canvas>
                    </div>
                </div>
            `);
            $('.estadisticas').append(gameContainer);

            var labels = juego.partidas.map(function (partida, index) {
                return `P${index + 1}`;
            });
            var data = juego.partidas.map(function (partida) {
                return partida.mmr_cambio;
            });

            var ctx = document.getElementById(`chart-${tema}`).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'MMR POR PARTIDA',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        data: data,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: Math.min(...data) - 10, // Ajuste del valor mínimo del eje Y
                            max: Math.max(...data) + 10, // Ajuste del valor máximo del eje Y
                            ticks: {
                                stepSize: 10
                            }
                        },
                        x: {
                            // Configuraciones del eje X
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuad'
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    layout: {
                        padding: {
                            left: 10,
                            right: 10,
                            top: 10,
                            bottom: 10
                        }
                    },
                    responsive: true,
                },
            });
        });
    },
    error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", error);
        console.error("Detalles:", xhr.responseText);
    }
});

