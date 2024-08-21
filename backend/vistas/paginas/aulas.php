<?php 

  if($admin["cargo"] != "Director"){

    echo '<script>

      window.location = "inicio";

    </script>';

    return;

  }

  $profesores = ModeloAulas::mdlObtenerProfesores();
//   echo '<pre class="bg-white">';print_r($profesores);echo '</pre>';

?>

<div class="content-wrapper" style="min-height: 717px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Aulas</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Aulas</li>

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

                            <button class="btn btn-dark" data-toggle="modal" data-target="#crearAula">Crear
                                nueva aula</button>

                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">

                            <table class="table table-bordered table-striped dt-responsive tablaAulas" width="100%">

                                <thead>

                                    <tr>

                                        <th style="width:10px">#</th>
                                        <th>Aula</th>
                                        <th>Profesor</th>
                                        <th>Alumnos</th>
                                        <th>Anio</th>
                                        <th>Estado</th>
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
Modal Crear Aula
======================================-->

<div class="modal" id="crearAula">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post">

                <div class="modal-header bg-secondary">

                    <h4 class="modal-title">Crear Aula</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <!-- input nombre -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-landmark"></span>

                        </div>

                        <input type="text" class="form-control" name="registroNombre" placeholder="Ingresa el aula"
                            required>

                    </div>


                    <!-- seleccionar el profesor -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                        <select class="form-control" name="registroProfesor" required>

                            <option value="">Seleccione profesor a cargo</option>

                            <?php foreach ($profesores as $key => $value): ?>
                            <option value="<?php echo $value['id']?>"><?php echo $value['nombre_completo']?></option>
                            <?php endforeach ?>

                        </select>

                    </div>

                    <?php 

                        $registroAulas = new ControladorAulas();
                        $registroAulas -> ctrCrearAula();

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
Modal Editar Aula
======================================-->

<div class="modal" id="editarAula">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post">

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Aula</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="editarId">

                    <!-- input nombre -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-landmark"></span>

                        </div>

                        <input type="text" class="form-control" name="editarNombre" value required>

                    </div>

                    <!-- seleccionar el profesor encargado -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                        <select class="form-control" name="editarProfesor" required>

                            <option class="editarPerfilOption"></option>

                            <option value="">Seleccione profesor a cargo</option>

                            <?php foreach ($profesores as $key => $value): ?>
                            <option value="<?php echo $value['id']?>"><?php echo $value['nombre_completo']?></option>
                            <?php endforeach ?>

                        </select>

                    </div>

                    <?php 

                        $editarAula = new ControladorAulas();
                        $editarAula -> ctrEditarAula();

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