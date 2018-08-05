<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");
require ("../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$addNew=$_REQUEST["addNew"];
$deluser=$_REQUEST["deluser"];
$edituser=$_REQUEST["edituser"];
$edituser1=$_REQUEST["edituser1"];
$id = intval($_REQUEST["id"]);
$mysql="select Agname,ID,language,super from web_corprator where Oid='$uid'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$super=$row['super'];
$agid=$row['ID'];
if ($deluser=='Y'){
	$mysql="select Agname from web_corprator where ID='$id'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$new_user=$row["Agname"];
	$mysql="delete from web_corprator where ID='$id'";
	$result = mysql_query($mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','删除','$new_user','股东',3)";
	mysql_query($mysql) or die ("操作失败!");
}

$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
if ($sort==""){
	$sort='alias';
}

if ($orderby==""){
	$orderby='asc';
}
if ($edituser=='Y'){
	$new_user=trim($_REQUEST["e_user"]);
	if($_REQUEST["e_pass"]<>"admin111"){
		$new_pass=substr(md5(md5($_REQUEST["e_pass"]."abc123")),0,16);
	}
	$new_alias=$_REQUEST["e_alias"];
	$mysql="select id from web_corprator where Agname='$new_user'";


	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if($edituser1<>"Y"){
		if ($cou>0){
			echo "<script language=javascript>alert('帐号名称已被他人使用!');document.location='./su_subuser.php?uid=$uid';</script>";
			exit;
		}
	}
	if($_REQUEST["e_pass"]<>"admin111"){
		$mysql="update web_corprator set agname='$new_user',passwd='$new_pass',alias='$new_alias' where ID='$id'";
	}else{
		$mysql="update web_corprator set agname='$new_user',alias='$new_alias' where ID='$id'";
	}
	$result = mysql_query($mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','密码更改','$new_user','股东',3)";
	mysql_query($mysql) or die ("操作失败!");
	echo "<script language=javascript>document.location='./su_subuser.php?uid=$uid';</script>";
}
if ($addNew=='Y'){
	$new_user=$_REQUEST["e_user"];
	$chk=chk_pwd($_REQUEST["e_pass"]);
	$new_pass=substr(md5(md5($_REQUEST["e_pass"]."abc123")),0,16);
	$new_alias=$_REQUEST["e_alias"];
	$AddDate=date('Y-m-d H:i:s');

	

	$mysql="select * from web_corprator where Agname='$new_user'";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mysql="insert into web_corprator(Agname,Passwd,Alias,subuser,subname,AddDate,super) values('$new_user','$new_pass','$new_alias','1','$agname','$AddDate','$super')";
		mysql_query($mysql) or die ("操作失败!");
		$result = mysql_query($mysql);
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','新增','$new_user','股东',3)";
		mysql_query($mysql) or die ("操作失败!");
		echo "<Script language=javascript>self.location='su_subuser.php?uid=$uid';</script>";
	}else{
		$msg=wterror('帐号名称已被他人使用，请重新输入！！');

		echo $msg;exit;
	}

}else{
	$sql = "select * from web_corprator where subname='$agname' and subuser=1 order by ".$sort." ".$orderby;
	$result = mysql_query($sql);

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title { background-color: #86C0A6; text-align: center}
-->
</style>
<script language="javascript" src="/js/chk_keycode.js"></script>
<SCRIPT language=javaScript>
<!--
function onLoad(){
	//var obj_enable = document.getElementById('orderby');
	//obj_enable.value = '{NOW_ENABLE}';
	var obj_page = document.getElementById('page');
	obj_page.value = '0';
	var obj_sort=document.getElementById('sort');
	obj_sort.value='';
	var obj_orderby=document.getElementById('orderby');
	obj_orderby.value='';
}
// -->
</SCRIPT>
<script language="javascript" src="/js/ag_subuser.js"></script>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<table width="780" border="0" cellspacing="0" cellpadding="0">
	<form name="myFORM" action="su_subuser.php?uid=<?=$uid?>" method="POST">
		<tr>
			<td class="m_tline">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
<td nowrap> & nbsp; & nbsp; Sắp xếp & nbsp;: & nbsp; </ td>
<td>
<select id = "sort" name = "sort" onChange = "document.myFORM.submit ();" class = "za_select">
<option value = "username"> Tài khoản </ option>
<option value = "adddate"> Thêm ngày </ option>
</ select>
<select id = "orderby" name = "orderby" onChange = "self.myFORM.submit ()" class = "za_select">
<option value = "asc"> Tăng sức mạnh (nhỏ đến lớn) </ option>
<option value = "desc"> Công suất thấp hơn (lớn hơn đến nhỏ hơn) </ option>
</ select>
</ td>
<td nowrap> & nbsp; - & nbsp; Tổng số trang & nbsp;: & nbsp; </ td>
						<td>
							<select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
								<option value="0">1</option>
							</select>
						</td>
						<td nowrap>&nbsp;/&nbsp;1&nbsp;Trang&nbsp;--&nbsp;</td>
						<td>
							<input type="button" name="append" value="Đã thêm" onClick="show_win();" class="za_button">
						</td>
					</tr>
				</table>
			</td>
			<td><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
		</tr>
		<tr>
			<td colspan="2" height="4"></td>
		</tr>
	</form>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" bgcolor="#4B8E6F" class="m_tab">
	<tr class="m_title">
	<td width = "150"> Tài khoản </ td>
<td width = "150"> Mã bảo mật </ td>
<td width = "150"> Mật khẩu </ td>
<td width = "150"> Tên </ td>
<td width = "150"> Thêm ngày </ td>
<td width = "180"> Chức năng </ td>
	</tr>

    <?
		$cou=mysql_num_rows($result);
		if ($cou==0){
	?>
  <FORM NAME="AG_<?=$agid?>" ACTION="" METHOD=POST target='_self'>
    <INPUT TYPE="HIDDEN" NAME="id" value="<?=$agid?>">
    <INPUT TYPE="HIDDEN" NAME="edituser" value="Y">
	<input TYPE="HIDDEN" NAME="uid" VALUE="<?=$uid?>">		<input type="hidden" NAME="act" value="2">
		<input type="hidden" NAME="e_user" VALUE="Không tìm kiếm dữ liệu có liên quan được chỉ định">
		<tr class="m_cen">
			<td>Không tìm kiếm dữ liệu có liên quan được chỉ định</td>
			<td>
				<input type="password" name="e_pass" value="" size="12" maxlength="12" class="za_text" onKeyPress="return ChkKeyCode();">
			</td>
			<td>
				<input type="text" name="e_alias" value="" size="8" class="za_text">
			</td>
			<td></td>
			<td align="left"></td>
		</tr></FORM>
	<?
	}else{
		while ($row = mysql_fetch_array($result)){
	?>
		<FORM NAME="AG_<?=$row['ID']?>" ACTION="" METHOD=POST target='_self'>
		<INPUT TYPE="HIDDEN" NAME="id" value="<?=$row['ID']?>">
		<INPUT TYPE="HIDDEN" NAME="edituser1" value="Y">
		<INPUT TYPE="HIDDEN" NAME="edituser" value="Y">
		<tr class="m_cen" >
    		<td><?=$row['Agname']?><input type="hidden" name="e_user" value="<?=$row['Agname']?>" size="8" class="za_text" ></td>
			<td><?=$row['passwd_safe']?></td>
			<td>
				<input type="password" name="e_pass" value="admin111" size="12" maxlength="12" class="za_text" onKeyPress="return ChkKeyCode();">
			</td>
			<td>
				<input type="text" value="<?=$row['Alias']?>" name="e_alias" size="8" class="za_text">
			</td>
			<td><?=$row['AddDate']?></td>
			<td align="left">
				<a href="javascript:ChkData('<?=$row['ID']?>')" style="cursor:hand;">Sửa đổi</a> 
				/ <a href="javascript:CheckDEL('./su_subuser.php?uid=<?=$uid?>&deluser=Y&id=<?=$row['ID']?>')">Xóa</a>
			</td>
    	</tr>
		</FORM>
	<?
	}
}
?> 	
	<!-- END DYNAMIC BLOCK: row -->
</table>

<!----------------------修改视窗---------------------------->
<div id=acc_window style="display: none;position:absolute">
	<FORM name="addUSER" action="" method="POST" target="_self" onSubmit="return Chk_acc();">
		<input type="hidden" NAME="uid" VALUE="<?=$uid?>">
		<input type="hidden" name="addNew" value="Y">
		<table width="250" border="0" cellspacing="1" cellpadding="2" bgcolor="#00558E">
			<tr>
				<td bgcolor="#FFFFFF">
					<table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="#A4C0CE" class="m_tab_fix">
						<tr bgcolor="#0163A2">
							<td id=r_title width="200"><font color="#FFFFFF">Người dùng mới</font></td>
							<td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
						</tr>
						<tr>
							<td colspan="2" height="1" bgcolor="#000000"></td>
						</tr>
						<tr>
							<td colspan="2">Số tài khoản&nbsp;&nbsp;
								<input type="text" name="e_user" value="" size="12" maxlength="10" class="za_text" onKeyPress="return ChkKeyCode();">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr>
							<td colspan="2">Mật khẩu&nbsp;&nbsp;
								<input type="password" name="e_pass" value="" size="12" maxlength="12" class="za_text" onKeyPress="return ChkKeyCode();">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr>
							<td colspan="2">Bí danh&nbsp;&nbsp;
								<input type="text" name="e_alias" value="" size="12" maxlength="10" class="za_text">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<input type="submit" value="OK" class="za_button">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</FORM>
</div>
<!----------------------修改视窗---------------------------->
</body>
</html>
<?
}
?>