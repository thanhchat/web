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
function getPriceByFeature($feature,$type,$arrayPrice){
	foreach($arrayPrice as $k=>$pPrice){
		if($pPrice['PRODUCT_PRICE_TYPE_ID']==$type&&$pPrice['TERM_UOM_ID']==$feature)
			return $pPrice;
	}
	return null;
}
function checkProduct($arr,$idProduct){
	$count=0;
	foreach($arr as $k=>$v){
		if($v['PRODUCT']["PRODUCT_ID"]==$idProduct)
			$count++;
	}
	return $count;
}
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../../functions/function.php");
include_once("../../../mvc/model/product.php");
include_once("../../../mvc/model/category.php");
$objCategory = new category();
$objProduct = new Product();
if (isset($_POST['filter1'])||isset($_POST['filterColor'])) {
	$arrayP = array();
	$arrayMenu = $objCategory->getAllListCategory(CATEGORY_PRODUCT_ID, $arrayP);
    $filter1 = $_POST['filter1'];
    $filterColor = $_POST['filterColor'];
    $textCate = $_POST['category'];
	$delay=0;
    $arrayProductFilter1 = array();
    $arrayProductFilterColor = array();
	$ProductFilter=array();
	$finalFilter=array();
	$idCategory = getCategoryId($arrayMenu,  $textCate);
	$arrayCateid=array();
	if($idCategory>0){
		$arrayT = array();
		$filterCategory = $objCategory->filterCategory();
		$arrayCategoryId = $objCategory->getAllListCategory($idCategory, $arrayT);
		if (count(getCategoryById($filterCategory, $idCategory)) > 0) {
			$v = getCategoryById($filterCategory, $idCategory);
			$categoryParent = array("MENU_ID" => $v['MENU_ID'], "NAME" => $v['NAME'], "PARENTS" => $v['PARENTS'], "LEVEL" => $v['LEVEL'], "ORDERING" => ($v['ORDERING'] != null) ? $v['ORDERING'] : "", "ENABLED" => $v['ENABLED'], "URL" => ($v['URL'] != null) ? $v['URL'] : "", "IMAGE" => ($v['IMAGE'] != null) ? $v['IMAGE'] : "");
			array_push($arrayCategoryId, $categoryParent);
		}
		foreach ($arrayCategoryId as $k => $v) {
			array_push($arrayCateid,$v['MENU_ID']);
		}
	}
	if($filter1!=-1)
		$arrayProductFilter1=$objProduct->getListProductCategortyHome($filter1);
	if($filterColor!=-1)
		$arrayProductFilterColor=$objProduct->getListProductCategortyHome($filterColor);
	if($filter1==0){
		$arrayProductFilter1=$objProduct->getListProductCategortyByArrayAll($arrayCateid);
		$finalFilter=$arrayProductFilter1;
	}
	if($filter1!=0&&$filter1!=-1&&$filterColor!=-1){
		foreach($arrayProductFilter1 as $k=>$v){
			if(in_array($v['PRODUCT']["PRODUCT_CATEGORY_ID_PARENT"],$arrayCateid))
					array_push($finalFilter,$v);
		}
		foreach($arrayProductFilterColor as $k=>$v){
			if(in_array($v['PRODUCT']["PRODUCT_CATEGORY_ID_PARENT"],$arrayCateid))
					array_push($finalFilter,$v);
		}
		foreach($finalFilter as $k=>$p){
			if(checkProduct($finalFilter,$p['PRODUCT']["PRODUCT_ID"])<2)
				unset($finalFilter[$k]);
		}
		foreach($finalFilter as $k=>$p){
			if(checkProduct($finalFilter,$p['PRODUCT']["PRODUCT_ID"])>1)
				unset($finalFilter[$k]);
		}
		//$finalFilter=array_unique($finalFilter);
	}
	
	if($filter1!=0&&$filter1!=-1&&$filterColor==-1){
		foreach($arrayProductFilter1 as $k=>$v){
			if(in_array($v['PRODUCT']["PRODUCT_CATEGORY_ID_PARENT"],$arrayCateid))
					array_push($finalFilter,$v);
		}	
	}
	if($filter1==-1&&$filterColor!=-1){
		foreach($arrayProductFilterColor as $k=>$v){
			if(in_array($v['PRODUCT']["PRODUCT_CATEGORY_ID_PARENT"],$arrayCateid))
					array_push($finalFilter,$v);
		}
	}
	
	//var_dump($finalFilter);
	if(count($finalFilter)>0){
		foreach($finalFilter as $k=>$pFilter){
			$priceDefault=0;
			$priceSale=0;
			$featureCheck=0;
			
			if(count($pFilter['PRICE'])>0){
				usort($pFilter['PRICE'], function($a, $b) {
					return $a['PRICE'] - $b['PRICE'];
				});
				foreach($pFilter['PRICE'] as $k1=>$pPrice){
					if($pPrice['PRODUCT_PRICE_TYPE_ID']=='LIST_PRICE'&&$pPrice['TERM_UOM_ID']==-1)
						$priceDefault=$pPrice['PRICE'];
					if($pPrice['PRODUCT_PRICE_TYPE_ID']=='PROMO_PRICE'&&$pPrice['TERM_UOM_ID']==-1)
						$priceSale=$pPrice['PRICE'];
					$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$pFilter['PRICE']);
					$sT=getPriceByFeature($pPrice['TERM_UOM_ID'],'PROMO_PRICE',$pFilter['PRICE']);
					if($dT!=null&&$sT!=null&&$pPrice['TERM_UOM_ID']!=-1){
						$priceDefault=$dT['PRICE'];
						$priceSale=$sT['PRICE'];
						$featureCheck=1;
						break;
					}
				}
				if($featureCheck==0){
						foreach($pFilter['PRICE'] as $k2=>$pPrice){
							$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$pFilter['PRICE']);
							if(null!=$dT&&$pPrice['TERM_UOM_ID']!=-1){
								$priceDefault=$dT['PRICE'];
								break;
							}
						}
				}
			}
			$ProductFilter[]=array('URL' => $pFilter['PRODUCT']['URL'],'SMALL_IMAGE_URL'=>$pFilter['PRODUCT']['SMALL_IMAGE_URL'],'PRODUCT_ID'=>$pFilter['PRODUCT']['PRODUCT_ID'],'PRODUCT_NAME'=>$pFilter['PRODUCT']['PRODUCT_NAME'],'PRODUCT_PRICE_D'=>$priceDefault,'PRODUCT_PRICE_S'=>$priceSale);
		}
		foreach ($ProductFilter as $k => $product) {
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
						if($k<count($ProductFilter)-1)
							echo '<div class="lineListView"></div>';
			 echo '</li>';
        }
	}
}