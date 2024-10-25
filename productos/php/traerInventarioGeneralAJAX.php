<?php
include "../../fGenerales/bd/conexion.php";
    
$resultados = [];
    
    if (isset($_GET['numParte']) && isset($_GET['descripcion']) && isset($_GET['numSerie']) && isset($_GET['detallado']) ) {
        
        $cadenaQuery = '';
        if($_GET['numParte'] != ''){
            $cadenaQuery .= " AND p.no_parte LIKE '%" . $_GET['numParte'] . "%'";
        }
        if($_GET['descripcion'] != ''){
            $cadenaQuery .= " AND p.descripcion LIKE '%" . $_GET['descripcion'] . "%'";
        }
        if($_GET['numSerie'] != ''){
            $cadenaQuery .= " AND i.no_serial LIKE '%" . $_GET['numSerie'] . "%'";
        }
        if($_GET['fechaInicio'] != '' && $_GET['fechaFin'] != ''){
            $fechaInicio = date('Y-m-d 00:00:00', strtotime($_GET['fechaInicio']));
            $fechaFin = date('Y-m-d 23:59:59', strtotime($_GET['fechaFin']));
                
            $cadenaQuery .= " AND i.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
        if($_GET['fechaInicio'] != '' && $_GET['fechaFin'] == ''){
            $fechaInicio = date('Y-m-d 00:00:00', strtotime($_GET['fechaInicio']));
            $fechaFin = date('Y-m-d 23:59:59', strtotime($_GET['fechaInicio']));
                
            $cadenaQuery .= " AND i.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
        if($_GET['fechaInicio'] == '' && $_GET['fechaFin'] != ''){
            $fechaInicio = date('Y-m-d 00:00:00', strtotime($_GET['fechaFin']));
            $fechaFin = date('Y-m-d 23:59:59', strtotime($_GET['fechaFin']));
                
            $cadenaQuery .= " AND i.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
        if($_GET['idsProductos'] != ''){
            $cadenaQueryIds = " AND i.id_inventario not in (".$_GET['idsProductos'].") ";
            $cadenaQueryIds2 = " AND id_inventario not in (".$_GET['idsProductos'].") ";
        } else {
            $cadenaQueryIds = "";
            $cadenaQueryIds2 = "";
        }
            
        $conexionProductos = new conexion;

        $detallado = $_GET['detallado'];
            
        if($detallado == 'true'){

            $resultados["detallado"] = 1; //CATALOGO DETALLADO

            $queryProductos = "SELECT i.id_inventario, i.id_producto, i.no_serial, p.no_parte, p.descripcion, i.fecha_registro, i.tipo_movimiento" 
                                ." FROM productos p, inventario i"
                                ." WHERE i.id_producto = p.id_producto AND i.tipo_movimiento = (1 or 2) AND i.id_estado = 1 " . $cadenaQuery . " " . $cadenaQueryIds;
            $datos = $conexionProductos->conn->query($queryProductos);

            if ($conexionProductos->conn->query($queryProductos)) {
                    
                $resultados["noDatos"] = $datos->num_rows;

                if($datos->num_rows > 0){
                    foreach ($datos->fetch_all() as $i => $datos) {
                        $resultados[$i]["id_inventario"] = $datos[0];
                        $resultados[$i]["id_producto"] = $datos[1];
                        $resultados[$i]["no_serial"] = $datos[2];
                        $resultados[$i]["no_parte"] = $datos[3];
                        $resultados[$i]["descripcion"] = $datos[4];
                        $resultados[$i]["fecha_registro"] = $datos[5];
                        $resultados[$i]["tipo_movimiento"] = $datos[6];
                    }

                    $resultados["resultado"] = 1;
                } else {
                    $resultados["resultado"] = 2;
                }
            }

        } else {
            $resultados["detallado"] = 0; //CATALOGO GENERAL

            $queryProductos = "SELECT total_registros.existentes, p.no_parte, p.descripcion, max_inventario.id_inventario"
            . " FROM productos p"
            . " JOIN ("
                ." SELECT COUNT(*) as existentes, id_producto"
                ." FROM inventario"
                ." WHERE tipo_movimiento IN (1, 2) AND id_estado = 1 ".$cadenaQueryIds2.""
                ." GROUP BY id_producto"
            ." ) AS total_registros ON p.id_producto = total_registros.id_producto"
            ." JOIN ("
                ." SELECT MAX(id_inventario) AS id_inventario, id_producto"
                ." FROM inventario"
                ." WHERE id_estado = 1 AND tipo_movimiento = (1 or 2) ".$cadenaQueryIds2.""
                ." GROUP BY id_producto"
            ." ) AS max_inventario ON p.id_producto = max_inventario.id_producto";

            $datos = $conexionProductos->conn->query($queryProductos);

            if ($datos) {
                $resultados["noDatos"] = $datos->num_rows;

                if ($datos->num_rows > 0) {
                    foreach ($datos->fetch_all() as $i => $datos) {
                    $resultados[$i]["existentes"] = $datos[0];
                    $resultados[$i]["no_parte"] = $datos[1];
                    $resultados[$i]["descripcion"] = $datos[2];
                    $resultados[$i]["id_inventario"] = $datos[3];
                    }

                    $resultados["resultado"] = 1;
                } else {
                    $resultados["resultado"] = 2;
                }
            } else {
                $resultados["resultado"] = 0;
            }
        } 
    }
    
    echo json_encode($resultados);
?>