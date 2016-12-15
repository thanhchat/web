<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/supplier.php");
$objSupplier = new supplier();
$id=$_GET['id'];
$array = array();
$check=3;
	$field=$_GET['field'];
	$val=$_GET['val'];
	$check=$objSupplier->updatesupplier($field,$val,$id);
	if($check==0)
		$array['mess']='2';
$json = json_encode($array);
echo($json);
?>