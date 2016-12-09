<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
$objProduct = new product();
$array = array();
if(isset($_GET['id'])){
    $Id = $_GET['id'];
    $array = $objProduct->getProductById($Id);
}
$json = json_encode($array);
echo($json);
?>