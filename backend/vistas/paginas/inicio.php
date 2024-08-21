<div class="content-wrapper" style="min-height: 717px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Analíticas</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Analíticas</li>

                    </ol>

                </div>

            </div>

        </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <?php include "modulos/top.php";?>



                <div class="col-6">

                    <?php include "modulos/promedio_aulas.php";?>

                </div>

                <div class="col-6">

                    <?php include "modulos/promedio_aulas_barras.php";?>

                </div>

                <div class="col-12">

                    <?php include "modulos/top_alumnos.php";?>

                </div>

                <div class="col-12">

                    <?php include "modulos/rangos.php";?>

                </div>

            </div>

        </div>

    </section>
    <!-- /.content -->
</div>