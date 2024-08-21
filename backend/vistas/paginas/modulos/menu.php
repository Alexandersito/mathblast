<?php
// Captura el valor del parámetro GET
$current_page = isset($_GET['pagina']) ? $_GET['pagina'] : 'inicio'; // 'inicio' es el valor predeterminado
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?php echo $ruta ?>" class="brand-link" target="_blank">
        <img src="vistas/img/plantilla/logo.png" alt="Math Blast Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Math Blast</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
                <a href="#" class="d-block"><?php echo $admin['nombre']."<br>".$admin['apellidos'] ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- botón Ver sitio x -->
                <li class="nav-item">
                    <a href="<?php echo $ruta; ?>" class="nav-link bg-warning" target="_blank">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>Ver sitio</p>
                    </a>
                </li>

                <!-- Botón página inicio -->
                <li class="nav-item">
                    <a href="inicio" class="nav-link <?php echo ($current_page == 'inicio') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                <?php if ($admin["cargo"] == "Director"): ?>
                <!-- Botón página administradores -->
                <li class="nav-item">
                    <a href="administradores"
                        class="nav-link <?php echo ($current_page == 'administradores') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Administradores</p>
                    </a>
                </li>


                <!-- Botón página aulas -->
                <li class="nav-item">
                    <a href="aulas" class="nav-link <?php echo ($current_page == 'aulas') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-landmark"></i>
                        <p>Aulas</p>
                    </a>
                </li>
                <?php endif ?>

                <?php if ($admin["cargo"] == "Profesor"): ?>
                <!-- Botón página alumnos -->
                <li class="nav-item">
                    <a href="alumnos" class="nav-link <?php echo ($current_page == 'alumnos') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Alumnos</p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Botón página juegos -->
                <li class="nav-item">
                    <a href="juegos" class="nav-link <?php echo ($current_page == 'juegos') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-gamepad"></i>
                        <p>Juegos</p>
                    </a>
                </li>

            </ul>
        </nav>

    </div>

</aside>