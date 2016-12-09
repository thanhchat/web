<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product-price.php");
$objProductPrice=new productprice();
$array=array();
$array['error']=0;
$idProduct=$_GET['idProduct'];
if(!empty($_POST)){
    $action=$_POST['action'];
    if($action=='add'){
        $listProductPriceType =$_POST['listProductPriceType'];
        $listProductFeature =$_POST['listProductFeature'];
        $txtProductPrice =$_POST['txtProductPrice'];
		$arrayPrice=explode(',',$txtProductPrice);
        $listCurrencyUom =$_POST['listCurrencyUom'];
		$check=$objProductPrice->checkProductPrice($idProduct,$listProductPriceType,$listProductFeature,$listCurrencyUom);
		if($check>0)
			$array['error']=1;
		else
			$objProductPrice->addProductPrice($listProductPriceType,$listProductFeature,$listCurrencyUom,$arrayPrice[0].$arrayPrice[1],null,$idProduct);
    }
    if($action=='edit'){
		$productPriceTypeKey=$_GET['productPriceTypeId'];
		$currencyUomIdKey=$_GET['currencyUomId'];
		$featureKey=$_GET['feature'];
		$listProductPriceType =$_POST['listProductPriceType'];
        $listProductFeature =$_POST['listProductFeature'];
        $txtProductPrice =$_POST['txtProductPrice'];
		$arrayPrice=explode(',',$txtProductPrice);
        $listCurrencyUom =$_POST['listCurrencyUom'];
		$objProductPrice->updateProductPrice($listProductPriceType,$listProductFeature,$listCurrencyUom,$arrayPrice[0].$arrayPrice[1],null,$idProduct,$productPriceTypeKey,$currencyUomIdKey,$featureKey);
    }
}
if(isset($_GET['action'])&&$_GET['action']=='del'){
		$productPriceTypeKey=$_GET['productPriceTypeId'];
		$currencyUomIdKey=$_GET['currencyUomId'];
		$featureKey=$_GET['feature'];
		$objProductPrice->deleteProductPrice($idProduct,$productPriceTypeKey,$currencyUomIdKey,$featureKey);
}
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);
?>