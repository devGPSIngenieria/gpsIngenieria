<?php

    include "../../fGenerales/php/funciones.php";
    include "../../fGenerales/bd/conexion.php";

    pantallaCarga('on');
?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <?php pintarHead('Responsivas') ?>
    </head>

    <?php                
        session_name('gpsingenieria');
        session_start();

        $datos = checarPermisosSeccion($_SESSION['usuarioid']);
    ?>

    <body class=" justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">
    
    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>

        <div class="contenedorCont">
            <div class="col-12">

                <!-- PINTA ENCABEZADO -->
                <?php pintarEncabezado('Responsivas', '<i class="fa-solid fa-file-signature fa-2xl"></i>' ,''); ?>
                
                <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">
                    
                    <div class="col-12">
                        <?php
                        foreach ($datos->fetch_all() as $dato) {
                            if ($dato[1] == 17) {
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Crear responsiva</span>
                                        </span>
                                    </button>';
                            }
                            if ($dato[1] == 18) {
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(2)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Catalogo responsivas</span>
                                        </span>
                                    </button>';
                            }
                        }
                        ?>
                    </div>

                </div>
                
                <!-- PINTA PRA CREAR RESPONSIVA -->
                <?php include_once './crearResponsivas.php'?>

                <!-- PINTA EL CATALOGO -->
                <?php include_once './catalogoResponsivas.php'?>

                <!-- MODAL -->
                <?php include_once './modales.php'?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        
        <?php pintarFooter() ?>

    </body>

</html>