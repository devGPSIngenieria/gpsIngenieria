<?php 

include "../../fGenerales/bd/conexion.php";

$id = filter_input(INPUT_GET,"id");


$conexionPagos = new conexion;

$query="SELECT pagoid,cantidad FROM pagos WHERE ordenid=".$id;

// echo $query;
$datos=$conexionPagos->conn->query($query);



$resultado=[];

$resultado["noDatos"] = $datos->num_rows;


if($resultado["noDatos"]>0){

    foreach($datos->fetch_all() as $index=>$pago){


        $resultado[$index]["id"] = $pago[0];
        $resultado[$index]["cantidad"] = $pago[1];
    
        
    }

    $resultado["resultado"]=true;

}

else{

    $resultado["resultado"]=false;
}






echo json_encode($resultado);