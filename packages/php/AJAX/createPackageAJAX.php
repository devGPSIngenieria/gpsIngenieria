<?php

    include "../../../fGenerales/bd/conexion.php";

    $nParte = filter_input(INPUT_POST, "nParte");
    $descripcion = filter_input(INPUT_POST, "descripcion");
    $categoria = filter_input(INPUT_POST, "filtroPackage");

    $conexionCrearProducto = new conexion;
    $queryCrearProducto = "INSERT INTO packages(no_parte, descripcion, id_categoria, id_estado)". 
                            "VALUES ('".$nParte."', '".$descripcion."', ".$categoria.", 1)";

    $resultados = [];

    if ($conexionCrearProducto->conn->query($queryCrearProducto)) {

        $resultados["resultado"] = true;

    } else {
        $resultados["resultado"] = false;
    }

    echo json_encode($resultados);
?>