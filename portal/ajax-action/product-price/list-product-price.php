<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product-price.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$objProductPrice=new productprice();
$array=array();
$idProduct=$_GET['idProduct'];
$listPrice=$objProductPrice->getListProductPriceByIdProduct($idProduct);
if (count($listPrice) > 0) {
        foreach ($listPrice as $k => $v) {
			$term_uom='Mặc định';
			if($v['TERM_UOM_ID']!=-1){
				$feature=$objFeature->getFeatureId($v['TERM_UOM_ID']);
				$term_uom=$feature[0]['DESCRIPTION_FEATURE'];
			}
            $stack = array("PRODUCT_PRICE_ID" => $v['PRODUCT_PRICE_ID'],"PRODUCT_PRICE_TYPE_ID" => $v['PRODUCT_PRICE_TYPE_ID'], "DESCRIPTION_PRICE_TYPE" => $v['DESCRIPTION_PRICE_TYPE'], "TERM_UOM_ID" => $v['TERM_UOM_ID'], "TERM_UOM_NAME" => $term_uom, "CURRENCY_UOM_ID" => $v['CURRENCY_UOM_ID'], "PRICE" => number_format($v['PRICE']), "FROM_DATE" => date("d-m-Y H:i", strtotime($v['FROM_DATE'])));
            array_push($array, $stack);
        }
    }
$json = json_encode($array);
echo($json);
?>