<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 26/05/2015
 * Time: 13:56 PM 11
 */
$DATA["TITLE"] = "Quản lý thông tin Caches";
include_once("../configs/application.php");
include_once("../functions/function.php");
include_once("../connections/class.db.php");
$db = new database();
include_once("../models/news.php");
$objNews = new news();
include_once("../models/product.php");
$objProduct = new Product();
include_once("../models/menuItems.php");
$objMenuItem = new menuItem();
include_once("../models/functions.php");
$objFunction = new Functions();
include_once("../models/box.php");
$objBox = new box();
global $cache;
include_once("model/category.php");
$objCat = new category();
$id_cate_product_pr=57;
$listMenuItems = $objCat->Menu($id_cate_product_pr);
switch (LINKS4) {
    case "sort_all_product":
        if (!empty($_POST)) {
            $sort_option = $_POST['sort_option'];
            if ($sort_option == "all") {
                $arrayOption = array("none", "price-asc", "price-desc", "name-asc", "name-desc", "price-sale");
                for ($i = 0; $i < count($arrayOption); $i++) {
                    $cacheOptionSort = "SUM_SORT_" . $arrayOption[$i];
                    $cacheSumAll = $objProduct->getNumberProduct(0, $arrayOption[$i]);
                    if ($cacheSumAll != null && count($cacheSumAll) > 0) {
                        $cache->set($cacheOptionSort, $cacheSumAll, TIMECACHE);
                    }
                    $total = ceil($cacheSumAll / PAGEING);
                    for ($j = 1; $j <= $total; $j++) {
                        $start = ($j - 1) * PAGEING;
                        $optionPage = $arrayOption[$i] . "_" . $j;
                        $arrayData = $objProduct->sortProduct($start, PAGEING, 0, $arrayOption[$i]);
                        if ($arrayData != null && count($arrayData) > 0) {
                            $cache->set($optionPage, $arrayData, TIMECACHE);
                        }
                    }
                }
            } else {
                $cacheOptionSort = "SUM_SORT_" . $sort_option;
                $cacheSumAll = $objProduct->getNumberProduct(0, $sort_option);
                if ($cacheSumAll != null && count($cacheSumAll) > 0) {
                    $cache->set($cacheOptionSort, $cacheSumAll, TIMECACHE);
                }
                $total = ceil($cacheSumAll / PAGEING);
                for ($j = 1; $j <= $total; $j++) {
                    $start = ($j - 1) * PAGEING;
                    $optionPage = $sort_option . "_" . $j;
                    $arrayData = $objProduct->sortProduct($start, PAGEING, 0, $sort_option);
                    if ($arrayData != null && count($arrayData) > 0) {
                        $cache->set($optionPage, $arrayData, TIMECACHE);
                    }
                }
            }
        }
        $success = "Cập nhật cache sắp xếp tất cả sản phẩm thành công";
        $view = "view/caches/index.phtml";
        break;
    case "sort_all_product_by_category":
        $arrayOption = array("none", "price-asc", "price-desc", "name-asc", "name-desc", "price-sale");
        if (!empty($_POST)) {
            $sort_option = $_POST['sort_option'];
            $idCategory = $_POST['listMenuItem'];
            if ($sort_option == "all" && $idCategory == "all") {
                $arrayCategoryLevel = $objCat->Menu($id_cate_product_pr);
                foreach ($arrayCategoryLevel as $k => $value) {
                    $idCategory = $value['MENU_ID'];
                    for ($i = 0; $i < count($arrayOption); $i++) {
                        $cacheOptionSortCate = "SUM_SORT_" . $arrayOption[$i] . "_" . $idCategory;
                        $cacheSumCate = $objProduct->getNumberProduct($idCategory, $arrayOption[$i]);
                        if ($cacheSumCate != null && count($cacheSumCate) > 0) {
                            $cache->set($cacheOptionSortCate, $cacheSumCate, TIMECACHE);
                        }
                        if ($cacheSumCate > 0) {
                            $total = ceil($cacheSumCate / PAGEING);
                            for ($j = 1; $j <= $total; $j++) {
                                $start = ($j - 1) * PAGEING;
                                $optionPageCate = $arrayOption[$i] . "_" . $j . "_" . $idCategory;
                                $arrayData = $objProduct->sortProduct($start, PAGEING, $idCategory, $arrayOption[$i]);
                                if ($arrayData != null && count($arrayData) > 0) {
                                    $cache->set($optionPageCate, $arrayData, TIMECACHE);
                                }
                            }
                        }
                    }
                }
            } else {
                if ($sort_option != "all" && $idCategory == "all") {
                    $arrayCategoryLevel = $objCat->Menu($id_cate_product_pr);
                    foreach ($arrayCategoryLevel as $k => $value) {
                        $idCategory = $value['MENU_ID'];
                        $cacheOptionSortCate = "SUM_SORT_" . $sort_option . "_" . $idCategory;
                        $cacheSumCate = $objProduct->getNumberProduct($idCategory, $sort_option);
                        if ($cacheSumCate != null && count($cacheSumCate) > 0) {
                            $cache->set($cacheOptionSortCate, $cacheSumCate, TIMECACHE);
                        }
                        if ($cacheSumCate > 0) {
                            $total = ceil($cacheSumCate / PAGEING);
                            for ($j = 1; $j <= $total; $j++) {
                                $start = ($j - 1) * PAGEING;
                                $optionPageCate = $sort_option . "_" . $j . "_" . $idCategory;
                                $arrayData = $objProduct->sortProduct($start, PAGEING, $idCategory, $sort_option);
                                if ($arrayData != null && count($arrayData) > 0) {
                                    $cache->set($optionPageCate, $arrayData, TIMECACHE);
                                }
                            }
                        }
                    }
                } else {
                    if ($sort_option == "all" && $idCategory != "all") {
                        for ($i = 0; $i < count($arrayOption); $i++) {
                            $cacheOptionSortCate = "SUM_SORT_" . $arrayOption[$i] . "_" . $idCategory;
                            $cacheSumCate = $objProduct->getNumberProduct($idCategory, $arrayOption[$i]);
                            if ($cacheSumCate != null && count($cacheSumCate) > 0) {
                                $cache->set($cacheOptionSortCate, $cacheSumCate, TIMECACHE);
                            }
                            if ($cacheSumCate > 0) {
                                $total = ceil($cacheSumCate / PAGEING);
                                for ($j = 1; $j <= $total; $j++) {
                                    $start = ($j - 1) * PAGEING;
                                    $optionPageCate = $arrayOption[$i] . "_" . $j . "_" . $idCategory;
                                    $arrayData = $objProduct->sortProduct($start, PAGEING, $idCategory, $arrayOption[$i]);
                                    if ($arrayData != null && count($arrayData) > 0) {
                                        $cache->set($optionPageCate, $arrayData, TIMECACHE);
                                    }
                                }
                            }
                        }
                    } else {
                        for ($i = 0; $i < count($arrayOption); $i++) {
                            $cacheOptionSortCate = "SUM_SORT_" . $sort_option . "_" . $idCategory;
                            $cacheSumCate = $objProduct->getNumberProduct($idCategory, $sort_option);
                            if ($cacheSumCate != null && count($cacheSumCate) > 0) {
                                $cache->set($cacheOptionSortCate, $cacheSumCate, TIMECACHE);
                            }
                            if ($cacheSumCate > 0) {
                                $total = ceil($cacheSumCate / PAGEING);
                                for ($j = 1; $j <= $total; $j++) {
                                    $start = ($j - 1) * PAGEING;
                                    $optionPageCate = $sort_option . "_" . $j . "_" . $idCategory;
                                    $arrayData = $objProduct->sortProduct($start, PAGEING, $idCategory, $sort_option);
                                    if ($arrayData != null && count($arrayData) > 0) {
                                        $cache->set($optionPageCate, $arrayData, TIMECACHE);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $success = "Cập nhật cache sắp xếp sản phẩm theo danh mục thành công";
        $view = "view/caches/index.phtml";
        break;
    case "all_product":
        $listAllProduct = $objProduct->getListAllProduct();
        $cacheProductAll = "CACHE_PRODUCT_ALL";//tat ca sp
        $cacheSumAllProduct = $objProduct->getNumberProductAll();
        if ($cacheSumAllProduct != null && count($cacheSumAllProduct) > 0) {
            $cache->set($cacheProductAll, $cacheSumAllProduct, TIMECACHE);
        }
        if ($cacheSumAllProduct > 0) {
            $total = ceil($cacheSumAllProduct / PAGEING);
            for ($k = 1; $k <= $total; $k++) {
                $start = ($k - 1) * PAGEING;
                $cacheProductAllPage = "CACHE_PRODUCT_ALL_" . $k;
                $arrayData = $objProduct->getListProductLimitAll($start, PAGEING);
                if ($arrayData != null && count($arrayData) > 0) {
                    $cache->set($cacheProductAllPage, $arrayData, TIMECACHE);
                }
            }
        }
        $success = "Cập nhật cache thành công";
        $view = "view/caches/index.phtml";
        break;
    case "sp_cung_loai":
        if (!empty($_POST)) {
            $idCategory = $_POST['listMenuItem'];
            if ($idCategory == "all") {
                $arrayCategoryLevel = $objCat->Menu($id_cate_product_pr);
                foreach ($arrayCategoryLevel as $k => $value) {
                    $idCategory = $value['MENU_ID'];
                    $listProductByCate = $objProduct->getListProductByCategory($idCategory);
                    if (count($listProductByCate) > 0) {
                        foreach ($listProductByCate as $k => $value) {
                            $listOrderCache = "LIST_ORDER_CACHE_" . $value['ID'] . "_" . $idCategory;
                            $listProductOrderCategory = $objProduct->getListProductOrderCategory($value['ID'], $idCategory, LIST_PRODUCT_ORDER);//list sp khac
                            if ($listProductOrderCategory != null && count($listProductOrderCategory) > 0) {
                                $cache->set($listOrderCache, $listProductOrderCategory, TIMECACHE);
                            }
                        }
                    }
                }
            } else {
                $listProductByCate = $objProduct->getListProductByCategory($idCategory);
                if (count($listProductByCate) > 0) {
                    foreach ($listProductByCate as $k => $value) {
                        $listOrderCache = "LIST_ORDER_CACHE_" . $value['ID'] . "_" . $idCategory;
                        $listProductOrderCategory = $objProduct->getListProductOrderCategory($value['ID'], $idCategory, LIST_PRODUCT_ORDER);//list sp khac
                        if ($listProductOrderCategory != null && count($listProductOrderCategory) > 0) {
                            $cache->set($listOrderCache, $listProductOrderCategory, TIMECACHE);
                        }
                    }
                }
            }
        }
        $success = "Cập nhật cache sản phẩm cùng loại thành công";
        $view = "view/caches/index.phtml";
        break;
    case "sp_theo_danh_muc":
        if (!empty($_POST)) {
            $idCategory = $_POST['listMenuItem'];
            if ($idCategory == "all") {
                $arrayCategoryLevel = $objCat->Menu($id_cate_product_pr);
                foreach ($arrayCategoryLevel as $k => $value) {
                    $idCategory = $value['MENU_ID'];
                    $categoryCache = "CATEGORY_" . $idCategory;
                    $cacheSumByCate = $objProduct->getNumberProductByCategory($idCategory);
                    if ($cacheSumByCate != null && count($cacheSumByCate) > 0) {
                        $cache->set($categoryCache, $cacheSumByCate, TIMECACHE);
                    }
                    if ($cacheSumByCate > 0) {
                        $total = ceil($cacheSumByCate / PAGEING);
                        for ($k = 1; $k <= $total; $k++) {
                            $start = ($k - 1) * PAGEING;
                            $pageCategoryCache = "PAGE_CATEGORY_" . $idCategory . "_" . $k;
                            $arrayData = $objProduct->getListProductLimitByCategory($start, PAGEING, $idCategory);
                            if ($arrayData != null && count($arrayData) > 0) {
                                $cache->set($pageCategoryCache, $arrayData, TIMECACHE);
                            }
                        }
                    }
                }
            } else {
                $categoryCache = "CATEGORY_" . $idCategory;
                $cacheSumByCate = $objProduct->getNumberProductByCategory($idCategory);
                if ($cacheSumByCate != null && count($cacheSumByCate) > 0) {
                    $cache->set($categoryCache, $cacheSumByCate, TIMECACHE);
                }
                if ($cacheSumByCate > 0) {
                    $total = ceil($cacheSumByCate / PAGEING);
                    for ($k = 1; $k <= $total; $k++) {
                        $start = ($k - 1) * PAGEING;
                        $pageCategoryCache = "PAGE_CATEGORY_" . $idCategory . "_" . $k;
                        $arrayData = $objProduct->getListProductLimitByCategory($start, PAGEING, $idCategory);
                        if ($arrayData != null && count($arrayData) > 0) {
                            $cache->set($pageCategoryCache, $arrayData, TIMECACHE);
                        }
                    }
                }
            }
        }
        $success = "Cập nhật cache sản phẩm theo danh muc thành công";
        $view = "view/caches/index.phtml";
        break;
    case "product_buys":
        $listProductBuys = $objProduct->getListProductBuys(LIST_PRODUCT_BUYS);
		$cache->delete(LIST_PRODUCT_BUYS_NAME);
        if ($listProductBuys != null && count($listProductBuys) > 0) {
            $cache->set(LIST_PRODUCT_BUYS_NAME, $listProductBuys, TIMECACHE);
        }
        $success = "Cập nhật cache sản phẩm mua nhiều thành công";
        $view = "view/caches/index.phtml";
        break;
    case "product_hot":
        $listProductHot = $objProduct->getListProduct_Hot(LIST_PRODUCT_HOT);
		$cache->delete(LIST_PRODUCT_HOT_NAME);
        if ($listProductHot != null && count($listProductHot) > 0) {
            $cache->set(LIST_PRODUCT_HOT_NAME, $listProductHot, TIMECACHE);
        }
        $success = "Cập nhật cache sản phẩm mới  thành công";
        $view = "view/caches/index.phtml";
        break;
    case "product_slide":
        $listProductSlide = $objProduct->getListProduct_Top(LIST_PRODUCT_TOP);
		$cache->delete(LIST_PRODUCT_TOP_NAME);
        if ($listProductSlide != null && count($listProductSlide) > 0) {
            $cache->set(LIST_PRODUCT_TOP_NAME, $listProductSlide, TIMECACHE);
        }
        $success = "Cập nhật cache sản phẩm slide thành công";
        $view = "view/caches/index.phtml";
        break;
    case "all_product_category_home":
        $listProduct = shuffle_assoc($objProduct->getListProductHomeAllCategory(NUM_PRODUCT_HOME_BY_CATE));
        if ($listProduct != null && count($listProduct) > 0) {
            $cache->set(LIST_PRODUCT_HOME_NAME, $listProduct, TIMECACHE);
        }
        $success = "Cập nhật cache sản phẩm trang chủ thành công";
        $view = "view/caches/index.phtml";
        break;
    case "product_parent":
        if (!empty($_POST)) {
            $idCategory = $_POST['listMenuItem'];
            if($idCategory=="all") {
                $listAllProduct = $objProduct->getListAllProduct();
                foreach ($listAllProduct as $k => $value) {
                    if ($value['ID'] == $value['PRODUCT_PARENT']) {
                        $cacheProductDetail = "PRODUCT_DETAIL_" . $value['ID'];
                        $cacheProductParent = "PRODUCT_DETAIL_PARENT" . $value['ID'];
                        $arrayFeatureType = explode(";", $value['FEATURE_TEXT']);
                        $arrayFeatureTypeEnd = array();
                        $h = 0;
                        $j = 0;
                        for ($k = 0; $k < count($arrayFeatureType); $k++) {
                            $h++;
                            $j++;
                            $strNameFeature = "";
                            $arrayFeatureTemp = explode(",", $arrayFeatureType[$k]);
                            if (count($arrayFeatureTemp) > 1) {
                                $cacheFeatureTypeName = "FEATURE_TYPE_NAME_" . $value['ID'] . "_" . $arrayFeatureTemp[0] . "_" . $arrayFeatureType[$k];
                                $nameFeatureType = $objProduct->getFeatureTypeNameById($arrayFeatureTemp[0]);
                                if ($nameFeatureType != null && count($nameFeatureType) > 0) {
                                    $cache->set($cacheFeatureTypeName, $nameFeatureType, TIMECACHE);
                                }
                                for ($i = 1; $i < count($arrayFeatureTemp); $i++) {
                                    $cacheFeatureName = "FEATURE_NAME_" . $value['ID'] . "_" . $arrayFeatureTemp[0] . "_" . $arrayFeatureTemp[$i];
                                    $listFeature = $objProduct->getFeatureNameById($arrayFeatureTemp[$i]);
                                    if ($listFeature != null && count($listFeature) > 0) {
                                        $cache->set($cacheFeatureName, $listFeature, TIMECACHE);
                                    }
                                }
                            }
                        }
                    } else {
                        $cacheProductDetail = "PRODUCT_DETAIL_" . $value['FEATURE_TEXT'];
                        $cacheProductParent = "PRODUCT_DETAIL_PARENT" . $value['FEATURE_TEXT'];
                        $NameCacheFeature = "NAME_FEATURE_" . $value['ID'];
                        $strNameFeature = "";
                        $arrayFeatureTemp = explode(":", $value['FEATURE_TEXT']);
                        if (count($arrayFeatureTemp) > 1) {
                            for ($i = 1; $i < count($arrayFeatureTemp); $i++) {
                                $listFeature = $objProduct->getFeatureNameById($arrayFeatureTemp[$i]);
                                $strNameFeature .= $listFeature[0]['DESCRIPTF'] . " -- ";
                            }
                            $strNameFeature = substr($strNameFeature, 0, -4);
                            $cache->set($NameCacheFeature, $strNameFeature, TIMECACHE);
                        }
                    }
                    $productDetail = $objProduct->getProductById($value['ID']);
                    if ($productDetail != null && count($productDetail) > 0) {
                        $cache->set($cacheProductDetail, $productDetail, TIMECACHE);
                    }
                    $productParent = $objProduct->getProductParent($value['PRODUCT_PARENT']);
                    if ($productParent != null && count($productParent) > 0) {
                        $cache->set($cacheProductParent, $productParent, TIMECACHE);
                    }
                }
            }else{
                $listAllProduct = $objProduct->getListProductByCategory($idCategory);
                foreach ($listAllProduct as $k => $value) {
                    if ($value['ID'] == $value['PRODUCT_PARENT']) {
                        $cacheProductDetail = "PRODUCT_DETAIL_" . $value['ID'];
                        $cacheProductParent = "PRODUCT_DETAIL_PARENT" . $value['ID'];
                        $arrayFeatureType = explode(";", $value['FEATURE_TEXT']);
                        $arrayFeatureTypeEnd = array();
                        $h = 0;
                        $j = 0;
                        for ($k = 0; $k < count($arrayFeatureType); $k++) {
                            $h++;
                            $j++;
                            $strNameFeature = "";
                            $arrayFeatureTemp = explode(",", $arrayFeatureType[$k]);
                            if (count($arrayFeatureTemp) > 1) {
                                $cacheFeatureTypeName = "FEATURE_TYPE_NAME_" . $value['ID'] . "_" . $arrayFeatureTemp[0] . "_" . $arrayFeatureType[$k];
                                $nameFeatureType = $objProduct->getFeatureTypeNameById($arrayFeatureTemp[0]);
                                if ($nameFeatureType != null && count($nameFeatureType) > 0) {
                                    $cache->set($cacheFeatureTypeName, $nameFeatureType, TIMECACHE);
                                }
                                for ($i = 1; $i < count($arrayFeatureTemp); $i++) {
                                    $cacheFeatureName = "FEATURE_NAME_" . $value['ID'] . "_" . $arrayFeatureTemp[0] . "_" . $arrayFeatureTemp[$i];
                                    $listFeature = $objProduct->getFeatureNameById($arrayFeatureTemp[$i]);
                                    if ($listFeature != null && count($listFeature) > 0) {
                                        $cache->set($cacheFeatureName, $listFeature, TIMECACHE);
                                    }
                                }
                            }
                        }
                    } else {
                        $cacheProductDetail = "PRODUCT_DETAIL_" . $value['FEATURE_TEXT'];
                        $cacheProductParent = "PRODUCT_DETAIL_PARENT" . $value['FEATURE_TEXT'];
                        $NameCacheFeature = "NAME_FEATURE_" . $value['ID'];
                        $strNameFeature = "";
                        $arrayFeatureTemp = explode(":", $value['FEATURE_TEXT']);
                        if (count($arrayFeatureTemp) > 1) {
                            for ($i = 1; $i < count($arrayFeatureTemp); $i++) {
                                $listFeature = $objProduct->getFeatureNameById($arrayFeatureTemp[$i]);
                                $strNameFeature .= $listFeature[0]['DESCRIPTF'] . " -- ";
                            }
                            $strNameFeature = substr($strNameFeature, 0, -4);
                            $cache->set($NameCacheFeature, $strNameFeature, TIMECACHE);
                        }
                    }
                    $productDetail = $objProduct->getProductById($value['ID']);
                    if ($productDetail != null && count($productDetail) > 0) {
                        $cache->set($cacheProductDetail, $productDetail, TIMECACHE);
                    }
                    $productParent = $objProduct->getProductParent($value['PRODUCT_PARENT']);
                    if ($productParent != null && count($productParent) > 0) {
                        $cache->set($cacheProductParent, $productParent, TIMECACHE);
                    }
                }
            }
        }
        $success = "Cập nhật cache sản phẩm theo tính năng thành công";
        $view = "view/caches/index.phtml";
        break;
    case "tags":
        $arrayTags = $objFunction->buildTags(NUM_TAGS_VIEW);
        if ($arrayTags != null && count($arrayTags) > 0) {
            $cache->set(LIST_PRODUCT_TAG, $arrayTags, TIMECACHE);
        }
        $success = "Cập nhật cache tags thành công";
        $view = "view/caches/index.phtml";
        break;
    case "productCache":
        //set_time_limit(0);
//        $arrayCacheIndexProduct = $cache->get("ProductIndex");
//        //var_dump($arrayCacheIndexProduct);
//        if ($arrayCacheIndexProduct != null && count($arrayCacheIndexProduct) > 0) {
//            foreach ($arrayCacheIndexProduct as $k => $value) {
//                $cache->delete($value);
//            }
//        }
        $arrayIndexProduct = array();
        //start cache sort all product
        $arrayOption = array("none", "price-asc", "price-desc", "name-asc", "name-desc", "price-sale");
        for ($i = 0; $i < count($arrayOption); $i++) {
            $cacheOptionSort = "SUM_SORT_" . $arrayOption[$i];
            $cacheSumAll = $objProduct->getNumberProduct(0, $arrayOption[$i]);
            if ($cacheSumAll != null && count($cacheSumAll) > 0) {
                $cache->set($cacheOptionSort, $cacheSumAll, TIMECACHE);
                array_push($arrayIndexProduct, $cacheOptionSort);
            }
            $total = ceil($cacheSumAll / PAGEING);
            for ($j = 1; $j <= $total; $j++) {
                $start = ($j - 1) * PAGEING;
                $optionPage = $arrayOption[$i] . "_" . $j;
                $arrayData = $objProduct->sortProduct($start, PAGEING, 0, $arrayOption[$i]);
                if ($arrayData != null && count($arrayData) > 0) {
                    $cache->set($optionPage, $arrayData, TIMECACHE);
                    array_push($arrayIndexProduct, $optionPage);
                }
            }
        }
        //end  cache sort all product

        //start cache sort by category product
        $arrayCategoryLevel = $objMenuItem->getListMenuByLevel(1);
        foreach ($arrayCategoryLevel as $k => $value) {
            $idCategory = $value['MENU_ID'];
            for ($i = 0; $i < count($arrayOption); $i++) {
                $cacheOptionSortCate = "SUM_SORT_" . $arrayOption[$i] . "_" . $idCategory;
                $cacheSumCate = $objProduct->getNumberProduct($idCategory, $arrayOption[$i]);
                if ($cacheSumCate != null && count($cacheSumCate) > 0) {
                    $cache->set($cacheOptionSortCate, $cacheSumCate, TIMECACHE);
                    array_push($arrayIndexProduct, $cacheOptionSortCate);
                }
                if ($cacheSumCate > 0) {
                    $total = ceil($cacheSumCate / PAGEING);
                    for ($j = 1; $j <= $total; $j++) {
                        $start = ($j - 1) * PAGEING;
                        $optionPageCate = $arrayOption[$i] . "_" . $j . "_" . $idCategory;
                        $arrayData = $objProduct->sortProduct($start, PAGEING, $idCategory, $arrayOption[$i]);
                        if ($arrayData != null && count($arrayData) > 0) {
                            $cache->set($optionPageCate, $arrayData, TIMECACHE);
                            array_push($arrayIndexProduct, $optionPageCate);
                        }
                    }
                }
            }
            //cache san pham cung loai
            $listProductByCate = $objProduct->getListProductByCategory($idCategory);
            if (count($listProductByCate) > 0) {
                foreach ($listProductByCate as $k => $value) {
                    $listOrderCache = "LIST_ORDER_CACHE_" . $value['ID'] . "_" . $idCategory;
                    $listProductOrderCategory = $objProduct->getListProductOrderCategory($value['ID'], $idCategory, LIST_PRODUCT_ORDER);//list sp khac
                    if ($listProductOrderCategory != null && count($listProductOrderCategory) > 0) {
                        $cache->set($listOrderCache, $listProductOrderCategory, TIMECACHE);
                        array_push($arrayIndexProduct, $listOrderCache);
                    }
                }
            }

            //cache san them danh muc
            $categoryCache = "CATEGORY_" . $idCategory;
            $cacheSumByCate = $objProduct->getNumberProductByCategory($idCategory);
            if ($cacheSumByCate != null && count($cacheSumByCate) > 0) {
                $cache->set($categoryCache, $cacheSumByCate, TIMECACHE);
                array_push($arrayIndexProduct, $categoryCache);
            }
            if ($cacheSumByCate > 0) {
                $total = ceil($cacheSumByCate / PAGEING);
                for ($k = 1; $k <= $total; $k++) {
                    $start = ($k - 1) * PAGEING;
                    $pageCategoryCache = "PAGE_CATEGORY_" . $idCategory . "_" . $k;
                    $arrayData = $objProduct->getListProductLimitByCategory($start, PAGEING, $idCategory);
                    if ($arrayData != null && count($arrayData) > 0) {
                        $cache->set($pageCategoryCache, $arrayData, TIMECACHE);
                        array_push($arrayIndexProduct, $pageCategoryCache);
                    }
                }
            }
        }
        //end cache sort by category product

        $listAllProduct = $objProduct->getListAllProduct();
        $cacheProductAll = "CACHE_PRODUCT_ALL";//tat ca sp
        $cacheSumAllProduct = $objProduct->getNumberProductAll();
        if ($cacheSumAllProduct != null && count($cacheSumAllProduct) > 0) {
            $cache->set($cacheProductAll, $cacheSumAllProduct, TIMECACHE);
            array_push($arrayIndexProduct, $cacheProductAll);
        }
        if ($cacheSumAllProduct > 0) {
            $total = ceil($cacheSumAllProduct / PAGEING);
            for ($k = 1; $k <= $total; $k++) {
                $start = ($k - 1) * PAGEING;
                $cacheProductAllPage = "CACHE_PRODUCT_ALL_" . $k;
                $arrayData = $objProduct->getListProductLimitAll($start, PAGEING);
                if ($arrayData != null && count($arrayData) > 0) {
                    $cache->set($cacheProductAllPage, $arrayData, TIMECACHE);
                    array_push($arrayIndexProduct, $cacheProductAllPage);
                }
            }
        }

        $listProductBuys = $objProduct->getListProductBuys(LIST_PRODUCT_BUYS);
        if ($listProductBuys != null && count($listProductBuys) > 0) {
            $cache->set(LIST_PRODUCT_BUYS_NAME, $listProductBuys, TIMECACHE);
            array_push($arrayIndexProduct, LIST_PRODUCT_BUYS_NAME);
        }

        $listProductHot = $objProduct->getListProduct_Hot(LIST_PRODUCT_HOT);
        if ($listProductHot != null && count($listProductHot) > 0) {
            $cache->set(LIST_PRODUCT_HOT_NAME, $listProductHot, TIMECACHE);
            array_push($arrayIndexProduct, LIST_PRODUCT_HOT_NAME);
        }

        $listProductSlide = $objProduct->getListProduct_Top(LIST_PRODUCT_TOP);
        if ($listProductSlide != null && count($listProductSlide) > 0) {
            $cache->set(LIST_PRODUCT_TOP_NAME, $listProductSlide, TIMECACHE);
            array_push($arrayIndexProduct, LIST_PRODUCT_TOP_NAME);
        }

        $listProduct = shuffle_assoc($objProduct->getListProductHomeAllCategory(NUM_PRODUCT_HOME_BY_CATE));
        if ($listProduct != null && count($listProduct) > 0) {
            $cache->set(LIST_PRODUCT_HOME_NAME, $listProduct, TIMECACHE);
            array_push($arrayIndexProduct, LIST_PRODUCT_HOME_NAME);
        }


        foreach ($listAllProduct as $k => $value) {
            if ($value['ID'] == $value['PRODUCT_PARENT']) {
                $cacheProductDetail = "PRODUCT_DETAIL_" . $value['ID'];
                $cacheProductParent = "PRODUCT_DETAIL_PARENT" . $value['ID'];
                $arrayFeatureType = explode(";", $value['FEATURE_TEXT']);
                $arrayFeatureTypeEnd = array();
                $h = 0;
                $j = 0;
                for ($k = 0; $k < count($arrayFeatureType); $k++) {
                    $h++;
                    $j++;
                    $strNameFeature = "";
                    $arrayFeatureTemp = explode(",", $arrayFeatureType[$k]);
                    if (count($arrayFeatureTemp) > 1) {
                        $cacheFeatureTypeName = "FEATURE_TYPE_NAME_" . $value['ID'] . "_" . $arrayFeatureTemp[0] . "_" . $arrayFeatureType[$k];
                        $nameFeatureType = $objProduct->getFeatureTypeNameById($arrayFeatureTemp[0]);
                        if ($nameFeatureType != null && count($nameFeatureType) > 0) {
                            $cache->set($cacheFeatureTypeName, $nameFeatureType, TIMECACHE);
                            array_push($arrayIndexProduct, $cacheFeatureTypeName);
                        }
                        for ($i = 1; $i < count($arrayFeatureTemp); $i++) {
                            $cacheFeatureName = "FEATURE_NAME_" . $value['ID'] . "_" . $arrayFeatureTemp[0] . "_" . $arrayFeatureTemp[$i];
                            $listFeature = $objProduct->getFeatureNameById($arrayFeatureTemp[$i]);
                            if ($listFeature != null && count($listFeature) > 0) {
                                $cache->set($cacheFeatureName, $listFeature, TIMECACHE);
                                array_push($arrayIndexProduct, $cacheFeatureName);
                            }
                        }
                    }
                }
            } else {
                $cacheProductDetail = "PRODUCT_DETAIL_" . $value['FEATURE_TEXT'];
                $cacheProductParent = "PRODUCT_DETAIL_PARENT" . $value['FEATURE_TEXT'];
                $NameCacheFeature = "NAME_FEATURE_" . $value['ID'];
                $strNameFeature = "";
                $arrayFeatureTemp = explode(":", $value['FEATURE_TEXT']);
                if (count($arrayFeatureTemp) > 1) {
                    for ($i = 1; $i < count($arrayFeatureTemp); $i++) {
                        $listFeature = $objProduct->getFeatureNameById($arrayFeatureTemp[$i]);
                        $strNameFeature .= $listFeature[0]['DESCRIPTF'] . " -- ";
                    }
                    $strNameFeature = substr($strNameFeature, 0, -4);
                    $cache->set($NameCacheFeature, $strNameFeature, TIMECACHE);
                    array_push($arrayIndexProduct, $NameCacheFeature);
                }
            }
            $productDetail = $objProduct->getProductById($value['ID']);
            if ($productDetail != null && count($productDetail) > 0) {
                $cache->set($cacheProductDetail, $productDetail, TIMECACHE);
                array_push($arrayIndexProduct, $cacheProductDetail);
            }
            $productParent = $objProduct->getProductParent($value['PRODUCT_PARENT']);
            if ($productParent != null && count($productParent) > 0) {
                $cache->set($cacheProductParent, $productParent, TIMECACHE);
                array_push($arrayIndexProduct, $cacheProductParent);
            }
        }

        $arrayTags = $objFunction->buildTags(NUM_TAGS_VIEW);
        if ($arrayTags != null && count($arrayTags) > 0) {
            $cache->set(LIST_PRODUCT_TAG, $arrayTags, TIMECACHE);
            array_push($arrayIndexProduct, LIST_PRODUCT_TAG);
        }

        //$cache->set("ProductIndex", $arrayIndexProduct);
        $success = "Cập nhật cache sản phẩm thành công";
        $view = "view/caches/index.phtml";
        break;
    case "cacheNews":
        $arrayCacheIndexNews = $cache->get("NewsIndex");
        if ($arrayCacheIndexNews != null && count($arrayCacheIndexNews) > 0) {
            foreach ($arrayCacheIndexNews as $k => $value) {
                $cache->delete($value);
            }
        }
        $arrayIndexNews = array();
        //start cache news home
        $listNews = $objNews->getListNews(LIST_NEWS_HOME);
        if ($listNews != null && count($listNews) > 0) {
            $cache->set(LIST_NEWS_NAME, $listNews, TIMECACHE);
            array_push($arrayIndexNews, LIST_NEWS_NAME);
        }
        //end cache news home
        //start cache news all
        $cacheNewsAll = "CACHE_NEWS_ALL";
        $cacheSum = $objNews->getNumAllNews();
        if ($cacheSum != null && count($cacheSum) > 0) {
            $cache->set($cacheNewsAll, $cacheSum, TIMECACHE);
            array_push($arrayIndexNews, $cacheNewsAll);
        }
        $total = ceil($cacheSum / PAGE_NEWS);
        for ($i = 1; $i <= $total; $i++) {
            $start = ($i - 1) * PAGE_NEWS;
            $cacheNewsAllPage = "CACHE_NEWS_ALL_" . $i;
            $listNews = $objNews->getNews_Limit_start_end($start, PAGE_NEWS);
            if ($listNews != null && count($listNews) > 0) {
                $cache->set($cacheNewsAllPage, $listNews, TIMECACHE);
                array_push($arrayIndexNews, $cacheNewsAllPage);
            }
        }
        //end cache news all
        //start cache news detail
        $listNewsAll = $objNews->getListAllNews();
        foreach ($listNewsAll as $k => $value) {
            $cacheNewsDetail = "NEWS_DETAIL_" . $value['NEWS_ID'];
            $cache->set($cacheNewsDetail, array($value), TIMECACHE);
            array_push($arrayIndexNews, $cacheNewsDetail);
        }
        //end cache news detail
        $cache->set("NewsIndex", $arrayIndexNews);
        $success = "Cập nhật cache tin tức thành công";
        $view = "view/caches/index.phtml";
        break;
    case "Category":
        $arrayCacheIndexCategory = $cache->get("CategoryIndex");
        if ($arrayCacheIndexCategory != null && count($arrayCacheIndexCategory) > 0) {
            foreach ($arrayCacheIndexCategory as $k => $value) {
                $cache->delete($value);
            }
        }
        $arrayIndexCategory = array();
        $arrayMenuItem = $objMenuItem->getListMenu();
        if ($arrayMenuItem != null && count($arrayMenuItem) > 0) {
            $cache->set('listMenu', $arrayMenuItem, TIMECACHE);
            array_push($arrayIndexCategory, 'listMenu');
        }

        $arrayCateProduct = $objMenuItem->getListMenuByLevel(1);
		$cache->delete(LIST_ARRAY_CATE);
        if ($arrayCateProduct != null && count($arrayCateProduct) > 0) {
            $cache->set(LIST_ARRAY_CATE, $arrayCateProduct, TIMECACHE);
            array_push($arrayIndexCategory, LIST_ARRAY_CATE);
        }
        foreach ($arrayCateProduct as $k => $value) {
            $cacheMenuCon = "CACHE_CATE_CHILD_" . $value['MENU_ID'];
            $array_menu_con = $objMenuItem->getListMenuByLevelAndID($value['MENU_ID'], 2);
            if ($array_menu_con != null && count($array_menu_con) > 0) {
                $cache->set($cacheMenuCon, $array_menu_con, TIMECACHE);
                array_push($arrayIndexCategory, $cacheMenuCon);
            }
        }


        $cache->set("CategoryIndex", $arrayIndexCategory);
        $success = "Cập nhật cache danh muc thành công";
        $view = "view/caches/index.phtml";
        break;
    case "box":
        $arrayCacheIndexBox = $cache->get("BoxIndex");
        if ($arrayCacheIndexBox != null && count($arrayCacheIndexBox) > 0) {
            foreach ($arrayCacheIndexBox as $k => $value) {
                $cache->delete($value);
            }
        }
        $arrayIndexBox = array();
        $arrayBox = $objBox->getAllBoxLimit(NUM_BOX_VIEW);
        if ($arrayBox != null && count($arrayBox) > 0) {
            $cache->set(LIST_BOX_NAME, $arrayBox, TIMECACHE);
            array_push($arrayIndexBox, LIST_BOX_NAME);
        }
        $cache->set("BoxIndex", $arrayIndexBox);
        $success = "Cập nhật cache liên kết hình thành công";
        $view = "view/caches/index.phtml";
        break;
    default:
        $view = "view/caches/index.phtml";
        break;
}