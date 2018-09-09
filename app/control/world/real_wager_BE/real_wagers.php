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
case "OU":
	$caption=$rel_straight;
	$width="894";
	$back_ou="#3399ff";
//	$table="<td width=38 >$rel_body_time</td>\n    <td width=28>$rel_body_league</td>\n    <td width=28>$rel_mid</td>\n    <td width=120>$rel_shometeam</td>\n    <td width=165>$rel_let / $rel_betou</td>\n    <td width=165>$rel_dime / $rel_betou</td>\n    <td width=130>$rel_win</td>\n";
	$table='    <td width="38" >�ɶ�</td>
    <td width="58">�p��</td>
    <td width="28">����</td>
    <td width="120">����</td>
    <td width="195">���L / �`��</td>
    <td width="195">�j�p�L / �`��</td>
    <td width="130">�WĹ</td>
    <td width="130">����</td>';
	break;
case "RE":
	$caption=$rel_running;
	$width="636";
	$back_re="#3399ff";
	$table="<td width=38 >$rel_body_time</td>\n    <td width=28>$rel_body_league</td>\n    <td width=28>$rel_mid</td>\n    <td width=120>$rel_shometeam</td>\n    <td width=165>$rel_let / $rel_betou</td>\n    <td width=165>$rel_dime / $rel_betou</td>";
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
	$table="<td width=38>$rel_body_time</td>\n    <td width=28>$rel_body_league</td>\n    <td width=28>$rel_mid</td>\n    <td width=120>$rel_shometeam</td>\n    <td width=120>$rel_parlay</td>";
	break;
case "PL":
	$caption=$rel_haveopen;
	$back_p="#3399ff";
	$width="720";
	//$table="<td  width=38 >$rel_body_time</td>\n    <td  width=28>$rel_body_league</td>\n    <td  width=28>$rel_mid</td>\n    <td  width=120>$rel_shometeam</td>\n    <td  width=165>$rel_let</td>\n    <td nowrap>$rel_hsthalf</td>\n    <td nowrap>$rel_running</td>\n    <td nowrap>$rel_dime</td>\n    <td nowrap>$rel_vou</td>\n    <td nowrap>$rel_running$rep_wtype_ou</td>\n      <td nowrap>$rel_running$rel_odd$rel_even</td>\n     <td nowrap>$rel_win</td>\n    <td nowrap>$rep_wtype_vm</td>\n    <td nowrap>$rel_halffull</td>\n    <td nowrap>$rel_correct</td>\n    <td nowrap>$rel_odd$rel_even</td>\n    <td nowrap>$rel_total</td>\n    <td nowrap>$rel_parlay</td>";
	$table='    <td  width="38" >�ɶ�</td>
    <td width="58">�p��</td>
    <td  width="28">����</td>
    <td  width="120">����</td>
    <td  width="165">���L</td>
    <td nowrap>�u�y</td>
    <td nowrap>�j�p�L</td>
    <td nowrap>�u�y�j�p</td>
    <td nowrap>�WĹ</td>
    <td nowrap>�i�x</td>
    <td nowrap>����</td>
    <td nowrap>�L��</td>';
	break;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
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
 function chg_gdate()
 {
  var obj_gdate = document.getElementById('gdate');
  var obj_set_account = document.getElementById('set_account');
  parent.body_var.location="./real_wagers_var.php?uid="+parent.uid+"&rtype=<?=$rtype?>&gdate="+obj_gdate.value+"&ltype="+parent.ltype+"&set_account="+obj_set_account.value;
  parent.pg=0;
  parent.sel_league="";
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


<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()" onUnload="onUnload()">
<FORM NAME="REFORM" ACTION="" METHOD=POST>
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60" nowrap>&nbsp;&nbsp;�u�W�޽L:</td>
            <td>
              <select id="ltype" name="ltype" onChange="chg_ltype()" class="za_select">
                <option value="1">��A</option>
                <option value="2">��B</option>
                <option value="3">��C</option>
                <option value="4">��D</option>
              </select>
            </td>
            <td width="65" nowrap> -- ���s��z:</td>
            <td>
              <select id="retime" name="retime" onChange="chg_retime()" class="za_select">
                <option value="-1" >����s</option>
                <option value="180" >180 sec</option>
              </select>
            </td>
            <td nowrap> --���:
              <select id="gdate" name="gdate" onChange="chg_gdate()" class="za_select">
<?
for ($i=1;$i<6;$i++){
	echo '<option value="'.date('Y-m-d',time()+$i*24*60*60).'">'.date('Y-m-d',time()+$i*24*60*60).'</option>';

}
?>

              </select>
            </td>
            <td id="dt_now" nowrap> -- ���F�ɶ�:</td>
            <td nowrap> -- <A HREF="#" onClick="chg_page('ou');" onMouseOver="window.status='�榡'; return true;" onMouseOut="window.status='';return true;" style="background-color: #3399FF">�榡</a>
              &nbsp;<A HREF="#" onClick="chg_page('hou');" onMouseOver="window.status='�W�b��'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�W�b��</a>
              &nbsp;<A HREF="#" onClick="chg_page('pd');" onMouseOver="window.status='�i�x'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�i�x</a>
              <!--&nbsp;<A HREF="#" onClick="chg_page('hpd');" onMouseOver="window.status='�W�b�i�x'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�W�b�i�x</a>
              &nbsp;<A HREF="#" onClick="chg_page('f');" onMouseOver="window.status='�b����'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�b����</a-->
              &nbsp;<A HREF="#" onClick="chg_page('eo');" onMouseOver="window.status='�`�o��'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�`�o��</a>
              &nbsp;<A HREF="#" onClick="chg_page('par');" onMouseOver="window.status='�L��'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�L��</a>
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
		<td width='70'><font color="#000099">&nbsp;&nbsp;�榡</font></td>
		<td>�[�ݤ覡&nbsp;<select id="set_account" name="set_account" onChange="chg_account(this.value);" class="za_select">
        		<option value="0">����</option>
			<option value="1">�ۤv</option>
			<!--<option value="2">���q</option>-->
		</select></td>
		<td>&nbsp;����p�� <span id="show_h"></span></td>
		<td width='450'>&nbsp;&nbsp;<span id="pg_txt"></span></td>
	</tr>
  </table>
  <div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: visible">
    <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>
  <table id="glist_table" border="0" cellspacing="1" cellpadding="0"  class="m_tab_be" width="838">
    <tr class="m_title_be">
    <?=$table?>
    </tr>
</table>
</form>

</form>

<span id="bowling" style="position:absolute; display: none">
	<option value="*LEAGUE_ID*" *SELECT*>*LEAGUE_NAME*</option>
</span>
<span id="bodyH" style="position:absolute; display: none">
        <select id="sel_lid" name="sel_lid" onChange="chg_league();" class="za_select">
        <option value="">����</option>
		*SHOW_H*
       	</select>
</span>
<span id="bodyP" style="position:absolute; display: none">
  ����:&nbsp;*SHOW_P*
</span>

</body>
</html>
