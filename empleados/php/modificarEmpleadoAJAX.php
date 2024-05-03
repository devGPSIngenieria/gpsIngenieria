<?php

    include "../../fGenerales/bd/conexion.php";

    $id = filter_input(INPUT_POST, "id");
    $nombre = filter_input(INPUT_POST, "nombre");
    $apellidos = filter_input(INPUT_POST, "apellidos");
    $correo = filter_input(INPUT_POST, "correo");
    $telefonoCelular = filter_input(INPUT_POST, "telefonoCelular");
    $puesto = filter_input(INPUT_POST, "puesto");

    $resultados = [];

    $resultados[0]["resultado"] = 0; //ALGO SALIO MAL

    if ($id=="" || $nombre=="" || $apellidos=="" || $correo=="" || $telefonoCelular=="" || $puesto=="") {

        $resultados[0]["resultado"] = 1; // DATOS VACÍOS

    } else {

        //CONEXIÓN PARA ACTUALIZAR DATOS DEL EMPLEADO 
        $conexionModificar = new conexion;
        $queryModificar = "UPDATE empleados SET nombre='".$nombre."', apellidos='".$apellidos."', correo='".$correo."', telefono = '".$telefonoCelular."', puesto = '".$puesto."' WHERE idEmpleado = ".$id;

        if ($conexionModificar->conn->query($queryModificar)) {

            $resultados[0]["resultado"] = 2; //SE MODIFICO EL EMPLEADO

            // /OBTIENE LOS DATOS
            $conexionEmpleados = new conexion;
            $queryEmpleados = "SELECT*FROM empleados";
            $datos = $conexionEmpleados->conn->query($queryEmpleados);

            $resultados[0]["noDatos"] = $datos->num_rows;

            foreach ($datos->fetch_all() as $key => $cliente) {

                $resultados[$key]["idempleado"] = $cliente[0];
                $resultados[$key]["nombre"] = $cliente[1];
                $resultados[$key]["apellidos"] = $cliente[2];
                $resultados[$key]["correo"] = $cliente[3];
                $resultados[$key]["telefono"] = $cliente[4];
                $resultados[$key]["puesto"] = $cliente[5];

            }
        }
    }
    echo json_encode($resultados);
?>