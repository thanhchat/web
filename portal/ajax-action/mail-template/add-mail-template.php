<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/mail-template.php");
$objMail = new MailTemplate();
$txtName = $_POST['txtEditName'];
$txtSubject = $_POST['txtSubject'];
$txtLongDescription = $_POST['txtLongDescription'];
$txtVariablesComment = $_POST['txtVariablesComment'];
$Variables = isset($_POST['txtVariables']) ? $_POST['txtVariables'] :array();
$chkActive =isset($_POST['chkActive'])?'Y':'N';
$strVariables='';
$data=array();
if(count($Variables)>0){
	$strVariables='{{'.$Variables[0].'}}';
	for($i=1;$i<count($Variables);$i++)
		$strVariables.='#{{'.$Variables[$i].'}}';
}
$check=$objMail->getMailTemplateByName(strtoupper($txtName));
if($check!=null)
	$data['mess']=1;
else
	$objMail->addMailTemplate($txtName,$txtSubject,$txtLongDescription,$strVariables,$txtVariablesComment,$chkActive);
$json = json_encode($data);
echo($json);
?>