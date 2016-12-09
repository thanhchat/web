<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$listFeatureType=$objFeature->getListFeatureType();
$array=array();
$str=' <p-multiselectlistbox caption="Danh sách loại tính năng" name="product-feature-all">';
foreach($listFeatureType as $k=>$v){
    $listFeature=$objFeature->getListFeatureByFeatureType($v['PRODUCT_FEATURE_TYPE_ID']);
    if(count($listFeature)>0)
        $str.=' <optgroup label="'.$v['DESCRIPTION_FEATURE_TYPE'].'" title="'.$v['DESCRIPTION_FEATURE_TYPE'].'">';
    foreach($listFeature as $k=>$v1){
        $str.='<option value="'.$v['PRODUCT_FEATURE_TYPE_ID'].'@'.$v1['PRODUCT_FEATURE_ID'].'">'.$v1['DESCRIPTION_FEATURE'].'</option>';

    }
    if(count($listFeature)>0)
        $str.=' </optgroup>';

}
echo($str);
?>