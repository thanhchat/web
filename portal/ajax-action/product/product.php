<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
$objProduct = new product();
$categoryId=$_POST['drpCategoryAdd'];
$manufactureId=mysql_real_escape_string(trim($_POST['txtProductIdAdd']));
$productName=mysql_real_escape_string(trim($_POST['txtProductNameAdd']));
$check=$objProduct->checkProductByManufactureId($manufactureId);
$array = array();
$array['mess'] = '';
if($check>0){
	$array['mess']='1';
}else{
	$check=$objProduct->addProduct(trim($manufactureId),$categoryId,trim($productName));
}
$json = json_encode($array);
echo($json);
?>