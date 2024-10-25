<?php
    include "../../../fGenerales/bd/conexion.php";
    
    $resultados = [];
    
    if (isset($_GET['nombre'])) {

        $cadenaQuery = '';
        if($_GET['nombre'] != ''){
            $cadenaQuery .= " AND nombre LIKE '%" . $_GET['nombre'] . "%'";
        }

        //TRAER PACKAGES
        $conexionTraerPackages = new conexion;
        $queryTraerPackages = "SELECT * FROM categoria WHERE id_estado = 1 and package = 1 " . $cadenaQuery;
        $datos = $conexionTraerPackages->conn->query($queryTraerPackages);
        
        if ($conexionTraerPackages->conn->query($queryTraerPackages)) {

            $resultados["noDatos"] = $datos->num_rows;

            foreach($datos->fetch_all() as $i => $dato){
                $resultados[$i]["id"] = $dato[0];
                $resultados[$i]["nombre"] = $dato[1];
            } 
            $resultados["resultado"] = 1;
            
        } else {
            $resultados["resultado"] = 2;
        }
    } else {
        $resultados["resultado"] = 0;
    }
    echo json_encode($resultados);
?>