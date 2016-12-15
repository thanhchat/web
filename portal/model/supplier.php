<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
//include_once("../configs/application.php");
//include_once("../connections/class.db.php");

class supplier extends database
{

    function getListsupplier()
    {
        $sql = "SELECT * FROM supplier";
        $result = $this->getData($sql);
        return $result;
    }
	function getsupplierById($id)
    {
        $sql = "SELECT * FROM supplier WHERE SUPPLIER_ID='$id'";
        $result = $this->getData($sql);
        return $result;
    }
	function getIdMax()
    {
        $sql = "SELECT * FROM supplier WHERE SUPPLIER_ID=(SELECT MAX(SUPPLIER_ID) FROM supplier)";
        $result = $this->getData($sql);
        $idsupplier = 12151506;	
        if (count($result) > 0) {
            $idsupplier = $result[0]['SUPPLIER_ID'];
            $idsupplier = $idsupplier + 1;
        }
        return $idsupplier;
    }
	function addsupplier($supplierName,$supplierPhone,$supplierEmail,$supplierAddress,$supplierComment)
    {
        try {
			
            $this->beginTransaction();
			$id = $this->getIdMax();
            $sql = "INSERT INTO supplier(SUPPLIER_ID,SUPPLIER_NAME, PHONE, EMAIL, ADDRESS,COMMENT) VALUES (:supplierId,:supplierName,:supplierPhone,:supplierEmail,:supplierAddress,:supplierComment)";
            $this->query($sql);
            $this->bind(':supplierId', $id);
			$this->bind(':supplierName', $supplierName);
            $this->bind(':supplierPhone', $supplierPhone);
            $this->bind(':supplierEmail', $supplierEmail);
            $this->bind(':supplierAddress',$supplierAddress);
            $this->bind(':supplierComment',$supplierComment);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
    }
   
	function updatesupplier($field,$val,$id)
    {
		$i=0;
        try {
            $this->beginTransaction();
            $sql = "UPDATE supplier SET $field='$val' WHERE SUPPLIER_ID='$id'";
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