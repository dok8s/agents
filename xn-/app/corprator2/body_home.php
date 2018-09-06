<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
//require ("../member/include/traditional.$langx.inc.php");
require ("../member/include/traditional.zh-cn.inc.php");


$sql = "select agname from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];

$sql = "select agname from web_corprator where subuser=1 and subname='$agname'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$ag=" M_czz='".$row['agname']."' or ";
}



$sql="select message_tw as message from web_marquee where level=4 order by ntime desc limit 0,1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$messages=$row['message'];

$sql="select  message from web_marquee where level=1 order by ntime desc limit 0,1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$messages2=$row['message'];

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
<style type="text/css">
<!--
div.bac {width:750px; color: #000; padding:5px; border:1px solid #C00;line-height:1.3em; font-size:1em;}
p.title { margin:0; padding:2px; background-color:#900; color:#FFF; text-align:center;}
b { color:#C30;}
-->
</style>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr>
    <td width="150" align="right">Hệ thống thông báo：</td>
    <td width="450"><marquee scrollDelay=200><?=$messages?></marquee></td>
    <td align="center">
    	<A HREF="javascript://" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>&scoll_set=scoll_set3','','help:no')">
    	Lịch sử thông điệp.
	  </a>
    </td>
  </tr>
  <tr align="center">
    <td colspan="3" bgcolor="6EC13E">&nbsp; </td>
  </tr>

</table>
<div id="user_msg" class="user_msg">
	<span>Số tài khoản thêm và mẹo đổi mật khẩu</span>
	<div id="table_master">
		<table cellpadding="0" cellspacing="0" id="table_header">
		  <tbody>
			<tr class="msg_td">
				<td>Thời gian.</td>
				
<td> 
Điều hành </td>
 <td>
Dự án </td>
<td>
Số tài khoản </td> 
<td> 
Tầng lớp </td>
			</tr>
			<?
if($ag==""){
	$sql="select  * from agents_log  where Status=3 and M_czz='$agname' order by M_DateTime desc";
}else{
	$sql="select  * from agents_log  where Status=3 and (".$ag." M_czz='$agname') order by M_DateTime desc";
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
<br>


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
