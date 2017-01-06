<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/category.php");
$objCat = new category();
$data = array();
if(!empty($_POST)){
	$txtCategoryName =$_POST['txtCategoryName'];
	$txtCategoryUrl =$_POST['txtCategoryUrl'];
	$txtCategoryLevel =$_POST['txtCategoryLevel'];
	$txtCategoryOrdering =$_POST['txtCategoryOrdering'];
	$drpCategory =$_POST['drpCategory'];
	$txtController =$_POST['txtController'];
	$chkActive =isset($_POST['chkActive'])?1:0;
	$objCat->addAction($txtCategoryName,$txtCategoryUrl,$txtCategoryOrdering,$chkActive,$drpCategory,$txtCategoryLevel,$txtController);
	$listMenu1 = $objCat->Menu(CATEGORY_HOME_ID,-1,null,"----");
	if (count($listMenu1) > 0) {
		foreach ($listMenu1 as $k => $v) {
			 $stack = array("label" => $v['NAME'], "value" => $v['MENU_ID']);
			array_push($data, $stack);
		}
	}
}
$json = json_encode($data);
echo($json);
?>

