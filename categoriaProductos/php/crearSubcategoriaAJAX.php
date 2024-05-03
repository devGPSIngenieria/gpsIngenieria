<?php

    include "../../fGenerales/bd/conexion.php";

    $subcategoria = filter_input(INPUT_GET, "subcategoria");

    $conexionCrearCategoria = new conexion;
    $queryCrearCategoria = "INSERT INTO subcategoria (nombre, id_estado) VALUES ('".$subcategoria."', 1)";

    $resultado = [];

    if ($conexionCrearCategoria->conn->query($queryCrearCategoria)) {

        $conexionTraerCategorias = new conexion;
        $queryTraerCategorias = "SELECT * FROM subcategoria";
    
        $datos = $conexionTraerCategorias->conn->query($queryTraerCategorias);

        $resultado["noDatos"] = $datos->num_rows;

        foreach($datos->fetch_all() as $index => $dato){
            $resultado[$index]["id"] = $dato[0];
            $resultado[$index]["nombre"] = $dato[1];
        }

        $resultado["resultado"] = true;
    } else {

        $resultado["resultado"] = false;
    }
    echo json_encode($resultado);
?>