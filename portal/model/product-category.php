<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
//include_once("../configs/application.php");
//include_once("../connections/class.db.php");
class productcategory extends database
{
	function getListProductCategoryByIdCategory($idCategory){
		$sql = "SELECT * FROM product_category,product WHERE product_category.PRODUCT_CATEGORY_ID='$idCategory' AND product_category.PRODUCT_ID=product.PRODUCT_ID ORDER BY product_category.DEFAULT_SEQUENCE_NUM DESC";
        $result = $this->getData($sql);
        return $result;
	}
	function checkProductCategory($idProduct,$idCategory){
		$sql = "SELECT * FROM product_category WHERE PRODUCT_CATEGORY_ID='$idCategory' AND PRODUCT_ID='$idProduct'";
		$this->query($sql);
		$this->execute();
        $count = $this->rowCount();
        return $count;
	}

	function updateOrdering($idProduct,$idCategory,$ordering){
		try {
            $this->beginTransaction();
            $sql = "UPDATE product_category SET DEFAULT_SEQUENCE_NUM=:ordering  WHERE PRODUCT_CATEGORY_ID=:idCategory AND PRODUCT_ID=:idProduct";
            $this->query($sql);
			$this->bind(':ordering', $ordering);
			$this->bind(':idCategory', $idCategory);
			$this->bind(':idProduct', $idProduct);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
	}
	function updateActive($idProduct,$idCategory,$active){
		try {
			$this->beginTransaction();
			$sql = "UPDATE product_category SET ACTIVE=1-:active  WHERE PRODUCT_CATEGORY_ID=:idCategory AND PRODUCT_ID=:idProduct";
			$this->query($sql);
			$this->bind(':active', $active);
			$this->bind(':idCategory', $idCategory);
			$this->bind(':idProduct', $idProduct);
			$this->execute();
			$this->endTransaction();
		} catch (PDOException $e) {
			$this->cancelTransaction();
			throw new Exception($e->getMessage());
		}
	}
	function deleteProductCategory($idProduct,$idCategory){
		try {
            $this->beginTransaction();
            $sql = "DELETE FROM product_category WHERE PRODUCT_CATEGORY_ID=:idCategory AND PRODUCT_ID=:idProduct";
            $this->query($sql);
			$this->bind(':idCategory', $idCategory);
			$this->bind(':idProduct', $idProduct);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
	}
	function addProductCategory($idProduct,$idCategory,$productCategoryParent,$ordering,$active){
		try {
            $this->beginTransaction();
            $sql = "INSERT INTO  product_category (PRODUCT_CATEGORY_ID,PRODUCT_ID,PRODUCT_CATEGORY_ID_PARENT,DEFAULT_SEQUENCE_NUM,ACTIVE) VALUES(:idCategory,:idProduct,:productCategoryParent,:ordering,:active)";
            $this->query($sql);
			$this->bind(':idCategory', $idCategory);
			$this->bind(':idProduct', $idProduct);
			$this->bind(':productCategoryParent', $productCategoryParent);
			$this->bind(':active', $active);
			$this->bind(':ordering', $ordering);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
	}
}


