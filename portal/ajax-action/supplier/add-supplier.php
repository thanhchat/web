<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/supplier.php");
$objSupplier = new supplier();
$array = array();
        $txtSupplierName =$_POST['txtSupplierName'];
        $txtSupplierPhone =$_POST['txtSupplierPhone'];
        $txtSupplierEmail =$_POST['txtSupplierEmail'];
        $txtSupplierAddress =$_POST['txtSupplierAddress'];
        $txtSupplierComment =$_POST['txtSupplierComment'];  
        $objSupplier->addsupplier($txtSupplierName,$txtSupplierPhone,$txtSupplierEmail,$txtSupplierAddress,$txtSupplierComment);
		//$listFeature = $objSupplier->getListFeatureByFeatureType($featureTypeId);
    $json = json_encode($array);
    echo($json);
?>