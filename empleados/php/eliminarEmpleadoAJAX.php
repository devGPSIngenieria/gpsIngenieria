<?php
    include "../../fGenerales/bd/conexion.php";
    
    $id = filter_input(INPUT_GET, "id");

    $resultados = [];

    $resultados[0]["resultado"] = 0; //HUBO UN ERROR
    
    // CONEXION PARA ELIMINAR USUARIO
    $conexionEliminar = new conexion;
    $queryEliminar = "UPDATE empleados SET status = 2 WHERE idEmpleado = ".$id;

    $resultados[0]["query"] = $queryEliminar;

    if($conexionEliminar->conn->query($queryEliminar)){
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