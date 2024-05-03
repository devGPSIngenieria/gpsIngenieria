<?php

include "../../fGenerales/bd/conexion.php";

require '../../vendor/autoload.php';

use Fpdf\Fpdf as Fpdf;

// Crear una nueva instancia de FPDF
$pdf = new Fpdf();
$pdf->AddPage();

$ancho = 5;

//sacando el id de la orden de trabajo

$ordenId = filter_input(INPUT_GET,"ordenid");

$conexionOrden = new conexion;
$queryConexion = "SELECT c.* FROM ordentrabajo ot  join
clientes c on c.idcliente = ot.idcliente
WHERE ordenid = ".$ordenId;

$datosOrden = $conexionOrden->conn->query($queryConexion);

$datosOrden = $datosOrden->fetch_row();

$nombre = $datosOrden[1]." ".$datosOrden[2];
$domicilio = $datosOrden[3];
$estado = $datosOrden[4];
$codigoPostal = $datosOrden[5];
$contacto = $datosOrden[6];
$rfc = $datosOrden[7];
$email = $datosOrden[8];




// Agregar la imagen como fondo de la página
// $pdf->Image('../../src/imagenes/logo.jpg', 0, 0, 100, 100);

$pdf->SetLineWidth(.2);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, $ancho*3, "", "TLB");

$pdf->Image('../../src/imagenes/logo.jpg', 15, 11, 12, 0, 'JPG');//LOGO

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(137, 172, 118);

$pdf->Cell(65, $ancho, "ORDEN DE TRABAJO", "RT",0,"C");//ORDEN DE TRABAJO
$pdf->Cell(40, $ancho, "ENVIOS", "TLR",0,"C",true);//ENVIOS
$pdf->Cell(25, $ancho, "Orden.No", "RTL",0,"C",true);//Orden.No

$pdf->SetTextColor(203,50,52);//rojo
$pdf->Cell(25, $ancho, "N.Folio", "RT",0,"C");//ORDEN DE TRABAJO


$pdf->SetTextColor(0,0,0);//negro
$pdf->SetFont('Arial', '', 6);
$pdf->Ln(); // Salto de línea

$pdf->Cell(40, 30, "", 0);
$pdf->Cell(65, $ancho, "Calle: Ley del Seguro Social No.545   Irapuato,Guanajuato, Mex.", "R");
$pdf->Cell(40, $ancho, "Paqueteria", "TLR",0);//Paqueteria
$pdf->Cell(25, $ancho, "Fecha", "RTL",0);//Fecha
$pdf->Cell(25, $ancho, "", "RTL",0);//vacio


$pdf->Ln(); // Salto de línea

