<?php
    include_once "../../../fGenerales/bd/conexion.php";

    // TRAE LOS PRODUCTOS
    $conexionProductos = new conexion;
    $queryProductos = "SELECT p.*,c.nombre  FROM productos p , categoriasproductos c  WHERE c.idcategoriaproducto = p.categoria";
    $resultados = $conexionProductos->conn->query($queryProductos);

    $bandera = 0;

    $idProducto = array();
    $numParte = array();
    $existencias = array();
    $precioUnidad = array();
    $foto = array();

    if($resultados->num_rows > 0){
        
        $bandera = 1;

        foreach ($resultados->fetch_all() as $columna) {
            $idProducto[] = $columna[0];
            $numParte[] = $columna[1];
            $existencias[] = $columna[6];
            $precioUnidad[] = $columna[8];
            
            $imagenPath = "/gpsIngenieria/productos/imgsProductos/producto_" . $columna[0] . ".jpg";
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagenPath)) {
                $foto[] = $imagenPath;
            } else {
                $foto[] = '/gpsIngenieria/productos/imgsProductos/sinImagen.png';
            }
        }
    }
    
    $respuesta = [
        'mensaje' => 'Productos',
        'bandera' => $bandera,
        'idProducto' => $idProducto,
        'numParte' => $numParte,
        'existencias' => $existencias,
        'precioUnidad' => $precioUnidad,
        'foto' => $foto
    ];

    header('Content-Type: application/json');
    echo json_encode($respuesta);
                    
?>