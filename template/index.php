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
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/template/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/css/font-awesome.min.css">
    <!-- Custom CSS -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/template/css/owl.carousel.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/css/responsive.css">
    <link rel="stylesheet" href="/template/css/animate.css">
    <link rel="stylesheet" href="/template/css/sweetalert.css">
    <link rel="stylesheet" href="/template/css/nprogress.css">
    <?php if ($cssProduct == 1 || $cssProductDetail == 1) { ?>
        <link rel="stylesheet" href="/template/css/componentSwitch.css">
    <?php } ?>
    <?php if ($cssProductDetail == 1) { ?>
        <link rel="stylesheet" href="/template/css/etalage.css">
        <link rel="stylesheet" href="/template/css/simplelightbox.min.css">
        <link rel="stylesheet" href="/template/css/nice-select.css">
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
                        <li><a href="/lien-he"><i class="fa fa-user"></i> LIÊN HỆ</a></li>
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
                        <a href="/dang-ky">ĐĂNG KÝ</a>
                    </div>
                    <div class="cart box_1">
                        <a href="/gio-hang">
                            <h3><span class="simpleCart_total">
                                    <?php
                                    if (isset($_SESSION['shopping_cart_online']) && is_array($_SESSION['shopping_cart_online'])) {
                                    ?>
                                    <?= number_format($objCart->get_order_total()); ?> VNĐ
                                </span>
                                (<span
                                    id="simpleCart_quantity"
                                    class="simpleCart_quantity"><?= $objCart->get_total_item(); ?>
                                </span> items)
                                <img src="/template/img/bag.png" alt="" id="imgCart">

                            <?php }else{ ?>
                                   0 VNĐ
                                </span>
                                (<span
                                    id="simpleCart_quantity"
                                    class="simpleCart_quantity">0
                                </span> items)
                                <img src="/template/img/bag.png" alt="" id="imgCart">
                            </h3>
                        <?php } ?>
                        </a>
                         <p id="cartEmty"><a href="javascript:;" onclick="deleteCart();" class="simpleCart_empty">(Xóa)</a></p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="create_btn">
                        <a href="/thanh-toan">THANH TOÁN</a>
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
    <div class="container">
        <div class="col-md-6 s-c">
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
    <div class="container">
        <div class="col-md-3 cust">
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
<div id="jsscript" class="modal fade"></div>
<!-- End footer top area -->
<!-- Bootstrap JS form CDN -->
<script type="text/javascript" src="/template/js/jquery-1.11.1.min.js"></script>
<script src="/template/js/bootstrap.min.js"></script>
<!-- jQuery sticky menu -->
<script src="/template/js/owl.carousel.min.js"></script>
<script src="/template/js/jquery.sticky.js"></script>
<!-- jQuery easing -->
<script src="/template/js/jquery.easing.1.3.min.js"></script>
<script src="/template/js/enscroll-0.6.2.min.js"></script>
<script src="/template/js/main.js"></script>
<script src="/template/js/sweetalert-dev.js"></script>
<script src="/template/js/nprogress.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Main Script -->
<!-- Slider -->
<script>
    <?php
    if (isset($_SESSION['shopping_cart_online']) && is_array($_SESSION['shopping_cart_online'])) {
    ?>
        $('#cartEmty').show();
    <?php }else{?>
        $('#cartEmty').hide();
    <?php }?>
</script>
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
    <script src="/template/js/jquery.nice-select.js"></script>
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
                thumb_image_width: 340,
                thumb_image_height: 340,
                source_image_width: 900,
                source_image_height: 900,
                zoom_area_width: 450,               // Width of the zoomed image frame (including borders, padding) (value in pixels)
                zoom_area_height: 450,       // Height of the zoomed image frame (including borders, padding) (value in pixels / 'justify' = height of large thumb + small thumbs)
                zoom_area_distance: 20,
                show_hint: true,
                autoplay: false,
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
            <?php if(isset($checkCountFeature)&&$checkCountFeature>0){?>
            etalage_show(<?=$showImg;?>);
            $('.dropdownlist').change(function () {
                etalage_show($(this).find('option:selected').attr('findShow'));
                $('.dropdownlist').niceSelect('update');
            });

            $('.dropdownlist').niceSelect();
            <?php }?>
        });
    </script>
    <?php include_once("mvc/model/shop.php"); ?>
