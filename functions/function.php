<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 30/12/2014
 * Time: 11:52 AM 05
 */
function addMessage($arrayMess)
{
    if (is_array($arrayMess)) {
        $str = "";
        for ($i = 0; $i < count($arrayMess); $i++) {
            $str .= "<span>" . $arrayMess[$i] . "</span><br>";
        }
    }
    return $str;
}

function md5s($md_hash)
{
    $md_hash = md5($md_hash);
    return $md_hash;
}

function cut_string($text, $len)
{

    mb_internal_encoding('UTF-8');
    if ((mb_strlen($text, 'UTF-8') > $len)) {

        $text = mb_substr($text, 0, $len, 'UTF-8');
        $text = mb_substr($text, 0, mb_strrpos($text, " ", 'UTF-8'), 'UTF-8');
        $text .= "...";
    }
    return $text;
}

function cut_string_start_end($text, $start, $len)
{

    mb_internal_encoding('UTF-8');
    if ((mb_strlen($text, 'UTF-8') > $len)) {

        $text = mb_substr($text, $start, $len, 'UTF-8');
        $text = mb_substr($text, $start, mb_strrpos($text, " ", 'UTF-8'), 'UTF-8');
    }
    return $text;
}

function curPageName()
{
    return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
}

function paging($page, $url, $total, $maxpage, $show)
{
    $list_page = "";
    $num_page = 0;
    $list_page2 = "";
    $list_page1 = "";
    if ($total > 1) {
        if ($page > $maxpage) {
            $num_page = ceil($page / $maxpage);
            $showpage = ($num_page - 1) * $maxpage;
            $end = $showpage + $maxpage;
            $showpage++;
        } else {
            $thispage = 1;
            $showpage = 1;
            $end = $maxpage;
        }
        $startpage = $showpage;
        for ($showpage; $showpage < $end + 1; $showpage++) {
            if ($showpage <= $total) {
                if ($page == $showpage) {
                    $list_page .= "<span class='current'>" . $showpage . "</span> ";
                } else {
                    $list_page .= "<a href='$url/$showpage$show'>" . $showpage . "</a> ";
                }
            }
        }
        if ($num_page > 1) {
            $back = $page - 1;
            if ($num_page > 2) {
                $list_page1 = "<a href='$url/1$show'>Đầu</a>";
            }
            $list_page1 .= "<a href='$url/$back$show'>Trước</a> ";
        }
        if ($num_page < ceil($total / $maxpage) && ($total > $maxpage)) {
            $next = $page + 1;
            $list_page2 .= " <a href='$url/$next$show'>Sau</a>";
            $list_page2 .= " <a href='$url/$total$show'>Cuối</a>";
        }
        $list_page = $list_page1 . $list_page . $list_page2;
        return "<div class='msdn'>" . $list_page . "</div>";

    }
}

function pagingHome($page, $url, $total, $maxpage, $show)
{
    $list_page = "";
    $num_page = 0;
    $list_page2 = "";
    $list_page1 = "";
    if ($total > 1) {
        if ($page > $maxpage) {
            $num_page = ceil($page / $maxpage);
            $showpage = ($num_page - 1) * $maxpage;
            $end = $showpage + $maxpage;
            $showpage++;
        } else {
            $showpage = 1;
            $end = $maxpage;
        }
        $startpage = $showpage;
        for ($showpage; $showpage < $end + 1; $showpage++) {
            if ($showpage <= $total) {
                if ($page == $showpage) {
                    $list_page .= '<li class="active"><a href="">' . $showpage . '</a></li>';
                } else {
                    $list_page .= '<li><a href="' . $url . $showpage . $show . '">' . $showpage . '</a> </li>';
                }
            }
        }
        if ($num_page > 1) {
            $back = $page - 1;
            if ($num_page >= 2) {
                $list_page1 .= '<li><a href="' . $url . "1" . $show . '">Đầu</a></li>';
            }
            $list_page1 .= '<li><a href="' . $url . $back . $show . '">Trước</a></li>';
        }
        if ($num_page < ceil($total / $maxpage) && ($total > $maxpage)) {
            $next = $page + 1;
            $list_page2 .= '<li><a href="' . $url . $next . $show . '">Sau</a></li>';
            $list_page2 .= '<li><a href="' . $url . $total . $show . '">Cuối</a></li>';
        }
    }
    $listSum = '<ul class="pagination">' . $list_page1 . $list_page . $list_page2 . "</ul>";
    return $listSum;
}

