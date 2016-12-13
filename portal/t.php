<?php
include_once("EmailTemplate.php");
$template=new EmailTemplate();
$variables=array(
    '{{User}}'=>'Nguyên Vũ',
    '{{website}}'=>'bebap.tk',
    '{{info}}'=>'CTY TNHH HÔ MƯA GỌI GIÓ'

);
$emailTemplate=$template->getTemplate('template-web.tbl','');
echo $template->getContentFinal('TEST',$variables,$emailTemplate);

