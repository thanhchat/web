<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
$objProduct = new product();
$txtProductId =$_GET['id'];
$txtProductName =mysql_real_escape_string(trim($_POST['txtProductName']));
$txtDescription =mysql_real_escape_string(trim($_POST['txtDescription']));
$txtLongDescription =$_POST['txtLongDescription'];
$txtProductKH =mysql_real_escape_string(trim($_POST['txtProductEdit']));
$drpCategory =$_POST['drpCategoryEdit'];
$array = array();
$check=$objProduct->updateInfoProduct($drpCategory,$txtProductKH,$txtProductName,$txtDescription,$txtLongDescription,$txtProductId);
if($check)
	$array['mess']=1;
else
	$array['mess']=2;
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);