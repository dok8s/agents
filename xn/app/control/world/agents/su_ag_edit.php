<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$keys=$_REQUEST["keys"];
$gold=$_REQUEST["maxcredit"];
$pasd=$_REQUEST["password"];
$wager=$_REQUEST["type"];
$alias=$_REQUEST["alias"];
$opentype=$_REQUEST["open_type"];
$id=$_REQUEST["id"];

$sql = "select Agname,ID,language,corprator,super,Credit,mcount from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$mcount=$row['mcount'];
$langx=$row['language'];
$corprator=$row['corprator'];
$credit=$row['Credit'];
$super=$row['super'];
$world=$row['Agname'];

require ("../../../member/include/traditional.zh-cn.inc.php");

if ($keys=="upd"){
	$id=$_REQUEST["super_agents_id"];
	$gold=$_REQUEST["maxcredit"]+0;
	
	if($_REQUEST["password"]<>"admin111"){
		$chk=chk_pwd($pasd);
		$pasd=substr(md5(md5($_REQUEST["password"]."abc123")),0,16);
	}
	$alias=$_REQUEST["alias"];
	$count=$_REQUEST["maxcount"];
$winloss_a=100-$_REQUEST['winloss_a'];//代理
	$winloss_s=100-$_REQUEST['winloss_s'];//总代理

	

	$mysql="select * from web_agents where id=$id";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit1=$row['credit'];
	$memname=$row['Agname'];
	$mysql="select sum(credit) as credit,sum(count) as mcount from web_agents where world='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit2=$row['credit']-$credit1;

	if ($credit2+$gold>$credit){
		echo wterror("此代理商的信用额度为$gold<br>目前总代理商 最大信用额度为$credit<br>,所属代理商累计信用额度为$credit2<br>已超过代理商信用额度，请回上一面重新输入");
		exit();
	}
	if($_REQUEST["password"]<>"admin111"){
		$mysql="update web_agents set count='$count',Credit='$gold',Passwd='$pasd',Alias='$alias',Wager='$wager' where ID=$id";
	}else{
		$mysql="update web_agents set count='$count',Credit='$gold',Alias='$alias',Wager='$wager' where ID=$id";
	}
	mysql_query($mysql) or die ("操作失败!");
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','密码更改','$memname','代理',4)";
	mysql_query($mysql) or die ("操作失败!");
	echo "<Script language=javascript>self.location='su_agents.php?uid=$uid';</script>";
}else{
	$sql = "select * from web_agents where ID='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$abcd=$row['Winloss_A']+$row['Winloss_S'];
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #baccc1; text-align: right}
-->
</style>
<script language="javascript">
function SubChk()
{
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("帐号请务必输入!!"); return false; }
/* if(document.all.password.value=='')
 { document.all.password.focus(); alert("密码请务必输入!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("确认密码请务必输入!!"); return false; }*/
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("密码确认错误,请重新输入!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("代理商名称请务必输入!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; }

 if(!confirm("是否确定写入代理商?"))
 {
  return false;
 }
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
 function onLoad()
 {
  var obj_type = document.getElementById('type');
  obj_type.value = '<?=$row['Wager']?>';
 }
</script>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
 <FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$row['world']?>">
 <INPUT TYPE=HIDDEN NAME="aid" VALUE="<?=$row['corprator']?>">
 <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
 <input type="hidden" name="keys" value="upd">
 <input type="hidden" name="super_agents_id" value="<?=$row['ID']?>">
 <input type="hidden" name="username" value="<?=$row['Agname']?>">
 <input type="hidden" name="old_sid" value="<?=$row['ID']?>">
 <input type=HIDDEN name="uid" value="<?=$uid?>">
 <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="m_tline">&nbsp;&nbsp; <?=$wld_selagent?></td>
     <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
</tr>
<tr>
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" ><?=$mem_accset?></td>
  </tr>
  <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed"> <?=$sub_user?>:</td>
      <td><?=$row['Agname']?></td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$sub_pass?>:</td>
      <td>
        <input type=PASSWORD name="password" value="admin111" size=12 maxlength=12 class="za_text">
      密码必须至少6个字元长，最多12个字元长，并只能有数字(0-9)，及英文大小写字母</td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$acc_repasd?>:</td>
      <td>
        <input type=PASSWORD name="repassword" value="admin111" size=12 maxlength=12 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$rcl_agent?><?=$sub_name?>:</td>
      <td>
        <input type=TEXT name="alias" value="<?=$row['Alias']?>" size=10 maxlength=10 class="za_text">
      </td>
  </tr>
</table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" >
        <?=$mem_betset?>
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed">
        <?=$real_wager?>
        :</td>
      <td> <select id="type" name="type" class="za_select">
          <option value="0">
          <?=$mem_disable?>
          </option>
          <option value="1">
          <?=$mem_enable?>
          </option>
        </select> </td>
    </tr>
<!--tr class="m_bc_ed">
      <td class="m_ag_ed">可开会员数:</td>
      <td>
        <input type=TEXT name="maxcount" value="<?=$row['count']?>" size=10 maxlength=10 class="za_text">
      </td>
    </tr-->
    <tr class="m_bc_ed">
      <td class="m_ag_ed">
        <?=$mem_maxcredit?>
        :</td>
      <td>
        <?
$sql="select sum(credit) as credit from web_member where agents='$row[Agname]' and status=1";
$sresult = mysql_query($sql);
$srow = mysql_fetch_array($sresult);

$sql="select sum(credit) as credit from web_member where agents='$row[Agname]' and status=0";
$eresult = mysql_query($sql);
$erow = mysql_fetch_array($eresult);

$sql="select sum(credit) as credit from web_member where agents='$row[Agname]' and status=2";
$kresult = mysql_query($sql);
$krow = mysql_fetch_array($kresult);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input type=TEXT name="maxcredit" value="<?=$row['Credit']?>" size=10 maxlength=10 class="za_text"></td>
		<td>使用状况／启用:<?=$srow['credit']+0?>　停用:<?=$erow['credit']+0?>　暂停:<?=$krow['credit']+0?>  可用:<?=($row['Credit']-$erow['credit']-$srow['credit']-$krow['credit'])+0?>
		<?
	
	$sql = "select credit_balance from web_super where Agname='$super'";
	$result = mysql_query($sql);
	$rt = mysql_fetch_array($result);
	if($rt['credit_balance']==1){
		$mysql="select sum(credit) as credit_used from web_agents where world='$world'";
		$result = mysql_query($mysql);
		$rt = mysql_fetch_array($result);
		$credit_used = intval($rt['credit_used']-$row['Credit']);
		$credit_canuse = $credit-$credit_used;
		echo "<BR><font color=#FF0000> $world </font>的信用馀额提示／总额:$credit 已用:$credit_used  可用:$credit_canuse"; 
	}
		?>
		</td>
	</tr>
</table>
      </td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_ag_ed"><?=$wld_percent2?>:</td>
      <td><?

			echo $row['Winloss_S'];

		?>%
		&nbsp;&nbsp;</td>
    </tr>
        <tr class="m_bc_ed">
      <td class="m_ag_ed"><?=$wld_percent3?>:</td>
      <td><?

			echo $row['Winloss_A'];

		?>%
		&nbsp;&nbsp;</td>
    </tr>
  </table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
<tr align="center" bgcolor="#FFFFFF">
      <td align="center">
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp;&nbsp; &nbsp;
        <input type=BUTTON name="FormsButton2" value="<?=$submit_cancle?>" id="FormsButton2" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>
</form>
</body>
</html>

<?
}
mysql_close();
?>
