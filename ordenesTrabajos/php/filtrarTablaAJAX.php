<?php

include "../../fGenerales/bd/conexion.php";
include "funciones.php";

$filtroNFolio = filter_input(INPUT_GET,"filtroNFolio");
$filtroTrabajador = filter_input(INPUT_GET,"filtroTrabajador");
$filtroCliente = filter_input(INPUT_GET,"filtroCliente");
$filtroFechaI = filter_input(INPUT_GET,"filtroFechaI");
$filtroFechaF = filter_input(INPUT_GET,"filtroFechaF");


$cadena = "";

if($filtroNFolio != 0){ 

   $cadena = $cadena .  " AND CAST(ot.numfolio AS CHARACTER) LIKE '%".$filtroNFolio."%'";

}

if($filtroTrabajador != ""){ 

    $cadena = $cadena .  "  AND u.nombre LIKE '%".$filtroTrabajador."%'";
 
 }

 if($filtroCliente != ""){ 

    $cadena = $cadena .  "   AND CONCAT(c.nombre, ' ',c.apellidos) LIKE '%".$filtroCliente."%'";
 
 }

 if($filtroFechaI != ""  && $filtroFechaF != ""){ 

    $cadena = $cadena .  "  AND ot.fecha BETWEEN '".$filtroFechaI."' AND DATE_ADD('".$filtroFechaF."', INTERVAL 1 DAY) ";
 
 }
//TRAYENDO LOS DATOS

$conexionDatos = new conexion;

datosTabla($resultado,$conexionDatos,$cadena);

echo json_encode($resultado);