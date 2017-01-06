<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="lun shop">
    <meta name="Description" content="lun shop">
    <link rel="icon" href="/template/img/favicon.png" type="image/x-icon">
    <title><?php if (isset($title)) echo $title; else echo 'Lun Shop Online Store'; ?></title>
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet'
          type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/template/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/template/css/owl.carousel.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/css/responsive.css">
    <link rel="stylesheet" href="/template/css/animate.css">
    <?php if ($cssProduct == 1 || $cssProductDetail == 1) { ?>
        <link rel="stylesheet" href="/template/css/componentSwitch.css">
    <?php } ?>
    <?php if ($cssProductDetail == 1) { ?>
        <link rel="stylesheet" href="/template/css/etalage.css">
        <link rel="stylesheet" href="/template/css/simplelightbox.min.css">
    <?php } ?>
    <!-- Latest jQuery form server -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="user-menu">
                    <ul>
                        <li><a href="#"><i class="fa fa-support"></i>HỖ TRỢ</a></li>
                        |
                        <li><a href="cart.html"><i class="fa fa-user"></i> LIÊN HỆ</a></li>
                        |
                        <li><a href="#"><i class="fa fa-car"></i>THÔNG TIN VẬN CHUYỂN</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="header-right">
                    <ul class="list-unstyled list-inline">
                        <li class="dropdown dropdown-small">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><span
                                    class="key">Thông tin</span><b
                                    class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Tài khoản</a></li>
                                <li><a href="#">Đơn hàng</a></li>
                                <li><a href="#">Địa chỉ giao hàng</a></li>
                            </ul>
                        </li>

                        <!--<li class="dropdown dropdown-small">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><span
                                    class="key">language :</span><span class="value">English </span><b
                                    class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">German</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End header area -->

<div class="site-branding-area">
    <div class="container" style="padding-right: 0px;padding-left: 0px;">
        <div class="head-top-ls">
            <div class="logo">
                <a href="index.html"><img src="/template/img/logo.png" class="img-responsive" alt=""> </a>
            </div>
            <div class="header_right-ls">
                <div class="rgt-bottom">
                    <div class="log">
                        <div class="login">
                            <div id="loginContainer"><a id="loginButton"><span>ĐĂNG NHẬP</span></a>

                                <div id="loginBox" style="display: none;">
                                    <form id="loginForm">
                                        <fieldset id="body">
                                            <fieldset>
                                                <label for="email">Email</label>
                                                <input type="text" name="email" id="email">
                                            </fieldset>
                                            <fieldset>
                                                <label for="password">Mật khẩu</label>
                                                <input type="password" name="password" id="password">
                                            </fieldset>
                                            <input type="submit" id="login" value="Đăng nhập">

                                            <div class="sky-form">
                                                <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Ghi
                                                    nhớ đăng nhập</label>
                                            </div>
                                        </fieldset>
                                        <span><a href="#">Quên mật khẩu?</a></span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="reg">
                        <a href="./dang-ky">ĐĂNG KÝ</a>
                    </div>
                    <div class="cart box_1">
                        <a href="./thanh-toan">
                            <h3><span class="simpleCart_total">1,200,000 VND</span> (<span id="simpleCart_quantity"
                                                                                           class="simpleCart_quantity">3</span>
                                items)<img src="/template/img/bag.png" alt=""></h3>
                        </a>

                        <p><a href="javascript:;" class="simpleCart_empty">(Xóa)</a></p>

                        <div class="clearfix"></div>
                    </div>
                    <div class="create_btn">
                        <a href="./thanh-toan">THANH TOÁN</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="search">
                    <form>
                        <input type="text" value="" placeholder="Từ khóa...">
                        <input type="submit" value="">
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- End site branding area -->

