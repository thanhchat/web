<?php
session_start();
defined('WEB_ACTIVE') or die(include_once("mvc/view/error/systemstop.phtml"));
$REQUEST_URI = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url_array = explode('/', $REQUEST_URI);
array_shift($url_array);
$i = 0;
$index = 1;
define('LINKS1', isset($url_array[$i]) ? $url_array[$i] : "");
define('LINKS2', isset($url_array[$i + 1]) ? $url_array[$i + 1] : "");
define('LINKS3', isset($url_array[$i + 2]) ? $url_array[$i + 2] : "");
define('LINKS4', isset($url_array[$i + 3]) ? $url_array[$i + 3] : "");
define('LINKS5', isset($url_array[$i + 4]) ? $url_array[$i + 4] : "");
define('LINKS6', isset($url_array[$i + 5]) ? $url_array[$i + 5] : "");
define('LINKS7', isset($url_array[$i + 6]) ? $url_array[$i + 6] : "");
define('END',$url_array[count($url_array)-1]);
define('FIRSTEND',isset($url_array[count($url_array)-2])?$url_array[count($url_array)-2]:END);


$page = '';
$flag=0;
$cssProduct=0;
$jsProduct=0;
$cssProductDetail=0;
$jsProductDetail=0;
$cssHome=0;
$jsHome=0;
$jsCheckout=0;
include_once("configs/application.php");
include_once("connections/class.db.php");
include_once("mvc/model/category.php");
include_once("functions/function.php");

$objCategory = new category();
$arrayCategory=$objCategory->getListCategory();
$filterCategory=$objCategory->filterCategory();
$arrayMenuProduct=$objCategory->getListCategoryByLevel(CATEGORY_PRODUCT_ID,1);
//var_dump($arrayMenuProduct);
$finalArrayCategory=array_merge($arrayCategory,$arrayMenuProduct);
usort($finalArrayCategory, function($a, $b) {
    return $a['ORDERING'] - $b['ORDERING'];
});
$listItemMenu = $objCategory->listMenuItems($url_array,$finalArrayCategory,$index,"active");
$detail=END;
if(END!=''&&!is_numeric($detail)){
	foreach($filterCategory as $k=>$v){
		$arr=explode('/',$v['URL']);
		if("/".$arr[count($arr)-1]=='/'.FIRSTEND){
			$page=$v['CONTROLLER'];
			$flag=1;
		}
	}
}else{
	$page='home.php';
	$flag=1;
}
$control = "mvc/controller/" . $page;
if ($flag==0) {
    $control = "mvc/controller/info-system-mess.php";
}
include_once($control);
