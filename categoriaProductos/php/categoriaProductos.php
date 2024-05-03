<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";

    pantallaCarga('on');
?>
<!DOCTYPE html>

    <html lang="en">

    <head>
        <?php pintarHead('Cat. Productos'); ?>
    </head>

    <?php
        $conexionCategorias = new conexion;
        $queryCategorias = "SELECT * FROM categoria ";
        $resultados = $conexionCategorias->conn->query($queryCategorias);

        $conexionSubcategorias = new conexion;
        $querySubcategorias = "SELECT * FROM subcategoria ";
        $resultadosSubcategorias = $conexionSubcategorias->conn->query($querySubcategorias);

        session_name('gpsingenieria');
        session_start();

        $datos = checarPermisosSeccion($_SESSION['usuarioid']);
    ?>

    <body class="justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">

        <!-- NAVBAR -->
        <?php pintarNavBar(); ?>

        <div class="contenedorCont">

            <div class="col-12">

                <?php pintarEncabezado('Categorias Productos','<i class="fa-regular fa-object-ungroup fa-2xl"></i>', ''); ?>

                <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">

                    <div class="col-12 cont-botones-secciones">
                        <?php     
                            foreach($datos->fetch_all() as $dato){
                                if($dato[1]==4){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                                            <span class="button_lg">
                                                <span class="button_sl"></span>
                                                <span class="button_text">Catálogo categorías</span>
                                            </span>
                                        </button>';
                                }
                                if($dato[1]==9){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(4)">
                                            <span class="button_lg">
                                                <span class="button_sl"></span>
                                                <span class="button_text">Catálogo subcategorías</span>
                                            </span>
                                        </button>';
                                }
                                if($dato[1]==5){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(2)">
                                            <span class="button_lg">
                                                <span class="button_sl"></span>
                                                <span class="button_text">Registro categorías</span>
                                            </span>
                                        </button>';
                                }
                                if($dato[1]==6){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(3)">
                                            <span class="button_lg">
                                                <span class="button_sl"></span>
                                                <span class="button_text">Registro subcategorías</span>
                                            </span>
                                        </button>';
                                }
                            }
                        ?>
                    </div>

                </div>

                <!-- CATALOGO CATEGORIAS -->
                <div class="row" id="catalogoCategorias" style="display: none;">
                
                    <div class="card_content">

                        <div class="row">
                            <div class="col-12 text-center">
                                <label class="text-subtitle">Catálogo de categorías productos</label>
                            </div>

                            <form id="frmFiltrosCatalogoCategorias">
                                <div class="row justify-content-center">

                                    <div class="col-sm-12 col-md-4">
                                        <!-- FILTRO POR NUMERO DE PARTE -->
                                        <div class="inputContainer">
                                            <input id="filtroNombre" name="filtroNombre" class="inputField" required="" type="text" placeholder="Filtrar por categoría" onkeyup="actualizarCategoria()">
                                            <label class='usernameLabel' for='filtroNombre'>Nombre categoría</label>
                                            <i class="userIcon fa-solid fa-text-width"></i>
                                        </div>
                                    </div>

                                </div>
                            </form>

                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="tablaCatalogoCategorias" class="table">
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- CATALOGO SUBCATEGORIAS -->
                <div class="row" id="catalogoSubcategoria" style="display: none;">
                    
                    <div class="card_content">

                        <div class="col-12 text-center">
                            <label class="text-subtitle">Catálogo de subcategorías productos</label>
                        </div>
                        
                        <form id="frmFiltrosCatalogoSubcategorias">
                            <div class="row justify-content-center">

                                <div class="col-sm-12 col-md-4">
                                    <!-- FILTRO POR NUMERO DE PARTE -->
                                    <div class="inputContainer">
                                        <input id="filtroNombre" name="filtroNombre" class="inputField" required="" type="text" placeholder="Filtrar por subcategoría" onkeyup="actualizarSubcategoria()">
                                        <label class='usernameLabel' for='filtroNombre'>Nombre subcategoría</label>
                                        <i class="userIcon fa-solid fa-text-width"></i>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id="tablaCatalogoSubcategorias" class="table">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- REGISTRO CATEGORIAS-->
            <div class="row" id="registrosCategorias" style="display: none;">
                <div class="card_content">
                    
                    <div class="col-12 text-center">
                        <label class="text-subtitle">Registro de categoría de productos</label>
                    </div>

                    <div class="col-sm-12">
                        <form class="row justify-content-center" id="frmRegistroCategoria">
                                        
                            <div class="col-sm-12 col-md-6">
                                <div class="inputContainer">
                                    <input id="categoria" name="categoria" class="inputField" required="" type="text" placeholder="Escriba el nombre de la categoría" maxlength="50">
                                    <label class='usernameLabel' for='categoria'>Nombre de categoría</label>
                                    <i class="userIcon fa-solid fa-text-width"></i>
                                </div>
                            </div>
                            
                            <div class="contenedor-boton-gen">
                                <div class="main_div">
                                    <a onclick="crearCategoria()">GUARDAR</a>
                                </div>
                            </div>

                        </form>
                    </div>
                
                </div>
            </div>
            
            <!-- REGISTRO SUBCATEGORIAS-->
            <div class="row" id="registrosSubcategorias" style="display: none;">
                <div class="card_content">

                    <div class="col-12 text-center">
                        <label class="text-subtitle">Registro de subcategoría de productos</label>
                    </div>

                    <div class="col-sm-12">
                        <form class="row justify-content-center" id="frmRegistroSubcategoria">
                                        
                            <div class="col-sm-12 col-md-6">
                                <div class="inputContainer">
                                    <input id="subcategoria" name="subcategoria" class="inputField" required="" type="text" placeholder="Escriba el nombre de la subcategoría" maxlength="50">
                                    <label class='usernameLabel' for='subcategoria'>Nombre de subcategoría</label>
                                    <i class="userIcon fa-solid fa-text-width"></i>
                                </div>
                            </div>
                            
                            <div class="contenedor-boton-gen">
                                <div class="main_div">
                                    <a onclick="crearSubCategoria()">GUARDAR</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="modalModificarCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">

                            <div class="col-12 text-center">
                                <label class="text-subtitle">Modificar categoría</label>
                            </div>

                            <form id="frmModificarCategoria" class="row justify-content-center">
                                <input type="text" id="id" name="id" hidden>

                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input id="nombre" name="nombre" class="inputField" required="" type="text" placeholder="Escriba nombre de la categoría" maxlength="50">
                                        <label class='usernameLabel' for='nombre'>Nombre de categoría</label>
                                        <i class="userIcon fa-solid fa-text-width"></i>
                                    </div>
                                </div>
                            </form>

                            <div class="contenedor-boton-gen">
                                <div class="main_div">
                                    <a onclick="modificarCategoria()">GUARDAR</a>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="modalModificarSubcategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">

                            <div class="col-12 text-center">
                                <label class="text-subtitle">Modificar subcategoría</label>
                            </div>

                            <form id="frmModificarSubcategoria" class="row justify-content-center">
                                <input type="text" id="id" name="id" hidden>

                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input id="nombre" name="nombre" class="inputField" required="" type="text" placeholder="Escriba nombre de la subcategoría" maxlength="50">
                                        <label class='usernameLabel' for='nombre'>Nombre de subcategoría</label>
                                        <i class="userIcon fa-solid fa-text-width"></i>
                                    </div>
                                </div>
                            </form>

                            <div class="contenedor-boton-gen">
                                <div class="main_div">
                                    <a onclick="modificarSubcategoria()">GUARDAR</a>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <?php pintarFooter();?>
    </body>

</html>