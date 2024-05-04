<?php
include "../../fGenerales/bd/conexion.php";
    
$resultados = [];
    
    if (isset($_GET['numParte']) && isset($_GET['descripcion']) && isset($_GET['numSerie']) ) {
        
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
                
            $cadenaQuery .= " AND d.fechadevolucion BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
        if($_GET['fechaInicio'] != '' && $_GET['fechaFin'] == ''){
            $fechaInicio = date('Y-m-d 00:00:00', strtotime($_GET['fechaInicio']));
            $fechaFin = date('Y-m-d 23:59:59', strtotime($_GET['fechaInicio']));
                
            $cadenaQuery .= " AND d.fechadevolucion BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
        if($_GET['fechaInicio'] == '' && $_GET['fechaFin'] != ''){
            $fechaInicio = date('Y-m-d 00:00:00', strtotime($_GET['fechaFin']));
            $fechaFin = date('Y-m-d 23:59:59', strtotime($_GET['fechaFin']));
                
            $cadenaQuery .= " AND d.fechadevolucion BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
            
        $conDevolucion = new conexion;
        $queryDevolucion = "SELECT d.fechadevolucion, p.no_parte, p.descripcion, i.no_serial" 
                                ." FROM devoluciones d, inventario i,  productos p"
                                ." WHERE d.id_estado = 1 AND i.id_inventario = d.id_inventario AND i.id_producto = p.id_producto " . $cadenaQuery;
        $datos = $conDevolucion->conn->query($queryDevolucion);

        if ($conDevolucion->conn->query($queryDevolucion)) {
                
            $resultados["noDatos"] = $datos->num_rows;

            if($datos->num_rows > 0){
                foreach ($datos->fetch_all() as $i => $datos) {
                    $resultados[$i]["fechadevolucion"] = $datos[0];
                    $resultados[$i]["no_parte"] = $datos[1];
                    $resultados[$i]["descripcion"] = $datos[2];
                    $resultados[$i]["no_serial"] = $datos[3];
                }
                $resultados["resultado"] = 1;
            } else {
                $resultados["resultado"] = 2;
            }
        }
     
    }
    
    echo json_encode($resultados);
?>