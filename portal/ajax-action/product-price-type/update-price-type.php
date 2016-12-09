<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/price-type.php");
$objPrice = new Price();
$id=$_GET['id'];
$array = array();
$check=3;
$array['mess'] = $check;
if(isset($_GET['action'])){
	$check=$objPrice->updatePriceTypeAction($id);
		if($check==0)
			$array['mess']='4';
}else{
	$field=$_GET['field'];
	$val=$_GET['val'];
	if($field=='PRODUCT_PRICE_TYPE_ID'){
		$check=$objPrice->checkPriceById($val);
		if($check>0){
			$array['mess']='1';
		}else{
			$check=$objPrice->updatePriceType($field,$val,$id);
			if($check==0)
				$array['mess']='2';
		}
	}else{
		$check=$objPrice->updatePriceType($field,$val,$id);
			if($check==0)
				$array['mess']='2';
	}
}
$json = json_encode($array);
echo($json);
?>