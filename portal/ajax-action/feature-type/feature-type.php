<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/feature.php");
$objFeature = new feature();
$array = array();
if(!empty($_POST)){
    $action=$_POST['actionadd'];
    if($action=='add'){
        $featureTypeId =$_POST['txtFeatureTypeId'];
        $featureTypeDes =$_POST['txtFeatureTypeDes'];
        $ordering =isset($_POST['txtFeatureTypeOrdering'])?$_POST['txtFeatureTypeOrdering']:0;
        $active = isset($_POST['txtFeatureTypeActive'])?1:0;
        $check=$objFeature->checkFeatureById($featureTypeId);
        //echo $featureTypeDes;
        $array = array();
        $array['mess'] = '';
        if($check>0){
            $array['mess']='1';
        }else{
            $objFeature->addFeatureType($featureTypeId,$featureTypeDes,$ordering,$active);
        }
    }
    if($action=='edit'){

    }
    $json = json_encode($array);
    echo($json);
}else {
    $listFeatureType = $objFeature->getListFeatureType();
    if (count($listFeatureType) > 0) {
        foreach ($listFeatureType as $k => $v) {
            $ac = 'Ẩn';
            if ($v['ACTIVE'] == 1)
                $ac = 'Hiển thị';
            $stack = array("PRODUCT_FEATURE_TYPE_ID" => $v['PRODUCT_FEATURE_TYPE_ID'], "DESCRIPTION_FEATURE_TYPE" => $v['DESCRIPTION_FEATURE_TYPE'], "ODERING" => $v['ODERING'], "ACTIVE" => $ac);
            array_push($array, $stack);
        }
    }
    $json = json_encode($array);
// $json = json_encode($result); // use on hostinger
    echo($json);
}

?>