<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
$uid      = $_REQUEST['uid'];
$langx    = $_REQUEST['langx'];
$username = $_REQUEST['username'];

require ("../../../member/include/config.inc.php");
$sql = "select * from web_agents where memname='$username'";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$count=mysql_num_rows($result);
	
if ($count<=0){
	echo "<SCRIPT language='javascript'>alert('Tài khoản này không được sử dụng!!');</script>";
	exit;
}else{
	echo "<SCRIPT language='javascript'>alert('Tài khoản này không được sử dụng!!');</script>";
	exit;
}
mysql_close();
?>

