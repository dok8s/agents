<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
require ("../../member/include/traditional.$langx.inc.php");
$sql = "select agname from web_world where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];

$sql = "select agname from web_world where subuser=1 and subname='$agname'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$ag=" M_czz='".$row['agname']."' or ";
}

$sql="select message_tw as message from web_marquee order by ntime desc limit 0,1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$messages=$row['message'];
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
</head>

<body oncontextmenu="return false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
  <tr>
    <td width="150" align="right">系统公告：</td>
    <td width="520"><marquee scrollDelay=200><?=$messages?></marquee></td>
    <td align="center">
    	<A HREF="javascript://" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','help:no')">
    	历史讯息
			</a>
    </td>
  </tr>
  <tr align="center" >
    <td colspan="3" bgcolor="6EC13E">&nbsp; </td>
  </tr>
</table>
<div id="user_msg" class="user_msg">
	<span>帐号新增及密码更改提示</span>
	<div id="table_master">
		<table cellpadding="0" cellspacing="0" id="table_header">
		  <tbody>
			<tr class="msg_td">
				<td>Khi</td>
				<td>操作者</td>
				<td>项目</td>
				<td>帐号</td>
				<td>阶层</td>
			</tr>
			<?
if($ag==""){
	$sql="select  * from agents_log  where Status=4 and M_czz='$agname' order by M_DateTime desc";
}else{
	$sql="select  * from agents_log  where Status=4 and (".$ag." M_czz='$agname') order by M_DateTime desc";
}
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
?>
			<tr>
				<td><?=$row["M_DateTime"]?></td>
				<td><?=$row["M_czz"]?></td>
				<td><?=$row["M_xm"]?></td>
				<td><?=$row["M_user"]?></td>
				<td><?=$row["M_jc"]?></td>
			</tr>
<?
}
?>
			</tbody>
		</table>
  </div>
	
</div>


</body>
</html>
<?
$sql='select salert as salert,alert_tw as alert from web_system';
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$talert=$row['alert'];
if ($row['salert']==1 and $talert<>''){
	echo "<script>alert('$talert');</script>";
}
mysql_close();
?>
