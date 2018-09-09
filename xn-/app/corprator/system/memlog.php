<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
$date_start = $_REQUEST['date_start'];
$agents_id = $_REQUEST['agents_id'];
$uid = $_REQUEST['uid'];
$user = $_REQUEST['user'];
$active = $_REQUEST['active'];
$so_log_name=trim($_REQUEST['so_log_name']);
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
$level=$row['subuser']==0 ? 1 : 0;
$d1set = @unserialize($row['setdata']);

$sql = "select setdata,d1edit from web_super where agname='$super'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$d0set = @unserialize($row['setdata']);
$d0set['d1_edit']=$row['d1edit'];
foreach($d1set as $k=>$v){
	if($v==1 && substr($k,0,2)=='d1'){
		$d1set[$k] = $d0set[$k];
	}
}

if($d1set['d1_mem_online_show']!=1){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>无权访问";
	exit;
}
if ( $date_start == "" )
{
				$date_start = date( "m-d" );
}
if ( $active == 1 )
{
				$sql = "update web_member set oid='' where corprator='$corprator' and memname='".$user."'";
				mysql_query( $sql );
				echo "<script language='javascript'>self.location='memlog.php?uid=".$uid."';</script>";
}
echo "<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<title></title>\r\n<script>\r\n<!--\r\nvar limit=\"120\"\r\nif (document.images){\r\n\tvar parselimit=limit\r\n}\r\nfunction beginrefresh(){\r\nif (!document.images)\r\n\treturn\r\nif (parselimit==1)\r\n\t//var obj_agent = document.getElementById('agents_id');\r\n\t//alert(obj_agent.value);\r\n\twindow.location.reload();\r\nelse{\r\n\tparselimit-=1\r\n\tcurmin=Math.floor(parselimit)\r\n\tif (curmin!=0)\r\n\t\tcurtime=curmin+\"秒后自动更新！\"\r\n\telse\r\n\t\tcurtime=cursec+\"秒后自动更新！\"\r\n\t\ttimeinfo.innerText=curtime\r\n\t\tsetTimeout(\"beginrefresh()\",1000)\r\n\t}\r\n}\r\nfunction reload()\r\n{\r\n\tself.location.href=\"memlog.php?uid=";
echo $uid;
echo "\";\r\n}
function report_bg(){
	document.getElementById('mem_num').innerText=cou;
}

function so_log()
{
	var so_log_name = document.getElementById('so_log_name').value;
	if(so_log_name!=''){
		self.location.href='?uid=$uid&so_log_name='+so_log_name;
	}
}
window.onload=beginrefresh
</script>";
?>

<?
echo "<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n</head>\r\n<body oncontextmenu=\"window.event.returnValue=false\" bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\">\r\n\r\n <table width=\"773\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n    <tr>\r\n      <td class=\"\" width=\"746\">&nbsp;线上数据－<font color=\"#CC0000\">日志</font><font color=\"#CC0000\">&nbsp;</font><input name=button type=button class=\"za_button\" onclick=\"reload()\" value=\"更新\">&nbsp;&nbsp;&nbsp;&nbsp;\r\n        <span id=\"timeinfo\"></span>-- 20分内在线人数<font color=red><b>(<span id=\"mem_num\"></span>)</b></font>&nbsp;&nbsp;&nbsp; 会员帐号或其部分:<INPUT TYPE='text' size=10 NAME='so_log_name' value='' id='so_log_name'> <input name=button type=button onclick='so_log()' value='搜索'>  -- <a href=\"javascript:history.go( -1 );\">回上一页</a></td>\r\n      <td width=\"34\"><img src=\"/images/control/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n    </tr>\r\n  </table>\r\n <table width=\"774\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n   <tr>\r\n     <td width=\"774\" height=\"4\"></td>\r\n   </tr>\r\n </table>\r\n\r\n<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"750\">\r\n  <tr class=\"m_title_ft\">";

if($d1set['d1_mem_online_aglog']==1){
	echo "<td width=\"100\">代理 </td>";
}
echo "<td width=\"100\">会员名称 </td>\r\n    <td width=\"150\">最后活动Khi</td>";

if($d0set['d0show_memip']==1){
	echo "<td width=\"150\">登陆IP</td>";
}

if($d1set['d1_mem_online_domain']==1){
	echo "<td width=\"150\">网址</td>";
}

echo "<td width=\"180\">操作</td>\r\n  </tr>\r\n  ";

$date = date('Y-m-d H:i:s',time()-60*20);
$sql_where="corprator='$corprator' AND active>'$date' AND oid!='' AND oid!='out' ";
if($so_log_name){
	$sql_where="corprator='$corprator' AND (memname like '%$so_log_name%' OR loginname like '%$so_log_name%') ";
}
$sql = "select memname,active,logip,domain,agents from web_member where $sql_where order by active desc";
$result = mysql_query( $sql );
while ( $row = mysql_fetch_array( $result ) )
{

				echo "  <tr class=\"m_cen\">\r\n";

				if($d1set['d1_mem_online_aglog']==1){
					echo "<td><a href='showlog.php?uid=$uid&agents_id=$row[agents]&level=3'>$row[agents]</a></td>";
				}
				echo "\r\n\t\t<td><font color=\"#CC0000\">";
				echo $row['memname'];
				echo "</font>\r\n\t\t<td>";
				echo $row['active'];
				echo "</td>\r\n\t\t";
				if($d0set['d0show_memip']==1){
					echo "<td align=center width='160'><a href='http://ip138.com/ips138.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a></td>";
				}
				if($d1set['d1_mem_online_domain']==1){
					echo "<td>$row[domain] </td>";
				}
				echo "<td align=\"center\">\r\n         <a href=\"./memlog.php?uid=";
				echo $uid;
				echo "&active=1&user=";
				echo $row['memname'];
				echo "\">踢线</a>\r\n    ";
				if ( $level == 1 )
				{
					if($d1set['d1_edit']==1){
						echo " / <a href='../wager_list/hide_list.php?uid=$uid&username=$row[memname]'>投注</a>";
					}
				}
				echo "    </td>\r\n  </tr>\r\n  ";
				++$i;
}
echo "</table>\r\n</form></body>\r\n</html>\r\n<script>\r\nvar cou='";
echo $i;
echo "';\r\nreport_bg();\r\n</script>\r\n";


	$loginfo='查看会员在线';
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$corprator',now(),'$loginfo','$ip_addr','1')";
	mysql_query($mysql);
?>
