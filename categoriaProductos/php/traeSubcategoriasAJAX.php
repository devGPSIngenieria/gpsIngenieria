<?php
    include "../../fGenerales/bd/conexion.php";
    
    $resultados = [];
    
    if (isset($_GET['nombre'])) {

        $cadenaQuery = '';
        if($_GET['nombre'] != ''){
            $cadenaQuery .= " AND nombre LIKE '%" . $_GET['nombre'] . "%'";
        }

        //TRAER CATEGORIAS
        $conexionTraerSubcategorias = new conexion;
        $queryTraerSubcategorias = "SELECT * FROM subcategoria WHERE id_estado = 1 " . $cadenaQuery;
        $datos = $conexionTraerSubcategorias->conn->query($queryTraerSubcategorias);
        
        if ($conexionTraerSubcategorias->conn->query($queryTraerSubcategorias)) {

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