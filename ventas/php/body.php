<?php

include "../../fGenerales/bd/conexion.php";
//checando permisos del usuario en la seccion

session_name('gpsingenieria');
session_start();

$datos = checarPermisosSeccion($_SESSION['usuarioid']);
?>


<body class=" justify-content-center align-items-center">

    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>
    
    <div class="contenedorCont">
        <!-- //div principal -->
        <div class="col-12">

            <?php pintarEncabezado('Ventas','<i class="fa-solid fa-cash-register fa-2xl"></i>','');?>

            <?php include "botones.php";?>
            <!-- Catalogo de ventas -->
            <?php include "catalogo.php" ?>
           
        </div>
        <!-- //div principal fin -->
        <!-- //PINTAR MODAL -->
        <?php include "modal.php";?>
        

        <?php pintarFooter();?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

       </div>

</body>



