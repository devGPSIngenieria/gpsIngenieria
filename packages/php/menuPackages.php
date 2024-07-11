<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";
    
    pantallaCarga('on');
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <?php pintarHead('Paquetes') ?>
    </head>

    <?php
    // CHECA LOS PERMISOS DEL USUARIO
        session_name('gpsingenieria');
        session_start();
        $datos = checarPermisosSeccion($_SESSION['usuarioid']);
    ?>

    <body class="justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">
        
        <!-- NAVBAR -->
        <?php pintarNavBar(); ?>

        <div class="contenedorCont">

            <div class="col-12">

                <?php pintarEncabezado('Paquetes','<i class="fa-solid fa-box fa-2xl"></i>','')?>

                <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">

                    <div class="col-12 cont-botones-secciones">

                        <?php include_once './navigationButtons.php'; ?>

                    </div>
                    
                </div>

                <?php include_once './registerPackages.php'; ?>
                <?php include_once './packageFormation.php'; ?>
                <?php include_once './catalogPackages.php'; ?>
                
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <?php pintarFooter()?>
        
    </body>
</html>