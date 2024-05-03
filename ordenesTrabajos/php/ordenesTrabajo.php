<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";
    include "formularios.php";

    pantallaCarga('on');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php pintarHead('Ord. Trabajo') ?>
</head>

<!-- //BUSCANDO Ordenes de Trabajo -->

<?php

$conexionOrdenes = new conexion;
$queryOrdenes = "SELECT ot.numfolio,u.nombre ,c.nombre as nombrecliente , c.apellidos  ,ot.totalpago,ot.fecha,ot.ordenid,ot.saldopendiente,ot.factura,ot.flete  
FROM ordentrabajo ot,usuarios u,clientes c 
WHERE ot.idusuario = u.idusuario AND ot.idcliente = c.idcliente";
$resultados = $conexionOrdenes->conn->query($queryOrdenes);


session_name('gpsingenieria');
session_start();

$datos = checarPermisosSeccion($_SESSION['usuarioid']);

//var_dump($resultados);

?>


<body class=" justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">
    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>

    <div class="contenedorCont">
        <!-- //div principal -->
        <div class="col-12">

            <?php pintarEncabezado('Ordenes de Trabajo','<i class="fa-solid fa-person-digging fa-2xl"></i>', ''); ?>

            <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">

                <div class="col-12">
                    <?php
                        foreach ($datos->fetch_all() as $dato) {
                            if ($dato[1] == 14) {
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Catálogo</span>
                                        </span>
                                    </button>';
                            }
                        }
                    ?>

                </div>

            </div>

            <div id="catalogo" style="display: none;">

                <!-- FILTROS -->
                <div class="col-12">
                    <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">
                        
                        <div class="col-sm-12 col-md-4">
                            <div class="inputContainer">
                                <input id="filtroNFolio" name="filtroNFolio" class="inputField" required="" type="text" placeholder="Escriba el número de folio" onkeyup="filtrarOrdenes()">
                                <label class='usernameLabel' for='filtroNFolio'>N. folio</label>
                                <i class="userIcon fa-solid fa-text-width"></i>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="inputContainer">
                                <input id="filtroTrabajador" name="filtroTrabajador" class="inputField" required="" type="text" placeholder="Escriba el trabajador" onkeyup="filtrarOrdenes()">
                                <label class='usernameLabel' for='filtroTrabajador'>Trabajador</label>
                                <i class="userIcon fa-solid fa-person-circle-check"></i>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="inputContainer">
                                <input id="filtroCliente" name="filtroCliente" class="inputField" required="" type="text" placeholder="Escriba el cliente" onkeyup="filtrarOrdenes()">
                                <label class='usernameLabel' for='filtroCliente'>Cliente</label>
                                <i class="userIcon fa-solid fa-people-arrows"></i>
                            </div>
                        </div>
      
                        <div class="col-sm-12 col-md-6">
                            <div class="inputContainer">
                                <input id="filtroFechaI" name="filtroFechaI" class="inputField" required="" type="date" placeholder="Ingrese la fecha inicio" onchange="filtrarOrdenes()">
                                <label class='usernameLabel' for='filtroFechaI'>Fecha inicio</label>
                                <i class="userIcon fa-solid fa-calendar-days"></i>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="inputContainer">
                                <input id="filtroFechaF" name="filtroFechaF" class="inputField" required="" type="date" placeholder="Ingrese la fecha fin" onchange="filtrarOrdenes()">
                                <label class='usernameLabel' for='filtroFechaI'>Fecha fin</label>
                                <i class="userIcon fa-solid fa-calendar-days"></i>
                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">
                    <div class="col-sm-12">
                        <div class="col-12 text-center">
                            <label class="text-subtitle">Catálogo de productos</label>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                
                                <table id="catalogoProductos" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">N.Folio</th>
                                            <th class="text-center" scope="col">Trabajador</th>
                                            <th class="text-center" scope="col">Cliente</th>
                                            <th class="text-center" scope="col">Factura</th>
                                            <th class="text-center" scope="col">Pago Total</th>
                                            <th class="text-center" scope="col">Flete</th>
                                            <th class="text-center" scope="col">Deuda</th>
                                            <th class="text-center" scope="col">Pagos</th>
                                            <th class="text-center" scope="col">Fecha</th>
                                            <th class="text-center" scope="col">Orden de Trabajo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <img class="marcaAguaTabla" src="../../src/imagenes/logo.png">
                                        <!--LLENADO LOS DATOS DE LAS TABLAS   -->
                                    <?php
                                        foreach ($resultados->fetch_all() as $columna) {
                                            echo " <tr>
                                                <td class=\"text-center\">" . $columna[0] . "</td>
                                                <td class=\"text-center\">" . $columna[1] . "</td>
                                                <td class=\"text-center\">" . $columna[2] . " " . $columna[3] . "</td>";
                                                
                                            if ($columna[8] != "") {
                                                echo   "<td class=\"text-center\"><div style=\"margin-right: 10px;\">" . $columna[8] . "</div><img src=\"../../src/imagenes/bills.svg\" width=\"40px\" onclick=\"abrirEvidenciaFactura(".$columna[6].")\"></td>";
                                            } else {
                                                echo   "<td class=\"text-center\"><img src=\"../../src/imagenes/agregargps.png\" onclick=\"abrirModalFacturaAgregar(" . $columna[6] . ")\" width=\"40px\"></td>";
                                            }

                                            echo  "<td class=\"text-center\">" . $columna[4] . "</td>
                                                <td class=\"text-center\">" . $columna[9] . "</td>
                                                <td class=\"text-center\">$columna[7]</td>
                                                <td class=\"text-center\"><img src=\"../../src/imagenes/pagos.png\"   width=\"40px\" onclick=\"abrirPagos(" . $columna[6] . ")\"></td>
                                                <td class=\"text-center\">" . $columna[5] . "</td>
                                                <td class=\"text-center\"><img src=\"../../src/imagenes/pdf.png\" width=\"50\"  onclick=\"checarOrden(" . $columna[6] . ")\"></td>
                                                </tr>";
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title text-center" id="exampleModalLabel" style="font-size: 30px;">Pagos</label>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <?php frmpagos() ?>
                        <?php frmFacturas() ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnNuevoPago" onclick="nuevoPago()">Nuevo pago</button>
                        <button type="button" class="btn btn-secondary" onclick="cerrarPago()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <?php pintarFooter()?>

</body>

</html>