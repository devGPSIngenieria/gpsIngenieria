<?php

include "../../fGenerales/bd/conexion.php";
//DECALRANDO LA VARIABLES QUE LLEGARAN POR POST

$id = filter_input(INPUT_POST, "id");
$nParte = filter_input(INPUT_POST, "nParte");
$descripcion = filter_input(INPUT_POST, "descripcion");
$precioPublico = filter_input(INPUT_POST, "precioPublico");
$precioVenta = filter_input(INPUT_POST, "precioVenta");

$resultado = [];

//PONIENDO LOS CAMBIOS 
$conexionModificar = new conexion;
$queryModificar = "UPDATE productos SET descripcion = '".$descripcion."', precio_public='".$precioPublico."', precio_venta='".$precioVenta."' WHERE id_producto=".$id;
                  
if($conexionModificar->conn->query($queryModificar)){
    $resultado["resultado"]=true; 
}else{
    $resultado["resultado"]=false; 
}

echo json_encode($resultado);