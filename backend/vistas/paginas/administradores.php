<?php 

  if($admin["cargo"] != "Director"){

    echo '<script>

      window.location = "inicio";

    </script>';

    return;

  }

?>

<div class="content-wrapper" style="min-height: 717px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Administradores</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Administradores</li>

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

                            <button class="btn btn-dark" data-toggle="modal" data-target="#crearAdministrador">Crear
                                nuevo administrador</button>

                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">

                            <table class="table table-bordered table-striped dt-responsive tablaAdministradores"
                                width="100%">

                                <thead>

                                    <tr>

                                        <th style="width:10px">#</th>
                                        <th>DNI</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Usuario</th>
                                        <th>Cargo</th>
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
Modal Crear Administrador
======================================-->

<div class="modal" id="crearAdministrador">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post">

                <div class="modal-header bg-secondary">

                    <h4 class="modal-title">Crear Administrador</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <!-- input dni -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                        <input type="text" class="form-control" name="registroDni" placeholder="Ingresa el DNI"
                            required>

                    </div>

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

                    <!-- input usuario -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user-lock"></span>

                        </div>

                        <input type="text" class="form-control" name="registroUsuario" placeholder="Ingresa el usuario"
                            required>

                    </div>

                    <!-- input password -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-lock"></span>

                        </div>

                        <input type="password" class="form-control" name="registroPassword"
                            placeholder="Ingresa la contraseña" required>

                    </div>

                    <!-- seleccionar el perfil -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-key"></span>

                        </div>

                        <select class="form-control" name="registroCargo" required>

                            <option value="">Seleccione cargo</option>

                            <option value="Profesor">Profesor</option>

                            <option value="Director">Director</option>

                        </select>

                    </div>

                    <?php 

                        $registroAdministrador = new ControladorAdministradores();
                        $registroAdministrador -> ctrRegistroAdministrador();

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
Modal Editar Administrador
======================================-->

<div class="modal" id="editarAdministrador">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post">

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Administrador</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="editarId">

                    <!-- input Dni -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user"></span>

                        </div>

                        <input type="text" class="form-control" name="editarDni" value required>

                    </div>

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

                    <!-- input usuario -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-user-lock"></span>

                        </div>

                        <input type="text" class="form-control" name="editarUsuario" value required>

                    </div>

                    <!-- input password -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-lock"></span>

                        </div>

                        <input type="password" class="form-control" name="editarPassword"
                            placeholder="Cambie la contraseña">
                        <input type="hidden" name="passwordActual">

                    </div>

                    <!-- seleccionar el perfil -->

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">

                            <span class="fas fa-key"></span>

                        </div>

                        <select class="form-control" name="editarCargo" required>

                            <option class="editarPerfilOption"></option>

                            <option value="">Seleccione cargo</option>

                            <option value="Profesor">Profesor</option>

                            <option value="Director">Director</option>

                        </select>

                    </div>

                    <?php 

                        $editarAdministrador = new ControladorAdministradores();
                        $editarAdministrador -> ctrEditarAdministrador();

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