<?php

include "../../../fGenerales/bd/conexion.php";

// TRAYENDO LOS DATOS QUE SE RECIBIRAN POR GET

$filtroCliente = filter_input(INPUT_GET,"filtroCliente");
$filtroTrabajador = filter_input(INPUT_GET,"filtroTrabajador");
$filtroCompra = filter_input(INPUT_GET,"filtroCompra");
$filtroFechaI = filter_input(INPUT_GET,"filtroFechaI");
$filtroFechaF = filter_input(INPUT_GET,"filtroFechaF");

//CHECANDO LOS ARGUMENTOS QUE SE MANDARAN ALA QUERY

$cadenaCliente = $filtroCliente!= ""? " AND CONCAT(c.nombre, ' ', c.apellidos) like '%".$filtroCliente."%' ":"";
$cadenaCliente2 = $filtroCliente!= ""? " AND ce.empresa like '%".$filtroCliente."%' ":"";
$cadenaTrabajador = $filtroTrabajador!= "" ? " AND u.nombreusuario like '%".$filtroTrabajador."%' ":"";
$cadenaCompra = $filtroCompra != "" ? " AND v.nombrecompra like '%".$filtroCompra."%'":""; 
$cadenaFecha = $filtroFechaI != "" && $filtroFechaF != "" ? " AND v.fecha BETWEEN '".$filtroFechaI."' AND '".$filtroFechaF."' ":""; 


//HACIENDO LA CONSULTA
$conexionVentas = new conexion;

$queryVentas = "SELECT v.ventaid,CONCAT(IFNULL(c.nombre, ''), ' ', IFNULL(c.apellidos, '')) AS nombre_completo  ,u.nombreusuario ,v.fecha ,v.nombrecompra ,v.total ,v.deuda".  
" from ventas v". 
" join clientes c on v.clienteid = c.idcliente  ".$cadenaCliente.
" join usuarios u on v.usuarioid = u.idusuario ".$cadenaTrabajador.
" WHERE v.tipocliente = 1 ".$cadenaCompra.$cadenaFecha.
" union".
" select v.ventaid,ce.empresa  as cliente,u.nombreusuario,v.fecha ,v.nombrecompra ,v.total ,v.deuda".  
" from ventas v". 
" join clienteexpress ce on v.clienteid = ce.clienteid ".$cadenaCliente2.
" join usuarios u on v.usuarioid = u.idusuario " .$cadenaTrabajador.
" where v.tipocliente  = 2 ".$cadenaCompra.$cadenaFecha.
" order by ventaid desc";

if($resultados = $conexionVentas->conn->query($queryVentas)){

    //MANDANDO LOS RESULTADOS

$arrResultados = [];
$arrResultados["query"] = $queryVentas;
$arrResultados["error"] = 0;//NO HUBO ERRORES EN LA CONSULTA
$arrResultados["noDatos"] = $resultados->num_rows;

foreach($resultados->fetch_all() as $index => $venta){

    $arrResultados[$index]["ventaid"] = $venta[0];
    $arrResultados[$index]["cliente"] = $venta[1];
    $arrResultados[$index]["trabajador"] = $venta[2];
    $arrResultados[$index]["fecha"] = $venta[3];
    $arrResultados[$index]["compra"] = $venta[4];
    $arrResultados[$index]["total"] = $venta[5];
    $arrResultados[$index]["deuda"] = $venta[6];

}

}else{
    $arrResultados["query"] = $queryVentas;
    $arrResultados["error"] = 1;//HUBO ERRORES EN LA CONSULTA

}



echo json_encode($arrResultados);
