<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$retime=$_REQUEST['retime'];
$rtype=strtoupper(trim($_REQUEST['rtype']));
$sql = "select * from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];
$langx=$row['language'];
require ("../../../member/include/traditional.$langx.inc.php");

if ($rtype==''){
	$rtype='OU';
}
if ($retime==''){
	$retime=-1;
}

switch ($rtype){
case "ALL":
	$caption='单式全部';
	$width="848";
	$back_all="#3399ff";
	$table='			<td width="38">时间</td>
			<td width="52" nowrap>联盟</td>
			<td width="28">场次</td>
			<td width="200">队伍</td>
			<td width="200">让分 / 注单</td>
			<td width="200">大小盘 / 注单</td>
			<!--td width="130">独赢</td-->
			<td width="130">单双</td>';
	$rtype2='OU';
	break;
case "OU":
	$caption=$rel_straight;
	$width="848";
	$back_ou="#3399ff";
	$table='			<td width="38">时间</td>
			<td width="52" nowrap>联盟</td>
			<td width="28">场次</td>
			<td width="200">队伍</td>
			<td width="200">让分 / 注单</td>
			<td width="200">大小盘 / 注单</td>
			<!--td width="130">独赢</td-->
			<td width="130">单双</td>';
	$rtype2='OU';
	break;
case "R4":
	$caption='单节';
	$width="848";
	$back_rq4="#3399ff";
	$table='<td width="38">时间</td>
			<td width="52" nowrap>联盟</td>
			<td width="28">场次</td>
			<td width="200">队伍</td>
			<td width="200">让分 / 注单</td>
			<td width="200">大小盘 / 注单</td>
			<!--td width="130">独赢</td-->
			<td width="130">单双</td>';
	$rtype2='OU';
	break;
case "RE":
	$caption='单节';
	$width="708";
	$back_re="#3399ff";
	$table='<td width="38">时间</td>
    <td width="52" nowrap>联盟</td>
    <td width="28">场次</td>
    <td width="200">队伍</td>
    <td width="195">让分 / 注单</td>
    <td width="195">大小盘 / 注单</td>';
	$rtype2='RE';
	break;
case "PAR":
	$caption=$rel_parlay;
	$width="438";
	$back_par="#3399ff";
	$table='			<td width="38">时间</td>
			<td width="52" nowrap>联盟</td>
			<td width="28">场次</td>
			<td width="200">队伍</td>
			<td width="120">过关</td>';
	$rtype2='P';
	break;
case "P":
	$caption=$rel_haveopen;
	$back_p="#3399ff";
	$width="1000";
	$table='			<td width="38">时间</td>
			<td width="40" nowrap>联盟</td>
			<td width="28">场次</td>
			<td width="200">队伍</td>
			<td width="200">让分</td>
			<td nowrap>大小盘</td>
			<td nowrap>走地</td>
			<td nowrap>走地大小</td>
			<td nowrap>单双</td>
			<td nowrap>过关</td>';
	$rtype2='PL';
	break;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT LANGUAGE="JAVASCRIPT1.2">
 var ReloadTimeID;
 function onLoad()
 {
  parent.loading = 'N';
  parent.ShowType = '<?=$rtype2?>';
  var obj_ltype = document.getElementById('ltype');
  obj_ltype.value = parent.ltype;
  var obj_retime = document.getElementById('retime');
  obj_retime.value =  <?=$retime?>;
  parent.pg=0;
  parent.body_var.location = "./real_wagers_var.php?uid=<?=$uid?>&rtype=<?=$rtype?>&page_no=0";
  if(obj_retime.value != -1)
   ReloadTimeID = setInterval("parent.body_var.location.reload()",obj_retime.value*1000);
 }

  function reload_var()
 {
  parent.body_var.location.reload();
 }
 function chg_ltype()
 {
  var obj_ltype = document.getElementById('ltype');
  var obj_set_account = document.getElementById('set_account');
  parent.body_var.location="./real_wagers_var.php?uid=<?=$uid?>&rtype=<?=$rtype?>&ltype="+obj_ltype.value+"&page_no="+parent.pg+"&league_id="+parent.sel_league+"&set_account="+obj_set_account.value;
 }
 function chg_retime()
 {
  var obj_retime = document.getElementById('retime');
  TimeValue = obj_retime.value;
  if(ReloadTimeID)
   clearInterval(ReloadTimeID);
  if(TimeValue != -1)
  {
   parent.body_var.location.reload();
   ReloadTimeID = setInterval("parent.body_var.location.reload()",TimeValue*1000);
  }
 }
 function chg_page(page_type)
 {
  var obj_retime = document.getElementById('retime');
  var url_str = 'real_wagers.php?uid=<?=$uid?>&rtype='+page_type+'&retime='+obj_retime.value;
  self.location = url_str;
 }
function onUnload()
 {
  if(ReloadTimeID) clearInterval(ReloadTimeID);
  parent.loading = 'Y';
  parent.ShowType = '';
  parent.pg=0;
  parent.sel_league='';
 }


 function chg_account(set_account){
	var obj_league = document.getElementById('sel_lid');
 	parent.body_var.location="./real_wagers_var.php?uid=<?=$uid?>&rtype="+parent.stype_var+"&set_account="+set_account+"&league_id="+obj_league.value+"&page_no="+parent.pg;
 }
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()" onUnload="onUnload()">
<FORM NAME="REFORM" ACTION="" METHOD=POST>
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60" >&nbsp;&nbsp;<?=$rel_contorl?>:</td>
            <td>
              <select id="ltype" name="ltype" onChange="chg_ltype()" class="za_select">
                <option value="1">篮A</option>
                <option value="2">篮B</option>
                <option value="3">篮C</option>
                <option value="4">篮D</option>
              </select>
            </td>
            <td width="65"> -- <?=$rel_reload?></td>
            <td>
              <select id="retime" name="retime" onChange="chg_retime()" class="za_select">
                <option value="-1" ><?=$rel_refresh?></option>
				<option value="180" >180 sec</option>
              </select>
            </td>
            <td id="dt_now"> -- <?=$rel_dtnow?>:</td>
						<td>&nbsp;--&nbsp;<a href="#" onClick="chg_page('all');" onMouseOver="window.status='单式全部'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_all?>">单式全部</a>
							&nbsp;<a href="#" onClick="chg_page('ou');" onMouseOver="window.status='单式'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_ou?>">单式</a>
							&nbsp;<a href="#" onClick="chg_page('r4');" onMouseOver="window.status='单节'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_rq4?>">单节</a>
							&nbsp;<a href="#" onClick="chg_page('re');" onMouseOver="window.status='滚球'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_re?>">滚球</a>
							&nbsp;<a href="#" onClick="chg_page('par');" onMouseOver="window.status='过关'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_par?>">过关</a>
							&nbsp;<a href="#" onClick="chg_page('p');" onMouseOver="window.status='已开赛'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_p?>">已开赛</a>
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
  <table height="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width='70'><font color="#000099">&nbsp;&nbsp;<?=$caption?></font></td>
		<td>观看方式&nbsp;<select id="set_account" name="set_account" onChange="chg_account(this.value);" class="za_select">
        		<option value="0">全部</option>
			<option value="1">自己</option>
			<!--option value="2">公司</option-->
		</select></td>
	</tr>
  </table>
  <div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: visible">
    <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>
<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="2A73AC" class="m_tab" width="<?=$width?>">
    <tr class="m_title_bk">
    <?=$table?>
    </tr>
</table>
</form>
</body>
</html>
