<?php

include "../../fGenerales/bd/conexion.php";
include "../../ordenesTrabajos/php/formatoOrdenTrabajo.php";
require '../../vendor/autoload.php';

$datosOrden = filter_input(INPUT_POST, "datosOrden");
$firmaCliente = filter_input(INPUT_POST, "firmaCliente");
$firmaEmpleado = filter_input(INPUT_POST, "firmaEmpleado");

//procesando los datos de la respuesta 

$datosOrden = json_decode($datosOrden);

  $km = $datosOrden->km;
  $travelTime = $datosOrden->travelTime;
  $manualJob = $datosOrden->manualJob;
  $total = $datosOrden->total;
  $problemas = $datosOrden->problemas;
  $trabajo = $datosOrden->trabajo;
  $usuarioid = $datosOrden->usuarioid;
  $comentarios = $datosOrden->comentarios; 
  $flete = $datosOrden->flete;
  $clienteId = $datosOrden->clienteId;
  $productos = $datosOrden->productos;
  $typeClient = $datosOrden->typeClient;
  $workData = $datosOrden->workData;
  
 $arrResultados = [];

 $conexionChecarOrdenTrabajo = new conexion;
 $queryChecarOrdenTrabajo = "SELECT numfolio FROM ordentrabajo order by numfolio desc limit 1 ";
 $resultados = $conexionChecarOrdenTrabajo->conn->query($queryChecarOrdenTrabajo);

 $idImagen = 0;

 if ($resultados->num_rows > 0) {

   foreach ($resultados->fetch_row() as $id) {

     $idImagen = $id + 1;
   }
 } else {

   $idImagen = 1;
 }

$imgClienteFirma = base64_decode($firmaCliente);
$pathClienteFirma = "firmaCliente" . $idImagen . ".jpg";
$clienteFirmaPath = "../../ordenesTrabajos/src/firmas/" . $pathClienteFirma;
file_put_contents("../../ordenesTrabajos/src/firmas/" . $pathClienteFirma, $imgClienteFirma);
$imgEmpleado = base64_decode($firmaEmpleado);
$pathEmpleado = "firmaEmpleado" . $idImagen . ".jpg";
$empleadoFirmaPath = "../../ordenesTrabajos/src/firmas/" . $pathEmpleado;
file_put_contents("../../ordenesTrabajos/src/firmas/" . $pathEmpleado, $imgEmpleado);

$saldoPendiente = floatval($total) - floatval($flete);

if ($typeClient != "0") {
  $clientdata = $datosOrden->clientdata;
  $clienteId = createNewClient($clientdata,$typeClient);
}


$conexionInsertaOrden = new conexion;
$queryInsertaOrden = "INSERT INTO ordentrabajo (idusuario, trabajorealizado, problema, comentarios, idcliente, firmaempleadoid, firmaclienteid, totalpago, flete, saldopendiente, fecha) ".
 " VALUES (" . $usuarioid . ", '" . $trabajo . "', '" . $problemas . "', '" . $comentarios . "'," . $clienteId . "," . $idImagen . "," . $idImagen . ",'".$total."', '".$flete."', '".$saldoPendiente."',NOW());";


if ($conexionInsertaOrden->conn->query($queryInsertaOrden) == true) {
   $ordeId = $conexionInsertaOrden->conn->insert_id;
   createServices($km, 1, $ordeId);
   createServices($travelTime, 2, $ordeId);
   createServices($manualJob, 3, $ordeId);
   $productos = json_decode($productos,true);
   createNewProductsForWorkOrder($productos, $ordeId);
   createWorkServices($ordeId, $workData);
   $arrResultados[0]["pdf"] = createPDFOrden($ordeId);
   $arrResultados[0]["status"] = 1;

}else {
  $arrResultados[0]["status"] = 0;
  }

 echo json_encode($arrResultados);


function createWorkServices($numFolio, $workData) {
  $data = json_decode($workData);
  if ($data->demostracion) {
    createNewWork(1, $numFolio);
  }
  if ($data->instalacion) {
    createNewWork(2, $numFolio);
  }
  if ($data->servicio) {
    createNewWork(3, $numFolio);
  }
  if ($data->garantia) {
    createNewWork(4, $numFolio);
  }
  if ($data->reparacion) {
    createNewWork(5, $numFolio);
  }
}

function createNewWork($idWork, $numFolio) {
  $conexionTrabajoNuevo = new conexion;
  $queryTrabajoNuevo = "INSERT INTO trabajo_realizado (numfolio, idwork) VALUES (" . $numFolio . "," . $idWork. ")";
  $conexionTrabajoNuevo->conn->query($queryTrabajoNuevo);
}

function createServices($services, $type, $id) {
     $conexionServicioNuevo = new conexion;
     $queryServicioNuevo = "INSERT INTO servicios (numfolio, type, count) VALUES (" . $id . "," . $type.  ",".$services.")";
     $conexionServicioNuevo->conn->query($queryServicioNuevo);
}

function createNewProductsForWorkOrder($productos, $id) {
     foreach($productos as $product) {
     $conexionInvetario = new conexion;
     $queryInvetario = "SELECT*FROM inventario where id_producto = ".$product["id"]." and id_estado = 1 limit ". $product["salidas"];
     $dataProducts = $conexionInvetario->conn->query($queryInvetario);
      foreach($dataProducts->fetch_all() as $existencia) {
        $conexionUpdateInventario = new conexion;
        $queryUpdateInventario = "UPDATE inventario SET id_estado = 2 WHERE id_inventario = ".$existencia[0] ;
        $conexionUpdateInventario->conn->query($queryUpdateInventario);
        $conexionCreateVentasOrden = new conexion;
        $queryCreateVentasOrden = "INSERT INTO ventas_orden VALUES (".$existencia[0].", ".$id.", 1)" ;
        $conexionCreateVentasOrden->conn->query($queryCreateVentasOrden);
      } 
     }  
}

function createNewClient($dataClient, $typeClient) {
  $data = json_decode($dataClient);
  $conexionCreateNewClient = new conexion;
  $queryCreateNewClient = "INSERT INTO clientes (client_company, adress, country, contact, rfc, email, typeid) ". 
  " VALUES ('".$data->cliente."','".$data->domicilio."','".$data->adress."','".$data->contact."','".$data->rfc."','".$data->email."', ".$typeClient.") ";
  $conexionCreateNewClient->conn->query($queryCreateNewClient);
  return  $conexionCreateNewClient->conn->insert_id;
}


