<?php

    include "../../../fGenerales/bd/conexion.php";

    // Obtener los datos del formulario
    $selectedValues = filter_input(INPUT_GET, "array");

    // Añadir corchetes al inicio y al final para convertir en un array JSON válido
    $jsonString = '[' . $selectedValues . ']';

    // Decodificar la cadena JSON en un array PHP
    $selectedValuesArray = json_decode($jsonString, true);

    $debug = '';
    $bandera = 0;

    // Si existe el array
    if (isset($selectedValuesArray) || count($selectedValuesArray)) 
    {
        // Agrupar los datos por el número de pasada (primer elemento del array)
        $agrupadosPorPasada = [];

        foreach ($selectedValuesArray as $values) {
            $pasadaCiclo = $values[0];
            $agrupadosPorPasada[$pasadaCiclo][] = $values;
        }

        $conexionInsertarPaquete = new conexion;
        $conexionEntradaInv = new conexion;
        $conexionRegistrarRelacion = new conexion;

        for( $punt = 0 ; $punt < count($agrupadosPorPasada) ; $punt++) 
        {

            if(isset($agrupadosPorPasada[$punt][0][1]))
            {
                $idPaquete = $agrupadosPorPasada[$punt][0][1];

                // REGISTRA EL PRODUCTO EN EL INVENTARIO
                $queryInsertarPaquete = " INSERT INTO inventario (id_producto, no_serial, id_estado, fecha_registro, tipo_movimiento)"
                . " VALUES ($idPaquete, 'NA', 1, NOW(), 4)"; // tipo_movimiento 4 ENTRADA PAQUETE A INVENTARIO
                
                if($conexionInsertarPaquete->conn->query($queryInsertarPaquete))
                {
                    $queryEntradaInv = "SELECT id_inventario FROM inventario ORDER BY id_inventario DESC LIMIT 1"; //VERIFICA LA ULTIMA ENTRADA ALINVENTARIO
                    $datos = $conexionEntradaInv->conn->query($queryEntradaInv);

                    if($datos->num_rows > 0)
                    {
                        foreach ($datos->fetch_all() as $i => $datos) 
                        {
                            $id_inventario = $datos[0];
                        }
                    
                        for( $punt2 = 0 ; $punt2 < count($agrupadosPorPasada[$punt]) ; $punt2++)
                        {
                            $id_producto = $agrupadosPorPasada[$punt][$punt2][2];

                            // REGISTRA EL PRODUCTO EN EL INVENTARIO
                            $queryInsertaRelacion = " INSERT INTO relation_inv_package_prod (id_inventario, id_prod_paq, id_estado)"
                            . " VALUES ($id_inventario, $id_producto, 1)"; 

                            if($conexionRegistrarRelacion->conn->query($queryInsertaRelacion))
                            {
                                $bandera = 1; //Exito al guardar la relacion y exito al insertar al inventario
                            }
                        }
                    }
                    else 
                    {
                        $bandera = 3; //Error, no hay nada en el inventario   
                    }
                } 
                else 
                {
                    $bandera = 2; //Error al insertar en inventario el paquete
                }
            }
        }
    }
    else
    {
        $bandera = 0; //Error, ocurrio un error en el sistema
    }

    $resultados["bandera"] = $bandera;
    $resultados["debug"] = $debug;

    echo json_encode($resultados);
?>
