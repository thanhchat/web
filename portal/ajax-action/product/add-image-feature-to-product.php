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
$img='';
$productOld=$objProduct->loadProductJuniorByIdAndFeature($idProduct,$feature);
if(null!=$productOld){
	foreach($productOld as $k=>$v){
		$img=$v['MEDIUM_IMAGE_URL'];
		if(!contains($img,$image)&&checkImage($image)){
			if($v['MEDIUM_IMAGE_URL']!=null&&$v['MEDIUM_IMAGE_URL']!='')
				$img.="@@@".$image;
			else
				$img="@@@".$image;
			$objProduct->updateImageProduct($img,$v['PRODUCT_ID']);
		}else{
			$array['error']=1;
			break;
		}
	}
}
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