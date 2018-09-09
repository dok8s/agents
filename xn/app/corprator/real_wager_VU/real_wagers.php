<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$retime=$_REQUEST['retime'];
$rtype=strtoupper(trim($_REQUEST['rtype']));
$sql = "select * from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];
$langx=$row['language'];
require ("../../member/include/traditional.zh-vn.inc.php");

if ($rtype==''){
	$rtype='OU';
}
if ($retime==''){
	$retime=-1;
}

switch ($rtype){
case "OU":
	$caption=$rel_straight;
	$width="973";
	$back_ou="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
     <td width = "52" nowrap> Liên minh </td>
     <td width = "28"> Sự kiện </td>
     <td width = "200"> Nhóm </td>
     <td width = "200"> Tham vấn / Lưu ý </td>
     <td width = "195"> Kích thước / ghi chú nhỏ </td>
     <td width = "130"> giành chiến thắng một mình </td>
     <td width = "130"> Đơn và đôi </td> ';
	break;
case "PD":
	$caption=$rel_correct;
	$back_pd="#3399ff";
	$width="360";
	$table="<td width=38 >$rel_body_time</td>\n      <td width=28>$rel_body_league</td>\n      <td width=148>$rel_lhometeam</td>\n      <td width=120>$rel_correct</td>";
	break;
case "P":
	$caption=$rel_parlay;
	$width="360";
	$back_par="#3399ff";
    $table = '<td width = 38> thời gian </td>
     <td width = 28> Liên minh </td>
     <td width = 28> lần </td>
     <td width = 120> Nhóm </td>
     <td width = 120> giải phóng mặt bằng </td> ';
	break;
case "PL":
	$caption=$rel_haveopen;
	$back_p="#3399ff";
	$width="940";
    $table = '<td width = "38"> Thời gian </td>
     <td width = "52" nowrap> Liên minh </td>
     <td width = "28"> Sự kiện </td>
     <td width = "200"> Nhóm </td>
     <td width = "165"> Hãy để văn phòng </td>
     <td nowrap> đĩa kích thước </td>
     <td nowrap> lăn bóng </td>
     <td nowrap> Kích thước bóng đẩy </td>
     <td nowrap> chiến thắng </td>
     <td nowrap> 波胆 </td>
     <td nowrap> Đơn và đôi </td>
     <td nowrap> giải phóng mặt bằng </td> ';
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
  parent.ShowType = '<?=$rtype?>';
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

function chg_pg(pg)
{
	var obj_set_account = document.getElementById('set_account');
	if (pg==parent.pg)return;
	parent.pg=pg;
	parent.loading_var = 'Y';
	parent.body_var.location = "./real_wagers_var.php?uid="+parent.uid+"&rtype="+parent.stype_var+"&langx="+parent.langx+"&ltype="+parent.ltype+"&page_no="+parent.pg+"&set_account="+obj_set_account.value;
}
function chg_league(){
	var obj_set_account = document.getElementById('set_account');
	obj_pg = document.getElementById('pg_txt');
	var obj_league = document.getElementById('sel_lid');
	parent.sel_league=obj_league.value;
	parent.ShowGameList();
	parent.body_var.location = "./real_wagers_var.php?uid="+parent.uid+"&rtype="+parent.stype_var+"&langx="+parent.langx+"&ltype="+parent.ltype+"&league_id="+obj_league.value+"&set_account="+obj_set_account.value;
	parent.pg=0;
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
                <option value="1">Hàng A</option>
                <option value="2">Hàng B</option>
                <option value="3">Hàng C</option>
                <option value="4">Hàng D</option>
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
            <td> -- <A HREF="#" onClick="chg_page('ou');" onMouseOver="window.status='<?=$rel_straight?>'; return true;" onMouseOut="window.status='';return true;" style="background-color: <?=$back_ou?>"><?=$rel_straight?></a>
              &nbsp;<A HREF="#" onClick="chg_page('pd');" onMouseOver="window.status='<?=$rel_correct?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_pd?>"><?=$rel_correct?></a>
              &nbsp;<A HREF="#" onClick="chg_page('p');" onMouseOver="window.status='<?=$rel_parlay?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_par?>"><?=$rel_parlay?></a>

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
		<td>Cách xem&nbsp;<select id="set_account" name="set_account" onChange="chg_account(this.value);" class="za_select">
        		<option value="0">Tất cả</option>
			<option value="1">Sở hữu</option>
			<!--option value="2">公司</option-->
		</select></td>

<?
if ($rtype=='OU' or $rtype=='V' or $rtype=='PD' or $rtype=='F' or $rtype=='P'){
?>
		<td>&nbsp;Chọn liên minh <span id="show_h"></span></td>
<?
}

if ($rtype!='RE'){
?>

		<td width='450'>&nbsp;&nbsp;<span id="pg_txt"></span></td>
<?
}
?>	</tr>
  </table>
  <div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: visible">
    <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>
<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab_vb" width="<?=$width?>">
    <tr class="m_title_vb">
    <?=$table?>
    </tr>
</table>
</form>

<span id="bowling" style="position:absolute; display: none">
	<option value="*LEAGUE_ID*" *SELECT*>*LEAGUE_NAME*</option>
</span>


<span id="bodyH" style="position:absolute; display: none">
        <select id="sel_lid" name="sel_lid" onChange="chg_league();" class="za_select">
        <option value="">Tất cả</option>
		*SHOW_H*
       	</select>
</span>
<span id="bodyP" style="position:absolute; display: none">
  Trang:&nbsp;*SHOW_P*
</span>
</body>
</html>
