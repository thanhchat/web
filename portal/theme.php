<?php
$theme = $_POST['name'];
$fp = @fopen('theme.txt', "w");
if (!$fp) {
    return;
} else {
    $data = $theme;
    fwrite($fp, $data);
}
?>