<?php

include "../../fGenerales/bd/conexion.php";

//traer la variables del post

$filtroTipo = filter_input(INPUT_POST, "filtroTipo");
$filtroMovimiento = filter_input(INPUT_POST, "filtroMovimiento");
$filtroProducto = filter_input(INPUT_POST, "filtroProducto");
$filtroFechaInicial = filter_input(INPUT_POST, "filtroFechaInicial");
$filtroFechaFinal = filter_input(INPUT_POST, "filtroFechaFinal");

//checando si trane datos
$parametros = "";

if ($filtroTipo != 0) {

    
        $parametros = $parametros . " AND  e.idtipo = ".$filtroTipo;
    

}

if ($filtroMovimiento != 0) {

  

        $parametros = $parametros . " AND  e.idmovimiento = " . $filtroMovimiento;
    
}


if ($filtroProducto != "") {

    //buscando aque producto corresponde y sacando el id 

    $parametros = $parametros . " AND e.identradasalida  in (SELECT p3.identradasalida  FROM productorelacionentradassalidas p3 WHERE p3.idproducto in (SELECT p4.idproducto  FROM productos p4 where p4.nparte like '".$filtroProducto."' or p4.descripcion like '".$filtroProducto."' ))";
    
}

//AGREGANDO LOS FILTROS DE FECHAS

if ($filtroFechaInicial != "" && $filtroFechaFinal != "") {

        $parametros = $parametros . " AND DATE(e.fecha) BETWEEN '".$filtroFechaInicial."' AND '".$filtroFechaFinal."' ";

}

$arrResultados = [];

//haciendo la consulta de las entradas y salidas 

$conexionENReporte = new conexion;
$queryENReporte = "SELECT e.identradasalida ,t.nombretipo,m.nombremovimiento,p2.nparte,p2.descripcion,p.cantidad,e.fecha  FROM entradassalidas e
join tipo t on t.idtipo = e.idtipo
join movimiento m on m.idmovimiento = e.idmovimiento 
join productorelacionentradassalidas p on e.identradasalida = p.identradasalida 
join productos p2 on p2.idproducto = p.idproducto 
where e.estado = 1  " . $parametros."
order by e.identradasalida asc";
$resutadosENReporte = $conexionENReporte->conn->query($queryENReporte);
//echo $queryENReporte."<br>";

$arrResultados["query"] = $queryENReporte;


$arrResultados["noDatos"] = 0;
if ($resutadosENReporte) {

    if ($resutadosENReporte->num_rows > 0) {

        $arrResultados["noDatos"] = $resutadosENReporte->num_rows;


        foreach ($resutadosENReporte->fetch_all() as $index => $datos) {


            $arrResultados[$index]["nparte"] = $datos[3];
            $arrResultados[$index]["descripcion"] = $datos[4];
            $arrResultados[$index]["cantidad"] = $datos[5];
            $arrResultados[$index]["fecha"] = $datos[6];
            $arrResultados[$index]["tipo"] = $datos[1];
            $arrResultados[$index]["movimiento"] = $datos[2];
          
        }
    }
}

echo json_encode($arrResultados);
