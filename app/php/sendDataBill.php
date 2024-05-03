<?php 

include "../../fGenerales/bd/conexion.php";
include "../../fGenerales/php/funciones.php";
include "createPDFSell.php";
require '../../vendor/autoload.php';

$arrResult = [];

$arrData = json_decode(filter_input(INPUT_POST,"jsonData"));
$firmClient = filter_input(INPUT_POST,"firmClient");
$firmEmployee = filter_input(INPUT_POST,"firmEmployee");


$idFirmClient = createFirm(1,$firmClient);
$idFirmEmployee = createFirm(2,$firmEmployee);
$arrResult["pdf"] = createPDFSell(createSell($arrData,$idFirmClient,$idFirmEmployee));

echo json_encode($arrResult);

function createSell($data,$idFirmClient,$idFirmEmployee){
    if(isset($data->businessName)){
       return createInsertSell(true,$data,$idFirmClient,$idFirmEmployee);
     
    }else{
        return createInsertSell(false,$data,$idFirmClient,$idFirmEmployee);
       
    }
}

function createInsertSell($type,$arrData,$idFirmClient,$idFirmEmployee) {
    $connInsertSell = new conexion;
    $flagBill = "";
    if($arrData->flagBill == "true") {
        $flagBill = "1";
    } else {
        $flagBill = "0";
    }

    if($type) {
        $queryInsertSell = "INSERT INTO ventas (empleadoid,bandera_factura,firmaclientid,firmaempleadoid,nombre_cliente,direccion_cliente,telefono_cliente,razonsocial_cliente,CFDI_cliente,email_cliente) ".
        " VALUES(".$arrData->employeeid.",'".$flagBill."',".$idFirmClient.",".$idFirmEmployee.",'".$arrData->client."','".$arrData->address."','".$arrData->phone."','".$arrData->businessName."','".$arrData->cfdi."','".$arrData->email."') ";
    } else {
        $queryInsertSell = "INSERT INTO ventas (empleadoid,bandera_factura,firmaclientid,firmaempleadoid,nombre_cliente,direccion_cliente,telefono_cliente) ".
        " VALUES(".$arrData->employeeid.",'".$flagBill."',".$idFirmClient.",".$idFirmEmployee.",'".$arrData->client."','".$arrData->address."','".$arrData->phone."') ";
    }
    
    $connInsertSell->conn->query($queryInsertSell);

    createDataSellForItem(1,$arrData->arrIdproduct,$arrData->arrAccount,$connInsertSell->conn->insert_id);

    return $connInsertSell->conn->insert_id;

}

function createDataSellForItem($result,$dataProducts,$dataAccount,$idSell) {
  $dataIds = json_decode($dataProducts);
  $dataAccount = json_decode($dataAccount);

  foreach($dataIds as $index => $id) {
    $connFindInventoryActive = new conexion;
    $queryFindInventoryActive = "SELECT id_inventario FROM inventario i  where id_producto = ".$id." AND id_estado  = 1 limit ".$dataAccount[$index];
    $result = $connFindInventoryActive->conn->query($queryFindInventoryActive);

    foreach($result->fetch_all() as $data) {
        $connInsertSellProduct = new conexion;
        $queryInsertSellProduct = "INSERT INTO ventasproductos(id_inventario,id_venta) values(".$data[0].",".$idSell.")";
        $connInsertSellProduct->conn->query($queryInsertSellProduct);

        $connUpdateInventory = new conexion;
        $queryUpdateInventory = "UPDATE inventario SET id_estado = 2 WHERE id_inventario = ".$data[0];
        $connUpdateInventory->conn->query($queryUpdateInventory);
    }
  }
}

function createFirm($type,$firmData) {
    $ultimateSellId = findIdSell()+1;
    $imgFirma = base64_decode($firmData);
    $pathFirma = "firm-" . $ultimateSellId . ".jpg";
    if($type == 1){
        file_put_contents("../../ventas/src/firmClients/" . $pathFirma, $imgFirma);  
    } else {
        file_put_contents("../../ventas/src/firmEmployees/" . $pathFirma, $imgFirma);  
    }
    return $ultimateSellId;                    
}

function findIdSell(){
    $connFindUltimateId = new conexion;
    $queryFindUltimateId = "SELECT id_venta from ventas order by id_venta desc limit 1";
    $result = $connFindUltimateId->conn->query($queryFindUltimateId);
    if($result->num_rows > 0) {
      foreach($result->fetch_all() as $data) {
        return $data[0];
      } 
    }else{
       return 0;
    }
}
