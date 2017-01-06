<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
//include_once("configs/application.php");
//include_once("connections/class.db.php");

class feature extends database
{

    function getListFeatureType()
    {
        $sql = "SELECT * FROM product_feature_type order by ODERING ASC";
        $result = $this->getData($sql);
        return $result;
    }
	function getFeatureTypeById($id)
    {
        $sql = "SELECT * FROM product_feature_type WHERE PRODUCT_FEATURE_TYPE_ID='$id'";
        $result = $this->getData($sql);
        return $result;
    }
	function getFeatureTypeByArrayId($array)
    {
        $sql = "SELECT * FROM product_feature_type WHERE PRODUCT_FEATURE_TYPE_ID IN('".implode("','",$array)."')";
        $result = $this->getData($sql);
        return $result;
    }
	
	function getListFeatureByFeatureType($idFeatureType)
    {
        $sql = "SELECT * FROM product_feature WHERE PRODUCT_FEATURE_TYPE_ID='$idFeatureType' order by DEFAULT_SEQUENCE_NUM ASC";
        $result = $this->getData($sql);
        return $result;
    }
	function getFeatureByArrayId($array)
    {
        $sql = "SELECT * FROM product_feature WHERE PRODUCT_FEATURE_ID IN('".implode("','",$array)."')";
        $result = $this->getData($sql);
        return $result;
    }
	function getFeatureId($id)
    {
        $sql = "SELECT * FROM product_feature WHERE PRODUCT_FEATURE_ID ='$id'";
        $result = $this->getData($sql);
        return $result;
    }
    function checkFeatureById($Id)
    {
        $sql = "SELECT * FROM product_feature_type WHERE PRODUCT_FEATURE_TYPE_ID=:Id";
        $this->query($sql);
        $this->bind(':Id', strtoupper($Id));
        $this->execute();
        $count = $this->rowCount();
        return $count;
    }
}