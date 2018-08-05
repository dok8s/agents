<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
require ("../../../member/include/traditional.zh-cn.inc.php");

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

$sql = "select super,Agname,ID,language,subname,subuser from web_world where Oid='$uid'";
$result = mysql_query($sql);
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
$row = mysql_fetch_array($result);

if ($row['subuser']==1){
	$agname=$row['subname'];
	$loginfo=$agname.'子帐号:'.$row['subname'].'查询期间'.$date_start.'至'.$date_end.$QQ526738.'报表';
}else{
	$agname=$row['Agname'];
	$loginfo='总代理商:'.$row['Agname'].'查询期间'.$date_start.'至'.$date_end.$QQ526738.'报表';
}

$agid=$row['ID'];
$super=$row['super'];
$where=get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end,$row['subuser']);

$sql="select world as name,(100-world_point-agent_point)*0.01 as point,count(*) as coun,sum(betscore) as score,sum(m_result) as result,sum(a_result) as a_result,sum(result_a) as result_a,sum(result_s) as result_s,sum(vgold) as vgold from web_db_io where ".$where." and super='$super' and world='$agname'";
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_reag {  background-color: #687780; text-align: center; color: #FFFFFF}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT language=javaScript src="/js/report_func.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript src="/js/FlashContent.js" type=text/javascript></SCRIPT>
<script>
function init(){
	callas(getCommand("report"));
}
</script>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="init();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="m_tline">
    <td>&nbsp;&nbsp;总代理商:<?=$agname?> -- 日期:<?=$date_start?>~<?=$date_end?>
      -- 报表分类:总帐 -- 投注方式:全部 -- 投注总类:全部 -- 下注管道:网路下注 -- <a href="javascript:history.go( -1 );">回上一页</a></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
if ($credit=='block'){
	$mysql=$sql." and pay_type=0 group by world order by name asc";
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
<table width="890" border="0" cellspacing="1" cellpadding="0" class="m_tab"  style="display:  <?=$credit?>" bgcolor="#000000">
  <tr class="m_title_reag">
    <td colspan="10">信用额度</td>
  </tr>
  <tr class="m_title_reag">
    <td width="50"  >名称</td>
    <td width="80">笔数</td>
    <td width="110"  >下注金额</td>
    <td width="110"  >有效金额</td>
    <td width="90"  >会员</td>
    <td width="90"  >代理商</td>
    <td width="90"  >代理商结果</td>
    <td width="90"  >总代理</td>
    <td width="90" >备注</td>
    <td width="90" >备注1</td>
  </tr>
	<?
	while ($row = mysql_fetch_array($result)){
		$c_score+=$row['score'];
		$c_num+=$row['coun'];
		$c_m_result+=$row['result'];
		$c_result_s+=$row['result_s'];
		$c_vscore+=$row['vgold'];
		$c_a_result+=$row['a_result'];
		$c_result_a+=$row['result_a'];
		$c_vgold+=$row['point']*$row['vgold'];
  	?>

  <tr  class="m_rig" align="left" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');" >
    <td align="center"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF="report_suagent.php?uid=<?=$uid?>&result_type=<?=$result_type?>&sid=<?=$row['name']?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=$row['score']?></a></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td><?=mynumberformat($row['result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td ><?=mynumberformat($row['result_s'],1)?></td>
    <td>
    	<table border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" width="100%">
		<tr>
			<td></td>
			<td align="right"><?=mynumberformat($row['point']*$row['vgold'],1)?></td>
		</tr>
	</table>
    </td>
    <td>1.00000</td>
  </tr>
<?
}
?>
  <!-- END DYNAMIC BLOCK: item0 -->
  <tr  class="m_rig_to" >
    <td></td>
    <td ><?=$c_num?></td>
    <td ><?=$c_score?></td>
    <td ><?=mynumberformat($c_vscore,1)?></td>
    <td><font color="#FFFFFF"><?=mynumberformat($c_m_result,1)?></font></td>
    <td><?=mynumberformat($c_a_result,1)?></td>
    <td><font color="#FFFFFF"><?=mynumberformat($c_result_a,1)?></font></td>
    <td><font color="#FFFFFF"><?=mynumberformat($c_result_s,1)?></font></td>
    <td><?=mynumberformat($c_vgold,1)?></td>
    <td>1.00000</td>
  </tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="15"></td>
</tr>
</table>
<?
$c_score=0;
$c_num=0;
$c_m_result=0;
$c_w_result=0;
$c_vscore=0;
$c_a_result=0;
$c_vgold=0;

if ($sgold=='block'){
	$mysql=$sql." and pay_type=1 group by world order by name asc";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$sgold='none';
	}
}else{
	$sgold='block';
}
if ($credit=='block'){
	echo '<BR>';
}
?>
<!-----------------↓ 现金资料区段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: <?=$sgold?>" width="890">
  <tr class="m_title_reag">
    <td colspan="10">现金</td>
  </tr>
  <tr class="m_title_reag">
    <td width="50"  >名称</td>
    <td width="80">笔数</td>
    <td width="110"  >下注金额</td>
    <td width="110"  >有效金额</td>
    <td width="90"  >会员</td>
    <td width="90"  >代理商</td>
    <td width="90"  >代理商结果</td>
    <td width="90"  >总代理</td>
    <td width="90" >备注</td>
    <td width="90" >备注1</td>
  </tr>
  <!-- BEGIN DYNAMIC BLOCK: item0 -->
   	<?
	while ($row = mysql_fetch_array($result)){
		$c_score+=$row['score'];
		$c_num+=$row['coun'];
		$c_m_result+=$row['result'];
		$c_w_result+=$row['w_result'];
		$c_vscore+=$row['vgold'];
		$c_a_result+=$row['a_result'];
		$vgold=$row['vgold']*(100-$row['world_point'])/100;
		$c_vgold+=$vgold;
  	?>
  <tr class="m_rig" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
    <td align="center"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF="report_suagent.php?uid=<?=$uid?>&result_type=<?=$result_type?>&sid=<?=$row['name']?>&pay_type=1&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=$row['score']?></a></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td><?=mynumberformat($row['result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td ><?=mynumberformat($row['w_result'],1)?></td>
    <td></td>
    <td><?=mynumberformat($vgold)?></td>
  </tr>
<?
}
?>
  <tr class="m_rig_re" >
    <td><font color="#CC0000">总<?=$agname?>小计</font></td>
    <td><?=$c_num?></td>
    <td><?=$c_score?></td>
	<td><?=mynumberformat($c_vgold,1)?></td>
    <td><?=mynumberformat($c_m_result,1)?></td>
    <td><?=mynumberformat($c_a_result,1, '.', '')?></td>
    <td><?=mynumberformat($c_a_result,1, '.', '')?></td>
    <td><?=mynumberformat($c_w_result,1, '.', '')?></td>
    <td></td>
    <td><?=$c_vgold?></td>
  </tr>
  <tr>
    <td height="1" colspan="10"></td>
  </tr>

  <tr class="m_rig_to">
    <td>总计</td>
    <td><?=$c_num?></td>
    <td><?=$c_score?></td>
    <td><?=mynumberformat($c_vgold,1)?></td>
    <td><?=mynumberformat($c_m_result,1)?></td>
    <td><?=mynumberformat($c_a_result,1, '.', '')?></td>
    <td><?=mynumberformat($c_a_result,1, '.', '')?></td>
    <td><?=mynumberformat($c_w_result,1, '.', '')?></td>
    <td></td>
    <td><?=$c_vgold?></td>
  </tr>
<!-----------------↓ TAX ↓------------------------->
<!--  <tr class="m_rig">
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>{MTAX_1}</td>
    <td>{ATAX_1}</td>
    <td>&nbsp;</td>
    <td>{ARTAX_1}</td>
    <td >{SRTAX_1}</td>
    <td >&nbsp;</td>
  </tr>-->
<!-----------------↑ TAX ↑------------------------->
</table>
<!-----------------↑ 现金资料区段 ↑------------------------->
<BR>
<!-----------------↓ 加总资料区段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: none" width="820">
  <tr class="m_title_reall" >
    <td colspan="11">总计</td>
  </tr>
  <tr class="m_rig_to">
    <td width="90">总计</td>
    <td width="50">{WCOUNT_ALL}</td>
    <td width="100">{GOLD_ALL}</td>
    <td width="100">{VGOLD_ALL}</td>
    <td width="100">{MWINGOLD_ALL}</td>
    <td width="100">{AWINGOLD_ALL}</td>
    <td width="50">&nbsp;</td>
    <td width="100">{ARESULT_ALL}</td>
    <td width="100">{SRESULT_ALL}</td>
    <td width="130"></td>
    <td width="130">{SGOLD_ALL}</td>
  </tr>
<!--  <tr class="m_rig">
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>{MTAX_ALL}</td>
    <td>{ATAX_ALL}</td>
    <td>&nbsp;</td>
    <td>{ARTAX_ALL}</td>
    <td >{SRTAX_ALL}</td>
    <td >&nbsp;</td>
  </tr>-->
<!-----------------↑ TAX ↑------------------------->
</table>
<!-----------------↑ 加总资料区段 ↑------------------------->
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
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql);
mysql_close();
?>
