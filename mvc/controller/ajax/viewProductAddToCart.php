<?php
/**
 * Created by PhpStorm.
 * User: thanhchat
 * Date: 07/01/2017
 * Time: 21:30
 */
 function getCategoryName($array, $url)
{
    foreach ($array as $key => $value) {
        $arr = explode('/', $value['URL']);
        if ($arr[count($arr) - 1] == $url)
            return $value['NAME'];
    }
    return $url;
}

function getCategoryById($array, $idCategory)
{
    foreach ($array as $key => $value) {
        if ($value['MENU_ID'] == $idCategory)
            return $value;
    }
    return null;
}

function getPriceByFeature($feature, $type, $arrayPrice)
{
    foreach ($arrayPrice as $k => $pPrice) {
        if ($pPrice['PRODUCT_PRICE_TYPE_ID'] == $type && $pPrice['TERM_UOM_ID'] == $feature)
            return $pPrice;
    }
    return null;
}

function contains($haystack, $needle)
{
    return strpos($haystack, $needle) !== false;
}

function getProductByFeature($productJunior, $feature)
{
    foreach ($productJunior as $k2 => $junior) {
        if (contains($junior['FEATURE_ID'], $feature))
            return $junior;
    }
    return null;
}

function coutImage($productJunior, $feature)
{
    foreach ($productJunior as $k2 => $junior) {
        if (contains($junior['FEATURE_ID'], $feature)) {
            $img = explode('@@@', $junior['SMALL_IMAGE_URL']);
            if (count($img > 0)) {
                unset($img[0]);
            }
            return count($img);
        }
    }
    return -1;
}

