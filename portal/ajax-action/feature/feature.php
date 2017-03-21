<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$array = array();
$id=$_GET['id'];
$listFeature = $objFeature->getListFeatureByFeatureType($id);
    if (count($listFeature) > 0) {
        foreach ($listFeature as $k => $v) {
            $ac = 'Ẩn';
            if ($v['ACTIVE'] == 1)
                $ac = 'Hiển thị';
            $stack = array("PRODUCT_FEATURE_ID" => $v['PRODUCT_FEATURE_ID'], "DESCRIPTION_FEATURE" => $v['DESCRIPTION_FEATURE'], "DEFAULT_SEQUENCE_NUM" => $v['DEFAULT_SEQUENCE_NUM'], "COMMENT" => $v['COMMENT'], "ACTIVE" => $ac);
            array_push($array, $stack);
        }
    }
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);
?>