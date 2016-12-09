<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$id=$_GET['id'];
$array = array();
$check=3;
$array['mess'] = $check;
if(isset($_GET['action'])){
	$check=$objFeature->updateFeatureTypeAction($id);
		if($check==0)
			$array['mess']='4';
}else{
	$field=$_GET['field'];
	$val=$_GET['val'];
	if($field=='PRODUCT_FEATURE_TYPE_ID'){
		$check=$objFeature->checkFeatureById($val);
		if($check>0){
			$array['mess']='1';
		}else{
			$check=$objFeature->updateFeatureType($field,$val,$id);
			if($check==0)
				$array['mess']='2';
		}
	}else{
		$check=$objFeature->updateFeatureType($field,$val,$id);
			if($check==0)
				$array['mess']='2';
	}
}
$json = json_encode($array);
echo($json);
?>