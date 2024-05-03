<?php
    include "../../fGenerales/bd/conexion.php";
    
    if( isset($_GET["arrayEntradas"]) ) {

        $arrayEntradas = $_GET['arrayEntradas'];
        $numEntrada = '';

        $arrayEntradasPHP = array();
        foreach ($arrayEntradas as $entradaJSON) {
            $entrada = json_decode($entradaJSON, true); // TRUE PARA OBTENER ARRAY ASOCIATIVO
            if ($entrada) {
                $arrayEntradasPHP[] = $entrada;
            }
        }

        $conexionInsertarEntrada = new conexion;
        $conexionInsertarInventario = new conexion;

        $resultados = [];

        $conexionNumEntrada = new conexion;
        $queryNumEntrada = "SELECT num_entrada FROM entradas ORDER BY id_entrada DESC LIMIT 1"; //VERIFICA LA ULTIMA ENTRADA
        $datos = $conexionNumEntrada->conn->query($queryNumEntrada);

        if($datos->num_rows > 0){
            foreach ($datos->fetch_all() as $i => $datos) {
                $numEntrada = $datos[0] + 1; //SUMA 1 PARA DARLE SEGUIMIENTO HACIA LA NUEVA ENTRADA
            }
        } else {
            $numEntrada = 1;
        }

        foreach ($arrayEntradasPHP as $entrada) {
            $id = $entrada['idProd'];
            $numSerie = $entrada['noSerie'];

            // REGISTRA LA ENTRADA DEL PRODUCTO
            $queryInsertarEntrada = "INSERT INTO entradas (id_producto, no_serial, id_estado, fecha_registro, num_entrada) VALUES ($id, '$numSerie', 1, NOW(), $numEntrada)"; //id_estado 1 ACTIVO

            // REGISTRA EL PRODUCTO EN EL INVENTARIO
            $queryInsertarInventario = "INSERT INTO inventario (id_producto, no_serial, id_estado, fecha_registro, tipo_movimiento) VALUES ($id, '$numSerie', 1, NOW(), 1)"; //tipo_movimiento 1 ENTRADA
            
            if ($conexionInsertarEntrada->conn->query($queryInsertarEntrada)) {

                $conexionInsertarInventario->conn->query($queryInsertarInventario);

                $resultados["resultado"] = true;
            } else {
                $resultados["resultado"] = false;
            }
        }
    } else {
        $resultados["resultado"] = false;
    }
    echo json_encode($resultados);
?>
