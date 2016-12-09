<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/price-type.php");
$objPrice = new Price();
$array = array();
if(!empty($_POST)){
    $action=$_POST['actionadd'];
    if($action=='add'){
        $priceTypeId =$_POST['txtPriceTypeId'];
        $priceTypeDes =$_POST['txtPriceTypeDes'];
        $check=$objPrice->checkPriceById($priceTypeId);
        //echo $featureTypeDes;
        $array = array();
        $array['mess'] = '';
        if($check>0){
            $array['mess']='1';
        }else{
            $objPrice->addPriceType($priceTypeId,$priceTypeDes);
        }
    }
    if($action=='edit'){

    }
    $json = json_encode($array);
    echo($json);
}else {
    $listPriceType = $objPrice->getListPriceType();
    if (count($listPriceType) > 0) {
        foreach ($listPriceType as $k => $v) {
            $stack = array("PRODUCT_PRICE_TYPE_ID" => $v['PRODUCT_PRICE_TYPE_ID'], "DESCRIPTION_PRICE_TYPE" => $v['DESCRIPTION_PRICE_TYPE']);
            array_push($array, $stack);
        }
    }
    $json = json_encode($array);
    echo($json);
}

?>