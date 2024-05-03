<?php

include '../../fGenerales/bd/conexion.php';

$id = filter_input(INPUT_POST, "id");
$factura  = filter_input(INPUT_POST, "factura");


// subir primero la evidencia 

$conexionFactura = new conexion;
$queryFactura = "UPDATE ordentrabajo SET factura = '" . $factura . "' WHERE ordenid=" . $id;

$arrResultado = [];

$arrResultado["query"] = $queryFactura;

if ($conexionFactura->conn->query($queryFactura)) { //la query corrio correctamente y se agrego la factura

    //creando la nueva evidencia

    move_uploaded_file($_FILES["evidenciaFactura"]["tmp_name"], "../../ordenesTrabajos/evidenciasFacturas/evidencia" . $id . ".jpg");

    $arrResultado["resultado"] = 1; //TODO SALIO BIEN


    $conexionDatos = new conexion;
    $queryDatos = "SELECT ot.ordenid,ot.numfolio,c.nombre ,c.apellidos,u.nombre,ot.totalpago,ot.fecha,ot.saldopendiente,ot.factura   FROM ordentrabajo ot,clientes c,usuarios u  WHERE ot.idcliente = c.idcliente and u.idusuario = ot.idusuario  ";
    //echo $queryDatos;

    $datos = $conexionDatos->conn->query($queryDatos);

    $arrResultado["noDatos"] = $datos->num_rows;

    foreach ($datos->fetch_all() as $i => $dato) {

        $arrResultado[$i]["id"] = $dato[0];
        $arrResultado[$i]["numfolio"] = $dato[1];
        $arrResultado[$i]["cliente"] = $dato[2] . " " . $dato[3];
        $arrResultado[$i]["trabajador"] = $dato[4];
        $arrResultado[$i]["total"] = $dato[5];
        $arrResultado[$i]["fecha"] = $dato[6];
        $arrResultado[$i]["factura"] = $dato[8];
        $arrResultado[$i]["pagoP"] = $dato[7];
    }
} else {
    $arrResultado["resultado"] = 0; //NO SE CREO LA FACTURA
}

echo json_encode($arrResultado);
