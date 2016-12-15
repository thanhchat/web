<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
//include_once("../configs/application.php");
//include_once("../connections/class.db.php");
class product extends database
{
	
    function checkProductByManufactureId($manufactureId)
    {
        $sql = "SELECT * FROM PRODUCT WHERE MANUFACTURER_PARTY_ID=:manufactureId and PRODUCT_PARENT_ID=0";
        $this->query($sql);
        $this->bind(':manufactureId', strtoupper($manufactureId));
        $this->execute();
        $count = $this->rowCount();
        return $count;
    }
	function updateImageProduct($img,$idProduct){
		try {
			$this->beginTransaction();
			$sql="UPDATE PRODUCT SET SMALL_IMAGE_URL='$img',MEDIUM_IMAGE_URL='$img',LARGE_IMAGE_URL='$img',ORIGINAL_IMAGE_URL='$img' WHERE PRODUCT_ID='$idProduct'";
			$this->query($sql);
			$this->execute();
			$this->endTransaction();
		}catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
	}
	function getProductById($Id)
    {
        $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_ID='$Id'";
        $result = $this->getData($sql);
        return $result;
    }
	function getProductByManufactureId($manufactureId)
    {
        $sql = "SELECT * FROM PRODUCT WHERE MANUFACTURER_PARTY_ID='$manufactureId' AND PRODUCT_PARENT_ID=0";
        $result = $this->getData($sql);
        return $result;
    }
	function publicProduct($idProduct,$active)
    {
       try {
			$this->beginTransaction();
			$sql="UPDATE product SET IS_ACTIVE=:active WHERE PRODUCT_ID=:idProduct";
			$this->query($sql);
            $this->bind(':active', $active);
            $this->bind(':idProduct', $idProduct);
			$this->execute();
            $this->endTransaction();
			return true;
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
			return false;
        }
    }
	
