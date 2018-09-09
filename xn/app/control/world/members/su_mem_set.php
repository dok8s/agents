<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");

$uid=$_REQUEST["uid"];
$mid=$_REQUEST["id"];
$aid=$_REQUEST["agents_id"];

$mysql = "select * from web_world where Oid='$uid'";
$ag_result = mysql_query($mysql);
$cou=mysql_num_rows($ag_result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$langx='zh-cn';
require ("../../../member/include/traditional.$langx.inc.php");
require ("../../../member/include/define_function_list.inc.php");
require ("../../../../inc/ag_mem_set.inc.php");
?>