<?php
include_once("../../../../configs/application.php");
include_once("../../../../connections/class.db.php");
function contains($haystack,$needle)
{
		return strpos($haystack, $needle) !== false;
}
function checkImage($image,$id){
		$db=new database();
		$sql = "SELECT * FROM PRODUCT WHERE PRODUCT_PARENT_ID='$id'";
		$resultImageCheck = $db->getData($sql);
		foreach($resultImageCheck as $k=>$value){
			if(contains($value['MEDIUM_IMAGE_URL'],$image))
				return true;
		}
		return false;
}
$image=$_GET['imageCheck'];
$id=$_GET['idProduct'];
if(checkImage($image,$id))
	echo '1';
else
	echo '0';
?>