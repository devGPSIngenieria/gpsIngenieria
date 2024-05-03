<?php

include "../../fGenerales/php/funciones.php";
include "../../fGenerales/bd/conexion.php";




// trayendo los materiales 

$resultados = [];


$conexion = new conexion;
    
$query = "SELECT * FROM productos ";

$resultado = $conexion->conn->query($query);




foreach($resultado->fetch_all() as $key => $producto){

    $resultados[$key]["id"] = $producto[0];
    $resultados[$key]["descripcion"] = $producto[2]; 
    $resultados[$key]["existentes"] = $producto[6]; 
     
    if($producto[8]!=null){
        $resultados[$key]["precioxunidad"] = $producto[8]; 
    }else{
        $resultados[$key]["precioxunidad"] = 0; 
    }


    
    
}

echo json_encode($resultados);