<?php
include_once("mvc/model/category.php");
$objCategory = new category();
$array=array();
$arrayMenu=$objCategory->getAllListCategory(CATEGORY_PRODUCT_ID,$array);
//var_dump($arrayMenu);
$category=$objCategory->getcategory(CATEGORY_PRODUCT_ID,$arrayMenu,LINKS1);
if(LINKS2!=""){
	$title='Chi tiết sản phẩm';
	$cssProductDetail=1;
	$jsProductDetail=1;
	$view = 'mvc/view/product/detail.phtml';
}else{
	$title='Sản phẩm';
	$cssProduct=1;
	$jsProduct=1;
	$view = 'mvc/view/product/index.phtml';
}