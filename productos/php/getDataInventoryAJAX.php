<?php

include '../../fGenerales/bd/conexion.php';



$arguments = '';

$numParte = filter_input(INPUT_GET, "numParte");
$descripcion = filter_input(INPUT_GET, "descripcion");
$numSerie = filter_input(INPUT_GET, "numSerie");

if ($numParte != "") {
    $arguments = $arguments . " AND p.no_parte like '%" . $numParte . "%'";
}
if ($descripcion != "") {
    $arguments = $arguments . " AND p.descripcion like '%" . $descripcion . "%'";
}
if ($numSerie != "") {
    $arguments = $arguments . " AND e.no_serial like '%" . $numSerie . "%'";
}

$connDataInventory = new conexion;
$queryDataInvetory = "SELECT p.no_parte, e.no_serial, p.descripcion  FROM entradas e , productos p  WHERE e.id_estado = 1 and e.id_producto = p.id_producto ".$arguments;
$dataInventory = $connDataInventory->conn->query($queryDataInvetory);

$arrResult = [];

foreach($dataInventory->fetch_all() as $data) {
  $arrData = [];
  $arrData["no_parte"] = $data[0];
  $arrData["no_serial"] = $data[1];
  $arrData["descripcion"] = $data[2];

  $arrResult[] = $arrData;
}

echo json_encode($arrResult);
