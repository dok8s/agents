<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language,world from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$sql = "select id,memname,curtype from web_member where world='$agname' and pay_type=1";
$active=$_REQUEST['active'];

$memname=$_REQUEST['mid'];
$id=$_REQUEST['id'];
$gold=$_REQUEST['gold'];
$rtype=$_REQUEST['type'];
$date_start=$_REQUEST['date_start'];
$date_end=$_REQUEST['date_end'];
if ($date_start==''){
	$date_start=date('Y-m-d');
}
if ($date_end==''){
	$date_end=date('Y-m-d');
}

if ($active=='Y'){
	switch($rtype){
	case 'S':
		$mysql="update web_member set Money=Money+$gold,credit=credit+$gold where memname='".$memname."'";
		break;
	case 'T':
		$mysql="update web_member set Money=Money-$gold,credit=credit-$gold where memname='".$memname."'";
		break;
	}
	
	mysql_query($mysql);
	$mysql="update sys800 set checked=1 where id=".$id;
	mysql_query($mysql);
}
?>
<html>
<head>
<title>800�t��</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<script language="JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
// -->

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
<script language="JavaScript" src="/js/simplecalendar.js"></script>

<link rel="stylesheet" href="/style/800/control_800main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css">
<style type="text/css">
<!--
.m_rig2 { background-color: #CCCCCC; text-align: right}
-->
</style>
</head>
<!--<base target="net_ctl_main">-->
<base target="_top">
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C">
<div id="Layer1" style="position:absolute; left:183px; top:47px; width:65px; height:40px; z-index:1; visibility: hidden" onMouseOver="MM_showHideLayers('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')"> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" >
    <tr> 
      <td  class="mou"><a href="user_list.php?uid=<?=$uid?>" target="_top">�b��d��</a></td>
    </tr>
    <tr> 
      <td class="mou"  ><a href="user_edit.php?uid=<?=$uid?>" target="_top">�s�J�b��</a></td>
    </tr>
  </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="183"><img src="/images/800/800_top_01.gif" width="183" height="29"></td>
    <td bgcolor="475854" class=m_title_he><font color="#FFFFFF">800�u�W�ȪA�t��</font></td>
  </tr>
  <tr height="18"> 
    <td><img src="/images/800/800_top_02.gif" width="183" height="19"></td>
    <td bgcolor="#2F4540" class="m_title_he"> <a href="#" target="_top" onMouseOver="MM_showHideLayers('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')">�b��@�~</a> 
      <font color="#FFFFFF"> - 800�@�~ - </font><a href="/login.php?uid=<?=$uid?>" target='_top'>�n�X</a></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <FORM id="myFORM" ACTION="" METHOD=POST  name="FrmData">
  <tr> 
    <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td width="50" >&nbsp;&nbsp;�b��O:</td>
            <td width="49"> 
		<select name="mid" class="za_select">
<?

$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
	echo "<option value=$row[memname]>$row[memname]</option>";
}
?>              </select>
            </td>
            <td width="68">&nbsp;--&nbsp;����϶�:</td>
            <td>
              <input type=TEXT name="date_start" size=10 maxlength=11 class="za_text" value="<?=$date_start?>">
              &nbsp;</td>
            <td><a href="javascript:void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_start',true,'yyyy-mm-dd'); return false;"><img src="/images/control/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td>~&nbsp;</td>
            <td>
              <input type=TEXT name="date_end" size=10 maxlength=10 class="za_text" value="<?=$date_end?>">
              &nbsp;</td>
            <td><a href="javascript:void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_end',true,'yyyy-mm-dd'); return false;"><img src="/images/control/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td width="45">&nbsp;--&nbsp;�覡:</td>
            <td>
              <select name="type" class="za_select">
			  <option value=>  </option>
