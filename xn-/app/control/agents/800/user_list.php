<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language,world from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$sql = "select id,memname from web_member where agents='$agname' and pay_type=1";
$active=$_REQUEST['active'];

$memname=$_REQUEST['mid'];
$id=$_REQUEST['id'];
$gold=$_REQUEST['gold'];
$rtype=$_REQUEST['type'];
$date_start=$_REQUEST['date_start'];
$date_end=$_REQUEST['date_end'];


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
<title>CashAdmin 系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C">
<div id="Layer1" style="position:absolute; left:183px; top:47px; width:65px; height:40px; z-index:1; visibility: hidden" onMouseOver="MM_showHideLayers('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')"> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" >
    <tr> 
      <td  class="mou"><a href="user_list.php?uid=<?=$uid?>" >帐户查询</a></td>
    </tr>
    <tr> 
      <td class="mou"  ><a href="user_edit.php?uid=<?=$uid?>" >存入帐户</a></td>
    </tr>
  </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="183"><img src="/images/800/800_top_01.gif" width="183" height="29"></td>
    <td bgcolor="475854" class=m_title_he><font color="#FFFFFF">CashAdmin 线上客服系统</font></td>
  </tr>
  <tr height="18"> 
    <td><img src="/images/800/800_top_02.gif" width="183" height="19"></td>
    <td bgcolor="#2F4540" class="m_title_he1">&nbsp; &nbsp; <!--<a href="#" target="_top" onMouseOver="MM_showHideLayers('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')">帐户作业</a> 
      <font color="#FFFFFF"> - <a href=#>800作业</a> - </font>-->
	 <a href="user_list.php?uid=<?=$uid?>">帐户查询</a> - 
	 <a href="user_edit.php?uid=<?=$uid?>">存入帐户</a> - 
	 <a href="/index.php?uid=<?=$uid?>" target='_top'>登出</a></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <FORM id="myFORM" ACTION="" METHOD=POST  name="FrmData">
  <tr> 
    <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td width="50" >&nbsp;&nbsp;帐户别:</td>
            <td width="49"> 
		<select name="mid" class="za_select">
<?

$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
	echo "<option value=$row[memname]>$row[memname]</option>";
}
?>              </select>
            </td>
            <td width="68">&nbsp;--&nbsp;日期区间:</td>
            <td>
              <input type=TEXT name="date_start" size=10 maxlength=11 class="za_text" value="<?=$date_start?>">
              &nbsp;</td>
            <td><a href="javascript:void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_start',true,'yyyy-mm-dd'); return false;"><img src="/images/control/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td>~&nbsp;</td>
            <td>
              <input type=TEXT name="date_end" size=10 maxlength=10 class="za_text" value="<?=$date_end?>">
              &nbsp;</td>
            <td><a href="javascript:void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_end',true,'yyyy-mm-dd'); return false;"><img src="/images/control/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td width="45">&nbsp;--&nbsp;方式:</td>
            <td>
              <select name="type" class="za_select">
			  <option value=>  </option>
<option value="S">存入</option>
<option value="T">提出</option>
<option value="O">下注</option>
<option value="W">赢</option>
<option value="L">输</option>
<option value="N">和局</option>
<option value="M">修正</option>

              </select>
            </td>
            <td > &nbsp; 
              <input type=SUBMIT name="SUBMIT" value="查询" class="za_button">
            </td>
            <td width="58">&nbsp;--&nbsp;总页数:</td>
            <td> 
              <select id="page" name="page"  class="za_select" onChange="self.myFORM.submit()">
                <!-- BEGIN DYNAMIC BLOCK: page --> 
                <option value="0" {PAGE_SELECT}>0</option>
                <!-- END DYNAMIC BLOCK: page --> 
              </select>
            </td>
            <td> / 0 页</td>
          </tr>
        </table>
      </td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
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
          <td ><font color="#000099">帐户查询</font></td>
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
          <td width="80">会员帐号</td>
          <td width="80">操作帐号</td>
          <td width="60">币别</td>
          <td width="80">金额</td>
          <td width="80">日期</td>
          <td width="80">审核日期</td>
          <td width="80">审核帐号</td>
          <td width="80">备注</td>
        </tr>
        <!-- BEGIN DYNAMIC BLOCK: row -->
<?
$sqladd = array();
if($memname!=''){
	$sqladd[] = "memname='$memname'";
}
if ($rtype!=''){
	$sqladd[] = "type='$rtype'";
}
$sqladd[] = "agents='$agname'";
if($date_start<>'' and $date_end<>''){
	$sqladd[] = "date>='$date_start' and date<='$date_end'";
}else if($date_start<>'' and $date_end==''){
	$sqladd[] = "date>='$date_start'";
}else if($date_start=='' and $date_end<>''){
	$sqladd[] = "date<='$date_end'";
}


$sqladd = join(' and ', $sqladd);
$mysql="select * from sys800 where $sqladd";
$result=mysql_query($mysql);
$all_count=0;

$cou=mysql_num_rows($result);
if ($cou==0){
?>
<tr class="m_cen"> 
          <td>目前没有记录</td>
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
	$all_count += $row['gold'];
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
<input type=submit name=send value='审核' onClick="return confirm('确定审核此笔单')" class="za_button">
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
echo '<td>存入</td>';
break;
case 'T':
echo '<td>提出</td>';
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
		<!--
          <td colspan="3" >可用馀额</td>
          <td colspan="2" bgcolor="#000066"><font color="#FFFFFF">90.0</font></td>
          <td >总计</td>
          <td colspan="2" bgcolor="#660000"><font color="#FFFFFF">0.0</font></td>
		  -->
		  <td colspan="6" >总计</td>
		  <td colspan="2" bgcolor="#660000"><font color="#FFFFFF"><?=$all_count?></font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="/images/800/800_title_p21b.gif">&nbsp;</td>
    <td width="18"><img src="/images/800/800_title_p22.gif" width="18" height="15"></td>
    <td width="200" class="m_foot">  &nbsp;&nbsp;Welcom to CashAdmin Online System</td>
  </tr>
</table>
</body>
</html>

