<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$objProduct = new product();
$txtProductId = isset($_POST['txtProductId']) ?$_POST['txtProductId']: null;
$txtProductName = isset($_POST['txtProductName']) ? $_POST['txtProductName']: null;
$txtProductKH = isset($_POST['txtProductKH']) ? $_POST['txtProductKH'] : null;
$drpCategory = isset($_POST['drpCategory']) ? $_POST['drpCategory']: null;
$drpActive = isset($_POST['drpActive']) ? $_POST['drpActive']: null;
$criteria = array("PRODUCT_ID" => trim($txtProductId), "PRODUCT_NAME" => trim($txtProductName),'txtProductKH'=>trim($txtProductKH),'drpCategory'=>$drpCategory,'drpActive'=>$drpActive);
$listProduct=$objProduct->getListProduct($criteria);
$array = array();
if (count($listProduct) > 0) {
    foreach ($listProduct as $k => $v) {
		$ac='Ẩn';
		if($v['IS_ACTIVE']=='Y')
			$ac='Hiển thị';
        $image="";
        if($v['SMALL_IMAGE_URL']!="" ||$v['SMALL_IMAGE_URL']!=null){
            $arr_tmp_image=explode('@@@',$v['SMALL_IMAGE_URL']);
            $image=$arr_tmp_image[1];
        }
		$feature='';
		if(null!=$v['FEATURE_ID'] &&$v['FEATURE_ID']!=''){
			$arrayFeatureType=explode('@',$v['FEATURE_TYPE_ID']);
			$arrayFeature=explode('@',$v['FEATURE_ID']);
			foreach ($arrayFeatureType as $key => $value) {
				$FeatureTypeName=$objFeature->getFeatureTypeById($value);
				$feature.=$FeatureTypeName[0]['DESCRIPTION_FEATURE_TYPE'].' : ';
				$featureName=$objFeature->getFeatureByArrayId(explode(':',$arrayFeature[$key]));
				foreach ($featureName as $keyF => $valueF) {
					$feature.=$valueF['DESCRIPTION_FEATURE'].', ';
				}
				$feature=rtrim($feature, ", ");
				$feature.='<br>';
			}
		}
        $stack = array("PRODUCT_ID" => $v['PRODUCT_ID'], "MANUFACTURER_PARTY_ID" => stripslashes($v['MANUFACTURER_PARTY_ID']),"PRODUCT_NAME"=>stripslashes($v['PRODUCT_NAME']),"PRODUCT_FEATURE"=>$feature,"SMALL_IMAGE_URL"=>$image,"IS_ACTIVE"=>$ac);
        array_push($array, $stack);
    }
}
$json = json_encode($array);
// $json = json_encode($result); // use on hostinger
echo($json);
?>