<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/mail-template.php");
$objMail = new MailTemplate();
$array = array();
$name = $_POST['mail_id'];
$txtSubject = $_POST['txtEditSubject'];
$txtLongDescription = $_POST['txtEditLongDescription'];
$txtVariablesComment = $_POST['txtEditVariablesComment'];
$Variables = isset($_POST['txtEditVariables']) ? $_POST['txtEditVariables'] :array();
$chkActive =isset($_POST['chkEditActive'])?'Y':'N';
$strVariables='';
$data=array();
if(count($Variables)>0){
	$strVariables='{{'.$Variables[0].'}}';
	for($i=1;$i<count($Variables);$i++)
		$strVariables.='#{{'.$Variables[$i].'}}';
}
$objMail->updateMailTemplate($name,$txtSubject,$txtLongDescription,$strVariables,$txtVariablesComment,$chkActive);
$json = json_encode($array);
echo($json);
?>