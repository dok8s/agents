<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language,super from web_corprator where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row 		= mysql_fetch_array($result);
$agname	=	$row['Agname'];
$agid		=	$row['ID'];
$super	=	$row['super'];
$langx	=	$row['language'];
$langx	=	'zh-tw';

require ("../../member/include/traditional.$langx.inc.php");

$enable	=	$_REQUEST["enable"];
$enabled=	$_REQUEST["enabled"];
$sort		=	$_REQUEST["sort"];
$active	=	$_REQUEST["active"];
$orderby=	$_REQUEST["orderby"];
$super_agents_id=$_REQUEST['super_agents_id'];

$mid		=	$_REQUEST["mid"];
$page		=	$_REQUEST["page"];
if ($page==''){
	$page=0;
}
if ($enable==""){
$enable='Y';
}

if ($sort==""){
	$sort='Alias';
}

if ($orderby==""){
	$orderby='asc';
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
	$mysql="update web_world set oid='',Status=$stop where ID=$mid";
	mysql_query($mysql);

	$mysql="select agname from web_world where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="update web_world set oid='',Status=$stop where subuser=1 and subname='$agent_name'";
	mysql_query($mysql);

	$mysql="update web_agents set oid='',Status=$stop where world='$agent_name'";
	mysql_query( $mysql);

	$mysql="update web_member set oid='',Status=$stop where world='$agent_name'";
	mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$agent_name','总代理',3)";
	mysql_query($mysql) or die ("操作失败!");
}

$sql = "select ID,Agname,passwd_safe,Alias,Credit,AgCount,date_format(AddDate,'%m-%d / %H:%i') as AddDate from web_world where corprator='$agname' and Status=$enabled and subuser=0 and  super='$super' order by ".$sort." ".$orderby;
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=30;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
if ($cou==0){
	$page_count=1;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title_suag {  background-color: #CD9A99; text-align: center}
-->
</style>
<SCRIPT language=javaScript src="/js/agents<?=$body_js?>.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript>
<!--
 function onLoad()
 {
  var obj_sagent_id = document.getElementById('super_agents_id');
  obj_sagent_id.value = '<?=$super_agents_id?>';
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

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad();">
<form name="myFORM" action="body_super_agents.php?uid=<?=$uid?>" method=POST>
  <table width="780" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="85" >&nbsp;&nbsp;总代理商管理:</td>
            <td>
              <select  name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y">启用</option>
                <option value="N">停用</option>
                <option value="S">暂停</option>
              </select>
	    </td>
            <td> -- <?=$mem_orderby?>:</td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="Alias"><?=$cor_name1?></option>
                <option value="Agname"><?=$cor_user?></option>
                <option value="AddDate"><?=$mem_adddate?></option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?>:</td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>

              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?> -- </td>
            <td>
              <input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='body_super_agents_add.php?uid=<?=$uid?>'" class="za_button">
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
$page_count=1;
?>
<table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="976061" class="m_tab">
    <tr class="m_title_suag">
      <td height="30" align=center>目前无任何总代理商</td>
    </tr>
  </table>
<?
}else{
?>
    <table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="976061" class="m_tab">
    <tr class="m_title_suag"  bgcolor="86C0A6">
      <td width="80">总代理名称</td>
      <td width="80">总代理帐号</td>
      <td width="80">安全代码</td>
      <td width="80" >信用额度</td>
      <td width="80">代理商总计</td>
      <td width="80">新增日期</td>
      <td width="55" >帐号状况</td>
      <td width="200">功能</td>
      <td width="54" >备注</td>
    </tr>
	<?
	while ($row = mysql_fetch_array($result)){

		$sql = "select count(*) as cou from web_agents where world='".$row['Agname']."' order by id";
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
<a href="javascript:CheckSTOP('/app/corprator/super_agent/body_super_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=S','S')">暂停</a> /
<?
}
?>
         <a href="javascript:CheckSTOP('/app/corprator/super_agent/body_super_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a>
        / <a href="/app/corprator/super_agent/body_super_agents_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&super_agents_id=<?=$agid?>"><?=$mem_acount?></a>
        / <a href="/app/corprator/super_agent/body_super_agents_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&super_agents_id=<?=$agid?>"><?=$mem_setopt?></a></td>
    <td></td>

      </tr>
<?
}
}
?>
</table>
  </table>
</form>
</body>
</html>
<?
mysql_close();
?>
