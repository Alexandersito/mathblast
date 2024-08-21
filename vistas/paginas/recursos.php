<?php
$valor = $_GET["pagina"];
$juego = ControladorJuegos::ctrMostrarJuego($valor);
// echo '<pre class="bg-white">';print_r($juego);echo '</pre>';

?>

<div class="recursos-video-container">
    <div class="recursos-header">
        <h1 class="letra-lilita"><?php echo $juego["nombre"]?></h1>
        <p class="letra-lilita"><?php echo $juego["tema"]?></p>
    </div>
    <div class="recursos-game-image text-center">
        <a href="<?php echo $ruta ?>">
            <img src="<?php echo $juego["img"]?>" alt="Imagen del Juego">
        </a>
    </div>
    <iframe src="https://www.youtube.com/embed/<?php echo $juego['video']; ?>" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
</div>
<div class="recursos-content">

    <div class="recursos-pdf-container">
        <iframe src="<?php echo $juego['pdf']; ?>" frameborder="0"></iframe>
    </div>

</div>