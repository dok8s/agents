<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");  
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
$langx='zh-tw';
require ("../../member/include/traditional.$langx.inc.php");

$sql = "select * from web_member where corprator='$agname' and pay_type=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou<>0){
	echo "<script>window.open('./user_list.php?uid=$uid','_self')</script>";
	exit;
}else{
	echo "<script>alert('目前还没有会员，请添加后在操作！！');window.open('/index.php?uid=$uid','_self')</script>";
	exit;
}
mysql_close();
?>
