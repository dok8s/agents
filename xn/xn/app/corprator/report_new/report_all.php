<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../member/include/traditional.zh-cn.inc.php");

$report_kind = $_REQUEST['report_kind'];
$pay_type    = $_REQUEST['pay_type'];
$wtype       = $_REQUEST['wtype'];
$date_start  = $_REQUEST['date_start'];
$date_end    = $_REQUEST['date_end'];
$gtype       = $_REQUEST['gtype'];
$cid         = $_REQUEST['cid'];
$aid         = $_REQUEST['aid'];
$sid         = $_REQUEST['sid'];
$uid         = $_REQUEST['uid'];
$result_type = $_REQUEST['result_type'];

$date_start	=	cdate($date_start);
$date_end		=	cdate($date_end);
switch ($pay_type){
case "0":
	$credit="block";
	$sgold="block";
	break;
case "1":
	$credit="block";
	$sgold="block";
	break;
case "":
	$credit="block";
	$sgold="block";
	break;
}

$sql = "select Agname,ID,language,subname,subuser,super from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
if ($result_type=='Y'){
	$QQ526738='<font color=green>有结果</font>';
}else{
	$QQ526738='<font color=green>无结果</font>';
}
if ($row['subuser']==1){
	$agname=$row['subname'];
	$loginfo=$agname.'子帐号:'.$row['Agname'].'查询期间'.$date_start.'至'.$date_end.$QQ526738.'报表';
}else{
	$agname=$row['Agname'];
	$loginfo='查询期间'.$date_start.'至'.$date_end.$QQ526738.'报表';
}
$agid=$row['ID'];
$super=$row['super'];
$where=get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end,$row['subuser']);

$sql="select corprator as name,count(*) as coun,sum(betscore) as score,sum(m_result) as result,sum(a_result) as a_result,sum(vgold) as vgold,sum(result_a) as result_a,sum(result_s) as result_s,sum(result_c) as result_c,(100-world_point-agent_point-corpor_point)*0.01 as point from web_db_io where  ".$where." and corprator='$agname'";

?>
<html>
<head>
<title>reports_all</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_reall {  background-color: #687780; text-align: center; color: #FFFFFF}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT language=javaScript src="/js/report_func.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript src="/js/report_super_agent.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript src="/js/FlashContent.js" type=text/javascript></SCRIPT>
<script>
function init(){
	callas(getCommand("report"));
}
</script>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="init();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline">&nbsp;&nbsp;日期:<?=$date_start?>~<?=$date_end?>
      -- 报表分类:总帐 -- 投注方式:全部 -- 投注总类:全部 -- 下注管道:网路下注</td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
if ($credit=='block'){
	$mysql=$sql." and pay_type=0 group by corprator order by name asc";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$credit='none';
	}
}else{
	$credit='none';
}
?>
<!-----------------↓ 信用额度资料区段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: <?=$credit?>" width="960">
  <tr class="m_title_reall" >
    <td colspan="11">信用额度</td>
  </tr>
  <tr class="m_title_reall" >
    <td width="70"  >名称</td>
    <td width="50"  >笔数</td>
    <td width="100"  >下注金额</td>
    <td width="100"  >有效金额</td>
    <td width="100"  >会员</td>
    <td width="100"  >代理商</td>
    <td width="100"  >代理商结果</td>
    <td width="90"  >总代理</td>
    <td width="90"  >股东</td>
    <td width="120"  >备注</td>
    <td width="120"  >备注1</td>
  </tr>
   	<?
	while ($row = mysql_fetch_array($result)){
		$c_score+=$row['score'];
		$c_num+=$row['coun'];
		$c_vgold+=$row['vgold'];
		$c_m_result+=$row['result'];
		$c_a_result+=$row['a_result'];
		$c_result_a+=$row['result_a'];
		$c_result_s+=$row['result_s'];
		$c_result_c+=$row['result_c'];
  	?>
  <tr class="m_rig" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
    <td align="center"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF="report_corprator.php?uid=<?=$uid?>&result_type=<?=$result_type?>&cid=<?=$row['name']?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=$row['score']?></a></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td><?=mynumberformat($row['result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat($row['result_s'],1)?></td>
    <td ><?=mynumberformat($row['result_c'],1)?></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td>1.00000</td>
  </tr>
<?
}
?>
  <tr>
    <td height="1" colspan="10"></td>
  </tr>
 <tr class="m_rig_to" >
    <td>总计</td><td><?=$c_num?></td>
    <td><?=$c_score?></td>
    <td><?=mynumberformat($c_vgold,1)?></td>
    <td><?=mynumberformat($c_m_result,1)?></td>
    <td><?=mynumberformat($c_a_result,1)?></td>
    <td><?=mynumberformat($c_result_a,1)?></td>
    <td><?=mynumberformat($c_result_s,1)?></td>
    <td><?=mynumberformat($c_result_c,1)?></td>
    <td><?=mynumberformat($c_vgold,1)?></td>
    <td>1.00000</td>
  </tr>
