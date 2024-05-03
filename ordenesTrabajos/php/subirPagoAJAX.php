<?php

include "../../fGenerales/bd/conexion.php";
include "funciones.php";

$id = filter_input(INPUT_POST, "id");
$cantidad = filter_input(INPUT_POST, "cantidad");
$evidencia = $_FILES["evidencia"];


// $id = filter_input(INPUT_GET, "id");
// $cantidad = filter_input(INPUT_GET, "cantidad");
// $evidencia = "";

$resultado = [];


//TRALLENDO LA CANTIDAD ANTERIOR
$conexionTraerPedientePago = new conexion;

$queryTraerPedientePago =  "SELECT saldopendiente FROM ordentrabajo WHERE ordenid =  " . $id;

//echo $queryTraerPedientePago;

$datos = $conexionTraerPedientePago->conn->query($queryTraerPedientePago);

$cantidadFaltante = 0;

foreach ($datos->fetch_all() as $i => $dato) {

    $cantidadFaltante = $dato[0]; //PENIEDO EL NUEVO VALOR QUE TENDRA LO PENDIENTE QUE DEBE

}

if ($cantidadFaltante > 0) {

    //CHECADO SI LA CANTIDAD PUESTA NO EXEDE ALO QUE FALTA POR PAGAR
    if ($cantidad > $cantidadFaltante) {
        $resultado["resultado"] = 2; //LA CANTIDAD SOBREPASO LO FALTANTE
    } else {

        //CHECANDO SI YA FUE PAGADA LA DEUDA

        $conexionSubirPago = new conexion;

        $query = "INSERT INTO pagos(ordenid,cantidad) VALUES (" . $id . ",'" . $cantidad . "') ";

        $conexionSubirPago->conn->query($query);

        //AL CREARSE UN NUEVO PAGO ESE PAGO SE DEBE DESCONTAR ALA ORDEN DE TRABAJO




        $cantidadPendienteNueva = 0;

           

            $cantidadPendienteNueva = $cantidadFaltante - $cantidad; //PENIEDO EL NUEVO VALOR QUE TENDRA LO PENDIENTE QUE DEBE

            // echo $cantidadPendienteNueva;

       


        $conexionPendienteNueva = new conexion;

        $queryPendienteNueva = "UPDATE ordentrabajo SET saldopendiente = '" . $cantidadPendienteNueva . "' WHERE ordenid = " . $id;

        $conexionPendienteNueva->conn->query($queryPendienteNueva);


        move_uploaded_file($_FILES["evidencia"]["tmp_name"], "../../ordenesTrabajos/evidencias/evidencia" . $conexionSubirPago->conn->insert_id . ".jpg");

        //PASANDO LOS DATOS NESESARIOS PARA REPINTAR LA TABLA   

        $conexionDatos = new conexion;
        

        datosTabla($resultado,$conexionDatos,"");


        $resultado["resultado"] = 1; //SE CREO EL NUEVO PAGO

    }
} else {
    $resultado["resultado"] = 0; //LA CANTIDAD YA FUE COMPLETADA
}





echo json_encode($resultado);
