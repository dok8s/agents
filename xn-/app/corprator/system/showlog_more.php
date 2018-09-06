<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require( "../../member/include/config.inc.php" );
$agents_id = $_REQUEST['agents_id'];
$uid = $_REQUEST['uid'];
$level = $_REQUEST['level'];
$user = $_REQUEST['agents_id'];
$active = $_REQUEST['active'];
$sql = "select id,subuser,agname,subname,status,super,setdata from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
	echo "<script>window.open('".$site."/index.php','_top')</script>";
	exit( );
}
$row = mysql_fetch_array($result);
$corprator=$row['agname'];
$super=$row['super'];

echo "<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<title></title>\r\n<script>\r\n<!--\r\nvar limit=\"60\"\r\nif (document.images){\r\n\tvar parselimit=limit\r\n}\r\nfunction beginrefresh(){\r\nif (!document.images)\r\n\treturn\r\nif (parselimit==1)\r\n\t//var obj_agent = document.getElementById('agents_id');\r\n\t//alert(obj_agent.value);\r\n\twindow.location.reload();\r\nelse{\r\n\tparselimit-=1\r\n\tcurmin=Math.floor(parselimit)\r\n\tif (curmin!=0)\r\n\t\tcurtime=curmin+\"秒后自动更新！\"\r\n\telse\r\n\t\tcurtime=cursec+\"秒后自动更新！\"\r\n\t\ttimeinfo.innerText=curtime\r\n\t\tsetTimeout(\"beginrefresh()\",1000)\r\n\t}\r\n}\r\nfunction reload()\r\n{\r\n\tself.location.href=\"showlog_more.php?uid=";
echo $uid;
echo "&level=";
echo $level;
echo "&agents_id=";
echo $agents_id;
echo "\";\r\n}\r\nwindow.onload=beginrefresh\r\nfile://-->\r\n</script>\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n</head>\r\n<body oncontextmenu=\"window.event.returnValue=false\" bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\">\r\n <table width=\"773\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n    <tr>\r\n      <td class=\"m_tline\" width=\"746\">&nbsp;线上数据－<font color=\"#CC0000\">日志</font><font color=\"#CC0000\">&nbsp;</font>&nbsp;&nbsp;&nbsp;<input name=button type=button class=\"za_button\" onclick=\"reload()\" value=\"更新\">&nbsp;&nbsp;&nbsp;\r\n\r\n        <span id=\"timeinfo\"></span>-- 管理模式:WEB页面 -- <a href=\"javascript:history.go( -1 );\">回上一页</a></td>\r\n\r\n      <td width=\"34\"><img src=\"/images/control/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n    </tr>\r\n  </table>\r\n  <table width=\"774\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n    <tr>\r\n      <td width=\"774\" height=\"4\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td ></td>\r\n    </tr>\r\n  </table>\r\n  ";


$level_name_array = array('大股东','股东','总代理','代理商');

echo "<table id='glist_table' border='0' cellspacing='1' cellpadding='0'  bgcolor='006255' class='m_tab' width='778'>
		<tr class='m_title_ft'>
		<td width='84' align='middle'>{$level_name_array[$level]}</td>
		<td width='126'>最后活动Khi</td>
		<td width='390'>操作</td>
		<td width='173'>登陆IP</td>
		</tr>";

$webtable = array('','','web_world','web_agents');
if(strlen($webtable[$level])>1){
	$query = mysql_query("select agname from {$webtable[$level]} where corprator='$corprator' and agname='$user'");
	if(mysql_num_rows($query)){
		$sql = "select username,logtime,context,logip from web_mem_log where username='$user' and level='$level' order by logtime desc limit 0,500";
		$result = mysql_query( $sql );
		while ( $row = mysql_fetch_array( $result ) ){
			echo "
		  <tr class='m_cen'>
			<td width=84>$row[username]</td>
			<td width=126><font color=#CC0000>$row[logtime]</font></td>
			<td align=right width=390>$row[context]</td>
			<td align=right width=173><a href='http://ip138.com/ips138.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a></td>
		  </tr>";
		}
	}
}
echo "</table>\r\n<br>\r\n";

echo "</form></body>\r\n</html>";
?>