function gannhan($sale, $hot, $new)
{
    $str = "";
    if ($sale != 0) {
        $str .= '<div class="hot">';
        $str .= '<img src="' . HTTP . 'templates/default/images/sale_icon.gif" width="30" height="25" border="0" />';
        $str .= '</div>';
        return $str;
    }
    if ($hot == 1) {
        $str .= '<div class="hot">';
        $str .= '<img src="' . HTTP . 'templates/default/images/hot.gif" width="50" height="13" border="0" />';
        $str .= '</div>';
        return $str;
    }
    if ($new == 1) {
        $str .= '<div class="hot">';
        $str .= '<img src="' . HTTP . 'templates/default/images/new.gif" width="33" height="16" />';
        $str .= '</div>';
        return $str;
    }
}

function create_captcha($num_character, $prefix)
{
    $chuoi = "ABCDEFGHIJKLMNOPQRSTUVWYWZ0123456789";
    $i = 1;
    $giatri = "";
    while ($i <= $num_character) {
        $vitri = mt_rand(0, 35);
        $giatri .= substr($chuoi, $vitri, 1);
        $i++;
    }
    return $prefix . "_" . strtolower($giatri);
}

function createFolder($name, $url)
{
    if ($name != "") {
        if (!is_dir($url . $name)) {
            if (!mkdir($url . $name, 0777, true))
                return false;
        } else {
            return false;
        }
    }
    return true;
}

function rmdirr($dirname)
{//Xóa thư mục
    if (!file_exists($dirname)) {
        return false;
    }

    if (is_file($dirname)) {
        return unlink($dirname);
    }

    $dir = scandir($dirname);
    for ($i = 0; $i < count($dir); $i++) {
        if ($dir[$i] == "." || $dir[$i] == "..")
            continue;
        $f = $dir[$i];
        rmdirr($dirname . "/" . $f);
    }
    return rmdir($dirname);
}

function del_file($dirname)
{
    if (!file_exists($dirname)) {
        return false;
    }
    if (is_file($dirname)) {
        return unlink($dirname);
    }
}

function compareDate($date)
{
    $day = date('d', strtotime($date));
    $month = date('F', strtotime($date));
    $year = date('Y', strtotime($date));
    $str = '<div class="date">
		   <span class="day">' . $day . '</span>
		  <span class="month">' . $month . '</span>
		  <span class="year">' . $year . '</span>
		  </div>';
    return $str;
}

function pareString($str, $character)
{
    // In thường
    $str = strtolower($str);
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = html_entity_decode($str);
    $str = str_replace(array(' ', '_'), $character, $str);
    $str = html_entity_decode($str);
    $str = str_replace("ç", "c", $str);
    $str = str_replace("Ç", "C", $str);
    $str = str_replace(" / ", $character, $str);
    $str = str_replace("/", $character, $str);
    $str = str_replace(" - ", $character, $str);
    $str = str_replace("_", $character, $str);
    $str = str_replace(" ", $character, $str);
    $str = str_replace("ß", "ss", $str);
    $str = str_replace("&", "", $str);
    $str = str_replace("%", "percent", $str);
    $str = str_replace("----", $character, $str);
    $str = str_replace("---", $character, $str);
    $str = str_replace("--", $character, $str);
    $str = str_replace(".", $character, $str);
    $str = str_replace(",", "", $str);
    // In đậm
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str; // Trả về chuỗi đã chuyển
}

function convertStringAndId($str, $id, $character)
{
    $string = pareString($str, "-");
    $string = $id . "-" . $string . $character;
    return $string;
}


function buildCacheList($arrayIndex, $prefix)
{
    global $cache;
    $arrayTemp = array();
    foreach ($arrayIndex as $k => $value) {
        if ($cache->isExisting($prefix . $value))
            array_push($arrayTemp, $cache->get($prefix . $value));
    }
    return $arrayTemp;
}

function updateItemAlbumCache($idAlbum, $data, $time, $page, $prefixItem, $prefixPage, $keyListIndex, $keyPageIndex)
{
    global $cache;
    $idCacheDel = $prefixItem . $idAlbum;
    $cache->set($idCacheDel, $data, $time);
    //var_dump($cache->get("albumid_87"));
    $cacheSum = count($cache->get($keyListIndex));
    $total = ceil($cacheSum / $page);
    if ($total == 0)
        $total = 1;
    $arrayIndexPage = array();
    for ($i = 1; $i <= $total; $i++) {
        array_push($arrayIndexPage, $i);
    }
    deleteCache($arrayIndexPage, $prefixPage);
    $cache->set($keyPageIndex, $arrayIndexPage, $time);
    $cacheList = buildCacheList($cache->get($keyListIndex), $prefixItem);
    for ($i = 1; $i <= $total; $i++) {
        $start = ($i - 1) * $page;
        $arrayTemp = array_slice($cacheList, $start, ($start + $page));
        $cache->set($prefixPage . ($start + $page), $arrayTemp, $time);
    }
}

