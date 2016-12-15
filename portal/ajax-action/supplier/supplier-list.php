<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/supplier.php");
$objsupplier = new supplier();
$array = array();
$list = $objsupplier->getListsupplier();
if (count($list) > 0) {
        foreach ($list as $k => $v) {
            $stack = array("label" => $v['SUPPLIER_NAME'], "value" => $v['SUPPLIER_ID']);
            array_push($array, $stack);
        }
    }
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);
?>