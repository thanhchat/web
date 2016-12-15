<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php 
function contains($haystack,$needle)
{
    return strpos($haystack, $needle) !== false;
}
function checkProductByFeature($feature,$listProduct){
	$id=0;
	$pos=-1;
	foreach($listProduct as $k=>$v){
		if(contains($feature,$v['FEATURE_ID'])){
			$id=$v['PRODUCT_ID'];
			$pos=$k;
			break;
		}
	}
	return $id."@".$pos;
}
function checkFeatureExist($feature,$listProduct){
	foreach($listProduct as $k=>$v){
		if(strcmp($v['FEATURE_ID'],$feature)==0){
			return true;
		}
	}
	return false;
}
function buildProductFeature($idProduct,$objProduct){
	$productNew=$objProduct->getProductFeatureById($idProduct);
	$featureTypeLoad=explode('@',$productNew[0]['FEATURE_TYPE_ID']);
	$featureLoad=explode('@',$productNew[0]['FEATURE_ID']);
	$listProductFeature=$objProduct->getProductJuniorById($idProduct);
		$countFeatureType=count($featureTypeLoad);
		switch($countFeatureType){
			case 1:
					$arrayFeatureId=explode(':',$featureLoad[0]);
					foreach($arrayFeatureId as $key=>$value){
						if(!checkFeatureExist($value,$listProductFeature)&&$value!=''){
						$count=$objProduct->countProductJuniorById($idProduct);
						$idProductAdd=$idProduct.'-'.($count+1);
						$objProduct->addProductFullInfo($idProductAdd,$productNew[0]['MANUFACTURER_PARTY_ID'],$idProduct,$productNew[0]['PRODUCT_CATEGORY_ID'],$productNew[0]['FEATURE_TYPE_ID'],$value,null,$productNew[0]['PRODUCT_NAME'],null,null,null,null,null,null,null,null,0,null,'N');
					}
					
				}
			break;
			case 2:
				$arrayFeature1 = explode(":", $featureLoad[0]);
                $arrayFeature2 = explode(":", $featureLoad[1]);
				foreach($arrayFeature1 as $k1=>$v1){
					foreach($arrayFeature2 as $k2=>$v2){
						$strFeature=$v1."@".$v2;
						if(!checkFeatureExist($strFeature,$listProductFeature)){
							$check=explode('@',checkProductByFeature($strFeature,$listProductFeature));
							if($check[0]>0){
								$objProduct->updateFeatureType($productNew[0]['FEATURE_TYPE_ID'],$check[0]);
								$objProduct->updateFeature($strFeature,$check[0]);
								unset($listProductFeature[$check[1]]);								
							}else{
								$count=$objProduct->countProductJuniorById($idProduct);
								$idProductAdd=$idProduct.'-'.($count+1);
								$objProduct->addProductFullInfo($idProductAdd,$productNew[0]['MANUFACTURER_PARTY_ID'],$idProduct,$productNew[0]['PRODUCT_CATEGORY_ID'],$productNew[0]['FEATURE_TYPE_ID'],$strFeature,null,$productNew[0]['PRODUCT_NAME'],null,null,null,null,null,null,null,null,0,null,'N');
							}
						}
					}
					
				}
			break;
			case 3:
				$arrayFeature1 = explode(":", $featureLoad[0]);
                $arrayFeature2 = explode(":", $featureLoad[1]);
				$arrayFeature3 = explode(":", $featureLoad[2]);
				foreach($arrayFeature1 as $k1=>$v1){
					foreach($arrayFeature2 as $k2=>$v2){
						foreach($arrayFeature3 as $k3=>$v3){
							$strFeature=$v1."@".$v2."@".$v3;
							if(!checkFeatureExist($strFeature,$listProductFeature)){
								$check=explode('@',checkProductByFeature($strFeature,$listProductFeature));
								if($check[0]>0){
									$objProduct->updateFeatureType($productNew[0]['FEATURE_TYPE_ID'],$check[0]);
									$objProduct->updateFeature($strFeature,$check[0]);
									unset($listProductFeature[$check[1]]);								
								}else{
									$count=$objProduct->countProductJuniorById($idProduct);
									$idProductAdd=$idProduct.'-'.($count+1);
									$objProduct->addProductFullInfo($idProductAdd,$productNew[0]['MANUFACTURER_PARTY_ID'],$idProduct,$productNew[0]['PRODUCT_CATEGORY_ID'],$productNew[0]['FEATURE_TYPE_ID'],$strFeature,null,$productNew[0]['PRODUCT_NAME'],null,null,null,null,null,null,null,null,0,null,'N');
								}
							}
						}
					}
					
				}
			break;
			case 4:
				$arrayFeature1 = explode(":", $featureLoad[0]);
                $arrayFeature2 = explode(":", $featureLoad[1]);
				$arrayFeature3 = explode(":", $featureLoad[2]);
				$arrayFeature4 = explode(":", $featureLoad[3]);
				foreach($arrayFeature1 as $k1=>$v1){
					foreach($arrayFeature2 as $k2=>$v2){
						foreach($arrayFeature3 as $k3=>$v3){
							foreach($arrayFeature4 as $k4=>$v4){
								$strFeature=$v1."@".$v2."@".$v3."@".$v4;
								if(!checkFeatureExist($strFeature,$listProductFeature)){
									$check=explode('@',checkProductByFeature($strFeature,$listProductFeature));
									if($check[0]>0){
										$objProduct->updateFeatureType($productNew[0]['FEATURE_TYPE_ID'],$check[0]);
										$objProduct->updateFeature($strFeature,$check[0]);
										unset($listProductFeature[$check[1]]);								
									}else{
										$count=$objProduct->countProductJuniorById($idProduct);
										$idProductAdd=$idProduct.'-'.($count+1);
										$objProduct->addProductFullInfo($idProductAdd,$productNew[0]['MANUFACTURER_PARTY_ID'],$idProduct,$productNew[0]['PRODUCT_CATEGORY_ID'],$productNew[0]['FEATURE_TYPE_ID'],$strFeature,null,$productNew[0]['PRODUCT_NAME'],null,null,null,null,null,null,null,null,0,null,'N');
									}
								}
							}
						}
					}
					
				}
			break;
			case 5:
				$arrayFeature1 = explode(":", $featureLoad[0]);
                $arrayFeature2 = explode(":", $featureLoad[1]);
				$arrayFeature3 = explode(":", $featureLoad[2]);
				$arrayFeature4 = explode(":", $featureLoad[3]);
				$arrayFeature5 = explode(":", $featureLoad[4]);
				foreach($arrayFeature1 as $k1=>$v1){
					foreach($arrayFeature2 as $k2=>$v2){
						foreach($arrayFeature3 as $k3=>$v3){
							foreach($arrayFeature4 as $k4=>$v4){
								foreach($arrayFeature4 as $k4=>$v4){
									$strFeature=$v1."@".$v2."@".$v3."@".$v4."@".$v5;
									if(!checkFeatureExist($strFeature,$listProductFeature)){
										$check=explode('@',checkProductByFeature($strFeature,$listProductFeature));
										if($check[0]>0){
											$objProduct->updateFeatureType($productNew[0]['FEATURE_TYPE_ID'],$check[0]);
											$objProduct->updateFeature($strFeature,$check[0]);
											unset($listProductFeature[$check[1]]);								
										}else{
											$count=$objProduct->countProductJuniorById($idProduct);
											$idProductAdd=$idProduct.'-'.($count+1);
											$objProduct->addProductFullInfo($idProductAdd,$productNew[0]['MANUFACTURER_PARTY_ID'],$idProduct,$productNew[0]['PRODUCT_CATEGORY_ID'],$productNew[0]['FEATURE_TYPE_ID'],$strFeature,null,$productNew[0]['PRODUCT_NAME'],null,null,null,null,null,null,null,null,0,null,'N');
										}
									}
								}
							}
						}
					}
					
				}
			break;
		}
}
?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/product.php");
include_once("../../model/feature.php");
include_once("../../model/product-price.php");
$objProductPrice=new productprice();
$objFeature = new feature();
$objProduct = new product();
$array = array();
$array['error']=0;
$array['listFeature']=array();
$array['listFeatureType']=array();
$type=isset($_GET['type'])?$_GET['type']:'';
$value=isset($_GET['value'])?$_GET['value']:'';
$idProduct=isset($_GET['productId'])?$_GET['productId']:0;
if($value!=''&&$idProduct!=0){
	//
	$product=$objProduct->getProductFeatureById($idProduct);
	if($type=='fearure'){
		$arrayFeature=explode('@',$value);
		$flag=0;
		$checkPriceFeature=$objProductPrice->checkProductPriceByIdAndFeature($idProduct,$arrayFeature[0]);
		$arrayProductJunior=$objProduct->getProductJuniorById($idProduct);
		foreach($arrayProductJunior as $k=>$v){
			if(contains($v['FEATURE_ID'],$arrayFeature[0])&&($v['QUANTITY_UOM_ID']!=0||$v['QUANTITY_INCLUDED']!=0))
				$flag=1;
		}
		if($checkPriceFeature==0&&$flag==0){
			//0: feature;1: featureType
			$feature=$product[0]['FEATURE_ID'];
			$featureType=explode('@',$product[0]['FEATURE_TYPE_ID']);
			$arrayFeatureGetToDb=explode('@',$feature);
			$del=-1;
			foreach($arrayFeatureGetToDb as $k=>$v){
				if(contains($v,":".$arrayFeature[0])){
					$arrayFeatureGetToDb[$k]=str_replace(":".$arrayFeature[0],'',$v);
				}else{
					if(contains($v,$arrayFeature[0])){
						$arrayCheck=explode(':',$v);
						if(count($arrayCheck)>1)
							$arrayFeatureGetToDb[$k]=str_replace($arrayFeature[0].":",'',$v);
						else
							$arrayFeatureGetToDb[$k]=str_replace($arrayFeature[0],'',$v);
					}
				}
				if($arrayFeatureGetToDb[$k]==''){
					$del=$k;
					unset($arrayFeatureGetToDb[$k]);
				}
			}
			
			if($del>=0)
				unset($featureType[$del]);
			$strFeatureEnd=implode("@",$arrayFeatureGetToDb);
			$strFeatureTypeEnd=implode("@",$featureType);
			$objProduct->updateFeatureAndFeatureType($strFeatureEnd,$strFeatureTypeEnd,$idProduct);
			$listProductFeature=$objProduct->getProductJuniorById($idProduct);
			foreach($listProductFeature as $k=>$v){
				if(contains($v['FEATURE_ID'],$arrayFeature[0])){
					$objProduct->deleteProductFeatureJunior($v['PRODUCT_ID']);
				}
			}
			buildProductFeature($idProduct,$objProduct);
		}else{
			$array['error']=1;
		}
	}
	if($type=='fearureType'){//del all
		$featureType=explode('@',$product[0]['FEATURE_TYPE_ID']);
		$feature=$product[0]['FEATURE_ID'];
		$arrayFeatureGetToDb=explode('@',$feature);
		foreach($featureType as $k=>$v){
			if($v==$value){
				unset($featureType[$k]);
				unset($arrayFeatureGetToDb[$k]);
			}
				
		}
		$strFeatureEnd=implode("@",$arrayFeatureGetToDb);
		$strFeatureTypeEnd=implode("@",$featureType);
		$objProduct->updateFeatureAndFeatureType($strFeatureEnd,$strFeatureTypeEnd,$idProduct);
	}
		$productNew=$objProduct->getProductFeatureById($idProduct);
		$featureTypeLoad=explode('@',$productNew[0]['FEATURE_TYPE_ID']);
		$featureLoad=explode('@',$productNew[0]['FEATURE_ID']);
		foreach($featureTypeLoad as $k=>$v){
			$arrayFeatureTypeName=$objFeature->getFeatureTypeById($v);
			$stack=array('DESCRIPTION_FEATURE_TYPE'=>$arrayFeatureTypeName[0]['DESCRIPTION_FEATURE_TYPE'],'PRODUCT_FEATURE_TYPE_ID'=>$arrayFeatureTypeName[0]['PRODUCT_FEATURE_TYPE_ID']);
			array_push($array['listFeatureType'],$stack);
		}
		foreach($featureLoad as $k=>$v){
			$arrayFeatureId=explode(':',$v);
			$array['listFeature'][$k]=array();
			foreach($arrayFeatureId as $key=>$value){
				$arrayFeatureName=$objFeature->getFeatureId($value);
				$stack=array('PRODUCT_FEATURE_ID'=>$arrayFeatureName[0]['PRODUCT_FEATURE_ID'],'DESCRIPTION_FEATURE'=>$arrayFeatureName[0]['DESCRIPTION_FEATURE']);
				array_push($array['listFeature'][$k],$stack);
			}
		}
}
$json = json_encode($array);
echo($json);
?>