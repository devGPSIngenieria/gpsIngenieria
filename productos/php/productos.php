<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";
    
    pantallaCarga('on');
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <?php pintarHead('Productos') ?>
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

                <?php pintarEncabezado('Productos','<i class="fa-solid fa-boxes-stacked fa-2xl"></i>','')?>

                <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">

                    <div class="col-12 cont-botones-secciones">
                        <?php 
                            foreach($datos->fetch_all() as $dato){

                                if($dato[1]==7){                                        
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                                            <span class="button_lg">
                                                <span class="button_sl"></span>
                                                <span class="button_text">Catálogo productos</span>
                                            </span>
                                        </button>';
                                }
                                if($dato[1]==8){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(2)">
                                            <span class="button_lg">
                                                <span class="button_sl"></span>
                                                <span class="button_text">Registrar productos</span>
                                            </span>
                                        </button>';
                                }
                                if($dato[1]==10){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(3)">
                                            <span class="button_lg">
                                                <span class="button_sl"></span>
                                                <span class="button_text">Catálogo entradas</span>
                                            </span>
                                        </button>';
                                }
                                if($dato[1]==13){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(5)">
                                            <span class="button_lg">
                                                <span class="button_sl"></span>
                                                <span class="button_text">Inventario General</span>
                                            </span>
                                        </button>';
                                }
                            
                                if($dato[1]==14){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(6)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Catálogo de responsivas</span>
                                        </span>
                                    </button>';
                                }

                                if($dato[1]==15){
                                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(4)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Subida masiva productos</span>
                                        </span>
                                    </button>';
                                }

                               
                                
                            }
                        ?>
                    </div>
                </div>

                <div class="row" id="catalogo" style="display: none;">
                    <div class="card_content">
                    
                        <form id="frmFiltosCatalogoProd">

                            <div class="row">

                                <div class="col-sm-12 col-md-3">
                                    <!-- FILTRO POR NUMERO DE PARTE -->
                                    <div class="inputContainer">
                                        <input id="filtroNParte" name="filtroNParte" class="inputField" required="" type="text" placeholder="Filtrar por número de parte" onkeyup="actualizaCatalogoProductos()">
                                        <label class='usernameLabel' for='filtroNParte'>Número de parte</label>
                                        <i class="userIcon fa-solid fa-hashtag"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <!-- FILTRO POR DESCRIPCIÓN -->
                                    <div class="inputContainer">
                                        <input id="filtroDescripcion" name="filtroDescripcion" class="inputField" required="" type="text" placeholder="Filtrar por descripción" onkeyup="actualizaCatalogoProductos()">
                                        <label class='usernameLabel' for='filtroDescripcion'>Descripción</label>
                                        <i class="userIcon fa-solid fa-align-left"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <!-- FILTRO POR CATEGORÍA -->
                                    <div class="inputContainer">
                                        <select id="filtroCategoria" name="filtroCategoria" class="inputField" required="" type="text" placeholder="Filtrar por categoría" onchange="actualizaCatalogoProductos()">
                                            <option value=0 selected>Todas</option>
                                            <?php
                                                $conexionCategorias = new conexion;
                                                $queryCategorias = "SELECT * FROM categoria";
                                                $categorias = $conexionCategorias->conn->query($queryCategorias);

                                                foreach ($categorias->fetch_all() as $index => $categoria) {

                                                    print_r("<option value=\"" . $categoria[0] . "\" >" . $categoria[1] . "</option>");
                                                }
                                            ?>
                                        </select>
                                        <label class='usernameLabel' for='filtroCategoria'>Categoría</label>
                                        <i class="userIcon fa-regular fa-object-ungroup"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <!-- FILTRO POR CATEGORÍA -->
                                    <div class="inputContainer">
                                        <select id="filtroSubcategoria" name="filtroSubcategoria" class="inputField" required="" type="text" placeholder="Filtrar por subcategoría" onchange="actualizaCatalogoProductos()">
                                            <option value=0 selected>Todas</option>
                                            <?php
                                                $conexionSubcategorias = new conexion;
                                                $querySubcategorias = "SELECT * FROM subcategoria";
                                                $subcategorias = $conexionSubcategorias->conn->query($querySubcategorias);

                                                foreach ($subcategorias->fetch_all() as $index => $subcategoria) {

                                                    print_r("<option value=\"" . $subcategoria[0] . "\" >" . $subcategoria[1] . "</option>");
                                                }
                                            ?>
                                        </select>
                                        <label class='usernameLabel' for='filtroSubcategoria'>Subcategoría</label>
                                        <i class="userIcon fa-regular fa-object-ungroup"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- TITULO DEL CONTENIDO -->
                        <div class="row justify-content-center">
                            <div id='section_catalogo' class="col-sm-12 text-center">
                                <label class="text-subtitle">Catálogo de productos</label>

                                <div class="table-responsive">
                                    <table id="tablaCatalogoProductos" class="table"></table>
                                </div>
                            </div>

                            <div id='section_entradas' class="col-sm-12 col-md-6 text-center" hidden>
                                <label class="text-subtitle">Agregar entradas</label>

                                <div class="table-responsive">
                                    <table id="tablaEntradas" class="table"></table>
                                </div>
                                
                                <div class="contenedor-boton-gen">
                                    <div class="main_div">
                                        <a onclick="insertarEntradaProd()">GUARDAR</a>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12">
                <!-- FORMULARIO DE REGISTRO DE PRODUCTOS-->
                <form class="justify-content-center" id="frmRegistroProductos" method="POST" enctype="multipart/form-data" style="display: none;">
                    
                    <div class="card_content">
                        <div class="row">
                            <div class="col-12 text-center">
                                <label class="text-subtitle">Registro de productos</label>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="inputContainer">
                                    <input id="nParte" name="nParte" class="inputField" required="" type="text" placeholder="Escriba el número de parte" maxlength="50">
                                    <label class='usernameLabel' for='nParte'>Número de parte</label>
                                    <i class="userIcon fa-solid fa-hashtag"></i>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-8">
                                <div class="inputContainer">
                                    <textarea type="text" id="descripcion" name="descripcion" class="inputField" required="" placeholder="Escriba descripción" maxlength="200"></textarea>
                                    <label class='usernameLabel' for='descripcion'>Descripción</label>
                                    <i class="userIcon fa-solid fa-align-left"></i>
                                </div>
                            </div>
                
                            <div class="col-sm-12 col-md-3">
                                <div class="inputContainer">
                                    <input type="number" id="precioPublico" name="precioPublico" class="inputField" required="" placeholder="Escriba el precio por unidad" min="0" onkeyup="aceptaNumeros(this)">
                                    <label class='usernameLabel' for='precioPublico'>Precio con IVA público</label>
                                    <i class="userIcon fa-solid fa-dollar-sign"></i>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <div class="inputContainer">
                                    <input type="number" id="precioVenta" name="precioVenta" class="inputField" required="" placeholder="Escriba el precio por unidad" min="0" onkeyup="aceptaNumeros(this)">
                                    <label class='usernameLabel' for='precioVenta'>Precio venta</label>
                                    <i class="userIcon fa-solid fa-dollar-sign"></i>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <div class="inputContainer">
                                    <select type="text" id="categoria" name="categoria" class="inputField" required="" placeholder="Seleccione categoría">
                                        <option value=0 selected>...</option>
                                        <?php
                                            $conexionCategorias = new conexion;
                                            $queryCategorias = "SELECT * FROM categoria";
                                            $categorias = $conexionCategorias->conn->query($queryCategorias);

                                            foreach ($categorias->fetch_all() as $index => $categoria) {
                                                print_r("<option value=\"" . $categoria[0] . "\" >" . $categoria[1] . "</option>");
                                            }
                                        ?>
                                    </select>
                                    <label class='usernameLabel' for='categoria'>Categoría</label>
                                    <i class="userIcon fa-regular fa-object-ungroup"></i>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <div class="inputContainer">
                                    <select type="text" id="subcategoria" name="subcategoria" class="inputField" required="" placeholder="Seleccione subcategoría">
                                        <option value=0 selected>...</option>
                                        <?php
                                            $conexionCategorias = new conexion;
                                            $queryCategorias = "SELECT * FROM subcategoria";
                                            $categorias = $conexionCategorias->conn->query($queryCategorias);

                                            foreach ($categorias->fetch_all() as $index => $categoria) {
                                                print_r("<option value=\"" . $categoria[0] . "\" >" . $categoria[1] . "</option>");
                                            }
                                        ?>
                                    </select>
                                    <label class='usernameLabel' for='subcategoria'>Subcategoría</label>
                                    <i class="userIcon fa-regular fa-object-ungroup"></i>
                                </div>
                            </div>

                            <div class="contenedor-boton-gen">
                                <div class="main_div">
                                    <a onclick="crearProducto()">GUARDAR</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row" id="catalogoEntradas" style="display: none;">

                <!-- TITULO DEL CONTENIDO -->
                <div class="card_content">

                    <div class="row">
                        <div class="col-12 text-center">
                            <label class="text-subtitle">Catálogo de entradas</label>
                        </div>

                        <label class='containerCheck contenedorMargen' style="justify-content: left; margin-left: 20px; width: 200px; color: #899bbd; margin-bottom: 20px;">
                            Catálogo detallado
                            <input type='checkbox' id='checkCatalogoEntradasDetallado' onclick='actualizaCatalogoProductosEntradas();'>
                            <div class='checkmark'></div>
                        </label>

                        <form id="frmFiltosCatalogoProdEntradas" style="display: none;">
                            
                            <div class="row">

                                <div class="col-sm-12 col-md-4">
                                    <!-- FILTRO POR FECHA INICIO-->
                                    <div class="inputContainer">
                                        <input id="filtroFechaInicio" name="filtroFechaInicio" class="inputField" required="" type="date" placeholder="Filtrar por fecha inicio" onchange="actualizaCatalogoProductosEntradas()">
                                        <label class='usernameLabel' for='filtroFechaInicio'>Fecha inicio</label>
                                        <i class="userIcon fa-solid fa-calendar-days"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <!-- FILTRO POR FECHA FIN-->
                                    <div class="inputContainer">
                                        <input id="filtroFechaFin" name="filtroFechaFin" class="inputField" required="" type="date" placeholder="Filtrar por fecha fin" onchange="actualizaCatalogoProductosEntradas()">
                                        <label class='usernameLabel' for='filtroFechaFin'>Fecha fin</label>
                                        <i class="userIcon fa-solid fa-calendar-days"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <!-- FILTRO POR NUMERO DE PARTE -->
                                    <div class="inputContainer">
                                        <input id="filtroNParte" name="filtroNParte" class="inputField" required="" type="text" placeholder="Filtrar por número de parte" onkeyup="actualizaCatalogoProductosEntradas()">
                                        <label class='usernameLabel' for='filtroNParte'>Número de parte</label>
                                        <i class="userIcon fa-solid fa-hashtag"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <!-- FILTRO POR NUMERO DE SERIE -->
                                    <div class="inputContainer">
                                        <input id="filtroNoSerie" name="filtroNoSerie" class="inputField" required="" type="text" placeholder="Filtrar por número de serie" onkeyup="actualizaCatalogoProductosEntradas()">
                                        <label class='usernameLabel' for='filtroNoSerie'>Número de serie</label>
                                        <i class="userIcon fa-solid fa-barcode"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <!-- FILTRO POR DESCRIPCIÓN -->
                                    <div class="inputContainer">
                                        <input id="filtroDescripcion" name="filtroDescripcion" class="inputField" required="" type="text" placeholder="Filtrar por descripción" onkeyup="actualizaCatalogoProductosEntradas()">
                                        <label class='usernameLabel' for='filtroDescripcion'>Descripción</label>
                                        <i class="userIcon fa-solid fa-align-left"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <!-- FILTRO POR NUMERO DE ENTRADA -->
                                    <div class="inputContainer">
                                        <input id="filtroNumEntrada" name="filtroNumEntrada" class="inputField" required="" type="number" placeholder="Filtrar por numero de entrada" onkeyup="actualizaCatalogoProductosEntradas()">
                                        <label class='usernameLabel' for='filtroNumEntrada'>Número de entrada</label>
                                        <i class="userIcon fa-solid fa-hashtag"></i>
                                    </div>
                                </div>

                            </div>  
                        </form>

                        <div class="col-sm-12">
                            <!-- TABLA DONDE APARECEN LOS PRODUCTOS -->
                            <div class="table-responsive">
                                <table id="tablaCatalogoProductosEntradas" class="table">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- MODULO - SUBIDA MASIVA -->
            <?php include "subidaMasiva.php"?>
            <!-- MODULO - INVENTARIO GENERAL -->
            <?php include "generalInventory.php"?>
            <!-- MODULO - CATALOGO RESPONSIVAS -->
            <?php include "responsiveCatalog.php"?>

            <!-- MODAL MODIFICAR -->
            <div class="modal fade" id="miModalEditarProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            
                            <!-- TITULO DEL MODAL -->
                            <div class="col-12 text-center">
                                <label class="text-subtitle">Modificar producto</label>
                            </div>

                            <form id="frmModificarProducto" class="row justify-content-center">
                                <input type="text" id="id" name="id" hidden>
                                
                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input id="nParte" name="nParte" class="inputField" required="" type="text" placeholder="Escriba el número de parte" maxlength="50" disabled>
                                        <label class='usernameLabel' for='nParte'>Número de parte</label>
                                        <i class="fa-solid fa-hashtag userIcon"></i>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <textarea id="descripcion" name="descripcion" class="inputField" required="" type="text" placeholder="Escriba la descripción" maxlength="200"></textarea>
                                        <label class='usernameLabel' for='descripcion'>Descripción</label>
                                        <i class="fa-solid fa-align-left userIcon"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input id="precioPublico" name="precioPublico" class="inputField" required="" type="number" placeholder="Escriba el precio publico" min="0" onkeyup="aceptaNumeros(this)">
                                        <label class='usernameLabel' for='precioPublico'>Precio publico</label>
                                        <i class="fa-solid fa-dollar-sign userIcon"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input id="precioVenta" name="precioVenta" class="inputField" required="" type="number" placeholder="Escriba el precio venta" min="0" onkeyup="aceptaNumeros(this)">
                                        <label class='usernameLabel' for='precioVenta'>Precio venta</label>
                                        <i class="fa-solid fa-dollar-sign userIcon"></i>
                                    </div>
                                </div>

                                <div class="contenedor-boton-gen">
                                    <div class="main_div">
                                        <a onclick="modificarProducto()">GUARDAR</a>
                                    </div>
                                </div>
                             
                            </form>
                        </div>
                    
                    </div>
                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <?php pintarFooter()?>
        
    </body>
</html>