<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 30/12/2014
 * Time: 11:54 AM 14
 */
include_once("../configs/application.php");
include_once("../connections/class.db.php");

class login extends database
{
    private $tbName = "user_login";
    private $primary = "USER_LOGIN_ID";
    private $username = "EMAIL";
    private $password = "PASSWORD";

    public function getListUser()
    {
        $sql = "SELECT * FROM $this->tbName";
        $result = $this->getData($sql);
        return $result;
    }

    public function checkValidLogin($user, $pass)
    {
        if (isset($user) && isset($pass)) {
            $sql = "SELECT * FROM $this->tbName WHERE :user=$this->username AND $this->password=:pass";
            $this->query($sql);
            $this->bind(':user',$user);
            $this->bind(':pass',$pass);
            $this->execute();
            $count=$this->rowCount();
            $arr=$this->single();
            if($count==1)
            {
                $_SESSION['id_user']=$arr['USER_LOGIN_ID'];
                $_SESSION['username']=$user;
                $_SESSION['time_expired'] = date("Y-m-d H:i:s");
                return true;
            }else
                return false;
        }
    }


    public function checkLogin()
    {
        if ((!isset($_SESSION['username']))) return false;

        if ((time() - strtotime($_SESSION['time_expired'])) > 20 * 60) {
            $_SESSION['username'] = "";
            $_SESSION['time_expired'] = "";
            return false;
        }
        $_SESSION['time_expired'] = date("Y-m-d H:i:s");
        return true;
    }
}