<?php 

function datosTabla(&$array,$conexion,$parametros){


    $queryDatos = "SELECT ot.ordenid,ot.numfolio,c.nombre ,c.apellidos,u.nombre,ot.totalpago,ot.fecha,ot.saldopendiente,ot.factura,ot.flete   FROM ordentrabajo ot,clientes c,usuarios u  WHERE ot.idcliente = c.idcliente and u.idusuario = ot.idusuario  ".$parametros;
        //echo $queryDatos;

        $datos = $conexion->conn->query($queryDatos);

        $array["noDatos"] = $datos->num_rows;

        foreach ($datos->fetch_all() as $i => $dato) {

            $array[$i]["id"] = $dato[0];
            $array[$i]["numfolio"] = $dato[1];
            $array[$i]["cliente"] = $dato[2] . " " . $dato[3];
            $array[$i]["trabajador"] = $dato[4];
            $array[$i]["total"] = $dato[5];
            $array[$i]["fecha"] = $dato[6];
            $array[$i]["factura"] = $dato[8];
            $array[$i]["pagoP"] = $dato[7];
            $array[$i]["flete"] = $dato[9];
        }



}