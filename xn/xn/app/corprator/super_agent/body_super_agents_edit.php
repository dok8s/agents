<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$mid=$_REQUEST["id"];
$sql = "select Agname,ID,language,credit,super from web_corprator where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$langx=$row['language'];
$agname=$row['Agname'];
$credit=$row['credit'];
$mcount=$row['mcount'];
$super=$row['super'];
$corprator=$row['Agname'];


require ("../../member/include/traditional.$langx.inc.php");

$keys=$_REQUEST['keys'];
if ($keys=='upd'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	if($_REQUEST['password']<>""){
		$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
		$chk=chk_pwd($_REQUEST['password']);
	}
	$maxcredit=$_REQUEST['maxcredit']+0;
	$alias=$_REQUEST['alias'];
	

	$memcount=$_REQUEST['maxmember'];

	if($memcount==''){$memcount=99999;}

	$mysql="select credit,Agname from web_world where id=$mid";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit1=$row['credit'];
	$memname1=$row["Agname"];
	$mysql="select sum(credit) as credit from web_world where corprator='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit2=$row['credit']-$credit1;
	if ($credit2+$maxcredit>$credit){
		echo wterror("此总代理商的信用额度为$maxcredit<br>目前股东 最大信用额度为$credit<br>,所属总代理商累计信用额度为$credit2<br>已超过股东信用额度，请回上一面重新输入");
		exit();
	}else{
		if($_REQUEST['password']<>""){
			$mysql="update web_world set passwd='$mempasd',Credit='$maxcredit',Alias='$alias' where id=$mid";
		}else{
			$mysql="update web_world set Credit='$maxcredit',Alias='$alias' where id=$mid";
		}

		mysql_query($mysql) or die ("操作失败!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','密码更改','$memname1','总代理',3)";
		mysql_query($mysql) or die ("操作失败!");
		echo "<script languag='JavaScript'>self.location='body_super_agents.php?uid=$uid'</script>";
	}
}else{
	$sql = "select * from web_world where ID=$mid";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_suag_ed {  background-color: #D3C9CB; text-align: right}
-->
</style>
<SCRIPT>
<!--
function SubChk()
{
// if(document.all.username.value=='')
// { document.all.username.focus(); alert("<?=$mem_alert1?>"); return false; }
/* if(document.all.password.value=='' )
 { document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }*/
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("总代理名称请务必输入!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("总代理信用额度请务必输入!!"); return false; }
// if(document.all.winloss_s.value=='')
// { document.all.winloss_s.focus(); alert("请选择总代理商佔成数!!"); return false; }
// if (eval(document.all.winloss_c.value) > eval(document.all.winloss_s.value))
// { document.all.winloss_s.focus(); alert("总代理商佔成数超过股东佔成数!!"); return false; }
 if(!confirm("是否确定写入总代理?"))
 {
  return false;
 }
}


 function onLoad()
 {
  var obj_type_id = document.getElementById('type');
  obj_type_id.value = '';
 }
// -->
</SCRIPT>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<FORM NAME="myFORM" ACTION="body_super_agents_edit.php" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
 <INPUT TYPE=HIDDEN NAME="adddate" VALUE="">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="upd">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
  <input TYPE=HIDDEN NAME="s_type" VALUE="">
  <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
  <input TYPE=HIDDEN NAME="winloss_c" VALUE="10">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="">&nbsp;&nbsp;<?=$cor_agents?>--<?=$mem_addnewuser?></td>

</tr>
<tr>
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" ><?=$mem_accset?></td>
  </tr>
<!--
  <tr class="m_bc_ed">
    <td width="120" class="m_suag_ed">身份:</td>
    <td>
      <select name="type" class="za_select">
        <option value="1">股东</option>
        <option value="2">总代理 ／半退</option>
        <option value="3">总代理 ／全退</option>
        <option value="8">外调</option>
      </select>
    </td>
  </tr>
-->
<input type="HIDDEN" value="" name="type">
  <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120"> <?=$sub_user?>:</td>
    <td>
      <?=$row['Agname']?>
    </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$sub_pass?>:</td>
    <td>
      <input type=PASSWORD name="password" value="" size=12 maxlength=12 class="za_text">
    密码必须至少6个字元长，最多12个字元长，并只能有数字(0-9)，及英文大小写字母</td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$acc_repasd?>:</td>
    <td>
      <input type=PASSWORD name="repassword" value="" size=12 maxlength=12 class="za_text">
    </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$cor_name1?>:</td>
    <td>
      <input type=TEXT name="alias" value="<?=$row['Alias']?>" size=10 maxlength=10 class="za_text">
    </td>
  </tr>
</table>

  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120"><?=$mem_maxcredit?>:</td>
      <td>
<?
$sql="select sum(credit) as credit from web_agents where world='$row[Agname]' and status=1";
$sresult = mysql_query($sql);
$srow = mysql_fetch_array($sresult);

$sql="select sum(credit) as credit from web_agents where world='$row[Agname]' and status=0";
$eresult = mysql_query($sql);
$erow = mysql_fetch_array($eresult);
$sql="select sum(credit) as credit from web_agents where world='$row[Agname]' and status=2";
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
		$mysql="select sum(credit) as credit_used from web_world where corprator='$corprator'";
		$result = mysql_query($mysql);
		$rt = mysql_fetch_array($result);
		$credit_used = intval($rt['credit_used']-$row['Credit']);
		$credit_canuse = $credit-$credit_used;
		echo "<BR><font color=#FF0000> $corprator </font>的信用馀额提示／总额:$credit 已用:$credit_used  可用:$credit_canuse"; 
	}
		?>
		</td>
	</tr>
</table>

      </td>

        <!--input type=TEXT name="maxcredit" value="<?=$row['Credit']?>" size=10 maxlength=10 class="za_text">
        <?=$mem_status?>／<?=$mem_enable?>:0　<?=$mem_disable?>:0　<?=$mem_havecredit?>:0 </td-->
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">总代理商佔成上限:</td>
      <td>
        <?=$row['winloss_parents']?>%</td>
    </tr>
		<tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">总代理商佔成下限:</td>
      <td>
        <?=$row['winloss']?>%</td>
    </tr>
  <!--tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">会员数:</td>
      <td>
        <input type=TEXT name="maxmember" value="<?=$row['mcount']?>" size=10 maxlength=10 class="za_text">
         </td>
    </tr-->
    <tr class="m_bc_ed" align="center">
      <td colspan="2">
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp; &nbsp; &nbsp;
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
