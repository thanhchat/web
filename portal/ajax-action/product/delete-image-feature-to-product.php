<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
function contains($haystack,$needle)
{
    return strpos($haystack, $needle) !== false;
}
function checkImage($image)
{
    $valid_formats = array("jpg", "JPG", "png", "PNG", "gif", "GIF", "jpeg", "JPEG", "bmp", "BMP");
    if (!in_array(pathinfo($image, PATHINFO_EXTENSION), $valid_formats))
        return FALSE;
    else
        return TRUE;
}
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
$objProduct = new product();
$idProduct=$_GET['idProduct'];
$image=$_GET['image'];
$feature=$_GET['feature'];
$array=array();
$imgNew='';
$img='';
$productOld=$objProduct->loadProductJuniorByIdAndFeature($idProduct,$feature);
if(null!=$productOld){
	foreach($productOld as $k=>$v){
		$img=$v['MEDIUM_IMAGE_URL'];
		if(contains($img,$image)&&checkImage($image)){
			if($v['MEDIUM_IMAGE_URL']!=null&&$v['MEDIUM_IMAGE_URL']!='')
				$imgNew=str_replace( '@@@'.$image, '',$v['MEDIUM_IMAGE_URL']);
			$objProduct->updateImageProduct($imgNew,$v['PRODUCT_ID']);
			$img=$imgNew;
		}
		//else{
			//$array['error']=1;
			//break;
		//}
	}
}
$productOld=$objProduct->loadProductJuniorByIdAndFeature($idProduct,$feature);
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