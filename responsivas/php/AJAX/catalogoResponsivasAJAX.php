<?php
    include_once "../../../fGenerales/bd/conexion.php";
    
    // TRAE LOS PRODUCTOS
    $conObtenerResponsivas = new conexion;
    $queryObtenerResponsivas = "SELECT r.idresponsiva, CONCAT(e.nombre,' ',e.apellidos), r.fechacreacion, r.banderafirmado, r.estadoid, u.nombreusuario
    FROM responsivas r, empleados e, usuarios u WHERE e.idEmpleado = r.idempleado AND r.idusuario = u.idusuario AND r.estadoid = 1";
    $resultados = $conObtenerResponsivas->conn->query($queryObtenerResponsivas);

    $bandera = 0;
    $idResponsiva = array();
    $nombreUsuario = array();
    $fechaCreacion = array();
    $firmado = array();
    $usuarioid = array();

    if($resultados->num_rows > 0){

        $bandera = 1;
        
        foreach ($resultados->fetch_all() as $responsiva) {

            $idResponsiva[] = $responsiva[0];
            $nombreUsuario[] = $responsiva[1];
            $fechaCreacion[] = $responsiva[2];
                        
            if($responsiva[3] == 0){
                $firmado[] = 'No';
            } else {
                $firmado[] = 'Si';
            }
            $usuarioid[] = $responsiva[5];
        }
    }

    $respuesta = [
        'mensaje' => 'Catalogo de responsivas',
        'bandera' => $bandera,
        'idResponsiva' => $idResponsiva,
        'nombreUsuario' => $nombreUsuario,
        'firmado' => $firmado,
        'fechaCreacion' => $fechaCreacion,
        'usuarioid' => $usuarioid
    ];

    header('Content-Type: application/json');
    echo json_encode($respuesta);
?>