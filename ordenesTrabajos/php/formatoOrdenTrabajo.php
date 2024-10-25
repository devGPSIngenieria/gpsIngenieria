<?php
//include "../../fGenerales/bd/conexion.php";
//require '../../vendor/autoload.php';
include "../../constants.php";
use Fpdf\Fpdf as Fpdf;


//createPDFOrden(99);

function createPDFOrden($idorden)
{
$server = DataConfig::SERVER;
$pdf = new Fpdf();
$pdf->AddPage();

$ancho = 5;

//sacando el id de la orden de trabajo

$ordenId = $idorden;

$conexionOrden = new conexion;
$queryConexion = "SELECT c.*,ot.* FROM ordentrabajo ot  join
clientes c on c.idclient = ot.idcliente
WHERE numfolio = ".$ordenId;

$datosOrden = $conexionOrden->conn->query($queryConexion);

$datosOrden = $datosOrden->fetch_row();

$numFolio = $datosOrden[8];
$nombre = $datosOrden[1];
$domicilio = $datosOrden[2];
$estado = $datosOrden[3];
$fecha = $datosOrden[19];
$fechaSeparada = explode(" ", $fecha);
$fecha = $fechaSeparada[0];
$codigoPostal = "";
$contacto = $datosOrden[4];
$rfc = $datosOrden[5];
$email = $datosOrden[6];
$trabajoRealizado = $datosOrden[10];
$problema = $datosOrden[11];
$comentarios = $datosOrden[12];
$totalPago = $datosOrden[16];

$conexionWorkServices = new conexion;
$queryWorkServices = "SELECT idwork FROM trabajo_realizado WHERE numfolio = ".$ordenId;
$datosWorkServices = $conexionWorkServices->conn->query($queryWorkServices)
;
$conexionServices = new conexion;
$queryServices = "SELECT*FROM servicios s WHERE numfolio =  ".$ordenId;
$datosServices = $conexionServices->conn->query($queryServices);
$arrServices = $datosServices->fetch_all();

// Agregar la imagen como fondo de la página
// $pdf->Image('../../src/imagenes/logo.jpg', 0, 0, 100, 100);


$dataProducts = findProductsOrden($ordenId)->fetch_all();

$pdf->SetLineWidth(.2);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, $ancho*3, "", "TLB");

$pdf->Image('../../src/imagenes/logo.jpg', 15, 11, 12, 0, 'JPG');//LOGO

//$pdf->Image($server.'/gpsIngenieria/ordenesTrabajos/src/firmas/firmaEmpleado86.jpg', 165, 120, 20, 20);
//$pdf->Image($server.'/gpsIngenieria/ordenesTrabajos/src/firmas/firmaCliente86.jpg', 165, 150, 20, 20);
$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(137, 172, 118);

$pdf->Cell(65, $ancho, "ORDEN DE TRABAJO", "RT",0,"C");//ORDEN DE TRABAJO
$pdf->Cell(40, $ancho, "", "TLR",0,"C",true);//ENVIOS
$pdf->Cell(25, $ancho, "Orden.No", "RTL",0,"C",true);//Orden.No

$pdf->SetTextColor(203,50,52);//rojo
$pdf->Cell(25, $ancho, "N.Folio " . $numFolio, "RT",0,"C");//ORDEN DE TRABAJO


$pdf->SetTextColor(0,0,0);//negro
$pdf->SetFont('Arial', '', 6);
$pdf->Ln(); // Salto de línea

$pdf->Cell(40, 30, "", 0);
$pdf->Cell(65, $ancho, "Calle: Ley del Seguro Social No.545   Irapuato,Guanajuato, Mex.", "R");
$pdf->Cell(40, $ancho, "", "TLR",0);//Paqueteria
$pdf->Cell(25, $ancho, "Fecha " . $fecha, "RTL",0);//Fecha
$pdf->Cell(25, $ancho, "", "RTL",0);//vacio


$pdf->Ln(); // Salto de línea

