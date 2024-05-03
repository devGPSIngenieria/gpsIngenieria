<?php

include "../../fGenerales/bd/conexion.php";
//DECALRANDO LA VARIABLES QUE LLEGARAN POR POST

$id = filter_input(INPUT_POST, "id");
$nombre = filter_input(INPUT_POST, "nombre");
$descripcion = filter_input(INPUT_POST, "descripcion");
$precio = filter_input(INPUT_POST, "precio");


$resultados = [];

//PONIENDO LOS CAMBIOS 

$conexionModificar = new conexion;
$queryModificar = "UPDATE servicios SET nombre='".$nombre."',descripcion='".$descripcion."',precio='".$precio."'".
                 " WHERE servicioid = ".$id;

$resultados["query"]=$queryModificar;                  
                  
if($conexionModificar->conn->query($queryModificar)){

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

}else{
    $resultados["resultado"]=false; 
}

echo json_encode($resultados);