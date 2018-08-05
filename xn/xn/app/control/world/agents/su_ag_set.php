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
$mid=$_REQUEST["id"];
$agents_id=$_REQUEST["agents_id"];
$act=$_REQUEST["act"];
$rtype=$_REQUEST['rtype'];
$sc=$_REQUEST['SC'];
$so=$_REQUEST['SO'];
$st=$_REQUEST['war_set'];
$kind=$_REQUEST['kind'];

$war_set_1=$_REQUEST["war_set_1"];
$war_set_2=$_REQUEST["war_set_2"];
$war_set_3=$_REQUEST["war_set_3"];


$mysql = "select * from web_world where ID=$agents_id";
$wd_result = mysql_db_query($dbname,$mysql);
$wd_row = mysql_fetch_array($wd_result);
$cou=mysql_num_rows($wd_result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agents_id=$wd_row["ID"];
$langx=$wd_row['language'];

require ("../../../member/include/traditional.$langx.inc.php");

if ($war_set_2!=''){
	$sc=$_REQUEST['SC'];
	$so=$_REQUEST['SO'];
	$updsql=$kind."_Turn_".$rtype."_A='".$war_set_1."',".$kind."_Turn_".$rtype."_B='".$war_set_2."',".$kind."_Turn_".$rtype."_C='".$war_set_3."'";
}else{
	$sc=$_REQUEST['SC_2'];
	$so=$_REQUEST['SO_2'];
	$updsql=$kind."_Turn_".$rtype."='".$war_set_1."'";
}
$st=$war_set;
if ($act=='Y'){
	$sql = "select agname from web_agents where ID=$mid";
	$result = mysql_db_query($dbname,$sql);
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
/*修改下线退水*/
	if ($war_set_2!=''){
		$s4=$kind."_Turn_".$rtype;
		$sql="update web_member set $s4='$war_set_1' where agents='$agname' and $s4>$war_set_1 and opentype='A'";
		mysql_db_query($dbname,$sql) or die ("操作失败!1");
		$sql="update web_member set $s4='$war_set_2' where agents='$agname' and $s4>$war_set_2 and opentype='B'";
		mysql_db_query($dbname,$sql) or die ("操作失败!1");
		$sql="update web_member set $s4='$war_set_3' where agents='$agname' and $s4>$war_set_3 and opentype='C'";
		mysql_db_query($dbname,$sql) or die ("操作失败!1");

	}else{

		$s1=$kind."_Turn_".$rtype;
		$sql="update web_member set $s1='$war_set_1' where agents='$agname' and $s1>$war_set_1";
		mysql_db_query($dbname,$sql) or die ("操作失败!1");
		
	}
	$sql="update web_member set $a1='$sc' where agents='$agname' and ($a1>$sc)";
	mysql_db_query($dbname,$sql) or die ("操作失败!");
	$sql="update web_member set $a2='$so' where agents='$agname' and ( $a2>$so)";
	mysql_db_query($dbname,$sql) or die ("操作失败!");
	$mysql="update web_agents set ".$kind.'_'.$rtype."_Scene='".$sc."',".$kind.'_'.$rtype."_Bet='".$so."',".$updsql." where ID=$mid";
	mysql_db_query($dbname,$mysql) or die ("操作失败!");
}

function turn_rate($start_rate,$rate_split,$end_rate,$sel_rate){
	$turn_rate='';
	echo $sel_rate;
	echo $end_rate;
	for($i=$start_rate;$i<$end_rate+$rate_split;$i+=$rate_split){
		if ($turn_rate==''){
			$turn_rate='<option>'.$i.'</option>';
		}else if($i==$sel_rate){
			$turn_rate=$turn_rate.'<option selected>'.$i.'</option>';
		}else{
			$turn_rate=$turn_rate.'<option>'.$i.'</option>';
		}
	}
	return $turn_rate;
}

$sql = "select * from web_agents where ID=$mid";
$result = mysql_db_query($dbname,$sql);
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
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td>足球 </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">独赢</td>
    <td width="68">滚球独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">综合过关</td>
    <td width="68">波胆</td>
    <td width="68">入球</td>
    <td width="68">半全场</td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>退水设定 <font color="#CC0000">A</font></td>
    <td><?=$row['FT_Turn_R_A']?></td>
    <td><?=$row['FT_Turn_OU_A']?></td>
    <td><?=$row['FT_Turn_RE_A']?></td>
    <td><?=$row['FT_Turn_ROU_A']?></td>
    <td><?=$row['FT_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['FT_Turn_M']?></td>
    <td rowspan="4"><?=$row['FT_Turn_RM']?></td>
    <td rowspan="4"><?=$row['FT_Turn_P']?></td>
    <td rowspan="4"><?=$row['FT_Turn_PR']?></td>
    <td rowspan="4"><?=$row['FT_Turn_PC']?></td>
    <td rowspan="4"><?=$row['FT_Turn_PD']?></td>
    <td rowspan="4"><?=$row['FT_Turn_T']?></td>
    <td rowspan="4"><?=$row['FT_Turn_F']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['FT_Turn_R_B']?></td>
    <td><?=$row['FT_Turn_OU_B']?></td>
    <td><?=$row['FT_Turn_RE_B']?></td>
    <td><?=$row['FT_Turn_ROU_B']?></td>
    <td><?=$row['FT_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['FT_Turn_R_C']?></td>
    <td><?=$row['FT_Turn_OU_C']?></td>
    <td><?=$row['FT_Turn_RE_C']?></td>
    <td><?=$row['FT_Turn_ROU_C']?></td>
    <td><?=$row['FT_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['FT_Turn_R_D']?></td>
    <td><?=$row['FT_Turn_OU_D']?></td>
    <td><?=$row['FT_Turn_RE_D']?></td>
    <td><?=$row['FT_Turn_ROU_D']?></td>
    <td><?=$row['FT_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['FT_R_Scene']?></td>
    <td><?=$row['FT_OU_Scene']?></td>
	<td><?=$row['FT_RE_Scene']?></td>
	<td><?=$row['FT_ROU_Scene']?></td>
    <td><?=$row['FT_EO_Scene']?></td>
    <td><?=$row['FT_M_Scene']?></td>
    <td><?=$row['FT_RM_Scene']?></td>
    <td><?=$row['FT_P_Scene']?></td>
    <td><?=$row['FT_PR_Scene']?></td>
    <td><?=$row['FT_PC_Scene']?></td>
    <td><?=$row['FT_PD_Scene']?></td>
    <td><?=$row['FT_T_Scene']?></td>
    <td><?=$row['FT_F_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['FT_R_Bet']?></td>
    <td><?=$row['FT_OU_Bet']?></td>
    <td><?=$row['FT_RE_Bet']?></td>
    <td><?=$row['FT_ROU_Bet']?></td>
    <td><?=$row['FT_EO_Bet']?></td>
    <td><?=$row['FT_M_Bet']?></td>
    <td><?=$row['FT_RM_Bet']?></td>
    <td><?=$row['FT_P_Bet']?></td>
    <td><?=$row['FT_PR_Bet']?></td>
    <td><?=$row['FT_PC_Bet']?></td>
    <td><?=$row['FT_PD_Bet']?></td>
    <td><?=$row['FT_T_Bet']?></td>
    <td><?=$row['FT_F_Bet']?></td>
  </tr>

  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
    <td><a href=# onClick="show_win('足球-让球','R','<?=$row['FT_R_Scene']?>','<?=$row['FT_R_Bet']?>',<?=$row['FT_Turn_R_A']?>,<?=$row['FT_Turn_R_B']?>,<?=$row['FT_Turn_R_C']?>,0,0.25,<?=$wd_row['FT_Turn_R_A']?>,<?=$wd_row['FT_Turn_R_B']?>,<?=$wd_row['FT_Turn_R_C']?>,0,'FT');"> 修改</a></td>
    <td><a href=# onClick="show_win('足球-大小盘','OU','<?=$row['FT_OU_Scene']?>','<?=$row['FT_OU_Bet']?>',<?=$row['FT_Turn_OU_A']?>,<?=$row['FT_Turn_OU_B']?>,<?=$row['FT_Turn_OU_C']?>,0,0.25,<?=$wd_row['FT_Turn_OU_A']?>,<?=$wd_row['FT_Turn_OU_B']?>,<?=$wd_row['FT_Turn_OU_C']?>,0,'FT');"> 修改</a></td>
    <td><a href=# onClick="show_win('足球-滚球','RE','<?=$row['FT_RE_Scene']?>','<?=$row['FT_RE_Bet']?>',<?=$row['FT_Turn_RE_A']?>,<?=$row['FT_Turn_RE_B']?>,<?=$row['FT_Turn_RE_C']?>,0,0.25,<?=$wd_row['FT_Turn_RE_A']?>,<?=$wd_row['FT_Turn_RE_B']?>,<?=$wd_row['FT_Turn_RE_C']?>,0,'FT');"> 修改</a></td>
    <td><a href=# onClick="show_win('足球-滚球大小','ROU','<?=$row['FT_ROU_Scene']?>','<?=$row['FT_ROU_Bet']?>',<?=$row['FT_Turn_ROU_A']?>,<?=$row['FT_Turn_ROU_B']?>,<?=$row['FT_Turn_ROU_C']?>,0,0.25,<?=$wd_row['FT_Turn_ROU_A']?>,<?=$wd_row['FT_Turn_ROU_B']?>,<?=$wd_row['FT_Turn_ROU_C']?>,0,'FT');">修改</a></td>
    <td><a href=# onClick="show_win('足球-单双','EO','<?=$row['FT_EO_Scene']?>','<?=$row['FT_EO_Bet']?>',<?=$row['FT_Turn_EO_A']?>,<?=$row['FT_Turn_EO_B']?>,<?=$row['FT_Turn_EO_C']?>,0,0.25,<?=$wd_row['FT_Turn_EO_A']?>,<?=$wd_row['FT_Turn_EO_B']?>,<?=$wd_row['FT_Turn_EO_C']?>,0,'FT');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('足球-独赢','M','<?=$row['FT_M_Scene']?>','<?=$row['FT_M_Bet']?>',<?=$row['FT_Turn_M']?>,1,<?=$wd_row['FT_Turn_M']?>,'FT');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('足球-独赢','RM','<?=$row['FT_RM_Scene']?>','<?=$row['FT_RM_Bet']?>',<?=$row['FT_Turn_RM']?>,1,<?=$wd_row['FT_Turn_RM']?>,'FT');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('足球-标准过关','P','<?=$row['FT_P_Scene']?>','<?=$row['FT_P_Bet']?>',<?=$row['FT_Turn_P']?>,1,<?=$wd_row['FT_Turn_P']?>,'FT');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('足球-让球过关','PR','<?=$row['FT_PR_Scene']?>','<?=$row['FT_PR_Bet']?>',<?=$row['FT_Turn_PR']?>,1,<?=$wd_row['FT_Turn_PR']?>,'FT');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('足球-综合过关','PC','<?=$row['FT_PC_Scene']?>','<?=$row['FT_PC_Bet']?>',<?=$row['FT_Turn_PC']?>,1,<?=$wd_row['FT_Turn_PC']?>,'FT');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('足球-波胆','PD','<?=$row['FT_PD_Scene']?>','<?=$row['FT_PD_Bet']?>',<?=$row['FT_Turn_PD']?>,1,<?=$wd_row['FT_Turn_PD']?>,'FT');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('足球-入球','T','<?=$row['FT_T_Scene']?>','<?=$row['FT_T_Bet']?>',<?=$row['FT_Turn_T']?>,1,<?=$wd_row['FT_Turn_T']?>,'FT');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('足球-半全场','F','<?=$row['FT_F_Scene']?>','<?=$row['FT_F_Bet']?>',<?=$row['FT_Turn_F']?>,1,<?=$wd_row['FT_Turn_F']?>,'FT');"> 修改</a></td>
  </tr>
</table>
<BR>
<table width='780'>
<tr>
<td align='left'>
<table width="515" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td>篮球 </td>
<td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">让球过关</td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed">退水设定 <font color="#CC0000">A</font></td>
    <td><?=$row['BK_Turn_R_A']?></td>
    <td><?=$row['BK_Turn_OU_A']?></td>
    <td><?=$row['BK_Turn_RE_A']?></td>
    <td><?=$row['BK_Turn_ROU_A']?></td>
    <td><?=$row['BK_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['BK_Turn_PR']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['BK_Turn_R_B']?></td>
    <td><?=$row['BK_Turn_OU_B']?></td>
    <td><?=$row['BK_Turn_RE_B']?></td>
    <td><?=$row['BK_Turn_ROU_B']?></td>
    <td><?=$row['BK_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['BK_Turn_R_C']?></td>
    <td><?=$row['BK_Turn_OU_C']?></td>
    <td><?=$row['BK_Turn_RE_C']?></td>
    <td><?=$row['BK_Turn_ROU_C']?></td>
    <td><?=$row['BK_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['BK_Turn_R_D']?></td>
    <td><?=$row['BK_Turn_OU_D']?></td>
    <td><?=$row['BK_Turn_RE_D']?></td>
    <td><?=$row['BK_Turn_ROU_D']?></td>
    <td><?=$row['BK_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单场限额:</td>
    <td><?=$row['BK_R_Scene']?></td>
    <td><?=$row['BK_OU_Scene']?></td>
    <td><?=$row['BK_RE_Scene']?></td>
    <td><?=$row['BK_ROU_Scene']?></td>
    <td><?=$row['BK_EO_Scene']?></td>
    <td><?=$row['BK_PR_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单注限额:</td>
    <td><?=$row['BK_R_Bet']?></td>
    <td><?=$row['BK_OU_Bet']?></td>
    <td><?=$row['BK_RE_Bet']?></td>
    <td><?=$row['BK_ROU_Bet']?></td>
    <td><?=$row['BK_EO_Bet']?></td>
    <td><?=$row['BK_PR_Bet']?></td>
  </tr>
<tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
    <td><a href=# onClick="show_win('篮球-让球','R','<?=$row['BK_R_Scene']?>','<?=$row['BK_R_Bet']?>',<?=$row['BK_Turn_R_A']?>,<?=$row['BK_Turn_R_B']?>,<?=$row['BK_Turn_R_C']?>,0,0.25,<?=$wd_row['BK_Turn_R_A']?>,<?=$wd_row['BK_Turn_R_B']?>,<?=$wd_row['BK_Turn_R_C']?>,0,'BK');"> 修改</a></td>
    <td><a href=# onClick="show_win('篮球-大小盘','OU','<?=$row['BK_EO_Scene']?>','<?=$row['BK_OU_Bet']?>',<?=$row['BK_Turn_OU_A']?>,<?=$row['BK_Turn_OU_B']?>,<?=$row['BK_Turn_OU_C']?>,0,0.25,<?=$wd_row['BK_Turn_OU_A']?>,<?=$wd_row['BK_Turn_OU_B']?>,<?=$wd_row['BK_Turn_OU_C']?>,0,'BK');"> 修改</a></td>
    <td><a href=# onClick="show_win('篮球-滚球','RE','<?=$row['BK_RE_Scene']?>','<?=$row['BK_RE_Bet']?>',<?=$row['BK_Turn_RE_A']?>,<?=$row['BK_Turn_RE_B']?>,<?=$row['BK_Turn_RE_C']?>,0,0.25,<?=$wd_row['BK_Turn_RE_A']?>,<?=$wd_row['BK_Turn_RE_B']?>,<?=$wd_row['BK_Turn_RE_C']?>,0,'BK');"> 修改</a></td>
    <td><a href=# onClick="show_win('篮球-滚球大小','ROU','<?=$row['BK_ROU_Scene']?>','<?=$row['BK_ROU_Bet']?>',<?=$row['BK_Turn_ROU_A']?>,<?=$row['BK_Turn_ROU_B']?>,<?=$row['BK_Turn_ROU_C']?>,0,0.25,<?=$wd_row['BK_Turn_ROU_A']?>,<?=$wd_row['BK_Turn_ROU_B']?>,<?=$wd_row['BK_Turn_ROU_C']?>,0,'BK');">修改</a></td>
    <td><a href=# onClick="show_win('篮球-单双','EO','<?=$row['BK_EO_Scene']?>','<?=$row['BK_EO_Bet']?>',<?=$row['BK_Turn_EO_A']?>,<?=$row['BK_Turn_EO_B']?>,<?=$row['BK_Turn_EO_C']?>,0,0.25,<?=$wd_row['BK_Turn_EO_A']?>,<?=$wd_row['BK_Turn_EO_B']?>,<?=$wd_row['BK_Turn_EO_C']?>,0,'BK');"> 修改</a></td>
    <td><a href=# onClick="show_win2('篮球-让球过关','PR','<?=$row['BK_PR_Scene']?>','<?=$row['BK_PR_Bet']?>',<?=$row['BK_Turn_PR']?>,1,<?=$wd_row['BK_Turn_PR']?>,'BK');"> 修改</a></td>
  </tr>
</table>
</td>
<td align='right'>
<table width="150" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td>冠军</td>
    <td width="68">冠军</td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed">退水设定:</td>
    <td><?=$row['FS_Turn_R']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单场限额:</td>
    <td><?=$row['FS_R_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单注限额:</td>
    <td><?=$row['FS_R_Bet']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
    <td><a href=# onClick="show_win2('冠军-让球','R','<?=$row['FS_R_Scene']?>','<?=$row['FS_R_Bet']?>',<?=$row['FS_Turn_R']?>,1,<?=$wd_row['FS_Turn_R']?>,'FS');"> 修改</a></td>
  </tr>
</table>
</td>
</tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td>网球 </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">波胆</td>
    <td width="68">入球</td>
    <td width="68">半全场</td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>退水设定 <font color="#CC0000">A</font></td>
    <td><?=$row['TN_Turn_R_A']?></td>
    <td><?=$row['TN_Turn_OU_A']?></td>
    <td><?=$row['TN_Turn_RE_A']?></td>
    <td><?=$row['TN_Turn_ROU_A']?></td>
    <td><?=$row['TN_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['TN_Turn_M']?></td>
    <td rowspan="4"><?=$row['TN_Turn_P']?></td>
    <td rowspan="4"><?=$row['TN_Turn_PR']?></td>
    <td rowspan="4"><?=$row['TN_Turn_PD']?></td>
    <td rowspan="4"><?=$row['TN_Turn_T']?></td>
    <td rowspan="4"><?=$row['TN_Turn_F']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['TN_Turn_R_B']?></td>
    <td><?=$row['TN_Turn_OU_B']?></td>
    <td><?=$row['TN_Turn_RE_B']?></td>
    <td><?=$row['TN_Turn_ROU_B']?></td>
    <td><?=$row['TN_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['TN_Turn_R_C']?></td>
    <td><?=$row['TN_Turn_OU_C']?></td>
    <td><?=$row['TN_Turn_RE_C']?></td>
    <td><?=$row['TN_Turn_ROU_C']?></td>
    <td><?=$row['TN_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['TN_Turn_R_D']?></td>
    <td><?=$row['TN_Turn_OU_D']?></td>
    <td><?=$row['TN_Turn_RE_D']?></td>
    <td><?=$row['TN_Turn_ROU_D']?></td>
    <td><?=$row['TN_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['TN_R_Scene']?></td>
    <td><?=$row['TN_OU_Scene']?></td>
	<td><?=$row['TN_RE_Scene']?></td>
	<td><?=$row['TN_ROU_Scene']?></td>
    <td><?=$row['TN_EO_Scene']?></td>
    <td><?=$row['TN_M_Scene']?></td>
    <td><?=$row['TN_P_Scene']?></td>
    <td><?=$row['TN_PR_Scene']?></td>
    <td><?=$row['TN_PD_Scene']?></td>
    <td><?=$row['TN_T_Scene']?></td>
    <td><?=$row['TN_F_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['TN_R_Bet']?></td>
    <td><?=$row['TN_OU_Bet']?></td>
    <td><?=$row['TN_RE_Bet']?></td>
    <td><?=$row['TN_ROU_Bet']?></td>
    <td><?=$row['TN_EO_Bet']?></td>
    <td><?=$row['TN_M_Bet']?></td>
    <td><?=$row['TN_P_Bet']?></td>
    <td><?=$row['TN_PR_Bet']?></td>
    <td><?=$row['TN_PD_Bet']?></td>
    <td><?=$row['TN_T_Bet']?></td>
    <td><?=$row['TN_F_Bet']?></td>
  </tr>
  <tr  class="m_cen">
  <td align="right"class="m_ag_ed">&nbsp;</td>
    <td><a href=# onClick="show_win('网球-让球','R','<?=$row['TN_R_Scene']?>','<?=$row['TN_R_Bet']?>',<?=$row['TN_Turn_R_A']?>,<?=$row['TN_Turn_R_B']?>,<?=$row['TN_Turn_R_C']?>,0,0.25,2.25,1.25,0.75,0,'TN');"> 修改</a></td>
    <td><a href=# onClick="show_win('网球-大小盘','OU','<?=$row['TN_OU_Scene']?>','<?=$row['TN_OU_Bet']?>',<?=$row['TN_Turn_OU_A']?>,<?=$row['TN_Turn_OU_B']?>,<?=$row['TN_Turn_OU_C']?>,0,0.25,2.25,1.25,0.75,0,'TN');"> 修改</a></td>
    <td><a href=# onClick="show_win('网球-滚球','RE','<?=$row['TN_RE_Scene']?>','<?=$row['TN_RE_Bet']?>',<?=$row['TN_Turn_RE_A']?>,<?=$row['TN_Turn_RE_B']?>,<?=$row['TN_Turn_RE_C']?>,0,0.25,2.25,1.25,0.75,0,'TN');"> 修改</a></td>
    <td><a href=# onClick="show_win('网球-滚球大小','ROU','<?=$row['TN_ROU_Scene']?>','<?=$row['TN_ROU_Bet']?>',<?=$row['TN_Turn_ROU_A']?>,<?=$row['TN_Turn_ROU_B']?>,<?=$row['TN_Turn_ROU_C']?>,0,0.25,2.25,1.25,0.75,0,'TN');">修改</a></td>
    <td><a href=# onClick="show_win('网球-单双','EO','<?=$row['TN_EO_Scene']?>','<?=$row['TN_EO_Bet']?>',<?=$row['TN_Turn_EO_A']?>,<?=$row['TN_Turn_EO_B']?>,<?=$row['TN_Turn_EO_C']?>,0,0.25,2.25,1.25,0.75,0,'TN');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('网球-独赢','M','<?=$row['TN_M_Scene']?>','<?=$row['TN_M_Bet']?>',<?=$row['TN_Turn_M']?>,1,5,'TN');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('网球-标准过关','P','<?=$row['TN_P_Scene']?>','<?=$row['TN_P_Bet']?>',<?=$row['TN_Turn_P']?>,1,8,'TN');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('网球-让球过关','PR','<?=$row['TN_PR_Scene']?>','<?=$row['TN_PR_Bet']?>',<?=$row['TN_Turn_PR']?>,1,5,'TN');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('网球-波胆','PD','<?=$row['TN_PD_Scene']?>','<?=$row['TN_PD_Bet']?>',<?=$row['TN_Turn_PD']?>,1,5,'TN');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('网球-入球','T','<?=$row['TN_T_Scene']?>','<?=$row['TN_T_Bet']?>',<?=$row['TN_Turn_T']?>,1,5,'TN');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('网球-半全场','F','<?=$row['TN_F_Scene']?>','<?=$row['TN_F_Bet']?>',<?=$row['TN_Turn_F']?>,1,5,'TN');"> 修改</a></td>
  </tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td>排球 </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">波胆</td>
    <td width="68">入球</td>
    <td width="68">半全场</td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>退水设定 <font color="#CC0000">A</font></td>
    <td><?=$row['VB_Turn_R_A']?></td>
    <td><?=$row['VB_Turn_OU_A']?></td>
    <td><?=$row['VB_Turn_RE_A']?></td>
    <td><?=$row['VB_Turn_ROU_A']?></td>
    <td><?=$row['VB_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['VB_Turn_M']?></td>
    <td rowspan="4"><?=$row['VB_Turn_P']?></td>
    <td rowspan="4"><?=$row['VB_Turn_PR']?></td>
    <td rowspan="4"><?=$row['VB_Turn_PD']?></td>
    <td rowspan="4"><?=$row['VB_Turn_T']?></td>
    <td rowspan="4"><?=$row['VB_Turn_F']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['VB_Turn_R_B']?></td>
    <td><?=$row['VB_Turn_OU_B']?></td>
    <td><?=$row['VB_Turn_RE_B']?></td>
    <td><?=$row['VB_Turn_ROU_B']?></td>
    <td><?=$row['VB_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['VB_Turn_R_C']?></td>
    <td><?=$row['VB_Turn_OU_C']?></td>
    <td><?=$row['VB_Turn_RE_C']?></td>
    <td><?=$row['VB_Turn_ROU_C']?></td>
    <td><?=$row['VB_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['VB_Turn_R_D']?></td>
    <td><?=$row['VB_Turn_OU_D']?></td>
    <td><?=$row['VB_Turn_RE_D']?></td>
    <td><?=$row['VB_Turn_ROU_D']?></td>
    <td><?=$row['VB_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['VB_R_Scene']?></td>
    <td><?=$row['VB_OU_Scene']?></td>
	<td><?=$row['VB_RE_Scene']?></td>
	<td><?=$row['VB_ROU_Scene']?></td>
    <td><?=$row['VB_EO_Scene']?></td>
    <td><?=$row['VB_M_Scene']?></td>
    <td><?=$row['VB_P_Scene']?></td>
    <td><?=$row['VB_PR_Scene']?></td>
    <td><?=$row['VB_PD_Scene']?></td>
    <td><?=$row['VB_T_Scene']?></td>
    <td><?=$row['VB_F_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['VB_R_Bet']?></td>
    <td><?=$row['VB_OU_Bet']?></td>
    <td><?=$row['VB_RE_Bet']?></td>
    <td><?=$row['VB_ROU_Bet']?></td>
    <td><?=$row['VB_EO_Bet']?></td>
    <td><?=$row['VB_M_Bet']?></td>
    <td><?=$row['VB_P_Bet']?></td>
    <td><?=$row['VB_PR_Bet']?></td>
    <td><?=$row['VB_PD_Bet']?></td>
    <td><?=$row['VB_T_Bet']?></td>
    <td><?=$row['VB_F_Bet']?></td>
  </tr>
  <tr  class="m_cen">

    <td align="right"class="m_ag_ed">&nbsp;</td>
  <td><a href=# onClick="show_win('排球-让球','R','<?=$row['VB_R_Scene']?>','<?=$row['VB_R_Bet']?>',<?=$row['VB_Turn_R_A']?>,<?=$row['VB_Turn_R_B']?>,<?=$row['VB_Turn_R_C']?>,0,0.25,2.25,1.25,0.75,0,'VB');"> 修改</a></td>
    <td><a href=# onClick="show_win('排球-大小盘','OU','<?=$row['VB_OU_Scene']?>','<?=$row['VB_OU_Bet']?>',<?=$row['VB_Turn_OU_A']?>,<?=$row['VB_Turn_OU_B']?>,<?=$row['VB_Turn_OU_C']?>,0,0.25,2.25,1.25,0.75,0,'VB');"> 修改</a></td>
    <td><a href=# onClick="show_win('排球-滚球','RE','<?=$row['VB_RE_Scene']?>','<?=$row['VB_RE_Bet']?>',<?=$row['VB_Turn_RE_A']?>,<?=$row['VB_Turn_RE_B']?>,<?=$row['VB_Turn_RE_C']?>,0,0.25,2.25,1.25,0.75,0,'VB');"> 修改</a></td>
    <td><a href=# onClick="show_win('排球-滚球大小','ROU','<?=$row['VB_ROU_Scene']?>','<?=$row['VB_ROU_Bet']?>',<?=$row['VB_Turn_ROU_A']?>,<?=$row['VB_Turn_ROU_B']?>,<?=$row['VB_Turn_ROU_C']?>,0,0.25,2.25,1.25,0.75,0,'VB');">修改</a></td>
    <td><a href=# onClick="show_win('排球-单双','EO','<?=$row['VB_EO_Scene']?>','<?=$row['VB_EO_Bet']?>',<?=$row['VB_Turn_EO_A']?>,<?=$row['VB_Turn_EO_B']?>,<?=$row['VB_Turn_EO_C']?>,0,0.25,2.25,1.25,0.75,0,'VB');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('排球-独赢','M','<?=$row['VB_M_Scene']?>','<?=$row['VB_M_Bet']?>',<?=$row['VB_Turn_M']?>,1,5,'VB');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('排球-标准过关','P','<?=$row['VB_P_Scene']?>','<?=$row['VB_P_Bet']?>',<?=$row['VB_Turn_P']?>,1,8,'VB');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('排球-让球过关','PR','<?=$row['VB_PR_Scene']?>','<?=$row['VB_PR_Bet']?>',<?=$row['VB_Turn_PR']?>,1,5,'VB');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('排球-波胆','PD','<?=$row['VB_PD_Scene']?>','<?=$row['VB_PD_Bet']?>',<?=$row['VB_Turn_PD']?>,1,5,'VB');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('排球-入球','T','<?=$row['VB_T_Scene']?>','<?=$row['VB_T_Bet']?>',<?=$row['VB_Turn_T']?>,1,5,'VB');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('排球-半全场','F','<?=$row['VB_F_Scene']?>','<?=$row['VB_F_Bet']?>',<?=$row['VB_Turn_F']?>,1,5,'VB');"> 修改</a></td>
  </tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
	<tr class="m_title_edit">
		<td>棒球 </td>
		<td width="68">让球</td>
		<td width="68">大小</td>
		<td width="68">滚球</td>
		<td width="68">滚球大小</td>
		<td width="68">单双</td>
		<td width="68">独赢</td>
		<td width="68">标准过关</td>
		<td width="68">让球过关</td>
		<td width="68">综合过关</td>
		<td width="68">波胆</td>
		<td width="68">总得分</td>
	</tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>退水设定 <font color="#CC0000">A</font></td>
    <td><?=$row['BS_Turn_R_A']?></td>
    <td><?=$row['BS_Turn_OU_A']?></td>
    <td><?=$row['BS_Turn_RE_A']?></td>
    <td><?=$row['BS_Turn_ROU_A']?></td>
    <td><?=$row['BS_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['BS_Turn_M']?></td>
    <td rowspan="4"><?=$row['BS_Turn_P']?></td>
    <td rowspan="4"><?=$row['BS_Turn_PR']?></td>
    <td rowspan="4"><?=$row['BS_Turn_PC']?></td>
    <td rowspan="4"><?=$row['BS_Turn_PD']?></td>
    <td rowspan="4"><?=$row['BS_Turn_T']?></td>
    
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['BS_Turn_R_B']?></td>
    <td><?=$row['BS_Turn_OU_B']?></td>
    <td><?=$row['BS_Turn_RE_B']?></td>
    <td><?=$row['BS_Turn_ROU_B']?></td>
    <td><?=$row['BS_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['BS_Turn_R_C']?></td>
    <td><?=$row['BS_Turn_OU_C']?></td>
    <td><?=$row['BS_Turn_RE_C']?></td>
    <td><?=$row['BS_Turn_ROU_C']?></td>
    <td><?=$row['BS_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['BS_Turn_R_D']?></td>
    <td><?=$row['BS_Turn_OU_D']?></td>
    <td><?=$row['BS_Turn_RE_D']?></td>
    <td><?=$row['BS_Turn_ROU_D']?></td>
    <td><?=$row['BS_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['BS_R_Scene']?></td>
    <td><?=$row['BS_OU_Scene']?></td>
	<td><?=$row['BS_RE_Scene']?></td>
	<td><?=$row['BS_ROU_Scene']?></td>
    <td><?=$row['BS_EO_Scene']?></td>
    <td><?=$row['BS_M_Scene']?></td>
    <td><?=$row['BS_P_Scene']?></td>
    <td><?=$row['BS_PR_Scene']?></td>
    <td><?=$row['BS_PC_Scene']?></td>
    <td><?=$row['BS_PD_Scene']?></td>
    <td><?=$row['BS_T_Scene']?></td>
   
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['BS_R_Bet']?></td>
    <td><?=$row['BS_OU_Bet']?></td>
    <td><?=$row['BS_RE_Bet']?></td>
    <td><?=$row['BS_ROU_Bet']?></td>
    <td><?=$row['BS_EO_Bet']?></td>
    <td><?=$row['BS_M_Bet']?></td>
    <td><?=$row['BS_P_Bet']?></td>
    <td><?=$row['BS_PR_Bet']?></td>
    <td><?=$row['BS_PC_Bet']?></td>
    <td><?=$row['BS_PD_Bet']?></td>
    <td><?=$row['BS_T_Bet']?></td>
    
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
    <td><a href=# onClick="show_win('棒球-让球','R','<?=$row['BS_R_Scene']?>','<?=$row['BS_R_Bet']?>',<?=$row['BS_Turn_R_A']?>,<?=$row['BS_Turn_R_B']?>,<?=$row['BS_Turn_R_C']?>,0,0.25,<?=$wd_row['BS_Turn_R_A']?>,<?=$wd_row['BS_Turn_R_B']?>,<?=$wd_row['BS_Turn_R_C']?>,0,'BS');"> 修改</a></td>
    <td><a href=# onClick="show_win('棒球-大小盘','OU','<?=$row['BS_OU_Scene']?>','<?=$row['BS_OU_Bet']?>',<?=$row['BS_Turn_OU_A']?>,<?=$row['BS_Turn_OU_B']?>,<?=$row['BS_Turn_OU_C']?>,0,0.25,<?=$wd_row['BS_Turn_OU_A']?>,<?=$wd_row['BS_Turn_OU_B']?>,<?=$wd_row['BS_Turn_OU_C']?>,0,'BS');"> 修改</a></td>
    <td><a href=# onClick="show_win('棒球-滚球','RE','<?=$row['BS_RE_Scene']?>','<?=$row['BS_RE_Bet']?>',<?=$row['BS_Turn_RE_A']?>,<?=$row['BS_Turn_RE_B']?>,<?=$row['BS_Turn_RE_C']?>,0,0.25,<?=$wd_row['BS_Turn_RE_A']?>,<?=$wd_row['BS_Turn_RE_B']?>,<?=$wd_row['BS_Turn_RE_C']?>,0,'BS');"> 修改</a></td>
    <td><a href=# onClick="show_win('棒球-滚球大小','ROU','<?=$row['BS_ROU_Scene']?>','<?=$row['BS_ROU_Bet']?>',<?=$row['BS_Turn_ROU_A']?>,<?=$row['BS_Turn_ROU_B']?>,<?=$row['BS_Turn_ROU_C']?>,0,0.25,<?=$wd_row['BS_Turn_ROU_A']?>,<?=$wd_row['BS_Turn_ROU_B']?>,<?=$wd_row['BS_Turn_ROU_C']?>,0,'BS');">修改</a></td>
    <td><a href=# onClick="show_win('棒球-单双','EO','<?=$row['BS_EO_Scene']?>','<?=$row['BS_EO_Bet']?>',<?=$row['BS_Turn_EO_A']?>,<?=$row['BS_Turn_EO_B']?>,<?=$row['BS_Turn_EO_C']?>,0,0.25,<?=$wd_row['BS_Turn_EO_A']?>,<?=$wd_row['BS_Turn_EO_B']?>,<?=$wd_row['BS_Turn_EO_C']?>,0,'BS');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('棒球-独赢','M','<?=$row['BS_M_Scene']?>','<?=$row['BS_M_Bet']?>',<?=$row['BS_Turn_M']?>,1,<?=$wd_row['BS_Turn_M']?>,'BS');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('棒球-标准过关','P','<?=$row['BS_P_Scene']?>','<?=$row['BS_P_Bet']?>',<?=$row['BS_Turn_P']?>,1,<?=$wd_row['BS_Turn_P']?>,'BS');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('棒球-让球过关','PR','<?=$row['BS_PR_Scene']?>','<?=$row['BS_PR_Bet']?>',<?=$row['BS_Turn_PR']?>,1,<?=$wd_row['BS_Turn_PR']?>,'BS');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('棒球-综合过关','PC','<?=$row['BS_PC_Scene']?>','<?=$row['BS_PC_Bet']?>',<?=$row['BS_Turn_PC']?>,1,<?=$wd_row['BS_Turn_PC']?>,'BS');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('棒球-波胆','PD','<?=$row['BS_PD_Scene']?>','<?=$row['BS_PD_Bet']?>',<?=$row['BS_Turn_PD']?>,1,<?=$wd_row['BS_Turn_PD']?>,'BS');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('棒球-入球','T','<?=$row['BS_T_Scene']?>','<?=$row['BS_T_Bet']?>',<?=$row['BS_Turn_T']?>,1,<?=$wd_row['BS_Turn_T']?>,'BS');"> 修改</a></td>
  </tr>
</table><br>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td>其它 </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">波胆</td>
    <td width="68">入球</td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>退水设定 <font color="#CC0000">A</font></td>
    <td><?=$row['OP_Turn_R_A']?></td>
    <td><?=$row['OP_Turn_OU_A']?></td>
    <td><?=$row['OP_Turn_RE_A']?></td>
    <td><?=$row['OP_Turn_ROU_A']?></td>
    <td><?=$row['OP_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['OP_Turn_M']?></td>
    <td rowspan="4"><?=$row['OP_Turn_P']?></td>
    <td rowspan="4"><?=$row['OP_Turn_PR']?></td>
    <td rowspan="4"><?=$row['OP_Turn_PD']?></td>
    <td rowspan="4"><?=$row['OP_Turn_T']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['OP_Turn_R_B']?></td>
    <td><?=$row['OP_Turn_OU_B']?></td>
    <td><?=$row['OP_Turn_RE_B']?></td>
    <td><?=$row['OP_Turn_ROU_B']?></td>
    <td><?=$row['OP_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['OP_Turn_R_C']?></td>
    <td><?=$row['OP_Turn_OU_C']?></td>
    <td><?=$row['OP_Turn_RE_C']?></td>
    <td><?=$row['OP_Turn_ROU_C']?></td>
    <td><?=$row['OP_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['OP_Turn_R_D']?></td>
    <td><?=$row['OP_Turn_OU_D']?></td>
    <td><?=$row['OP_Turn_RE_D']?></td>
    <td><?=$row['OP_Turn_ROU_D']?></td>
    <td><?=$row['OP_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['OP_R_Scene']?></td>
    <td><?=$row['OP_OU_Scene']?></td>
	<td><?=$row['OP_RE_Scene']?></td>
	<td><?=$row['OP_ROU_Scene']?></td>
    <td><?=$row['OP_EO_Scene']?></td>
    <td><?=$row['OP_M_Scene']?></td>
    <td><?=$row['OP_P_Scene']?></td>
    <td><?=$row['OP_PR_Scene']?></td>
    <td><?=$row['OP_PD_Scene']?></td>
    <td><?=$row['OP_T_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['OP_R_Bet']?></td>
    <td><?=$row['OP_OU_Bet']?></td>
    <td><?=$row['OP_RE_Bet']?></td>
    <td><?=$row['OP_ROU_Bet']?></td>
    <td><?=$row['OP_EO_Bet']?></td>
    <td><?=$row['OP_M_Bet']?></td>
    <td><?=$row['OP_P_Bet']?></td>
    <td><?=$row['OP_PR_Bet']?></td>
    <td><?=$row['OP_PD_Bet']?></td>
    <td><?=$row['OP_T_Bet']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"></td>
    <td><a href=# onClick="show_win('其它-让球','R','<?=$row['OP_R_Scene']?>','<?=$row['OP_R_Bet']?>',<?=$row['OP_Turn_R_A']?>,<?=$row['OP_Turn_R_B']?>,<?=$row['OP_Turn_R_C']?>,0,0.25,10,10,10,0,'OP');"> 修改</a></td>
    <td><a href=# onClick="show_win('其它-大小盘','OU','<?=$row['OP_OU_Scene']?>','<?=$row['OP_OU_Bet']?>',<?=$row['OP_Turn_OU_A']?>,<?=$row['OP_Turn_OU_B']?>,<?=$row['OP_Turn_OU_C']?>,0,0.25,10,10,10,0,'OP');"> 修改</a></td>
    <td><a href=# onClick="show_win('其它-滚球','RE','<?=$row['OP_RE_Scene']?>','<?=$row['OP_RE_Bet']?>',<?=$row['OP_Turn_RE_A']?>,<?=$row['OP_Turn_RE_B']?>,<?=$row['OP_Turn_RE_C']?>,0,0.25,10,10,10,0,'OP');"> 修改</a></td>
    <td><a href=# onClick="show_win('其它-滚球大小','ROU','<?=$row['OP_ROU_Scene']?>','<?=$row['OP_ROU_Bet']?>',<?=$row['OP_Turn_ROU_A']?>,<?=$row['OP_Turn_ROU_B']?>,<?=$row['OP_Turn_ROU_C']?>,0,0.25,10,10,10,0,'OP');">修改</a></td>
    <td><a href=# onClick="show_win('其它-单双','EO','<?=$row['OP_EO_Scene']?>','<?=$row['OP_EO_Bet']?>',<?=$row['OP_Turn_EO_A']?>,<?=$row['OP_Turn_EO_B']?>,<?=$row['OP_Turn_EO_C']?>,0,0.25,10,10,10,0,'OP');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('其它-独赢','M','<?=$row['OP_M_Scene']?>','<?=$row['OP_M_Bet']?>',<?=$row['OP_Turn_M']?>,1,10,'OP');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('其它-标准过关','P','<?=$row['OP_P_Scene']?>','<?=$row['OP_P_Bet']?>',<?=$row['OP_Turn_P']?>,1,10,'OP');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('其它-让球过关','PR','<?=$row['OP_PR_Scene']?>','<?=$row['OP_PR_Bet']?>',<?=$row['OP_Turn_PR']?>,1,10,'OP');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('其它-波胆','PD','<?=$row['OP_PD_Scene']?>','<?=$row['OP_PD_Bet']?>',<?=$row['OP_Turn_PD']?>,1,10,'OP');"> 修改</a></td>
    <td> <a href=# onClick="show_win2('其它-入球','T','<?=$row['OP_T_Scene']?>','<?=$row['OP_T_Bet']?>',<?=$row['OP_Turn_T']?>,1,10,'OP');"> 修改</a></td>
  </tr>

</table>
<!----------------------结帐视窗1---------------------------->
<div id=rs_window style="display: none;position:absolute">
  <form name=rs_form action="" method=post onSubmit="return Chk_acc();">
    <input type=hidden name=rtype value="">
<input type=hidden name=act value="N">
<input type=hidden name=sid value="<?=$agents_id?>">
<input type=hidden name=id value="<?=$mid?>">
<input type=hidden name=kind value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
  <tr>
    <td bgcolor="#FFFFFF">
          <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix">
            <tr bgcolor="0163A2">
          <td width="200" id=r_title><font color="#FFFFFF">&nbsp;请输入</font></td>
          <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
            <tr bgcolor="#A4C0CE">
              <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr align="center">
                    <td>A盘</td>
                    <td>B盘</td>
                    <td>C盘</td>
                     <td>D盘</td>
                  </tr>
                  <tr align="center">
                    <td>
                      <select class="za_select" name="war_set_1">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_2">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_3">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_4">
                      </select>
                    </td>
                  </tr>
                </table>
              </td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">单场限额&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SC" value="" size=8 maxlength=8 class="za_text" onKeyUp="count_so(1)"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">单注限额&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SO" value="" size=8 maxlength=8 class="za_text"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
              <td colspan="2" align="center">
                <input type=submit name=rs_ok value="确定" class="za_button">
              </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>
<!----------------------结帐视窗1---------------------------->
<!----------------------结帐视窗2---------------------------->
<div id=rs_window_2 style="display: none;position:absolute">
  <form name=rs_form_2 action="" method=post onSubmit="return Chk_acc2();">
    <input type=hidden name=rtype value="">
<input type=hidden name=act value="N">
<input type=hidden name=sid value="<?=$agents_id?>">
<input type=hidden name=id value="<?=$mid?>">
<input type=hidden name=kind value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
  <tr>
    <td bgcolor="#FFFFFF">
            <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix">
              <tr bgcolor="0163A2">
          <td width="200" id=r_title_2><font color="#FFFFFF">&nbsp;请输入</font></td>
          <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win_2();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">退水设定&nbsp;&nbsp;<select class="za_select" name="war_set_1">
                  </select></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">单场限额&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SC_2" value="" size=8 maxlength=8 class="za_text" onKeyUp="count_so(2)"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">单注限额&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SO_2" value="" size=8 maxlength=8 class="za_text"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
                <td colspan="2" align="center">
                  <input type=submit name=rs_ok value="确定" class="za_button">
                </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>
<!----------------------结帐视窗2---------------------------->
</body>
</html>
<?
mysql_close();
?>
