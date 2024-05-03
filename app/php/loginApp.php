<?php

include "../../fGenerales/php/funciones.php";
include "../../fGenerales/bd/conexion.php";


$usuario = filter_input(INPUT_POST,"usuario");
$password = filter_input(INPUT_POST,"password");

//pruebas 

// $usuario = filter_input(INPUT_GET,"usuario");
// $password = filter_input(INPUT_GET,"password");

$arrRespuesta = [];

$datos = checarLogin($usuario,$password);

if($datos[0]){
   $arrRespuesta[0]['accesso'] = true;
   $arrRespuesta[0]['usuarioid'] = $datos[1] ;
}else{
   $arrRespuesta[0]['accesso'] = false;
}


echo json_encode($arrRespuesta);
