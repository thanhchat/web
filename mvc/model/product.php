<?php

/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 02/02/2015
 * Time: 21:46 PM 58
 */
//include_once("configs/application.php");
//include_once("connections/class.db.php");
class Product extends database
{
    public function getListProductCategortyHome($idCategory)
    {
        $arrayProduct = array();
        $sql = "SELECT * FROM product_category,product,menu_items WHERE product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID and menu_items.ENABLED=1 and product_category.PRODUCT_CATEGORY_ID='$idCategory' AND product_category.PRODUCT_ID=product.PRODUCT_ID and product.IS_ACTIVE='Y' and product.PRODUCT_PARENT_ID=0 ORDER BY product_category.DEFAULT_SEQUENCE_NUM DESC";
        $result = $this->getData($sql);
        if (count($result) > 0) {
            foreach ($result as $k => $value) {
                $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='" . $value['PRODUCT_ID'] . "'";
                $resultPrice = $this->getData($sql);
                $arrayProduct[$k]['PRODUCT'] = $value;
                $arrayProduct[$k]['PRICE'] = $resultPrice;
            }
        }
        return $arrayProduct;
    }

    public function getListProductCategortyById($idCategory)
    {
        $arrayProduct = array();
        $sql = "SELECT * FROM product,menu_items WHERE product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID and product.PRODUCT_CATEGORY_ID='$idCategory' and menu_items.ENABLED=1  and product.IS_ACTIVE='Y' and product.PRODUCT_PARENT_ID=0";
        $result = $this->getData($sql);
        if (count($result) > 0) {
            foreach ($result as $k => $value) {
                $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='" . $value['PRODUCT_ID'] . "'";
                $resultPrice = $this->getData($sql);
                $arrayProduct[$k]['PRODUCT'] = $value;
                $arrayProduct[$k]['PRICE'] = $resultPrice;
            }
        }
        return $arrayProduct;
    }
	public function getListProductCategortyRelated($idCategory,$limit,$idProduct)
    {
        $arrayProduct = array();
        $sql = "SELECT * FROM product,menu_items WHERE product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID and product.PRODUCT_CATEGORY_ID='$idCategory' and menu_items.ENABLED=1  and product.IS_ACTIVE='Y' and product.PRODUCT_PARENT_ID=0 AND product.PRODUCT_ID!=$idProduct LIMIT 0,$limit";
        $result = $this->getData($sql);
        if (count($result) > 0) {
            foreach ($result as $k => $value) {
                $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='" . $value['PRODUCT_ID'] . "'";
                $resultPrice = $this->getData($sql);
                $arrayProduct[$k]['PRODUCT'] = $value;
                $arrayProduct[$k]['PRICE'] = $resultPrice;
            }
        }
        return $arrayProduct;
    }
	public function getListProductCategortyByArray($array,$start,$limit,$sort)
    {
		$order='';
		$orderPrice='';
		if('DEFAULT'==$sort)
			$order='order by product.PRODUCT_ID';
		if('SORT_NAME_DECREASE'==$sort)
			$order='order by product.PRODUCT_NAME';
		if('SORT_NAME_INCREASE'==$sort)
			$order='order by product.PRODUCT_NAME DESC';
		if('SORT_PRICE_INCREASE'==$sort)
			$order='order by product_price.PRICE';
		if('SORT_PRICE_DECREASE'==$sort)
			$order='order by product_price.PRICE DESC';
		
        $arrayProduct = array();
        $sql = "SELECT DISTINCT product.*,menu_items.* FROM product,menu_items,product_price WHERE product_price.PRODUCT_PRICE_ID=product.PRODUCT_ID and product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID and menu_items.ENABLED=1  and product.IS_ACTIVE='Y' and product.PRODUCT_PARENT_ID=0 and product.PRODUCT_CATEGORY_ID IN('".implode("','",$array)."') $order LIMIT $start,$limit";
        $result = $this->getData($sql);
        if (count($result) > 0) {
            foreach ($result as $k => $value) {
                $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='" . $value['PRODUCT_ID'] . "'";
                $resultPrice = $this->getData($sql);
                $arrayProduct[$k]['PRODUCT'] = $value;
                $arrayProduct[$k]['PRICE'] = $resultPrice;
            }
        }
        return $arrayProduct;
    }
	public function getListProductCategortyByArrayAll($array)
    {	
        $arrayProduct = array();
        $sql = "SELECT DISTINCT product.*,menu_items.* FROM product,menu_items,product_price WHERE product_price.PRODUCT_PRICE_ID=product.PRODUCT_ID and product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID and menu_items.ENABLED=1  and product.IS_ACTIVE='Y' and product.PRODUCT_PARENT_ID=0 and product.PRODUCT_CATEGORY_ID IN('".implode("','",$array)."')";
        $result = $this->getData($sql);
        if (count($result) > 0) {
            foreach ($result as $k => $value) {
                $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='" . $value['PRODUCT_ID'] . "'";
                $resultPrice = $this->getData($sql);
                $arrayProduct[$k]['PRODUCT'] = $value;
                $arrayProduct[$k]['PRICE'] = $resultPrice;
            }
        }
        return $arrayProduct;
    }

