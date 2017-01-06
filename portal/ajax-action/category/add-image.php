<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/category.php");
include_once("../../model/ResizeImageClass.php");
$objCat = new category();
$data = array();
if(!empty($_POST)){
	$idCate=$_POST['caterory_idi'];
	$txtW =$_POST['txtW'];
	$txtH =$_POST['txtH'];
	$imageOld=$objCat->getCategoryById($idCate);
	$imageName =$_FILES['image']['name'];
	$img = strip_tags($_FILES['image']['tmp_name']);
	if($imageOld[0]['IMAGE']!=''){
		if (file_exists('../../../public/category/' . $imageOld[0]['IMAGE'])) {
			unlink('../../../public/category/' . $imageOld[0]['IMAGE']);
		}
	}
	$resize = new System_ResizeImageClass($img);
	$resize->resizeTo($txtW, $txtH, 'exact');
	$resize->saveImage('../../../public/category/' . $imageName, 100);
	$objCat->addImage($imageName,$idCate);
	$listMenu1 = $objCat->Menu(CATEGORY_HOME_ID,-1,null,"----");
	if (count($listMenu1) > 0) {
		foreach ($listMenu1 as $k => $v) {
				if($idCate!=$v['MENU_ID']){
					$stack = array("label" => $v['NAME'], "value" => $v['MENU_ID']);
					array_push($data, $stack);
				}
		}
	}
}
$json = json_encode($data);
echo($json);
?>

