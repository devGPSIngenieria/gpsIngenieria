<?php

include "../../fGenerales/bd/conexion.php";

$nombre = filter_input(INPUT_POST, "nombre");
$descripcion = filter_input(INPUT_POST, "descripcion");
$precio = filter_input(INPUT_POST, "precio");


$conexionCrearServicio = new conexion;
$queryCrearServicio = "INSERT INTO servicios(nombre,descripcion,precio)" 
."VALUES ('" . $nombre . "','" . $descripcion . "','" . $precio . "')";



$resultados = [];
$resultados["query"] = $queryCrearServicio;
if ($conexionCrearServicio->conn->query($queryCrearServicio)) {

    $resultados["resultado"] = true;

    $conexionDatos = new conexion;
    $queryDatos = "SELECT * FROM servicios";
    $datos = $conexionDatos->conn->query($queryDatos);

    $resultados["noDatos"] = $datos->num_rows;

    foreach ($datos->fetch_all() as $i => $datos) {

        $resultados[$i]["id"] = $datos[0];
        $resultados[$i]["nombre"] = $datos[1];
        $resultados[$i]["descripcion"] = $datos[2];
        $resultados[$i]["precio"] = $datos[3];
     
        
        
    }
} else {

    $resultados["resultado"] = false;
}

echo json_encode($resultados);
