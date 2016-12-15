<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
include_once("../../model/product-price.php");
$objProductPrice=new productprice();
$objProduct = new product();
$idProduct=$_GET['idProduct'];
$array = array();
$array['price'] = 0;
$array['info'] = 0;
$product=$objProduct->getProductById($idProduct);
$objProduct->publicProduct($idProduct,($product[0]['IS_ACTIVE']=='N')?'Y':'N');
$json = json_encode($array);
echo($json);
?>