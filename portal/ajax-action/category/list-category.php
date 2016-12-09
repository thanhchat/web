<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/category.php");
$objCat = new category();
$listMenu1 = $objCat->Menu(2,-1,null,"----");
$data = array();
if (count($listMenu1) > 0) {
    foreach ($listMenu1 as $k => $v) {
        $stack = array("label" => $v['NAME'], "value" => $v['MENU_ID']);
        array_push($data, $stack);
    }
}
$json = json_encode($data);
echo($json);
?>

