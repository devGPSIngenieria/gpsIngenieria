<?php

    include "../../../fGenerales/bd/conexion.php";

    $name = filter_input(INPUT_POST, "namePackage");
    $price = filter_input(INPUT_POST, "pricePackage");

    $conCreatePackage = new conexion;
    $queryCreatePackage = "INSERT INTO categoria (nombre, id_estado, package, price)". 
                            "VALUES ('".$name."', 1, 1, '".$price."')";

    $resultados = [];

    if ($conCreatePackage->conn->query($queryCreatePackage)) {
        
        $resultados["resultado"] = true;

    } else {
        $resultados["resultado"] = false;
    }

    echo json_encode($resultados);
?>