jQuery(document).ready(function ($) {

    // jQuery sticky Menu

    $(".mainmenu-area").sticky({topSpacing: 0});
    $('.product-carousel').owlCarousel({
        loop: true,
        navText: ['<<', '>>'],
        nav: false,
        margin: 20,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 5,
            }
        }
    });

    $('.related-products-carousel').owlCarousel({
        loop: true,
        nav: true,
        margin: 20,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });

    $('.brand-list').owlCarousel({
        loop: true,
        nav: true,
        margin: 20,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 4,
            }
        }
    });


    // Bootstrap Mobile Menu fix
    $(".navbar-nav li a").click(function () {
        $(".navbar-collapse").removeClass('in');
    });

    // jQuery Scroll effect
    $('.navbar-nav li a, .scroll-to-up').bind('click', function (event) {
        var $anchor = $(this);
        var headerH = $('.header-area').outerHeight();
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - headerH + "px"
        }, 1200, 'easeInOutExpo');

        event.preventDefault();
    });

    // Bootstrap ScrollPSY
    $('body').scrollspy({
        target: '.navbar-collapse',
        offset: 95
    })
});
function showProduct(idProduct) {
    $.ajax({
        type: "GET",
        url: '/mvc/controller/ajax/viewProductAddToCart.php?idProduct=' + idProduct,
        dataType: "text",
        success: function (response) {
            $.loadCSS('/template/css/componentSwitch.css');
            $.loadCSS('/template/css/etalage.css');
            $.loadCSS('/template/css/simplelightbox.min.css');
            $.loadCSS('/template/css/nice-select.css');

            $.when(
                $.getScript("/template/js/jquery.etalage.min.js"),
                $.getScript("/template/js/simpleLightbox.min.js"),
                $.getScript("/template/js/jquery.nice-select.js"),
                $.Deferred(function (deferred) {
                    $(deferred.resolve);
                })
            ).done(function () {
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
                    var showimg = $('#showImg').val();
                    var countfeature = $('#countfeature').val();
                    if (countfeature > 0) {
                        etalage_show(showimg);
                        $('.dropdownlist').change(function () {
                            etalage_show($(this).find('option:selected').attr('findShow'));
                            $('.dropdownlist').niceSelect('update');
                        });
                        $('.dropdownlist').niceSelect();
                    }
                });
            $('#jsscript').html(response);
            $('#jsscript').modal('show');

        }
    });
}
function deleteCart() {
    swal({
            title: "",
            text: "Bạn có chắc muốn xóa giỏ hàng?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "XÓA",
            cancelButtonText: "HỦY",
            showLoaderOnConfirm: true,
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                setTimeout(function () {
                    $.ajax({
                        type: "GET",
                        url: '/mvc/controller/ajax/cart.php?action=emtyCart',
                        dataType: "json",
                        success: function (response) {
                            swal({
                                title: "",
                                text: "XÓA GIỎ HÀNG THÀNH CÔNG!",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                                    $('.simpleCart_total').html('0 VNĐ');
                                    $('.simpleCart_quantity').html('0');
                                    $('#total-item').html('(0)');
                                    $('.cart-header').remove();
                                    $('#price-details').remove();
                                    $('.cart-items').append('<div>Không có thông tin sản phẩm</div>');
                                    $('#cartEmty').hide();
                        }
                    });
                }, 1500);
            }
        });
}
function deleteProduct(id,manuid) {
    swal({
            title: "",
            text: "Bạn có chắc muốn xóa sản phẩm "+manuid+" ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "XÓA",
            cancelButtonText: "HỦY",
            showLoaderOnConfirm: true,
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                setTimeout(function () {
                    $('#close-' + id).fadeOut('slow', function (c) {
                        $('#cart-header-' + id).remove();
                        $.ajax({
                            type: "GET",
                            url: '/mvc/controller/ajax/cart.php?action=del&idProduct=' + id,
                            dataType: "json",
                            success: function (response) {
                                swal({
                                    title: "",
                                    text: "XÓA SẢN PHẨM " + manuid + " THÀNH CÔNG!",
                                    type: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                if(response.total_item=='0') {
                                    $('.simpleCart_total').html('0 VNĐ');
                                    $('.simpleCart_quantity').html('0');
                                    $('#total-item').html('(0)');
                                    $('#price-details').remove();
                                    $('.cart-items').append('<div>Không có thông tin sản phẩm</div>');
                                    $('#cartEmty').hide();
                                }else{
                                    $('.simpleCart_quantity').html(response.total_item);
                                    $('.simpleCart_total').html(response.total_order);
									$('#total-item').html('('+response.total_item+')');
                                    $('#last_price').html(response.total_order);
                                    $('#total1').html(response.total_order);
                                }
                            }
                        });
                    });
                }, 800);
            }
        });
}
function updateTotalPriceProduct(idProduct, price) {
    var idFieldTotalMoney = 'priceProduct-' + idProduct;
    var qty = $('#Qty-' + idProduct);
    var quantity = qty.val();
    quantity = parseInt(quantity, 10);
    var totalMoney = quantity * price;
    $('#' + idFieldTotalMoney).empty();
    totalMoney = addCommas(totalMoney + '');
    $('#' + idFieldTotalMoney).append(totalMoney).append('VNĐ');
    $.ajax({
        type: "GET",
        url: '/mvc/controller/ajax/cart.php?action=update&idProduct=' + idProduct+'&qty='+quantity,
        dataType: "json",
        success: function (response) {
            $('.simpleCart_quantity').html(response.total_item);
            $('.simpleCart_total').html(response.total_order);
            $('#last_price').html(response.total_order);
            $('#total1').html(response.total_order);
        }
    });
}
function checkEmptyToOneDetail(idOrderItem) {
    var qty = $('#' + idOrderItem);
    var quantity = qty.val();
    if (quantity == "" || quantity <= 0 || !$.isNumeric(quantity)) {
        quantity = "1"
        qty.val(quantity);
    }else{
        qty.val(quantity);
    }
}
function checkEmptyToOne(idOrderItem, price) {
    var qty = $('#Qty-' + idOrderItem);
    var quantity = qty.val();
    if (quantity == "" || quantity <= 0 || !$.isNumeric(quantity)) {
        quantity = "1"
        qty.val(quantity);
        updateTotalPriceProduct(idOrderItem, price);
    }else{
        qty.val(quantity);
        updateTotalPriceProduct(idOrderItem, price);
    }
}
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function updateQuantity(idTextFieldQuantity, sortType) {
    var input = $('#' + idTextFieldQuantity);
    var value = input.val();
    if (value == "") {
        value = "0"
    }
    value = parseInt(value, 10);
    if (sortType == 'ASC') {
        if (value >= 99) {
            return;
        }
        value = value + 1;
    } else {
        if (value <= 1) {
            return;
        }
        value = value - 1;
    }
    input.val(value);
}
// Login Form
$(function () {
    var button = $('#loginButton');
    var box = $('#loginBox');
    var form = $('#loginForm');
    button.removeAttr('href');
    button.mouseup(function (login) {
        box.toggle();
        button.toggleClass('active');
    });
    form.mouseup(function () {
        return false;
    });
    $(this).mouseup(function (login) {
        if (!($(login.target).parent('#loginButton').length > 0)) {
            button.removeClass('active');
            box.hide();
        }
    });
});
jQuery.loadCSS = function (url) {
    if (!$('link[href="' + url + '"]').length)
        $('head').append('<link rel="stylesheet" type="text/css" href="' + url + '">');
}

