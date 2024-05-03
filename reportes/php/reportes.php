<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";

    pantallaCarga('on');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php pintarHead('Reportes') ?>
</head>

<!-- //BUSCANDO Productos -->

<?php
// CREANDO LA CONSULTA PARA TRAER LAS ENTRADAS Y SALIDAS
$conexionProductos = new conexion;
$queryProductos = "SELECT p.*,c.nombre  FROM productos p , categoriasproductos c  WHERE c.idcategoriaproducto = p.categoria ";
$resultados = $conexionProductos->conn->query($queryProductos);

//checando permisos del usuario en la seccion

session_name('gpsingenieria');
session_start();

$datos = checarPermisosSeccion($_SESSION['usuarioid']);
?>


<body class=" justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">
    
    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>

    <div class="contenedorCont">

        <?php pintarEncabezado('Reportes','<i class="fa-solid fa-file-invoice fa-2xl"></i>','')?>

        <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">

            <div class="col-12">
                <?php 
                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                            <span class="button_lg">
                                <span class="button_sl"></span>
                                <span class="button_text">Reportes</span>
                            </span>
                        </button>';
                ?>
            </div>

        </div>

        <div id="reporteES" style="display: none;">
            
            <div class="col-12">
                <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">

                    <div class="col-sm-12 col-md-4">
                        <div class="inputContainer">
                            <select type="text" id="filtroTipo" name="filtroTipo" class="inputField" required="" placeholder="Seleccione categoría">
                                <?php
                                    print_r("<option value=0 >Categoría.../option>");
                                    print_r("<option value=1 >Ventas</option>");
                                    print_r("<option value=2 >Ordenes</option>");
                                    print_r("<option value=3 >Otros</option>");
                                ?>
                            </select>
                            <label class='usernameLabel' for='filtroTipo'>Categorías</label>
                            <i class="userIcon fa-regular fa-object-ungroup"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="inputContainer">
                            <select type="text" id="filtroMovimiento" name="filtroMovimiento" class="inputField" required="" placeholder="Seleccione categoría" onchange="filtrarProductos()">
                                <?php
                                    print_r("<option value=0 >Movimiento...</option>");
                                    print_r("<option value=1 >Entrada</option>");
                                    print_r("<option value=2 >Salida</option>");
                                ?>
                            </select>
                            <label class='usernameLabel' for='filtroMovimiento'>Movimiento</label>
                            <i class="userIcon fa-solid fa-timeline"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="inputContainer">
                            <input id="filtroProducto" name="filtroProducto" class="inputField" required="" type="text" placeholder="Escriba el producto" onkeyup="filtrarProductos()">
                            <label class='usernameLabel' for='filtroProducto'>Producto</label>
                            <i class="userIcon fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="inputContainer">
                            <input id="filtroFechaInicial" name="filtroFechaInicial" class="inputField" required="" type="date" placeholder="Ingrese la fecha inicial" onchange="filtrarProductos()">
                            <label class='usernameLabel' for='filtroFechaInicial'>Fecha inicial</label>
                            <i class="userIcon fa-solid fa-calendar-days"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="inputContainer">
                            <input id="filtroFechaFinal" name="filtroFechaFinal" class="inputField" required="" type="date" placeholder="Ingrese la fecha final" onchange="filtrarProductos()">
                            <label class='usernameLabel' for='filtroFechaFinal'>Fecha final</label>
                            <i class="userIcon fa-solid fa-calendar-days"></i>
                        </div>
                    </div>
                
                    <div class="contenedor-boton-gen">
                        <div class="main_div">
                            <button onclick="buscarES()">BUSCAR</button>
                        </div>
                    </div>

                </div>

                <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">
                    <div class="col-sm-12">
                        <div class="col-sm-12 text-center">
                            <label class="text-subtitle">Catalogo de productos</label>
                        </div>

                        <div class="col-sm-12">
                            <div class="table-responsive">

                                <table id="catalogoProductos" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">N.parte</th>
                                            <th class="text-center" scope="col">Descripcion</th>
                                            <th class="text-center" scope="col">Tipo</th>
                                            <th class="text-center" scope="col">Cantidad</th>   
                                            <th class="text-center" scope="col">Fecha</th>
                                            <th class="text-center" scope="col">Hora</th>     
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <img class="marcaAguaTabla" src="../../src/imagenes/logo.png">
                                        <!--LLENADO LOS DATOS DE LAS TABLAS   -->
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <?php pintarFooter()?>
    
</body>

</html>