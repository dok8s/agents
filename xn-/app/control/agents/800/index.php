<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");  
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
require ("../../../member/include/traditional.$langx.inc.php");

$sql = "select * from web_member where agents='$agname' and pay_type=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou<>0){
	echo "<script>window.open('./user_list.php?uid=$uid','_self')</script>";
	exit;
}else{
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('目前还没有会员，请添加后在操作！！');window.close()</script>";
	exit;
}
?>
<html>
<head>
<title>800</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<frameset rows="*" frameborder="NO" border="0" framespacing="0"> 
<frame name="index" src="./user_list.php?uid=<?=$uid?>">

<noframes> 
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>
