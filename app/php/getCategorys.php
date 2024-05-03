<?php

include "../../fGenerales/bd/conexion.php";
include "../../fGenerales/php/funciones.php";

$connFindCategorys = new conexion;
$queryFindCategorys = "SELECT*FROM categoria c WHERE  id_estado  = 1";
$result = $connFindCategorys->conn->query($queryFindCategorys);


$arrResult = [];

foreach($result->fetch_all() as $data) {
  $arrData = [];
  $arrData["id"] = $data[0]; 
  $arrData["name"] = $data[1]; 

  $arrResult[] = $arrData;
}

echo json_encode($arrResult);