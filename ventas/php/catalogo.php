    <?php
        $conexionVentas = new conexion;
        $queryVentas = "SELECT v.nombre_cliente,CONCAT(IFNULL(e.nombre, ''), ' ', IFNULL(e.apellidos, '')),v.bandera_factura AS nombre_completo, v.id_venta  from ventas v
        join empleados e on v.empleadoid = e.idempleado ";
        $resultados = $conexionVentas->conn->query($queryVentas); 
    ?>


    <div class="row" id="catalogo" style="display: none;">
        <div class="card_content">
        
            <div class="col-12 text-center">
                <label class="text-subtitle">Catálogo de ventas</label>
            </div>
        
            <?php include "filtros.php" ?>

            <div class="col-12">
                <div class="table-responsive">
                    <table id="catalogoVentas" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Cliente</th>
                                <th class="text-center" scope="col">Trabajador</th>
                                <th class="text-center" scope="col">Factura</th>
                                <th class="text-center" colspan="1" scope="col">Venta</th>

                            </tr>
                        </thead>
                        <tbody>
                            <img class="marcaAguaTabla" src="../../src/imagenes/logo.png">
                            <?php
                            foreach ($resultados->fetch_all() as $datos) {
                                if($datos[2]==1){
                                $factura = "nesesita factura";
                                }else {
                                    $factura = "no nesesita factura";
                                }
                                echo "<tr><td>" . $datos[0] . "</td><td>" . $datos[1] . "</td><td>" . $factura. "</td><td><div class='cont-btn-tabla'><div data-toggle='tooltip' data-placement='top' title='ver pdf' class='cont-icono-tbl' onclick=\"descargarArchivo('../src/pdfSells/sell" . $datos[3] . ".pdf', 'Venta" . $datos[3] . ".pdf')\"><i class='fa-solid fa-file-pdf fa-xl'></i></div></div></td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>