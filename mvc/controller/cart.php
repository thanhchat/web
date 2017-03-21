<?php
include_once("/configs/application.php");
include_once("/connections/class.db.php");
include_once("/mvc/model/product.php");
include_once("/mvc/model/feature.php");
include_once("/mvc/model/ClassShoppingCart.php");
$objProduct = new Product();
$objFeature = new feature();
$objCart = new ClassShoppingCart();
$title='Cập nhật giỏ hàng';
$jsCheckout=1;
$view = 'mvc/view/product/cart.phtml';