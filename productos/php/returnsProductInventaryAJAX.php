<?php

    include "../../fGenerales/bd/conexion.php";

    $resultados = [];
    $resultados[0]["resultado"] = 0;
    $id = filter_input(INPUT_GET,"id_inventario");

    $conexionDevolver = new conexion;
    $conexionInsertarDev = new conexion;

    $queryDevolver = "UPDATE inventario SET tipo_movimiento = 2 WHERE id_inventario =".$id;

    if($conexionDevolver->conn->query($queryDevolver)){

        $resultados[0]["resultado"] = 1;//salio bien

        $queryInsertarDev = "INSERT INTO devoluciones (fechadevolucion, id_inventario, id_estado) VALUES ( NOW(), ".$id.", 1)";
        $conexionInsertarDev->conn->query($queryInsertarDev);
    }
    echo json_encode($resultados);
?>