<?php

include "../../fGenerales/bd/conexion.php";


$id = filter_input(INPUT_POST, "id");
$nombres = filter_input(INPUT_POST, "nombres");
$apellidos = filter_input(INPUT_POST, "apellidos");
$domicilio = filter_input(INPUT_POST, "domicilio");
$estado = filter_input(INPUT_POST, "estado");
$codigoPostal = filter_input(INPUT_POST, "codigoPostal");
$contacto = filter_input(INPUT_POST, "contacto");
$rfc = filter_input(INPUT_POST, "rfc");
$email = filter_input(INPUT_POST, "email");

$resultados = [];

$resultados[0]["resultado"] = 0; //algo salio mal
if ($nombres == "" || $apellidos == "" || $domicilio == "" || $estado == "" || $codigoPostal == "" || $contacto == "" || $rfc == "" || $email == "") {

    $resultados[0]["resultado"] = 1; // los datos estan mal

} else {

    //CREAR EL MODIFICAR 
    $conexionModificar = new conexion;
  

        $queryModificar = "UPDATE clientes SET nombre = '".$nombres."',apellidos = '".$apellidos."',domicilio = '".$domicilio."',estado = '".$estado."',codigopostal = '".$codigoPostal."',contacto = '".$contacto."',rfc = '".$rfc."',email = '".$email."'   WHERE idcliente = ".$id;
    

    if ($conexionModificar->conn->query($queryModificar)) {

        $resultados[0]["resultado"] = 2; // salio bien la modificacion

        // //TRAYENDO LOS DATOS 
        $conexionClientes = new conexion;
        $queryClientes = "SELECT*FROM clientes ";
        $datos = $conexionClientes->conn->query($queryClientes);

        $resultados[0]["noDatos"] = $datos->num_rows;

        foreach ($datos->fetch_all() as $key => $cliente) {

            $resultados[$key]["idcliente"] = $cliente[0];
            $resultados[$key]["nombre"] = $cliente[1];
            $resultados[$key]["apellidos"] = $cliente[2];
            $resultados[$key]["domicilio"] = $cliente[3];
            $resultados[$key]["estado"] = $cliente[4];
            $resultados[$key]["codigopostal"] = $cliente[5];
            $resultados[$key]["contacto"] = $cliente[6];
            $resultados[$key]["rfc"] = $cliente[7];
            $resultados[$key]["email"] = $cliente[8];

        }
    }
}



echo json_encode($resultados);
