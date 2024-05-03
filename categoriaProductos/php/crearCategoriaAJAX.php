<?php

    include "../../fGenerales/bd/conexion.php";

    $nombre = filter_input(INPUT_GET, "categoria");

    $conexionCrearCategoria = new conexion;
    $queryCrearCategoria = "INSERT INTO categoria (nombre, id_estado) VALUES ('".$nombre."', 1)";

    $resultado = [];

    if ($conexionCrearCategoria->conn->query($queryCrearCategoria)) {

        $conexionTraerCategorias = new conexion;
        $queryTraerCategorias = "SELECT * FROM categoria";
    
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