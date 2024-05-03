<?php

    include "../../fGenerales/bd/conexion.php";

    $nParte = filter_input(INPUT_POST, "nParte");
    $descripcion = filter_input(INPUT_POST, "descripcion");
    $precioPublico = filter_input(INPUT_POST, "precioPublico");
    $precioVenta = filter_input(INPUT_POST, "precioVenta");
    $categoria = filter_input(INPUT_POST, "categoria");
    $subcategoria = filter_input(INPUT_POST, "subcategoria");

    $conexionCrearProducto = new conexion;
    $queryCrearProducto = "INSERT INTO productos(no_parte, descripcion, precio_public, precio_venta, id_categoria, id_subcategoria, id_estado)". 
                            "VALUES ('".$nParte."', '".$descripcion."', '".$precioPublico."', '".$precioVenta."', ".$categoria.", ".$subcategoria.", 1)";

    $resultados = [];

    if ($conexionCrearProducto->conn->query($queryCrearProducto)) {


        $conexionDatos = new conexion;
        $queryDatos = "SELECT p.*,c.nombre  FROM productos p , categoria c  WHERE c.id_categoria = p.id_categoria ";
        $datos = $conexionDatos->conn->query($queryDatos);

        $resultados["noDatos"] = $datos->num_rows;

        foreach ($datos->fetch_all() as $i => $datos) {
            $resultados[$i]["id_producto"] = $datos[0];
            $resultados[$i]["no_parte"] = $datos[1];
            $resultados[$i]["descripcion"] = $datos[2];
            $resultados[$i]["precio_public"] = $datos[3];
            $resultados[$i]["precio_venta"] = $datos[4];
            $resultados[$i]["id_categoria"] = $datos[5];
            $resultados[$i]["id_subcategoria"] = $datos[6];
            $resultados[$i]["id_estado"] = $datos[7];
        }
        $resultados["resultado"] = true;

    } else {
        $resultados["resultado"] = false;
    }

    echo json_encode($resultados);
?>