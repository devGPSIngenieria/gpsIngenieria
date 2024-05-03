<?php 


include "../../fGenerales/bd/conexion.php";

$idseccion = filter_input(INPUT_GET,"idseccion");
$idusuario = filter_input(INPUT_GET,"idusuario");

$conexionChecarPermiso = new conexion;
$queryChecarPermiso = "SELECT * FROM permisos_secciones WHERE id_usuario = ".$idusuario." and id_seccion = ".$idseccion;

$checar = $conexionChecarPermiso->conn->query($queryChecarPermiso);
$resultado = [];

if($checar->num_rows>0){

    //ELIMINANDO PERMISO
    $conexionEliminarPermiso = new conexion;
    $queryEliminarPermiso = "DELETE FROM permisos_secciones WHERE id_usuario = ".$idusuario." and id_seccion = ".$idseccion;
    $conexionEliminarPermiso->conn->query($queryEliminarPermiso);

    $resultado["resultado"] = true;

}else{

    $conexionAgregarPermisos = new conexion;
    $queryAgregarPermisos = "INSERT INTO permisos_secciones (id_usuario, id_seccion) VALUES (".$idusuario.",".$idseccion.") ";
    $conexionAgregarPermisos->conn->query($queryAgregarPermisos);

    $resultado["resultado"] = false;
}

echo json_encode($resultado);