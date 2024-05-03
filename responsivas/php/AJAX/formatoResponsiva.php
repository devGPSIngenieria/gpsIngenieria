<?php
    include "../../../fGenerales/bd/conexion.php";
    require '../../../vendor/autoload.php';

    session_name('gpsingenieria');
    session_start();

    // VARIABLES GLOBALES
    $ancho = 5;
    $añoActual = date("Y");
    $fechaActual = date("d/m/Y");

    // ARRAYS QUE CONTIENEN LOS ID Y LOS VALORES SELECCIONADOS PARA LAS RESPONSIVAS
    $idsProductos = filter_input(INPUT_GET,'idsProductos');
    $idsProductos = explode(",", $idsProductos);
    $idEmpleado = filter_input(INPUT_GET,'idempleado');
    $comentarios = filter_input(INPUT_GET,'comentarios');
    $idUsuarioCreador = $_SESSION['usuarioid'];

    // IMPORTA LA CLASE Fpdf DE LA BIBLIOTECA
    use Fpdf\Fpdf as Fpdf;

    // INSTANCIA PDF CREADA
    $pdf = new Fpdf();

    // BANDERAFIRMADO 0 = NO FIRMADO
    $conInsertarResponsiva = new conexion;
    $queryInsertarResponsiva = "INSERT INTO responsivas (idempleado, id_firma, id_estado, fechacreacion, id_usuariocreador, comentario) VALUES ('".$idEmpleado."', 0, 1, now(), '".$idUsuarioCreador."', '".$comentarios."')";
    
    if($conInsertarResponsiva->conn->query($queryInsertarResponsiva)){
        
        $conSelectResponsiva = new conexion;
        $querySelectResponsiva = "SELECT id_responsiva, id_usuariocreador FROM responsivas WHERE id_estado=1 order by id_responsiva DESC LIMIT 1";
        $resultados = $conSelectResponsiva->conn->query($querySelectResponsiva);
       
        if($resultados && $resultados->num_rows > 0 ){

            $fila = $resultados->fetch_assoc();
            $idResponsiva = $fila['id_responsiva'];
            $usuarioCreador1 = $fila['id_usuariocreador'];

            $nombreArchivoPDF = 'Responsiva_' . $idResponsiva . '_' . $usuarioCreador1 . '.pdf';
            $rutaDestino = '../responsivas/' . $nombreArchivoPDF;

            // AGREGA UNA PAGINA AL PDF
            $pdf->AddPage();

            $pdf->SetLineWidth(.2); //GROSOR DE LINEA

            $pdf->SetFont('Arial', '', 12); //FUENTE
            $pdf->SetTitle('RESPONSIVA'); //TITULO DEL DOCUMENTO
            $pdf->SetAuthor('GPS INGENIERIA'); //AUTOR
            $pdf->SetCreator('GPSIngeniería © ' . $añoActual); //CREADOR

            $pdf->Cell(40, $ancho*3, "", "TLB",0,"C");
            $pdf->Image('../../../src/imagenes/logo.png', 24, 8.5, 17, 0, 'png'); //IMAGEN LOGO

            $pdf->SetFont('Arial', '', 10);
            $pdf->SetFillColor(137, 172, 118);

            $pdf->Cell(70, $ancho, "RESPONSIVA", "T",0,"C"); //RESPONSIVA
            $pdf->Cell(25, $ancho, utf8_decode("AÑO"), "TL",0,"C",true);  //AÑO
            $pdf->Cell(30, $ancho, "Responsiva.No", "RTL",0,"C",true); //NUMERO DE RESPONSIVA

            $pdf->SetTextColor(203,50,52); //COLOR ROJO PARA EL TEXTO
            $pdf->Cell(25, $ancho, "N.Folio", "RT",0,"C"); //NUMERO DE FOLIO


            $pdf->SetTextColor(0,0,0); //COLOR NEGRO
            $pdf->SetFont('Arial', '', 7); //FUENTE

            $pdf->Ln(); //SALTO DE LINEA

            $pdf->Cell(40, 30, "", 0); //CELDA VACÍA
            $pdf->Cell(70, $ancho, "Carta Responsiva entregada por GPS INGENIERIA","",0, "C"); //DESCRIPCIÓN RESPONSIVA
            $pdf->Cell(25, $ancho, $añoActual, "TL",0,"C"); //AÑO ACTUAL
            $pdf->Cell(30, $ancho, "#".$idResponsiva, "RTL",0,"C"); //NUMERO DE RESPONSIVA
            $pdf->Cell(25, $ancho, "", "RTL",0,"C"); //CELDA VACÍA


            $pdf->Ln(); // SALTO DE LINEA

            $pdf->Cell(40, $ancho, "", ""); //CELDA VACÍA
            $pdf->Cell(70, $ancho, "Col. Primero de Mayo CP: 36644 Tel: 462-173-51-96", "B",0,"C"); //DESCRIPCIÓN
            $pdf->Cell(25, $ancho, "Emitida:", "LTB",0,"C"); //EMITIDA 
            $pdf->Cell(30, $ancho, $fechaActual , "BTR",0); //FECHA ACTUAL
            $pdf->Cell(25, $ancho, "", "RB"); //CELDA VACÍA

            $pdf->Ln(20); // SALTO DE LINEA

            $pdf->SetTextColor(0,0,0); //COLOR NEGRO
            $pdf->SetFont('Arial', '', 10); //FUENTE
            $pdf->Cell(50, $ancho, "Fecha: " . $fechaActual, "",0,"L"); //FECHA
            $pdf->Ln(); // SALTO DE LINEA
            $pdf->Cell(50, $ancho, "Irapuato, Guanajuato", "",0,"L"); //LUGAR
            $pdf->Ln(20); // SALTO DE LINEA
            $pdf->Cell(190, $ancho, "A quien corresponda.", "",0,"L"); //TEXTO RESPONSIVA
            $pdf->Ln(10); // SALTO DE LINEA
            $pdf->Cell(190, $ancho, utf8_decode("Por medio de la presente, hago constar que recibí de la empresa GPS INGENIERIA el producto con las características"), "", 0, "L"); //TEXTO RESPONSIVA
            $pdf->Ln(); // SALTO DE LINEA
            $pdf->Cell(190, $ancho, utf8_decode("que se mencionan a continuación para el uso y desarrollo de actividades relacionadas con mi actividad laborar:"), "", 0, "L"); //TEXTO RESPONSIVA

            $pdf->Ln(10); // SALTO DE LINEA

            $pdf->SetFont('Arial', 'B', 10); //NEGRITAS

            $pdf->Cell(40, $ancho, utf8_decode("Número de parte"), "BTLR", 0, "C"); //TITULO DE TABLA
            $pdf->Cell(110, $ancho, utf8_decode("Descripción"), "BTLR", 0, "C"); //TITULO DE TABLA
            $pdf->Cell(40, $ancho, "Serial", "BTLR", 0, "C"); //TITULO DE TABLA

            $pdf->SetFont('Arial', '', 7); //FUENTE

            $pdf->Ln(); // SALTO DE LINEA

            for($puntero = 0 ; $puntero < count($idsProductos) ; $puntero++){

                $conexionProductos = new conexion;
                $queryProductos = "SELECT i.id_inventario, p.no_parte, p.descripcion, c.nombre, s.nombre, i.no_serial";
                $queryProductos .= " FROM productos p, categoria c, subcategoria s, inventario i";
                $queryProductos .= " WHERE i.id_producto = p.id_producto AND p.id_categoria = c.id_categoria";
                $queryProductos .= " AND p.id_subcategoria = s.id_subcategoria AND i.id_estado = 1 AND i.id_inventario = " . $idsProductos[$puntero];
                $datosResponsiva = $conexionProductos->conn->query($queryProductos);

                $datosResponsiva = $datosResponsiva->fetch_row();
                $idProductoInv = $datosResponsiva[0];
                $numParte = $datosResponsiva[1];
                $descripcion = $datosResponsiva[2];
                $categoria = $datosResponsiva[3];
                $subcategoria = $datosResponsiva[4];
                $serial = $datosResponsiva[5];
                
                // INSERTA LA RELACION DE PRODUCTOS CON LA RESPONSIVA
                $conInsertarRelacion = new conexion;
                $queryInsertarRelacion = "INSERT INTO relacion_responsiva_productos (id_responsiva, id_inventario, id_estado) VALUES ('".$idResponsiva."', '".$idProductoInv."', 1)";
                $conInsertarRelacion->conn->query($queryInsertarRelacion);

                // ACTUALIZA LAS EXISTENCIAS 
                $updateExistencias = new conexion;
                $queryUpdateExistencias = "UPDATE inventario SET tipo_movimiento = 3 WHERE id_inventario = " . $idsProductos[$puntero];
                $updateExistencias->conn->query($queryUpdateExistencias);

                $pdf->Cell(40, $ancho, utf8_decode($numParte), "BTLR", 0, "C"); //NUMERO DE PARTE
                $pdf->Cell(110, $ancho, utf8_decode($descripcion), "BTLR", 0, "C"); //DESCRIPCION
                $pdf->Cell(40, $ancho, utf8_decode($serial), "BTLR", 0, "C"); //SERIAL

                $pdf->Ln(); // SALTO DE LINEA
            }
            $pdf->Ln(5); // SALTO DE LINEA
            $pdf->SetFont('Arial', '', 9); //FUENTE
            $pdf->Cell(190, $ancho, utf8_decode("* Comentario:"), "", 0, "BL"); //COMENTARIOS
            $pdf->Ln(); // SALTO DE LINEA
            $pdf->SetFont('Arial', '', 8); //FUENTE
            if($comentarios == ""){
                $comentarios = "Sin comentarios.";
            }
            $pdf->Cell(190, $ancho, utf8_decode($comentarios), "", 0, "L"); //COMENTARIOS

            $pdf->Ln(10); // SALTO DE LINEA

            $pdf->SetTextColor(0,0,0); //COLOR NEGRO
            $pdf->SetFont('Arial', '', 10); //FUENTE
            $pdf->Cell(190, $ancho, utf8_decode("El cual me comprometo a cuidar, mantener en buen estado y utilizarlo única y exclusivamente para asuntos relacionados"), "", 0, "L"); //TEXTO RESPONSIVA
            $pdf->Ln(); // SALTO DE LINEA
            $pdf->Cell(190, $ancho, utf8_decode("con mi actividad laboral. En caso de su extravío, daño o uso inadecuado, me responsabilizo con la reposición del equipo,"), "", 0, "L"); //TEXTO RESPONSIVA
            $pdf->Ln(); // SALTO DE LINEA
            $pdf->Cell(190, $ancho, utf8_decode("según el anexo, así como, al momento de devolverlo, entregarlo en condiciones optimas de uso."), "", 0, "L"); //TEXTO RESPONSIVA

            $pdf->Ln(10); // SALTO DE LINEA
            $pdf->Cell(190, $ancho, utf8_decode("ATTE:"), "", 0, "C"); //TEXTO RESPONSIVA

            $pdf->Ln(15); // SALTO DE LINEA
            $pdf->Cell(90, $ancho, utf8_decode("______________________________________________"), "", 0, "C"); //FIRMA DEL RESPONSABLE
            $pdf->Cell(10, $ancho, utf8_decode(""), "", 0, "C"); //ESPACIO
            $pdf->Cell(90, $ancho, utf8_decode("______________________________________________"), "", 0, "C"); //FIRMA DE QUIEN AUTORIZA
            $pdf->Ln(); // SALTO DE LINEA
            $pdf->Cell(90, $ancho, utf8_decode("Firma de responsable."), "", 0, "C"); //PERSONA RESPONSABLE
            $pdf->Cell(10, $ancho, utf8_decode(""), "", 0, "C"); //ESPACIO
            $pdf->Cell(90, $ancho, utf8_decode("Firma de autorización."), "", 0, "C"); //PERSONA AUTORIZA
            $pdf->Ln(); // SALTO DE LINEA

            $conexionUsuarioResponsable = new conexion;
            $queryUsuarioResponsable = "SELECT CONCAT(nombre, ' ',apellidos) FROM empleados WHERE status=1 AND idempleado = " . $idEmpleado;
            $datosResponsable = $conexionUsuarioResponsable->conn->query($queryUsuarioResponsable);
            $datosResponsable = $datosResponsable->fetch_row();
            $nombreEmpleado = $datosResponsable[0];

            $pdf->Cell(90, $ancho, utf8_decode($nombreEmpleado . "."), "", 0, "C"); //PERSONA RESPONSABLE
            $pdf->Cell(10, $ancho, utf8_decode(""), "", 0, "C"); //ESPACIO
            $pdf->Cell(90, $ancho, utf8_decode("*Nombre de quien autoriza."), "", 0, "C"); //PERSONA AUTORIZA

            $pdf->Output($rutaDestino, 'F');

            // Devolver la ruta del archivo PDF en la respuesta AJAX
            $respuesta = ['rutaPDF' => $nombreArchivoPDF];
    
        } else {
            $respuesta = ['error' => "Error al obtener el último ID de responsiva."];
        }
    } else {
        $respuesta = ['error' => "Error al insertar la responsiva en la base de datos."];
    }
    
    // Envía la respuesta JSON
    // header('Content-Type: application/json');
    echo json_encode($respuesta);
?>