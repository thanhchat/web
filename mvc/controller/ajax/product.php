<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../../mvc/model/category.php");
include_once("../../../mvc/model/product.php");
include_once("../../../mvc/model/feature.php");
$objCategory = new category();
$objProduct = new Product();
$objFeature = new feature();
$idProduct=(isset($_GET['idProduct']))?$_GET['idProduct']:0;
$feature=(isset($_GET['feature']))?$_GET['feature']:'';
$defaultPrice=0;
$defaultPromoPrice=0;
$defaultPriceT=$objProduct->getProductPrice($idProduct,'LIST_PRICE',-1);
$defaultPromoPriceT=$objProduct->getProductPrice($idProduct,'PROMO_PRICE',-1);
if(null!=$defaultPriceT)
		$defaultPrice=$defaultPriceT[0]['PRICE'];
if(null!=$defaultPromoPriceT)
		$defaultPromoPrice=$defaultPromoPriceT[0]['PRICE'];
$arrayFeature=explode('@',$feature);
foreach($arrayFeature as $k=>$v){
	$priceFTemp=$objProduct->getProductPrice($idProduct,'LIST_PRICE',$v);
	$pricePTemp=$objProduct->getProductPrice($idProduct,'PROMO_PRICE',$v);
	if(null!=$priceFTemp)
		$defaultPrice=$priceFTemp[0]['PRICE'];
	if(null!=$pricePTemp)
		$defaultPromoPrice=$pricePTemp[0]['PRICE'];
}
if($defaultPromoPrice>0){
	echo'<span class="price-new">'.number_format($defaultPromoPrice).' VNĐ</span><br>';
	echo'<span class="price-old">'.number_format($defaultPrice).' VNĐ</span><br>';
}else{
	echo'<span class="price-new">'.number_format($defaultPrice).' VNĐ</span><br>';
}