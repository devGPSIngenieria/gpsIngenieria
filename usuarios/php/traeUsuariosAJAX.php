<?php
    include "../../fGenerales/bd/conexion.php";
    
    $resultados = [];

    if (isset($_GET['nombre']) && isset($_GET['login']) && isset($_GET['correo']) ) {
                
        $cadenaQuery = '';
        if($_GET['nombre'] != ''){
            $cadenaQuery .= " AND nombre LIKE '%" . $_GET['nombre'] . "%'";
        }
        if($_GET['login'] != ''){
            $cadenaQuery .= " AND usuario LIKE '%" . $_GET['login'] . "%'";
        }
        if($_GET['correo'] != ''){
            $cadenaQuery .= " AND correo LIKE '%" . $_GET['correo'] . "%'";
        }

        //TRAYENDO LOS DATOS 
        $conexionUsuarios = new conexion;
        $queryUsuarios = "SELECT *FROM usuarios WHERE id_estado = 1 " . $cadenaQuery;
        $datos = $conexionUsuarios->conn->query($queryUsuarios);

        if ($conexionUsuarios->conn->query($queryUsuarios)) {
            
            $resultados[0]["noDatos"] = $datos->num_rows;

            foreach ($datos->fetch_all() as $key => $usuario) {
                $resultados[$key]["idusuario"] = $usuario[0];
                $resultados[$key]["nombreusuario"] = $usuario[1];
                $resultados[$key]["passwordusuario"] = $usuario[2];
                $resultados[$key]["correo"] = $usuario[3];
                $resultados[$key]["nombre"] = $usuario[4];
            }
            $resultados["resultado"] = 1;
        } else {
            $resultados["resultado"] = 2;
        }
    } else {
        $resultados["resultado"] = 0;
    }
    echo json_encode($resultados);
?>