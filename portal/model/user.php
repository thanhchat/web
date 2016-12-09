<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
include_once("../configs/application.php");
include_once("../connections/class.db.php");

class user extends database
{
    private $tbName = "user_login";
    private $primary = "USER_LOGIN_ID";

    public function getListUser()
    {
        $sql = "SELECT * FROM  $this->tbName ORDER BY $this->primary";
        $this->query($sql);
        $this->result();
        $count = $this->rowCount();
        return $count;
    }

    public function getListUserLimit($start, $end)
    {
        $sql = "SELECT * FROM  $this->tbName ORDER BY $this->primary LIMIT $start, $end";
        return $this->getData($sql);
    }
    public function getListAllUser()
    {
        $sql = "SELECT * FROM  $this->tbName ORDER BY $this->primary";
        return $this->getData($sql);
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM  $this->tbName WHERE EMAIL=:email";
        $this->query($sql);
        $this->bind(':email',$email);
        $this->execute();
        $count = $this->rowCount();
        return $count;
    }

    public function addUser($email, $pass, $phone, $address, $active, $role, $user, $fullname)
    {
        $sql = "INSERT INTO $this->tbName (EMAIL,PASSWORD,PHONE,ADDRESS,ENABLED,USER_ROLE,CREATED_BY_USER_LOGIN,FULLNAME) VALUES (:email,:pass,:phone,:address,:active,:role,:user,:fullname)";
        $this->query($sql);
        $this->bind(':email',$email);
        $this->bind(':pass',$pass);
        $this->bind(':phone',$phone);
        $this->bind(':address',$address);
        $this->bind(':active',$active);
        $this->bind(':role',$role);
        $this->bind(':user',$user);
        $this->bind(':fullname',$fullname);
        return $this->execute();
    }
    public function deleteUser($id){
        $sql="DELETE FROM $this->tbName WHERE $this->primary=:id";
        $this->query($sql);
        $this->bind(':id',$id);
        return $this->execute();
    }
    public function getUserById($id){
        $sql="SELECT * FROM $this->tbName WHERE $this->primary=:id";
        $this->query($sql);
        $this->bind(':id',$id);
        return $this->single();
    }
    public function updateInforUser( $phone, $address, $active, $role, $fullname,$timeUpdate,$idUpdate){
        $sql="UPDATE $this->tbName SET PHONE='" . $phone . "',ADDRESS='" . $address . "',ENABLED='".$active."',FULLNAME='" . $fullname . "',LAST_UPDATED='".$timeUpdate."' WHERE $this->primary=$idUpdate";
        $this->query($sql);
        return $this->execute();
    }
    public function updatePassUser( $pass,$idUpdate){
        $sql="UPDATE $this->tbName SET PASSWORD='" . $pass . "'  WHERE $this->primary=$idUpdate";
        $this->query($sql);
        return $this->execute();
    }
    public function searchAction($idUser,$fullname,$email,$phone,$active){
        $sql="SELECT * FROM $this->tbName";
        $flag=false;
        if(!empty($idUser)){
            $sql.=" WHERE $this->primary=$idUser";
            $flag=true;
        }
        if(!empty($fullname)){
            if($flag==true){
                $sql.=" AND FULLNAME like '%".$fullname."%'";
            }else{
                $sql.=" WHERE FULLNAME like '%".$fullname."%'";
                $flag=true;
            }
        }
        if(!empty($email)){
            if($flag==true){
                $sql.=" AND EMAIL='".$email."'";
            }else{
                $sql.=" WHERE EMAIL='".$email."'";
                $flag=true;
            }
        }
        if(!empty($phone)){
            if($flag==true){
                $sql.=" AND PHONE=$phone";
            }else{
                $sql.=" WHERE PHONE=$phone";
                $flag=true;
            }
        }
        if(!empty($active)){
            if($flag==true){
                $sql.=" AND ENABLED='".$active."'";
            }else{
                $sql.=" WHERE ENABLED='".$active."'";
                $flag=true;
            }
        }
//        echo $sql;
        return $this->getData($sql);
    }
}