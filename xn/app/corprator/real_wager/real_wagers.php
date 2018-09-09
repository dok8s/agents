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
$langx='zh-vn';
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
        $table='    <td width="38">Thời gian</td>
    <td width="52" nowrap>Thời gian...</td>
    <td width="28">Phiên</td>
    <td width="200">Đội</td>
    <td width="195">Điểm chấp/ghi chú</td>
    <td width="195">Kích thước/lưu ý</td>
    <td width="130">Giành chiến</td>';
        break;
    case "V":
        $caption=$rel_hsthalf;
        $rtype='HOU';
        $width="838";
        $back_hou="#3399ff";
        $table = '<td width = "38"> Thời gian </td>
     <td width = "52" nowrap> Liên minh </td>
     <td width = "28"> Sự kiện </td>
     <td width = "200"> Nhóm </td>
     <td width = "195"> Đưa bóng / ghi chú </td>
     <td width = "195"> Kích thước / ghi chú </td>
     <td width = "130"> giành chiến  </td> ';
        break;
    case "RE":
        $caption=$rel_running;
        $width="1098";
        $back_re="#3399ff";
        $table = '<td width = "38">Thời gian</td>
     <td width = "52" nowrap>Liên minh</td>
     <td width = "28"> Sự kiện</td>
     <td width = "200"> Nhóm</td>
     <td width = "195"> Toàn bộ đường bóng/ghi chú</td>
     <td width = "195"> Kích thước hoàn/Lưu ý</td>
     <td width = "195" class = "1st"> Nửa đầu tay/ghi chú</td>
     <td width = "195" class = "1st"> Kích thước/ghi chú phía</td> ';
        break;
    case "PD":
        $caption=$rel_correct;
        $back_pd="#3399ff";
        $width="410";
        $table='      <td width="38">Thời gian</td>
      <td width="52" nowrap>Liên minh</td>
      <td width="200">Tổ chức và</td>
      <td width="120">Làn sóng</td>';
        break;
    case "HPD":
        $caption=$rel_correct;
        $back_hpd="#3399ff";
        $width="410";
        $table='      <td width="38">Thời gian</td>
      <td width="52" nowrap>Liên minh</td>
      <td width="200">Tổ chức</td>
      <td width="120">Làn sóng</td>';
        break;
    case "EO":
        $caption=$rel_total;
        $back_eo="#3399ff";
        $width="718";
        $table='    <td width="38">Thời gian</td>
    <td width="200">Tổ chức và</td>
    <td width="80">Độc thân</td>
    <td width="80">Đôi</td>
    <td width="80">0~1</td>
    <td width="80">2~3</td>
    <td width="80">4~6</td>
    <td width="80">7up</td>';
        break;
    case "F":
        $caption=$rel_halffull;
        $width="410";
        $back_f="#3399ff";
        $table='      <td width="38">Thời gian</td>
      <td width="52" nowrap>Liên minh</td>
      <td width="200">Tổ chức và</td>
      <td width="120">Trường toàn</td>';
        break;
    case "P":
        $caption=$rel_parlay;
        $width="438";
        $back_par="#3399ff";
        $table='    <td width="38">Thời gian</td>
    <td width="52" nowrap>Liên minh</td>
    <td width="28">Phiên</td>
    <td width="200">Đội</td>
    <td width="120">Vượt qua</td>';
        break;
    case "PL":
        $caption=$rel_haveopen;
        $back_p="#3399ff";
        $width="880";
        //$table="<td  width=38 >$rel_body_time</td>\n    <td  width=28>$rel_body_league</td>\n    <td  width=28>$rel_mid</td>\n    <td  width=120>$rel_shometeam</td>\n    <td  width=165>$rel_let</td>\n    <td nowrap>$rel_hsthalf</td>\n    <td nowrap>$rel_running</td>\n    <td nowrap>$rel_dime</td>\n    <td nowrap>$rel_vou</td>\n    <td nowrap>$rel_running$rep_wtype_ou</td>\n      <td nowrap>$rel_running$rel_odd$rel_even</td>\n     <td nowrap>$rel_win</td>\n    <td nowrap>$rep_wtype_vm</td>\n    <td nowrap>$rel_halffull</td>\n    <td nowrap>$rel_correct</td>\n    <td nowrap>$rel_odd$rel_even</td>\n    <td nowrap>$rel_total</td>\n    <td nowrap>$rel_parlay</td>";
        $table='			<td nowrap width="38">Thời gian</td>
			<td nowrap width="52">Liên minh</td>
	<td nowrap width = "28">lần</td>
<td nowrap width = "200"> Nhóm</td>
<td nowrap width = "150"> Hãy để</td>
<td nowrap width = "150"> Đĩa kích thước</td>
<td nowrap width = "100"> Lăn bóng</td>
<td nowrap width = "100"> Kích thước</td>
<td nowrap width = "36"> Tính năng</td>';
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

function show_detail(gid){
	document.all.line_window.style.position='absolute';
	document.all.line_window.style.top=document.body.scrollTop+event.clientY+40;
	document.all.line_window.style.left=document.body.scrollLeft+event.clientX-400;
	line_form.gid.value=gid;
	line_form.sid.value=parent.sid;
	line_form.set_acc.value=document.all.set_account.value;
	document.all.line_window.style.visibility='visible';
	line_form.submit();
}

