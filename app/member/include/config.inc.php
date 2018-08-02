<?php
require_once('global.php');
isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_FORWARDED_FOR'];

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "123456";
$dbname = "hg";

$lnk = mysql_connect($dbhost,$dbuser,$dbpass) or exit("ERROR MySQL Connect");
mysql_select_db($dbname, $lnk);

$wager_vars = array( "正常注单", "非正常注单", "", "", "赛事腰斩", "赛事延期", "赔率错误", "赛事无pk/加时", "球员弃权", "队名错误", "", "", "取消" );
$wager_vars_re = array( "正常注单", "非正常注单", "进球取消", "红卡取消", "赛事腰斩", "赛事延期", "赔率错误", "赛事无pk/加时", "球员弃权", "队名错误", "确认注单", "未确认注单", "取消" );
$match_status = array( "", "赛事取消", "赛事延期", "赛事腰斩", "赛事无pk/加时", "球员弃权", "队名错误" );
$wager_vars_p = array( "正常注单", "非正常注单", "", "", "", "", "", "", "", "", "", "", "取消" );
$ODDS=Array(
	'H'=>'香港盘',
	'M'=>'马来盘',
	'I'=>'印尼盘',
	'E'=>'欧洲盘'
);
?>
