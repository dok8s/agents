<?
require ("../../../member/include/config.inc.php");

$username	=	$_REQUEST['username'];
$langx		=	$_REQUEST['langx'];

if(strlen($username)>=6 && strlen($username)<=12){
	$sql = "select id from `web_agents` where Agname='$username' or passwd_safe='$username'";
	$result = mysql_query($sql);
	$cou = mysql_num_rows($result);
	$str = $cou==0 ? "此帐号无人使用" : "此帐号已有人使用";
}else{
	$str = "登录帐号最少必须有2个英文大小写字母和数字(0~9)组合输入限制(6~12字元)";
}

	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<script>alert('$str');</script>";
?>