function buildCacheParent($idParent, $time)
{
    global $cache;
    $cacheList = buildCacheList($cache->get("keyAlbumIndex"), "albumid_");
    $parentCache = "parent_" . $idParent;
    $cache->delete($parentCache);
    $listCache = $cache->get($parentCache);
    if ($listCache == null) {
        $arrayTemp = array();
        foreach ($cacheList as $k => $value) {
            if ($value['MENU_ITEM_ID'] == $idParent) {
                array_push($arrayTemp, $value);
            }
        }
        $listCache = $arrayTemp;
        $cache->set($parentCache, $arrayTemp, $time);
    }
    return $listCache;
}

function updateItemParentCache($idParent, $idAlbum, $data, $time)
{
    global $cache;
    $idCacheDel = "albumid_" . $idAlbum;
    $cache->set($idCacheDel, $data, $time);
    $cacheList = buildCacheList($cache->get("keyAlbumIndex"), "albumid_");
    $parentCache = "parent_" . $idParent;
    $cache->delete($parentCache);
    $listCache = $cache->get($parentCache);
    if ($listCache == null) {
        $arrayTemp = array();
        foreach ($cacheList as $k => $value) {
            if ($value['MENU_ITEM_ID'] == $idParent) {
                array_push($arrayTemp, $value);
            }
        }
        $listCache = $arrayTemp;
        $cache->set($parentCache, $arrayTemp, $time);
    }
    return $listCache;
}

function deleteCache($arrayIndex, $prefix)
{
    global $cache;
    foreach ($arrayIndex as $k => $value) {
        if ($cache->isExisting($value))
            $cache->delete($prefix . $value);
    }
}


function get_product($pid)
{
    global $db;
    $sql = "select * from products,menu_items where products.ACTIVE=1 and products.PRODUCT_MENU_ITEM_ID=menu_items.MENU_ID and products.ID =$pid";
    $data = $db->getData($sql);
    return $data;
}

function remove_product($pid)
{
    $pid = intval($pid);
    if (isset($_SESSION['shopping_cart_chshop_online'])) {
        $max = count($_SESSION['shopping_cart_chshop_online']);
        for ($i = 0; $i < $max; $i++) {
            if ($pid == $_SESSION['shopping_cart_chshop_online'][$i]['productid']) {
                unset($_SESSION['shopping_cart_chshop_online'][$i]);
                break;
            }
        }
        $_SESSION['shopping_cart_chshop_online'] = array_values($_SESSION['shopping_cart_chshop_online']);
    }
}

function get_order_total()
{
    $sum = 0;
    if (isset($_SESSION['shopping_cart_chshop_online'])) {
        $max = count($_SESSION['shopping_cart_chshop_online']);
        for ($i = 0; $i < $max; $i++) {
            $pid = $_SESSION['shopping_cart_chshop_online'][$i]['productid'];
            $q = $_SESSION['shopping_cart_chshop_online'][$i]['qty'];
            $data = get_product($pid);
            $price = $data[0]['PRICE'] - $data[0]['SALE'];
            $sum += $price * $q;
        }
    }
    return $sum;
}

function get_total_item()
{
    if (isset($_SESSION['shopping_cart_chshop_online']))
        return count($_SESSION['shopping_cart_chshop_online']);
    else
        return 0;
}

function addtocart($pid, $q, $feature)
{
    if ($pid < 1 or $q < 1) return;

    if (isset($_SESSION['shopping_cart_chshop_online']) && is_array($_SESSION['shopping_cart_chshop_online'])) {
        //if (product_exists($pid)) return;
        $i = product_exists($pid);
        if ($i >= 0) {
            $_SESSION['shopping_cart_chshop_online'][$i]['qty'] += $q;
        } else {
            $max = count($_SESSION['shopping_cart_chshop_online']);
            $_SESSION['shopping_cart_chshop_online'][$max]['productid'] = $pid;
            $_SESSION['shopping_cart_chshop_online'][$max]['qty'] = $q;
            $_SESSION['shopping_cart_chshop_online'][$max]['feature'] = $feature;
        }

    } else {
        $_SESSION['shopping_cart_chshop_online'] = array();
        $_SESSION['shopping_cart_chshop_online'][0]['productid'] = $pid;
        $_SESSION['shopping_cart_chshop_online'][0]['qty'] = $q;
        $_SESSION['shopping_cart_chshop_online'][0]['feature'] = $feature;
    }
}

function updateCart($pid, $q)
{
    if ($pid < 1 or $q < 1) return;
    $i = product_exists($pid);
    if ($i >= 0) {
        $_SESSION['shopping_cart_chshop_online'][$i]['qty'] = $q;
    }
}

