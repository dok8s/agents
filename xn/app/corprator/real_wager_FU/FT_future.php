<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$retime=$_REQUEST['retime'];
$gdate=$_REQUEST['gdate'];

$rtype=strtoupper(trim($_REQUEST['rtype']));
$sql = "select Agname,ID,language from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];
$langx=$row['language'];
require ("../../member/include/traditional.$langx.inc.php");

if ($rtype==''){
	$rtype='OU';
}
if ($retime==''){
	$retime=-1;
}

switch ($rtype){
case "OU":
	$caption=$rel_straight;
	$width="838";
	$back_ou="#3399ff";
	$table='    <td width = "38"> Thời gian </ td>
     <td width = "52" nowrap> Liên minh </ td>
     <td width = "28"> Sự kiện </ td>
     <td width = "200"> Nhóm </ td>
     <td width = "195"> Nhận thẻ bóng / ghi chú </ td>
     <td width = "195"> Kích thước / ghi chú </ td>
     <td width = "130"> Chỉ giành chiến thắng </ td>';
	break;
case "V":
	$caption=$rel_hsthalf;
	$rtype='HOU';
	$width="838";
	$back_hou="#3399ff";
	$table='    <td width = "38"> Thời gian </ td>
     <td width = "52" nowrap> Liên minh </ td>
     <td width = "28"> Sự kiện </ td>
     <td width = "200"> Nhóm </ td>
     <td width = "195"> Nhận thẻ bóng / ghi chú </ td>
     <td width = "195"> Kích thước / ghi chú </ td>
     <td width = "130"> Chỉ giành chiến thắng </ td>';
	break;
case "PD":
	$caption=$rel_correct;
	$back_pd="#3399ff";
	$width="835";
	$table='   <td width = "38"> Thời gian </ td>
     <td width = "28"> Liên minh </ td>
     <td width = "151"> Nhóm máy chủ </ td>
     <td width = "80"> Lưu ý / Số tiền </ td>
    <td>1:0</td>
    <td>2:0</td>
    <td>2:1</td>
    <td>3:0</td>
    <td>3:1</td>
    <td>3:2</td>
    <td>4:0</td>
    <td>4:1</td>
    <td>4:2</td>
    <td>4:3</td>
    <td>0:0</td>
    <td>1:1</td>
    <td>2:2</td>
    <td>3:3</td>
    <td>4:4</td>
    <td width="25">up5</td>';
	break;
case "HPD":
	$caption='Nửa đầu của sóng';
	$back_hpd="#3399ff";
	$width="835";
	$table='   <td width = "38"> Thời gian </ td>
     <td width = "28"> Liên minh </ td>
     <td width = "151"> Nhóm máy chủ </ td>
     <td width = "80"> Lưu ý / Số tiền </ td>
    <td>1:0</td>
    <td>2:0</td>
    <td>2:1</td>
    <td>3:0</td>
    <td>3:1</td>
    <td>3:2</td>
    <td>4:0</td>
    <td>4:1</td>
    <td>4:2</td>
    <td>4:3</td>
    <td>0:0</td>
    <td>1:1</td>
    <td>2:2</td>
    <td>3:3</td>
    <td>4:4</td>
    <td width="25">up5</td>';
	break;
case "EO":
	$caption=$rel_total;
	$back_eo="#3399ff";
	$width="718";
	$table='<td width = "38"> Thời gian </ td>
     <td width = "200"> Máy chủ và nhóm </ td>
    <td width="80">单</td>
    <td width="80">双</td>
    <td width="80">0~1</td>
    <td width="80">2~3</td>
    <td width="80">4~6</td>
    <td width="80">7up</td>';
	break;
case "F":
	$caption=$rel_halffull;
	$width="835";
	$back_f="#3399ff";
	$table='<td width = "38"> Thời gian </ td>
     <td width = "52" nowrap> Liên minh </ td>
     <td width = "200"> Máy chủ và nhóm </ td>
     <td width = "80"> Lưu ý / Số tiền </ td>
     <td> Thạc sĩ / Thạc sĩ </ td>
     <td> Chủ / và </ td>
     <td> Chủ / Khách </ td>
     <td> và / chính </ td>
     <td> và / và </ td>
     <td> và / hoặc </ td>
     <td> Khách / Chủ </ td>
     <td> Khách / và </ td>
     <td> Khách hàng / Khách </ td>';
	break;
case "P":
	$caption=$rel_parlay;
	$width="438";
	$back_par="#3399ff";
	$table='      <td width = "38"> Thời gian </ td>
     <td width = "52" nowrap> Liên minh </ td>
     <td width = "28"> Sự kiện </ td>
     <td width = "200"> Nhóm </ td>
     <td width = "120"> Giao nhau </ td>';
	break;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT LANGUAGE="JAVASCRIPT1.2">
document.onkeypress=checkfunc;
function checkfunc(e) {
	switch(event.keyCode){

	}
}

 var ReloadTimeID;
 function onLoad()
 {
  parent.loading = 'N';
  parent.ShowType = '<?=$rtype?>';
  var obj_ltype = document.getElementById('ltype');
  obj_ltype.value = parent.ltype;
  var obj_gdate = document.getElementById('gdate');
  obj_gdate.value = parent.gdate;
  var obj_retime = document.getElementById('retime');
  obj_retime.value = <?=$retime?>;
  parent.body_var.location = "./FT_future_var.php?uid="+parent.uid+"&rtype=<?=$rtype?>&page_no=<?=$page?>&gdate="+obj_gdate.value;
  parent.pg=0;
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
  parent.body_var.location="./FT_future_var.php?uid="+parent.uid+"&rtype=<?=$rtype?>&gdate="+obj_gdate.value+"&ltype="+obj_ltype.value+"&page_no="+parent.pg+"&league_id="+parent.sel_league+"&set_account="+obj_set_account.value;
 }

  function chg_gdate()
 {
  var obj_gdate = document.getElementById('gdate');
  var obj_set_account = document.getElementById('set_account');
  parent.body_var.location="./FT_future_var.php?uid="+parent.uid+"&rtype=<?=$rtype?>&gdate="+obj_gdate.value+"&ltype="+parent.ltype+"&set_account="+obj_set_account.value;
  parent.pg=0;
  parent.sel_league="";
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
  var obj_gdate = document.getElementById('gdate');
  var url_str = 'FT_future.php?uid='+parent.uid+'&rtype='+page_type+'&retime='+obj_retime.value+'&gdate='+obj_gdate.value;
  self.location = url_str;
 }

 function onUnload()
 {
  if(ReloadTimeID) clearInterval(ReloadTimeID);
  parent.loading = 'Y';
  parent.ShowType = '';
  parent.pg=0;
  parent.sel_league="";
 }

function chg_pg(pg)
{
	var obj_set_account = document.getElementById('set_account');
	if (pg==parent.pg)return;
	parent.pg=pg;
	parent.loading_var = 'Y';
	parent.body_var.location = "./FT_future_var.php?uid="+parent.uid+"&rtype="+parent.stype_var+"&langx="+parent.langx+"&ltype="+parent.ltype+"&page_no="+parent.pg+"&set_account="+obj_set_account.value+"&gdate="+parent.gdate;
}
function chg_league(){
	var obj_set_account = document.getElementById('set_account');
	obj_pg = document.getElementById('pg_txt');
	var obj_league = document.getElementById('sel_lid');
	parent.sel_league=obj_league.value;
	parent.ShowGameList();
	parent.body_var.location = "./FT_future_var.php?uid="+parent.uid+"&rtype="+parent.stype_var+"&langx="+parent.langx+"&ltype="+parent.ltype+"&league_id="+obj_league.value+"&set_account="+obj_set_account.value+"&gdate="+parent.gdate;
	parent.pg=0;
}

 function chg_account(set_account){
	var obj_league = document.getElementById('sel_lid');
 	parent.body_var.location="./FT_future_var.php?uid="+parent.uid+"&rtype="+parent.stype_var+"&set_account="+set_account+"&league_id="+obj_league.value+"&page_no="+parent.pg+"&gdate="+parent.gdate;
 }
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()" onUnload="onUnload()">
<FORM NAME="REFORM" ACTION="" METHOD=POST>
  <table width="780" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60" nowrap>&nbsp;&nbsp;Giao dịch trực tuyến:</td>
            <td>
              <select id="ltype" name="ltype" onChange="chg_ltype()" class="za_select">
                <option value="1">Chân A</option>
                <option value="2">Chân B</option>
                <option value="3">Chân C</option>
                <option value="4">Chân D</option>
              </select>
            </td>
            <td width="65" nowrap> -- Làm mới:</td>
            <td>
              <select id="retime" name="retime" onChange="chg_retime()" class="za_select">
                <option value="-1" >Chưa cập nhật</option>

                <option value="180" >180 sec</option>
              </select>
            </td>
            <td nowrap> --Ngày:
              <select id="gdate" name="gdate" onChange="chg_gdate()" class="za_select">
<?
for ($i=1;$i<12;$i++){
	echo '<option value="'.date('Y-m-d',time()+$i*24*60*60).'">'.date('Y-m-d',time()+$i*24*60*60).'</option>';

}
?>

              </select>
            </td>
            <td id="dt_now" nowrap> -- Giờ miền đông:</td>
            <td nowrap> -- <A HREF="#" onClick="chg_page('ou');" onMouseOver="window.status='<?=$rel_straight?>'; return true;" onMouseOut="window.status='';return true;" style="background-color: <?=$back_ou?>"><?=$rel_straight?></a>
              &nbsp;<A HREF="#" onClick="chg_page('v');" onMouseOver="window.status='<?=$rel_hsthalf?>'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_hou?>"><?=$rel_hsthalf?></a>
              &nbsp;<A HREF="#" onClick="chg_page('pd');" onMouseOver="window.status='<?=$rel_correct?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_pd?>"><?=$rel_correct?></a>
              &nbsp;<A HREF="#" onClick="chg_page('hpd');" onMouseOver="window.status='上半波胆'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_hpd?>">Nửa đầu của sóng</a>
              &nbsp;<a href="#" onClick="chg_page('f');" onMouseOver="window.status='<?=$rel_halffull?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_f?>"><?=$rel_halffull?></a>
              &nbsp;<A HREF="#" onClick="chg_page('eo');" onMouseOver="window.status='总入球'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_eo?>">Tổng số bàn thắng</a>
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
		<td>Theo dõi cách&nbsp;<select id="set_account" name="set_account" onChange="chg_account(this.value);" class="za_select">
        		<option value="0">Tất cả</option>
			<option value="1">Bản thân bạn</option>
			<!--<option value="2">公司</option>-->
		</select></td>
		<td>&nbsp;Chọn liên minh <span id="show_h"></span></td>
		<td width='450'>&nbsp;&nbsp;<span id="pg_txt"></span></td>
	</tr>
  </table>
  <div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: visible">
    <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>
  <table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="C2C2A6" class="m_tab" width="<?=$width?>">
    <tr class="m_title_ft_future">
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
  Số lần trang:&nbsp;*SHOW_P*
</span>

</body>
</html>