<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
function contains($haystack,$needle)
{
    return strpos($haystack, $needle) !== false;
}
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
$objProduct = new product();
$idProduct=$_GET['idProduct'];
$array=array();
$productOld=$objProduct->getProductById($idProduct);
if(null!=$productOld){
	$img=$productOld[0]['MEDIUM_IMAGE_URL'];
	$imageNew = explode('@@@', $img);
	if(count($imageNew)>0)
	  unset($imageNew[0]);
	foreach($imageNew as $k=>$value){
		$stack = array("imageName" =>$value, "idProduct" =>  $idProduct);
		array_push($array, $stack);
	}
}
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);
?>