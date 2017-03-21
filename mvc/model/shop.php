<script>
    function getProductFeature() {
        var str = '';
        <?php foreach($arrayFeature['listFeatureType'] as $k=>$featureType){?>
        str += $('#<?=$featureType['PRODUCT_FEATURE_TYPE_ID']?>').val() + '@';
        <?php }?>
        str = str.replace(/@*$/, "");
        $.ajax({
            type: "GET",
            url: '/mvc/controller/ajax/get-product-price.php?idProduct=<?=$detailP;?>&feature=' + str,
            dataType: "text",
            success: function (response) {
                $('#price').html(response);
            }
        });
    }
    $('.add-to-cart').click(function () {
        var str = '';
        <?php foreach($arrayFeature['listFeatureType'] as $k=>$featureType){?>
        str += $('#<?=$featureType['PRODUCT_FEATURE_TYPE_ID']?>').val() + '@';
        <?php }?>
        str = str.replace(/@*$/, "");
        if (str == '')
            str = '-1';
        var quantity = $('#qty').val();
        $.ajax({
            type: "GET",
            url: '/mvc/controller/ajax/cart.php?idProduct=<?=$detailP;?>&feature_add=' + str + '&qty=' + quantity + '&action=add',
            dataType: "json",
            beforeSend: function (jqXHR, options) {
                var cart = $('#imgCart');
                var imgtofly = $('.etalage_smallthumb_active').find('img').eq(0);
                if (imgtofly.length == 0) {
                    imgtofly = $('.etalage_thumb_active').find('img').eq(0);
                    imgtofly.removeClass('etalage_thumb_image');
                }
                if (imgtofly) {
                    var imgclone = imgtofly.clone()
                        .offset({top: imgtofly.offset().top, left: imgtofly.offset().left})
                        .css({
                            'position': 'absolute',
                            'height': '150px',
                            'width': '150px',
                            'z-index': '1000',
                            'border-radius': '50%'
                        })
                        .appendTo($('body'))
                        .animate({
                            'top': cart.offset().top + 10,
                            'left': cart.offset().left + 30,
                            'width': 55,
                            'height': 55
                        }, 1000, 'easeInCubic');
                    imgclone.animate({'width': 0, 'height': 0}, function () {
                        $(this).detach()
                    });
                }
                setTimeout(function () {
                    // null beforeSend to prevent recursive ajax call
                    $.ajax($.extend(options, {beforeSend: $.noop}));
                }, 1200);
                return false;
            },
            success: function (response) {
                if (response.error == '1') {
                    swal({
                        title: "",
                        text: "LỖI THÊM VÀO GIỎ HÀNG!",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    swal({
                        title: "",
                        text: "THÊM VÀO GIỎ HÀNG THÀNH CÔNG!",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('.simpleCart_total').html(response.total_order);
                    $('.simpleCart_quantity').html(response.total_item);
                    $('#qty').val(1);
                    $('#cartEmty').show();
                }
            }
        });
        return false;
    });
	$('#buyNow').click(function () {
        var str = '';
        <?php foreach($arrayFeature['listFeatureType'] as $k=>$featureType){?>
        str += $('#<?=$featureType['PRODUCT_FEATURE_TYPE_ID']?>').val() + '@';
        <?php }?>
        str = str.replace(/@*$/, "");
        if (str == '')
            str = '-1';
        var quantity = $('#qty').val();
        $.ajax({
            type: "GET",
            url: '/mvc/controller/ajax/cart.php?idProduct=<?=$detailP;?>&feature_add=' + str + '&qty=' + quantity + '&action=add',
            dataType: "json",
            success: function (response) {
                if (response.error == '1') {
                    swal({
                        title: "",
                        text: "LỖI THÊM VÀO GIỎ HÀNG!",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
						$('.simpleCart_total').html(response.total_order);
						$('.simpleCart_quantity').html(response.total_item);
						$('#qty').val(1);
						$('#cartEmty').show();
						window.location = "/gio-hang";
					} 
                }
        });
        return false;
    });
</script>