	function getProductJuniorById($id){
		$sql = "SELECT * FROM PRODUCT WHERE PRODUCT_PARENT_ID='$id'";
        $result = $this->getData($sql);
		return $result;
	}
	function countProductJuniorById($id){
		$sql = "SELECT * FROM PRODUCT WHERE PRODUCT_PARENT_ID=:id";
        $this->query($sql);
        $this->bind(':id', $id);
        $this->execute();
        $count = $this->rowCount();
        return $count;
	}
	function getProductFeatureById($Id)
    {
        $sql = "SELECT * FROM product WHERE PRODUCT_ID='$Id'";
        $result = $this->getData($sql);
        return $result;
    }
	function addProductFullInfo($productId,$manufactureId,$productParentId,$categoryId,$featureType,$feature,$toppic,$productName,$internalName,$comment,$description,$longDescription,$image,$quantity_uom,$quantity_include,$userCreated,$productRating,$supplier,$active){
		try {
			$this->beginTransaction();
			$sql="INSERT INTO `product`(`PRODUCT_ID`, `MANUFACTURER_PARTY_ID`, `PRODUCT_PARENT_ID`, `PRODUCT_CATEGORY_ID`, `FEATURE_TYPE_ID`, 
			`FEATURE_ID`, `TOPIC_ID`, `PRODUCT_NAME`, `INTERNAL_NAME`, `COMMENTS`, `DESCRIPTION`, `LONG_DESCRIPTION`, `SMALL_IMAGE_URL`, `MEDIUM_IMAGE_URL`, 
			`LARGE_IMAGE_URL`, `ORIGINAL_IMAGE_URL`, `QUANTITY_UOM_ID`, `QUANTITY_INCLUDED`,`CREATED_BY_USER_LOGIN`, `PRODUCT_RATING`, `SUPPLIER`, `IS_ACTIVE`) 
			VALUES (:productId,:manufactureId,:productParentId,:categoryId,:featureType,:feature,:toppic,
			:productName,:internalName,:comment,:description,:longDescription,:smallImage,:mediumImage,:largeImage,:originalIamge,
			:quantity_uom,:quantity_include,:userCreated,:productRating,:supplier,:active)";
			$this->query($sql);
			$this->bind(':productId', $productId);
			$this->bind(':manufactureId', $manufactureId);
			$this->bind(':productParentId', $productParentId);
			$this->bind(':categoryId', $categoryId);
			$this->bind(':featureType', $featureType);
			$this->bind(':feature', $feature);
			$this->bind(':toppic', $toppic);
			$this->bind(':productName', $productName);
			$this->bind(':internalName', $internalName);
			$this->bind(':comment', $comment);
			$this->bind(':description', $description);
			$this->bind(':longDescription', $longDescription);
			$this->bind(':smallImage', $image);
			$this->bind(':mediumImage', $image);
			$this->bind(':largeImage', $image);
			$this->bind(':originalIamge', $image);
			$this->bind(':quantity_uom', $quantity_uom);
			$this->bind(':quantity_include', $quantity_include);
			$this->bind(':userCreated', $userCreated);
			$this->bind(':productRating', $productRating);
			$this->bind(':supplier', $supplier);
			$this->bind(':active', $active);
			$this->execute();
            $this->endTransaction();
			return true;
		 } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
			return false;
        }
	}
    function updateFeatureAndFeatureType($feature,$featureType,$idProduct){
		try {
			$this->beginTransaction();
			$sql="UPDATE product SET FEATURE_TYPE_ID=:featureType,FEATURE_ID=:feature WHERE PRODUCT_ID=:productId";
			$this->query($sql);
            $this->bind(':featureType', $featureType);
            $this->bind(':feature',$feature);
            $this->bind(':productId', $idProduct);
			$this->execute();
            $this->endTransaction();
			return true;
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
			return false;
        }
    }
	function updateFeatureType($featureType,$idProduct){
		try {
			$this->beginTransaction();
			$sql="UPDATE product SET FEATURE_TYPE_ID=:featureType WHERE PRODUCT_ID=:productId";
			$this->query($sql);
            $this->bind(':featureType', $featureType);
            $this->bind(':productId', $idProduct);
			$this->execute();
            $this->endTransaction();
			return true;
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
			return false;
        }
    }
	function updateFeature($feature,$idProduct){
		try {
			$this->beginTransaction();
			$sql="UPDATE product SET FEATURE_ID=:feature WHERE PRODUCT_ID=:productId";
			$this->query($sql);
            $this->bind(':feature',$feature);
            $this->bind(':productId', $idProduct);
			$this->execute();
            $this->endTransaction();
			return true;
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
			return false;
        }
    }
	function updateSupplier($supplier,$idProduct){
		try {
			$this->beginTransaction();
			$sql="UPDATE product SET SUPPLIER=:supplier WHERE PRODUCT_ID=:productId";
			$this->query($sql);
            $this->bind(':supplier',$supplier);
            $this->bind(':productId', $idProduct);
			$this->execute();
            $this->endTransaction();
			return true;
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
			return false;
        }
    }
	function deleteProductFeatureJunior($id){
		try {
			$this->beginTransaction();
			$sql="DELETE FROM product WHERE PRODUCT_ID=:productId";
			$this->query($sql);
            $this->bind(':productId', $id);
			$this->execute();
            $this->endTransaction();
			return true;
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
			return false;
        }
	}
	function updateInfoProduct($productCategory,$manufactureId,$productName,$description,$longDescription,$productId)
	{
		try {
			$this->beginTransaction();
			$sql="UPDATE product SET MANUFACTURER_PARTY_ID=:manufactureId,PRODUCT_CATEGORY_ID=:productCategory,PRODUCT_NAME=:productName,DESCRIPTION=:description,LONG_DESCRIPTION=:longDescription WHERE PRODUCT_ID=:productId";
			$this->query($sql);
            $this->bind(':productId', $productId);
            $this->bind(':manufactureId', strtoupper($manufactureId));
            $this->bind(':productCategory', $productCategory);
            $this->bind(':productName', $productName);
            $this->bind(':description', $description);
            $this->bind(':longDescription', $longDescription);
			$this->execute();
			$sql1="UPDATE product SET MANUFACTURER_PARTY_ID=:manufactureId,PRODUCT_CATEGORY_ID=:productCategory,PRODUCT_NAME=:productName,DESCRIPTION=:description,LONG_DESCRIPTION=:longDescription WHERE PRODUCT_PARENT_ID=:productId";
			$this->query($sql1);
            $this->bind(':productId', $productId);
            $this->bind(':manufactureId', strtoupper($manufactureId));
            $this->bind(':productCategory', $productCategory);
            $this->bind(':productName', $productName);
            $this->bind(':description', $description);
            $this->bind(':longDescription', $longDescription);
			$this->execute();
            $this->endTransaction();
			return true;
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
			return false;
        }
	}
    function addProduct($manufactureId, $productCategory, $productName)
    {
        try {
            $idProduct = $this->getIdMax();
            $this->beginTransaction();
            $sql = "INSERT INTO product(PRODUCT_ID, MANUFACTURER_PARTY_ID, PRODUCT_PARENT_ID, PRODUCT_CATEGORY_ID,PRODUCT_NAME) VALUES (:productId,:manufactureId,:productParent,:productCategoryId,:productName)";
            $this->query($sql);
            $this->bind(':productId', $idProduct);
            $this->bind(':manufactureId', strtoupper($manufactureId));
            $this->bind(':productParent', 0);
            $this->bind(':productCategoryId', $productCategory);
            $this->bind(':productName', $productName);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
    }
    function getIdMax()
    {
        $sql = "SELECT * FROM product WHERE PRODUCT_ID=(SELECT MAX(PRODUCT_ID) FROM product WHERE PRODUCT_PARENT_ID=0)";
        $result = $this->getData($sql);
        $idProduct = 15062016;
        if (count($result) > 0) {
            $idProduct = $result[0]['PRODUCT_ID'];
            $idProduct = $idProduct + 1;
        }
        return $idProduct;
    }
	function getListProduct($criteria)
    {
		
		$filters='';
			if(!empty($criteria['PRODUCT_ID'])){
				$idpd=mysql_real_escape_string($criteria['PRODUCT_ID']);
				$filters.= " and upper(PRODUCT_ID) like upper('%$idpd%')";
			}
			if(!empty($criteria['PRODUCT_NAME'])){
				$pdname=mysql_real_escape_string($criteria['PRODUCT_NAME']);
				$filters.= " and upper(PRODUCT_NAME) like upper('%$pdname%')";
			}
			if(!empty($criteria['txtProductKH'])){
				$pdkh=mysql_real_escape_string($criteria['txtProductKH']);
				$filters.= " and upper(MANUFACTURER_PARTY_ID) like upper('%$pdkh%')";
			}
			if(!empty($criteria['drpCategory'])&&$criteria['drpCategory']!=-1){
				$cate=$criteria['drpCategory'];
				$filters.= " and PRODUCT_CATEGORY_ID=$cate ";
			}
			if(!empty($criteria['drpActive'])&&$criteria['drpActive']!=-1){
				$active=$criteria['drpActive'];
				$filters.= " and IS_ACTIVE='$active'";
			}
        $sql = "SELECT * FROM product WHERE PRODUCT_PARENT_ID=0 ".$filters;
		//echo $sql;
        $result = $this->getData($sql);
        return $result;
    }
	

}


