<?php
ob_start();
session_start();
$tb = "";
if (!empty($_POST)) {
    $email = addslashes(strip_tags($_POST['txtUsername'], '<script><a>'));
    $pass = addslashes(strip_tags($_POST['txtPassword'], '<script><a>'));

    if (!empty($email) && !empty($pass)) {
        include_once("model/login.php");
        include_once("../functions/function.php");
        $objLogin = new login();
        if ($objLogin->checkValidLogin($email, md5s($pass)) == 1) {
            if (isset($_SESSION['urlViewStar']))
                header("location:" . $_SESSION['urlViewStar'] . "");
            else
                header("location:index.php");
        } else {
            $tb = "Đăng nhập không thành công";
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/mainStyles.css" media="screen"/>
    <title>Đăng nhập</title>
</head>
<body>
<div id="mainContent">
    <form action="" method="post" id="frmLogin">
        <div><?= ($tb != "") ? $tb : ""; ?></div>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr style="height: 60px;padding: 10px;font-size: 30px;font-weight: bold;background-color: #dfdfdf;">
                <td colspan="3" style="padding-left: 20px;">Đăng nhập</td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 10px">
                    <input placeholder="Email" id="txtUsername" name="txtUsername" class="txtInput" type="text">
                </td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 10px;"><input placeholder="Mật khẩu" id="txtPassword" name="txtPassword"
                                                              class="txtInput" type="password"></td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 10px;"><input type="submit" class="btn" id="subLogin" value="Đăng nhập">
                </td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>