    public function getProductById($idProduct)
    {
        $arrayProduct = array();
        $sql = "SELECT * FROM product,menu_items WHERE product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID and product.PRODUCT_ID='$idProduct' and menu_items.ENABLED=1  and product.IS_ACTIVE='Y'";
        $result = $this->getData($sql);
        if (count($result) > 0) {
            foreach ($result as $k => $value) {
                $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='" . $value['PRODUCT_ID'] . "'";
                $resultPrice = $this->getData($sql);
                $arrayProduct[$k]['PRODUCT'] = $value;
                $arrayProduct[$k]['PRICE'] = $resultPrice;
            }
        }
        $sql1 = "SELECT * FROM product,menu_items WHERE product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID and product.PRODUCT_PARENT_ID='$idProduct' and menu_items.ENABLED=1";
        $productJunior = $this->getData($sql1);
        if (count($productJunior) > 0 && null != $productJunior)
            $arrayProduct['LIST-PRODUCT-JUNIOR'] = $productJunior;
        return $arrayProduct;
    }

    function getProductJuniorById($id)
    {
        $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_PARENT_ID='$id'";
        $result = $this->getData($sql);
        return $result;
    }

    function getListProductPriceByIdProduct($idProduct)
    {
        $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='$idProduct'";
        $result = $this->getData($sql);
        return $result;
    }

    function getProductPrice($idProduct, $Type, $feature)
    {
        $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='$idProduct' AND PRODUCT_PRICE_TYPE_ID='$Type' AND TERM_UOM_ID='$feature'";
        $result = $this->getData($sql);
        return $result;
    }

    function countProductByIdcategory($idCategory)
    {
        $sql = "SELECT * FROM product WHERE IS_ACTIVE='Y' and PRODUCT_CATEGORY_ID='$idCategory' and PRODUCT_PARENT_ID=0";
        $this->query($sql);
        $this->execute();
        $count = $this->rowCount();
        return $count;
    }

    public function getProductByFeatureAndIdProductParent($idProduct,$feature)
    {
        $sql = "SELECT * FROM product,menu_items WHERE product.PRODUCT_PARENT_ID='$idProduct' AND  product.FEATURE_ID='$feature' AND product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID";
        $result = $this->getData($sql);
        return $result;
    }
    public function getProductByIdNotListPrice($idProduct)
    {
        $sql = "SELECT * FROM product,menu_items WHERE product.PRODUCT_ID='$idProduct' AND product.PRODUCT_CATEGORY_ID=menu_items.MENU_ID";
        $result = $this->getData($sql);
        return $result;
    }
}