$pdf->Cell(40, 30, "", 0);
$pdf->Cell(65, $ancho, "Colonia Primero de Mayo CP: 36644  Tel: 462-173-51-96", "RB");
$pdf->Cell(40, $ancho, "Rastreo", "TLR",0);//Rastreo
$pdf->Cell(50, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(105, $ancho, "Cliente/Empresa: ".$nombre, "LRB");
$pdf->Cell(40, $ancho, "Accesorios", "TLR",0);//Rastreo
$pdf->Cell(50, $ancho, "Recibido por:", "LR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(105, $ancho, "Domicilio: ".$domicilio, "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(25, $ancho, "Modelo:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por


$pdf->Ln(); // Salto de línea

$pdf->Cell(105, $ancho, "", "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(25, $ancho, "Descripcion:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por


$pdf->Ln(); // Salto de línea

$pdf->Cell(60, $ancho, "Ciudad,Estado y CP: " .$estado.",".$codigoPostal, "LRB");
$pdf->Cell(45, $ancho, "RFC: ".$rfc, "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(50, $ancho, "No.De serie:", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(60, $ancho, "Contacto: " .$contacto, "LRB");
$pdf->Cell(45, $ancho, "e-mail: " . $email, "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(50, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "TLRB");

//SERVICIOS 

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, $ancho, "Trabajo a Realizar" ,"TLR",0,"C",true);//ENVIOS//Recibido por

$pdf->SetFont('Arial', '', 6);
$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Demostracion:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Instalacion:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Servicio:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Garantia:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Reparacion:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea


$pdf->SetFont('Arial', '', 10);
$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(50, $ancho, "Vo.Bo","TLR",0,"C",true);//ENVIOS//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(50, $ancho, "","TLR",0,"C");//ENVIOS//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(50, $ancho, "","LR",0);//ENVIOS//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(50, $ancho, "","LR",0);//ENVIOS//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(50, $ancho, "","LR",0);//ENVIOS//Recibido por


$pdf->Ln(); // Salto de línea

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(29, $ancho, "No.de Parte", "LRT",0,"C",true);
$pdf->Cell(58, $ancho, "Descripcion", "LRT",0,"C",true);
$pdf->Cell(18, $ancho, "Cant.", "LRT",0,"C",true);
$pdf->Cell(20, $ancho, "Precio", "LRT",0,"C",true);
$pdf->Cell(20, $ancho, "Total", "LRT",0,"C",true);
$pdf->Cell(50, $ancho, "", "LR");

$pdf->Ln(); // Salto de línea

$pdf->Cell(29, $ancho, "", "LRT",0);
$pdf->Cell(58, $ancho, "", "LRT",0);
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "Fecha:", "LRB");

$pdf->Ln(); // Salto de línea

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, $ancho, "", "LRT",0);
$pdf->Cell(58, $ancho, "", "LRT",0);
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "Nombre y firma del Responsable", "LR",0,"C");

$pdf->Ln(); // Salto de línea


$pdf->Cell(29, $ancho, "", "LRT",0);
$pdf->Cell(58, $ancho, "", "LRT",0);
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea


$pdf->Cell(29, $ancho, "", "LRT",0);
$pdf->Cell(58, $ancho, "", "LRT",0);
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea


$pdf->Cell(29, $ancho, "", "LRT",0);
$pdf->Cell(58, $ancho, "", "LRT",0);
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");

$pdf->Ln(); // Salto de línea


$pdf->Cell(64, $ancho, "Garantias", "LRT",0,"C",true);
$pdf->Cell(23, $ancho, "Calibracion", "LRT",0,"C");
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea

$pdf->Cell(24, $ancho, "", "LRT",0);
$pdf->Cell(40, $ancho, "", "LRT",0);
$pdf->Cell(23, $ancho, "Mano de Obra","LRT",0,"C");
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "Fecha:", "LR",0);

$pdf->Ln(); // Salto de línea

$pdf->Cell(24, $ancho, "", "LRT",0);
$pdf->Cell(40, $ancho, "", "LRT",0);
$pdf->Cell(23, $ancho, "Horas de Viaje","LRT",0,"C");
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "Nombre Y Firma del Cliente:", "TLR",0,"C");


$pdf->Ln(); // Salto de línea

$pdf->Cell(24, $ancho, "", "LRT",0);
$pdf->Cell(40, $ancho, "", "LRT",0);
$pdf->Cell(23, $ancho, "Kilometraje","LRT",0,"C");
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0);



$pdf->Ln(); // Salto de línea


$pdf->Cell(64, $ancho, "Prestamo de equipo", "LRT",0,"C",true);
$pdf->Cell(41, $ancho, "Cobranza", "LRT",0,"C",true);
$pdf->Cell(20, $ancho, "Subtotal", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea



$pdf->Cell(16, $ancho, "No.Parte", "LRT",0,"C");
$pdf->Cell(16, $ancho, "No.Serie", "LRT",0,"C");
$pdf->Cell(32, $ancho, "Descripcion", "LRT",0,"C");
$pdf->Cell(41, $ancho, "Factura No:", "LRT",0);
$pdf->Cell(20, $ancho, "Flete", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea



$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(32, $ancho, "", "LRT",0,"C");
$pdf->Cell(41, $ancho, "Fecha de Pago:", "LRT",0);
$pdf->Cell(20, $ancho, "I.V.A", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea



$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(32, $ancho, "", "LRT",0,"C");
$pdf->Cell(41, $ancho, "Metodo de Pago:", "LRT",0);
$pdf->Cell(20, $ancho*2, "Total", "LRTB",0,"C");
$pdf->Cell(20, $ancho*2, "$", "LRTB",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea



$pdf->Cell(16, $ancho, "", "LRTB",0,"C");
$pdf->Cell(16, $ancho, "", "LRTB",0,"C");
$pdf->Cell(32, $ancho, "", "LRTB",0,"C");
$pdf->Cell(41, $ancho, "Importe:", "LRTB",0);
$pdf->Cell(90, $ancho, "Fecha :", "LRB",0,"C");











// // Agregar filas de datos
// foreach ($data as $row) {
//     foreach ($row as $col) {
//         $pdf->Cell(40, 10, $col, 1);
//     }
//     $pdf->Ln(); // Salto de línea después de cada fila
// }

$pdf->Output();