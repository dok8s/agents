<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];

$mysql = "select * from web_agents where oid='$uid'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agents_id=$wd_row["ID"];
$corprator=$wd_row["corprator"];

require ("../../member/include/traditional.zh-cn.inc.php");

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
.m_ag_ed {  background-color: #bdd1de; text-align: center}
-->
</style>
<script language="javascript1.2" src="/js/ag_set.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agents_id?>">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;代理商详细设定&nbsp;&nbsp;&nbsp;<?=$sub_user?>:<?=$agents_name?> -- 
      <?=$sub_name?>:<?=$alias?> </td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table id="FT_Coor" width="550" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td rowspan="2" width="140">足球 </td>
    <td colspan="4" align="center" width="160">退水设定</td>
    <td id ="FT_MY_col" colspan="2" >投注限额</td>
	<!--td colspan="4">投注限额</td-->
  </tr>
   <tr class="m_title_edit" align="center">
    <td width="40">A</td>
    <td width="40">B</td>
    <td width="40">C</td>
    <td width="40">D</td>
	<td width="125">单场</td>
    <td width="125">单注</td>
  </tr>
  <tr  class="m_cen">
    <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
    <td nowrap><?=$row["FT_Turn_R_A"]?></td>
    <td nowrap><?=$row["FT_Turn_R_B"]?></td>
	<td nowrap><?=$row["FT_Turn_R_C"]?></td>
	<td nowrap><?=$row["FT_Turn_R_D"]?></td>
	<td nowrap><?=$row["FT_R_Scene"]?></td>
	<td nowrap><?=$row["FT_R_Bet"]?></td>		
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
    <td nowrap><?=$row["FT_Turn_RE_A"]?></td>
    <td nowrap><?=$row["FT_Turn_RE_B"]?></td>
	<td nowrap><?=$row["FT_Turn_RE_C"]?></td>
	<td nowrap><?=$row["FT_Turn_RE_D"]?></td>
	<td nowrap><?=$row["FT_RE_Scene"]?></td>
	<td nowrap><?=$row["FT_RE_Bet"]?></td>	
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">独赢, 滚球独赢</td>
    <td nowrap colspan="4" ><?=$row["FT_Turn_M"]?></td>
	<td nowrap><?=$row["FT_M_Scene"]?></td>
	<td nowrap><?=$row["FT_M_Bet"]?></td>
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">其他</td>
    <td nowrap colspan="4" ><?=$row["FT_Turn_PC"]?></td>
	<td nowrap><?=$row["FT_PC_Scene"]?></td>
	<td nowrap><?=$row["FT_PC_Bet"]?></td>
  </tr>
</table>
<BR>

<table id="BK_Coor" width="550" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td rowspan="2" width="140">篮球 </td>
    <td colspan="4" align="center" width="160">退水设定</td>
    <td id ="BK_MY_col" colspan="2" >投注限额</td>
	<!--td colspan="4">投注限额</td-->

  </tr>
   <tr class="m_title_edit">
    <td width="40">A</td>
    <td width="40">B</td>
    <td width="40">C</td>
    <td width="40">D</td>
	<td width="125">单场</td>
    <td width="125">单注</td>
  </tr>
  <tr  class="m_cen">
    <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
    <td nowrap><?=$row["BK_Turn_R_A"]?></td>
    <td nowrap><?=$row["BK_Turn_R_B"]?></td>
	<td nowrap><?=$row["BK_Turn_R_C"]?></td>
	<td nowrap><?=$row["BK_Turn_R_D"]?></td>
	<td nowrap><?=$row["BK_R_Scene"]?></td>
	<td nowrap><?=$row["BK_R_Bet"]?></td>
	
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
    <td nowrap><?=$row["BK_Turn_RE_A"]?></td>
    <td nowrap><?=$row["BK_Turn_RE_B"]?></td>
	<td nowrap><?=$row["BK_Turn_RE_C"]?></td>
	<td nowrap><?=$row["BK_Turn_RE_D"]?></td>
	<td nowrap><?=$row["BK_RE_Scene"]?></td>
	<td nowrap><?=$row["BK_RE_Bet"]?></td>	
  </tr>
  
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">其他</td>
    <td nowrap colspan="4" ><?=$row["BK_Turn_PC"]?></td>
	<td nowrap><?=$row["BK_PC_Scene"]?></td>
	<td nowrap><?=$row["BK_PC_Bet"]?></td>
  </tr>
</table>
<BR>

<table id="OP_Coor" width="550" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td rowspan="2" width="140">综合球类</td>
    <td colspan="4" align="center" width="160">退水设定</td>
    <td id ="OP_MY_col" colspan="2" >投注限额</td>
	<!--td colspan="4">投注限额</td-->

  </tr>
   <tr class="m_title_edit">
    <td width="40">A</td>
    <td width="40">B</td>
    <td width="40">C</td>
    <td width="40">D</td>
	<td width="125">单场</td>
    <td width="125">单注</td>
  </tr>
  <tr  class="m_cen">
    <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
   <td nowrap><?=$row["OP_Turn_R_A"]?></td>
    <td nowrap><?=$row["OP_Turn_R_B"]?></td>
	<td nowrap><?=$row["OP_Turn_R_C"]?></td>
	<td nowrap><?=$row["OP_Turn_R_D"]?></td>
	<td nowrap><?=$row["OP_R_Scene"]?></td>
	<td nowrap><?=$row["OP_R_Bet"]?></td>	
	
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
    <td nowrap><?=$row["OP_Turn_RE_A"]?></td>
    <td nowrap><?=$row["OP_Turn_RE_B"]?></td>
	<td nowrap><?=$row["OP_Turn_RE_C"]?></td>
	<td nowrap><?=$row["OP_Turn_RE_D"]?></td>
	<td nowrap><?=$row["OP_RE_Scene"]?></td>
	<td nowrap><?=$row["OP_RE_Bet"]?></td>	

  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">独赢, 滚球独赢</td>
    <td nowrap colspan="4" ><?=$row["OP_Turn_M"]?></td>
	<td nowrap><?=$row["OP_M_Scene"]?></td>
	<td nowrap><?=$row["OP_M_Bet"]?></td>
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">其他</td>
    <td nowrap colspan="4" ><?=$row["OP_Turn_PC"]?></td>
	<td nowrap><?=$row["OP_PC_Scene"]?></td>
	<td nowrap><?=$row["OP_PC_Bet"]?></td>
  </tr>
</table>
<BR>

<table id="FS_Coor" width="550" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td rowspan="2" width="140">冠军</td>
    <td colspan="4" align="center" width="160">退水设定</td>
    <td id ="FS_MY_col" colspan="2" >投注限额</td>
	<!--td colspan="4">投注限额</td-->

  </tr>
   <tr class="m_title_edit">
    <td width="40">A</td>
    <td width="40">B</td>
    <td width="40">C</td>
    <td width="40">D</td>
	<td width="125">单场</td>
    <td width="125">单注</td>
  </tr>			
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">冠军</td>
    <td nowrap colspan="4" ><?=$row["FS_Turn_R"]?></td>
	<td nowrap><?=$row["FS_R_Scene"]?></td>
	<td nowrap><?=$row["FS_R_Bet"]?></td>
 </tr>

</table>
<div id="show_table" style="visibility:hidden;position: absolute;"></div>
<div id="list" style="visibility:hidden;">
	<table border="0" cellpadding="1" cellspacing="1" class="ta_div">
		<tr class="m_title_ft_future">
			<td width=30>编号</td>
			<td width=100 >新帐号</td>
			<td width=100 >旧帐号</td>
			<td width=100 >修改日期</td>
		</tr>
		*LIST_RECORD*
		<tr><td colspan="4" class="m_cen"><input type="button" value="关闭" onClick="close_divs();" class="za_button"></td></tr>
	</table>
</div>
<div id="hidden_list" style="visibility:hidden;">
	<tr bgcolor="#F9FED3">
		<td>*NUMBER*</td>
		<td>*NEW_NAME*</td>
		<td>*OLD_NAME*</td>
		<td>*EDIT_DATE*</td>
	</tr>
</div>
<iframe id="showdata" name="showdata" scrolling="no" width="0" height="0" src="../../../ok.html"></iframe>
</body>
</html>