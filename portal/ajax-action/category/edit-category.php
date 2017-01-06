<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/category.php");
$objCat = new category();
$data = array();
if(!empty($_POST)){
	$idCate=$_POST['caterory_id'];
	$txtCategoryName =$_POST['txtCategoryNameEdit'];
	$txtCategoryUrl =$_POST['txtCategoryUrlEdit'];
	$txtCategoryLevel =$_POST['txtCategoryLevelEdit'];
	$txtCategoryOrdering =$_POST['txtCategoryOrderingEdit'];
	$drpCategory =$_POST['drpCategoryEdit'];
	$chkActive =isset($_POST['chkActiveEdit'])?1:0;
	$txtController =$_POST['txtControllerEdit'];
	$objCat->editAction($idCate,$txtCategoryName,$txtCategoryUrl,$txtCategoryOrdering,$chkActive,$drpCategory,$txtCategoryLevel,$txtController);
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

