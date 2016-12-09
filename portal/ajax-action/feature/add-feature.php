<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$array = array();
        $featureTypeId =$_POST['txtFeatureTypeId'];
        $featureDes =$_POST['txtFeatureDes'];
        $ordering =isset($_POST['txtFeatureOrdering'])?$_POST['txtFeatureOrdering']:0;
        $active = isset($_POST['txtFeatureActive'])?1:0;
        $objFeature->addFeature($featureTypeId,$featureDes,$ordering,$active);
		$listFeature = $objFeature->getListFeatureByFeatureType($featureTypeId);
		if (count($listFeature) > 0) {
			foreach ($listFeature as $k => $v) {
				$ac = 'Ẩn';
				if ($v['ACTIVE'] == 1)
					$ac = 'Hiển thị';
				$stack = array("PRODUCT_FEATURE_ID" => $v['PRODUCT_FEATURE_ID'], "DESCRIPTION_FEATURE" => $v['DESCRIPTION_FEATURE'], "DEFAULT_SEQUENCE_NUM" => $v['DEFAULT_SEQUENCE_NUM'], "ACTIVE" => $ac);
				array_push($array, $stack);
			}
		}
    $json = json_encode($array);
    echo($json);

?>