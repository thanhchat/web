<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
//include_once("../configs/application.php");
//include_once("../connections/class.db.php");

class Price extends database
{

    function getListPriceType()
    {
        $sql = "SELECT * FROM product_price_type";
        $result = $this->getData($sql);
        return $result;
    }
	function getListPriceTypeArray($array)
    {
		
        $sql = "SELECT * FROM product_price_type WHERE PRODUCT_PRICE_TYPE_ID IN('".implode("','",$array)."')";
        $result = $this->getData($sql);
        return $result;
    }
	function getPriceTypeById($id)
    {
        $sql = "SELECT * FROM product_price_type WHERE PRODUCT_PRICE_TYPE_ID='$id'";
        $result = $this->getData($sql);
        return $result;
    }
    function checkPriceById($Id)
    {
        $sql = "SELECT * FROM product_price_type WHERE PRODUCT_PRICE_TYPE_ID=:Id";
        $this->query($sql);
        $this->bind(':Id', strtoupper($Id));
        $this->execute();
        $count = $this->rowCount();
        return $count;
    }
	
    function addPriceType($priceTypeId, $priceTypeDes)
    {
        try {
            $this->beginTransaction();
            $sql = "INSERT INTO product_price_type(PRODUCT_PRICE_TYPE_ID, DESCRIPTION_PRICE_TYPE) VALUES (:priceTypeId,:priceTypeDes)";
            $this->query($sql);
            $this->bind(':priceTypeId', $priceTypeId);
            $this->bind(':priceTypeDes', $priceTypeDes);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
    }
	function updatePriceType($field,$val,$id)
    {
		$i=0;
        try {
            $this->beginTransaction();
            $sql = "UPDATE product_price_type SET $field='$val' WHERE PRODUCT_PRICE_TYPE_ID='$id'";
            $this->query($sql);
            $this->execute();
			$i=1;
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
		return $i;
    }



}