<?php

include "../../fGenerales/php/funciones.php";
include "../../fGenerales/bd/conexion.php";

//TRAYENDO LOS DATOS 

$fechaI = filter_input(INPUT_GET, "fechaI");

$fechaF = filter_input(INPUT_GET, "fechaF");

$cliente = filter_input(INPUT_GET, "cliente");

$trabajador = filter_input(INPUT_GET, "trabajador");

$nFolio = filter_input(INPUT_GET, "nFolio");


//CHECANDO QUE ARGUMENTOS SE VAN A MANDAR

$cadenaCliente = "";

if ($cliente != "") {

    $cadenaCliente = " AND c.nombre like '%" . $cliente . "%' ";
}

$cadenaTrabajador = "";

if ($trabajador != "") {

    $cadenaTrabajador = " AND u.nombreusuario like '%" . $trabajador . "%' ";
}

$cadenaOrden = "";

if ($fechaI != "" && $fechaF != "") {

    $cadenaOrden = " AND date(o.fecha) BETWEEN '".$fechaI."' AND '".$fechaF."' ";

}

if($nFolio!=""){

    $cadenaOrden = " AND o.numfolio = ".$nFolio;

}

 

//HACIENDO LA QUERY PARA TRAER LOS RESULTADOS

$conexionOrden = new conexion;

$queryOrden = "SELECT o.ordenid,o.numfolio,u.nombreusuario,c.nombre,o.totalpago  
FROM ordentrabajo o  
JOIN usuarios u ON o.idusuario = u.idusuario " . $cadenaTrabajador .
    " JOIN clientes c ON c.idcliente = o.idcliente " . $cadenaCliente .
    " WHERE o.banderaautorizar = 1 " .$cadenaOrden;

    
$resultado = $conexionOrden->conn->query($queryOrden);

//MANDANDO LOS DATOS EN UN JSON

$arrResultados = [];



foreach($resultado->fetch_all() as $index=>$orden){

    $arreglo = [
       "idorden" => $orden[0],
       "numFolio" => $orden[1],
       "nombreEmpleado" => $orden[2],
       "nombreCliente" => $orden[3],
       "TotalPago" => $orden[4],

    ];

    array_push($arrResultados,$arreglo);

}


echo json_encode($arrResultados);

