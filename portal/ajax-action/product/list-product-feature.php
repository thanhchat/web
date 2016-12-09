<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$objProduct = new product();
$listProduct=$objProduct->getProductJuniorById($_GET['idProduct']);
$array = array();
if (count($listProduct) > 0) {
	$stack = array("label" =>' -- Chọn tính năng --', "value" =>  -1);
    array_push($array, $stack);
    foreach ($listProduct as $k => $v) {
		$feature='';
		if(null!=$v['FEATURE_ID'] &&$v['FEATURE_ID']!=''){
			$arrayFeatureType=explode('@',$v['FEATURE_TYPE_ID']);
			$arrayFeature=explode('@',$v['FEATURE_ID']);
			foreach ($arrayFeatureType as $key => $value) {
				$FeatureTypeName=$objFeature->getFeatureTypeById($value);
				$feature.=$FeatureTypeName[0]['DESCRIPTION_FEATURE_TYPE'].' : ';
				$featureName=$objFeature->getFeatureByArrayId(explode(':',$arrayFeature[$key]));
				foreach ($featureName as $keyF => $valueF) {
					$feature.=$valueF['DESCRIPTION_FEATURE'].'  | ';
				}
			}
		}
		$feature=rtrim($feature, "  | ");
		//$feature.=' (Mã sản phẩm : '.$v['PRODUCT_ID'].')';
        $stack = array("label" =>$feature, "value" =>  $v['PRODUCT_ID']);
        array_push($array, $stack);
    }
}else{
	$stack = array("label" =>' -- Không có tính năng --', "value" =>  -1);
    array_push($array, $stack);
}
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);
?>