function product_exists($pid)
{
    $flag = -1;
    if (isset($_SESSION['shopping_cart_chshop_online'])) {
        $pid = intval($pid);
        $max = count($_SESSION['shopping_cart_chshop_online']);
        for ($i = 0; $i < $max; $i++) {
            if ($pid == $_SESSION['shopping_cart_chshop_online'][$i]['productid']) {
                $flag = $i;
                break;
            }
        }
    }
    return $flag;
}

function _get_viewed_product($product_id)
{
    $flag = FALSE;
    if (!isset($_SESSION['viewed_product']))
        $_SESSION['viewed_product'] = $product_id;
    else {
        $str = $product_id;
        $viewed_array = explode(':', $_SESSION['viewed_product']);
        foreach ($viewed_array as $a) {
            if ($str == $a) {
                $flag = FALSE;
                break;
            } else {
                $flag = TRUE;
            }
        }
    }
    if ($flag)
        $_SESSION['viewed_product'] = $_SESSION['viewed_product'] . ':' . $str;
    $product_ids = explode(':', $_SESSION['viewed_product']);
    if (count($product_ids) > 9) {
        array_shift($product_ids);
        $b = '';
        foreach ($product_ids as $id) {
            if ($b == '')
                $b .= $id;
            else
                $b .= ':' . $id;
        }
        $_SESSION['viewed_product'] = $b;
    }
    return explode(':', $_SESSION['viewed_product']);
}

function delete_directory($dirname)
{
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while ($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname . "/" . $file))
                unlink($dirname . "/" . $file);
            else
                delete_directory($dirname . '/' . $file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

$mangso = array('không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín');
function dochangchuc($so, $daydu)
{
    global $mangso;
    $chuoi = "";
    $chuc = floor($so / 10);
    $donvi = $so % 10;
    if ($chuc > 1) {
        $chuoi = " " . $mangso[$chuc] . " mươi";
        if ($donvi == 1) {
            $chuoi .= " mốt";
        }
    } else if ($chuc == 1) {
        $chuoi = " mười";
        if ($donvi == 1) {
            $chuoi .= " một";
        }
    } else if ($daydu && $donvi > 0) {
        $chuoi = " lẻ";
    }
    if ($donvi == 5 && $chuc > 1) {
        $chuoi .= " lăm";
    } else if ($donvi > 1 || ($donvi == 1 && $chuc == 0)) {
        $chuoi .= " " . $mangso[$donvi];
    }
    return $chuoi;
}

function docblock($so, $daydu)
{
    global $mangso;
    $chuoi = "";
    $tram = floor($so / 100);
    $so = $so % 100;
    if ($daydu || $tram > 0) {
        $chuoi = " " . $mangso[$tram] . " trăm";
        $chuoi .= dochangchuc($so, true);
    } else {
        $chuoi = dochangchuc($so, false);
    }
    return $chuoi;
}

function dochangtrieu($so, $daydu)
{
    $chuoi = "";
    $trieu = floor($so / 1000000);
    $so = $so % 1000000;
    if ($trieu > 0) {
        $chuoi = docblock($trieu, $daydu) . " triệu";
        $daydu = true;
    }
    $nghin = floor($so / 1000);
    $so = $so % 1000;
    if ($nghin > 0) {
        $chuoi .= docblock($nghin, $daydu) . " nghìn";
        $daydu = true;
    }
    if ($so > 0) {
        $chuoi .= docblock($so, $daydu);
    }
    return $chuoi;
}

function docso($so)
{
    global $mangso;
    if ($so == 0) return $mangso[0];
    $chuoi = "";
    $hauto = "";
    do {
        $ty = $so % 1000000000;
        $so = floor($so / 1000000000);
        if ($so > 0) {
            $chuoi = dochangtrieu($ty, true) . $hauto . $chuoi;
        } else {
            $chuoi = dochangtrieu($ty, false) . $hauto . $chuoi;
        }
        $hauto = " tỷ";
    } while ($so > 0);
    return ucfirst(trim($chuoi)) . " đồng chẵn";
}

function shuffle_assoc($list)
{
    if (!is_array($list)) return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key) {
        $random[$key] = $list[$key];
    }
    return $random;
}

function get_image_by_string($strImage,$index){
    $strTemp="";
    if($strImage=="")return $strTemp;
    $listImageFeature=explode("@@@",$strImage);
    if(count($listImageFeature)>0)
        $strTemp = $listImageFeature[$index];
    return $strTemp;
}
function get_image_array_by_string($strImage){
    $listImageFeature=explode("@@@",$strImage);
    return $listImageFeature;
}

