<?
require ("../../../member/include/config.inc.php");

$username	=	$_REQUEST['username'];
$langx		=	$_REQUEST['langx'];

if(strlen($username)>=6 && strlen($username)<=12){
	$sql = "select id from `web_agents` where Agname='$username' or passwd_safe='$username'";
	$result = mysql_query($sql);
	$cou = mysql_num_rows($result);
	$str = $cou==0 ? "Tài khoản này không được sử dụng" : "Tài khoản này đã được mọi người sử dụng";
}else{
	$str = "Tài khoản đăng nhập phải có ít nhất 2 chữ cái tiếng Anh và chữ thường và chữ số (0 ~ 9) giới hạn đầu vào kết hợp (6 ~ 12 ký tự)";
}

	echo "<meta http-equiv='Content-Type' content='text/html; charset=big5'>
<script>alert('$str');</script>";
?>