<?php } ?>
<?php if ($jsProductDetail == 1 || $jsProduct == 1) { ?>
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
    <script>
		$start=parseInt($('#VIEWBY').val());
		$('#VIEWBY').change(function () {
				$start=parseInt($('#VIEWBY').val());
				$sort=$('#SORT').val();
				$delay=0;
                $st=0;
                $ed=$(this).val();
				$.post(
					'/mvc/controller/ajax/get-product-page.php',
					{start:$st,end:$ed,category:'<?=END;?>',delay:$delay,sort:$sort},
					function(data){
						if(data){
							new WOW(
								{
									boxClass: 'wow',      // default
									animateClass: 'animated', // default
									offset: 0,          // default
									mobile: true,       // default
									live: true        // default
								}
							).init();
							reset_slider('#slider-container');
							$('#listProductByCategory >li').remove();
							$('#listProductByCategory').append(data);
							if (!$('#more').length){
								$('#pagination').append(' <div id="more">Xem thêm sản phẩm</div>');
							}
						}
						$("input:radio").removeAttr("checked");
						$("#filterColor li > span").removeClass ( 'active' );
					}
				);
        });
		$('#SORT').change(function () {
				$delay=0;
                $st=0;
                $ed=$start;
				$sort=$(this).val();
				$.post(
					'/mvc/controller/ajax/get-product-page.php',
					{start:$st,end:$ed,category:'<?=END;?>',delay:$delay,sort:$sort},
					function(data){
						if(data){
							new WOW(
								{
									boxClass: 'wow',      // default
									animateClass: 'animated', // default
									offset: 0,          // default
									mobile: true,       // default
									live: true        // default
								}
							).init();
							reset_slider('#slider-container');
							$('#listProductByCategory >li').remove();
							$('#listProductByCategory').append(data);
							if (!$('#more').length){
								$('#pagination').append(' <div id="more">Xem thêm sản phẩm</div>');
							}
						}
						$("input:radio").removeAttr("checked");
						$("#filterColor li > span").removeClass ( 'active' );
					}
				);
        });
		$more=$('#more');
		$text_default=$more.text();
		$('#pagination').on('click','#more', function() {
			//$delay=$('#listProductByCategory>li:last').attr('data-wow-delay');
			reset_slider('#slider-container');
			$delay=0;//$delay.replace(/s*$/, "");
			$end=parseInt($('#VIEWBY').val());
			$sort=$('#SORT').val();
				//$go_to=$('#listProductByCategory li:last').offset().top;
				$.post(
					'/mvc/controller/ajax/get-product-page.php',
					{start:$start,end:$end,category:'<?=END;?>',delay:$delay,sort:$sort},
					function(data){
						if(data){
							$('#listProductByCategory').append(data);
							//$('html, body').animate({scrollTop:$go_to},800);
							$start+=parseInt($end);
						}else{
							$('#more').remove();
						}
					}
				);
		});
		
        $('.scrollbox3').enscroll({
            showOnHover: true,
            verticalTrackClass: 'track3',
            verticalHandleClass: 'handle3'
        });

		$('input:radio[name="filter_type1"]').change(
		function(){
			if ($(this).is(':checked')) {
				var $filter1=$(this).val();
				var $filterColor=-1;
				if ($('#filterColor >li').find('span').hasClass( "active" )){
					$filterColor=$('#idColor').val();
				}
				if($filter1==0)
					$("#filterColor li > span").removeClass ( 'active' );
				//alert(filter1+'-'+filterColor);
				$.post(
					'/mvc/controller/ajax/get-product-filter.php',
					{filter1:$filter1,filterColor:$filterColor,category:'<?=END;?>'},
					function(data){
						if(data){
							$('#listProductByCategory >li').remove();
							$('#listProductByCategory').append(data);
							$('#more').remove();
						}else{
							$('#listProductByCategory >li').remove();
							$('#listProductByCategory').append('<li>Không tìm thấy kết quả</li>');
							$('#more').remove();
						}
					}
				);
			}
		});
		function filterColor(idColor){
			$('#idColor').val(idColor);
			var $filter1=-1;
			var myRadio = $('input[name=filter_type1]');
			if(myRadio.is(':checked'))
				$filter1=myRadio.filter(':checked').val();
			//alert(filter_type1+'-'+idColor);
			$("#filterColor li > span").removeClass ( 'active' );
			$('#'+idColor).addClass('active');
			$.post(
					'/mvc/controller/ajax/get-product-filter.php',
					{filter1:$filter1,filterColor:idColor,category:'<?=END;?>'},
					function(data){
						if(data){
							$('#listProductByCategory >li').remove();
							$('#listProductByCategory').append(data);
							$('#more').remove();
						}else{
							$('#listProductByCategory >li').remove();
							$('#listProductByCategory').append('<li>Không tìm thấy kết quả</li>');
							$('#more').remove();
						}
					}
				);
		}
    </script>
    <!--initiate accordion-->
    <script type="text/javascript">
        $(function () {
            $('#cssmenu li.has-sub').find('ul').slideUp(200);
            $('#cssmenu li.active').parent('ul').slideDown(200);
            $('#cssmenu li.has-sub.open').parent('ul').slideDown(200);
            $('#cssmenu li.has-sub.open').find('ul').slideDown(200);

            $('#cssmenu li.has-sub>a').on('click', function () {
                $(this).removeAttr('href');
                var element = $(this).parent('li');
                if (element.hasClass('open')) {
                    element.removeClass('open');
                    element.find('li').removeClass('open');
                    element.find('ul').slideUp(200);
                } else {
                    element.addClass('open');
                    element.children('ul').slideDown(200);
                    element.siblings('li').children('ul').slideUp(200);
                    element.siblings('li').removeClass('open');
                    element.siblings('li').find('li').removeClass('open');
                    element.siblings('li').find('ul').slideUp(200);
                }
            });
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
        });
    </script>
<?php } ?>
<script>
NProgress.start();
NProgress.set(0.4);
//Increment 
var interval = setInterval(function() { NProgress.inc(); }, 1000);
$(document).ready(function(){
    NProgress.done();
    clearInterval(interval);
});

