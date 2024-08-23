<?php
    include "../../../fGenerales/bd/conexion.php";
    
    $resultados = [];

    if (isset($_GET['nombre'])) {

        $cadenaQuery = '';
        if($_GET['nombre'] != ''){
            $cadenaQuery .= " AND pr.descripcion LIKE '%" . $_GET['nombre'] . "%'";
        }

        // TRAER CATEGORIAS
        $conexionTraePackages = new conexion;
        $queryTraePackages = "SELECT pr.descripcion, p.id_estado, pr.precio_public, pr.id_producto"
                            . " FROM packages p, productos pr"
                            . " WHERE p.id_producto = pr.id_producto and p.id_estado = 1" . $cadenaQuery
                            . " GROUP BY pr.descripcion, p.id_estado, pr.precio_public, pr.id_producto";
        $datos = $conexionTraePackages->conn->query($queryTraePackages);
        
        if ($datos) {

            $resultados["noDatos"] = $datos->num_rows;

            foreach($datos->fetch_all(MYSQLI_ASSOC) as $i => $dato){
                $resultados["paquetes"][$i] = [
                    "descripcion" => $dato['descripcion'],
                    "id_estado" => $dato['id_estado'],
                    "precio_public" => $dato['precio_public'],
                    "id_producto" => $dato['id_producto'],

                    "packages" => []
                ];

                // TRAER PACKAGES
                $conexionTraeProd = new conexion;
                $queryTraeProd = "SELECT pp.numero_parte, pp.descripcion, p.id_producto"
                                . " FROM packages p, pruducts_packages pp"      
                                . " WHERE p.id_estado = 1 AND p.id_prod_paq = pp.id_prod_paq AND p.id_producto =" . $dato['id_producto'];
                $datosP = $conexionTraeProd->conn->query($queryTraeProd);

                if ($datosP && $datosP->num_rows > 0) {
                    foreach($datosP->fetch_all(MYSQLI_ASSOC) as $j => $datoP){
                        $resultados["paquetes"][$i]["packages"][$j] = $datoP;
                    }
                } else {
                    // $resultados["categorias"][$i]["packages"][$j];
                }
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
