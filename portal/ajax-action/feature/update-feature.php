<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$id=$_GET['id'];
$array = array();
$check=3;
if(isset($_GET['action'])){
	$check=$objFeature->updateFeatureAction($id);
		if($check==0)
			$array['mess']='4';
		else{
		$listFeature = $objFeature->getListFeatureByFeatureType($_GET['typeId']);
		if (count($listFeature) > 0) {
			foreach ($listFeature as $k => $v) {
				$ac = 'Ẩn';
				if ($v['ACTIVE'] == 1)
					$ac = 'Hiển thị';
				$stack = array("PRODUCT_FEATURE_ID" => $v['PRODUCT_FEATURE_ID'], "DESCRIPTION_FEATURE" => $v['DESCRIPTION_FEATURE'], "DEFAULT_SEQUENCE_NUM" => $v['DEFAULT_SEQUENCE_NUM'], "ACTIVE" => $ac);
				array_push($array, $stack);
			}
		}
		}
}else{
	$field=$_GET['field'];
	$val=mysql_real_escape_string($_GET['val']);
		$check=$objFeature->updateFeature($field,$val,$id);
			if($check==0)
				$array['mess']='2';
}

$json = json_encode($array);
echo($json);
?>