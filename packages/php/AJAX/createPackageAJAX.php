<?php

    include "../../../fGenerales/bd/conexion.php";

    $name = filter_input(INPUT_POST, "namePackage");
    $price = filter_input(INPUT_POST, "pricePackage");

    $conCreatePackage = new conexion;
    $queryCreatePackage = "INSERT INTO packages(name_package, id_estado, price)". 
                            "VALUES ('".$name."', 1, '".$price."')";

    $resultados = [];

    if ($conCreatePackage->conn->query($queryCreatePackage)) {


        // $conexionDatos = new conexion;
        // $queryDatos = "SELECT p.*,c.nombre  FROM productos p , categoria c  WHERE c.id_categoria = p.id_categoria ";
        // $datos = $conexionDatos->conn->query($queryDatos);

        // $resultados["noDatos"] = $datos->num_rows;

        // foreach ($datos->fetch_all() as $i => $datos) {
        //     $resultados[$i]["id_producto"] = $datos[0];
        //     $resultados[$i]["no_parte"] = $datos[1];
        //     $resultados[$i]["price"] = $datos[2];
        //     $resultados[$i]["precio_public"] = $datos[3];
        //     $resultados[$i]["precio_venta"] = $datos[4];
        //     $resultados[$i]["id_categoria"] = $datos[5];
        //     $resultados[$i]["id_subcategoria"] = $datos[6];
        //     $resultados[$i]["id_estado"] = $datos[7];
        // }
        $resultados["resultado"] = true;

    } else {
        $resultados["resultado"] = false;
    }

    echo json_encode($resultados);
?>