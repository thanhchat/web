<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?php
include_once("../../../configs/application.php");
include_once("../../../connections/class.db.php");
include_once("../../model/mail-template.php");
$objMail = new MailTemplate();
$array = array();
if(isset($_GET['detail'])){
	$array = $objMail->getMailTemplateByName($_GET['detail']);
}else{
	$listMail = $objMail->getListMailTemplate();
    if (count($listMail) > 0) {
        foreach ($listMail as $k => $v) {
            $ac = 'Ẩn';
            if ($v['STATUS'] == 'Y')
                $ac = 'Hiển thị';
            $stack = array("ID" => $v['ID'], "NAME" => $v['NAME'], "SUBJECT" => $v['SUBJECT'], "DESCRIPTION" => $v['DESCRIPTION'], "VARIABLES" => $v['VARIABLES'], "COMMENT_VARIABLES" => $v['COMMENT_VARIABLES'], "STATUS" => $ac);
            array_push($array, $stack);
        }
    }
}
$json = json_encode($array);
echo($json);
?>