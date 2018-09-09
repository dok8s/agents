<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) parent.location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );
$uid = $_REQUEST['uid'];
$sql = "select agname,super,setdata from web_corprator where oid='$uid'";
$result = mysql_query($sql);
if (mysql_num_rows($result) == 0 ){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>��Ȩ����";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['agname'];
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
if($d1set['d1_wager_add']!=1){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>��Ȩ����";
	exit;
}

$enable = $_REQUEST['enable'];
$enabled = $_REQUEST['enabled'];
$sort = $_REQUEST['sort'];
$orderby = $_REQUEST['orderby'];
$mid = $_REQUEST['id'];
$active = $_REQUEST['active'];
$page = $_REQUEST['page'];
if ( $page == "" )
{
				$page = 0;
}
if ( $enable == "" )
{
				$enable = "Y";
}
if ( $sort == "" )
{
				$sort = "alias";
}
if ( $orderby == "" )
{
				$orderby = "asc";
}
if ( $enable == "Y" )
{
				$enabled = 1;
				$memstop = "N";
				$stop = 1;
				$start_font = "";
				$end_font = "";
				$caption1 = "ͣ��";
				$caption2 = "����";
}
else
{
				$enable = "N";
				$memstop = "Y";
				$enabled = 0;
				$stop = 0;
				$start_font = "";
				$end_font = "</font>";
				$caption2 = "<SPAN STYLE='background-color: rgb(255,255,0);'>ͣ��</SPAN>";
				$caption1 = "����";
}
if ( $active==2 ){
	$mysql = "update web_member set Status=".$stop." where corprator='".$agname."' and id={$mid}";
	mysql_query( $mysql );
}
elseif ( $active==3 && $d1set['d1_wager_add_deluser']==1){
	$sql = "update web_member set edtvou=0 where corprator='".$agname."' and id=".$mid;
	mysql_query( $sql );
}
echo "<html>\r\n<head>\r\n<title>main</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style type=\"text/css\">\r\n<!--\r\n.m_title {  background-color: #FEF5B5; text-align: center}\r\n-->\r\n</style>\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<SCRIPT language=\"javascript\" src=\"/js/member_gb.js\"></script>\r\n<SCRIPT>\r\n\r\n function onLoad()\r\n {\r\n  //var obj_sagent_id = document.getElementById('agent_id');\r\n  //obj_sagent_id.value = '";
echo $agid;
echo "';\r\n  var obj_enable = document.getElementById('enable');\r\n  obj_enable.value = '";
echo $enable;
echo "';\r\n  var obj_page = document.getElementById('page');\r\n  obj_page.value = '";
echo $page;
echo "';\r\n  var obj_sort=document.getElementById('sort');\r\n  obj_sort.value='";
echo $sort;
echo "';\r\n  var obj_orderby=document.getElementById('orderby');\r\n  obj_orderby.value='";
echo $orderby;
echo "';\r\n }\r\n// -->\r\n</SCRIPT>\r\n</head>\r\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\" onload=\"onLoad()\";>\r\n<FORM NAME=\"myFORM\" ACTION=\"?uid=";
echo $uid;
echo "\" METHOD=POST>\r\n<input type=\"hidden\" name=\"agent_id\" value=\"";
echo $agid;
echo "\">\r\n";
$sql = "select passwd,ID,Memname,pay_type,money,Alias,Credit,ratio,date_format(AddDate,'%m-%d / %H:%i') as AddDate,pay_type,Agents,OpenType from web_member where corprator='".$agname."' and edtvou=1 and Status=".$enabled." order by ".$sort." ".$orderby;
$result = mysql_query( $sql );
$cou = mysql_num_rows( $result );
$page_size = 15;
$page_count = ceil( $cou / $page_size );
$offset = $page * $page_size;
$mysql = $sql.( "  limit ".$offset.",{$page_size};" );
$result = mysql_query( $mysql );
echo "<table width=\"775\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n\t<td class=\"\">\r\n        <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >\r\n          <tr>\r\n            <td>&nbsp;&nbsp;�ĵ���Ա            <select name=\"enable\" onChange=\"self.myFORM.submit()\" class=\"za_select\" >\r\n                <option value=\"Y\" >����</option>\r\n                <option value=\"N\" >ͣ��</option></td>\r\n\r\n            <td width=\"40\"> -- ����</td>\r\n            <td>\r\n              <select id=\"super_agents_id\" name=\"sort\" onChange=\"document.myFORM.submit();\" class=\"za_select\">\r\n                <option value=\"alias\">��Ա����</option>\r\n                <option value=\"memname\">��Ա�ʺ�</option>\r\n                <option value=\"adddate\">��������</option>\r\n              </select>\r\n              <select id=\"enable\" name=\"orderby\" onChange=\"self.myFORM.submit()\" class=\"za_select\">\r\n                <option value=\"asc\">����(��С����)</option>\r\n                <option value=\"desc\">����(�ɴ�С)</option>\r\n              </select>\r\n            </td>\r\n            <td width=\"52\"> -- ��ҳ��:</td>\r\n            <td>\r\n              <select id=\"page\" name=\"page\" onChange=\"self.myFORM.submit()\" class=\"za_select\">\r\n\t\t\t\t\t\t\t";
$i = 0;
for ( ;	$i < $page_count;	++$i	)
{
				echo ( "<option value='".$i."'>".( $i + 1 ) )."</option>";
}
echo "              </select>\r\n            </td>\r\n            <td> / ";
echo $page_count;
echo " ҳ -- </td>\r\n            <td>\r\n              <input type=BUTTON name=\"append\" value=\"����\" onClick=\"document.location='./mem_add.php?uid=";
echo $uid;
echo "'\" class=\"za_button\">\r\n            </td>\r\n          </tr>\r\n        </table>\r\n\t\t\t</td>\r\n    <td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n</tr>\r\n<tr>\r\n\t<td colspan=\"2\" height=\"4\"></td>\r\n</tr>\r\n</table>\r\n";
if ( $cou == 0 )
{
				echo "  <table width=\"775\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"E3D46E\" class=\"m_tab\">\r\n    <tr class=\"m_title\">\r\n      <td height=\"30\" >";
				echo $mem_nomem;
				echo "</td>\r\n    </tr>\r\n  </table>\r\n\t";
}
else
{
				echo "  <table width=\"780\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"E3D46E\" class=\"m_tab\">\r\n    <tr class=\"m_title\">\r\n      <td width=\"60\">��Ա����</td>\r\n      <td width=\"70\">��Ա�ʺ�</td>\r\n      <td width=\"60\">����</td>\r\n\t  \t<td width=\"110\">���ö��</td>\r\n\t  \t<td width=\"30\">�̿�</td>\r\n      <td width=\"80\">��������</td>\r\n      <td width=\"70\">ʹ��״��</td>\r\n      <td width=\"240\">����</td>\r\n    </tr>\r\n\t";
				while ( $row = mysql_fetch_array( $result ) )
				{
								echo "\t\t<tr class=\"m_cen\">\r\n      <td>";
								echo $start_font;
								echo iconv('big5','gbk',$row['Alias']);
								echo $end_font;
								echo "</td>\r\n      <td>";
								echo $start_font;
								echo $row['Memname'];
								echo $end_font;
								echo "</td>\r\n\t\t\t<td>";
								echo $start_font;
								echo $row['passwd'];
								echo $end_font;
								echo "</td>\r\n\t  \t<td align=\"right\">\r\n      <p align=\"right\">";
								echo $start_font;
								if ( $row['pay_type'] == 1 )
								{
												echo mynumberformat( $row['money'] * $row['ratio'], 2 );
								}
								else
								{
												echo mynumberformat( $row['Credit'] * $row['ratio'], 2 );
								}
								echo $end_font;
								echo "</td>\r\n      <td>";
								echo $start_font;
								echo $row['OpenType'];
								echo $end_font;
								echo "</td>\r\n\t  <td>";
								echo $row['AddDate'];
								echo "</td>\r\n\t  <td>";
								echo $caption2;
								echo "</td>\r\n      <td align=\"left\"><font color=\"#0000FF\"><a style=\"cursor: hand\">\r\n\t\t&nbsp;&nbsp;<a href=\"javascript:CheckSTOP('wager_add.php?uid=";
								echo $uid;
								echo "&active=2&id=";
								echo $row['ID'];
								echo "&enable=";
								echo $memstop;
								echo "')\">";
								echo $caption1;
								echo "</a>";
							if($d1set['d1_wager_add_deluser']==1){
								echo "&nbsp;/&nbsp; <a href=\"javascript:CheckDEL('?uid=$uid&active=3&id=$row[ID]')\">ɾ��</a>";
							}
							if($d1set['d1_wager_add_edit']==1){
								echo "&nbsp;/&nbsp; <a href=\"hide_list.php?uid=$uid&username=$row[Memname]\">��ϸͶע</a>";
							}
								echo "</td>\r\n    </tr>\r\n";
				}
				echo "\t</table>\r\n</form>\r\n\r\n";
}
echo "<INPUT TYPE='hidden' NAME='agents' value=''></body>\r\n</html>";
?>