</table>
<!-----------------↑ 信用额度资料区段 ↑------------------------->
<?
$c_score1=0;
$c_num1=0;
$c_m_result1=0;
$c_w_result1=0;
$c_vscore1=0;
$c_a_result1=0;
$c_vgold1=0;

if ($sgold=='block'){
	$mysql=$sql." and pay_type=1 group by corprator order by name asc";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$sgold='none';
	}
}else{
	$sgold='block';
}
if ($credit=='block'){
	echo '<br>';
}
?>
<!-----------------↓ 现金资料区段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: <?=$sgold?>" width="960">
  <tr class="m_title_reall" >
    <td colspan="11">现金</td>
  </tr>
  <tr class="m_title_reall" >
    <td width="70"  >名称</td>
    <td width="50"  >笔数</td>
    <td width="100"  >下注金额</td>
    <td width="100"  >有效金额</td>
    <td width="100"  >会员</td>
    <td width="100"  >代理商</td>
    <td width="100"  >代理商结果</td>
    <td width="90"  >总代理</td>
    <td width="90"  >股东</td>
    <td width="120"  >备注</td>
    <td width="120"  >备注1</td>
  </tr>
  <?
	while ($row = mysql_fetch_array($result)){
		$c_score1+=$row['score'];
		$c_num1+=$row['coun'];
		$c_vgold1+=$row['vgold'];

		$c_m_result1+=$row['result'];
		$c_a_result1+=$row['a_result'];
		$c_result_a1+=$row['result_a'];
		$c_result_s1+=$row['result_s'];
		$c_result_c1+=$row['a_result']*$row['point'];
  	?>
  <tr class="m_rig" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
    <td align="center"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF="report_corprator.php?uid=<?=$uid?>&result_type=<?=$result_type?>&cid=<?=$row['name']?>&pay_type=1&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=$row['score']?></a></td>
		<td><?=mynumberformat($row['vgold'],1)?></td>
    <td><?=mynumberformat($row['result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat($row['result_s'],1)?></td>
    <td ><?=mynumberformat($row['a_result']*$row['point'],1)?></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td>1.00000</td>
  </tr>
<?
}
?>
  <tr>
    <td height="1" colspan="10"></td>
  </tr>

  <tr class="m_rig_to">
   <td>总计</td>
   <td><?=$c_num1?></td>
    <td><?=$c_score1?></td>
       <td><?=mynumberformat($c_vgold1,1)?></td>
    <td><?=mynumberformat($c_m_result1,1)?></td>
    <td><?=mynumberformat($c_a_result1,1)?></td>
    <td><?=mynumberformat($c_result_a1,1)?></td>
    <td><?=mynumberformat($c_result_s1,1)?></td>
    <td><?=mynumberformat($c_result_c1,1)?></td>
    <td><?=mynumberformat($c_vgold1,1)?></td>
    <td></td>
  </tr>
</table>
<BR>
<?
if($credit=='block' and $sgold=='block'){
	$listall='block';
}else{
	$listall='none';
}
?>
<!-----------------↓ 加总资料区段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: <?=$listall?>" width="960">
  <tr class="m_title_reall" >
    <td colspan="11">总计</td>
  </tr>
  <tr class="m_rig_to">
    <td width="70" nowrap>总计</td>
    <td width="50"><?=$c_num1+$c_num?></td>
    <td width="100"><?=$c_score1+$c_score?></td>
    <td width="100"><?=mynumberformat($c_vgold1+$c_vgold,1)?></td>
    <td width="100"><?=mynumberformat($c_m_result+$c_m_result1,1)?></td>
    <td width="100"><?=mynumberformat($c_a_result+$c_a_result1,1)?></td>
    <td width="100"><?=mynumberformat($c_result_a+$c_result_a1,1)?></td>
    <td width="90"><?=mynumberformat($c_w_result+$c_w_result1,1)?></td>
    <td width="90"><?=mynumberformat($c_c_result+$c_c_result1,1)?></td>
    <td width="120">0</td>
    <td width="120">0</td>
  </tr>
<!-----------------↓ 无资料讯息区段 ↓------------------------->
<?
if ($credit=='none' and $sgold=='none'){
	$nosearch='block';
}else{
	$nosearch='none';
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="display: <?=$nosearch?>">
  <tr >
    <td align=center height="30" bgcolor="#CC0000"><marquee align="middle" behavior="alternate" width="200"><font color="#FFFFFF">查无任何资料</font></marquee></td>

  <tr>
    <td align=center height="20" bgcolor="#CCCCCC"><a href="javascript:history.go(-1);">离开</a></td>

</table>
<!-----------------↑ 无资料区段 ↑------------------------->
<!----------------------结帐视窗---------------------------->
<div id=acc_window style="display: none;">
<form name=agAcc1 action="agAccount_proc.php" method=post onSubmit="return Chk_acc();" target="win_agAcc">
<input type=hidden name=in_who_id value="">
<input type=hidden name=acc_date value="2005-10-23">

<table width="220" border="0" cellspacing="2" cellpadding="0" bgcolor="0163A2">
      <tr>
        <td><font color="#FFFFFF">请输入结帐日期</font></td>
        <td align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
      </tr>
      <tr>
        <td colspan="2"><font color="#FFFFFF">日　期:</font>
          <input type=text name=acc_date2 value="" class="za_text" size="12" maxlength="10">
          <input type=submit name=acc_ok value="确定" class="za_text_ed">
        </td>
      </tr>
    </table>
  </form>
</div>
<!----------------------结帐视窗---------------------------->
<!----------------------结帐视窗OLD----------------------------
<div id=input_window style="display: none;" style="position:absolute">
<form name=agAcc action="agAccount_proc.php" method=post onsubmit="return Chk_IN();" target="win_agAcc">
<input type=hidden name=in_who_id value="">
<input type=hidden name=date_start value="2005-10-23">
<input type=hidden name=date_end value="2005-10-26">
<input type=hidden name=wagers_type value="{WAGERS_TYPE}">
<input type=hidden name=super_agents_id value="{SUPER_AGENTS_ID}">
<input type=hidden name=game_type value="{GAME_TYPE}">
  <table width="220" border="0" cellspacing="2" cellpadding="0" bgcolor="0163A2">
    <tr>
      <td><font color="#FFFFFF">请输入结帐金额</font></td>
      <td align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
    </tr>

    <tr>
      <td colspan="2"><font color="#FFFFFF">代理商:</font><
        <input type=text name=in_who_name value="" class="za_text" size="8" >
      </td>
    </tr>
    <tr>
      <td colspan="2"><font color="#FFFFFF">金　额:</font>
        <input type=text name=in_gold value="" class="za_text" size="8" maxlength="8">
        <input type=submit name=in_chk value="结帐" class="za_text_ed">
        </td>
    </tr>
  </table>
</form>
</div>
<!----------------------结帐视窗---------------------------->
<SCRIPT language=JavaScript1.2><!--
//document.oncontextmenu=showmenuie5
//if (document.all&&window.print)
//document.body.onclick=hidemenuie5
// -->
</SCRIPT>
</body>
</html>
<?
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','1')";
mysql_query($mysql);
mysql_close();
?>
