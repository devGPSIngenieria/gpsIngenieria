<?php

include "../../fGenerales/php/funciones.php";
include "../../fGenerales/bd/conexion.php";


$clienteid = filter_input(INPUT_GET,"clienteid");

// trayendo los clientes 

$resultados = [];


$conexion = new conexion;
    
$query = "SELECT * FROM clientes WHERE idcliente=".$clienteid;

$resultado = $conexion->conn->query($query);

foreach($resultado->fetch_all() as $key => $cliente){

    $resultados[$key]["nombre"] = $cliente[1];
    $resultados[$key]["apellidos"] = $cliente[2]; 
    $resultados[$key]["domicilio"] = $cliente[3]; 
    $resultados[$key]["estado"] = $cliente[4]; 
    $resultados[$key]["codigopostal"] = $cliente[5]; 
    $resultados[$key]["contacto"] = $cliente[6]; 
    $resultados[$key]["rfc"] = $cliente[7]; 
    $resultados[$key]["email"] = $cliente[8]; 


}

echo json_encode($resultados);