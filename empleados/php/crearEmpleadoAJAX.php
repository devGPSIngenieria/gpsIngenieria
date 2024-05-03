<?php
    include "../../fGenerales/bd/conexion.php";

    $nombre = filter_input(INPUT_POST, "nombre");
    $apellidos = filter_input(INPUT_POST, "apellidos");
    $correo = filter_input(INPUT_POST, "correo");
    $telefono = filter_input(INPUT_POST, "TelefonoCelular");
    $puesto = filter_input(INPUT_POST, "puesto");

    $resultados = [];

    //CREAR NUEVO EMPLEADO
    $resultados[0]["resultado"] = 0; //HUBO UN ERROR

    $conexionEmpleado = new conexion;
    $queryEmpleado = "INSERT INTO empleados(nombre,apellidos,correo,telefono,puesto,status) VALUES ('".$nombre."', '".$apellidos."', '".$correo."', ".$telefono." , '".$puesto."',1)";
    
    if($conexionEmpleado->conn->query($queryEmpleado)){
        $resultados[0]["resultado"] = 1;

        //TRAYENDO LOS DATOS 
        $conexionConsultarEmpleados = new conexion;
        $queryConsultarEmpleados = "SELECT * FROM empleados WHERE status = 1";
        $datos = $conexionConsultarEmpleados->conn->query($queryConsultarEmpleados);

        $resultados[0]["noDatos"] = $datos->num_rows;

        foreach ($datos->fetch_all() as $key => $empleado) {

            $resultados[$key]["idempleado"] = $empleado[0];
            $resultados[$key]["nombre"] = $empleado[1];
            $resultados[$key]["apellidos"] = $empleado[2];
            $resultados[$key]["correo"] = $empleado[3];
            $resultados[$key]["telefono"] = $empleado[4];
            $resultados[$key]["puesto"] = $empleado[5];
        }
    }

    echo json_encode($resultados);
?>