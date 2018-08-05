<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select super,Agname,ID,language,subname,subuser from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$week1=date('w+1');
$row = mysql_fetch_array($result);
if ($row['subuser']==1){
	$agname=$row['subname'];
	$loginfo=$agname.'子帐号:'.$row['subname'].'查询期间报表';
}else{
	$agname=$row['Agname'];
	$loginfo='查询期间'.$date_start.'至'.$date_end.'报表';
}
$agid=$row['ID'];
$super=$row['super'];

$langx=$row['language'];
require ("../../member/include/traditional.$langx.inc.php");

$langx=$row['language'];
$date_s=date('Y-m-d',time()-24*3600);
$date_e=date('Y-m-d',time()-24*3600);

$today=date('Y-m-d');
$nowday=TDate();

$week1=date('w');
if($week1==0){
	$week1=6;
}else{
	$week1=$week1-1;
}

?>
<html>
<head>
<title>reports</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}
.m_bc { background-color: #C9DBDF; padding-left: 7px }
.small {
	font-size: 11px;
	background-color: #7DD5D2;
	text-align: center;
}
.small_top {
	font-size: 11px;
	color: #FFFFFF;
	background-color: #669999;
	text-align: center;
}
.show_ok {background-color: gold; color: blue}
.show_no {background-color: yellow; color: red}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css">
<SCRIPT>
<!--
function onSubmit(){
	kind_obj = document.getElementById("report_kind");
	form_obj = document.getElementById("myFORM");
	if(kind_obj.value == "A")
		form_obj.action = "report_all.php";
	else
		form_obj.action = "report_all.php?report_kind="+kind_obj.value;
	return true;
}
-->
</SCRIPT>
<style type="text/css">
<!--
.m_title_ce {background-color: #669999; text-align: center; color: #FFFFFF}
-->
</style>
</head>
<script language="JavaScript" src="/js/simplecalendar.js"></script>
<script language="JavaScript">

function chg_date(range,num1,num2){
	//alert(num1+'-'+num2);
	if(range=='t' || range=='w' || range=='lw' || range=='r'){
		FrmData.date_start.value ='<?=$today?>';
		FrmData.date_end.value =FrmData.date_start.value;
	}

	if(range!='t'){
		if(FrmData.date_start.value!=FrmData.date_end.value){
			FrmData.date_start.value ='<?=$today?>';
			FrmData.date_end.value =FrmData.date_start.value;
		}
		var aStartDate = FrmData.date_start.value.split('-');
		var newStartDate = new Date(parseInt(aStartDate[0], 10),parseInt(aStartDate[1], 10) - 1,parseInt(aStartDate[2], 10) + num1);
		FrmData.date_start.value = newStartDate.getFullYear()+ '-' + padZero(newStartDate.getMonth() + 1)+ '-' + padZero(newStartDate.getDate());
		var aEndDate = FrmData.date_end.value.split('-');
		var newEndDate = new Date(parseInt(aEndDate[0], 10),parseInt(aEndDate[1], 10) - 1,parseInt(aEndDate[2], 10) + num2);
		FrmData.date_end.value = newEndDate.getFullYear()+ '-' + padZero(newEndDate.getMonth() + 1)+ '-' + padZero(newEndDate.getDate());
	}
}
function report_bg(){
	document.getElementById(date_num).className="report_c";
}
</script>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<FORM id="myFORM" ACTION="" METHOD=POST onSubmit="return onSubmit();" name="FrmData">
<input type=HIDDEN name="uid" value="<?=$uid?>">
<table width="780" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="m_tline">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="60">&nbsp;&nbsp;报表管理:</td>
									<td><select name="gtype" class="za_select">
								<option value="">全部</option>
								<option value="FT">足球</option>
								<option value="BK">篮球</option>
								<option value="TN">网球</option>
								<option value="VB">排球</option>
								<option value="BS">棒球</option>
								<option value="OP">其它 </option>
								<option value="FS">冠军</option>
						</select>
					</td>
<td width="80"></td>
						<td nowrap>
							&nbsp;<a href="./report.php?uid=<?=$uid?>" onMouseOver="window.status='报表'; return true;" onMouseOut="window.status='';return true;"style="background-color:">报表</a>
							&nbsp;<a href="./report_cancel_wager.php?uid=<?=$uid?>" onMouseOver="window.status='取消单分析'; return true;" onMouseOut="window.status='';return true;"style="background-color:#3399FF">取消单分析</a>
						</td>

				</tr>
			</table>
		</td>
		<td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
	</tr>
	<tr>
		<td colspan="2" height="4"></td>
	</tr>
</table>

<table><tr><td>

<table width="660" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
	<tr class="m_bc">
		<td width="100" class="m_title_re"> 日期区间: </td>
		<td colspan="5">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><input type=TEXT name="date_start" value="<?=$date_s?>" size=10 maxlength=11 class="za_text"></td>
					<td><a href="javascript: void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_start',true,'yyyy-mm-dd'); return false;">&nbsp;&nbsp;<img src="/images/control/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a></td>
					<td width="20" align="center"> ~</td>
					<td><input type=TEXT name="date_end" value="<?=$date_e?>" size=10 maxlength=10 class="za_text"></td>
					<td><a href="javascript: void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_end',true,'yyyy-mm-dd'); return false;">&nbsp;&nbsp;<img src="/images/control/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a></td>
					<td>&nbsp;</td>
					<td>
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('t',0,0)" value="今日">
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('l',-1,-1)" value="昨日">
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('n',1,1)" value="明日">
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('w',-<?=$week1?>,6-<?=$week1?>)" value="本星期">
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('lw',-<?=$week1?>-7,6-<?=$week1?>-7)" value="上星期">
						<input name="Submit" type="Button" class="za_button" onClick="FrmData.date_start.value='<?=$nowday[0]?>';FrmData.date_end.value='<?=$nowday[1]?>'" value="本期">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="m_bc">
		<td class="m_title_re"> 报表分类: </td>
		<td colspan="4">
			<select name="report_kind" class="za_select">
				
				<option value="D">取消</option>
				<option value="D4">非正常投注单</option>
				<!--option value="C">分类帐</option-->
			</select>
		</td>
	</tr>
	<!--tr class="m_bc">
		<td class="m_title_re"> 币值: </td>
		<td colspan="4">
			<select name="currency" class="za_select"-->
				<!-- BEGIN DYNAMIC BLOCK: currency -->
				<!--option value="{CUR_VALUE}">{CUR_NAME}</option-->
				<!-- END DYNAMIC BLOCK: currency -->
			<!--/select>
		</td>
	</tr-->
	<tr class="m_bc">
		<td class="m_title_re"> 投注方式: </td>
		<td colspan="4">
			<select name="pay_type" class="za_select">
				<option value="" SELECTED>全部</option>
				<option value="0">信用额度</option>
				<option value="1">现金</option>
			</select>
		</td>
	</tr>
	<tr class="m_bc">
		<td class="m_title_re"> 投注种类: </td>
		<td colspan="4">
			<select name="wtype" class="za_select">
				<option value="" SELECTED>全部</option>
				<option value="R">让球(分)</option>
				<option value="RE">滚球</option>
				<option value="P">标准过关</option>
				<option value="PR">让球(分)过关</option>
				<option value="PC">综合过关</option>
				<option value="OU">大小</option>
				<option value="ROU">滚球大小</option>
				<option value="PD">波胆</option>
				<option value="T">入球</option>
				<option value="M">独赢</option>
				<option value="F">半全场</option>
				<option value="HR">上半场让球(分)</option>
				<option value="HOU">上半场大小</option>
				<option value="HM">上半场独赢</option>
				<option value="HRE">上半滚球让球(分)</option>
				<option value="HROU">上半滚球大小</option>
                                <option value="HPD">上半波胆</option>
			</select>
		</td>
	</tr>
	
	<tr bgcolor="#FFFFFF">
		<td height="30" colspan="6">
			<table>
				<tr>
					<td align="right" width="60"> 注单状态: </td>
					<td width="250">
						<select name="result_type" class="za_select">
							<OPTION VALUE="Y">有结果</OPTION>
							<OPTION VALUE="N">未有结果</OPTION>
						</select>
					</td>
					<td>
						<input type=SUBMIT name="SUBMIT" value="查询" class="za_button">
						&nbsp;&nbsp;&nbsp;
						<input type=BUTTON name="CANCEL" value="取消" onClick="javascript:history.go(-1)" class="za_button">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

 </td>
</tr></table>
</form></body>
</html>

<?
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','1')";
mysql_query($mysql);
mysql_close();
?>
