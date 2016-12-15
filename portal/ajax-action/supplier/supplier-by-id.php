<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/supplier.php");
$objsupplier = new supplier();
$array = array();
$id=$_GET['id'];
$array = $objsupplier->getsupplierById($id);
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);
?>