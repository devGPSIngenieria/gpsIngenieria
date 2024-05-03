<?php

   include "../../fGenerales/bd/conexion.php";


   $id = filter_input(INPUT_POST, "id");
   $nombre = filter_input(INPUT_POST, "nombre");

   $resultado = [];

   //CHECAR SI LA CATEGORIA YA EXISTE
   $conexionChecarCategoria = new conexion;
   $queryChecarCategoria  = "SELECT*FROM categoria WHERE nombre = '".$nombre."' AND id_categoria <> ".$id;
   $checarCategoria = $conexionChecarCategoria->conn->query($queryChecarCategoria);

   if($checarCategoria->num_rows > 0){
   
      $resultado["resultado"] = 0; //el usuario esta repetido 

   }else{

      //MODIFICA LA CATEGORIA

      $conexionModificar =  new conexion;
      $queryModificar = "UPDATE categoria SET nombre = '".$nombre."' WHERE id_categoria = ".$id;

      if($conexionModificar->conn->query($queryModificar)){
         $resultado["resultado"] = 1; //se hiso la modificacion 
      }else{
         $resultado["resultado"] = 2; 
      }
   }
   echo json_encode($resultado);
?>