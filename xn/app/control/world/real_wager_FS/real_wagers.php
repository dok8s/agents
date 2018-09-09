<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select Agname,ID,language from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
require ("../../../member/include/traditional.zh-vn.inc.php");
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<style>
<!--
.za_text_f {background-color: #FFFFFF;font-size: 12px;border-style: solid; border-width: 0; padding: 0 0; margin:  2px}
.za_text_f_close {background-color: #CCCCCC;font-size: 12px;border-style: solid; border-width: 0; padding: 0 0; margin: 2px}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT>
var ReloadTimeID;
function onLoad(){
	parent.loading = 'N';
	parent.ShowType = 'FS';
	var obj_ltype = document.getElementById('ltype');
	obj_ltype.value = parent.ltype;
	var obj_retime = document.getElementById('retime');
	obj_retime.value = -1;
	parent.body_var.location = "./real_wagers_var.php?uid=<?=$uid?>&rtype=fs";
	if(obj_retime.value != -1)
		ReloadTimeID = setInterval("parent.body_var.location.reload()",obj_retime.value*1000);
}

function reload_var(){
	parent.body_var.location.reload();
}

function chg_ltype(){
	var obj_ltype = document.getElementById('ltype');
	var obj_set_account = document.getElementById('set_account');
	parent.body_var.location="./real_wagers_var.php?uid=<?=$uid?>&rtype=fs&ltype="+obj_ltype.value+"&set_account="+obj_set_account.value;
}

function chg_retime(){
	var obj_retime = document.getElementById('retime');
	TimeValue = obj_retime.value;
	if(ReloadTimeID) {clearInterval(ReloadTimeID);}
	if(TimeValue != -1){
		parent.body_var.location.reload();
		ReloadTimeID = setInterval("parent.body_var.location.reload()",TimeValue*1000);
	}
}

function chg_page(page_type){
	var obj_retime = document.getElementById('retime');
	var url_str = 'real_wagers.php?uid=<?=$uid?>&rtype='+page_type+'&retime='+obj_retime.value;
	self.location = url_str;
}

function show_bet(bet_str) {
	document.all["bet_title"].innerHTML ="<font color=#FFFFFF>"+bet_str+"</font>";
	bet_window.style.top=document.body.scrollTop+event.clientY-50;
	bet_window.style.left=document.body.scrollLeft+event.clientX-20;
	document.all["bet_window"].style.display = "block";
	setTimeout("close_win(2)", 10000);
}

function close_win(cw) {
	switch(cw){
		case(1):document.all["rs_window"].style.display = "none";
		break;
		case(2):document.all["bet_window"].style.display = "none";
		break;
	}
}

function onUnload(){
	if(ReloadTimeID) clearInterval(ReloadTimeID);
	parent.loading = 'Y';
	parent.ShowType = '';
}

function chg_account(set_account){
	parent.body_var.location="./real_wagers_var.php?uid=<?=$uid?>&rtype="+parent.stype_var+"&set_account="+set_account;
}

function chg_gtype(){
	var gametype = document.getElementById("game_type").value;
	top.game_type = gametype;
	parent.ShowGameList();
}

function get_new_top(){
	top.game_type = document.getElementById("game_type").value;
}
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()" onUnload="onUnload()">
<div id="main_body">
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60" >&nbsp;&nbsp;線上操盤:</td>
            <td>
              <select id="ltype" name="ltype" onChange="chg_ltype()" class="za_select">
                <option value="1">冠軍A</option>
                <option value="2">冠軍B</option>
                <option value="3">冠軍C</option>
                <option value="4">冠軍D</option>
              </select>
            </td>
            <td width="65">&nbsp;--&nbsp;重新整理:</td>
            <td>
              <select id="retime" name="retime" onChange="chg_retime()" class="za_select">
                <option value="-1">不更新</option>
				<option value="180" >180 sec</option>
              </select>
            </td>
            <td id="dt_now"></td>
            <td>&nbsp;--&nbsp;</td>
            <td>
            	<select id="game_type" name="game_type" onchange="chg_gtype();" class="za_select">
            		<option value="">全部</option>
            		<option value="FT">足球</option>
            		<option value="BK">籃球</option>
            		<option value="TN">網球</option>
            		<option value="VB">排球</option>
            	</select>
            </td>
            <!--td> -- <A HREF="#" onClick="chg_page('ou');" onMouseOver="window.status='單式'; return true;" onMouseOut="window.status='';return true;" style="background-color:">單式</a>
              &nbsp;<A HREF="#" onClick="chg_page('hou');" onMouseOver="window.status='上半場'; return true;" onMouseOut="window.status='';return true;"style="background-color:">上半場</a>
              &nbsp;<A HREF="#" onClick="chg_page('re');" onMouseOver="window.status='走地'; return true;" onMouseOut="window.status='';return true;"style="background-color:">滾球</a>
              &nbsp;<A HREF="#" onClick="chg_page('pd');" onMouseOver="window.status='波膽'; return true;" onMouseOut="window.status='';return true;"style="background-color:">波膽</a>
              &nbsp;<A HREF="#" onClick="chg_page('eo');" onMouseOver="window.status='總入球'; return true;" onMouseOut="window.status='';return true;"style="background-color:">總入球</a>
              &nbsp;<A HREF="#" onClick="chg_page('f');" onMouseOver="window.status='半全場'; return true;" onMouseOut="window.status='';return true;"style="background-color: ">半全場</a>
              &nbsp;<A HREF="#" onClick="chg_page('par');" onMouseOver="window.status='過關'; return true;" onMouseOut="window.status='';return true;"style="background-color:">過關</a>
              &nbsp;<A HREF="#" onClick="chg_page('fs');" onMouseOver="window.status='特殊'; return true;" onMouseOut="window.status='';return true;"style="background-color:#3399FF">特殊</a>
              &nbsp;<A HREF="#" onClick="chg_page('p');" onMouseOver="window.status='已開賽'; return true;" onMouseOut="window.status='';return true;"style="background-color:">已開賽</a>
            </td-->
          </tr>
        </table>
      </td>
      <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
    <tr>
      <td colspan="2"><font color="#000099">&nbsp;&nbsp;特殊&nbsp;&nbsp;</font>
		觀看方式&nbsp;<select id="set_account" name="set_account" onchange="chg_account(this.value);" class="za_select">
        		<option value="0">全部</option>
			<option value="1">自己</option>
		</select></td>
    </tr>
  </table>
  <div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: visible">
    <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>
  <table id="glist_table" width="835" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab">
    <tr class="m_title_ft"  >
    <td width="38" >時間</td>
    <td width="100">聯盟</td>
    <td>隊伍/賠率</td>
    </tr>
  </table>
</div>
<div id="update_msg" style="display: none"><br><br><center>更新中............</center></div>
</body>
</html>