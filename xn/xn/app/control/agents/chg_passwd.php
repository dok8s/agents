<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select Agname,ID from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agname=$row["Agname"];
$active=$_REQUEST['action'];
if ($active==1){
	if($_REQUEST["password"]<>"admin111"){
		$pasd=substr(md5(md5($_REQUEST["password"]."abc123")),0,16);
	}
	$chk=chk_pwd($pasd);
	
	if($_REQUEST["password"]<>"admin111"){
		$mysql="update web_agents set Passwd='$pasd' where Oid='$uid'";
		mysql_query($mysql) or die ("操作失败!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','密码更改','$agname','代理商',5)";
		mysql_query($mysql) or die ("操作失败!");
	}
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><Script language=javascript>alert('已成功的变更了您的密码~~请回首页重新');window.open('/','_top')</script>";
}
else{
	$mysql="Select Passwd,language from web_agents where Oid='$uid'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$agpawd=$row['Passwd'];
	$langx=$row['language'];
	require ("../../member/include/traditional.$langx.inc.php");
?>
<html>
<head>
<title><?=$mnu_epasd?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/mem_body.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<script language="JavaScript" src="/js/mem_chk_pass.js">
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td valign="middle">
      <table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="#98B3C2" align="center">
        <tr>
          <td>
            <table width="250" border="0" cellspacing="1" cellpadding="0">
              <tr align="center">
          <td colspan="2" height="25"  bgcolor="#004080"><font color="#FFFFFF"><?=$acc_caption?></font></td>
			</tr>
              <form method=post onSubmit="return SubChk();">
                <tr bgcolor="#C2E1E7" >
                  <td class="b_rig_02"><?=$acc_pasd?></td>
                  <td height="30" width="120">
				  	<input type=PASSWORD name="password" value="admin111"  size=8 maxlength=20  class="za_text_02">
            	  </td>
                </tr>
                <tr bgcolor="#C2E1E7" >
                  <td height="30" class="b_rig_02" ><?=$acc_repasd?></td>
                  <td >
		            <input type=PASSWORD name="REpassword" value="admin111" size=8 maxlength=20 class="za_text_02">
                   </td>
                </tr>
                <tr  bgcolor="#C2E1E7"  align="center">
                  <td colspan="2" height="40" >
                    <input type=submit name="OK" value="<?=$submit_ok?>" class="za_button_01">
                    <input type=button name="cancel" value="<?=$submit_cancle?>" class="za_button_01" onClick="javascript:history.go(-1);">
                    <input type="hidden" name="action" value="1">
                    <input type="hidden" name="uid" value="<?=$uid?>">
                  </td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html><script language='javascript'>
function cancelMouse()
{
    return false;
}
document.oncontextmenu=cancelMouse;
</script>
<?
}
mysql_close();
?>
