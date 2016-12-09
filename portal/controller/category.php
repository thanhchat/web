<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 04/01/2015
 * Time: 11:13 AM 00
 */
$DATA["TITLE"] = "Quản lý danh mục";
include_once("../functions/function.php");
switch (LINKS4) {
    case "add":
        include_once("model/category.php");
        $objCat = new category();
        if (!empty($_POST)) {
            $catName = trim($_POST['catName']);
            $url = isset($_POST['url']) ? $_POST['url'] : "";
            $controller = isset($_POST['controller']) ? $_POST['controller'] : "";
            $ordering = (isset($_POST['ordering']) && $_POST['ordering'] >= 0 && $_POST['ordering'] != "") ? $_POST['ordering'] : 0;
            $active = (isset($_POST['enabled'])) ? "1" : "0";
            $catSelect = isset($_POST['catSelect']) ? $_POST['catSelect'] : 0;
            $level = (isset($_POST['level']) && $_POST['level'] >= 0 && $_POST['level'] != "") ? $_POST['level'] : 0;
            if (!empty($catName)) {
                $check = $objCat->addAction($catName, $url, $controller, $ordering, $active, $catSelect, $level);
                if ($check) {
                    $success = "Thêm danh mục thành công";
                    //$cache->delete("listMenu");
                    $catName = "";
                    $url = "";
                    $controller = "";
                } else
                    $error = "Có lỗi xảy ra trong quá trình thêm danh mục";
            } else {
                $error = "Tên danh mục không được để trống";
            }
        }
        $listMenu = $objCat->getListCategory();

        $listMenu1 = $objCat->Menu(0);
        $selectCat = "<select id='catSelect' name='catSelect'><option value='0'>-- Danh mục gốc--</option> ";
        foreach ($listMenu1 as $key => $value) {
            $selectCat .= "<option value=" . $value['MENU_ID'] . ">" . $value['NAME'] . "</option>";
        }
        $selectCat .= "</select>";
        $dataPaginator = $listMenu;
        $view = "view/category/index.phtml";
        $objCat = null;
        break;
    case "delete":
        include_once("model/category.php");
        $objCat = new category();
        $id = LINKS5;
        $check = $objCat->deleteAction($id);
        if ($check) {
            $success = "Xóa danh mục thành công";
        } else
            $error = "Có lỗi xảy ra trong quá trình xóa danh mục";

        $listMenu = $objCat->getListCategory();

        $listMenu1 = $objCat->Menu(0);
        $selectCat = "<select id='catSelect' name='catSelect'><option value='0'>-- Danh mục gốc--</option> ";
        foreach ($listMenu1 as $key => $value) {
            $selectCat .= "<option value=" . $value['MENU_ID'] . ">" . $value['NAME'] . "</option>";
        }
        $action = "?/category/add";
        $selectCat .= "</select>";
        $dataPaginator = $listMenu;
        $view = "view/category/index.phtml";
        $objCat = null;
        break;
    case "edit":
        include_once("model/category.php");
        $objCat = new category();
        $id = LINKS5;
        if ($id != "" && is_numeric($id) && $id > 0) {
            $idCat = $id;
            // echo $idCat;
            if (!empty($_POST)) {
                // var_dump($_POST);
                $catName = $_POST['catName'];
                $url = $_POST['url'];
                $controller = $_POST['controller'];
                $ordering = $_POST['ordering'];
                $active = (isset($_POST['enabled'])) ? "1" : "0";
                $catSelect = $_POST['catSelect'];
                $level = $_POST['level'];
                $check = $objCat->editAction($idCat, $catName, $url, $controller, $ordering, $active, $catSelect, $level);
                if ($check) {
                    $success = "Cập nhật thông tin thành công";
                    $catName = "";
                    $url = "";
                    $controller = "";
                    $ordering = "";
                } else
                    $error = "Có lỗi xảy ra trong quá trình cập nhật";
            }
        }
        $action = "?/category/add";
        $listMenu = $objCat->getListCategory();
        $listMenu1 = $objCat->Menu(0);
        $selectCat = "<select id='catSelect' name='catSelect'><option value='0'>-- Danh mục gốc--</option> ";
        foreach ($listMenu1 as $key => $value) {
            $selectCat .= "<option value=" . $value['MENU_ID'] . ">" . $value['NAME'] . "</option>";
        }
        $selectCat .= "</select>";
        $dataPaginator = $objCat->getListCategory();
        $view = "view/category/index.phtml";
        $objCat = null;
        break;
    default:
        $action = "?/category/add";
        include_once("model/category.php");
        $objCat = new category();
        $listMenu = $objCat->getListCategory();
        $objCat = null;
        include_once("model/category.php");
        $objCat = new category();
        $listMenu1 = $objCat->Menu(0);
        $objCat = null;
        $selectCat = "<select id='catSelect' name='catSelect'><option value='0'>-- Danh mục gốc--</option> ";
        foreach ($listMenu1 as $key => $value) {
            $selectCat .= "<option value=" . $value['MENU_ID'] . ">" . $value['NAME'] . "</option>";
        }
        $selectCat .= "</select>";
        $dataPaginator = $listMenu;
        $view = "view/category/index.phtml";
        break;
}