<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
//include_once("../configs/application.php");
//include_once("../connections/class.db.php");

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
	function getIdMax()
    {
        $sql = "SELECT * FROM product_feature WHERE PRODUCT_FEATURE_ID=(SELECT MAX(PRODUCT_FEATURE_ID) FROM product_feature)";
        $result = $this->getData($sql);
        $idFeature = 1506;
        if (count($result) > 0) {
            $idFeature = $result[0]['PRODUCT_FEATURE_ID'];
            $idFeature = $idFeature + 1;
        }
        return $idFeature;
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
	
	function addFeature($featureTypeId, $featureDes, $ordering,$active)
    {
        try {
			
            $this->beginTransaction();
			$id = $this->getIdMax();
            $sql = "INSERT INTO product_feature(PRODUCT_FEATURE_ID,PRODUCT_FEATURE_TYPE_ID, DESCRIPTION_FEATURE, DEFAULT_SEQUENCE_NUM, ACTIVE) VALUES (:featureId,:featureTypeId,:featureDes,:ordering,:active)";
            $this->query($sql);
            $this->bind(':featureId', $id);
			$this->bind(':featureTypeId', $featureTypeId);
            $this->bind(':featureDes', $featureDes);
            $this->bind(':ordering', ($ordering!='')?$ordering:0);
            $this->bind(':active', ($active>0)?1:0);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
    }
    function addFeatureType($featureTypeId, $featureTypeDes, $ordering,$active)
    {
        try {
            $this->beginTransaction();
            $sql = "INSERT INTO product_feature_type(PRODUCT_FEATURE_TYPE_ID, DESCRIPTION_FEATURE_TYPE, ODERING, ACTIVE) VALUES (:featureTypeId,:featureTypeDes,:ordering,:active)";
            $this->query($sql);
            $this->bind(':featureTypeId', $featureTypeId);
            $this->bind(':featureTypeDes', $featureTypeDes);
            $this->bind(':ordering', ($ordering!='')?$ordering:0);
            $this->bind(':active', ($active>0)?1:0);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
    }
	function updateFeatureTypeAction($id)
    {
		$i=0;
        try {
            $this->beginTransaction();
            $sql = "UPDATE product_feature_type SET ACTIVE=1-ACTIVE WHERE PRODUCT_FEATURE_TYPE_ID='$id'";
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
	function updateFeatureAction($id)
    {
		$i=0;
        try {
            $this->beginTransaction();
            $sql = "UPDATE product_feature SET ACTIVE=1-ACTIVE WHERE PRODUCT_FEATURE_ID='$id'";
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
	function updateFeatureType($field,$val,$id)
    {
		$i=0;
        try {
            $this->beginTransaction();
            $sql = "UPDATE product_feature_type SET $field='$val' WHERE PRODUCT_FEATURE_TYPE_ID='$id'";
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
	function updateFeature($field,$val,$id)
    {
		$i=0;
        try {
            $this->beginTransaction();
            $sql = "UPDATE product_feature SET $field='$val' WHERE PRODUCT_FEATURE_ID='$id'";
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