<?php 

    if($admin["cargo"] != "Profesor"){

        echo '<script>

        window.location = "inicio";

        </script>';

        return;

    }

    $alumnos = ControladorAlumnos::ctrMostrarAlumnos($_SESSION["idBackend"]);
    $imagenesUsadas = array_map(function($alumno) {
        return $alumno['img'];
    }, $alumnos);

    do {
        $randomImageNumber = rand(20, 105);
        $randomImagePath = "vistas/img/alumnos/" . $randomImageNumber . ".png";
    } while (in_array($randomImagePath, $imagenesUsadas));

    $obtenerJuegos = ModeloAlumnos::mdlObtenerJuegos();
    // echo '<pre class="bg-white">';print_r($obtenerJuegos);echo '</pre>';
    
?>

<div class="content-wrapper" style="min-height: 717px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Alumnos <?php echo $aula["nombre"]?></h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Alumnos</li>

                    </ol>

                </div>

            </div>

        </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-12">

                    <!-- Default box -->
                    <div class="card card-info card-outline">

                        <div class="card-header">

                            <button class="btn btn-dark" data-toggle="modal" data-target="#crearAlumno">Crear
                                nuevo alumno</button>

                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">

                            <table class="table table-bordered table-striped dt-responsive tablaAlumnos" width="100%">

                                <thead>

                                    <tr>

                                        <th style="width:10px">#</th>
                                        <th>Img</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Número Orden</th>
                                        <th>MMR Global</th>
                                        <th>Aula</th>
                                        <th>Partida</th>
                                        <th>Acciones</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <!--  <tr>
                    
                    <td>1</td>
                    <td>Hotel Portobelo</td>
                    <td>portobelo</td>
                    <td>Administrador</td>
                    <td><button class="btn btn-info btn-sm">Activo</button></td>
                    <td>

                      <div class='btn-group'>
                      
                        <button class="btn btn-warning btn-sm">
                          <i class="fas fa-pencil-alt text-white"></i>
                        </button>  

                        <button class="btn btn-danger btn-sm">
                          <i class="fas fa-trash-alt"></i>
                        </button> 

                      </div> 

                    </td>

                  </tr> -->

                                </tbody>

                            </table>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">

                        </div>
                        <!-- /.card-footer-->

                    </div>
                    <!-- /.card -->

                </div>

            </div>

        </div>

    </section>
    <!-- /.content -->

</div>


<!--=====================================
Modal Crear Administrador
======================================-->

<div class="modal" id="crearAlumno">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post">

                <div class="modal-header bg-secondary">

                    <h4 class="modal-title">Crear Alumno para <?php echo $aula["nombre"]?></h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <div class=" mb-3">
                        <img src="<?php echo $randomImagePath; ?>" alt="Imagen Alumno" class="img-thumbnail"
                            width='150px'>
                    </div>

                    <input type="hidden" name="registroImg" value="<?php echo $randomImagePath; ?>">

                    <!-- input nombre -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                        <input type="text" class="form-control" name="registroNombre" placeholder="Ingresa el nombre"
                            required>

                    </div>

                    <!-- input Apellidos -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                        <input type="text" class="form-control" name="registroApellidos"
                            placeholder="Ingresa los apellidos" required>

                    </div>

                    <!-- input número de orden -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user-lock"></span>

                        </div>

                        <input type="text" class="form-control" name="registroNumeroOrden"
                            placeholder="Ingresa el número de orden" required>

                    </div>

                    <!-- input password -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-lock"></span>

                        </div>

                        <input type="password" class="form-control" name="registroPassword"
                            placeholder="Ingresa la contraseña" required>

                    </div>

                    <input type="hidden" name="aulaId" value="<?php echo $aula['id']; ?>">
                    <input type="hidden" name="profesorId" value="<?php echo $_SESSION["idBackend"]; ?>">

                    <?php 

                        $registroAlumno = new ControladorAlumnos();
                        $registroAlumno -> ctrRegistroAlumno();

                    ?>

                </div>

                <div class="modal-footer d-flex justify-content-between">

                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


<!--=====================================
Modal Editar Alumno
======================================-->

<div class="modal" id="editarAlumno">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post">

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Alumno</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="editarId">

                    <!-- input nombre -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                        <input type="text" class="form-control" name="editarNombre" value required>

                    </div>

                    <!-- input Apellidos -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                        <input type="text" class="form-control" name="editarApellidos" value required>

                    </div>

                    <!-- input numero de orden -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user-lock"></span>

                        </div>

                        <input type="text" class="form-control" name="editarNumeroOrden" value required>

                    </div>

                    <!-- input password -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-lock"></span>

                        </div>

                        <input type="text" class="form-control" name="editarPassword"
                            placeholder="Cambie la contraseña">
                        <input type="hidden" name="passwordActual">

                    </div>

                    <input type="hidden" name="profesorId" value="<?php echo $_SESSION["idBackend"]; ?>">

                    <?php 

                        $editarAlumno = new ControladorAlumnos();
                        $editarAlumno -> ctrEditarAlumno();

                    ?>

                </div>

                <div class="modal-footer d-flex justify-content-between">

                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<!--=====================================
Modal CREAR PARTIDA
======================================-->

<div class="modal" id="crearPartida">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post">

                <div class="modal-header bg-primary">

                    <h4 class="modal-title">Agregar Partida Para:</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <!-- input paraAlumno -->
                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                        <input type="text" class="form-control" name="paraAlumno" value="Nombre del Alumno" readonly>
                    </div>


                    <!-- seleccionar el juego -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-gamepad"></span>

                        </div>

                        <select class="form-control" name="registroJuego" required>
                            <option value="">Seleccione Juego</option>
                            <?php foreach ($obtenerJuegos as $juego): ?>
                            <option value="<?php echo $juego['id']; ?>">
                                <?php echo $juego['nombre']."-".$juego['tema']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <!-- input puntaje -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-plus"></span>

                        </div>

                        <input type="text" class="form-control" name="registroPuntaje" value required
                            placeholder="Puntaje">

                    </div>

                    <input type="hidden" name="alumnoId">

                    <?php 

                        $agregarPartida = new ControladorAlumnos();
                        $agregarPartida -> ctrAgregarPartida();

                    ?>

                </div>

                <div class="modal-footer d-flex justify-content-between">

                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>