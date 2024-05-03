<?php

include "../../fGenerales/bd/conexion.php";

$nombres = filter_input(INPUT_POST, "nombres");
$apellidos = filter_input(INPUT_POST, "apellidos");
$domicilio = filter_input(INPUT_POST, "domicilio");
$estado = filter_input(INPUT_POST, "estado");
$codigoPostal = filter_input(INPUT_POST, "codigoPostal");
$contacto = filter_input(INPUT_POST, "contacto");
$rfc = filter_input(INPUT_POST, "rfc");
$email = filter_input(INPUT_POST, "email");

// $nombre = filter_input(INPUT_GET, "nombre");
// $login = filter_input(INPUT_GET, "login");
// $correo = filter_input(INPUT_GET, "correo");
// $password = filter_input(INPUT_GET, "password");


$resultados = [];

//CREAR NUEVO CLIENTE
$resultados[0]["resultado"] = 0; //HUBO UN ERROR

$conexionCliente = new conexion;
$queryCliente = "INSERT INTO clientes(nombre,apellidos,domicilio,estado,codigopostal,contacto,rfc,email) VALUES ('".$nombres."','".$apellidos."','".$domicilio."','".$estado."','".$codigoPostal."','".$contacto."','".$rfc."','".$email."')";

//echo json_encode($queryCliente);
if($conexionCliente->conn->query($queryCliente)){
    $resultados[0]["resultado"] = 1;

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





echo json_encode($resultados);
