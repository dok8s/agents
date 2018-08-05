<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../../inc/ag_set.inc.php");
$uid=$_REQUEST["uid"];
$mid=$_REQUEST["id"];
$id=$_REQUEST["id"];

$mysql = "select * from web_corprator where oid='$uid'";

$wd_result = mysql_query($mysql);
$cou=mysql_num_rows($wd_result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$wd_row = mysql_fetch_array($wd_result);
$agents_id=$wd_row["ID"];

$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");

$agents_id=	$_REQUEST["super_agents_id"];
$act			=	$_REQUEST["act"];
$rtype		=	$_REQUEST['rtype'];
$sc				=	$_REQUEST['SC'];
$so				=	$_REQUEST['SO'];
$st				=	$_REQUEST['war_set'];
$kind			=	$_REQUEST['kind'];
$id				=	$_REQUEST["id"];

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
	$sql = "select agname from web_world where ID='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$agname=$row["agname"];

	$ag_scene=$kind.'_'.$rtype."_Scene";
	$ag_bet=$kind.'_'.$rtype."_Bet";
	$agscene=$wd_row[$ag_scene];
	$agbet=$wd_row[$ag_bet];

	if ($sc>$agscene){
		echo wterror("此总代理的单场限额已超过股东的单场限额，请回上一面重新输入");
		exit;
	}
	if ($so>$agbet){
		echo wterror("此总代理的单注限额已超过股东的单注限额，请回上一面重新输入");
		exit;
	}
	$sql="update web_agents set $ag_scene='$sc' where world='$agname' and $ag_scene>$sc";

	mysql_query($sql) or die ("操作失败!1");
	$sql="update web_agents set $ag_bet='$so' where world='$agname' and $ag_bet>$so";
	mysql_query($sql) or die ("操作失败!2");

	$sql="update web_member set $ag_scene='$sc' where world='$agname' and $ag_scene>$sc";
	mysql_query($sql) or die ("操作失败!3");
	$sql="update web_member set $ag_bet='$so' where world='$agname' and $ag_bet>$so";
	mysql_query($sql) or die ("操作失败!4");

	$mysql="update web_world set ".$kind.'_'.$rtype."_Scene='".$sc."',".$kind.'_'.$rtype."_Bet='".$so."',".$updsql." where ID='$id'";
	mysql_query($mysql) or die ("操作失败!");
}

$sql = "select * from web_world where ID='$mid'";
$result = mysql_query($sql);

$row = mysql_fetch_array($result);
$opentype=$row['OpenType'];
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
      <?=$sub_name?>:<?=$alias?> -- <a href="./body_super_agents.php?uid=<?=$uid?>">回上一页</a></td>
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
