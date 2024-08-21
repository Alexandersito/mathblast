<?php
// $valor = $_GET["pagina"];
$juego = ControladorJuegos::ctrMostrarJuegos();
// echo '<pre class="bg-white">';print_r($juego);echo '</pre>';

if (isset($_GET["pagina"])) {

    foreach ($juego as $key => $value) {
            
            $realRuta = convertirAUrlAmigable($value['tema']);
        
            if ($_GET["pagina"] == $realRuta) {

                if ($value['estado']==0) {
                    echo'<script>
            
                                swal({
                                        type:"error",
                                          title: "¡ERROR!",
                                          text: "¡EL JUEGO ESTA SIENDO ACTUALIZADO O EN MANTENIMIENTO!",
                                          showConfirmButton: true,
                                        confirmButtonText: "Cerrar"
                                      
                                }).then(function(result){
            
                                          
                                            history.back();
                                        
                                });
            
                            </script>';
                }else{

                    include 'vistas/'.$value['ruta'];

                }
            }
    }

}

?>