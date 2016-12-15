<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
//include_once("../configs/application.php");
//include_once("../connections/class.db.php");
class productprice extends database
{
	function getListProductPriceByIdProduct($idProduct){
		$sql = "SELECT * FROM product_price,product_price_type WHERE product_price.PRODUCT_PRICE_ID='$idProduct' AND product_price.PRODUCT_PRICE_TYPE_ID=product_price_type.PRODUCT_PRICE_TYPE_ID";
        $result = $this->getData($sql);
        return $result;
	}
	function checkProductPrice($idProduct,$productPriceType,$feature,$currencyUomId){
		$sql = "SELECT * FROM product_price WHERE product_price.PRODUCT_PRICE_ID='$idProduct' AND PRODUCT_PRICE_TYPE_ID='$productPriceType' AND TERM_UOM_ID='$feature' AND CURRENCY_UOM_ID='$currencyUomId'";
		$this->query($sql);
		$this->execute();
        $count = $this->rowCount();
        return $count;
	}
	function checkProductPriceByIdAndFeature($idProduct,$feature){
		$sql = "SELECT * FROM product_price WHERE product_price.PRODUCT_PRICE_ID='$idProduct' AND  TERM_UOM_ID='$feature'";
		$this->query($sql);
		$this->execute();
        $count = $this->rowCount();
        return $count;
	}
	function updateProductPrice($productPriceType,$feature,$currencyUomId,$price,$userlogin,$idProductKey,$productPriceTypeKey,$currencyUomIdKey,$featureKey){
		try {
            $this->beginTransaction();
            $sql = "UPDATE product_price SET PRODUCT_PRICE_TYPE_ID=:productPriceType,TERM_UOM_ID=:feature,CURRENCY_UOM_ID=:currencyUomId,PRICE=:price,CREATED_BY_USER_LOGIN=:userlogin  WHERE PRODUCT_PRICE_ID=:idProductKey AND PRODUCT_PRICE_TYPE_ID=:productPriceTypeKey AND CURRENCY_UOM_ID=:currencyUomIdKey AND TERM_UOM_ID=:featureKey";
            $this->query($sql);
			$this->bind(':productPriceType', $productPriceType);
			$this->bind(':feature', $feature);
			$this->bind(':currencyUomId', $currencyUomId);
			$this->bind(':price', $price);
			$this->bind(':userlogin', $userlogin);
			$this->bind(':idProductKey', $idProductKey);
			$this->bind(':productPriceTypeKey', $productPriceTypeKey);
			$this->bind(':currencyUomIdKey', $currencyUomIdKey);
			$this->bind(':featureKey', $featureKey);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
	}
	function deleteProductPrice($idProductKey,$productPriceTypeKey,$currencyUomIdKey,$featureKey){
		try {
            $this->beginTransaction();
            $sql = "DELETE FROM product_price  WHERE PRODUCT_PRICE_ID=:idProductKey AND PRODUCT_PRICE_TYPE_ID=:productPriceTypeKey AND CURRENCY_UOM_ID=:currencyUomIdKey AND TERM_UOM_ID=:featureKey";
            $this->query($sql);
			$this->bind(':idProductKey', $idProductKey);
			$this->bind(':productPriceTypeKey', $productPriceTypeKey);
			$this->bind(':currencyUomIdKey', $currencyUomIdKey);
			$this->bind(':featureKey', $featureKey);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
	}
	function addProductPrice($productPriceType,$feature,$currencyUomId,$price,$userlogin,$idProduct){
		try {
            $this->beginTransaction();
            $sql = "INSERT INTO  product_price (PRODUCT_PRICE_ID,PRODUCT_PRICE_TYPE_ID,TERM_UOM_ID,CURRENCY_UOM_ID,PRICE,CREATED_BY_USER_LOGIN) VALUES(:idProduct,:productPriceType,:feature,:currencyUomId,:price,:userlogin)";
            $this->query($sql);
			$this->bind(':productPriceType', $productPriceType);
			$this->bind(':feature', $feature);
			$this->bind(':currencyUomId', $currencyUomId);
			$this->bind(':price', $price);
			$this->bind(':userlogin', $userlogin);
			$this->bind(':idProduct', $idProduct);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
	}
}


