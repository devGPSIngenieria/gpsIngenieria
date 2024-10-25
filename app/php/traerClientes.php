<?php

include "../../fGenerales/php/funciones.php";
include "../../fGenerales/bd/conexion.php";

// trayendo los clientes 
$resultados = [];
$conexion = new conexion;
$query = "SELECT idclient, client_company FROM clientes";
$resultado = $conexion->conn->query($query);
foreach($resultado->fetch_all() as $key => $cliente){
    $resultados[$key]["id"] = $cliente[0];
    $resultados[$key]["nombre"] = $cliente[1];
}
echo json_encode($resultados);