<?php
function getCategoryById($array,$idCategory){
	 foreach ($array as $key => $value) {
		if($value['MENU_ID']==$idCategory)
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
$title='LunShop';
$cssHome=1;
$jsHome=1;
include_once("mvc/model/category.php");
include_once("mvc/model/Product.php");
$objCategory = new category();
$objProduct = new Product();
$array=array();
$arrayProductSlide=array();
$ProductSlide=array();
$ProductCountCategory=array();
$ProductCategoryHome=array();
$arrayCategoryHome=$objCategory->getAllListCategory(CATEGORY_PRODUCT_HOME_ID,$array);
$arrayCategoryProduct=$arrayMenuProduct;//$arrayMenuProduct trong home
if(count($arrayCategoryHome)>0){
	$arrayProductSlide=$objProduct->getListProductCategortyHome($arrayCategoryHome[0]['MENU_ID']);
	if(count($arrayProductSlide)>0){
		foreach($arrayProductSlide as $k=>$pSlide){
			//$productPrice=$objProduct->getListProductPriceByIdProduct($pSlide['PRODUCT_ID']);
			$priceDefault=0;
			$priceSale=0;
			$featureCheck=0;
			
			if(count($pSlide['PRICE'])>0){
				usort($pSlide['PRICE'], function($a, $b) {
					return $a['PRICE'] - $b['PRICE'];
				});
				foreach($pSlide['PRICE'] as $k1=>$pPrice){
					if($pPrice['PRODUCT_PRICE_TYPE_ID']=='LIST_PRICE'&&$pPrice['TERM_UOM_ID']==-1)
						$priceDefault=$pPrice['PRICE'];
					if($pPrice['PRODUCT_PRICE_TYPE_ID']=='PROMO_PRICE'&&$pPrice['TERM_UOM_ID']==-1)
						$priceSale=$pPrice['PRICE'];
					$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$pSlide['PRICE']);
					$sT=getPriceByFeature($pPrice['TERM_UOM_ID'],'PROMO_PRICE',$pSlide['PRICE']);
					if($dT!=null&&$sT!=null&&$pPrice['TERM_UOM_ID']!=-1){
						$priceDefault=$dT['PRICE'];
						$priceSale=$sT['PRICE'];
						$featureCheck=1;
						break;
					}
				}
				if($featureCheck==0){
						foreach($pSlide['PRICE'] as $k2=>$pPrice){
							$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$pSlide['PRICE']);
							if(null!=$dT&&$pPrice['TERM_UOM_ID']!=-1){
								$priceDefault=$dT['PRICE'];
								break;
							}
						}
				}
			}
			//$url=getCategoryById($filterCategory,$pSlide['PRODUCT']['PRODUCT_CATEGORY_ID']);//$filterCategory trong homecontroller
			$ProductSlide[]=array('URL' => $pSlide['PRODUCT']['URL'],'SMALL_IMAGE_URL'=>$pSlide['PRODUCT']['SMALL_IMAGE_URL'],'PRODUCT_ID'=>$pSlide['PRODUCT']['PRODUCT_ID'],'PRODUCT_NAME'=>$pSlide['PRODUCT']['PRODUCT_NAME'],'PRODUCT_PRICE_D'=>$priceDefault,'PRODUCT_PRICE_S'=>$priceSale);
		}
	}
	unset($arrayCategoryHome[0]);
	if(count($arrayCategoryHome)>0){
		foreach($arrayCategoryHome as $k=>$pHome){
			$ProductTemp=array();
			$arrayProductHome=$objProduct->getListProductCategortyHome($pHome['MENU_ID']);
			if(count($arrayProductHome)>0){
				foreach($arrayProductHome as $k1=>$product){
					$priceDefault=0;
					$priceSale=0;
					$featureCheck=0;
					if(count($product['PRICE'])>0){
						usort($product['PRICE'], function($a, $b) {
						return $a['PRICE'] - $b['PRICE'];
						});
						foreach($product['PRICE'] as $k2=>$pPrice){
							if($pPrice['PRODUCT_PRICE_TYPE_ID']=='LIST_PRICE'&&$pPrice['TERM_UOM_ID']==-1)
								$priceDefault=$pPrice['PRICE'];
							if($pPrice['PRODUCT_PRICE_TYPE_ID']=='PROMO_PRICE'&&$pPrice['TERM_UOM_ID']==-1)
								$priceSale=$pPrice['PRICE'];
							$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$product['PRICE']);
							$sT=getPriceByFeature($pPrice['TERM_UOM_ID'],'PROMO_PRICE',$product['PRICE']);
							if($dT!=null&&$sT!=null&&$pPrice['TERM_UOM_ID']!=-1){
								$priceDefault=$dT['PRICE'];
								$priceSale=$sT['PRICE'];
								$featureCheck=1;
								break;
							}
						}
					}
					
					/*foreach($product['PRICE'] as $k2=>$pPrice){
						$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$product['PRICE']);
						$sT=getPriceByFeature($pPrice['TERM_UOM_ID'],'PROMO_PRICE',$product['PRICE']);
						if($dT!=null&&$sT!=null&&$pPrice['TERM_UOM_ID']!=-1){
							$priceDefault=$dT['PRICE'];
							$priceSale=$sT['PRICE'];
							$featureCheck=1;
							break;
						}
					}*/
					if($featureCheck==0){
						foreach($product['PRICE'] as $k2=>$pPrice){
							$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$product['PRICE']);
								if(null!=$dT&&$pPrice['TERM_UOM_ID']!=-1){
									$priceDefault=$dT['PRICE'];
									break;
								}
						}
					}
					//$url=getCategoryById($filterCategory,$product['PRODUCT']['PRODUCT_CATEGORY_ID']);//$filterCategory trong homecontroller
					$ProductTemp[]=array('URL' => $product['PRODUCT']['URL'],'SMALL_IMAGE_URL'=>$product['PRODUCT']['SMALL_IMAGE_URL'],'PRODUCT_ID'=>$product['PRODUCT']['PRODUCT_ID'],'PRODUCT_NAME'=>$product['PRODUCT']['PRODUCT_NAME'],'PRODUCT_PRICE_D'=>$priceDefault,'PRODUCT_PRICE_S'=>$priceSale);
				}
				array_push($ProductCategoryHome,array('TITLE'=>$pHome['NAME'],'LIST-PRODUCT'=>$ProductTemp));
			}
		}
	}
}
//var_dump($ProductCategoryHome[0]['LIST-PRODUCT'][0]['PRICE']);
if(count($arrayCategoryProduct)>0){
	foreach($arrayCategoryProduct as $k=>$category){
		$arrayT=array();
		$arrayTemp=$objCategory->getAllListCategory($category['MENU_ID'],$arrayT);
		if(null==$arrayTemp&&count($arrayTemp)==0){
			array_push($arrayTemp,$category);
		}
		$count=0;
		foreach($arrayTemp as $kt=>$categoryT)
			$count+=$objProduct->countProductByIdcategory($categoryT['MENU_ID']);
		$ProductCountCategory[]=array('IMAGE'=>$category['IMAGE'],'COUNT'=>$count,'NAME'=>$category['NAME'],'URL'=>$category['URL']);
	}
}
$view = 'mvc/view/home/index.phtml';