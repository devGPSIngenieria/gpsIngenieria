<?php

require '../../vendor/autoload.php';

use Fpdf\Fpdf as Fpdf;

// Crear una nueva instancia de FPDF
$pdf = new Fpdf();
$pdf->AddPage();
// Encabezados de la tabla
$header = array('Nombre', 'Edad', 'País');

// Datos de la tabla
$data = array(
    array('Juan', '30', 'España'),
    array('María', '25', 'México'),
    array('Carlos', '28', 'Argentina')
);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 30, "", "TLB");

$pdf->Image('../../src/imagenes/logo.jpg', 15, 11, 25, 0, 'JPG');//LOGO

$pdf->Cell(70, 10, "ORDEN DE TRABAJO", "RT");//ORDEN DE TRABAJO

$pdf->SetFont('Arial', '', 6);
$pdf->Ln(); // Salto de línea

$pdf->Cell(40, 30, "", 0);
$pdf->Cell(70, 10, "Calle: Ley del Seguro Social No.545   Irapuato,Guanajuato, Mex.", "R");

$pdf->Ln(); // Salto de línea

$pdf->Cell(40, 30, "", 0);
$pdf->Cell(70, 10, "Colonia Primero de Mayo CP: 36644  Tel: 462-173-51-96", "RB");

// Configurar fuente y tamaño para el contenido de la tabla


$pdf->Ln(); // Salto de línea

// // Agregar filas de datos
// foreach ($data as $row) {
//     foreach ($row as $col) {
//         $pdf->Cell(40, 10, $col, 1);
//     }
//     $pdf->Ln(); // Salto de línea después de cada fila
// }

$pdf->Output();