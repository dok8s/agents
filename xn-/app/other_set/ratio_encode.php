<?php
header("Content-type: image/png");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require ("../member/include/define_function_list.inc.php");

$tmp_data=$_REQUEST['tmp_data'];

$code=substr(strtoupper(md5($tmp_data)),11,4);
$f='code'.rand(0, 9).'.png';

$im=LoadPNG("$f","$code");
imagepng($im);
?> 