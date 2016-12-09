<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 04/01/2015
 * Time: 11:13 AM 00
 */
$DATA["TITLE"] = "Quản lý liên kết hình ";
include_once("../functions/function.php");
function checkImage($image)
{
    $valid_formats = array("jpg", "JPG", "png", "PNG", "gif", "GIF", "jpeg", "JPEG", "bmp", "BMP");
    if (!in_array(pathinfo($image, PATHINFO_EXTENSION), $valid_formats))
        return FALSE;
    else
        return TRUE;
}
switch (LINKS4) {
    case "add":
        $DATA["TITLE"] = "Thêm liên kết hình";
        if (!empty($_POST)) {
            include_once("model/ResizeImageClass.php");
            include_once("model/box.php");
            $objBox=new box();
            $boxName = $_POST['box_name'];
            $urlName = $_POST['url_name'];
            $imageName = strip_tags($_FILES['image']['name']);
            $active = (isset($_POST['active'])) ? 1 : 0;
            $img = strip_tags($_FILES['image']['tmp_name']);
            if (!empty($boxName)&&!empty($urlName)) {
                if (checkImage($imageName)) {
                    $i = strrpos($imageName, ".");
                    $l = strlen($imageName) - $i;
                    $ext = substr($imageName, $i + 1, $l);
                    $imageName = create_captcha(7, PREFIX_IMG) . "." . $ext;
                    $resize = new System_ResizeImageClass($img);
                    if ($_FILES['image']['size'] <= FILE_MAX) {
                        if ($resize != "error") {
                            $resize->resizeTo(262, 320, 'exact');
                            $resize->saveImage('../public/box/' . $imageName, 70);
                            $objBox->addBox($boxName,$urlName,$imageName,$active);
                            $success = "Thêm liên kết hình thành công";
                            $boxName = "";
                            $urlName = "";
                        }else {
                            $error = "Upload bị lỗi hoặc file không đúng định dạng";
                        }
                    }else {
                        $error = "File hình chọn quá lớn";
                    }
                }else {
                    $error = "Hình không đúng định dạng";
                }
            }
        }
        $view = "view/box/add.phtml";
        break;
    case "delete":
        $idBox = LINKS5;
        include_once("model/box.php");
        $objBox = new box();
        $box = $objBox->getBoxById($idBox);
        if (!empty($box[0]['IMAGE'])) {
            if (file_exists('../public/box/' . $box[0]['IMAGE'])) {
                unlink('../public/box/' . $box[0]['IMAGE']);
            }
        }
        $objBox->deleteBox($idBox);
        $page = LINKS4;
        $page = ($page > 0 && $page != "") ? $page : 1;
        $cacheSum = $objBox->getAllBox();
        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
        $arrayData = $objBox->getListBoxLimit($start, PAGEMAX);
        $dataPaginator = $arrayData;
        $success = "Xóa liên kết với Mã: <span style='color: red;'>" . $idBox . "</span> thành công";
        $view = "view/box/index.phtml";
        break;
    case "active":
        $idBox = LINKS5;
        $page = LINKS6;
        $page = ($page > 0 && $page != "") ? $page : 1;
        include_once("model/box.php");
        $objBox = new box();
        $objBox->updateActive($idBox);
        header("location:?/box/" . $page);
        break;
    default:
        $page = LINKS4;
        $page = ($page > 0 && $page != "") ? $page : 1;
        include_once("model/box.php");
        $objBox=new box();
        $cacheSum = $objBox->getAllBox();
        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
        $arrayData = $objBox->getListBoxLimit($start, PAGEMAX);
        $dataPaginator = $arrayData;
        $view = "view/box/index.phtml";
        break;
}