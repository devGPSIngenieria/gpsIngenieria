<?php

include "../../fGenerales/bd/conexion.php";

$datosOrden = filter_input(INPUT_POST, "datosOrden");
$firmaCliente = filter_input(INPUT_POST, "firmaCliente");
$firmaEmpleado = filter_input(INPUT_POST, "firmaEmpleado");

//procesando los datos de la respuesta 

 $datosOrden = json_decode($datosOrden);


$clienteid = $datosOrden->clienteId;
$usuarioid = $datosOrden->usuarioid;
$productos = $datosOrden->productos;
$flete = $datosOrden->flete;
$total = $datosOrden->total;
$ordenNombre = $datosOrden->ordenNombre;

$arrResultados = [];

$conexionCheckSales = new conexion;
$queryCheckSales = "SELECT ventaid FROM ventas order by ventaid desc limit 1 ";
$resultados = $conexionCheckSales->conn->query($queryCheckSales);

$idImagen = 0;

if ($resultados->num_rows > 0) {

  foreach ($resultados->fetch_row() as $id) {

    $idImagen = $id + 1;
  }
} else {

  $idImagen = 1;
}

addFirm($firmaCliente, $idImagen, 1);
addFirm($firmaEmpleado, $idImagen, 2);


$saldoPendiente = floatval($total) - floatval($flete);

$conexionInsertaOrden = new conexion;
$queryInsertaOrden = "INSERT INTO ventas (clienteid,tipocliente,fecha,nombrecompra,total,deuda,usuarioid) VALUES (".$clienteid.",1,NOW(),'".$ordenNombre."','".$total."','".$saldoPendiente."',".$usuarioid.") ;";
$conexionInsertaOrden->conn->query($queryInsertaOrden);

$arrResult = [];

$arrData["status"] = (int)1;

$arrResult[] = $arrData;

echo json_encode($arrResult);


function addFirm($firma, $idImage, $type) {

if($type == 1){
    $name = "firmaClienteVentas";
}else{
    $name = "firmaEmpleadoVentas";
}   

// Decodificar la cadena Base64 a bytes
$imgClienteFirma = base64_decode($firma);

// Ruta donde se guardará la imagen
$pathClienteFirma = $name . $idImage . ".jpg";

// Guardar la imagen en el disco
file_put_contents("../../ordenesTrabajos/src/firmas/" . $pathClienteFirma, $imgClienteFirma);

}

