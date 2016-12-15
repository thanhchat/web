<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
$objProduct = new product();
$txtProductId =$_GET['idProduct'];
$supplier=$_GET['supplier'];
$array = array();
$objProduct->updateSupplier($supplier,$txtProductId);
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);