<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 21/04/2015
 * Time: 15:03 PM 19
 */
$DATA["TITLE"] = "Quản lý tin tức";
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
        $DATA["TITLE"] = "Thêm tin tức";
        if (!empty($_POST)) {
            include_once("model/ResizeImageClass.php");
            include_once("model/news.php");
            include_once("model/tagNews.php");
            include_once("model/tagNewsValue.php");
            $objNews = new news();
            $objTags = new tagNews();
            $objTagsNewsValue = new tagNewsValue();
            $newsName = $_POST['news_name'];
            $description = $_POST['description'];
            $contentDes = $_POST['contentDes'];
            $imageName = strip_tags($_FILES['image']['name']);
            $active = (isset($_POST['active'])) ? 1 : 0;
            $tags = $_POST['tags'];
            $sources = $_POST['sources'];
            $menuItemId = isset($_POST['listMenuItem']) ? $_POST['listMenuItem'] : 0;
            $img = strip_tags($_FILES['image']['tmp_name']);
            if (!empty($newsName)) {
                if ($imageName != "") {
                    if (checkImage($imageName)) {
                        //header('Content-Type: image/jpeg');
                        $i = strrpos($imageName, ".");
                        $l = strlen($imageName) - $i;
                        $ext = substr($imageName, $i + 1, $l);
                        $imageName = create_captcha(7, PREFIX_IMG) . "." . $ext;
                        $resize = new System_ResizeImageClass($img);
                        if ($_FILES['image']['size'] <= FILE_MAX) {
                            if ($resize != "error") {
                                $resize->resizeTo(300, 300, 'exact');
                                $resize->saveImage('../public/news/medium/' . $imageName, 70);
                                $resize->resizeTo(650, 400, 'exact');
                                $resize->saveImage('../public/news/original/' . $imageName, 80);

                                $array = array('MENU_ID' => $menuItemId, 'NEWS_TITLE' => $newsName,
                                    'DESCRIPT' => $description, 'NEWS_CONTENT' => $contentDes, 'MEDIUM_IMAGE_URL' => $imageName,
                                    'ORIGINAL_IMAGE_URL' => $imageName, 'CREATED_BY_USER' => $_SESSION['username'],
                                    'IS_ACTIVE' => $active, 'VIEW' => 0, 'TAGS' => $tags, 'NEWS_SOURCE' => $sources);
                                $newsId = $objNews->addNews($array);
                                if (trim($tags) != "") {
                                    $listTags = explode(';', $tags);
                                    if (is_array($listTags) && count($listTags) > 0) {
                                        foreach ($listTags as $key => $value) {
                                            $checkIsExist = $objTags->getTagsByName(trim($value));
                                            $idTags = 0;
                                            if (count($checkIsExist) > 0) {
                                                $idTags = $checkIsExist[0]['TAG_ID'];
                                            } else {
                                                $arrayTagsName = array('TAG_NAME' => $value);
                                                $idTags = $objTags->addTagsValue($arrayTagsName);
                                            }

                                            $arrayTagValue = array('TAG_ID' => $newsId, 'NEWS_VALUE_ID' => $idTags);
                                            $objTagsNewsValue->addTagsNewsValue($arrayTagValue);
                                        }
                                    }
                                }
                                $success = "Thêm tin tức thành công";
                                $newsName = "";
                                $description = "";
                                $contentDes = "";
                                $active = 0;
                                $tags = "";
                                $sources = "";
//                            $cache->delete("sumNews");
//                            $cache->delete("listNews");
//                            $cache->delete($menuItemId);
                            } else {
                                $error = "Upload bị lỗi hoặc file không đúng định dạng";
                            }
                        } else {
                            $error = "File hình chọn quá lớn";
                        }

                    } else {
                        $error = "Hình không đúng định dạng";
                    }
                } else {
                    $array = array('MENU_ID' => $menuItemId, 'NEWS_TITLE' => $newsName,
                        'DESCRIPT' => $description, 'NEWS_CONTENT' => $contentDes, 'MEDIUM_IMAGE_URL' => "",
                        'ORIGINAL_IMAGE_URL' => "", 'CREATED_BY_USER' => $_SESSION['username'],
                        'IS_ACTIVE' => $active, 'VIEW' => 0, 'TAGS' => $tags, 'NEWS_SOURCE' => $sources);
                    $newsId = $objNews->addNews($array);
                    if (trim($tags) != "") {
                        $listTags = explode(';', $tags);
                        if (is_array($listTags) && count($listTags) > 0) {
                            foreach ($listTags as $key => $value) {
                                $checkIsExist = $objTags->getTagsByName(trim($value));
                                $idTags = 0;
                                if (count($checkIsExist) > 0) {
                                    $idTags = $checkIsExist[0]['TAG_ID'];
                                } else {
                                    $arrayTagsName = array('TAG_NAME' => $value);
                                    $idTags = $objTags->addTagsValue($arrayTagsName);
                                }

                                $arrayTagValue = array('TAG_ID' => $newsId, 'NEWS_VALUE_ID' => $idTags);
                                $objTagsNewsValue->addTagsNewsValue($arrayTagValue);
                            }
                        }
                    }
                    $success = "Thêm tin tức thành công";
                    $cache->delete("listNews");
                    $newsName = "";
                    $description = "";
                    $contentDes = "";
                    $active = 0;
                    $tags = "";
                    $sources = "";
                }

            } else {
                $error = "Tiêu đề tin không được bỏ trống";
            }
            $objAlbum = null;
            $objTags = null;
            $objTagsAlbumValue = null;
        }
        include_once("model/category.php");
        $objCat = new category();
        $listMenuItems = $objCat->Menu(0);
        $view = "view/news/add.phtml";
        $objCat = null;
        break;
    case
    "delete":
        $idNews = LINKS5;
        include_once("model/ResizeImageClass.php");
        include_once("model/news.php");
        include_once("model/tagNews.php");
        include_once("model/tagNewsValue.php");
        $objNews = new news();
        $objTags = new tagNews();
        $objTagsNewsValue = new tagNewsValue();
        $news = $objNews->getNewsById($idNews);
        if (!empty($news[0]['MEDIUM_IMAGE_URL'])) {
            if (file_exists('../public/news/medium/' . $news[0]['MEDIUM_IMAGE_URL'])) {
                unlink('../public/news/medium/' . $news[0]['MEDIUM_IMAGE_URL']);
            }
            if (file_exists('../public/news/original/' . $news[0]['MEDIUM_IMAGE_URL'])) {
                unlink('../public/news/original/' . $news[0]['MEDIUM_IMAGE_URL']);
            }
        }
        $objTagsNewsValue->deleteTagNewsValue($idNews);
        $objNews->deleteNews($idNews);
        $page = LINKS4;
        $page = ($page > 0 && $page != "") ? $page : 1;
        $cacheSum = $objNews->getListNews();
        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
        $arrayData = $objNews->getListNewsLimit($start, PAGEMAX);
        $dataPaginator = $arrayData;
        $view = "view/news/index.phtml";
        $success = "Xóa tin với Mã: <span style='color: red;'>" . $idNews . "</span> thành công";
        break;
    case "edit":
        $DATA["TITLE"] = 'Sửa tin tức';
        $idNews = LINKS5;
        include_once("model/ResizeImageClass.php");
        include_once("model/news.php");
        include_once("model/tagNews.php");
        include_once("model/tagNewsValue.php");
        include_once("model/category.php");
        $objNews = new news();
        $objTags = new tagNews();
        $objTagsNewsValue = new tagNewsValue();
        $news = $objNews->getNewsById($idNews);
        $imageView = $news[0]['MEDIUM_IMAGE_URL'];
        if (!empty($_POST)) {
            $news_name = trim($_POST['news_name']);
            $description = $_POST['description'];
            $contentDes = $_POST['contentDes'];
            $imageName = strip_tags($_FILES['image']['name']);
            $active = (isset($_POST['active'])) ? 1 : 0;
            $tags = $_POST['tags'];
            $sources = $_POST['sources'];
            $menuItemId = $_POST['listMenuItem'];
            $img = strip_tags($_FILES['image']['tmp_name']);
            if (!empty($news_name)) {
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
                                $resize->resizeTo(300, 300, 'exact');
                                $resize->saveImage('../public/news/medium/' . $imageName, 70);
                                $resize->resizeTo(650, 400, 'exact');
                                $resize->saveImage('../public/news/original/' . $imageName, 80);
                                if (file_exists('../public/news/medium/' . $news[0]['MEDIUM_IMAGE_URL'])) {
                                    unlink('../public/news/medium/' . $news[0]['MEDIUM_IMAGE_URL']);
                                }
                                if (file_exists('../public/news/original/' . $news[0]['MEDIUM_IMAGE_URL'])) {
                                    unlink('../public/news/original/' . $news[0]['MEDIUM_IMAGE_URL']);
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
                    $array = array('MENU_ID' => $menuItemId, 'NEWS_TITLE' => $news_name,
                        'DESCRIPT' => $description, 'NEWS_CONTENT' => $contentDes, 'MEDIUM_IMAGE_URL' => $imageName, 'LAST_UPDATED' => $timestamp,
                        'ORIGINAL_IMAGE_URL' => $imageName,
                        'IS_ACTIVE' => $active, 'VIEW' => 0, 'TAGS' => $tags, 'NEWS_SOURCE' => $sources);
                    $imageView = $imageName;
                    $objNews->editNews($array, 1, $idNews);
                } else {
                    $array = array('MENU_ID' => $menuItemId, 'NEWS_TITLE' => $news_name, 'LAST_UPDATED' => $timestamp,
                        'DESCRIPT' => $description, 'NEWS_CONTENT' => $contentDes,
                        'IS_ACTIVE' => $active, 'TAGS' => $tags, 'NEWS_SOURCE' => $sources);
                    $imageView = $news[0]['MEDIUM_IMAGE_URL'];
                    $objNews->editNews($array, 0, $idNews);
                }

                if (trim($tags) != "") {
                    $listTags = explode(';', $tags);
                    if (is_array($listTags) && count($listTags) > 0) {
                        $objTagsNewsValue->deleteTagNewsValue($idNews);
                        foreach ($listTags as $key => $value) {
                            $checkIsExist = $objTags->getTagsByName(trim($value));
                            $idTags = 0;
                            if (count($checkIsExist) > 0) {
                                $idTags = $checkIsExist[0]['TAG_ID'];
                            } else {
                                $arrayTagsName = array('TAG_NAME' => $value);
                                $idTags = $objTags->addTagsValue($arrayTagsName);
                            }
                            $arrayTagValue = array('TAG_ID' => $idNews, 'NEWS_VALUE_ID' => $idTags);
                            $objTagsNewsValue->addTagsNewsValue($arrayTagValue);
                        }
                    }
                } else {
                    $objTagsNewsValue->deleteTagNewsValue($idNews);
                }
                $success = "Cập nhật thông tin thành công";
                $news = $objNews->getNewsById($idNews);
                $news_name = "";
                $description = "";
                $contentDes = "";
                $active = 0;
                $tags = "";
                $sources = "";
            } else {
                $error = "Tiêu đề tin không được bỏ trống";
            }
        }
        $news_name = $news[0]['NEWS_TITLE'];
        $description = $news[0]['DESCRIPT'];
        $contentDes = $news[0]['NEWS_CONTENT'];
        $active = ($news[0]['IS_ACTIVE']) ? 1 : 0;
        $tags = $news[0]['TAGS'];
        $sources = $news[0]['NEWS_SOURCE'];
        $menuItemId = $news[0]['MENU_ID'];
        $objListItem = new category();
        $listMenuItems = $objListItem->Menu(0);
        $view = "view/news/edit.phtml";
        break;
    default:
        $page = LINKS4;
        $page = ($page > 0 && $page != "") ? $page : 1;
        include_once("model/news.php");
        $objNews = new news();
        $cacheSum = $objNews->getListNews();
        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
        $arrayData = $objNews->getListNewsLimit($start, PAGEMAX);
        $dataPaginator = $arrayData;
        $view = "view/news/index.phtml";
        break;
}