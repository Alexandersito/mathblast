<?php

$chatGlobal = ControladorChat::ctrMostrarChat();
// echo '<pre class="bg-white">';print_r($alumno);echo '</pre>';

$mmrGlobal = ControladorAlumnos::ctrMostrarMMR();
// echo '<pre class="bg-white">';print_r($mmrGlobal);echo '</pre>';

?>

<!--=======================================================================================================================================-->
<!---->
<!--=======================================================================================================================================-->
<input type="hidden" value="<?php echo $alumno['img_alumno']; ?>" id="imgAlumno">
<input type="hidden" value="<?php echo $alumno['nombre_alumno'].' '.$alumno['apellidos_alumno']; ?>" id="nombreAlumno">

<div class="grid-container">

    <div class="grid-item">

        <h2 class="letra-lilita text-center mt-3">GLOBAL CHAT</h2>

        <ul class="chat-container mt-4" id="chatContainer">

            <?php foreach ($chatGlobal as $key => $value): ?>
            <li class="message">
                <span class="time"><?php echo $value['hora_mensaje']; ?></span>
                <a href="<?php echo $ruta.convertirAUrlAmigable($value['nombre_alumno']).$value['id'] ?>">
                    <img class="user-avatar" src="<?php echo $servidor.$value['img_alumno']; ?>" alt="Avatar">
                </a>
                <span class="name"><?php echo substr($value['nombre_alumno'], 0, 18); ?>:</span>
                <span class="text"><?php echo $value['contenido_mensaje']; ?></span>
            </li>
            <?php endforeach ?>

        </ul>

        <div class="chat-input-container">

            <form action="#">
                <input type="text" class="chat-input" placeholder="Escribe un mensaje...">
                <input type="hidden" value="<?php if (isset($alumno)) {
                echo $alumno["id_alumno"];
            }else{
                echo "none";
            }; ?>" id="idAlumno">
                <!-- <button class="send-button">Enviar</button> -->
                <input type="submit" class="send-button" value="Enviar">
            </form>

        </div>

    </div>

    <div class="grid-item">

        <h2 class="letra-lilita text-center mt-3">ONLINE: <?php echo count($mmrGlobal)?></h2>

        <div class="mmr-container mt-4">

            <?php foreach ($mmrGlobal as $key => $value): ?>

            <?php
                $colorMMR = "";

                if ($value['mmr_global'] < 500) {
                    $colorMMR = "bg-success";
                } elseif ($value['mmr_global'] >= 500 && $value['mmr_global'] < 1000) {
                    $colorMMR = "bg-warning";
                } elseif ($value['mmr_global'] >= 1000) {
                    $colorMMR = "bg-danger";
                }
            ?>

            <div class="item bg-dark relative">

                <a href="<?php echo $ruta.convertirAUrlAmigable($value['nombre_completo']).$value['id'] ?>">
                    <img class="avatar bg-inf" src="<?php echo $servidor.$value['img']?>" alt="Avatar">
                </a>

                <div class="name mr-2" style="color:white;"><?php echo substr($value['nombre_completo'], 0, 18)?>
                </div>
                <!-- <div class="score negrita">[<?php echo $value['mmr_global']?>]</div> -->
                <h5 class=" <?php echo $colorMMR ?> negrita " style="font-size: 13px;
                right:10px;
                margin-top: 7px;
                padding: 5px 10px; 
                border-radius: 5px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); ">[ <?php echo $value['mmr_global'] ?> ]</h5>

            </div>
            <?php endforeach ?>

        </div>
    </div>

</div>