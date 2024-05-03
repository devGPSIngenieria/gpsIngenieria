<?php

include "../../fGenerales/bd/conexion.php";

//RECIBIENDO LA FIRMA DE AUTORIZACION

// $firmaAutorizacion = filter_input(INPUT_POST,"firmaAutorizacion");

// $firmaAutorizacion = filter_input(INPUT_POST,"firmaAutorizacion");
// $ordenid =  filter_input(INPUT_POST,"id");

$firmaAutorizacion = filter_input(INPUT_GET,"firmaAutorizacion");
$ordenid =  filter_input(INPUT_GET,"id");

//SE ACTUALIZA LA ORDE AQUE YA ESTA AUTORIZADA

$conexionAutorizar = new conexion;
$queryAutorizar = "UPDATE ordentrabajo SET banderaautorizadar = 2 WHERE ordenid=".$ordenid;

 $arrResutados = []; 

if($conexionAutorizar->conn->query($queryAutorizar)){

// Decodificar la firmaAutorizacionn base64
$firmaAutorizacion = base64_decode($firmaAutorizacion);

// Crear un nombre de archivo para la firmaAutorizacionn
$filename = "firmaAutorizacion".$ordenid.".jpg";

// Guardar la firmaAutorizacionn en una carpeta
$path = "../../ordenesTrabajos/src/firmasAutorizacion";
if(file_put_contents($path . "/" . $filename, $firmaAutorizacion)){
    $arrResutados["error"] = 0;//sin errores
}else{
    $arrResutados["error"] = 2;//algun error en la imagen
}
}else{
    $arrResutados["error"] = 1;//algun error en la conexion
}

echo json_encode($arrResutados);