function getCategoryId($array, $url)
{
    foreach ($array as $key => $value) {
        $arr = explode('/', $value['URL']);
        if ($arr[count($arr) - 1] == $url)
            return $value['MENU_ID'];
    }
    return 0;
}
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../../mvc/model/product.php");
include_once("../../../mvc/model/feature.php");
$objProduct = new Product();
$objFeature = new feature();
$arrayFeature['listFeature'] = array();
$arrayFeature['listFeatureType'] = array();
$idProduct = (isset($_GET['idProduct'])) ? $_GET['idProduct'] : 0;
if (is_numeric($idProduct) && $idProduct >= 15062016) {//chi tiet san pham
    $cssProductDetail = 1;
    $jsProductDetail = 1;
    $productDetail = $objProduct->getProductById($idProduct);
    if (count($productDetail) > 0 && $productDetail != null) {
        $priceDefault = 0;
        $priceSale = 0;
        $select = 0;
        if (count($productDetail[0]['PRICE']) > 0) {
            foreach ($productDetail[0]['PRICE'] as $k2 => $pPrice) {
                if ($pPrice['PRODUCT_PRICE_TYPE_ID'] == 'LIST_PRICE' && $pPrice['TERM_UOM_ID'] == -1)
                    $priceDefault = $pPrice['PRICE'];
                if ($pPrice['PRODUCT_PRICE_TYPE_ID'] == 'PROMO_PRICE' && $pPrice['TERM_UOM_ID'] == -1)
                    $priceSale = $pPrice['PRICE'];
            }
        }
        $featureTypeLoad = explode('@', $productDetail[0]['PRODUCT']['FEATURE_TYPE_ID']);
        $featureLoad = explode('@', $productDetail[0]['PRODUCT']['FEATURE_ID']);
        $checkCountFeature = 0;
        if (count($featureTypeLoad) > 0 && count($featureLoad) > 0) {
            foreach ($featureTypeLoad as $k => $v) {
                if ($v != "") {
                    $checkCountFeature++;
                    $arrayFeatureTypeName = $objFeature->getFeatureTypeById($v);
                    $stack = array('DESCRIPTION_FEATURE_TYPE' => $arrayFeatureTypeName[0]['DESCRIPTION_FEATURE_TYPE'], 'PRODUCT_FEATURE_TYPE_ID' => $arrayFeatureTypeName[0]['PRODUCT_FEATURE_TYPE_ID']);
                    array_push($arrayFeature['listFeatureType'], $stack);
                }
            }
            foreach ($featureLoad as $k => $v) {
                if ($v != "") {
                    $arrayFeatureId = explode(':', $v);
                    $arrayFeature['listFeature'][$k] = array();
                    foreach ($arrayFeatureId as $key => $value) {
                        $arrayFeatureName = $objFeature->getFeatureId($value);
                        $stack = array('PRODUCT_FEATURE_ID' => $arrayFeatureName[0]['PRODUCT_FEATURE_ID'], 'DESCRIPTION_FEATURE' => $arrayFeatureName[0]['DESCRIPTION_FEATURE'], 'COMMENT' => $arrayFeatureName[0]['COMMENT']);
                        array_push($arrayFeature['listFeature'][$k], $stack);
                    }
                }
            }
            $featureCheck = 0;
            usort($productDetail[0]['PRICE'], function ($a, $b) {
                return $a['PRICE'] - $b['PRICE'];
            });
            foreach ($productDetail[0]['PRICE'] as $k2 => $pPrice) {
                $dT = getPriceByFeature($pPrice['TERM_UOM_ID'], 'LIST_PRICE', $productDetail[0]['PRICE']);
                $sT = getPriceByFeature($pPrice['TERM_UOM_ID'], 'PROMO_PRICE', $productDetail[0]['PRICE']);
                if ($dT != null && $sT != null && $pPrice['TERM_UOM_ID'] != -1) {
                    $priceDefault = $dT['PRICE'];
                    $select = $dT['TERM_UOM_ID'];
                    $priceSale = $sT['PRICE'];
                    $featureCheck = 1;
                    break;
                }
            }
            if ($featureCheck == 0) {
                foreach ($productDetail[0]['PRICE'] as $k2 => $pPrice) {
                    $dT = getPriceByFeature($pPrice['TERM_UOM_ID'], 'LIST_PRICE', $productDetail[0]['PRICE']);
                    if (null != $dT && $pPrice['TERM_UOM_ID'] != -1) {
                        $priceDefault = $dT['PRICE'];
                        $select = $dT['TERM_UOM_ID'];
                        break;
                    }
                }
            }
        }
        $arrayImage = array();
        if (isset($productDetail['LIST-PRODUCT-JUNIOR']) && null != $productDetail['LIST-PRODUCT-JUNIOR']) {
            $productJunior = $productDetail['LIST-PRODUCT-JUNIOR'];
            foreach ($arrayFeature['listFeatureType'] as $k => $featureType) {
                foreach ($arrayFeature['listFeature'][$k] as $k1 => $feature) {
                    //echo $feature['DESCRIPTION_FEATURE'];
                    $featureTemp = getProductByFeature($productJunior, $feature['PRODUCT_FEATURE_ID']);
                    //var_dump($featureTemp);
                    if (null != $featureTemp) {
                        $img = explode('@@@', $featureTemp['SMALL_IMAGE_URL']);
                        if (count($img > 0)) {
                            unset($img[0]);
                            foreach ($img as $k => $image) {
                                $lag = 0;
                                foreach ($arrayImage as $k => $valueImg) {
                                    if ($valueImg == $image) {
                                        $lag = 1;
                                    }
                                }
                                if ($lag == 0) {
                                    array_push($arrayImage, $image);
                                }
                            }
                        }
                    }
                }
            }
        }
        $showImg =-1;
	}
	
	echo'
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
	  <div class="clearfix"></div>
        <p>
<div class="col-md-12 col-sm-12">
                <div>
                    <div class=" images_3_of_2">
                        <ul id="etalage">';
								$img=split('@@@',$productDetail[0]['PRODUCT']['SMALL_IMAGE_URL']);
								if(count($img>0)){
								unset($img[0]);
								if(count($arrayImage)>0)
									$img=$arrayImage;
								foreach($img as $k=>$image){
                            echo'<li>
									<img class="etalage_thumb_image" src="/public/product/'.$productDetail[0]['PRODUCT']['PRODUCT_ID'].'/medium/'.$image.'" class="img-responsive" alt="">
                                    <a href="/public/product/'.$productDetail[0]['PRODUCT']['PRODUCT_ID'].'/medium/'.$image.'" title="'.mb_strtoupper($productDetail[0]['PRODUCT']['PRODUCT_NAME'],'utf-8').'">
									<img class="etalage_source_image" src="/public/product/'.$productDetail[0]['PRODUCT']['PRODUCT_ID'].'/medium/'.$image.'" class="img-responsive" title=""/>
									</a>
                            </li>';
							 }}
                        echo'</ul>
						<!--<div><button class="button-prev button1">Previous</button><button class="button-next button1">Next</button></div>-->
                        <div class="clearfix"></div>
                    </div>
                    <div class="desc1 span_3_of_2">
                        <h3>'.mb_strtoupper($productDetail[0]['PRODUCT']['PRODUCT_NAME'],'utf-8').'</h3>
                        <!--<span class="brand">Thương hiệu: <a href="#">NHT </a></span>-->
                        <span class="code">Mã sản phẩm: <pid>'.$productDetail[0]['PRODUCT']['MANUFACTURER_PARTY_ID'].'</pid></span>';
                        if($productDetail[0]['PRODUCT']['DESCRIPTION']!='') echo'<div class="line"></div><p>'.$productDetail[0]['PRODUCT']['DESCRIPTION'].'</p>';else echo'';
                       echo' <div class="line"></div>
                        <div id="price" class="price">';
							if($priceSale>0){
												echo'<span class="price-new">'.number_format($priceSale).' VNĐ</span><br>
												<span class="price-old">'.number_format($priceDefault).' VNĐ</span>';
											 }else{
												echo'<span class="price-new">'.number_format($priceDefault).' VNĐ</span>';
											 }
                            echo'<!--<span class="price-tax">Ex Tax: $90.00</span><br>
                            <span class="points"><small>Price in reward points: 400</small></span><br>-->
                        </div>
                        <div class="line"></div>
						
                        <span class="text">Tình trạng : </span>
                        <span class="product-status">Còn hàng</span>';
						 if(count($arrayFeature['listFeatureType'])>0){
                        echo'<div class="line"></div>
                        <div class="det_nav1">';
							 foreach($arrayFeature['listFeatureType'] as $k=>$featureType){
                            echo'<h4>CHỌN '.$featureType['DESCRIPTION_FEATURE_TYPE'].'</h4>
							<div class="clearfix"></div>
                            <div class=" sky-form col col-4">';
								echo'<select onchange="getProductFeature();" id="'.$featureType['PRODUCT_FEATURE_TYPE_ID'].'" class="dropdownlist wide">';
								$firt=1; foreach($arrayFeature['listFeature'][$k] as $k1=>$feature){
									$t=0;
									$t=$firt;
									$findShow='';
									$style='';
									if($feature['COMMENT']!='')
										$style='data-style="'.$feature['COMMENT'].'"';
									if($select==$feature['PRODUCT_FEATURE_ID']){
										if(in_array($featureType['PRODUCT_FEATURE_TYPE_ID'],$TYPE_SHOW_IMAGE)){
											$showImg=$t; 
											$findShow='findShow='.$t;
											if($k1==0)
												$findShow='findShow=1';
										}
										echo'<option '.$style.' selected '.$findShow.' value="'.$feature['PRODUCT_FEATURE_ID'].'">'.mb_strtoupper($feature['DESCRIPTION_FEATURE'],'utf-8').'</option>';
								 }else{
									$findShow='';
									if(in_array($featureType['PRODUCT_FEATURE_TYPE_ID'],$TYPE_SHOW_IMAGE)){	
											$findShow='findShow='.$t;
											if($k1==0)
												$findShow='findShow=1';
									}
									echo'<option '.$style.' '.$findShow.' value="'.$feature['PRODUCT_FEATURE_ID'].'">'.mb_strtoupper($feature['DESCRIPTION_FEATURE'],'utf-8').'</option>';
								 }
									$firt=coutImage($productJunior,$feature['PRODUCT_FEATURE_ID'])+$t;
								}
							echo '</select>
							<div class="clearfix"></div>
                            </div>';
							 }
                        echo'</div>';
						 }
						
                        echo' <div class="line"></div>
                        <div class="btn_form quantity-buy-detail">
                            <span class="txtcssQt">Số lượng</span> <input type="number" name="qty" id="qty" size="4" class="input-text qty text" title="Qty" value="1"
                                            min="1" step="1">
                            <button title="Thêm vào giỏ hàng" class="add-to-cart" href="#"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ
                                hàng</button>
                            <a title="Mua sản phẩm" class="buy-now" id="buyNow" href="#"><i class="fa fa-check"></i>Mua ngay</a>
                        </div>

                    </div>
					
                    <div class="clearfix"></div>
                </div>
                <div class="single-bottom1">
                    <h6>Chi tiết</h6>

                    <p class="prod-desc">'.$productDetail[0]['PRODUCT']['LONG_DESCRIPTION'].'</p>
                </div>
            </div>
			<input type="hidden" id="showImg" value="'.$showImg.'"/>
			<input type="hidden" id="countfeature" value="'.$checkCountFeature.'"/>
			<div class="clearfix"></div>
			</p>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ĐÓNG</button>
      </div>
    </div>

  </div>
			';
}?>
<script>
    function getProductFeature() {
        var str = '';
        <?php foreach($arrayFeature['listFeatureType'] as $k=>$featureType){?>
        str += $('#<?=$featureType['PRODUCT_FEATURE_TYPE_ID']?>').val() + '@';
        <?php }?>
        str = str.replace(/@*$/, "");
        $.ajax({
            type: "GET",
            url: '/mvc/controller/ajax/get-product-price.php?idProduct=<?=$idProduct;?>&feature=' + str,
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
            url: '/mvc/controller/ajax/cart.php?idProduct=<?=$idProduct;?>&feature_add=' + str + '&qty=' + quantity + '&action=add',
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
                    swal({
                        title: "",
                        text: "THÊM VÀO GIỎ HÀNG THÀNH CÔNG!",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    },function(){
						$('.simpleCart_total').html(response.total_order);
						$('.simpleCart_quantity').html(response.total_item);
						$('#qty').val(1);
						$('#cartEmty').show();
						window.location = "/gio-hang";
					});
                    
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
            url: '/mvc/controller/ajax/cart.php?idProduct=<?=$idProduct;?>&feature_add=' + str + '&qty=' + quantity + '&action=add',
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

