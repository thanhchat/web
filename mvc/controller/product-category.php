<?php
function getCategoryName($array,$url){
	 foreach ($array as $key => $value) {
		$arr=explode('/',$value['URL']);
		if($arr[count($arr)-1]==$url)
			return $value['NAME'];
	 }
	 return $url;
}
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
function contains($haystack,$needle)
{
    return strpos($haystack, $needle) !== false;
}
function getProductByFeature($productJunior,$feature){
	foreach($productJunior as $k2=>$junior){
		if(contains($junior['FEATURE_ID'],$feature))		
			return $junior;
	}
	return null;
}
function coutImage($productJunior,$feature){
	foreach($productJunior as $k2=>$junior){
		if(contains($junior['FEATURE_ID'],$feature)){
			$img=split('@@@',$junior['SMALL_IMAGE_URL']);
			if(count($img>0)){
				unset($img[0]);
			}
			return count($img);
		}			
	}
	return -1;
}
function getCategoryId($array,$url){
	 foreach ($array as $key => $value) {
		$arr=explode('/',$value['URL']);
		if($arr[count($arr)-1]==$url)
			return $value['MENU_ID'];
	 }
	 return 0;
}
include_once("mvc/model/category.php");
include_once("mvc/model/Product.php");
include_once("mvc/model/feature.php");
$objCategory = new category();
$objProduct = new Product();
$objFeature = new feature();
$array=array();
//$arrayFeature=array();
$arrayFeature['listFeature']=array();
$arrayFeature['listFeatureType']=array();
$arrayP=array();
$arrayMenu=$objCategory->getAllListCategory(CATEGORY_PRODUCT_ID,$array);
$urlCategory='<a href="/">Trang chủ</a>';
$detailP=(int)END;
if(END!=''&&$detailP==0){
	$category=$objCategory->getcategory(CATEGORY_PRODUCT_ID,$arrayMenu,END);
}else{
	$category=$objCategory->getcategory(CATEGORY_PRODUCT_ID,$arrayMenu,FIRSTEND);
}
$strUrl="";
for($i=0;$i<count($url_array);$i++){
	if($v!='')
		$strUrl.='/'.$url_array[$i];
}
if(is_numeric($detailP)&&$detailP>=15062016){//chi tiet
	for($i=0;$i<count($url_array)-1;$i++){
		if($v!='')
			$urlCategory.='<a href="/'.$url_array[$i].'">'.getCategoryName($arrayMenu,$url_array[$i]).'</a>';
	}
	$cssProductDetail=1;
	$jsProductDetail=1;
	$productDetail=$objProduct->getProductById($detailP);
	$title=mb_strtoupper($productDetail[0]['PRODUCT']['PRODUCT_NAME'].'-'.$productDetail[0]['PRODUCT']['PRODUCT_ID'],'utf-8');
	if(count($productDetail)>0&&$productDetail!=null){
		$priceDefault=0;
		$priceSale=0;
		$select=0;
		if(count($productDetail[0]['PRICE'])>0){
							foreach($productDetail[0]['PRICE'] as $k2=>$pPrice){
								if($pPrice['PRODUCT_PRICE_TYPE_ID']=='LIST_PRICE'&&$pPrice['TERM_UOM_ID']==-1)
									$priceDefault=$pPrice['PRICE'];
								if($pPrice['PRODUCT_PRICE_TYPE_ID']=='PROMO_PRICE'&&$pPrice['TERM_UOM_ID']==-1)
									$priceSale=$pPrice['PRICE'];
			}
		}
		$featureTypeLoad=explode('@',$productDetail[0]['PRODUCT']['FEATURE_TYPE_ID']);
		$featureLoad=explode('@',$productDetail[0]['PRODUCT']['FEATURE_ID']);
		$checkCountFeature=0;
		if(count($featureTypeLoad)>0&&count($featureLoad)>0){
			foreach($featureTypeLoad as $k=>$v){
				if($v!=""){
					$checkCountFeature++;
					$arrayFeatureTypeName=$objFeature->getFeatureTypeById($v);
					$stack=array('DESCRIPTION_FEATURE_TYPE'=>$arrayFeatureTypeName[0]['DESCRIPTION_FEATURE_TYPE'],'PRODUCT_FEATURE_TYPE_ID'=>$arrayFeatureTypeName[0]['PRODUCT_FEATURE_TYPE_ID']);
					array_push($arrayFeature['listFeatureType'],$stack);
				}
			}
			foreach($featureLoad as $k=>$v){
				if($v!=""){
					$arrayFeatureId=explode(':',$v);
					$arrayFeature['listFeature'][$k]=array();
					foreach($arrayFeatureId as $key=>$value){
						$arrayFeatureName=$objFeature->getFeatureId($value);
						$stack=array('PRODUCT_FEATURE_ID'=>$arrayFeatureName[0]['PRODUCT_FEATURE_ID'],'DESCRIPTION_FEATURE'=>$arrayFeatureName[0]['DESCRIPTION_FEATURE']);
						array_push($arrayFeature['listFeature'][$k],$stack);
					}
				}
			}
			$featureCheck=0;
			usort($productDetail[0]['PRICE'], function($a, $b) {
				return $a['PRICE'] - $b['PRICE'];
			});
			foreach($productDetail[0]['PRICE'] as $k2=>$pPrice){
				$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$productDetail[0]['PRICE']);
				$sT=getPriceByFeature($pPrice['TERM_UOM_ID'],'PROMO_PRICE',$productDetail[0]['PRICE']);
				if($dT!=null&&$sT!=null&&$pPrice['TERM_UOM_ID']!=-1){
					$priceDefault=$dT['PRICE'];
					$select=$dT['TERM_UOM_ID'];
					$priceSale=$sT['PRICE'];
					$featureCheck=1;
					break;
				}
			}
			if($featureCheck==0){
				foreach($productDetail[0]['PRICE'] as $k2=>$pPrice){
					$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$productDetail[0]['PRICE']);
						if(null!=$dT&&$pPrice['TERM_UOM_ID']!=-1){
							$priceDefault=$dT['PRICE'];
							$select=$dT['TERM_UOM_ID'];
							break;
						}
				}
			}
		}
		$arrayImage=array();
		if(isset($productDetail['LIST-PRODUCT-JUNIOR'])&&null!=$productDetail['LIST-PRODUCT-JUNIOR']){
		$productJunior=$productDetail['LIST-PRODUCT-JUNIOR'];
		foreach($arrayFeature['listFeatureType'] as $k=>$featureType){
			foreach($arrayFeature['listFeature'][$k] as $k1=>$feature){
				//echo $feature['DESCRIPTION_FEATURE'];
				$featureTemp=getProductByFeature($productJunior,$feature['PRODUCT_FEATURE_ID']);
				//var_dump($featureTemp);
				if(null!=$featureTemp){
					$img=split('@@@',$featureTemp['SMALL_IMAGE_URL']);
					if(count($img>0)){
						unset($img[0]);
						foreach($img as $k=>$image){
							$lag=0;
							foreach($arrayImage as $k=>$valueImg){
								if($valueImg==$image){
									$lag=1;
								}
							}
							if($lag==0){
								array_push($arrayImage,$image);
							}
							
							
						}
					}
				}
			}
		}
		}
		$showImg=1;
		$view = 'mvc/view/product-category/detail.phtml';
	}else
		$view = 'mvc/view/error/error.phtml';
}else{//san pham danh muc
	for($i=0;$i<count($url_array);$i++){
		if($v!='')
			$urlCategory.='<a href="/'.$url_array[$i].'">'.getCategoryName($arrayMenu,$url_array[$i]).'</a>';
	}
	$cssProduct=1;
	$jsProduct=1;
	$idCategory=getCategoryId($arrayMenu,END);
	//$filterCategory
	$arrayT=array();
	$arrayCategoryId=$objCategory->getAllListCategory($idCategory,$arrayT);
	if(count(getCategoryById($filterCategory,$idCategory))>0){
		$v=getCategoryById($filterCategory,$idCategory);
		$categoryParent=array("MENU_ID" => $v['MENU_ID'], "NAME" =>$v['NAME'], "PARENTS" => $v['PARENTS'], "LEVEL" => $v['LEVEL'], "ORDERING" => ($v['ORDERING']!=null)?$v['ORDERING']:"", "ENABLED" => $v['ENABLED'], "URL" => ($v['URL']!=null)?$v['URL']:"","IMAGE" => ($v['IMAGE']!=null)?$v['IMAGE']:"");
		array_push($arrayCategoryId,$categoryParent);
	}
	
	$listProduct=array();
	foreach($arrayCategoryId as $k=>$v){
			$arrayProduct=$objProduct->getListProductCategortyById($v['MENU_ID']);
			if(count($arrayProduct)>0){
				foreach($arrayProduct as $k1=>$product){
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
						if($featureCheck==0){
						foreach($product['PRICE'] as $k2=>$pPrice){
							$dT=getPriceByFeature($pPrice['TERM_UOM_ID'],'LIST_PRICE',$product['PRICE']);
								if(null!=$dT&&$pPrice['TERM_UOM_ID']!=-1){
									$priceDefault=$dT['PRICE'];
									break;
								}
						}
					}
					}
					//$url=getCategoryById($filterCategory,$product['PRODUCT']['PRODUCT_CATEGORY_ID']);//$filterCategory trong homecontroller
					array_push($listProduct,array('URL' => $product['PRODUCT']['URL'],'SMALL_IMAGE_URL'=>$product['PRODUCT']['SMALL_IMAGE_URL'],'PRODUCT_ID'=>$product['PRODUCT']['PRODUCT_ID'],'PRODUCT_NAME'=>$product['PRODUCT']['PRODUCT_NAME'],'PRODUCT_PRICE_D'=>$priceDefault,'PRODUCT_PRICE_S'=>$priceSale));
				}
			}
	}
	$view = 'mvc/view/product-category/index.phtml';
	$title=getCategoryName($arrayMenu,END);
}