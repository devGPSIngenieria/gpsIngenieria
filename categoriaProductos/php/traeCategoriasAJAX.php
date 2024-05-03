<?php
    include "../../fGenerales/bd/conexion.php";
    
    $resultados = [];
    
    if (isset($_GET['nombre'])) {

        $cadenaQuery = '';
        if($_GET['nombre'] != ''){
            $cadenaQuery .= " AND nombre LIKE '%" . $_GET['nombre'] . "%'";
        }

        //TRAER CATEGORIAS
        $conexionTraerCategorias = new conexion;
        $queryTraerCategorias = "SELECT * FROM categoria WHERE id_estado = 1 " . $cadenaQuery;
        $datos = $conexionTraerCategorias->conn->query($queryTraerCategorias);
        
        if ($conexionTraerCategorias->conn->query($queryTraerCategorias)) {

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