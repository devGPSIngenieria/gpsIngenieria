<?php

    include "../../../fGenerales/bd/conexion.php";

    $arrRegSeleccionados = json_decode($_GET['arrRegSeleccionados']);            

    if($arrRegSeleccionados != null){

        $longitudArreglo = count($arrRegSeleccionados);
        $numParte = array();
        $descripcion = array();
        $existentes = array();
        $precioxunidad = array();
        $nombre = array();

        for($puntero = 0; $puntero < $longitudArreglo; $puntero++){
            
            $conexionProductos = new conexion;
            $queryProducto = "SELECT p.*,c.nombre  FROM productos p , categoriasproductos c  WHERE c.idcategoriaproducto = p.categoria AND p.idproducto = " . $arrRegSeleccionados[$puntero];
            $resultadoConsulta = $conexionProductos->conn->query($queryProducto);
            
            foreach ($resultadoConsulta->fetch_all() as $producto){
                $numParte[] = $producto[1];
                $descripcion[] = $producto[2];
                $existentes[] = $producto[6];
                $precioxunidad[] = $producto[8];
                $nombre[] = $producto[9];
            }
        }

        $respuesta = [
            'mensaje' => 'Operación exitosa',
            'bandera' => 1,
            'array' => $arrRegSeleccionados,
            'numParte' => $numParte,
            'descripcion' => $descripcion,
            'existentes' => $existentes,
            'precioxunidad' => $precioxunidad,
            'nombre' => $nombre,
        ];

    } else {
        
        $respuesta = [
            'mensaje' => 'arreglo null',
            'bandera' => 0
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($respuesta);

?>