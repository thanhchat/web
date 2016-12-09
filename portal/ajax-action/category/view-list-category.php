<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
function getNameCategoryById($id,$lisCategory){
	if($id==0) return "Danh mục gốc";
	foreach ($lisCategory as $k => $v) {
		if($v['MENU_ID']==$id)
			return $v['NAME'];
	}
	return "";
}
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/category.php");
$objCat = new category();
$data = array();
if(isset($_GET['listCateAdd'])){
	$cate=$_GET['listCateAdd'];
	$data = array();
	$listMenu1 = $objCat->Menu(0,-1,null,"----");
	if (count($listMenu1) > 0) {
		foreach ($listMenu1 as $k => $v) {
			if($cate==0){
				$stack = array("label" => $v['NAME'], "value" => $v['MENU_ID']);
				array_push($data, $stack);
			}else{
				if($cate!=$v['MENU_ID']){
					$stack = array("label" => $v['NAME'], "value" => $v['MENU_ID']);
					array_push($data, $stack);
				}
			}
		}
	}
	$json = json_encode($data);
	echo($json);
}else{
	$listMenu1 = $objCat->Menu(0,-1,null,"----");
	$data1 = array();
	if (count($listMenu1) > 0) {
		foreach ($listMenu1 as $k => $v) {
			$ac="Ẩn";
			if($v['ENABLED']==1)
				$ac="Hiển thị";
			$stack = array("MENU_ID" => $v['MENU_ID'], "NAME" => $v['NAME'], "PARENTS" => getNameCategoryById($v['PARENTS'],$listMenu1)." -- ".$v['PARENTS'],"LEVEL" => $v['LEVEL'], "ORDERING" => $v['ORDERING'], "ENABLED" => $v['ENABLED'], "URL" => $v['URL']);
			array_push($data1, $stack);
		}
	}
	$json = json_encode($data1);
	echo($json);
}
if(isset($_GET['active']))
  $objCat->updateActive($_GET['menuId']);
if(!empty($_POST)){
	$txtCategoryName =$_POST['txtCategoryName'];
	$txtCategoryUrl =$_POST['txtCategoryUrl'];
	$txtCategoryLevel =$_POST['txtCategoryLevel'];
	$txtCategoryOrdering =$_POST['txtCategoryOrdering'];
	$drpCategory =$_POST['drpCategory'];
	$chkActive =isset($_POST['chkActive'])?1:0;
	$objCat->addAction($txtCategoryName,$txtCategoryUrl,$txtCategoryOrdering,$chkActive,$drpCategory,$txtCategoryLevel);
	$listMenu1 = $objCat->Menu(0,-1,null,"----");
	$data2 = array();
	if (count($listMenu1) > 0) {
		foreach ($listMenu1 as $k => $v) {
			 $stack = array("label" => $v['NAME'], "value" => $v['MENU_ID']);
			array_push($data2, $stack);
		}
	}
	$json = json_encode($data2);
	echo($json);
}
?>

