<?php

/**
 * Created by PhpStorm.
 * User: thanhchat
 * Date: 06/01/2017
 * Time: 21:30
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class ClassShoppingCart extends database
{
    public function product_exists($pid)
    {
        $flag = -1;
        if (isset($_SESSION['shopping_cart_online'])) {
            //$pid = intval($pid);
            $max = count($_SESSION['shopping_cart_online']);
            for ($i = 0; $i < $max; $i++) {
                if ($pid == $_SESSION['shopping_cart_online'][$i]['pid']) {
                    $flag = $i;
                    break;
                }
            }
        }
        return $flag;
    }

    public function addProductToCart($idParent, $manuid, $idProduct, $quantity, $featureSelect, $price, $promo, $img, $pName,$url)
    {
        if ($idProduct < 15062016 or $quantity < 1) return;
        if (isset($_SESSION['shopping_cart_online']) && is_array($_SESSION['shopping_cart_online'])) {
            //if ($this->product_exists($idProduct)!=-1) return;
            $i = $this->product_exists($idProduct);
            if ($i >= 0) {
                $_SESSION['shopping_cart_online'][$i]['qty'] += $quantity;
            } else {
                $max = count($_SESSION['shopping_cart_online']);
                $_SESSION['shopping_cart_online'][$max]['pidParent'] = $idParent;
                $_SESSION['shopping_cart_online'][$max]['manuid'] = $manuid;
                $_SESSION['shopping_cart_online'][$max]['pName'] = $pName;
                $_SESSION['shopping_cart_online'][$max]['pid'] = $idProduct;
                $_SESSION['shopping_cart_online'][$max]['qty'] = $quantity;
                $_SESSION['shopping_cart_online'][$max]['feature'] = $featureSelect;
                $_SESSION['shopping_cart_online'][$max]['price'] = $price;
                $_SESSION['shopping_cart_online'][$max]['promo'] = $promo;
                $_SESSION['shopping_cart_online'][$max]['img'] = $img;
                $_SESSION['shopping_cart_online'][$max]['url'] = $url;
            }

        } else {
            $_SESSION['shopping_cart_online'] = array();
            $_SESSION['shopping_cart_online'][0]['pidParent'] = $idParent;
            $_SESSION['shopping_cart_online'][0]['manuid'] = $manuid;
            $_SESSION['shopping_cart_online'][0]['pName'] = $pName;
            $_SESSION['shopping_cart_online'][0]['pid'] = $idProduct;
            $_SESSION['shopping_cart_online'][0]['qty'] = $quantity;
            $_SESSION['shopping_cart_online'][0]['feature'] = $featureSelect;
            $_SESSION['shopping_cart_online'][0]['price'] = $price;
            $_SESSION['shopping_cart_online'][0]['promo'] = $promo;
            $_SESSION['shopping_cart_online'][0]['img'] = $img;
            $_SESSION['shopping_cart_online'][0]['url'] = $url;
        }
    }

    public function updateCart($pid, $q)
    {
        if ($pid < 15062016 or $q < 1) return;
        $i = $this->product_exists($pid);
        if ($i >= 0) {
            $_SESSION['shopping_cart_online'][$i]['qty'] = $q;
        }
    }

    public function get_total_item()
    {
        if (isset($_SESSION['shopping_cart_online']))
            return count($_SESSION['shopping_cart_online']);
        else
            return 0;
    }

    public function get_order_total()
    {
        $sum = 0;
        if (isset($_SESSION['shopping_cart_online'])) {
            $max = count($_SESSION['shopping_cart_online']);
            for ($i = 0; $i < $max; $i++) {
                $q = $_SESSION['shopping_cart_online'][$i]['qty'];
                $price = $_SESSION['shopping_cart_online'][$i]['price'];
                $promo = $_SESSION['shopping_cart_online'][$i]['promo'];
                $priceFinal = $price;
                if ($promo > 0)
                    $priceFinal = $promo;
                $sum += $priceFinal * $q;
            }
        }
        return $sum;
    }

    function getProductPrice($idProduct)
    {
        $sql = "SELECT * FROM product_price WHERE PRODUCT_PRICE_ID='$idProduct'";
        $result = $this->getData($sql);
        return $result;
    }

    public function get_product($pid)
    {
        $sql = "select * from products,menu_items where products.ACTIVE=1 and products.PRODUCT_MENU_ITEM_ID=menu_items.MENU_ID and products.ID =$pid";
        $data = $this->getData($sql);
        return $data;
    }

    public function remove_product($pid)
    {
        $pid = intval($pid);
        if (isset($_SESSION['shopping_cart_online'])) {
            $max = count($_SESSION['shopping_cart_online']);
            for ($i = 0; $i < $max; $i++) {
                if ($pid == $_SESSION['shopping_cart_online'][$i]['pid']) {
                    unset($_SESSION['shopping_cart_online'][$i]);
                    break;
                }
            }
            $_SESSION['shopping_cart_online'] = array_values($_SESSION['shopping_cart_online']);
        }
    }
}