<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 01/01/2015
 * Time: 12:44 PM 57
 */
//include_once("../configs/application.php");
//include_once("../connections/class.db.php");

class MailTemplate extends database
{

    function getListMailTemplate()
    {
        $sql = "SELECT * FROM email_template";
        $result = $this->getData($sql);
        return $result;
    }
	function getMailTemplateByName($name)
    {
        $sql = "SELECT * FROM email_template WHERE NAME='$name'";
        $result = $this->getData($sql);
        return $result;
    }
	function addMailTemplate($name,$subject,$description,$variables,$commentVariables,$status)
    {
        try {
			
            $this->beginTransaction();
            $sql = "INSERT INTO email_template(NAME,SUBJECT, DESCRIPTION, VARIABLES,COMMENT_VARIABLES, STATUS) VALUES (:name,:subject,:description,:variables,:commentVariables,:status)";
            $this->query($sql);
            $this->bind(':name', $name);
            $this->bind(':description', $description);
            $this->bind(':subject', $subject);
            $this->bind(':status', $status);
            $this->bind(':variables', $variables);
            $this->bind(':commentVariables', $commentVariables);
            $this->execute();
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
    }

	function updateMailTemplate($id,$subject,$description,$variables,$commentVariables,$status)
    {
		$i=0;
        try {
            $this->beginTransaction();
            $sql = "UPDATE email_template SET SUBJECT=:subject, DESCRIPTION=:description, VARIABLES=:variables,COMMENT_VARIABLES=:commentVariables, STATUS=:status WHERE NAME=:name";
            $this->query($sql);
            $this->bind(':name', $id);
            $this->bind(':description', $description);
            $this->bind(':subject', $subject);
            $this->bind(':status', $status);
            $this->bind(':commentVariables', $commentVariables);
            $this->bind(':variables', $variables);
            $this->execute();
			$i=1;
            $this->endTransaction();
        } catch (PDOException $e) {
            $this->cancelTransaction();
            throw new Exception($e->getMessage());
        }
		return $i;
    }
}