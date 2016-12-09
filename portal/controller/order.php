<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 03/08/2015
 * Time: 13:21 PM 54
 */
$DATA["TITLE"] = "Chi tiết đơn hàng";
include_once("../configs/application.php");
include_once("../functions/function.php");
include_once("../connections/class.db.php");
$db = new database();
include_once("../models/product.php");
$objProduct = new Product();
switch (LINKS4) {
    case "changeStatus":
        $id = LINKS5;
        $arrvalue=explode("@@",$id);
        include_once("model/order.php");
        $objOrder = new order();
        $objOrder->updateStatus($arrvalue[1],$arrvalue[0]);
        header("location:?/order/");
        break;
    case "detail":
        $id = LINKS5;
        $title_or="CHI TIẾT ĐƠN HÀNG : ".$id;
        include_once("model/order.php");
        $objOrder = new order();
        $arrayData = $objOrder->getOrderDetail($id);
        $dataPaginator = $arrayData;
        $view = "view/order/order_detail.phtml";
        break;
    case "delete":
        $id = LINKS5;
        include_once("model/order.php");
        $objOrder = new order();
        $objOrder->deleteOrder($id);
        $success = "Xóa đơn hàng thành công";
        header("location:?/order/");
        break;
    default:
        $page = LINKS4;
        $page = ($page > 0 && $page != "") ? $page : 1;
        include_once("model/order.php");
        $objOrder = new order();
        $cacheSum = $objOrder->getAllOrder();
        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
        $arrayData = $objOrder->getListOrderLimit($start, PAGEMAX);
        $dataPaginator = $arrayData;
        $view = "view/order/index.phtml";
        break;
}