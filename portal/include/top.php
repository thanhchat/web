<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 31/12/2014
 * Time: 09:37 AM 50
 */
defined('_JEXEC') or die('Restricted access');
session_start();
ob_start();
//include_once("../functions/function.php");
include_once("../configs/application.php");

$REQUEST_URI = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url_array = explode('/', $REQUEST_URI);
array_shift($url_array);
$RENDER=true;
$i=0;
define('LINKS1', isset($url_array[$i])?$url_array[$i]:"");
define('LINKS2', isset($url_array[$i+1])?$url_array[$i+1]:"");
define('LINKS3', isset($url_array[$i+2])?$url_array[$i+2]:"");
define('LINKS4', isset($url_array[$i+3])?$url_array[$i+3]:"");
define('LINKS5', isset($url_array[$i+4])?$url_array[$i+4]:"");
define('LINKS6', isset($url_array[$i+5])?$url_array[$i+5]:"");
define('LINKS7', isset($url_array[$i+6])?$url_array[$i+6]:"");