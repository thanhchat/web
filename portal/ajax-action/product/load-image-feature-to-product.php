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
$feature=$_GET['feature'];
$array=array();
$productOld=$objProduct->loadProductJuniorByIdAndFeature($idProduct,$feature);
if(null!=$productOld){
	foreach($productOld as $k1=>$value1){
		$img=$value1['MEDIUM_IMAGE_URL'];
		$imageNew = explode('@@@', $img);
		if(count($imageNew)>0)
		  unset($imageNew[0]);
		foreach($imageNew as $k=>$value){
			$lag=0;
			foreach($array as $k=>$valueImg){
				if($valueImg['imageName']==$value){
					$lag=1;
				}
			}
			if($lag==0){
				$stack = array("imageName" =>$value, "idProduct" =>  $idProduct);
				array_push($array, $stack);
			}
		}
	}
}
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);
?>