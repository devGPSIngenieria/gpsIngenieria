<?php

include "../../fGenerales/bd/conexion.php";

$datosOrden = filter_input(INPUT_POST, "datosOrden");
$firmaCliente = filter_input(INPUT_POST, "firmaCliente");
$firmaEmpleado = filter_input(INPUT_POST, "firmaEmpleado");

//procesando los datos de la respuesta 

$datosOrden = json_decode($datosOrden);

//var_dump($datosOrden);

$servicios = $datosOrden->servicios;
$clienteid = $datosOrden->clienteId;
$problemas = $datosOrden->problemas;
$trabajo = $datosOrden->trabajo;
$usuarioid = $datosOrden->usuarioid;
$productos = $datosOrden->productos;
$flete = $datosOrden->flete;
$total = $datosOrden->total;

$arrResultados = [];

//checnado la ultima orde de trabajo que se hiso

$conexionChecarOrdenTrabajo = new conexion;
$queryChecarOrdenTrabajo = "SELECT ordenid FROM ordentrabajo order by ordenid desc limit 1 ";
$resultados = $conexionChecarOrdenTrabajo->conn->query($queryChecarOrdenTrabajo);

$idImagen = 0;

if ($resultados->num_rows > 0) {

  foreach ($resultados->fetch_row() as $id) {

    $idImagen = $id + 1;
  }
} else {

  $idImagen = 1;
}


//subiendo firmas 

// Decodificar la cadena Base64 a bytes
$imgClienteFirma = base64_decode($firmaCliente);

// Ruta donde se guardará la imagen
$pathClienteFirma = "firmaCliente" . $idImagen . ".jpg";

// Guardar la imagen en el disco
file_put_contents("../../ordenesTrabajos/src/firmas/" . $pathClienteFirma, $imgClienteFirma);



// Decodificar la cadena Base64 a bytes
$imgEmpleado = base64_decode($firmaEmpleado);

// Ruta donde se guardará la imagen
$pathEmpleado = "firmaEmpleado" . $idImagen . ".jpg";

// Guardar la imagen en el disco
file_put_contents("../../ordenesTrabajos/src/firmas/" . $pathEmpleado, $imgEmpleado);

//CALCULANDO SALDO PENDIENTE 

$saldoPendiente = floatval($total) - floatval($flete);

//INSERTANDO LA ORDEN DE TRABAJO

$conexionInsertaOrden = new conexion;
$queryInsertaOrden = "INSERT INTO ordentrabajo (idusuario, trabajorealizado, problema, numfolio, idcliente, firmaempleadoid, firmaclienteid, totalpago, flete, saldopendiente, fecha) VALUES (" . $usuarioid . ", '" . $trabajo . "', '" . $problemas . "'," . ($idImagen + 1) . "," . $clienteid . "," . $idImagen . "," . $idImagen . ",'".$total."', '".$flete."', '".$saldoPendiente."',NOW());";


if ($conexionInsertaOrden->conn->query($queryInsertaOrden) == true) {

  $ordeId = $conexionInsertaOrden->conn->insert_id;

  //echo $ordeId;


  $servicios = json_decode($servicios, true);

  foreach ($servicios as $servicio) {


    //insertando los servicios

    $conexionServicioNuevo = new conexion;
    $queryServicioNuevo = "INSERT INTO serviciosofrecidos VALUES (" . $ordeId . "," . $servicio["id"] . ")";
    $conexionServicioNuevo->conn->query($queryServicioNuevo);
  }


  //insertando los productos y quitando las existencias 
   $productos = json_decode($productos,true);

    //INSERTANDO LAS ENTRADAS 
    $conexionEntradas = new conexion;
    $queryEntradas = "INSERT INTO entradassalidas(idtipo,idmovimiento,idrelacion,fecha,estado) VALUES (2,2,".$ordeId.",now(),1)";
    $conexionEntradas->conn->query($queryEntradas);

   foreach($productos as $producto){
    //haciendo la disminucion de existencias 

    $conexionChecarProductoExistencias = new conexion;
    $queryChecarProductoExistencias = "SELECT existentes FROM productos WHERE idproducto = ".$producto["id"];
    $existencias = $conexionChecarProductoExistencias->conn->query($queryChecarProductoExistencias);

    $existencia = $existencias->fetch_row(); 
    $existenciasNuevas = $existencia[0] - $producto["salidas"];

    //cambiando las existencias del producto alas nuevas
    $conexionCambiarExistencias = new conexion;
    $queryCambiarExistencias = "UPDATE productos SET existentes = ".$existenciasNuevas ." WHERE idproducto = ".$producto["id"];
    $conexionCambiarExistencias->conn->query($queryCambiarExistencias);

    //CREANDO LAS EXISTENCIAS QUE SE CREARON EN LA ENTRADA DE PRODUCTO

    $conexionCantidad = new conexion;
    $queryCantidad = "INSERT INTO productorelacionentradassalidas (identradasalida,idproducto,cantidad,estado) VALUES (".$conexionEntradas->conn->insert_id.",".$producto["id"].",".$producto["salidas"].",1)";
    $conexionCantidad->conn->query($queryCantidad);

  }

  $arrResultados[0]["status"] = 1;//SE AGREGARON LOS DATOS CORRECTAMENTE

} else {

  $arrResultados[0]["status"] = 0;//OCURRIO UN ERROR AL AGREGAR LA ORDEN
}

echo json_encode($arrResultados);
