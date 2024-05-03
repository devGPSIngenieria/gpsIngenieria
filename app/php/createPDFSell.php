<?php

include "../../fGenerales/bd/conexion.php";
require '../../vendor/autoload.php';

use Fpdf\Fpdf as Fpdf;

createPDFSell(8);

function createPDFSell($idSell)
{

    $dataSell = findDataSell($idSell);

    $pdf = new Fpdf();
    $pdf->AddPage();

    $ancho = 5;

    $pdf->Image('../../src/imagenes/logo.jpg', 0, 0, 50, 50);

    $pdf->SetLineWidth(.2);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(125, $ancho, "Agriculture and Services GPS", "", 0, "C");
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, $ancho, "NOTA DE REMISION", "LTRB", 0, "C");
    $pdf->Ln(); // Salto de línea
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(125, $ancho, "Irapuato", "", 0, "C");
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(203, 50, 52);
    $pdf->Cell(0, $ancho, "N Folio", "LTRB", 0, "C");
    $pdf->Ln(); // Salto de línea
    $pdf->Ln(); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //negro
    $pdf->Cell(125, $ancho, "ASG190529JV6", "", 0, "C");

    $pdf->Ln(); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //negro
    $pdf->Cell(125, $ancho, "facturasgps1@gmail.com", "", 0, "C");

    $pdf->Ln(); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //negro
    $pdf->Cell(125, $ancho, "Ley del Seguro Social 545", "", 0, "C");
    $pdf->Cell(0, $ancho, "FECHA", "LTRB", 0, "C");

    $pdf->Ln(); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //negro
    $pdf->Cell(125, $ancho, "Col. Primero de Mayo,", "", 0, "C");
    $pdf->Cell(0, $ancho, date("d/m/Y"), "LTRB", 0, "C");
    $pdf->Ln(); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //negro
    $pdf->Cell(125, $ancho, "Irapuato Gto", "", 0, "C");

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln(); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //negro
    $pdf->Cell(190, $ancho, "NOMBRE:  " . $dataSell["nombre"], "LTRB", 0, "L");

    $pdf->Ln(); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //negro
    $pdf->Cell(190, $ancho, "DIRECCION:  " . $dataSell["direccion"], "LTRB", 0, "L");

    $pdf->Ln(); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //negro
    $pdf->Cell(190, $ancho, "TELEFONO:  " . $dataSell["telefono"], "LTRB", 0, "L");

    $pdf->Ln(); // Salto de línea

    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "CANTIDAD:", "LTRB", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(100, $ancho, "DESCRIPICION:", "LTRB", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "PRECIO:", "LTRB", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "IMPORTE:", "LTRB", 0, "C");

    for ($i = 0; $i < $dataSell["count"]; $i++) {
        addNewProduct($pdf, $ancho, $dataSell[$i]);
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "", "", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(100, $ancho, "", "", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "TOTAL:", "LTRB", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, $dataSell["total"], "LTRB", 0, "C");

    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(45, $ancho, "FACTURACION", "", 0, "L");
    if ($dataSell["flagBill"] == 1) {
        $pdf->SetFillColor(0, 255, 0);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }

    $pdf->Cell(15, $ancho, "SI", "", 0, "C", true);
    if ($dataSell["flagBill"] == 0) {
        $pdf->SetFillColor(0, 255, 0);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }
    $pdf->Cell(15, $ancho, "NO", "", 0, "C", true);

    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "RAZON SOCIAL:  " , "", 0, "L");
    $pdf->Cell(160, $ancho,  $dataSell["razonSocial"], "B", 0, "L");
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "USO DE CFDI:  " , "", 0, "L");
    $pdf->Cell(160, $ancho, $dataSell["CFDI"], "B", 0, "L");
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(50, $ancho, "CORREO ELECTRONICO  " , "", 0, "L");
    $pdf->Cell(140, $ancho, $dataSell["email"], "B", 0, "L");


    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "", "", 0, "L");
    $pdf->Cell(40, $ancho, "", "B", 0, "L");
    $pdf->Cell(45, $ancho, "", "", 0, "L");
    $pdf->Cell(40, $ancho, "", "B", 0, "L");


    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->Image('../../src/imagenes/firm-12.jpg', 0, 0, 620, 563);

    // $pdf->Cell(30, $ancho, "", "", 0, "L");
    // $pdf->Cell(40, $ancho, "Firma Empleado", "", 0, "C");
    // //$pdf->Image('../../ventas/src/firmClients/firm-12.jpg', 0, 0, 50, 250);
    // $pdf->Cell(45, $ancho, "", "", 0, "L");
    // $pdf->Cell(40, $ancho, "Firma Cliente", "", 0, "C");

    $pdfFilePath = '../../ventas/src/pdfSells/sell'.$idSell.'.pdf';

   // $pdf->Output($pdfFilePath, 'F');
    $pdf->Output('I');

    //$server = "http://192.184.24.85";
    $server = "https://inggpsmexico.com";
    return $server."/gpsIngenieria/ventas/src/pdfSells/sell".$idSell.".pdf";
}


function addNewProduct($pdf, $ancho, $data)
{
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, $data["cuenta"], "LTRB", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(100, $ancho, $data["descripcion"], "LTRB", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, $data["precio"], "LTRB", 0, "C");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(30, $ancho, "", "LTRB", 0, "C");
}

function findDataSell($idSell)
{
    $connFindEmployee = new conexion;
    $queryFindEmployee = "SELECT*FROM ventas e  WHERE id_venta = " . $idSell;
    $result = $connFindEmployee->conn->query($queryFindEmployee);

    $dataResult = [];
    foreach ($result->fetch_all() as $data) {
        $dataResult["nombre"] = $data[5];
        $dataResult["direccion"] = $data[6];
        $dataResult["telefono"] = $data[7];

        $dataResult["razonSocial"] = $data[8] == null ? "":$data[8];
        $dataResult["CFDI"] = $data[8] == null ? "":$data[8];
        $dataResult["email"]= $data[8] == null ? "":$data[8];

        $dataProductSell = findProductsSell($idSell);
        $count = 0;
        $total = 0;
        foreach ($dataProductSell->fetch_all() as $dataProduct) {
            $arrDataproduct = [];
            $arrDataproduct["cuenta"] = $dataProduct[0];
            $arrDataproduct["descripcion"] = $dataProduct[1];
            $arrDataproduct["precio"] = $dataProduct[2];
            $total += $dataProduct[2];
            $dataResult[] = $arrDataproduct;
            $count += 1;
        }
        if($data[2] == 1){
            $dataResult["total"] = $total+($total*.16);
        } else {
            $dataResult["total"] = $total;
        }
        $dataResult["count"] = $count;
        $dataResult["flagBill"] = $data[2];
    }

    return $dataResult;
}

function findProductsSell($idSell)
{
    $connFindEmployee = new conexion;
    $queryFindEmployee = "SELECT COUNT(v.id_inventario),p.descripcion ,p.precio_venta * COUNT(v.id_inventario) AS precio FROM ventasproductos v 
    join   inventario i on v.id_inventario = i.id_inventario 
    join   productos p  on i.id_producto  = p.id_producto 
    where v.id_venta = " . $idSell . " 
    GROUP by v.id_inventario ";
    return $connFindEmployee->conn->query($queryFindEmployee);
}
