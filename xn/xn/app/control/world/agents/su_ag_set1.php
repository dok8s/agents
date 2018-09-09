<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
require ("../../../../../inc/ag_set.inc.php");

 $uid=$_REQUEST["uid"];
$mid=$_REQUEST["id"];
$agents_id=$_REQUEST["agents_id"];
$act=$_REQUEST["act"];
$rtype=$_REQUEST['rtype'];
$sc=$_REQUEST['SC'];
$so=$_REQUEST['SO'];
$st=$_REQUEST['war_set'];
$kind=$_REQUEST['kind'];


$mysql = "select * from web_world where ID=$agents_id";
$wd_result = mysql_query($mysql);
$wd_row = mysql_fetch_array($wd_result);
$cou=mysql_num_rows($wd_result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agents_id=$wd_row["ID"];
$langx=$wd_row['language'];

require ("../../../member/include/traditional.$langx.inc.php");

$war_set_1=$_REQUEST["war_set_1"];
$war_set_2=$_REQUEST["war_set_2"];
$war_set_3=$_REQUEST["war_set_3"];
$war_set_4=$_REQUEST["war_set_4"];
if ($war_set_2!=''){
	$sc=$_REQUEST['SC'];
	$so=$_REQUEST['SO'];
	$updsql=$kind."_Turn_".$rtype."_A='".$war_set_1."',".$kind."_Turn_".$rtype."_B='".$war_set_2."',".$kind."_Turn_".$rtype."_C='".$war_set_3."',".$kind."_Turn_".$rtype."_D='".$war_set_4."'";
}else{
	$sc=$_REQUEST['SC_2'];
	$so=$_REQUEST['SO_2'];
	$updsql=$kind."_Turn_".$rtype."='".$war_set_1."'";
}
$st=$war_set;
if ($act=='Y'){
	$sql = "select agname from web_agents where ID=$mid";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$agname=$row["agname"];

	$a1=$kind.'_'.$rtype."_Scene";
	$a2=$kind.'_'.$rtype."_Bet";

	if ($sc>$wd_row[$a1]){
		echo wterror("代理商单场限额已超过总代理单场限额!请回上一页重新输入");
		exit;
	}
	if ($so>$wd_row[$a2]){
		echo wterror("代理商单注限额已超过总代理单注限额!请回上一页重新输入");
		exit;
	}
	$sql="update web_member set $a1='$sc' where agents='$agname' and ($a1>$sc)";
	mysql_query($sql) or die ("操作失败!");
	$sql="update web_member set $a2='$so' where agents='$agname' and ( $a2>$so)";
	mysql_query($sql) or die ("操作失败!");
	$mysql="update web_agents set ".$kind.'_'.$rtype."_Scene='".$sc."',".$kind.'_'.$rtype."_Bet='".$so."',".$updsql." where ID=$mid";
	mysql_query($mysql) or die ("操作失败!");
}


$sql = "select * from web_agents where ID=$mid";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agents_name=$row["Agname"];
$alias=$row["Alias"];

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<script language="javascript1.2" src="/js/ag_set.js"></script>
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agents_id?>">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline">&nbsp;&nbsp;代理商详细设定&nbsp;&nbsp;&nbsp;<?=$sub_user?>:<?=$agents_name?> --
      <?=$sub_name?>:<?=$alias?> -- <a href="./su_agents.php?uid=<?=$uid?>&super_agents_id=<?=$id?>">回上一页</a></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
echo get_set_table($row,$wd_row);
echo get_rs_window($sid,$mid);
?>
<BR><BR><BR>
</body>
</html>
