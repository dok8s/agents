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
switch ( $level )
{
case 0 :
				$level0 = 1;
				$level1 = 0;
				$level3 = 0;
				$level2 = 0;
				$sp = $user;
				break;
case 1 :
				$level0 = 1;
				$level1 = 1;
				$level3 = 0;
				$level2 = 0;
				$co = $user;
				$sql = "select super from web_corprator where 1>2 and agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$sp = $row['super'];
				break;
case 2 :
				$level0 = 1;
				$level1 = 1;
				$level2 = 1;
				$level3 = 0;
				$wd = $user;
				$sql = "select super,corprator from web_world where corprator='$corprator' and agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$co = $row['corprator'];
				$sp = $row['super'];
				break;
case 3 :
				$level0 = 1;
				$level1 = 1;
				$level2 = 1;
				$level3 = 1;
				$sql = "select super,world,corprator from web_agents where corprator='$corprator' and agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$wd = $row['world'];
				$co = $row['corprator'];
				$sp = $row['super'];
}
$level0 = 0;
$level1 = 0;
echo "<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<title></title>";
if(!$sp || ($level==0 && $sp!=$super)){
	echo "数据不存在";exit;
}
echo "<script>\r\n<!--\r\nvar limit=\"60\"\r\nif (document.images){\r\n\tvar parselimit=limit\r\n}\r\nfunction beginrefresh(){\r\nif (!document.images)\r\n\treturn\r\nif (parselimit==1)\r\n\t//var obj_agent = document.getElementById('agents_id');\r\n\t//alert(obj_agent.value);\r\n\twindow.location.reload();\r\nelse{\r\n\tparselimit-=1\r\n\tcurmin=Math.floor(parselimit)\r\n\tif (curmin!=0)\r\n\t\tcurtime=curmin+\"秒后自动更新！\"\r\n\telse\r\n\t\tcurtime=cursec+\"秒后自动更新！\"\r\n\t\ttimeinfo.innerText=curtime\r\n\t\tsetTimeout(\"beginrefresh()\",1000)\r\n\t}\r\n}\r\nfunction reload()\r\n{\r\n\tself.location.href=\"showlog.php?uid=";
echo $uid;
echo "&level=";
echo $level;
echo "&agents_id=";
echo $agents_id;
echo "\";\r\n}\r\nwindow.onload=beginrefresh\r\nfile://-->\r\n</script>\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n</head>\r\n<body oncontextmenu=\"window.event.returnValue=false\" bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\">\r\n <table width=\"773\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n    <tr>\r\n      <td class=\"m_tline\" width=\"746\">&nbsp;线上数据－<font color=\"#CC0000\">日志</font><font color=\"#CC0000\">&nbsp;</font>&nbsp;&nbsp;&nbsp;<input name=button type=button class=\"za_button\" onclick=\"reload()\" value=\"更新\">&nbsp;&nbsp;&nbsp;\r\n\r\n        <span id=\"timeinfo\"></span>-- 管理模式:WEB页面 -- <a href=\"javascript:history.go( -1 );\">回上一页</a></td>\r\n\r\n      <td width=\"34\"><img src=\"/images/control/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n    </tr>\r\n  </table>\r\n  <table width=\"774\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n    <tr>\r\n      <td width=\"774\" height=\"4\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td ></td>\r\n    </tr>\r\n  </table>\r\n  ";
if ( $level3 == 1 )
{
				echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>代理商</td><td width='126'>最后活动Khi</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";

				$sql = "select username,logtime,context,logip from web_mem_log where username='".$user."' and level=3 order by logtime desc limit 0,8";
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
								echo "  <tr class=\"m_cen\">\r\n    <td width=\"84\">";
								echo $row['username'];
								echo "</td>\r\n    <td width=\"126\"><font color=\"#CC0000\">";
								echo $row['logtime'];
								echo "</font></td>\r\n    <td align=right width=\"390\">";
								echo $row['context'];
								echo "</td>\r\n\t<td align=right width=\"173\">";
								echo $row['logip'];
								echo "</td>\r\n  </tr>\r\n  ";
				}
				echo "  <tr class='m_cen'> <td colSpan=4 align=right><a href='showlog_more.php?uid=$uid&level=3&agents_id=$user'>更多...</a></td></tr></table><br>\r\n";
}
if ( $level2 == 1 )
{
	echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>总代理</td><td width='126'>最后活动Khi</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";
				$sql = "select username,logtime,context,logip from web_mem_log where username='".$wd."' and level=2 order by logtime desc limit 0,8";
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
								echo "  <tr class=\"m_cen\">\r\n    <td>\r\n      ";
								echo $row['username'];
								echo "    </td>\r\n    <td><font color=\"#CC0000\">\r\n      ";
								echo $row['logtime'];
								echo "      </font></td>\r\n    <td align=right >\r\n      ";
								echo $row['context'];
								echo "    </td>\r\n    <td align=right>\r\n      ";
								echo $row['logip'];
								echo "    </td>\r\n  </tr>\r\n  ";
				}
				echo "  <tr class='m_cen'> <td colSpan=4 align=right><a href='showlog_more.php?uid=$uid&level=2&agents_id=$wd'>更多...</a></td></tr></table><br>\r\n";
}
if ( $level1 == 1 )
{
				echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>股东</td><td width='126'>最后活动Khi</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";

				$sql = "select username,logtime,context,logip from web_mem_log where username='".$co."' and level=1 order by logtime desc limit 0,8";
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
								echo "  <tr class=\"m_cen\">\r\n    <td width=\"84\">\r\n      ";
								echo $row['username'];
								echo "    </td>\r\n    <td width=\"126\"><font color=\"#CC0000\">\r\n      ";
								echo $row['logtime'];
								echo "      </font></td>\r\n    <td align=right width=\"390\">\r\n      ";
								echo $row['context'];
								echo "    </td>\r\n    <td align=right width=\"173\">\r\n      ";
								echo $row['logip'];
								echo "    </td>\r\n  </tr>\r\n  ";
				}
				echo "</table>\r\n\r\n<br>\r\n";
}
if ( $level0 == 1 )
{
				echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>大股东</td><td width='126'>最后活动Khi</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";

				$sql = "select username,logtime,context,logip from web_mem_log where username='".$sp."' and level=0 order by logtime desc limit 0,8";
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
								echo "  <tr class=\"m_cen\">\r\n    <td width=\"84\">\r\n      ";
								echo $row['username'];
								echo "    </td>\r\n    <td width=\"126\"><font color=\"#CC0000\">\r\n      ";
								echo $row['logtime'];
								echo "      </font></td>\r\n    <td align=right width=\"390\">\r\n      ";
								echo $row['context'];
								echo "    </td>\r\n    <td align=right width=\"173\">\r\n      ";
								echo $row['logip'];
								echo "    </td>\r\n  </tr>\r\n  ";
				}
				echo "</table>\r\n</form></body>\r\n</html>\r\n";
}
?>
