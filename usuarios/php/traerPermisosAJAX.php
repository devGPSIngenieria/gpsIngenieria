<?php
    include "../../fGenerales/bd/conexion.php";

    $idusuario = filter_input(INPUT_GET, "idusuario");

    $conexionAreas = new conexion;
    $queryAreas = "SELECT * FROM areas WHERE id_estado = 1";
    $areas = $conexionAreas->conn->query($queryAreas);

    $datos = [];
    $datos["noDatosAreas"][0]["noDatos"] = $areas->num_rows;

    foreach ($areas->fetch_all() as $key => $area) {
        $datos["areas"][$key]["id"] = $area[0];
        $datos["areas"][$key]["nombre"] = $area[1];
    }

    $conexionPermisos = new conexion;
    $queryPermisos = "SELECT s.id_seccion ,s.id_area , s.nombre, p.id_usuario   
                        FROM seccion_area s LEFT JOIN permisos_secciones p  
                        ON  p.id_seccion = s.id_seccion and p.id_usuario =" . $idusuario
                    . " ORDER BY s.id_seccion ASC";
    $permisos = $conexionPermisos->conn->query($queryPermisos);

    $datos["noDatosSeccion"][0]["noDatos"] = $permisos->num_rows;

    foreach ($permisos->fetch_all() as $index => $permiso) {

        $datos["secciones"][$index]["idseccion"] = $permiso[0];
        $datos["secciones"][$index]["idarea"] = $permiso[1];
        $datos["secciones"][$index]["nombre"] = $permiso[2];
        $datos["secciones"][$index]["idusuario"] = $permiso[3];

        if ($permiso[3] != null) {
            $datos["secciones"][$index]["permiso"] = true;
        } else {
            $datos["secciones"][$index]["permiso"] = false;
        }
    }

    echo json_encode($datos);

?>