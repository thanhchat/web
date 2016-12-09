<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 05/01/2015
 * Time: 13:57 PM 15
 */
$DATA["TITLE"] = "Quản lý thông tin album";
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
    case "uploads":
        $DATA["TITLE"] = 'Upload hình ảnh';
        $idAlbum = LINKS5;
        $act = (LINKS6 != "") ? LINKS6 : "";
        $action = "?/album/uploads/$idAlbum";
        $id = $idAlbum;
        include_once("model/ResizeImageClass.php");
        include_once("model/album.php");
        include_once("model/tagAlbum.php");
        include_once("model/tagAlbumValue.php");
        include_once("model/category.php");
        include_once("model/imageAlbum.php");
        $objAlbum = new album();
        $objTags = new tagAlbum();
        $objTagsAlbumValue = new tagAlbumValue();
        $listAlbum = $objAlbum->getAllListAlbum();
        $objAlbumValue = new imageAlbum();
        $objImageValue = new imageAlbum();
        $messError = array();
        $messSucc = array();
        if (!empty($_POST) && $idAlbum > 0) {
            $idUser = $_SESSION['username'];
            if (isset($_FILES['file_uploads_with_title']) && !empty($_FILES["file_uploads_with_title"]['name'][0])) {
                $valueName = $_POST['listAlbumItem'];
                $nameFolder = explode('@@_', $valueName);
                $no_files = count($_FILES["file_uploads_with_title"]['name']);
                for ($i = 0; $i < $no_files; $i++) {
                    if ($_FILES["file_uploads_with_title"]["error"][$i] > 0) {
                        //$messError[] = "Lỗi : " . $_FILES["file_uploads_with_title"]["name"][$i] . "<br>";
                        continue;
                    } else {
                        if (checkImage($_FILES["file_uploads_with_title"]["name"][$i])) {
                            $img = strip_tags($_FILES["file_uploads_with_title"]["tmp_name"][$i]);
                            $imageName = $_FILES["file_uploads_with_title"]["name"][$i];
                            if ($_FILES['file_uploads_with_title']['size'][$i] <= FILE_MAX && !empty($imageName)) {
                                $k = strrpos($imageName, ".");
                                $l = strlen($imageName) - $k;
                                $ext = substr($imageName, $k + 1, $l);
                                $imageName = create_captcha(7, PREFIX_IMG) . "." . $ext;
                                $resize = new System_ResizeImageClass($img);
                                if ($resize != "error") {
                                    $resize->resizeTo(75, 75, 'exact');
                                    $resize->saveImage('../public/images/' . $nameFolder[0] . "/medium/" . $imageName,40);
                                    $resize->resizeTo(600, 502);
                                    $resize->saveImage('../public/images/' . $nameFolder[0] . "/original/" . $imageName,80);
                                    $title = $_POST['title' . ($i + 1)];
                                    $active = (isset($_POST['chk' . ($i + 1)])) ? 1 : 0;
                                    $data = array('ALBUM_ID' => $nameFolder[1], 'DESCRIPT' => $title, 'SMALL_IMAGE_URL' => $imageName, 'ORIGINAL_IMAGE_URL' => $imageName, 'IS_ACTIVE' => $active, 'CREATED_BY_USER' => $idUser);
                                    $objImageValue->addImage($data, 1);
                                    $messSucc[] = "Success : " . $_FILES["file_uploads_with_title"]["name"][$i] . "<br>";
                                } else {
                                    $messError[] = "Lỗi upoad file : " . $_FILES["file_uploads_with_title"]["name"][$i];
                                }
                            } else {
                                $messError[] = "File : " . $_FILES["file_uploads_with_title"]["name"][$i] . " quá lớn";
                            }
                        } else {
                            $messError[] = "File : " . $_FILES["file_uploads_with_title"]["name"][$i] . " không đúng định dạng.";
                        }
                    }
                    $_FILES["file_uploads_with_title"]["name"][$i] = "";
                }
            }
            if (isset($_FILES['file_uploads_not_title']) && !empty($_FILES["file_uploads_not_title"]['name'][0])) {
                $valueName = $_POST['listAlbumItem'];
                $nameFolder = explode('@@_', $valueName);
                foreach ($_FILES['file_uploads_not_title']['name'] as $f => $name) {
                    if ($_FILES["file_uploads_not_title"]["error"][$f] == 4) {
                        $messError[] = "Lỗi : " . $_FILES["file_uploads_not_title"]["name"][$f] . "<br>";
                    } else {
                        $img = strip_tags($_FILES["file_uploads_not_title"]["tmp_name"][$f]);
                        $imageName = $_FILES["file_uploads_not_title"]["name"][$f];
                        if (checkImage($imageName) && !empty($imageName)) {
                            $i = strrpos($imageName, ".");
                            $l = strlen($imageName) - $i;
                            $ext = substr($imageName, $i + 1, $l);
                            $imageName = create_captcha(7, PREFIX_IMG) . "." . $ext;
                            if ($_FILES['file_uploads_not_title']['size'][$f] <= FILE_MAX) {
                                $resize = new System_ResizeImageClass($img);
                                if ($resize != "error") {
                                    $resize->resizeTo(75, 75, 'exact');
                                    $resize->saveImage('../public/images/' . $nameFolder[0] . "/medium/" . $imageName,40);
                                    $resize->resizeTo(600, 502);
                                    $resize->saveImage('../public/images/' . $nameFolder[0] . "/original/" . $imageName,80);
                                    $active = 0;
                                    $data = array('ALBUM_ID' => $nameFolder[1], 'SMALL_IMAGE_URL' => $imageName, 'ORIGINAL_IMAGE_URL' => $imageName, 'IS_ACTIVE' => $active, 'CREATED_BY_USER' => $idUser);
                                    $objImageValue->addImage($data, 0);
                                    $messSucc[] = "Success : " . $_FILES["file_uploads_not_title"]["name"][$f] . "<br>";
                                } else {
                                    $messError[] = "Lỗi upoad file : " . $_FILES["file_uploads_not_title"]["name"][$f];
                                }
                            } else {
                                $messError[] = "File : " . $_FILES["file_uploads_not_title"]["name"][$f] . " quá lớn";
                            }
                        } else {
                            $messError[] = "File : " . $_FILES["file_uploads_not_title"]["name"][$f] . " không đúng định dạng.";
                        }
                    }
                    $_FILES["file_uploads_not_title"]["name"][$f] = "";
                }
            }
            if (isset($messSucc) && count($messSucc) > 0) {
                $success = addMessage($messSucc);
            }
            if (isset($messError) && count($messError) > 0) {
                $error = addMessage($messError);
            }
        }
        if ($act == "editimg" && !empty($_POST)) {
            $i = 0;
            $idImageEdit = $_POST['idEdit'];
            if ($idImageEdit > 0) {
                $folderEdit = $_POST['folder_hidden'];
                $des = $_POST['des'];
                $nameold = $_POST['nameImg'];
                $actEdit = (isset($_POST['ac'])) ? 1 : 0;
                $timestamp = date("Y-m-d H:i:s");
                if (isset($_FILES['edit_Img']['name']) && !empty($_FILES['edit_Img']['name'])) {
                    $imageName = strip_tags($_FILES['edit_Img']['name']);
                    if (checkImage($imageName)) {
                        $i = strrpos($imageName, ".");
                        $l = strlen($imageName) - $i;
                        $ext = substr($imageName, $i + 1, $l);
                        $imageName = create_captcha(7, PREFIX_IMG) . "." . $ext;
                        $temp = $_FILES['edit_Img']['tmp_name'];
                        $resize = new System_ResizeImageClass($temp);
                        if ($_FILES['edit_Img']['size'] <= FILE_MAX) {
                            if ($resize != "error") {
                                $resize->resizeTo(75, 75, 'exact');
                                $resize->saveImage('../public/images/' . $folderEdit . "/medium/" . $imageName,40);
                                $resize->resizeTo(600, 502);
                                $resize->saveImage('../public/images/' . $folderEdit . "/original/" . $imageName,80);
                                if (file_exists('../public/images/' . $folderEdit . "/medium/" . $nameold)) {
                                    unlink('../public/images/' . $folderEdit . "/medium/" . $nameold);
                                }
                                if (file_exists('../public/images/' . $folderEdit . "/original/" . $nameold)) {
                                    unlink('../public/images/' . $folderEdit . "/original/" . $nameold);
                                }
                                $i = 1;
                            } else {
                                $error = "Upload bị lỗi hoặc file không đúng định dạng";
                            }
                        } else {
                            $error = "File hình chọn quá lớn";
                        }
                    } else {
                        $error = "Hình không đúng định dạng";
                    }
                }
                if ($i == 1) {
                    $arrayUp = array('DESCRIPT' => $des, 'SMALL_IMAGE_URL' => $imageName,
                        'ORIGINAL_IMAGE_URL' => $imageName, 'IS_ACTIVE' => $actEdit,
                        'LAST_UPDATE' => $timestamp);
                    $objAlbumValue->updateAlbumImage($arrayUp, 1, "AB_IMAGE_ID=" . $idImageEdit);
                    $success = "Cập nhật thông tin thành công";
					//$cache->delete("sumAlbum");
					//$cache->delete("listAlbum");
                } else {
                    $arrayUp = array('DESCRIPT' => $des, 'IS_ACTIVE' => $actEdit, 'LAST_UPDATE' => $timestamp);
                    $objAlbumValue->updateAlbumImage($arrayUp, 0, "AB_IMAGE_ID=" . $idImageEdit);
                    $success = "Cập nhật thông tin thành công";
					//$cache->delete("sumAlbum");
					//$cache->delete("listAlbum");
                }

            } else {
                $error = "Chọn hình muốn sửa";
            }
        }
        //echo $idAlbum;
        if (isset($idAlbum) && $idAlbum > 0) {
            $album = $objAlbum->getTitleById($idAlbum);
            $imageList = $objAlbumValue->getImageByIdAlbum($idAlbum);
            //var_dump($imageList);
            $page = LINKS6;
            $page = ($page > 0 && $page != "") ? $page : 1;
            $sum = count($imageList);
            $start = ($page - 1) * PAGEMAX;
            $total = ceil($sum / PAGEMAX);
            //echo $start;
            $paginator = $objAlbumValue->getListImageLimit($idAlbum, $start, PAGEMAX);
            $listImage = $paginator;
           // var_dump($listImage);
            if (count($album) > 0)
                $albumName = $album[0]['ALBUM_TITLE'];
        }
		//$album = $objAlbum->getAlbumById($idAlbum);
		//$cache->delete("listAlbum");
		//$cache->delete($album[0]['MENU_ITEM_ID']);
        $view = "view/album/uploads.phtml";
        $objAlbum = null;
        $objTags = null;
        $objTagsAlbumValue = null;
        $objAlbumValue = null;
        $objImageValue = null;
        break;
    case "edit":
        $DATA["TITLE"] = 'Sửa thông tin album';
        $idAlbum = LINKS5;
        include_once("model/ResizeImageClass.php");
        include_once("model/album.php");
        include_once("model/tagAlbum.php");
        include_once("model/tagAlbumValue.php");
        include_once("model/category.php");
        $objAlbum = new album();
        $objTags = new tagAlbum();
        $objTagsAlbumValue = new tagAlbumValue();
        $album = $objAlbum->getAlbumById($idAlbum);
        $imageView = $album[0]['MEDIUM_IMAGE_URL'];
        if (!empty($_POST)) {
            $albumName = trim($_POST['album_name']);
            $album_name = $albumName;
            $description = $_POST['description'];
            $contentDes = $_POST['contentDes'];
            $imageName = strip_tags($_FILES['image']['name']);
            $active = (isset($_POST['active'])) ? 1 : 0;
            $tags = $_POST['tags'];
            $sources = $_POST['sources'];
            $menuItemId = $_POST['listMenuItem'];
            $image_folder = $album[0]['ALBUM_FOLDER_NAME'];
            $img = strip_tags($_FILES['image']['tmp_name']);
            if (!empty($albumName)) {
                $i = 0;
                // if ($this->checkImage($imageName)) {
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    if (checkImage($imageName)) {
                        $i = strrpos($imageName, ".");
                        $l = strlen($imageName) - $i;
                        $ext = substr($imageName, $i + 1, $l);
                        $imageName = create_captcha(7, PREFIX_IMG) . "." . $ext;
                        $resize = new System_ResizeImageClass($img);
                        if ($_FILES['image']['size'] <= FILE_MAX) {
                            if ($resize != "error") {
                                $resize->resizeTo(300, 300,'exact');
                                $resize->saveImage('../public/images/' . $image_folder . "/medium/" . $imageName,70);
                                $resize->resizeTo(600, 502);
                                $resize->saveImage('../public/images/' . $image_folder . "/original/" . $imageName,80);

                                if (file_exists('../public/images/' . $image_folder . "/medium/" . $album[0]['MEDIUM_IMAGE_URL'])) {
                                    unlink('../public/images/' . $image_folder . "/medium/" . $album[0]['MEDIUM_IMAGE_URL']);
                                }
                                if (file_exists('../public/images/' . $image_folder . "/original/" . $album[0]['ORIGINAL_IMAGE_URL'])) {
                                    unlink('../public/images/' . $image_folder . "/original/" . $album[0]['ORIGINAL_IMAGE_URL']);
                                }
                                $i = 1;
                            } else {
                                $error = "Upload bị lỗi hoặc file không đúng định dạng";
                            }
                        } else {
                            $error = "File hình chọn quá lớn";
                        }
                    } else {
                        $error = "Hình không đúng định dạng";
                    }
                }
                $array = array();
                $timestamp = date("Y-m-d H:i:s");
                if ($i == 1) {
                    $array = array('MENU_ITEM_ID' => $menuItemId, 'ALBUM_TITLE' => $albumName,
                        'ALBUM_DESCRIPT' => $description, 'ALBUM_CONTENT' => $contentDes, 'MEDIUM_IMAGE_URL' => $imageName, 'LAST_UPDATE' => $timestamp,
                        'ORIGINAL_IMAGE_URL' => $imageName, 'ALBUM_FOLDER_NAME' => $image_folder,
                        'IS_ACTIVE' => $active, 'VIEW' => 0, 'TAGS' => $tags, 'IMAGE_SOURCE' => $sources);
                    $imageView = $imageName;
                    $objAlbum->editAlbum($array, 1, $idAlbum);
                } else {
                    $array = array('MENU_ITEM_ID' => $menuItemId, 'ALBUM_TITLE' => $albumName, 'LAST_UPDATE' => $timestamp,
                        'ALBUM_DESCRIPT' => $description, 'ALBUM_CONTENT' => $contentDes,
                        'IS_ACTIVE' => $active, 'TAGS' => $tags, 'IMAGE_SOURCE' => $sources);
                    $imageView = $album[0]['MEDIUM_IMAGE_URL'];
                    $objAlbum->editAlbum($array, 0, $idAlbum);
                }

                if (trim($tags) != "") {
                    $listTags = explode(';', $tags);
                    if (is_array($listTags) && count($listTags) > 0) {
                        $objTagsAlbumValue->deleteTagAlbumValue($idAlbum);
                        foreach ($listTags as $key => $value) {
                            $checkIsExist = $objTags->getTagsByName(trim($value));
                            $idTags = 0;
                            if (count($checkIsExist) > 0) {
                                $idTags = $checkIsExist[0]['ID_TAG'];
                            } else {
                                $arrayTagsName = array('TAG_NAME' => $value);
                                $idTags = $objTags->addTagsValue($arrayTagsName);
                            }
                            $arrayTagValue = array('ALBUM_ID' => $idAlbum, 'TAG_VALUE_ID' => $idTags);
                            $objTagsAlbumValue->addTagsAlbumValue($arrayTagValue);
                        }
                    }
                } else {
                    $objTagsAlbumValue->deleteTagAlbumValue($idAlbum);
                }
                $success = "Cập nhật thông tin thành công";
                $album_name = "";
                $description = "";
                $contentDes = "";
                $active = 0;
                $tags = "";
                $sources = "";
                $image_folder = "";
			//	$cache->delete("sumAlbum");
				//$cache->delete("listAlbum");
			//	$cache->delete($album[0]['MENU_ITEM_ID']);
            } else {
                $error = "Tên album không được bỏ trống";
            }
        }
        $album = $objAlbum->getAlbumById($idAlbum);
        $album_name = $album[0]['ALBUM_TITLE'];
        $description = $album[0]['ALBUM_DESCRIPT'];
        $contentDes = $album[0]['ALBUM_CONTENT'];
        $active = ($album[0]['IS_ACTIVE']) ? 1 : 0;
        $tags = $album[0]['TAGS'];
        $sources = $album[0]['IMAGE_SOURCE'];
        $menuItemId = $album[0]['MENU_ITEM_ID'];
        $image_folder = $album[0]['ALBUM_FOLDER_NAME'];
        $objListItem = new category();
        $listMenuItems = $objListItem->Menu(0);
        $view = "view/album/edit.phtml";
        $objAlbum = null;
        $objTags = null;
        $objTagsAlbumValue = null;
        $objListItem = null;
        break;
    case "add":
        $DATA["TITLE"] = "Thêm mới album";
        if (!empty($_POST)) {
            include_once("model/ResizeImageClass.php");
            include_once("model/album.php");
            include_once("model/tagAlbum.php");
            include_once("model/tagAlbumValue.php");
            $objAlbum = new album();
            $objTags = new tagAlbum();
            $objTagsAlbumValue = new tagAlbumValue();
            $albumName = $_POST['album_name'];
            $description = $_POST['description'];
            $contentDes = $_POST['contentDes'];
            $imageName = strip_tags($_FILES['image']['name']);
            $active = (isset($_POST['active'])) ? 1 : 0;
            $tags = $_POST['tags'];
            $sources = $_POST['sources'];
            $menuItemId = isset($_POST['listMenuItem']) ? $_POST['listMenuItem'] : 0;
            $image_folder = $_POST['image_folder'];
            $img = strip_tags($_FILES['image']['tmp_name']);
            if (!empty($albumName)) {
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    if (checkImage($imageName)) {
                        if (!empty($image_folder)) {
                            $image_folder = pareString($image_folder,"-");
                            $image_folder = create_captcha(5, $image_folder);
                            $i = 0;
                            if (createFolder($image_folder, "../public/images/")) {
                                if (createFolder("medium", "../public/images/" . $image_folder . "/") && createFolder("original", "../public/images/" . $image_folder . "/")) {
                                    $i = 1;
                                }
                            } else {
                                $error = "Thư mục trùng hoặc tạo không thành công";
                            }
                            if ($i == 1) {
                                //header('Content-Type: image/jpeg');
                                $i = strrpos($imageName, ".");
                                $l = strlen($imageName) - $i;
                                $ext = substr($imageName, $i + 1, $l);
                                $imageName = create_captcha(7, PREFIX_IMG) . "." . $ext;
                                $resize = new System_ResizeImageClass($img);
                                if ($_FILES['image']['size'] <= FILE_MAX) {
                                    if ($resize != "error") {
                                        $resize->resizeTo(300, 300,'exact');
                                        $resize->saveImage('../public/images/' . $image_folder . "/medium/" . $imageName,70);
                                        $resize->resizeTo(600, 502);
                                        $resize->saveImage('../public/images/' . $image_folder . "/original/" . $imageName,80);

                                        $array = array('MENU_ITEM_ID' => $menuItemId, 'ALBUM_TITLE' => $albumName,
                                            'ALBUM_DESCRIPT' => $description, 'ALBUM_CONTENT' => $contentDes, 'MEDIUM_IMAGE_URL' => $imageName,
                                            'ORIGINAL_IMAGE_URL' => $imageName, 'ALBUM_FOLDER_NAME' => $image_folder, 'CREATED_BY_USER' => $_SESSION['username'],
                                            'IS_ACTIVE' => $active, 'VIEW' => 0, 'TAGS' => $tags, 'IMAGE_SOURCE' => $sources);
                                        $albumId = $objAlbum->addAlbum($array);
                                        if (trim($tags) != "") {
                                            $listTags = explode(';', $tags);
                                            if (is_array($listTags) && count($listTags) > 0) {
                                                foreach ($listTags as $key => $value) {
                                                    $checkIsExist = $objTags->getTagsByName(trim($value));
                                                    $idTags = 0;
                                                    if (count($checkIsExist) > 0) {
                                                        $idTags = $checkIsExist[0]['ID_TAG'];
                                                    } else {
                                                        $arrayTagsName = array('TAG_NAME' => $value);
                                                        $idTags = $objTags->addTagsValue($arrayTagsName);
                                                    }

                                                    $arrayTagValue = array('ALBUM_ID' => $albumId, 'TAG_VALUE_ID' => $idTags);
                                                    $objTagsAlbumValue->addTagsAlbumValue($arrayTagValue);
                                                }
                                            }
                                        }
                                        $success = "Thêm album thành công";
                                        $albumName = "";
                                        $description = "";
                                        $contentDes = "";
                                        $active = 0;
                                        $tags = "";
                                        $sources = "";
                                        $image_folder = "";
										//$cache->delete("sumAlbum");
										//$cache->delete("listAlbum");
										//$cache->delete($menuItemId);
                                    } else {
                                        $error = "Upload bị lỗi hoặc file không đúng định dạng";
                                    }
                                } else {
                                    $error = "File hình chọn quá lớn";
                                }
                            }
                        } else {
                            $error = "Tên thư mục hình không được bỏ trống";
                        }
                    } else {
                        $error = "Hình không đúng định dạng";
                    }
                } else {
                    $error = "Vui lòng chọn hình để upload";
                }
            } else {
                $error = "Tên album không được bỏ trống";
            }
            $objAlbum = null;
            $objTags = null;
            $objTagsAlbumValue = null;
        }
        include_once("model/category.php");
        $objCat = new category();
        $listMenuItems = $objCat->Menu(0);
        $view = "view/album/add.phtml";
        $objCat = null;
        break;
    case "delete":
        $idAlbum = LINKS5;
        include_once("model/ResizeImageClass.php");
        include_once("model/album.php");
        include_once("model/tagAlbum.php");
        include_once("model/tagAlbumValue.php");
        include_once("model/imageAlbum.php");
        $objAlbum = new album();
        $objTags = new tagAlbum();
        $objTagsAlbumValue = new tagAlbumValue();
        $objAlbum = new album();
        $objImageValue = new imageAlbum();
        $album = $objAlbum->getAlbumById($idAlbum);
        if (isset($album[0]['ALBUM_FOLDER_NAME']) && !empty($album[0]['ALBUM_FOLDER_NAME'])) {
            $folder_name = $album[0]['ALBUM_FOLDER_NAME'];
            if (file_exists('../public/images/' . $folder_name . "/medium")) {
                rmdirr('../public/images/' . $folder_name . "/medium");
            }
            if (file_exists('../public/images/' . $folder_name . "/original")) {
                rmdirr('../public/images/' . $folder_name . "/original");
            }
            if (file_exists('../public/images/' . $folder_name)) {
                rmdirr('../public/images/' . $folder_name);
            }
        }
        $objTagsAlbumValue->deleteTagAlbumValue($idAlbum);
        $objAlbum->deleteAlbum($idAlbum);
        $objImageValue->deleteAlbum($idAlbum);
		//$cache->delete("sumAlbum");
		//$cache->delete("listAlbum");
		//$cache->delete($album[0]['MENU_ITEM_ID']);
        $page = LINKS4;
        $page = ($page > 0 && $page != "") ? $page : 1;
        //$cacheSum = $cache->sumAlbum;
       // if ($cacheSum == null) {
            $cacheSum = $objAlbum->getListAlbum();
          //  $cache->sumAlbum= array($cacheSum, TIMECACHE);//set in to cache in 600 seconds = 10 minutes
        //}
        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
        //$arrayData = $cache->listAlbum;
      //  if ($arrayData == null) {
            $arrayData = $objAlbum->getListAlbumLimit($start,PAGEMAX);
           // $cache->listAlbum=array($arrayData, TIMECACHE);
       // }
       // $j = 0;
        $k = $start+PAGEMAX;
        if ($k > $cacheSum){
            $k=$cacheSum;
        }
      //  $arrayTemp=array();
      //  for ($i = $start; $i < $k; $i++) {
        //    $arrayTemp[$j] = $arrayData[$i];
       //     $j++;
       // }
        $dataPaginator = $arrayData;
        $view = "view/album/index.phtml";
        $success = "Xóa album thành công";
        $objAlbum = null;
        $objTags = null;
        $objTagsAlbumValue = null;
        $objImageValue = null;
        break;
    case "deleteImage":
        $id = LINKS5;
        $idal = LINKS7;
        $fd = LINKS6;
        include_once("model/album.php");
        $objAlbum = new album();
        if ($id > 0) {
            include_once("model/imageAlbum.php");
            $objImageVale = new imageAlbum();
            $objImage = $objImageVale->getImageValueById($id);
            if (!empty($objImage[0]['SMALL_IMAGE_URL'])) {
                if (file_exists('../public/images/' . $fd . "/medium/" . $objImage[0]['SMALL_IMAGE_URL'])) {
                    unlink('../public/images/' . $fd . "/medium/" . $objImage[0]['SMALL_IMAGE_URL']);
                }
                if (file_exists('../public/images/' . $fd . "/original/" . $objImage[0]['ORIGINAL_IMAGE_URL'])) {
                    unlink('../public/images/' . $fd . "/original/" . $objImage[0]['ORIGINAL_IMAGE_URL']);
                }
                $objImageVale->deleteImageValueById($id);
            }
            $objImageVale = null;
        }
		//$album = $objAlbum->getAlbumById($id);
		//$cache->delete("listAlbum");
		//$cache->delete($album[0]['MENU_ITEM_ID']);
        header("location:?/album/uploads/" . $idal . "");
        break;
    default:
        $page = LINKS4;
        include_once("model/album.php");
        $objAlbum = new album();
        $page = ($page > 0 && $page != "") ? $page : 1;
        //$cacheSum = $cache->sumAlbum;
       //if ($cacheSum == null) {
            $cacheSum = $objAlbum->getListAlbum();
           //$cache->sumAlbum= array($cacheSum, TIMECACHE);//set in to cache in 600 seconds = 10 minutes
      // }
        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
      // $arrayData = $cache->listAlbum;
       // if ($arrayData == null) {
        $arrayTemp = $objAlbum->getListAlbumLimit($start,5);
           // $cache->listAlbum=array($arrayData, TIMECACHE);
       // }
//        $j = 0;
//        $k = $start+PAGEMAX;
//        if ($k > $cacheSum){
//            $k=$cacheSum;
//        }
//        $arrayTemp=array();
//        for ($i = $start; $i < $k; $i++) {
//            $arrayTemp[$j] = $arrayData[$i];
//            $j++;
//        }
        $dataPaginator = $arrayTemp;

        $view = "view/album/index.phtml";
       $objAlbum = null;
        break;
}