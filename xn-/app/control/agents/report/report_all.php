<?
Session_start();
if (!$_SESSION["bkbk"])
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
$mid         = $_REQUEST['mid'];
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
if($uid==""){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$sql = "select super,Agname,ID,language,subname,subuser,world,corprator from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0 ){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);

if ($result_type=='Y'){
	$QQ526738='<font color=green>有结果</font>';
}else{
	$QQ526738='<font color=green>无结果</font>';
}

if ($row['subuser']==1){
	$agname=$row['subname'];
	$loginfo=$agname.'子帐号:'.$row['subuser'].'查询期间'.$date_start.'至'.$date_end.$QQ526738.'报表';
}else{
	$agname=$row['Agname'];
	$loginfo='代理商:'.$row['Agname'].'查询期间'.$date_start.'至'.$date_end.$QQ526738.'报表';
}

$agid=$row['ID'];
$super=$row['super'];
$corprator=$row['corprator'];
$world=$row['world'];
$where=get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end,$row['subuser']);

$sql="select agents as name,count(*) as coun,sum(betscore) as score,sum(m_result) as result,sum(a_result) as a_result,sum(result_a) as result_a,sum(vgold) as vgold,round(agent_point*0.01,2) as agent_point from web_db_io where ".$where." and super='$super' and Agents='$agname'";

?>
<script>if(self == top) location='/'
;</script><html>
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
    <td class="m_tline" width="750">&nbsp;&nbsp;<?=$rag_date?>:<?=$date_start?>~<?=$date_end?>
      -- <?=$rep_kind?>:<?=$rep_kind_a?> -- <?=$rep_pay_type?>:<?=$rep_pay?> -- <?=$rep_wtype?>:<?=$type_caption?> -- <?=$rag_type?> -- <a href="javascript:history.go( -1 );">回上一页</a></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
if ($credit=='block'){
	$mysql=$sql." and pay_type=0 group by agents order by name asc";
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
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: <?=$credit?>" width="880">
  <tr class="m_title_reall" >
    <td colspan="10">信用额度</td>
  </tr>
  <tr class="m_title_reall" >
    <td width="50"  >名称</td>
    <td width="80"  >笔数</td>
    <td width="110"  >下注金额</td>
    <td width="110"  >有效金额</td>
    <td width="90"  >会员</td>
    <td width="90"  >代理商</td>
    <td width="90"  >代理商成数</td>
    <td width="90"  >代理商结果</td>
    <td width="90"  >原币值</td>
    <td width="80"  >实货量</td>
  </tr>
   	<?
	while ($row = mysql_fetch_array($result)){
		$c_score+=$row['score'];
		$c_num+=$row['coun'];
		$c_m_result+=$row['result'];
		$c_vscore+=$row['vgold'];
		$c_a_result+=$row['a_result'];
		$c_result_a+=$row['result_a'];
		$c_vgold+=(1-$row['agent_point'])*$row['vgold'];
  	?>
	<tr class="m_rig" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF="report_agent.php?uid=<?=$uid?>&result_type=<?=$result_type?>&aid=<?=$row['name']?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=mynumberformat($row['score'],1)?></a></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td><?=mynumberformat($row['result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td><?=$row['agent_point']?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat((1-$row['agent_point'])*$row['vgold'],1)?></td>
  </tr>
	<?
	}
	?>
  <tr class="m_rig_to">
    <td>总计</td>
    <td><?=$c_num?></td>
    <td><?=mynumberformat($c_score,1)?></td>
    <td><?=mynumberformat($c_vscore,1)?></td>
    <td><?=mynumberformat($c_m_result,1)?></td>
    <td><?=mynumberformat($c_a_result,1)?></td>
    <td></td>
    <td><?=mynumberformat($c_result_a,1)?></td>
    <td><?=mynumberformat($c_result_a,1)?></td>
    <td><?=mynumberformat($c_vgold,1)?></td>
    </tr>
</table>
<!-----------------↑ 信用额度资料区段 ↑------------------------->
<BR>
<?
if ($sgold=='block'){
	$mysql=$sql." and pay_type=1 group by agents order by name asc";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$sgold='none';
	}
}else{
	$sgold='block';
}
?>
<!-----------------↓ 现金资料区段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: <?=$sgold?>" width="940">
  <tr class="m_title_reall" >
    <td colspan="10">现金</td>
  </tr>
  <tr class="m_title_reall" >
   <td width="50"  >名称</td>
    <td width="80"  >笔数</td>
    <td width="110"  >下注金额</td>
    <td width="110"  >有效金额</td>
    <td width="90"  >会员</td>
    <td width="90"  >代理商</td>
    <td width="90"  >代理商成数</td>
    <td width="90"  >代理商结果</td>
    <td width="90"  >原币值</td>
    <td width="80"  >实货量</td>
  </tr>
<?
	while ($row = mysql_fetch_array($result)){
		$c_score1+=$row['score'];
		$c_num1+=$row['coun'];
		$c_m_result1+=$row['result'];
		$c_vscore1+=$row['vgold'];
		$c_a_result1+=$row['a_result'];
		$c_result_a1+=$row['result_a'];
		$c_vgold1+=(1-$row['agent_point'])*$row['vgold'];
  	?>

	<tr class="m_rig" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF="report_agent.php?uid=<?=$uid?>&result_type=<?=$result_type?>&aid=<?=$row['name']?>&pay_type=1&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=mynumberformat($row['score'],1)?></a></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td><?=mynumberformat($row['result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td><?=$row['agent_point']?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat((1-$row['agent_point'])*$row['vgold'],1)?></td>
  </tr>
	<?
	}
	?>
  <tr>
    <td height="1" colspan="10"></td>
  </tr>
  <!-- END DYNAMIC BLOCK: group0 -->
  <tr class="m_rig_to">
    <td>总计</td>
    <td><?=$c_num1?></td>
    <td><?=mynumberformat($c_score1,1)?></td>
    <td><?=mynumberformat($c_vscore1,1)?></td>
    <td><?=mynumberformat($c_m_result1,1)?></td>
    <td><?=mynumberformat($c_a_result1,1)?></td>
    <td></td>
    <td><?=mynumberformat($c_result_a1,1)?></td>
    <td><?=mynumberformat($c_result_a1,1)?></td>
    <td><?=mynumberformat($c_vgold1,1)?></td>
  </tr>
</table>
<BR>
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
</body>
</html>
<?
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','3')";
mysql_query($mysql);
mysql_close();
?>
