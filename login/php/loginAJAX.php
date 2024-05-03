<?php

   include "../../fGenerales/php/funciones.php";
   include "../../fGenerales/bd/conexion.php";

   $usuario = filter_input(INPUT_POST,"usuario");
   $password = filter_input(INPUT_POST,"password");

   $arrRespuesta = [];

   $datos = checarLogin($usuario,$password);


   if($datos[0]){
      $arrRespuesta[0] = $datos[0];
      $arrRespuesta['usuarioid'] = $datos[1] ;
   }else{
      $arrRespuesta[0] = $datos[0];
   }

   echo json_encode($arrRespuesta);
?>