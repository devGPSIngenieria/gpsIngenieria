<?php
include "../../fGenerales/bd/conexion.php";
    
$resultados = [];
    
    if (isset($_GET['idResponsiva']) ) {
        
        $idResponsiva = $_GET['idResponsiva'];

        $conReturnsCatalog = new conexion;
        $queryReturns = "SELECT i.id_inventario, i.id_producto, i.no_serial, p.no_parte, p.descripcion, i.fecha_registro, i.tipo_movimiento" 
                                ." FROM productos p, inventario i, relacion_responsiva_productos r, responsivas r2"
                                ." WHERE r2.id_responsiva = ".$idResponsiva." AND r.id_responsiva = r2.id_responsiva AND r.id_inventario = i.id_inventario AND i.id_producto = p.id_producto AND r2.id_estado=1 AND i.tipo_movimiento=3";
        $datos = $conReturnsCatalog->conn->query($queryReturns);

        if ($conReturnsCatalog->conn->query($queryReturns)) {
                
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
        $resultados["resultado"] = 0;
    }

    $resultados["debug"] = $queryReturns;
    
    echo json_encode($resultados);
?>