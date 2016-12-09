<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$array = array();
    $listFeatureType = $objFeature->getListFeatureType();
    if (count($listFeatureType) > 0) {
        foreach ($listFeatureType as $k => $v) {
            $stack = array("label" => $v['DESCRIPTION_FEATURE_TYPE'], "value" => $v['PRODUCT_FEATURE_TYPE_ID']);
            array_push($array, $stack);
        }
    }
    $json = json_encode($array);
// $json = json_encode($result); // use on hostinger
    echo($json);
?>