<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 31/10/2015
 * Time: 21:58 PM 07
 */
$DATA["TITLE"] = "Quản lý tính năng";
include_once("../functions/function.php");
include_once("model/feature.php");
$objFeatureType = new feature();
switch (LINKS4) {
    case "add":
       if(LINKS6!=""){
           $idFeatureType=LINKS6;
           $description = $_POST['feature_name'];
           $ordering = $_POST['feature_order'];
           $objFeatureType->addFeature($description,$ordering,1,$idFeatureType);
           header('location:?/feature/select/feature_type/'.$idFeatureType);

       }else{
           $error="Vui lòng chọn loại tính năng";
           $listFeatureType=$objFeatureType->getListFeatureType();
           $view = "view/feature/index.phtml";
       }
        break;
    case "update":
        $idFeature=LINKS6;
        $idFeatureType=LINKS5;
        if (!empty($_POST)) {
            $description = $_POST['feature_name'];
            $ordering = $_POST['feature_order'];
            $objFeatureType->updateFeature($description,$ordering,$idFeature);
        }
        header('location:?/feature/select/feature/'.$idFeatureType);
        break;
    case "active":
        $idFeature=LINKS6;
        $idFeatureType=LINKS5;
        $objFeatureType->updateActiveFeature($idFeature);
        header('location:?/feature/select/feature/'.$idFeatureType);
        break;
    default:
        $listFeatureType=$objFeatureType->getListFeatureType();
        if(LINKS6!=""){
            $idFeatureType=LINKS6;
            $listFeature=$objFeatureType->getFeatureByIdType($idFeatureType);
        }
        $view = "view/feature/index.phtml";
        break;
}