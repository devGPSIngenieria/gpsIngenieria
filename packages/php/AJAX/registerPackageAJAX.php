<?php

include "../../../fGenerales/bd/conexion.php";

// Obtener los datos del formulario
$name = filter_input(INPUT_POST, "namePackage");
$price = filter_input(INPUT_POST, "pricePackage");

// Obtener los arrays enviados
$numeroParte = filter_input(INPUT_POST, 'numeroParte', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

$bandera = 0;

if (count($numeroParte) !== count($descripcion)) {
    $bandera = 0;
    exit;
}

    $conexion = new conexion;

    // Insertar en la tabla subcategoria
    $queryCrearPaquete = "INSERT INTO subcategoria (nombre, id_estado, id_categoria) VALUES (?, 1, ?)";
    $stmt = $conexion->conn->prepare($queryCrearPaquete);
    $stmt->bind_param('si', $name, $categoria);
    $categoria = 12;
    $stmt->execute();

    // Obtener el ID del nuevo subcategoria
    $querySelectPaquete = "SELECT id_subcategoria FROM subcategoria ORDER BY id_subcategoria DESC LIMIT 1";
    $resultado = $conexion->conn->query($querySelectPaquete);

    if ($resultado && $dato = $resultado->fetch_assoc()) {

        $id_subcategoria = $dato['id_subcategoria'];

        // Insertar en la tabla productos
        $queryCreatePackage = "INSERT INTO productos (descripcion, precio_public, precio_venta, id_categoria, id_subcategoria, id_estado) VALUES (?, ?, ?, 12, ?, 1)";
        $stmt = $conexion->conn->prepare($queryCreatePackage);
        $stmt->bind_param('ssii', $name, $price, $price, $id_subcategoria);
        $stmt->execute();

        // Obtener el ID del nuevo producto
        $querySelectIdPaq = "SELECT id_producto FROM productos ORDER BY id_producto DESC LIMIT 1";
        $resultado = $conexion->conn->query($querySelectIdPaq);
        if ($resultado && $dato = $resultado->fetch_assoc()) {
            $id_producto = $dato['id_producto'];

            // Insertar en la tabla products_packages
            $queryInsertProd_Paq = "INSERT INTO pruducts_packages (numero_parte, descripcion, id_estado) VALUES (?, ?, 1)";
            $stmt = $conexion->conn->prepare($queryInsertProd_Paq);
            foreach ($numeroParte as $index => $numeroParteValue) {
                $descripcionValue = $descripcion[$index];
                $stmt->bind_param('ss', $numeroParteValue, $descripcionValue);
                $stmt->execute();
            }

            // Obtener IDs de los productos_packages insertados
            $limit = count($numeroParte);
            $querySelectProductos_paq = "SELECT id_prod_paq FROM pruducts_packages ORDER BY id_prod_paq DESC LIMIT ?";
            $stmt = $conexion->conn->prepare($querySelectProductos_paq);
            $stmt->bind_param('i', $limit);
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Insertar en la tabla packages
            $queryInsertProd_Paq = "INSERT INTO packages (id_producto, id_prod_paq, id_estado) VALUES (?, ?, 1)";
            $stmt = $conexion->conn->prepare($queryInsertProd_Paq);
            while ($dato = $resultado->fetch_assoc()) {
                $id_prod_paq = $dato['id_prod_paq'];
                $stmt->bind_param('ii', $id_producto, $id_prod_paq);
                $stmt->execute();
            }

            $bandera = 1;
        }
    } 

$stmt->close();
$conexion->conn->close();

$resultados["bandera"] = $bandera;
echo json_encode($resultados);
?>
