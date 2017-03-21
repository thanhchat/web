<?php
function getProductPrice($listProductPrice,$type,$feature){
    foreach($listProductPrice as $k=>$v){
        if($v['PRODUCT_PRICE_TYPE_ID']==$type&&$v['TERM_UOM_ID']==$feature)
            return $v;
    }
    return null;
}
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../../mvc/model/product.php");
$objProduct = new Product();
$idProduct = (isset($_GET['idProduct'])) ? $_GET['idProduct'] : 0;
$feature = (isset($_GET['feature'])) ? $_GET['feature'] : '';
$defaultPrice = 0;
$defaultPromoPrice = 0;
$listPriceProduct=$objProduct->getListProductPriceByIdProduct($idProduct);//get list price product by id
$defaultPriceT =getProductPrice($listPriceProduct,'LIST_PRICE',-1);// $objProduct->getProductPrice($idProduct, 'LIST_PRICE', -1);
$defaultPromoPriceT =getProductPrice($listPriceProduct,'PROMO_PRICE',-1);// $objProduct->getProductPrice($idProduct, 'PROMO_PRICE', -1);
if (null != $defaultPriceT)
    $defaultPrice = $defaultPriceT['PRICE'];
if (null != $defaultPromoPriceT)
    $defaultPromoPrice = $defaultPromoPriceT['PRICE'];
$arrayFeature = explode('@', $feature);
foreach ($arrayFeature as $k => $v) {
    $priceFTemp = getProductPrice($listPriceProduct,'LIST_PRICE',$v);//$objProduct->getProductPrice($idProduct, 'LIST_PRICE', $v);
    $pricePTemp = getProductPrice($listPriceProduct,'PROMO_PRICE',$v);//$objProduct->getProductPrice($idProduct, 'PROMO_PRICE', $v);
    if (null != $priceFTemp)
        $defaultPrice = $priceFTemp['PRICE'];
    if (null != $pricePTemp)
        $defaultPromoPrice = $pricePTemp['PRICE'];
}
if ($defaultPromoPrice > 0) {
    echo '<span class="price-new">' . number_format($defaultPromoPrice) . ' VNĐ</span><br>';
    echo '<span class="price-old">' . number_format($defaultPrice) . ' VNĐ</span><br>';
} else {
    echo '<span class="price-new">' . number_format($defaultPrice) . ' VNĐ</span><br>';
}