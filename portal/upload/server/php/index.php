<?php
/*
 * jQuery File Upload Plugin PHP Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
require('UploadHandler.php');
$folder='test';
$folder= $_GET['id'];
$upload_handler = new UploadHandler('../../../../public/product/'.$folder.'/');
