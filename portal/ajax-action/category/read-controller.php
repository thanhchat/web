<?php
$data=scandir('../../../mvc/controller');
unset($data[0]);
unset($data[1]);
$array=array();
foreach($data as $k=>$v){
	$stack = array("label" => $v, "value" => $v);
	array_push($array,$stack);
}
$json = json_encode($array);
echo($json);
?>

