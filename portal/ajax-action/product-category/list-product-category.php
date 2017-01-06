<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product-category.php");
$objProductCategory=new productcategory();
$idCategory=$_GET['idCategory'];
$list_product_category=$objProductCategory->getListProductCategoryByIdCategory($idCategory);
$array = array();
if (count($list_product_category) > 0) {
    foreach ($list_product_category as $k => $v) {
        $ac='?n';
        if($v['ACTIVE']==1)
            $ac='Hi?n th?';
        $image="";
        if($v['SMALL_IMAGE_URL']!="" ||$v['SMALL_IMAGE_URL']!=null){
            $arr_tmp_image=explode('@@@',$v['SMALL_IMAGE_URL']);
            $image=$arr_tmp_image[1];
        }
        $stack = array("PRODUCT_ID" => $v['PRODUCT_ID'],"DEFAULT_SEQUENCE_NUM"=>$v['DEFAULT_SEQUENCE_NUM'], "MANUFACTURER_PARTY_ID" => stripslashes($v['MANUFACTURER_PARTY_ID']),"PRODUCT_NAME"=>stripslashes($v['PRODUCT_NAME']),"SMALL_IMAGE_URL"=>$image,"ACTIVE"=>$ac);
        array_push($array, $stack);
    }
}
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);