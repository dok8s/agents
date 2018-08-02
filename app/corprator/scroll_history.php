<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

require_once('../member/include/config.inc.php');
$uid=$_REQUEST['uid'];
$scoll_set=$_REQUEST['scoll_set'];
$mysql="select Agname,ID from web_corprator where Oid='$uid'";
$result = mysql_query($mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

if($scoll_set=='scoll_cor_set'){
	$level=' where level=1';
}else{
	$level=' where level=4';
}

$shistory='message';
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">

<table width="495" border="0" cellspacing="1" cellpadding="0"  bgcolor="2A73AC" class="m_tab">
  <tr></tr>
  <tr>跑马灯_历史讯息</tr>
  <tr class="m_title_bk" >
    <td width="50"  align="center">编号</td>
    <td width="55"  align="center">时间</td>
    <td>公告内容</td>
  </tr>
  <?
	$sql="select date_format(ntime,'%y-%m-%d') as ntime,$shistory as message from web_marquee $level order by id desc";
	$result = mysql_query($sql);
	$icount=1;
	while ($row = mysql_fetch_array($result))
	{
	?>

  <tr class="m_cen">
      <td align="center"><?=$icount?></td>
      <td align="center"><?=$row['ntime']?></td>
      <td align="left"><font color="#CC0000"><?=$row['message']?></font></td>
  </tr>
  <?
$icount++;
}
?>
  </tr>
</table>
</form>
</body>
</html>
<?
mysql_close();
?>
