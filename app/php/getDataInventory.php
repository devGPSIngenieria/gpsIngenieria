<?php

include "../../fGenerales/bd/conexion.php";
include "../../fGenerales/php/funciones.php";

$nPart = filter_input(INPUT_GET, "nPart");
$description = filter_input(INPUT_GET, "description");
$category = filter_input(INPUT_GET, "category");
$subCategory = filter_input(INPUT_GET, "subCategory");

$stringPart = "";

if ($nPart != "") {
   $stringPart =  " AND p.no_parte like '%" . $nPart . "%'";
}
if ($description != "") {
   $stringPart = $stringPart . " AND p.descripcion like '%" . $description . "%'";
}

if ($category != 0) {
   $stringPart = $stringPart . " AND p.id_categoria = ".$category;
}

if ($subCategory != 0) {
   $stringPart = $stringPart . " AND p.id_subcategoria = ".$subCategory;
}

$connFindProducts = new conexion;
$queryFindProducts = "SELECT  i.id_producto,COUNT(i.id_producto),p2.no_parte ,p2.precio_venta  from inventario i, productos p2  where i.id_producto in (select id_producto  from productos p where p.id_estado = 1 " . $stringPart . ") AND i.id_producto = p2.id_producto AND i.id_estado = 1 GROUP by i.id_producto ";

$resultFindProducts = $connFindProducts->conn->query($queryFindProducts);

$arrResult = [];

foreach ($resultFindProducts->fetch_all() as $data) {
   $arrdata = [];
   $arrdata["idproducto"] = $data[0];
   $arrdata["contador"] = $data[1];
   $arrdata["nParte"] = $data[2];
   $arrdata["precio"] = $data[3];

   $arrResult[] = $arrdata;
}

echo json_encode($arrResult);
