<?php

    include "../../fGenerales/bd/conexion.php";
    
    $resultados = [];
    
    if (isset($_GET['idCategoria']) ) {

        $idCategoria = $_GET['idCategoria'];
            
        $conexionSubcategorias = new conexion;
        $querySubcategorias = "SELECT * FROM subcategoria Where id_categoria = " . $idCategoria;
        $subcategorias = $conexionSubcategorias->conn->query($querySubcategorias);

        $resultados["noDatos"] = $subcategorias->num_rows;

        if($subcategorias->num_rows > 0){

            foreach ($subcategorias->fetch_all() as $index => $subcategoria) {

                $resultados[$index]["value"] = $subcategoria[0];
                $resultados[$index]["name"] = $subcategoria[1];

            }
            $resultados["resultado"] = 1;
        } else {
            $resultados["resultado"] = 0;
        }

    
    } else {
        $resultados["resultado"] = 0;
    }

    echo json_encode($resultados);
?>