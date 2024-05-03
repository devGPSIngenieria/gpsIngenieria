<?php

include "../../fGenerales/bd/conexion.php";
include "../../fGenerales/php/funciones.php";


$connFindEmployees = new conexion;
$queryFindEmployees = "SELECT idempleado,nombre,apellidos FROM empleados WHERE status = 1";

$resultFindEmployees = $connFindEmployees->conn->query($queryFindEmployees);

$arrResult = [];

foreach($resultFindEmployees->fetch_all() as $data) {
   $arrdata = [];
   $arrdata["idempleado"] = $data[0];
   $arrdata["nombre"] = $data[1]." ".$data[2];

   $arrResult[] = $arrdata; 
}

echo json_encode($arrResult);