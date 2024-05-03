<?php
include "../../fGenerales/bd/conexion.php";
    
$resultados = [];
    
    if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin']) && isset($_GET['empleado']) && isset($_GET['firmado']) ) {
        
        $cadenaQuery = '';

        if($_GET['fechaInicio'] != '' && $_GET['fechaFin'] != ''){
            $fechaInicio = date('Y-m-d 00:00:00', strtotime($_GET['fechaInicio']));
            $fechaFin = date('Y-m-d 23:59:59', strtotime($_GET['fechaFin']));
                
            $cadenaQuery .= " AND r.fechacreacion BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
        if($_GET['fechaInicio'] != '' && $_GET['fechaFin'] == ''){
            $fechaInicio = date('Y-m-d 00:00:00', strtotime($_GET['fechaInicio']));
            $fechaFin = date('Y-m-d 23:59:59', strtotime($_GET['fechaInicio']));
                
            $cadenaQuery .= " AND r.fechacreacion BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
        if($_GET['fechaInicio'] == '' && $_GET['fechaFin'] != ''){
            $fechaInicio = date('Y-m-d 00:00:00', strtotime($_GET['fechaFin']));
            $fechaFin = date('Y-m-d 23:59:59', strtotime($_GET['fechaFin']));
                
            $cadenaQuery .= " AND r.fechacreacion BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ";
        }
        if($_GET['empleado'] != 0){
            $cadenaQuery .= " AND r.idempleado = " . $_GET['empleado'];
        }
        if($_GET['firmado'] != 0){
            $cadenaQuery .= " AND r.id_firma = " . $_GET['firmado'];
        }

        $conexionResponsiva = new conexion;
        $queryResponsiva = "SELECT r.id_responsiva, r.idempleado, r.id_usuariocreador, r.fechacreacion, CONCAT(e.nombre,' ',e.apellidos), r.id_firma, r.comentario";
        $queryResponsiva .= " FROM responsivas r, empleados e";
        $queryResponsiva .= " WHERE r.id_estado = 1 and r.idempleado = e.idempleado" . $cadenaQuery;

        $datos = $conexionResponsiva->conn->query($queryResponsiva);

        if ($conexionResponsiva->conn->query($queryResponsiva)) {
                
            $resultados["noDatos"] = $datos->num_rows;

            if($datos->num_rows > 0){
                foreach ($datos->fetch_all() as $i => $datos) {
                    $resultados[$i]["id_responsiva"] = $datos[0];
                    $resultados[$i]["idempleado"] = $datos[1];
                    $resultados[$i]["id_usuariocreador"] = $datos[2];
                    $resultados[$i]["fecha_creacion"] = $datos[3];
                    $resultados[$i]["nombreResponsable"] = $datos[4];
                    $resultados[$i]["firma"] = $datos[5];
                    $resultados[$i]["comentarios"] = $datos[6];
                }

                $resultados["resultado"] = 1;
            } else {
                $resultados["resultado"] = 2;
            }
        }
    } else { 
        $resultados["resultado"] = 0;
    }
    $resultados['debug'] = $queryResponsiva;
    
    echo json_encode($resultados);
?>