<?php

include "../../fGenerales/bd/conexion.php";
include "../../fGenerales/php/funciones.php";

$conexionServicios = new conexion;

$queryServicios = "SELECT*FROM servicios";

$resultados = $conexionServicios->conn->query($queryServicios);

$jsonDatos = [];

foreach($resultados->fetch_all() as $index=>$datos){

   $jsonDatos[$index]["servicioid"] = $datos[0]; 
   $jsonDatos[$index]["nombre"] = $datos[1]; 
   $jsonDatos[$index]["descripcion"] = $datos[2]; 
   $jsonDatos[$index]["precio"] = $datos[3]; 

}

echo json_encode($jsonDatos);