<option value="S">�s�J</option>
<option value="T">���X</option>
<option value="O">�U�`</option>
<option value="W">Ĺ</option>
<option value="L">��</option>
<option value="N">�M��</option>
<option value="M">�ץ�</option>

              </select>
            </td>
            <td > &nbsp; 
              <input type=SUBMIT name="SUBMIT" value="�d��" class="za_button">
            </td>
            <td width="58">&nbsp;--&nbsp;�`����:</td>
            <td> 
              <select id="page" name="page"  class="za_select" onChange="self.myFORM.submit()">
                <!-- BEGIN DYNAMIC BLOCK: page --> 
                <option value="0" {PAGE_SELECT}>0</option>
                <!-- END DYNAMIC BLOCK: page --> 
              </select>
            </td>
            <td> / 0 ��</td>
          </tr>
        </table>
      </td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</FORM>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_top">
      <table border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td >&nbsp;<img src="/images/control/zh-tw/main_dot.gif" width="13" height="15">&nbsp; 
          </td>
          <td ><font color="#000099">�b��d��</font></td>
        </tr>
      </table>
    </td>
    <td width="221"><img src="/images/800/800_title_p1.gif" width="221" height="31"></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0" class="m_tab">
  <tr>
    <td>
      <table width="620" border="1" cellspacing="2" cellpadding="0" class="m_tab_main" bordercolor="#CCCCCC">
        <tr class="m_title"> 
          <td width="80">�|���b��</td>
          <td width="80">�s�J�b��</td>
          <td width="60">�s�J���O</td>
          <td width="80">�s�J���B</td>
          <td width="80">�s�J���</td>
          <td width="80">�f�ֱb��</td>
          <td width="80">�f�֤��</td>
          <td width="80">�Ƶ�</td>
        </tr>
        <!-- BEGIN DYNAMIC BLOCK: row -->
<?

if ($rtype==''){
	$mysql="select * from sys800 where agents='$agname' and memname='$memname' and indate>='$date_start' and indate<='$date_end'";
}else{
	$mysql="select * from sys800 where agents='$agname' and type='$rtype' and memname='$memname' and indate>='$date_start' and indate<='$date_end'";
}

$result=mysql_query($mysql);
$cou=mysql_num_rows($result);
if ($cou==0){
?>
<tr class="m_cen"> 
          <td>�ثe�S���O��</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
<?
}else{
while ($row = mysql_fetch_array($result))
{
?><form  method=post target='_self'>
        <tr class="m_cen"> 
          <td><?=$row['memname']?></td>
          <td><?=$row['agents']?>&nbsp;</td>
          <td><?=$row['curtype']?>&nbsp;</td>
          <td align="right"><?=$row['gold']?>&nbsp;</td>
          <td><?=$row['indate']?>&nbsp;</td>
          <?
if ($row['checked']==0){
?>
<td>&nbsp;</td>
      <td>&nbsp;</td>
         <td>
<input type=submit name=send value='�f��' onclick="return confirm('�T�w�f�֦�����')" class="za_button">
<input type=hidden name=id value=<?=$row['id']?>>
<input type=hidden name=mid value=<?=$row[memname]?>>
<input type=hidden name=gold value=<?=$row['gold']?>>
<input type=hidden name=type value=<?=$row['type']?>>
<input type=hidden name=uid value=<?=$uid?>>
<input type=hidden name=active value=Y></td>
<?
}else{
?>
<td><?=$row['indate']?></td>
      <td><?=$row['agents']?></td>

<?
switch($row['type']){
case 'S':
echo '<td>�s�J</td>';
break;
case 'T':
echo '<td>���X</td>';
break;
}
?>

        </tr></form>
 <?
}
} 
}      
?>
 
        <!-- END DYNAMIC BLOCK: row -->
        <tr class="m_rig2"> 
          <td colspan="3" >�i�ξl�B</td>
          <td colspan="2" bgcolor="#000066"><font color="#FFFFFF">90.0</font></td>
          <td >�`�p</td>
          <td colspan="2" bgcolor="#660000"><font color="#FFFFFF">0.0</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="/images/800/800_title_p21b.gif">&nbsp;</td>
    <td width="18"><img src="/images/800/800_title_p22.gif" width="18" height="15"></td>
    <td width="200" class="m_foot">Copyrignt by SYTNET Online Corporation</td>
  </tr>
</table>
</body>
</html>
<?
mysql_close();
?>
