<?php

    include "../../fGenerales/bd/conexion.php";

    $id = filter_input(INPUT_POST, "id");
    $nombre = filter_input(INPUT_POST, "nombre");
    $login = filter_input(INPUT_POST, "login");
    $correo = filter_input(INPUT_POST, "correo");
    $password = filter_input(INPUT_POST, "password");

    $resultados = [];

    $resultados[0]["resultado"] = 0; //algo salio mal
    if ($nombre == "" || $login == "" || $correo == "") {

        $resultados[0]["resultado"] = 1; // los datos estan mal

    } else {

        //CREAR EL MODIFICAR 
        $conexionModificar = new conexion;
        if ($password != "") {
            $queryModificar = "UPDATE usuarios SET usuario = '" . $login . "' , PASSWORD = SHA2('" . $password . "', 256)  , correo = '" . $correo . "' , nombre = '" . $nombre . "' WHERE id_usuario = " . $id . " AND id_estado = 1";
        } else {
            $queryModificar = "UPDATE usuarios SET usuario = '" . $login . "'  , correo = '" . $correo . "' , nombre = '" . $nombre . "' WHERE id_usuario = " . $id . " AND id_estado = 1";
        }

        if ($conexionModificar->conn->query($queryModificar)) {
            $resultados[0]["resultado"] = 2; // salio bien la modificacion
        }
    }

    echo json_encode($resultados);
?>