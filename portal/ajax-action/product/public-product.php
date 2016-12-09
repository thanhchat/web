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
$listPrice=$objProductPrice->getListProductPriceByIdProduct($idProduct);
if(count($listPrice)==0){
	$array['price'] = 1;
}else{
	if($product[0]['MANUFACTURER_PARTY_ID']==null ||$product[0]['MANUFACTURER_PARTY_ID']=='' || $product[0]['PRODUCT_NAME']==null ||$product[0]['PRODUCT_NAME']=='' ||($product[0]['DESCRIPTION']==null&&$product[0]['LONG_DESCRIPTION']==null)||($product[0]['DESCRIPTION']==''&&$product[0]['LONG_DESCRIPTION']=='')){
		$array['info'] = 1;
		}else{
				$product=$objProduct->publicProduct($idProduct,($product[0]['IS_ACTIVE']=='N')?'Y':'N');
				}
}

$json = json_encode($array);
echo($json);
?>