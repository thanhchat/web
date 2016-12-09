<?php

class database
{
    private $host = HOST_DB;
    private $user = USERNAME_DB;
    private $pass = PASSWORD_DB;
    private $dbname = DBNAME_DB;
    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname.";charset=utf8";
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        // Create a new PDO instanace
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } // Catch any errors
        catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function Disconnect()
    {
        $this->dbh = null;
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    public function getData($sql){
        $arr = array();
        $this->query($sql);
        foreach($this->result() as $k=>$v){
            $arr[] = $v;
        }
        return $arr;
    }
    public function execute()
    {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function result()
    {
        try {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function single()
    {
        try {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function rowCount()
    {
        try {
            return $this->stmt->rowCount();
        } catch
        (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }
}

//$obj = new Database();
////$obj->bind(':email' => $email,':password' => base64_encode($password));
////$obj->bind(array(':email' => $email,':password' => base64_encode($password)));
////$obj->bind(':email', 'thanhchat1202@gmail.com');
//$rows=$obj->getData("SELECT * FROM `user_login` WHERE EMAIL='thanhchat1202@gmail.com'");
//print_r($rows);
