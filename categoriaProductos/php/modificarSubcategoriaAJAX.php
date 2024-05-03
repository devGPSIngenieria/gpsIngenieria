<?php

   include "../../fGenerales/bd/conexion.php";


   $id = filter_input(INPUT_POST, "id");
   $nombre = filter_input(INPUT_POST, "nombre");

   $resultado = [];

   //CHECAR SI LA CATEGORIA YA EXISTE
   $conexionChecarSubcategoria = new conexion;
   $queryChecarSubcategoria  = "SELECT * FROM subcategoria WHERE nombre = '".$nombre."' AND id_subcategoria <> ".$id;
   $checarSubcategoria = $conexionChecarSubcategoria->conn->query($queryChecarSubcategoria);

   if($checarSubcategoria->num_rows > 0){
   
      $resultado["resultado"] = 0; //el usuario esta repetido 

   }else{

      //MODIFICA LA CATEGORIA

      $conexionModificar =  new conexion;
      $queryModificar = "UPDATE subcategoria SET nombre = '".$nombre."' WHERE id_subcategoria = ".$id;

      if($conexionModificar->conn->query($queryModificar)){
         $resultado["resultado"] = 1; //se hiso la modificacion 

         //TRAER CATEGORIAS
         $conexionTraerCategorias = new conexion;
         $queryTraerCategorias = "SELECT * FROM subcategoria";

         $datos = $conexionTraerCategorias->conn->query($queryTraerCategorias);

         $resultado["noDatos"] = $datos->num_rows;

         foreach($datos->fetch_all() as $index => $dato){
            $resultado[$index]["id"] = $dato[0];
            $resultado[$index]["nombre"] = $dato[1];
         }


      }else{
      $resultado["resultado"] = 2; 
      }
   }
   echo json_encode($resultado);
?>