function show_one(){
	show_table = document.getElementById("gdiv_table");
	parent.ShowData_PL_DETAIL(show_table,top.divFT);
}
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()" onUnload="onUnload()">
<FORM NAME="REFORM" ACTION="" METHOD=POST>
<table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
                        <td width="60" >&nbsp;&nbsp;Giao dịch:</td>
                        <td>
                            <select id="ltype" name="ltype" onChange="chg_ltype()" class="za_select">
                                <option value="1">Chân A</option>
                                <option value="2">Chân B</option>
                                <option value="3">Chân C</option>
                                <option value="4">Chân D</option>
                            </select>
                        </td>
                        <td width="65"> -- Sắp xếp lại</td>
                        <td>
                            <select id="retime" name="retime" onChange="chg_retime()" class="za_select">
                                <option value="-1" >Chưa cập</option>
                                <option value="180" >180 sec</option>
                            </select>
                        </td>
                        <td id="dt_now"> -- Giờ miền:</td>
                        <td> -- <A HREF="#" onClick="chg_page('ou');" onMouseOver="window.status='<?=$rel_straight?>'; return true;" onMouseOut="window.status='';return true;" style="background-color: <?=$back_ou?>"><?=$rel_straight?></a>
                            &nbsp;<A HREF="#" onClick="chg_page('v');" onMouseOver="window.status='<?=$rel_hsthalf?>'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_hou?>"><?=$rel_hsthalf?></a>
                            &nbsp;<A HREF="#" onClick="chg_page('re');" onMouseOver="window.status='<?=$rel_running?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_re?>"><?=$rel_running?></a>
                            &nbsp;<A HREF="#" onClick="chg_page('pd');" onMouseOver="window.status='<?=$rel_correct?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_pd?>"><?=$rel_correct?></a>
                            &nbsp;<A HREF="#" onClick="chg_page('hpd');" onMouseOver="window.status='<?=$rel_correct?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_hpd?>">Nửa trên</a>
                            &nbsp;<A HREF="#" onClick="chg_page('eo');" onMouseOver="window.status='Số bàn'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_eo?>">Số bàn</a>
                            &nbsp;<a href="#" onClick="chg_page('f');" onMouseOver="window.status='<?=$rel_halffull?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_f?>"><?=$rel_halffull?></a>
                            &nbsp;<A HREF="#" onClick="chg_page('p');" onMouseOver="window.status='<?=$rel_parlay?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_par?>"><?=$rel_parlay?></a>
                            <A HREF="#" onClick="chg_page('pl');" onMouseOver="window.status='<?=$rel_haveopen?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_p?>"><?=$rel_haveopen?></a>
                        </td>
                    </tr>
                </table>
            </td>
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
            if ($rtype=='OU' or $rtype=='HOU' or $rtype=='HPD'  or $rtype=='PD' or $rtype=='F' or $rtype=='P'){
                ?>
                <td>&nbsp;Chọn liên <span id="show_h"></span></td>
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
<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab" width="<?=$width?>">
    <tr class="m_title_ft">
    <?=$table?>
    </tr>
</table>
</form>
<?
if($rtype<>'PL'){?>
<span id="bowling" style="position:absolute; display: none">
	<option value="*LEAGUE_ID*" *SELECT*>*LEAGUE_NAME*</option>
</span>


<span id="bodyH" style="position:absolute; display: none">
        <select id="sel_lid" name="sel_lid" onChange="chg_league();" class="za_select">
        <option value="">全部</option>
		*SHOW_H*
       	</select>
</span>
<?
}else{
    ?>
    <form name="line_form" id=line_form action="real_wagers_var_pl_detail.php" method="post" target=showdata>
        <div class="t_div" id="line_window" style="visibility:hidden;position: absolute;">
            <input type=hidden name='uid' value='<?=$uid?>'>
            <input type=hidden name='gid' value=''>
            <input type=hidden name='sid' value=''>
            <input type=hidden name='set_acc' value=''>
            <table id="gdiv_table" border="0" cellspacing="1" cellpadding="0" bgcolor="#006255" class="m_tab" width="544">
                <tr class="m_title_ft">
                    <td nowrap>chiến thắng</td>
                    <td nowrap>Làn sóng</td>
                    <td nowrap>Một nửa</td>
                    <td nowrap>Đơn và</td>
                    <td nowrap>Tổng số</td>
                    <td nowrap>Trường toàn</td>
                    <td nowrap>giải phóng</td>
                    <td nowrap>Nửa bóng</td>
                    <td nowrap>kích thước</td>
                    <td nowrap>Bóng một</td>
                    <td nowrap>Nửa kích</td>
                    <td nowrap>Chiến thắng</td>
                </tr>
            </table>
            <input type='button' class="za_button" onClick="document.all.line_window.style.visibility='hidden';" value='Đóng'>
        </div>
    </form>
    <?
}
?>
<span id="bodyP" style="position:absolute; display: none">
  Trang:&nbsp;*SHOW_P*
</span>
<iframe id=showdata name=showdata src='../../../../ok.html' scrolling='no' width="0" height='0'></iframe>

</body>
</html>
