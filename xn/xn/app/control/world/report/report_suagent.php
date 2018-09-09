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
	$loginfo=$agname.'子帐号:'.$row['Agname'].'查询总代理'.$sid.':'.$date_start.'至'.$date_end.$QQ526738.'报表投注明细';
}else{
	$agname=$row['Agname'];
	$loginfo='查询总代理'.$sid.':'.$date_start.'至'.$date_end.$QQ526738.'报表投注明细';
}
$agid=$row['ID'];
$super=$row['super'];
$where=get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end,$row['subuser']);

$sql="select sum(vgold) as vgold,agent_point,world_point,count(*) as coun,sum(BetScore) as score,sum(M_Result) as result,sum(a_result) as a_result,sum(result_a) as result_a,sum(result_s) as result_s,agents as name from web_db_io where ".$where." and world='$agname'";

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_reag { background-color: #687780; text-align: center; color: #FFFFFF}
-->
</style>

<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT language=javaScript src="/js/report_func.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript src="/js/FlashContent.js" type=text/javascript></SCRIPT>
<script language="javascript">
var WData=new Array();
var gamount=0;
function Show_winloss_DETAIL(obj_table,WinlossData,data_amount){
	with(obj_table){
		while(rows.length> 1)
			deleteRow(rows.length-1);
		if (data_amount==0){
			nowTR = insertRow();
			nowTR.align = 'center';
			nowTR.bgColor = '#FFFFFF';
			with(nowTR){
				nowTD = insertCell();
				nowTD.vAlign = 'top';
				with(nowTD){
					innerHTML = '<font color=\"#FF0000\">没有修改纪录</font>';
					colSpan='3';
				}
			}
		}
		for(i=0; i<data_amount; i++){
			nowTR = insertRow();
			nowTR.align = 'right';
			nowTR.bgColor = '#FFFFFF';
			with(nowTR){
				//成数
				nowTD = insertCell();
				nowTD.vAlign = 'top';
				nowTD.innerHTML = '<font color=\"#FF0000\">'+WinlossData[i][0]+'</font>';
				//日期
				nowTD = insertCell();
				nowTD.vAlign = 'top';
				nowTD.innerHTML = '<font color=\"#FF0000\">'+WinlossData[i][1]+'</font>';
				//Khi
				nowTD = insertCell();
				nowTD.vAlign = 'top';
				nowTD.innerHTML = '<font color=\"#FF0000\">'+WinlossData[i][2]+'</font>';
			}//with(TR)
		}
	}//with(obj_table);
}

function show_detail(sid,aid){
	self.winloss_window.style.position='absolute';
	self.winloss_window.style.top=event.clientY+15;
	self.winloss_window.style.left=event.clientX-300;
	self.winloss_window.style.visibility='visible';
	winloss_form.sid.value=sid;
	winloss_form.aid.value=aid;
	winloss_form.submit();
}
function show_one(){
	show_table = document.getElementById("winloss_table");
	Show_winloss_DETAIL(show_table,WData,gamount);
}

function init(){
	callas(getCommand("report"));
}
</script>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onLoad="init();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="m_tline">
		<td>&nbsp;&nbsp;日期:<?=$date_start?>~<?=$date_end?>
		-- 报表分类:总帐 -- 投注方式:全部 -- 投注总类:全部 -- 下注管道:网路下注 -- <a href="javascript:history.go( -1 );">回上一页</a></td>
		<td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
	</tr>
	<tr>
		<td colspan="2" height="4"></td>
	</tr>
</table>
<?
$mysql=$sql." and pay_type=".$pay_type."  group by agents order by name asc";

$result = mysql_query($mysql);
$cou=mysql_num_rows($result);
if ($cou==0){
	$credit='none';
}else{
	$credit='block';
}

?>
<!-----------------↓ 信用额度资料区段 ↓------------------------->
<table width="1010" border="0" cellspacing="1" cellpadding="0" class="m_tab" style="display: {LIST_CREDIT}" bgcolor="#000000">
	<tr class="m_title_reag">
		<td colspan="13"><?=$rep_pay?></td>
	</tr>
	<tr class="m_title_reag">
		<td width="70">代理商</td>
		<td width="40">笔数</td>
		<td width="95">下注金额</td>
		<td width="95">有效金额</td>
		<td width="100">会员</td>
		<td width="90">代理商</td>
		<td width="80">代理商成数</td>
		<td width="90">代理商结果</td>
		<td width="80">总代理成数</td>
		<td width="90">总代理结果</td>
		<td width="75">备注</td>
		<td width="75">备注1</td>
		<td width="30">功能</td>
	</tr>
	<?
	while ($row = mysql_fetch_array($result)){
		$c_score+=$row['score'];
		$c_num+=$row['coun'];
		$c_m_result+=$row['result'];
		$c_vgold+=$row['vgold'];
		$c_a_result+=$row['a_result'];
		$c_result_a+=$row['result_a'];
		$c_result_s+=$row['result_s'];
		$abc+=$row['vgold']*(100-$row['agent_point'])*0.01;
  	?>
	<tr class="m_rig" align="left" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
		<td align="left"><?=$row['name']?></td>
		<td><?=$row['coun']?></td>
		<td><A HREF="report_agent.php?uid=<?=$uid?>&result_type=<?=$result_type?>&aid=<?=$row['name']?>&pay_type=<?=$pay_type?>&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=$row['score']?></a></td>
		<td><?=mynumberformat($row['vgold'],1)?></td>
		<td><?=mynumberformat($row['result'],1)?></td>
		<td><?=mynumberformat($row['a_result'],1)?></td>
		<td><?=mynumberformat($row['agent_point']/100,2)?></td>
		<td><?=mynumberformat($row['result_a'],1)?></td>
		<td ><?=mynumberformat($row['world_point']/100,2)?></td>
		<td><?=mynumberformat($row['result_s'],1)?></td>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" width="100%">
				<tr>
					<td></td>
					<td align="right"><?=mynumberformat($row['result_a'],1)?></td>
				</tr>
			</table>
		</td>
		<td><?=mynumberformat($row['vgold']*(100-$row['agent_point'])*0.01,1)?></td>
		<td><A href="javascript:" onClick="show_detail('{SID0}','{AID0}');">详细</A></td>
	</tr>
<?
}
?>
	<!-- END DYNAMIC BLOCK: item0 -->
	<tr class="m_rig_re">
		<td></td>
		<td><?=$c_num?></td>
		<td><?=$c_score?></td>
		<td><?=mynumberformat($c_vgold,1)?></td>
		<td><?=mynumberformat($c_m_result,1)?></td>
		<td><?=mynumberformat($c_a_result,1, '.', '')?></td>
		<td></td>
		<td><?=mynumberformat($c_result_a,1, '.', '')?></td>
		<td></td>
		<td><?=mynumberformat($c_result_s,1, '.', '')?></td>
		<td><?=mynumberformat($c_result_a,1)?></td>
		<td><?=mynumberformat($abc,1)?></td>
		<td></td>
	</tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="15"></td>
	</tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="15"></td>
	</tr>
</table>
<!-----------------↑ 现金资料区段 ↑------------------------->
<table width="980" border="0" cellspacing="1" cellpadding="0" class="m_tab" style="display: {LIST_ALL}" bgcolor="#000000">
	<tr class="m_title_reag">
		<td width="70">总代理商</td>
		<td width="40">笔数</td>
		<td width="95">下注金额</td>
		<td width="90">有效金额</td>
		<td width="100">会员</td>
		<td width="85">代理商</td>
		<td width="80">代理商成数</td>
		<td width="90">代理商结果</td>
		<td width="80">总代理成数</td>
		<td width="90">总代理结果</td>
		<td width="75">备注</td>
		<td width="75">备注1</td>
	</tr>
	<!-- BEGIN DYNAMIC BLOCK: row2 -->
	<tr class="m_rig">
		<td align="left"><?=$sid?></td>
		<td><?=$c_num?></td>
		<td><?=$c_score?></td>
		<td><?=mynumberformat($c_vgold,1)?></td>
		<td><?=mynumberformat($c_m_result,1)?></td>
		<td><?=mynumberformat($c_a_result,1, '.', '')?></td>
		<td></td>
		<td><?=mynumberformat($c_result_a,1, '.', '')?></td>
		<td></td>
		<td><?=mynumberformat($c_result_s,1, '.', '')?></td>
		<td></td>
		<td></td>
	</tr>
	<!-- END DYNAMIC BLOCK: row2 -->
</table>
<br>&nbsp;
<?
if ($credit=='none' and $sgold=='none'){
	$nosearch='block';
}else{
	$nosearch='none';
}
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" style="display: <?=$nosearch?>">
	<tr>
		<td align=center height="30" bgcolor="#CC0000"><marquee align="middle" behavior="alternate" width="200"><font color="#FFFFFF">查无任何资料</font></marquee></td>
	</tr>
	<tr>
		<td align=center height="20" bgcolor="#CCCCCC"><a href="javascript:history.go(-1);">离开</a></td>
	</tr>
</table>
<!-----------------↑ 无资料区段 ↑------------------------->
<form name="winloss_form" id=winloss_form action="report_winloss_detail.php" method="post" target=showdata>
	<div class="t_div" id="winloss_window" style="visibility:hidden;position: absolute;">
		<input type=hidden name='uid' value='{UID}'>
		<input type=hidden name='sid' value=''>
		<input type=hidden name='aid' value=''>
		<input type=hidden name='date_start' value='{DATE_START}'>
		<input type=hidden name='date_end' value='{DATE_END}'>
		<input type=hidden name='id_type' value='sid'>
		<table id="winloss_table" border="0" cellspacing="1" cellpadding="0" bgcolor="006255" class="m_tab" width="300">
			<tr class="m_title_ft">
				<td nowrap>成数</td>
				<td nowrap>修改日期</td>
				<td nowrap>修改Khi</td>
			</tr>
		</table>
		<input type='button' class="za_button" onClick="self.winloss_window.style.visibility='hidden';" value='关闭'>
	</div>
</form>
<iframe id=showdata name=showdata src='/ok.html' scrolling='no' width="0"></iframe>
</body>
</html>
<?
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql);
mysql_close();
?>