<div class="mainmenu-area">
    <div class="container" style=" background: none repeat scroll 0 0 #f5f5f5;  text-transform: uppercase;">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" style="padding-left: 0px;">
                <ul class="nav navbar-nav">
                    <?php
                    foreach ($listItemMenu as $k => $value) {
                        ?>
                        <li class="<?= $value["STATUS"] ?>"><a
                                href="<?= $value["URL"] ?>"><?= $value["NAME"] ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End mainmenu area -->
<!--Main content-->
<?php include_once($view); ?>
<!--End main content-->
<div class="foot-top">
    <div class="container" style="padding-right: 0px;padding-left: 0px;">
        <div class="col-md-6 s-c" style="padding-right: 0px;padding-left: 0px;">
            <li>
                <div class="fooll">
                    <h5>Theo dõi </h5>
                </div>
            </li>
            <li>
                <div class="social-ic">
                    <ul>
                        <li><a href="#"><i class="facebok"> </i></a></li>
                        <li><a href="#"><i class="goog"> </i></a></li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </li>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-6 s-c" style="padding-right: 0px;padding-left: 0px;">
            <div class="stay">
                <div class="stay-left">
                    <form>
                        <input type="text" placeholder="Nhập email tham gia bản tin" required="">
                    </form>
                </div>
                <div class="btn-1">
                    <form>
                        <input fa fa-paper-plane type="submit" value="Gửi">
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="footer">
    <div class="container" style="padding-left: 0px;padding-right: 0px">
        <div class="col-md-3 cust" style="padding-right: 0px;padding-left: 0px;">
            <h4>CHĂM SÓC KHÁCH HÀNG</h4>
            <li><a href="#">Hỗ trợ</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="buy.html">Làm sao để đặt hàng?</a></li>
            <li><a href="#">Vận chuyển</a></li>
        </div>
        <div class="col-md-2 abt">
            <h4>GIỚI THIỆU</h4>
            <li><a href="#">Về chúng tôi</a></li>
            <li><a href="contact.html">Liên hệ</a></li>
        </div>
        <div class="col-md-2 myac">
            <h4>TÀI KHOẢN</h4>
            <li><a href="register.html">Đăng ký</a></li>
            <li><a href="#">Giỏ hàng</a></li>
            <li><a href="#">Lịch sử đặt hàng</a></li>
            <li><a href="buy.html">Thanh toán</a></li>
        </div>
        <div class="col-md-5 our-st" style="padding-right: 0px;padding-left: 0px;">
            <div class="our-left">
                <h4>CỬA HÀNG</h4>
            </div>
            <div class="clearfix"></div>
            <li><i class="add"> </i>114/8/38 Chiến Lược, Bình Trị Đông, Bình Tân, HCM</li>
            <li><i class="phone"> </i>0977.230.710</li>
            <li><a href="mailto:info@example.com"><i class="mail"> </i>thanhchat1202@gmail.com</a></li>

        </div>
        <div class="clearfix"></div>
        <p>Copyrights © 2016 LunShop</p>
    </div>
</div>
<!-- End footer top area -->
<!-- Bootstrap JS form CDN -->
<script type="text/javascript" src="/template/js/jquery-1.11.1.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- jQuery sticky menu -->
<script src="/template/js/owl.carousel.min.js"></script>
<script src="/template/js/jquery.sticky.js"></script>
<!-- jQuery easing -->
<script src="/template/js/jquery.easing.1.3.min.js"></script>
<script src="/template/js/enscroll-0.6.2.min.js"></script>
<script src="/template/js/main.js"></script>
<!-- Main Script -->
<!-- Slider -->
<?php if ($jsHome == 1) { ?>
    <script type="text/javascript" src="/template/js/bxslider.min.js"></script>
    <script type="text/javascript" src="/template/js/script.slider.js"></script>
<?php } ?>
<?php if ($jsHome == 1 || $jsProductDetail == 1 || $jsProduct == 1) { ?>
    <script src="/template/js/wow.min.js"></script>
<?php } ?>
<?php if ($jsProductDetail == 1) { ?>
    <script src="/template/js/jquery.etalage.min.js"></script>
    <script src="/template/js/simpleLightbox.min.js"></script>

<?php } ?>
<?php if ($jsProduct == 1) { ?>
    <script src="/template/js/jquery.cookie.js"></script>
    <script src="/template/js/classie.js"></script>
    <script src="/template/js/cbpViewModeSwitch.js"></script>
<?php } ?>
<?php if ($jsProductDetail == 1) { ?>
    <script>
        jQuery(document).ready(function ($) {
            $('#etalage').etalage({
                thumb_image_width: 300,
                thumb_image_height: 400,
                source_image_width: 900,
                source_image_height: 1200,
                zoom_area_width: 500,               // Width of the zoomed image frame (including borders, padding) (value in pixels)
                zoom_area_height: 500,       // Height of the zoomed image frame (including borders, padding) (value in pixels / 'justify' = height of large thumb + small thumbs)
                zoom_area_distance: 20,
                show_hint: true,
                autoplay: true,
                click_callback: function (image_anchor, instance_id) {
                    var $items = $('#etalage a');
                    //console.log($items);
                    var imgSelect = image_anchor.split('/');
                    var index = 0;
                    for (i = 0; i < $items.length; i++) {
                        var imgChect = $items[i].pathname.split('/');
                        if (imgChect[imgChect.length - 1] == imgSelect[imgSelect.length - 1])
                            index = i;
                    }
                    //alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
                    $.SimpleLightbox.open({
                        $items: $items,
                        startAt: index
                    });
                }
            });
        });
    </script>
<?php } ?>
<?php if ($jsProductDetail == 1 || $jsProduct == 1) { ?>
    <script>
        $('.scrollbox3').enscroll({
            showOnHover: true,
            verticalTrackClass: 'track3',
            verticalHandleClass: 'handle3'
        });

    </script>
    <!--initiate accordion-->
    <script type="text/javascript">
	$(function() {
	  var menu = $('#cssmenu > ul');
	  menu.find('.has-sub > ul').hide();
	  menu.on('click', function(event) {
		event.preventDefault();
		var targetParent = $(event.target).parent();
		if (targetParent.hasClass('has-sub')) {
		  targetParent.toggleClass('active');
		  targetParent.children('ul').slideToggle(250);
		}
	  })
	});
</script>
<?php } ?>
<?php if ($jsHome == 1) { ?>
    <script>
        new WOW(
            {
                boxClass: 'wow',      // default
                animateClass: 'animated', // default
                offset: 0,          // default
                mobile: true,       // default
                live: true        // default
            }
        ).init();
    </script>
<?php } ?>
<?php if ($jsCheckout == 1) { ?>
    <script>
        $(document).ready(function (c) {
            $("#cpnsID").click(function () {
                $("#coupons").toggle();
            });
            $('.close1').on('click', function (c) {
                $('.cart-header').fadeOut('slow', function (c) {
                    $('.cart-header').remove();
                });
            });
        });
    </script>
    <script>
        $(document).ready(function (c) {
            $('.close2').on('click', function (c) {
                $('.cart-header2').fadeOut('slow', function (c) {
                    $('.cart-header2').remove();
                });
            });
        });
    </script>
<?php } ?>

</body>
</html>