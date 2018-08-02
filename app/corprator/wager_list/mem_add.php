<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

echo "<script>if(self == top) location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
$uid = $_REQUEST['uid'];
$action = $_REQUEST['action'];
$langx = $_REQUEST['langx'];
$mtype = $_REQUEST['mtype'];
$key = $_REQUEST['keys'];

$sql = "select agname,super,setdata from web_corprator where oid='$uid'";
$result = mysql_query($sql);
if (mysql_num_rows($result) == 0 ){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>无权访问";
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


if ( $action == 1 )
{
				$memname = $_REQUEST['username'];
				$mempasd = $_REQUEST['password'];
				$sql = "SELECT * FROM `web_member` WHERE corprator='$agname' and Memname = '".$memname."' AND Passwd = '{$mempasd}' AND STATUS =1";
				$result = mysql_query( $sql );
				$cou = mysql_num_rows( $result );
				if ( $cou == 0 )
				{
								if ( $key == "" )
								{
												echo "<script>alert('LOGIN ERROR!!\\nPlease check username/passwd and try again!!');\r\n\t\t\tself.location='./wager_add.php?uid=".$uid."';</script>";
												exit( );
								}
								echo "<script>alert('LOGIN ERROR!!\\nPlease check username/passwd and try again!!');\r\n\t\t\tself.location='./wager_hide.php?uid=".$uid."';</script>";
								exit( );
				}
				if ( $key == "" )
				{
								$sql = "update `web_member` set edtvou=1 WHERE corprator='$agname' and Memname = '".$memname."' AND Passwd = '{$mempasd}' AND STATUS =1";
								if($d1set['d1_wager_add']==1) mysql_query( $sql );
								echo "<script>self.location='./wager_add.php?uid=".$uid."';</script>";
								exit( );
				}
				$sql = "update `web_member` set hidden=1 WHERE corprator='$agname' and Memname = '".$memname."' AND Passwd = '{$mempasd}' AND STATUS =1";
				if($d1set['d1_wager_hide']==1) mysql_query( $sql );
				echo "<script>self.location='./wager_hide.php?uid=".$uid."';</script>";
				exit( );
}
echo "<html>\r\n<head>\r\n<title>更改密码</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" href=\"/style/control/mem_body.css\" type=\"text/css\">\r\n</head>\r\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\">\r\n<script language=\"JavaScript\" src=\"/js/mem_chk_pass.js\">\r\n</script>\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"100%\">\r\n  <tr>\r\n    <td valign=\"middle\">\r\n      <table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#98B3C2\" align=\"center\">\r\n        <tr>\r\n          <td>\r\n            <table width=\"250\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\">\r\n              <tr align=\"center\">\r\n                <td colspan=\"2\" height=\"25\"  bgcolor=\"#004080\"><font color=\"#FFFFFF\">请输入帐号密码</font></td>\r\n\t\t\t</tr>\r\n              <form method=post onSubmit=\"return SubChk();\">\r\n                <tr bgcolor=\"#C2E1E7\" >\r\n                  <td class=\"b_rig_02\">帐号</td>\r\n                  <td height=\"30\" width=\"120\">\r\n\t\t\t\t  \t<input type=text name=\"username\" value=\"\"  size=8 maxlength=8  class=\"za_text_02\">\r\n            \t  </td>\r\n                </tr>\r\n                <tr bgcolor=\"#C2E1E7\" >\r\n                  <td height=\"30\" class=\"b_rig_02\" >密码</td>\r\n                  <td >\r\n\t\t            <input type=PASSWORD name=\"password\" value=\"\" size=8 maxlength=8 class=\"za_text_02\">\r\n                   </td>\r\n                </tr>\r\n                <tr  bgcolor=\"#C2E1E7\"  align=\"center\">\r\n                  <td colspan=\"2\" height=\"40\" >\r\n                    <input type=submit name=\"OK\" value=\"确定\" class=\"za_button_01\">\r\n                    <input type=button name=\"cancel\" value=\"取消\" class=\"za_button_01\" onClick=\"javascript:window.close();\">\r\n                    <input type=\"hidden\" name=\"action\" value=\"1\">\r\n                    <input type=\"hidden\" name=\"uid\" value=\"";
echo $uid;
echo "\">\r\n                  </td>\r\n                </tr>\r\n              </form>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n</body>\r\n</html>\r\n";
mysql_close( );
?>
