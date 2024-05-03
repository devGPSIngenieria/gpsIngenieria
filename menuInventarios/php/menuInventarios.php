<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";

    pantallaCarga('on');

    session_name('gpsingenieria');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php pintarHead('Inventarios') ?>
</head>


<body class=" justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">

    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>

    <div class="contenedorCont">
        <!-- //div principal -->
        <div class="col-12">

            <?php pintarEncabezado('Inventarios', '<i class="fa-solid fa-warehouse fa-2xl"></i>', '') ?>
            

            <main class="site-wrapper">
                <div class="pt-table desktop-768">
                    <div class="pt-tablecell">
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                            
                                <?php if(checarPermisosArea($_SESSION['usuarioid'], 3)){ ?>
                                    <div class="col-lg-6">
                                        <div class="hexagon-item">
                                            <div class="hex-item">
                                                <div></div> <div></div> <div></div>
                                            </div>
                                            <div class="hex-item">
                                                <div></div> <div></div> <div></div>
                                            </div>
                                            
                                            <a  class="hex-content" onclick="abrirCategoriaProductos()">
                                                <span class="hex-content-inner">
                                                    <span class="icon">
                                                        <i id='iconoMPanal'><i class="fa-regular fa-object-ungroup fa-2xl"></i></i>
                                                    </span>
                                                    <span class="title">Categorías</span>
                                                </span>
                                                <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#ffffff"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if(checarPermisosArea($_SESSION['usuarioid'], 4)){ ?>
                                    <div class="col-lg-6">
                                        <div class="hexagon-item">
                                            <div class="hex-item">
                                                <div></div> <div></div> <div></div>
                                            </div>
                                            <div class="hex-item">
                                                <div></div> <div></div> <div></div>
                                            </div>
                                            
                                            <a  class="hex-content" onclick="abrirProductos()">
                                                <span class="hex-content-inner">
                                                    <span class="icon">
                                                        <i id='iconoMPanal'><i class="fa-solid fa-boxes-stacked fa-2xl"></i></i>
                                                    </span>
                                                    <span class="title">Productos</span>
                                                </span>
                                                <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#ffffff"></path></svg>
                                            </a>    
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- <div class="col-lg-3">
                                    <div class="hexagon-item">
                                        <div class="hex-item">
                                            <div></div> <div></div> <div></div>
                                        </div>
                                        <div class="hex-item">
                                            <div></div> <div></div> <div></div>
                                        </div>
                                        
                                        <a  class="hex-content" onclick="abrirReportes()">
                                            <span class="hex-content-inner">
                                                <span class="icon">
                                                    <i id='iconoMPanal'><i class="fa-solid fa-file-invoice fa-2xl"></i></i>
                                                </span>
                                                <span class="title">Reportes</span>
                                            </span>
                                            <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#ffffff"></path></svg>
                                        </a>    
                                    </div>
                                </div> -->
                                
                                <!-- <div class="col-lg-3">
                                    <div class="hexagon-item">
                                        <div class="hex-item">
                                            <div></div> <div></div> <div></div>
                                        </div>
                                        <div class="hex-item">
                                            <div></div> <div></div> <div></div>
                                        </div>
                                        
                                        <a  class="hex-content" onclick="abrirResponsivas()">
                                            <span class="hex-content-inner">
                                                <span class="icon">
                                                    <i id='iconoMPanal'><i class="fa-solid fa-file-signature fa-2xl"></i></i>
                                                </span>
                                                <span class="title">Responsivas</span>
                                            </span>
                                            <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#ffffff"></path></svg>
                                        </a>    
                                    </div>
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <?php pintarFooter()?>

</body>

</html>