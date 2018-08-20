<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$addNew=$_REQUEST["addNew"];
$deluser=$_REQUEST["deluser"];
$edituser=$_REQUEST["edituser"];
$edituser1=$_REQUEST["edituser1"];

$mysql="select Agname,ID,language,super,corprator,world from web_agents where Oid='$uid'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$super=$row['super'];
$corprator=$row['corprator'];
$world=$row['world'];
$agid=$row['ID'];

if ($deluser=='Y'){
	$id=intval($_REQUEST['id']);
	$mysql111="select Agname from web_agents where ID='$id'";
	$result111 = mysql_query($mysql111);
	$row111 = mysql_fetch_array($result111);
	$mysql="delete from web_agents where ID='$id'";
	$result = mysql_query($mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','删除','".$row111["Agname"]."','代理商',5)";
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
	$mysql="select id from web_agents where Agname='$new_user' or passwd_safe='$new_user'";


	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if($edituser1<>"Y"){
		if ($cou>0){
			echo "<script language=javascript>alert('帐号名称已被他人使用!');document.location='./su_subuser.php?uid=$uid';</script>";
			exit;
		}
	}
	if($_REQUEST["e_pass"]<>"admin111"){
		$mysql="update web_agents set agname='$new_user',passwd='$new_pass',alias='$new_alias' where ID=".$_REQUEST["id"];
		
	}else{
		$mysql="update web_agents set agname='$new_user',alias='$new_alias' where ID=".$_REQUEST["id"];
	}
	$result = mysql_query($mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','修改密码','".$new_user."','代理商',5)";
	mysql_query($mysql) or die ("操作失败!");
	echo "<script language=javascript>document.location='./ag_subuser.php?uid=$uid';</script>";
}
if ($addNew=='Y'){
	$new_user=$_REQUEST["e_user"];
	$new_pass=substr(md5(md5($_REQUEST["e_pass"]."abc123")),0,16);
	$new_alias=$_REQUEST["e_alias"];
	$AddDate=date('Y-m-d H:i:s');

	$chk=chk_pwd($new_pass);

	$mysql="select id from web_agents where Agname='$new_user' or passwd_safe='$new_user'";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mysql="insert into web_agents(Agname,Passwd,Alias,subuser,subname,AddDate,super,corprator,world) values('$new_user','$new_pass','$new_alias','1','$agname','$AddDate','$super','$corprator','$world')";
		mysql_query($mysql) or die ("操作失败!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','新增','".$new_user."','代理商',5)";
		mysql_query($mysql) or die ("操作失败!");
		echo "<Script language=javascript>self.location='ag_subuser.php?uid=$uid';</script>";
	}else{
		$msg=wterror('您添加的子帐号已经存在，请重新输入！！');
		echo $msg;
		exit;
	}
}else{
	$sql = "select * from web_agents where subname='$agname' and subuser=1 order by ".$sort." ".$orderby;
	$result = mysql_query($sql);

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" type="text/css">
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
<ul class="list-group">
    <li class="list-group-item active">
        <a style="color:#ffffff;padding-right: 5px;" href="/app/control/agents/members/ag_members.php?uid=<?=$uid?>"
           target="main" onMouseOver="window.status='会员'; return true;" onMouseOut="window.status='';return true;"><font>会员</font></a>
        |
        <a style="color:#7E1414;padding-left: 5px;" href="/app/control/agents/ag_subuser.php?uid=<?=$uid?>"
           target="main" onMouseOver="window.status='子账号'; return true;" onMouseOut="window.status='';return true;"><font>子账号</font></a>
    </li>
</ul>
<FORM NAME="myFORM" ACTION="/app/control/agents/members/ag_members.php?uid=<?=$uid?>" METHOD=POST>
    <input type="hidden" name="agent_id" value="28752">
    <table width="1024" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
        <tr>
            <td>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td nowrap>&nbsp;&nbsp;排序&nbsp;:&nbsp;</td>
                        <td>
                            <select id="sort" name="sort" onChange="document.myFORM.submit();" class="za_select">
                                <option value="username">帐号</option>
                                <option value="adddate">新增日期</option>
                            </select>
                            <select id="orderby" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                                <option value="asc">升幂(由小到大)</option>
                                <option value="desc">降幂(由大到小)</option>
                            </select>
                        </td>
                        <td nowrap>&nbsp;--&nbsp;总页数&nbsp;:&nbsp;</td>
                        <td>
                            <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
                                <option value="0">1</option>
                            </select>
                        </td>
                        <td nowrap>&nbsp;/&nbsp;1&nbsp;页&nbsp;--&nbsp;</td>
                        <td>
                            <button type="button" class="btn btn-success" onClick="show_win();">新增</button>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <div class="container-fluid">
            <div class="row-fluid">
                <table class="table" style="width: 70%;margin-left:20px;">
                    <thead>
                    <tr style="background: #F4F1F1;height: 30px;">
                        <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
                            帐号
                        </th>
                        <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
                            登录帐号
                        </th>
                        <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
                            密码
                        </th>
                        <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
                            名称
                        </th>
                        <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
                            新增日期
                        </th>
                        <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:20%">
                            功能
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $cou=mysql_num_rows($result);
                    if ($cou==0){
                        ?>
                        <FORM NAME="AG_<?=$agid?>" ACTION="" METHOD=POST target='_self'>
                            <INPUT TYPE="HIDDEN" NAME="id" value="<?=$agid?>">
                            <INPUT TYPE="HIDDEN" NAME="edituser" value="Y">
                            <input TYPE="HIDDEN" NAME="uid" VALUE="<?=$uid?>">		<input type="hidden" NAME="act" value="2">
                            <input type="hidden" NAME="e_user" VALUE="未搜寻到指定相关资料">
                            <tr class="m_cen">
                                <td>未搜寻到指定相关资料</td>
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
                                    <td align="left"><a onClick="javascript:ChkData('<?=$row['ID']?>')" style="cursor:hand;">修改</a> / <a href="javascript:CheckDEL('./ag_subuser.php?uid=<?=$uid?>&deluser=Y&id=<?=$row['ID']?>')">删除</a></td>
                                </tr>
                            </FORM>
                            <?
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </table>
</form>

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
							<td id=r_title width="200"><font color="#FFFFFF">新增使用者</font></td>
							<td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
						</tr>
						<tr>
							<td colspan="2" height="1" bgcolor="#000000"></td>
						</tr>
						<tr>
							<td colspan="2">帐　号&nbsp;&nbsp;
								<input type="text" name="e_user" value="" size="12" maxlength="10" class="za_text" onKeyPress="return ChkKeyCode();">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr>
							<td colspan="2">密　码&nbsp;&nbsp;
								<input type="password" name="e_pass" value="" size="12" maxlength="12" class="za_text" onKeyPress="return ChkKeyCode();">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr>
							<td colspan="2">别　名&nbsp;&nbsp;
								<input type="text" name="e_alias" value="" size="12" maxlength="10" class="za_text">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<input type="submit" value="确定" class="za_button">
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
<style>
    .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
        z-index: 2;
        color: #fff;
        background-color: #c12e36;
        border-color: #c12e36;
    }

    .list-group-item:first-child {
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
    }
    .za_select {
        font-family: "Arial";
        font-size: 15px;
        height: 30px;
    }
</style>
<?
}
?>
<?
mysql_close();
?>
