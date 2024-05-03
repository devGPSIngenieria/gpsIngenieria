<?php
// Cargar el autoloader de Composer
include '../../vendor/autoload.php';
include "../../fGenerales/bd/conexion.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

// Obtener la ruta temporal del archivo Excel subido
$archivoTemp = $_FILES["archivo"]["tmp_name"];

// Crear un objeto Reader para leer el archivo Excel
$reader = IOFactory::createReaderForFile($archivoTemp);

// Cargar el archivo Excel en un objeto PhpSpreadsheet
$spreadsheet = $reader->load($archivoTemp);

// Obtener la hoja activa del archivo Excel
$hojaActiva = $spreadsheet->getActiveSheet();

// Obtener el número de filas y columnas de la hoja
$numFilas = $hojaActiva->getHighestRow();
$numColumnas = $hojaActiva->getHighestColumn();

$contProducts = 0;

for ($fila = 2; $fila <= $numFilas; $fila++) {
    $arrData = [];
    for ($columna = 'A'; $columna <= $numColumnas; $columna++) {
        $valorCelda = $hojaActiva->getCell($columna . $fila)->getValue();
        $arrData[$columna] = $valorCelda ;  
    }
    if(insertNewProduct($arrData)) {
      $contProducts += 1;
    }
}
$arrResult["contPorducts"] = $contProducts;

echo json_encode($arrResult);


 function insertNewProduct($data) {
    $noParte = $data['A'];
    $descripcion = $data['B'];
    $precioPublico = $data['C'];
    $precioVenta = $data['C'] * 20 ;
    $idCategory = $data['D'];
    $idSubCategory = $data['E'];

    $connInsertProduct = new conexion;
    $queryInsertProduct = "INSERT INTO productos(no_parte,descripcion,precio_public,precio_venta,id_categoria,id_subcategoria,id_estado) ".
    " VALUES ('".$noParte."','".$descripcion."','".$precioPublico."','".$precioVenta."',".$idCategory.",".$idSubCategory.",1)";
    $connInsertProduct->conn->query($queryInsertProduct);

    return true;
    
 }

