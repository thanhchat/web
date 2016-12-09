<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:08 PM 40
 */
if (isset($_SESSION['username']) && isset($_SESSION['time_expired'])) {
    $_SESSION['username'] = "";
    $_SESSION['time_expired'] = "";
    session_destroy();
    header("location:login.php");
}