<?php
/**
 * Created by PhpStorm.
 * User: thanhchat
 * Date: 07/01/2017
 * Time: 21:30
 */
function getProductPrice($listProductPrice, $type, $feature)
{
    foreach ($listProductPrice as $k => $v) {
        if ($v['PRODUCT_PRICE_TYPE_ID'] == $type && $v['TERM_UOM_ID'] == $feature)
            return $v;
    }
    return null;
}

include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../../mvc/model/product.php");
include_once("../../../mvc/model/feature.php");
include_once("../../../mvc/model/ClassShoppingCart.php");
$objProduct = new Product();
$objFeature = new feature();
$objCart = new ClassShoppingCart();
$idProduct = (isset($_GET['idProduct'])) ? $_GET['idProduct'] : 0;
$feature = (isset($_GET['feature_add'])) ? $_GET['feature_add'] : -1;
$quantity = (isset($_GET['qty'])) ? $_GET['qty'] : 1;
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
$arrayResult = array();
$arrayResult['error'] = 0;
if ($action == 'add' && is_numeric($idProduct) && $idProduct >= 15062016) {
    if ($feature != -1) {//get product feature
        $defaultPrice = 0;
        $defaultPromoPrice = 0;
        $productFeature = $objProduct->getProductByFeatureAndIdProductParent($idProduct, $feature);
        if (null != $productFeature) {
            $listPrice = $objProduct->getListProductPriceByIdProduct($idProduct);
            $defaultPriceT = getProductPrice($listPrice, 'LIST_PRICE', -1);// $objProduct->getProductPrice($idProduct, 'LIST_PRICE', -1);
            $defaultPromoPriceT = getProductPrice($listPrice, 'PROMO_PRICE', -1);// $objProduct->getProductPrice($idProduct, 'PROMO_PRICE', -1);
            if (null != $defaultPriceT)
                $defaultPrice = $defaultPriceT['PRICE'];
            if (null != $defaultPromoPriceT)
                $defaultPromoPrice = $defaultPromoPriceT['PRICE'];
            $arrayFeature = explode('@', $feature);
            foreach ($arrayFeature as $k => $v) {
                $priceFTemp = getProductPrice($listPrice, 'LIST_PRICE', $v);//$objProduct->getProductPrice($idProduct, 'LIST_PRICE', $v);
                $pricePTemp = getProductPrice($listPrice, 'PROMO_PRICE', $v);//$objProduct->getProductPrice($idProduct, 'PROMO_PRICE', $v);
                if (null != $priceFTemp)
                    $defaultPrice = $priceFTemp['PRICE'];
                if (null != $pricePTemp)
                    $defaultPromoPrice = $pricePTemp['PRICE'];
            }
            $featureName = '';
            if (null != $productFeature[0]['FEATURE_ID'] && $productFeature[0]['FEATURE_ID'] != '') {
                $arrayFeatureType = explode('@', $productFeature[0]['FEATURE_TYPE_ID']);
                $featureLoad = explode('@', $productFeature[0]['FEATURE_ID']);
                foreach ($arrayFeatureType as $key => $value) {
                    $FeatureTypeName = $objFeature->getFeatureTypeById($value);
                    $featureName .= $FeatureTypeName[0]['DESCRIPTION_FEATURE_TYPE'] . ' : ';
                    $featureNameT = $objFeature->getFeatureByArrayId(explode(':', $featureLoad[$key]));
                    foreach ($featureNameT as $keyF => $valueF) {
                        $featureName .= $valueF['DESCRIPTION_FEATURE'] . ', ';
                    }
                    $featureName = rtrim($featureName, ", ");
                    $featureName .= '<br>';
                }
            }
            $img = explode('@@@', $productFeature[0]['SMALL_IMAGE_URL']);
            if (count($img) < 2) {
                $productParent = $objProduct->getProductByIdNotListPrice($idProduct);
                $img = explode('@@@', $productParent[0]['SMALL_IMAGE_URL']);
            }
            $objCart->addProductToCart($idProduct, $productFeature[0]['MANUFACTURER_PARTY_ID'], $productFeature[0]['PRODUCT_ID'], $quantity, $featureName, $defaultPrice, $defaultPromoPrice, (isset($img[1]) && $img[1] != '') ? $img[1] : '', $productFeature[0]['PRODUCT_NAME'],$productFeature[0]['URL']);
            $arrayResult['total_item'] = $objCart->get_total_item();
            $arrayResult['total_order'] = number_format($objCart->get_order_total()) . ' VNĐ';
            $json = json_encode($arrayResult);
            echo($json);
        } else {
            $arrayResult['error'] = 1;
        }
    } else {//get product parent
        $productParent = $objProduct->getProductByIdNotListPrice($idProduct);
        if (null != $productParent) {
            $defaultPrice = 0;
            $defaultPromoPrice = 0;
            $listPrice = $objProduct->getListProductPriceByIdProduct($idProduct);
            $defaultPriceT = getProductPrice($listPrice, 'LIST_PRICE', -1);// $objProduct->getProductPrice($idProduct, 'LIST_PRICE', -1);
            $defaultPromoPriceT = getProductPrice($listPrice, 'PROMO_PRICE', -1);// $objProduct->getProductPrice($idProduct, 'PROMO_PRICE', -1);
            if (null != $defaultPriceT)
                $defaultPrice = $defaultPriceT['PRICE'];
            if (null != $defaultPromoPriceT)
                $defaultPromoPrice = $defaultPromoPriceT['PRICE'];
            $img = explode('@@@', $productParent[0]['SMALL_IMAGE_URL']);
            $objCart->addProductToCart($idProduct, $productParent[0]['MANUFACTURER_PARTY_ID'], $productParent[0]['PRODUCT_ID'], $quantity, $feature, $defaultPrice, $defaultPromoPrice, (isset($img[1]) && $img[1] != '') ? $img[1] : '', $productParent[0]['PRODUCT_NAME'],$productParent[0]['URL']);
            $arrayResult['total_item'] = $objCart->get_total_item();
            $arrayResult['total_order'] = number_format($objCart->get_order_total()) . ' VNĐ';
            $json = json_encode($arrayResult);
            echo($json);
        } else {
            $arrayResult['error'] = 1;
        }
    }
}
if ($action == "emtyCart") {
    unset($_SESSION['shopping_cart_online']);
    $arrayResult['total_item'] = 0;
    $arrayResult['total_order'] = '0 VNĐ';
    $json = json_encode($arrayResult);
    echo($json);
}
if ($action == "del") {
    $objCart->remove_product($idProduct);
    $arrayResult['total_item'] = $objCart->get_total_item();
    $arrayResult['total_order'] = number_format($objCart->get_order_total()).' VNĐ';
	if($objCart->get_total_item()==0)
		 unset($_SESSION['shopping_cart_online']);
    $json = json_encode($arrayResult);
    echo($json);
}
if ($action == "update") {
    $objCart->updateCart($idProduct,$quantity);
    $arrayResult['total_item'] = $objCart->get_total_item();
    $arrayResult['total_order'] = number_format($objCart->get_order_total()).' VNĐ';
    $json = json_encode($arrayResult);
    echo($json);
}
