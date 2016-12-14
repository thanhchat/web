<?php
define('_JEXEC', true);
//include_once("model/login.php");
//$objLogin = new login();
//if (!$objLogin->checkLogin())
//header("location:login.php");
$theme = "bluesky";
$fp = @fopen('theme.txt', "r");
// Kiểm tra file mở thành công không
if (!$fp) {
    echo 'Mở file không thành công';
} else {
    // Lặp qua từng dòng để đọc
    while (!feof($fp)) {
        $theme = fgets($fp);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <title>Portal Admin</title>
    <link rel="stylesheet" type="text/css" href="../primeui/showcase/themes/<?= $theme; ?>/theme.css"/>
    <link rel="stylesheet" type="text/css" href="../primeui/showcase/resources/css/site.css"/>
    <link rel="stylesheet" type="text/css" href="../primeui/showcase/resources/css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../primeui/showcase/resources/css/perfect-scrollbar.css"/>
    <link rel="stylesheet" type="text/css" href="../primeui/showcase/resources/css/sh.css"/>
    <link rel="stylesheet" type="text/css" href="../primeui/showcase/resources/icons/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../primeui/showcase/resources/css/magicsuggest-min.css"/>
    <script type="text/javascript" src="../primeui/showcase/resources/js/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="./ckeditor/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="../primeui/showcase/resources/js/jquery-ui.js"></script>
    <script type="text/javascript" src="../primeui/showcase/resources/js/perfect-scrollbar.js"></script>
    <script type="text/javascript" src="../primeui/showcase/resources/js/site.js"></script>
    <script type="text/javascript" src="../primeui/showcase/resources/js/block.js"></script>
    <script type="text/javascript" src="../primeui/showcase/resources/js/magicsuggest-min.js"></script>


    <!-- Dependencies of some widgets -->
    <script type="text/javascript" src="../primeui/showcase/resources/js/plugins/plugins-all.js"></script>

    <!-- Mustache for templating support -->
    <script type="text/javascript" src="../primeui/showcase/resources/js/plugins/mustache.min.js"></script>

    <!-- X-TAG for PrimeElements -->
    <script type="text/javascript" src="../primeui/showcase/resources/js/x-tag-core.min.js"></script>
    <!-- PrimeUI -->
    <link rel="stylesheet" href="../primeui/build/primeui.css"/>
    <script type="text/javascript" src="../primeui/build/primeui.js"></script>
    <script type="text/javascript" src="../primeui/build/primeelements.js"></script>


    <link rel="stylesheet" href="upload/css/bootstrap.min.css">

    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="upload/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="upload/css/jquery.fileupload.css">
    <link rel="stylesheet" href="upload/css/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript>
        <link rel="stylesheet" href="upload/css/jquery.fileupload-noscript.css">
    </noscript>
    <noscript>
        <link rel="stylesheet" href="upload/css/jquery.fileupload-ui-noscript.css">
    </noscript>

</head>

<body>
<div class="PC">
    <div id="MENUSIDE">
        <div id="MENUSIDEindent">
				<span id="LOGO" class="bordersOfMenuSide">
                        <a href=""><img alt="logo" src="../primeui/showcase/resources/images/admin2.png" width="150px"
                                        height="70px"/></a>
                    </span>
            <span id="SubMenu-PrimeElements" class="MenuSideMainLink bordersOfMenuSide"
                  onclick="Showcase.changePageWithLink('view/product/index.phtml')"><span
                    class="MainLinkText">Sản phẩm</span></span>
            <span id="SubMenu-Input" class="MenuSideMainLink bordersOfMenuSide"
                  onclick="Showcase.openSubMenu(this);"><span class="MainLinkText">Tính năng</span></span>

            <div class="SubMenuLinkContainer">
                <a class="SubMenuLink" href="view/feature/index.phtml">Tính năng</a>
                <a class="SubMenuLink" href="view/feature-type/index.phtml">Loại tính năng</a>
            </div>
            <span id="SubMenu-Input" class="MenuSideMainLink bordersOfMenuSide"
                  onclick="Showcase.changePageWithLink('view/category/index.phtml');"><span class="MainLinkText">Danh mục</span></span>
            <span id="SubMenu-Input" class="MenuSideMainLink bordersOfMenuSide"
                  onclick="Showcase.changePageWithLink('view/product-price-type/index.phtml');"><span class="MainLinkText">Loại giá</span></span>
            <span id="SubMenu-Input" class="MenuSideMainLink bordersOfMenuSide"
                  onclick="Showcase.changePageWithLink('view/mail-template/index.phtml');"><span class="MainLinkText">Mail template</span></span>
        </div>
    </div>

    <div id="CONTENTSIDE">
        <div id="CONTENTSIDEindent">

            <!-- header bar start-->
            <div class="ContentSideSections" id="PFTopLinksCover" style="height:5px;">
                        <span class="PFTopLinks floatRight boldFont cursorPointer" id="themeSwitcher">
                            <span class="PFDarkText">Đổi giao diện</span>
                            <div id="GlobalThemeSwitcher" class="navOverlay">
                                <a href="#" data-theme="aristo"><span class="ui-theme ui-theme-aristo"></span><span
                                        class="ui-text">Aristo</span></a>
                                <a href="#" data-theme="bluesky"><span class="ui-theme ui-theme-bluesky"></span><span
                                        class="ui-text">Bluesky</span></a>
                                <a href="#" data-theme="bootstrap"><span
                                        class="ui-theme ui-theme-bootstrap"></span><span
                                        class="ui-text">Bootstrap</span></a>
                                <a href="#" data-theme="casablanca"><span
                                        class="ui-theme ui-theme-casablanca"></span><span
                                        class="ui-text">Casablanca</span></a>
                                <a href="#" data-theme="delta"><span class="ui-theme ui-theme-delta"></span><span
                                        class="ui-text">Delta</span></a>
                                <a href="#" data-theme="flick"><span class="ui-theme ui-theme-flick"></span><span
                                        class="ui-text">Flick</span></a>
                                <a href="#" data-theme="glass-x"><span class="ui-theme ui-theme-glass-x"></span><span
                                        class="ui-text">Glass-X</span></a>
                                <a href="#" data-theme="overcast"><span class="ui-theme ui-theme-overcast"></span><span
                                        class="ui-text">Overcast</span></a>
                                <a href="#" data-theme="pepper-grinder"><span
                                        class="ui-theme ui-theme-pepper-grinder"></span><span class="ui-text">Pepper-Grinder</span></a>
                                <a href="#" data-theme="redmond"><span class="ui-theme ui-theme-redmond"></span><span
                                        class="ui-text">Redmond</span></a>
                                <a href="#" data-theme="sam"><span class="ui-theme ui-theme-sam"></span><span
                                        class="ui-text">Sam</span></a>
                                <a href="#" data-theme="smoothness"><span
                                        class="ui-theme ui-theme-smoothness"></span><span
                                        class="ui-text">Smoothness</span></a>
                                <a href="#" data-theme="south-street"><span
                                        class="ui-theme ui-theme-south-street"></span><span
                                        class="ui-text">South-Street</span></a>
                                <a href="#" data-theme="start"><span class="ui-theme ui-theme-start"></span><span
                                        class="ui-text">Start</span></a>
                            </div>
                        </span>
                <select id="mobilemenu" class="selectmenu mediumFont">
                    <option value="#">Home</option>
                    <option value="view/product/index.phtml">Sản phẩm</option>
					<optgroup label="Tính năng" class="LEVEL1">
                                <option value="view/feature/index.phtml">Tính năng</option>
								<option value="view/feature-type/index.phtml">Loại tính năng</option>
                    </optgroup>
					<option value="view/product-price-type/index.phtml">Loại giá</option>
					<option value="view/category/index.phtml">Danh mục</option>
                </select>

            </div>
            <!-- header bar end-->

            <div id="ContentPagePortal" style="background: white;">
				<div style="text-align:center;margin-top:20%;"><img alt="logo" src="../primeui/showcase/resources/images/admin_home.png" /></div>
            </div>


            <!-- footer start
            <div class="ContentSideSections">
                <span class="floatLeft fontSize14 gray"><a href="#">Shop</a>, Copyright &copy; 2016</span>
                <span class="floatRight fontSize14 gray">All rights reserved</span>
                <div style="clear:both"></div>
            </div>
            <!-- footer end-->

        </div>
    </div>

</div>

<script type="text/javascript" src="../primeui/showcase/resources/js/sh.js"></script>
</body>
</html>
