<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];

$mysql = "select * from web_world where Oid='$uid' and oid<>''";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agents_id=$wd_row["ID"];
$corprator=$wd_row["corprator"];

require ("../../member/include/traditional.zh-tw.inc.php");

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
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agents_id?>">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;总代理 详细设定&nbsp;&nbsp;&nbsp;<?=$sub_user?>:<?=$agents_name?> -- 
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
    <td><?=$row['FT_P_Bet']?></td>
    <td><?=$row['FT_PR_Bet']?></td>
    <td><?=$row['FT_PC_Bet']?></td>
    <td><?=$row['FT_PD_Bet']?></td>
    <td><?=$row['FT_T_Bet']?></td>
    <td><?=$row['FT_F_Bet']?></td>
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
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
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
</table><BR><table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>棒球</td>
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
    <td width="68">入球</td>
    
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
