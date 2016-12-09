<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 11:59 AM 10
 */
$DATA["TITLE"] = "Quản lý thông tin thành viên";
include_once("../functions/function.php");
switch (LINKS4) {
    case "add":
        $DATA["TITLE"] = "Thêm thành viên";
        if (!empty($_POST)) {
            include_once("model/user.php");
            $objUser = new user();
            $email = addslashes(strip_tags($_POST['email'], '<script><a>'));
            $pass = addslashes(strip_tags($_POST['password'], '<script><a>'));
            $re_pass = addslashes(strip_tags($_POST['re_password'], '<script><a>'));
            $fullname = addslashes(strip_tags($_POST['fullname'], '<script><a>'));
            $phone = addslashes(strip_tags($_POST['phone'], '<script><a>'));
            $address = addslashes(strip_tags($_POST['address'], '<script><a>'));
            $active = (isset($_POST['active'])) ? "Y" : "N";
            $viewActive = ($active == "Y") ? "checked='checked'" : "";
            $role = $_POST['role'];
            if ($role == "1")
                $role1 = "selected='selected'";
            else
                $role2 = "selected='selected'";
            if (!empty($email)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if ($objUser->getUserByEmail($email) == 0) {
                        if (!empty($pass) && !empty($re_pass)) {
                            if ($pass != $re_pass) {
                                $error = "Mật khẩu không khớp";
                            } else {
                                $pass = md5s($pass);
                                $idUser = $_SESSION['id_user'];
                                $check = $objUser->addUser($email, $pass, $phone, $address, $active, $role, $idUser, $fullname);
                                if ($check) {
                                    $success = "Thêm thành viên thành công.";
                                    $cache->delete("listUser");
									$cache->delete("sumUser");
                                    $fullname = "";
                                    $email = "";
                                    $phone = "";
                                    $pass = "";
                                    $re_pass = "";
                                    $address = "";
                                    $viewActive = "";
                                } else
                                    $error = "Có lỗi trong quá trình thêm thành viên.";
                            }
                        } else {
                            $error = "Mật khẩu không được để trống.";
                        }
                    } else {
                        $error = "Tài khoản này đã tồn tại.";
                    }
                } else {
                    $error = "Email không đúng định dạng.";
                }
            } else {
                $error = "Email không được để trống.";
            }
            $objUser = null;
        }
        $view = "view/user/add.phtml";
        break;
    case "edit":
        $idEdit = LINKS5;
        include_once("model/user.php");
        $objUser = new user();
        if (!empty($_POST)) {
            $ac = LINKS6;
            if ($ac == "infor") {
                $fullname = addslashes(strip_tags($_POST['fullname'], '<script><a>'));
                $phone = addslashes(strip_tags($_POST['phone'], '<script><a>'));
                $address = addslashes(strip_tags($_POST['address'], '<script><a>'));
                $active = (isset($_POST['active'])) ? "Y" : "N";
                $role = $_POST['role'];
                $timestamp = date("Y-m-d H:i:s");
                $check=$objUser->updateInforUser($phone,$address,$active,$role,$fullname,$timestamp,$idEdit);
                if($check) {
                    $success = "Cập nhật thông tin thành công";
                    $cache->delete("listUser");
					$cache->delete("sumUser");
                }
                else
                    $error="Có lỗi xảy ra trong quá trình cập nhật thông tin";
            }
            if ($ac == "pass") {
                $pass = addslashes(strip_tags($_POST['password'], '<script><a>'));
                $re_pass = addslashes(strip_tags($_POST['re_password'], '<script><a>'));
                if (!empty($pass) && !empty($re_pass)) {
                    if ($pass != $re_pass) {
                        $error = "Mật khẩu không khớp";
                    } else {
                        $pass = md5s($pass);
                        $idUser = $_SESSION['id_user'];
                        $check = $objUser->updatePassUser($pass,$idEdit);
                        if ($check) {
                            $success="Cập nhật mật khẩu thành công";
                        } else
                            $error = "Có lỗi trong quá trình cập nhật mật khẩu.";
                    }
                } else {
                    $error = "Mật khẩu không được để trống.";
                }
            }
        }
        $arr=$objUser->getUserById($idEdit);
        $email=$arr['EMAIL'];
        $fullname=$arr['FULLNAME'];
        $phone=$arr['PHONE'];
        $address=$arr['ADDRESS'];
        $viewActive=($arr['ENABLED']=="Y")? "checked='checked'" : "";
        $role =$arr['USER_ROLE'];
        if ($role == "1")
            $role1 = "selected='selected'";
        else
            $role2 = "selected='selected'";
        $view = "view/user/edit.phtml";
        $objUser=null;
        break;
    case "delete":
        $id = LINKS5;
        if ($id > 0) {
            include_once("model/user.php");
            $objUser = new user();
            if ($objUser->deleteUser($id)) {
               $cache->delete("listUser");
			   $cache->delete("sumUser");
                header("location:?/user");
            }
        }
        $objUser = null;
        $RENDER = false;
        break;
    case "search":
        if(!empty($_POST)){
            $idUser=$_POST['user_id'];
            $fullName=$_POST['fullName'];
            $email=$_POST['email'];
            $phone=$_POST['phone'];
            $active=$_POST['active'];
            if ($active == "Y")
                $active1 = "selected='selected'";
            elseif ($active == "N")
                $active2 = "selected='selected'";
            else
                $active0 = "selected='selected'";
            include_once("model/user.php");
            $objUser = new user();
            $arrayData = $objUser->searchAction($idUser,$fullName,$email,$phone,$active);
            $objUser=null;
        }
        $view = "view/user/search.phtml";
        break;
    default:
        $page = LINKS4;
        $page = ($page > 0 && $page != "") ? $page : 1;
        $cacheSum=$cache->sumUser;
        if($cacheSum==null){
            include_once("model/user.php");
            $objUser = new user();
            $cacheSum = $objUser->getListUser();
            $objUser = null;
            $cache->sumUser = array($cacheSum,TIMECACHE);//set in to cache in 600 seconds = 10 minutes
        }

        $start = ($page - 1) * PAGEMAX;
        $total = ceil($cacheSum / PAGEMAX);
        $arrayData=$cache->listUser;
        if($arrayData==null){
            include_once("model/user.php");
            $objUser = new user();
//            $arrayData = $objUser->getListUserLimit($start, PAGEMAX);
            $arrayData = $objUser->getListAllUser();
            $cache->listUser=array($arrayData,TIMECACHE);
            $objUser = null;
        }
        $j = 0;
        $k = $start+PAGEMAX;
        if ($k > $cacheSum){
            $k=$cacheSum;
        }
        $arrayTemp=array();
        for($i=$start;$i<$k;$i++){
            $arrayTemp[$j]=$arrayData[$i];
            $j++;
        }
        $view = "view/user/index.phtml";
        break;
}