$pdf->Cell(40, 30, "", 0);
$pdf->Cell(65, $ancho, "Colonia Primero de Mayo CP: 36644  Tel: 462-173-51-96", "RB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(50, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(105, $ancho, "Cliente/Empresa: ".$nombre, "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(50, $ancho, "Recibido por:", "LR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(105, $ancho, "Domicilio: ".$domicilio, "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por


$pdf->Ln(); // Salto de línea

$pdf->Cell(105, $ancho, "", "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por


$pdf->Ln(); // Salto de línea

$pdf->Cell(60, $ancho, "Ciudad,Estado y CP: " .$estado.",".$codigoPostal, "LRB");
$pdf->Cell(45, $ancho, "RFC: ".$rfc, "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(50, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(60, $ancho, "Contacto: " .$contacto, "LRB");
$pdf->Cell(45, $ancho, "e-mail: " . $email, "LRB");
$pdf->Cell(40, $ancho, "", "TLR",0);//Rastreo
$pdf->Cell(50, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "Problema encontrado : " . $problema, "TLRB");

//SERVICIOS 

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, $ancho, "Trabajo a Realizar" ,"TLR",0,"C",true);//ENVIOS//Recibido por

$pdf->SetFont('Arial', '', 6);
$pdf->Ln(); // Salto de línea

$resultWorkServices = $datosWorkServices->fetch_all();
foreach($resultWorkServices as $data) {
   if(1 == $data[0]) {
    $pdf->Image('../../src/imagenes/check.jpg', 191, 56, 3, 0, 'JPG');
   }
 }

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Demostracion:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea
foreach($resultWorkServices as $data) {
    if(2 == $data[0]) {
        $pdf->Image('../../src/imagenes/check.jpg', 191, 61, 3, 0, 'JPG');
    }
  }

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Instalacion:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea
foreach($resultWorkServices as $data) {
    if(3 == $data[0]) {
        $pdf->Image('../../src/imagenes/check.jpg', 191, 66, 3, 0, 'JPG');
    }
  }
$pdf->Cell(145, $ancho, "Trabajo Realizado : ".$trabajoRealizado, "LRB");
$pdf->Cell(25, $ancho, "Servicio:", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea
foreach($resultWorkServices as $data) {
    if(4 == $data[0]) {
        $pdf->Image('../../src/imagenes/check.jpg', 191, 71, 3, 0, 'JPG');
    }
  }

$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Garantia", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea
foreach($resultWorkServices as $data) {
    if(5 == $data[0]) {
        $pdf->Image('../../src/imagenes/check.jpg', 191, 76, 3, 0, 'JPG');
    }
  }
$pdf->Cell(145, $ancho, "", "LRB");
$pdf->Cell(25, $ancho, "Reparacion :", "TLR",0);//Recibido por
$pdf->Cell(25, $ancho, "", "TLR",0);//Recibido por

$pdf->Ln(); // Salto de línea

$pdf->Cell(145, $ancho, "Comentarios : ".$comentarios, "LRB");
$pdf->SetFont('Arial', '', 10);
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
if (count($dataProducts) > 0) {
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(29, $ancho, $dataProducts[0][2], "LRT",0);
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(58, $ancho, $dataProducts[0][1], "LRT",0);
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(18, $ancho, $dataProducts[0][0], "LRT",0, 'C');
  $pdf->Cell(20, $ancho, "$".$dataProducts[0][3], "LRT",0 , 'C');
  $totalProduct = floatval($dataProducts[0][3]) * floatval($dataProducts[0][0]);
  $pdf->Cell(20, $ancho, "$".$totalProduct, "LRT",0 , 'C');
  $pdf->Cell(50, $ancho, "Fecha:", "LRB");
} else {
  $pdf->Cell(29, $ancho, "", "LRT",0);
  $pdf->Cell(58, $ancho, "", "LRT",0);
  $pdf->Cell(18, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(50, $ancho, "Fecha:", "LRB");
}

$pdf->Ln(); // Salto de línea
if (count($dataProducts) > 1) {
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(29, $ancho, $dataProducts[1][2], "LRT",0);
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(58, $ancho, $dataProducts[1][1], "LRT",0);
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(18, $ancho, $dataProducts[1][0], "LRT",0, 'C');
  $pdf->Cell(20, $ancho, "$".$dataProducts[1][3], "LRT",0 , 'C');
  $totalProduct = floatval($dataProducts[1][3]) * floatval($dataProducts[1][0]);
  $pdf->Cell(20, $ancho, "$".$totalProduct, "LRT",0 , 'C');
  $pdf->Cell(50, $ancho, "Nombre y firma del Responsable", "LR",0,"C");
} else {
  $pdf->Cell(29, $ancho, "", "LRT",0);
  $pdf->Cell(58, $ancho, "", "LRT",0);
  $pdf->Cell(18, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(50, $ancho, "Nombre y firma del Responsable", "LR",0,"C");
}


$pdf->Ln(); // Salto de línea

if (count($dataProducts) > 2) {
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(29, $ancho, $dataProducts[2][2], "LRT",0);
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(58, $ancho, $dataProducts[2][1], "LRT",0);
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(18, $ancho, $dataProducts[2][0], "LRT",0, 'C');
  $pdf->Cell(20, $ancho, "$".$dataProducts[2][3], "LRT",0 , 'C');
  $totalProduct = floatval($dataProducts[2][3]) * floatval($dataProducts[2][0]);
  $pdf->Cell(20, $ancho, "$".$totalProduct, "LRT",0 , 'C');
  $pdf->Cell(50, $ancho, "", "LR",0,"C");
} else {
  $pdf->Cell(29, $ancho, "", "LRT",0);
  $pdf->Cell(58, $ancho, "", "LRT",0);
  $pdf->Cell(18, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(50, $ancho, "", "LR",0,"C");
}

$pdf->Ln(); // Salto de línea

if (count($dataProducts) > 3) {
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(29, $ancho, $dataProducts[3][2], "LRT",0);
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(58, $ancho, $dataProducts[3][1], "LRT",0);
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(18, $ancho, $dataProducts[3][0], "LRT",0, 'C');
  $pdf->Cell(20, $ancho, "$".$dataProducts[3][3], "LRT",0 , 'C');
  $totalProduct = floatval($dataProducts[3][3]) * floatval($dataProducts[3][0]);
  $pdf->Cell(20, $ancho, "$".$totalProduct, "LRT",0 , 'C');
  $pdf->Cell(50, $ancho, "", "LR",0,"C");
} else {
  $pdf->Cell(29, $ancho, "", "LRT",0);
  $pdf->Cell(58, $ancho, "", "LRT",0);
  $pdf->Cell(18, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(50, $ancho, "", "LR",0,"C");
}


$pdf->Ln(); // Salto de línea

if (count($dataProducts) > 4) {
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(29, $ancho, $dataProducts[4][2], "LRT",0);
  $pdf->SetFont('Arial', '', 6);
  $pdf->Cell(58, $ancho, $dataProducts[4][1], "LRT",0);
  $pdf->SetFont('Arial', '', 8);
  $pdf->Cell(18, $ancho, $dataProducts[4][0], "LRT",0, 'C');
  $pdf->Cell(20, $ancho, "$".$dataProducts[4][3], "LRT",0 , 'C');
  $totalProduct = floatval($dataProducts[4][3]) * floatval($dataProducts[4][0]);
  $pdf->Cell(20, $ancho, "$".$totalProduct, "LRT",0 , 'C');
  $pdf->Cell(50, $ancho, "", "LR",0,"C");
} else {
  $pdf->Cell(29, $ancho, "", "LRT",0);
  $pdf->Cell(58, $ancho, "", "LRT",0);
  $pdf->Cell(18, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(20, $ancho, "", "LRT",0);
  $pdf->Cell(50, $ancho, "", "LR",0,"C");
}

$pdf->Ln(); // Salto de línea


$pdf->Cell(64, $ancho, "Garantias", "LRT",0,"C",true);
$pdf->Cell(23, $ancho, "", "LRT",0,"C");
$pdf->Cell(18, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea

$pdf->Cell(24, $ancho, "", "LRT",0);
$pdf->Cell(40, $ancho, "", "LRT",0);
$pdf->Cell(23, $ancho, "Mano de Obra","LRT",0,"C");
$pdf->Cell(18, $ancho, $arrServices[2][3], "LRT",0,"C");
$pdf->Cell(20, $ancho, "$750", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$".$arrServices[2][3]*750, "LRT",0,"C");
$pdf->Cell(50, $ancho, "Fecha:", "LR",0);

$pdf->Ln(); // Salto de línea

$pdf->Cell(24, $ancho, "", "LRT",0);
$pdf->Cell(40, $ancho, "", "LRT",0);
$pdf->Cell(23, $ancho, "Horas de Viaje","LRT",0,"C");
$pdf->Cell(18, $ancho, $arrServices[1][3], "LRT",0,"C");
$pdf->Cell(20, $ancho, "$350", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$".$arrServices[1][3]*350 , "LRT",0,"C");
$pdf->Cell(50, $ancho, "Nombre Y Firma del Cliente:", "TLR",0,"C");


$pdf->Ln(); // Salto de línea

$pdf->Cell(24, $ancho, "", "LRT",0);
$pdf->Cell(40, $ancho, "", "LRT",0);
$pdf->Cell(23, $ancho, "Kilometraje","LRT",0,"C");
$pdf->Cell(18, $ancho,  $arrServices[0][3], "LRT",0,"C");
$pdf->Cell(20, $ancho, "$5", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$".$arrServices[0][3]*5, "LRT",0,"C");
$pdf->Cell(50, $ancho, "", "LR",0);



$pdf->Ln(); // Salto de línea


$pdf->Cell(64, $ancho, "", "LRT",0,"C",true);
$pdf->Cell(41, $ancho, "Cobranza", "LRT",0,"C",true);
$pdf->Cell(20, $ancho, "Subtotal", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$".($totalPago-($totalPago*.16)), "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea



$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(32, $ancho, "", "LRT",0,"C");
$pdf->Cell(41, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "Flete", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$", "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea



$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(32, $ancho, "", "LRT",0,"C");
$pdf->Cell(41, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho, "I.V.A", "LRT",0,"C");
$pdf->Cell(20, $ancho, "$".($totalPago*.16), "LRT",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea



$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(16, $ancho, "", "LRT",0,"C");
$pdf->Cell(32, $ancho, "", "LRT",0,"C");
$pdf->Cell(41, $ancho, "", "LRT",0);
$pdf->Cell(20, $ancho*2, "Total", "LRTB",0,"C");
$pdf->Cell(20, $ancho*2, "$".$totalPago, "LRTB",0);
$pdf->Cell(50, $ancho, "", "LR",0,"C");


$pdf->Ln(); // Salto de línea



$pdf->Cell(16, $ancho, "", "LRTB",0,"C");
$pdf->Cell(16, $ancho, "", "LRTB",0,"C");
$pdf->Cell(32, $ancho, "", "LRTB",0,"C");
$pdf->Cell(41, $ancho, "", "LRTB",0);
$pdf->Cell(90, $ancho, "Fecha :", "LRB",0,"C");

$pdf->Image($server.'/gpsIngenieria/ordenesTrabajos/src/firmas/firmaEmpleado'.$numFolio.'.jpg', 165, 120, 20, 20);
$pdf->Image($server.'/gpsIngenieria/ordenesTrabajos/src/firmas/firmaCliente'.$numFolio.'.jpg', 165, 150, 20, 20);


$pdfFilePath = '../../ordenesTrabajos/src/pdf/orden'.$ordenId.'.pdf';
$pdf->Output($pdfFilePath, 'F');
 //$pdf->Output('I');
 //$server = "https://inggpsmexico.com";
 return $server."/gpsIngenieria/ordenesTrabajos/src/pdf/orden".$ordenId.".pdf";

}


function findProductsOrden($idOrden)
{
    $connFindProductsOrden = new conexion;
    $queryFindProductsOrden = "SELECT COUNT(i.id_producto) as cantidad, p.descripcion, p.no_parte, p.precio_venta AS precio FROM ventas_orden v 
    join   inventario i on v.id_inventario = i.id_inventario 
    join   productos p  on i.id_producto  = p.id_producto 
    where v.id_orden  = " . $idOrden . " 
    GROUP by i.id_producto  ";
    return $connFindProductsOrden->conn->query($queryFindProductsOrden);
}
