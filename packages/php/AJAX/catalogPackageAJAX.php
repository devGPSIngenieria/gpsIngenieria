<?php
    include "../../../fGenerales/bd/conexion.php";
    
    $resultados = [];

    if (isset($_GET['nombre'])) {

        $cadenaQuery = '';
        if($_GET['nombre'] != ''){
            $cadenaQuery .= " AND nombre LIKE '%" . $_GET['nombre'] . "%'";
        }

        // TRAER CATEGORIAS
        $conexionTraePackages = new conexion;
        $queryTraePackages = "SELECT * FROM categoria WHERE id_estado = 1 AND package = 1 " . $cadenaQuery;
        $datos = $conexionTraePackages->conn->query($queryTraePackages);
        
        if ($datos) {

            $resultados["noDatos"] = $datos->num_rows;

            foreach($datos->fetch_all(MYSQLI_ASSOC) as $i => $dato){
                $resultados["categorias"][$i] = [
                    "id" => $dato['id_categoria'],
                    "nombre" => $dato['nombre'],
                    "id_estado" => $dato['id_estado'],
                    "package" => $dato['package'],
                    "price" => $dato['price'],
                    "packages" => []
                ];

                // TRAER PACKAGES
                $conexionTraeProd = new conexion;
                $queryTraeProd = "SELECT * FROM packages WHERE id_estado = 1 AND id_categoria = " . $dato['id_categoria'];
                $datosP = $conexionTraeProd->conn->query($queryTraeProd);

                if ($datosP && $datosP->num_rows > 0) {
                    foreach($datosP->fetch_all(MYSQLI_ASSOC) as $j => $datoP){
                        $resultados["categorias"][$i]["packages"][$j] = $datoP;
                    }
                } else {
                    // $resultados["categorias"][$i]["packages"][$j];
                }
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