$(function () {
	var mi, mx;
      $('#slider-container').slider({
          range: true,
		  step: 1000,
          min: 0,
          max: 5000000,
          values: [0, 5000000],
          create: function() {
              $("#amount").val("0 - "+addCommas('5000000')+" VNĐ");
          },
          slide: function (event, ui) {  
              $("#amount").val(addCommas(ui.values[0]) + " VNĐ - " + addCommas(ui.values[1])+" VNĐ");
          },
		  stop:function (event, ui) {
               mi = ui.values[0];
               mx = ui.values[1];
              filterSystem(mi, mx);
			  new WOW(
					{
						boxClass: 'wow',      // default
						animateClass: 'animated', // default
						offset: 0,          // default
						mobile: true,       // default
						live: true        // default
					}
				).init();
          }
      })
});
var reset_slider = function( slider_selector ){
    // Reset the sliders to their original min/max values 
    $( slider_selector ).each(function(){

      var options = $(this).slider( 'option' );
      $(this).slider( 'values', [ options.min, options.max ] );
	  $("#amount").val("0 - "+addCommas('5000000')+" VNĐ");
    });  
  
};
  function filterSystem(minPrice, maxPrice) {
      $("#listProductByCategory li").hide().filter(function () {
          var price = parseInt($(this).data("price"), 10);
          return price >= minPrice && price <= maxPrice;
      }).show();
  }
</script>
</body>
</html>