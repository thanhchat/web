<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php 
function contains($haystack,$needle)
{
    return strpos($haystack, $needle) !== false;
}
?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$objProduct = new product();
$array = array();
$arrayFeature = array();
$array['listFeature']=array();
$array['listFeatureType']=array();
$idProduct=isset($_GET['productId'])?$_GET['productId']:0;
$productNew=$objProduct->getProductFeatureById($idProduct);
$featureTypeLoad=explode('@',$productNew[0]['FEATURE_TYPE_ID']);
$featureLoad=explode('@',$productNew[0]['FEATURE_ID']);
if(isset($_GET['listFeaturePrice'])){
	$stack=array('label'=>'Mặc định','value'=>'-1');
	array_push($arrayFeature,$stack);
	foreach($featureLoad as $k=>$v){
		if($v!=""){
			//$arrayFeatureTypeName=$objFeature->getFeatureTypeById($featureTypeLoad[$k]);
			//$stack=array('label'=>$arrayFeatureTypeName[0]['DESCRIPTION_FEATURE_TYPE'],'value'=>$arrayFeatureTypeName[0]['PRODUCT_FEATURE_TYPE_ID']);
			//array_push($arrayFeature,$stack);
			$arrayFeatureId=explode(':',$v);
			foreach($arrayFeatureId as $key=>$value){
				$arrayFeatureName=$objFeature->getFeatureId($value);
				$stack=array('label'=>$arrayFeatureName[0]['DESCRIPTION_FEATURE'],'value'=>$arrayFeatureName[0]['PRODUCT_FEATURE_ID']);
				array_push($arrayFeature,$stack);
			}
		}
	}
	$json = json_encode($arrayFeature);
	echo($json);
}else{
	foreach($featureTypeLoad as $k=>$v){
		$arrayFeatureTypeName=$objFeature->getFeatureTypeById($v);
		$stack=array('DESCRIPTION_FEATURE_TYPE'=>$arrayFeatureTypeName[0]['DESCRIPTION_FEATURE_TYPE'],'PRODUCT_FEATURE_TYPE_ID'=>$arrayFeatureTypeName[0]['PRODUCT_FEATURE_TYPE_ID']);
		array_push($array['listFeatureType'],$stack);
	}
	foreach($featureLoad as $k=>$v){
		$arrayFeatureId=explode(':',$v);
		$array['listFeature'][$k]=array();
		foreach($arrayFeatureId as $key=>$value){
			$arrayFeatureName=$objFeature->getFeatureId($value);
			$stack=array('PRODUCT_FEATURE_ID'=>$arrayFeatureName[0]['PRODUCT_FEATURE_ID'],'DESCRIPTION_FEATURE'=>$arrayFeatureName[0]['DESCRIPTION_FEATURE']);
			array_push($array['listFeature'][$k],$stack);
		}
	}
	$json = json_encode($array);
	echo($json);
}

?>