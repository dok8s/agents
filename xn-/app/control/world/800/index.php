<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");  
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";	
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
require ("../../../member/include/traditional.$langx.inc.php");

$sql = "select * from web_member where world='$agname' and pay_type=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou<>0){
	echo "<script>window.open('./user_list.php?uid=$uid','_self')</script>";
}else{
	echo "<script>alert('Ŀǰ��û�л�Ա������Ӻ��ڲ�������');window.open('/index.php?uid=$uid','_self')</script>";
}
mysql_close();
?>
