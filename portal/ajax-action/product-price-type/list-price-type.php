<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/price-type.php");
$objPrice = new Price();
$array = array();
    $listPriceType = $objPrice->getListPriceType();
    if (count($listPriceType) > 0) {
        foreach ($listPriceType as $k => $v) {
            $stack = array("label" => $v['DESCRIPTION_PRICE_TYPE'], "value" => $v['PRODUCT_PRICE_TYPE_ID']);
            array_push($array, $stack);
        }
    }
    $json = json_encode($array);
    echo($json);
?>