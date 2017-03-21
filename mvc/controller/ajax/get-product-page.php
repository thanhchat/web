<?php
function getCategoryId($array, $url)
{
    foreach ($array as $key => $value) {
        $arr = explode('/', $value['URL']);
        if ($arr[count($arr) - 1] == $url)
            return $value['MENU_ID'];
    }
    return 0;
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

include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../../functions/function.php");
include_once("../../../mvc/model/product.php");
include_once("../../../mvc/model/category.php");
$objCategory = new category();
$objProduct = new Product();
if (isset($_POST['start'])) {
    $start = $_POST['start'];
    $end = $_POST['end'];
    $textCate = $_POST['category'];
    $sort = $_POST['sort'];
    $delay = $_POST['delay'];
    $array = array();
    $arrayMenu = $objCategory->getAllListCategory(CATEGORY_PRODUCT_ID, $array);
    $idCategory = getCategoryId($arrayMenu, $textCate);
    $filterCategory = $objCategory->filterCategory();
    if ($idCategory > 0) {
        $arrayT = array();
        $arrayCategoryId = $objCategory->getAllListCategory($idCategory, $arrayT);
        if (count(getCategoryById($filterCategory, $idCategory)) > 0) {
            $v = getCategoryById($filterCategory, $idCategory);
            $categoryParent = array("MENU_ID" => $v['MENU_ID'], "NAME" => $v['NAME'], "PARENTS" => $v['PARENTS'], "LEVEL" => $v['LEVEL'], "ORDERING" => ($v['ORDERING'] != null) ? $v['ORDERING'] : "", "ENABLED" => $v['ENABLED'], "URL" => ($v['URL'] != null) ? $v['URL'] : "", "IMAGE" => ($v['IMAGE'] != null) ? $v['IMAGE'] : "");
            array_push($arrayCategoryId, $categoryParent);
        }
        $arrayCateid = array();
        foreach ($arrayCategoryId as $k => $v) {
            array_push($arrayCateid, $v['MENU_ID']);
        }
        $listProduct = array();
        $arrayProduct = $objProduct->getListProductCategortyByArray($arrayCateid, $start, $end,$sort);
        if (count($arrayProduct) > 0) {
            foreach ($arrayProduct as $k1 => $product) {
                $priceDefault = 0;
                $priceSale = 0;
                $featureCheck = 0;
                if (count($product['PRICE']) > 0) {
                    usort($product['PRICE'], function ($a, $b) {
                        return $a['PRICE'] - $b['PRICE'];
                    });
                    foreach ($product['PRICE'] as $k2 => $pPrice) {
                        if ($pPrice['PRODUCT_PRICE_TYPE_ID'] == 'LIST_PRICE' && $pPrice['TERM_UOM_ID'] == -1){
                            $priceDefault = $pPrice['PRICE'];
						}
                        if ($pPrice['PRODUCT_PRICE_TYPE_ID'] == 'PROMO_PRICE' && $pPrice['TERM_UOM_ID'] == -1)
						{
                            $priceSale = $pPrice['PRICE'];
						}
                        $dT = getPriceByFeature($pPrice['TERM_UOM_ID'], 'LIST_PRICE', $product['PRICE']);
                        $sT = getPriceByFeature($pPrice['TERM_UOM_ID'], 'PROMO_PRICE', $product['PRICE']);
                        if ($dT != null && $sT != null && $pPrice['TERM_UOM_ID'] != -1) {
                            $priceDefault = $dT['PRICE'];
                            $priceSale = $sT['PRICE'];
                            $featureCheck = 1;
                            break;
                        }
                    }
                    if ($featureCheck == 0) {
                        foreach ($product['PRICE'] as $k2 => $pPrice) {
                            $dT = getPriceByFeature($pPrice['TERM_UOM_ID'], 'LIST_PRICE', $product['PRICE']);
                            if (null != $dT && $pPrice['TERM_UOM_ID'] != -1) {
                                $priceDefault = $dT['PRICE'];
                                break;
                            }
                        }
                    }
                }
                array_push($listProduct, array('URL' => $product['PRODUCT']['URL'], 'SMALL_IMAGE_URL' => $product['PRODUCT']['SMALL_IMAGE_URL'], 'PRODUCT_ID' => $product['PRODUCT']['PRODUCT_ID'], 'PRODUCT_NAME' => $product['PRODUCT']['PRODUCT_NAME'], 'DESCRIPTION' => $product['PRODUCT']['DESCRIPTION'], 'PRODUCT_PRICE_D' => $priceDefault, 'PRODUCT_PRICE_S' => $priceSale));
            }
        }
		if('SORT_PRICE_INCREASE'==$sort){
			 usort($listProduct, function ($a, $b) {
						if($a['PRODUCT_PRICE_S']!=0&&$b['PRODUCT_PRICE_S']!=0){
							if ($a['PRODUCT_PRICE_S'] == $b['PRODUCT_PRICE_S'])
							{
								return 0;
							}

							return ($a['PRODUCT_PRICE_S']<$b['PRODUCT_PRICE_S']) ? -1 : 1;
						}
						if($a['PRODUCT_PRICE_S']!=0&&$b['PRODUCT_PRICE_S']==0){
							if ($a['PRODUCT_PRICE_S'] == $b['PRODUCT_PRICE_D'])
							{
								return 0;
							}

							return ($a['PRODUCT_PRICE_S']<$b['PRODUCT_PRICE_D']) ? -1 : 1;
						}
						if($a['PRODUCT_PRICE_S']==0&&$b['PRODUCT_PRICE_S']!=0){
							if ($a['PRODUCT_PRICE_D'] == $b['PRODUCT_PRICE_S'])
							{
								return 0;
							}

							return ($a['PRODUCT_PRICE_D']<$b['PRODUCT_PRICE_S']) ? -1 : 1;
						}
						if($a['PRODUCT_PRICE_S']==0&&$b['PRODUCT_PRICE_S']==0){
							if ($a['PRODUCT_PRICE_D'] == $b['PRODUCT_PRICE_D'])
							{
								return 0;
							}

							return ($a['PRODUCT_PRICE_D']<$b['PRODUCT_PRICE_D']) ? -1 : 1;
						}
             });
		}
		if('SORT_PRICE_DECREASE'==$sort){
			usort($listProduct, function ($a, $b) {
						if($a['PRODUCT_PRICE_S']!=0&&$b['PRODUCT_PRICE_S']!=0){
							if ($a['PRODUCT_PRICE_S'] == $b['PRODUCT_PRICE_S'])
							{
								return 0;
							}

							return ($a['PRODUCT_PRICE_S']>$b['PRODUCT_PRICE_S']) ? -1 : 1;
						}
						if($a['PRODUCT_PRICE_S']!=0&&$b['PRODUCT_PRICE_S']==0){
							if ($a['PRODUCT_PRICE_S'] == $b['PRODUCT_PRICE_D'])
							{
								return 0;
							}

							return ($a['PRODUCT_PRICE_S']>$b['PRODUCT_PRICE_D']) ? -1 : 1;
						}
						if($a['PRODUCT_PRICE_S']==0&&$b['PRODUCT_PRICE_S']!=0){
							if ($a['PRODUCT_PRICE_D'] == $b['PRODUCT_PRICE_S'])
							{
								return 0;
							}

							return ($a['PRODUCT_PRICE_D']>$b['PRODUCT_PRICE_S']) ? -1 : 1;
						}
						if($a['PRODUCT_PRICE_S']==0&&$b['PRODUCT_PRICE_S']==0){
							if ($a['PRODUCT_PRICE_D'] == $b['PRODUCT_PRICE_D'])
							{
								return 0;
							}

							return ($a['PRODUCT_PRICE_D']>$b['PRODUCT_PRICE_D']) ? -1 : 1;
						}
             });
		}
        foreach ($listProduct as $k => $product) {
            $delay = $delay + 0.1;
            $img = split('@@@', $product['SMALL_IMAGE_URL']);
            $imgName = '';
            if (count($img > 0))
                $imgName = $img[1];
			$datap='data-price='.$product['PRODUCT_PRICE_D'];
			if($product['PRODUCT_PRICE_S']>0)
				$datap='data-price='.$product['PRODUCT_PRICE_S'];
            echo '<li '.$datap.' class="wow fadeIn animated" data-wow-delay="' . $delay . 's">
									<div class="cbp-vm-image"><a title="' . $product['PRODUCT_NAME'] . '" href="' . $product['URL'] . '/' . convertStringAndId($product['PRODUCT_NAME'], $product['PRODUCT_ID'], '.html') . '">
									<img src="/public/product/' . $product['PRODUCT_ID'] . '/medium/' . $imgName . '" alt="' . $product['PRODUCT_NAME'] . '"></a>
									</div>
									<div></div>
									<div class="product_container">
										<div class="cbp-vm-title">
											<a title="' . $product['PRODUCT_NAME'] . '" href="' . $product['URL'] . '/' . convertStringAndId($product['PRODUCT_NAME'], $product['PRODUCT_ID'], '.html') . '">' . cut_string($product['PRODUCT_NAME'], 18) . '</a>
										</div>
										<div class="list-title">
											<a title="'.$product['PRODUCT_NAME'].'" href="'.$product['URL'].'/'.convertStringAndId($product['PRODUCT_NAME'],$product['PRODUCT_ID'],'.html').'">'.$product['PRODUCT_NAME'].'</a>
										</div>
										<div class="clearfix"></div>
										<div class="cbp-vm-price">';
            if ($product['PRODUCT_PRICE_S'] > 0) {
                echo '<ins>' . number_format($product['PRODUCT_PRICE_S']) . ' VNĐ</ins>
														<del>' . number_format($product['PRODUCT_PRICE_D']) . ' VNĐ</del>';
            } else {
                echo '<ins>' . number_format($product['PRODUCT_PRICE_D']) . ' VNĐ</ins>';
            }
            echo '</div>
					<div class="clearfix"></div>
					<div class="clearfix"></div>
						<div><a onclick="showProduct(' . $product['PRODUCT_ID'] . ');" class="cbp-vm-icon cbp-vm-add item_add">THÊM VÀO GIỎ HÀNG</a></div>
					</div>';
						if($k<count($listProduct)-1)
							echo '<div class="lineListView"></div>';
			 echo '</li>';
        }
    }

}