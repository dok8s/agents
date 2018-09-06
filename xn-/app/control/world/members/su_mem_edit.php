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
$keys=$_REQUEST["keys"];
$mid=$_REQUEST["mid"];
$sql = "select Agname,ID,language from web_world where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$agname1=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
$credit=$row['Credit'];
require ("../../../member/include/traditional.zh-cn.inc.php");

if ($keys=='upd'){
	$gold=$_REQUEST["maxcredit"];
	$pasd=$_REQUEST["password"];
	$alias=$_REQUEST["alias"];
	$opentype=$_REQUEST["type"];
	$mem_line=$_REQUEST["mem_line"];

	$chk=chk_pwd($pasd);
	$maxcredit=$_REQUEST["maxcredit"]+0;

	$sql = "select agents,credit,pay_type from web_member where memname='".$_REQUEST[username]."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$agname=$row['agents'];
	$mysql="select credit from web_agents where agname='".$row['agents']."'";

	$bresult = mysql_query($mysql);
	$brow = mysql_fetch_array($bresult);
	$credit=$brow['credit']+0;

	$mysql="select sum(Credit) as credit from web_member where Agents='$agname' and status=1";
	$aresult = mysql_query($mysql);
	$arow = mysql_fetch_array($aresult);
	$abcdef=$arow['credit']+0;

	if ($row['pay_type']==1){
		$mysql="update web_member set oid='',lastpawd=adddate,Passwd='$pasd',Alias='$alias' where memname='$_REQUEST[username]'";
		mysql_query($mysql) or die ("error 1!");
		echo "<Script language=javascript>self.location='./ag_members.php?uid=$uid';</script>";
		exit;
	}

	if ($arow['credit']+$maxcredit-$row['credit']>$credit){
		echo wterror("此会员的信用额度为$maxcredit<br>目前代理商 最大信用额度为$credit<br>,所属代理累计信用额度为$abcdef<br>已超过代理商信用额度，请回上一面重新胔入");
		exit();
	}else{
		$mysql="select sum(betscore) as betscore from web_db_io where m_name='".$_REQUEST[username]."' and m_date='".date('Y-m-d')."'";
		$result = mysql_query($mysql);
		$row = mysql_fetch_array($result);
		$betscore=$row['betscore'];

		$money=$maxcredit-$betscore+0;
		if($money<0){
			echo wterror("此会员的原信用额度为$maxcredit<br>已投注信用额度为$betscore<br>,已超过限制，请回上一面重新胔入");
			exit;		
		}
		$mysql="update web_member set oid='',lastpawd=adddate,Credit=$maxcredit,money=$money,Passwd='$pasd',Alias='$alias' where memname='".$_REQUEST[username]."'";
		mysql_query($mysql) or die ("操作失败!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname1','密码更改','".$_REQUEST[username]."','会员',4)";
		mysql_query($mysql) or die ("操作失败!");
		echo "<Script language=javascript>self.location='su_members.php?uid=$uid';</script>";
	}
}else{
	$sql = "select * from web_member where ID=$mid";

	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	switch ($row['OpenType']){
	case "A":
		$type=1;
		break;
	case "B":
		$type=2;
		break;
	case "C":
		$type=3;
		break;
	case "D":
		$type=4;
		break;
	}

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_mem_ed {  background-color: #bdd1de; text-align: right}
.STYLE1 {color: #990000}
-->
</style>
<script language="javascript" src="/js/mem_edit.js"></script>
<SCRIPT>
function Chg_Mcy(a){
	curr=new Array();
	curr_now=new Array();


    if (document.all.ratio.value==''){
      tmp=document.all.currency.options[document.all.currency.selectedIndex].value;
	  ratio=eval(curr[tmp]);
      ratio_now=eval(curr_now[tmp]);
    }else{
	  ratio=eval(document.all.ratio.value);
      ratio_now=eval(document.all.ratio_now.value);
    }
    if (a=='mx')
    {
      tmp_count=ratio*eval(document.all.maxcredit.value);
      tmp_count=Math.round(tmp_count*100);
	  tmp_count=tmp_count/100;
      document.all.mcy_mx.innerHTML=tmp_count;
    }
    if (a=='now')
    {
      document.all.mcy_now.innerHTML=ratio_now;
    }
}

function onLoad()
 {
  //var obj_sagent_id = document.getElementById('aid');
  //obj_sagent_id.value = '{SAID}';
  var obj_type = document.getElementById('type');
  obj_type.value = '<?=$type?>';
 }

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("总信用额度仅能输入数字!!"); return false;}
}
</SCRIPT>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad();Chg_Mcy('now')">
<div id="Layer1" style="position:absolute; width:780px; height:48px; z-index:1; left: 0px; top: 297px; visibility: hidden; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000"></div>
 <FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="keys" VALUE="upd">
  <input type="hidden" name="aid" value="<?=$agid?>">
  <input type="hidden" name="currency" value="RMB">
  <input type="hidden" name="mid" value="<?=$row['ID']?>">
  <input type="hidden" name="pay_type" value="<?=$row['pay_type']?>">
  <input type="hidden" name="mem_line" value="<?=$type?>">
  <input type="hidden" name="ratio" value="<?=$row['ratio']?>">
  <input type="hidden" name="agents_id" value="<?=$agid?>">
  <input type="hidden" name="username" value="<?=$row['Memname']?>">
  <input type="hidden" name="pay" value="0">
  <input type="hidden" name="ratio_now" value="<?=$row['ratio']?>">
  <input type="hidden" name="old_aid" value="<?=$agid?>">
  <input type="hidden" name="uid" value="<?=$uid?>">
  <table width="770" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">&nbsp;&nbsp;<?=$mem_caption?></td>
      <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
  </table>
  <table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" ><?=$mem_accset?></td>
  </tr>
  <tr class="m_bc_ed">
    <td width="120" class="m_mem_ed"> <?=$sub_user?>:</td>
      <td><?=$row['Memname']?>
/ <font color =red>
<?=$row['loginname'];?>
</font></td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_mem_ed"><?=$sub_pass?>:</td>
      <td>
        <input type=PASSWORD name="password" size=12 maxlength=12 class="za_text" value="<?=$row['Passwd']?>">
        密码必须至少6个字元长，最多12个字元长，并只能有数字(0-9)，及英文大小写字母 </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_mem_ed"><?=$acc_repasd?>:</td>
      <td>
        <input type=PASSWORD name="repassword" size=12 maxlength=12 class="za_text" value="<?=$row['Passwd']?>">
      </td>
  </tr>
  <tr class="m_bc_ed">
      <td class="m_mem_ed"><?=$mem_name?>:</td>
      <td>
        <input type=TEXT name="alias" size=10 maxlength=10 class="za_text" value="<?=$row['Alias']?>">
      </td>
  </tr>
</table>
  <table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>
    <tr class="m_bc_ed">
      <td width="120" class="m_mem_ed"><?=$mem_otype?>:</td>
      <td>
        <select name="type" class="za_select" disabled>
          <option value="1">A<?=$mem_opentype?></option>
          <option value="2">B<?=$mem_opentype?></option>
          <option value="3">C<?=$mem_opentype?></option>
          <option value="4">D<?=$mem_opentype?></option>
        </select>      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed"><?=$rep_pay_type?>:</td>
      <td>
	  <table border="0" cellspacing="0" cellpadding=0>
	<tr>
		<td><?
		if ($row['pay_type']==0){
			echo $mem_credit;
		}else{
			echo $mem_moncredit;
		}
		?></td>
	</tr>
</table></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed"><?=$mem_radioset?>:</td>
      <td><?
	switch(strtoupper(trim($row['CurType']))){
	case 'HKD':
		echo $mem_radio_HKD;
		break;
	case 'USD':
		echo $mem_radio_USD;
		break;
	case 'MYR':
		echo $mem_radio_MYR;
		break;
	case 'SGD':
		echo $mem_radio_SGD;
		break;
	case 'THB':
		echo $mem_radio_THB;
		break;
	case 'GBP':
		echo $mem_radio_GBP;
		break;
	case 'JPY':
		echo $mem_radio_JPY;
		break;
	case 'EUR':
		echo $mem_radio_EUR;
		break;
	case 'RMB':
		echo $mem_current;
		break;
	case '':
		echo $mem_current;
		break;
	}
	?> ; <?=$mem_curradio?>:<font color="#FF0033" id="mcy_now"><?=$row['ratio']?></font>&nbsp;<?=$mem_radiored?></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed"><?=$mem_maxcredit?>:</td>
      <td><?
	if ($row[pay_type]==0){
	$credit=$row['Credit']*$row['ratio'];
?>
        <input type=TEXT name="maxcredit" value="<?=$credit?>" size=12 maxlength=12 class="za_text" onKeyUp="Chg_Mcy('mx');" onKeyPress="return CheckKey();">
<?
}else{
	$credit=$row['Money']*$row['ratio'];
	echo $credit;
}
?>&nbsp; &nbsp; &nbsp;         <?=$mem_current?>:<font color="#FF0033" id="mcy_mx"><?=$credit;?></font> </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">盘口玩法:</td>
      <td><span class="STYLE1">香港盘,马来盘,印尼盘,欧洲盘</span></td>
    </tr>
  </table>
	<table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr align="center" bgcolor="#FFFFFF">
      <td>
        <input type=SUBMIT name="OK2" value="<?=$submit_ok?>" class="za_button">
        &nbsp; &nbsp; &nbsp;
        <input type=BUTTON name="CANCEL2" value="<?=$submit_cancle?>" id="CANCEL" onClick="javascript:history.go(-1)" class="za_button">
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
