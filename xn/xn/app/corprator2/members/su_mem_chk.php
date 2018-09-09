<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
$uid      = $_REQUEST['uid'];
$langx    = $_REQUEST['langx'];
$username = $_REQUEST['username'];

require ("../../member/include/config.inc.php");
$sql = "select id from web_member where memname='$username'";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$count=mysql_num_rows($result);

if ($count<=0){
	echo "<SCRIPT language='javascript'>alert('此帐号无人使用!!');</script>";
	exit;
}else{
	echo "<SCRIPT language='javascript'>alert('此帐号有人使用!!');</script>";
	exit;
}
mysql_close();
?>

