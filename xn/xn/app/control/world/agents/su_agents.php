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
$sql = "select super,Agname,ID,language from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$super=$row['super'];
$langx=$row['language'];
require ("../../../member/include/traditional.zh-cn.inc.php");

$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$active=$_REQUEST["active"];
$orderby=$_REQUEST["orderby"];

$mid=$_REQUEST["mid"];

if ($enable==""){
	$enable='Y';
}

$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}

if ($sort=='' and $orderby==''){
	$order='';
}else if ($sort<>"" and $orderby==''){
	$order=' order by '.$sort." desc";
	$orderby='desc';
}else if ($sort=='' and $orderby<>''){
	$order=' order by alias '.$orderby;
	$sort='Alias';
}else{
	$order=' order by '.$sort.' '.$orderby;
}


switch($enable){
case "Y":
	$enabled=1;
	$memstop='N';
	$stop=1;
	$start_font="";
	$end_font="";
	$caption1=$mem_disable;
	$caption2=$mem_enable;
	$xm="启用";
	break;
case "N":
	$enable='N';
	$memstop='Y';
	$enabled=0;
	$stop=0;
	//$start_font="<font color=#999999>";
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(255,0,0);'>$mem_disable</SPAN>";
	$caption1=$mem_enable;
	$xm="停用";
	break;
default:
	$enable='S';
	$memstop='Y';
	$enabled=2;
	$stop=2;
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(0,255,0);'>暂停</SPAN>";
	$caption1=$mem_enable;
	$xm="暂停";
	break;
}

if ($active==2){

	$sql = "select Agname from web_agents where ID=$mid";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$memname=$row["Agname"];
	$mysql="update web_agents set oid='',Status=$stop where ID=$mid";
	mysql_query( $mysql);

	$mysql="select agname,world from web_agents where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agname1=$row['agname'];

	$mysql="update web_corprator set oid='',Status=$stop where subuser=1 and subname='$agname1'";
	mysql_query($mysql);

	$mysql="update web_member set oid='',Status=$stop where Agents='$agname1'";
	mysql_query( $mysql);
	
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$memname','代理',4)";
	mysql_query($mysql) or die ("操作失败!");
}

$sql = "select ID,Agname,passwd_safe,Alias,Credit,date_format(AddDate,'%m-%d / %H:%i') as AddDate,mcount from web_agents where Status=$enabled and world='$agname' and super='$super' and subuser=0".$order;

$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=30;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title {  background-color: #86C0A6; text-align: center}
-->
</style>
<SCRIPT language=javaScript src="/js/agents.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript>
<!--
 function onLoad()
 {
  var obj_sagent_id = document.getElementById('super_agents_id');
  obj_sagent_id.value = '';
  var obj_enable = document.getElementById('enable');
  obj_enable.value = '<?=$enable?>';
  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }
// -->
</SCRIPT>
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<form name="myFORM" action="/xn/app/control/world/agents/su_agents.php?uid=<?=$uid?>" method=POST>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="70">&nbsp;&nbsp;<?=$wld_selagent?></td>
            <td>
		 <select  name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y">启用</option>
                <option value="N">停用</option>
                <option value="S">暂停</option>
              </select>
            </td>
            <td> -- <?=$mem_orderby?></td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="Alias"><?=$mem_name?></option>
                <option value="Agname"><?=$mem_uid?></option>
                <option value="Adddate"><?=$mem_adddate?></option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?></td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>
              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?> -- </td>
            <td>
              <input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='./su_ag_add.php?uid=<?=$uid?>'" class="za_button">
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
<?

if ($cou==0){
?>
<table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">    <tr class="m_title">
      <td height="30" >目前无任何代理商</td>
    </tr>
  </table>
<?
}else{
 ?>
<table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
   <tr class="m_title">
      <td width="80"><?=$rcl_agent?><?=$sub_name?></td>
      <td width="80"><?=$rcl_agent?><?=$sub_user?></td>
      <td width="80">登录帐号</td>
	  <td width="110"><?=$rep_pay_type_c?></td>
      <td width="50"><?=$wld_memcount?></td>
      <td width="80"><?=$mem_adddate?></td>
      <td width="64">帐号状况</td>
      <td width="220"><?=$mem_option?></td>
    </tr>
	<?
	while ($row = mysql_fetch_array($result)){
		$sql = "select count(*) as cou from web_member where agents='".$row['Agname']."' order by id";
		$cresult = mysql_query( $sql);
		$crow = mysql_fetch_array($cresult)
		
	?>
    <tr  class="m_cen">
      <td><?=$row['Alias']?></td>
      <td><?=$row['Agname']?></td>
      <td><?=$row['passwd_safe']?></td>
     <td align="right"><?=$row['Credit']?></td>
      <td><?=$crow['cou']?></td>
      <td><?=$row['AddDate']?></td>
      <td><?=$caption2?></td>
      <td align="left">

<?
if($enable=='Y'){
?>
<a href="javascript:CheckSTOP('/xn/app/control/world/agents/su_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=S','S')">暂停</a> /
<?
}
?>
        <a href="javascript:CheckSTOP('/app/control/world/agents/su_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a>
        / <a href="/xn/app/control/world/agents/su_ag_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&agents_id=<?=$agid?>"><?=$mem_acount?></a>
        / <a href="/xn/app/control/world/agents/su_ag_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&agents_id=<?=$agid?>"><?=$mem_setopt?></a></td>
    </tr>
<?
}
}
?>
</table>
  </table>
</form>
<!----------------------结帐视窗---------------------------->
<div id=acc_window style="display: none;position:absolute">
<form name=agAcc action="../acc_proc.php?uid=<?=$uid?>&url=agents/su_agents.php?uid=<?=$uid?>" method=post onSubmit="return Chk_acc();" target="win_agAcc">
<input type=hidden name=aid value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="0163A2">
  <tr>
    <td bgcolor="#FFFFFF">
    <table width="220" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix">
      <tr bgcolor="0163A2">
        <td id=acc_title><font color="#FFFFFF">请输入结帐日期</font></td>
    <td align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
      </tr>
       <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
      <tr>
        <td colspan="2">日　期:
          <input type=text name=acc_date value="2005-06-06" class="za_text" size="12" maxlength="10" >
          &nbsp;&nbsp;
          <input type=submit name=acc_ok value="确定" class="za_button">
          &nbsp; </td>
      </tr>
    </table>
   </td>
  </tr>
</table>
</form>
</div>
<!----------------------结帐视窗---------------------------->
<!----------------------回复视窗---------------------------->
<div id=re_window style="display: none;position:absolute">
<form name=agre action="../recover_credit.php?uid=<?=$uid?>" method=post onSubmit="return Chk_acc();" target="win_agAcc">
<input type=hidden name=aid value="">
<input type=hidden name=cdate value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="0163A2">
  <tr>
    <td bgcolor="#FFFFFF">
      <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix" >
        <tr bgcolor="0163A2">
          <td width="200" id=re_title><font color="#FFFFFF">&nbsp;请输入回复日期</font></td>
          <td align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr>
          <td colspan="2">日　期：
          <input type=text name=acc_date value="2005-06-06" class="za_text" size="12" maxlength="10">
          &nbsp;&nbsp;
          <input type=submit name=acc_ok value="确定" class="za_button"></td>
       </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>
<!----------------------回复视窗----------------------------></body>
</html>

