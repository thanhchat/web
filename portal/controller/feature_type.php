<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 31/10/2015
 * Time: 21:58 PM 07
 */
$DATA["TITLE"] = "Quản lý loại tính năng";
include_once("../functions/function.php");
include_once("model/feature.php");
$objFeatureType = new feature();
switch (LINKS4) {
    case "add":
        if (!empty($_POST)) {
            $description = $_POST['feature_name'];
            $ordering = $_POST['feature_order'];
            if (trim($description) != "") {
                $objFeatureType->addFeature_Type($description, $ordering, 1);
                $success = "Thêm loại tính năng thành công";
            } else {
                $error = "Tên loại tính năng không được để trống";
            }
        }
        header("location:?/feature_type");
        break;
    case "delete":

        break;
    case "update":
        if (!empty($_POST)) {
            $id = LINKS5;
            $description = $_POST['feature_name'];
            $ordering = $_POST['feature_order'];
            $objFeatureType->update($description, $ordering, $id);
        }
        header("location:?/feature_type");
        break;
    case "active":
        $id = LINKS5;
        $objFeatureType->updateActive($id);
        header("location:?/feature_type");
        break;
    default:
        $page = LINKS4;
        $page = ($page > 0 && $page != "") ? $page : 1;
        $cacheSum = $objFeatureType->getAllFeature_Type();
        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
        $arrayData = $objFeatureType->getListFeature_TypeLimit($start, PAGEMAX);
        $dataPaginator = $arrayData;
        $view = "view/feature_type/index.phtml";
        break;
}