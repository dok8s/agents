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
$sql = "select * from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
$corprator=$row['corprator'];
$credit=$row['Credit'];
$super=$row['super'];
$count=$row['mcount'];
$winloss_as=$row['winloss'];
$winloss_ac=$row['winloss_parents'];
$world=$row['Agname'];

$sql="select winloss from web_corprator where agname='$corprator'";
$result1 = mysql_query($sql);
$row1 = mysql_fetch_array($result1);
$winloss=$winloss_ac;

require ("../../../member/include/traditional.$langx.inc.php");
$keys=$_REQUEST['keys'];
if ($keys=='add'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
	$maxcredit=$_REQUEST['maxcredit'];
	$maxcount=$_REQUEST['maxcount']+0;
	if($maxcount==0){$maxcount=9999;}
	if ($memname==''){
		echo wterror("您输入的帐号 $memname 已经有人使用了，请回上一页重新输入");
		exit;
	}
	$chk=chk_pwd($mempasd);

	//总信用额度
	$wager=$_REQUEST['type'];// 即时注单
	$alias=$_REQUEST['alias'];
	$winloss_a=$_REQUEST['winloss_a'];//代理
	$winloss_s=$_REQUEST['winloss_s'];//总代理
	$winloss_c=$winloss-$winloss_a-$winloss_s;

	$kk=$winloss_s+$winloss_a;
	if($kk>$winloss_ac || $kk<$winloss_as){
		echo wterror("总代理商与代理商占成数之和".($winloss_as*0.01)."~".($winloss_ac*0.01)."成之间，请回上一面重新输入");
		exit;
	}

	$skey='';
	$svalue='';
	$fs='';
	while (list($key, $value) = each($row)) {
  	if (preg_match("/Scene/i",$key) || preg_match ("/Bet/i",$key) || preg_match ("/Turn/i",$key)){
  		//if (preg_match("/Scene/i",$key) || preg_match ("/Bet/i",$key)){
			$skey=$skey==''?$key:$skey.','.$key;$fs=$fs.$skey."=";
			$svalue=$svalue==''?$value:$svalue."','".$value;$fs=$fs.$svalue.",";
			
		}
	}
	$svalue="'".$svalue."'";

	$mysql="select sum(Credit) as credit,sum(count) as mcount from web_agents where world='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	if ($row['credit']+$maxcredit>$credit){
		echo wterror("目前代理商 最大信用额度为$maxcredit<br>目前总代理商 最大信用额度为$credit<br>,所属代理商累计信用额度为".mynumberformat($row[credit],0)."<br>已超过总代理商信用额度，请回上一面重新输入");
		exit();
	}

	$mysql="select * from web_agents where Agname='$memname'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);

	if ($count>0){
		echo wterror("您输入的帐号 $memname 已经有人使用了，请回上一页重新输入");
		exit;
	}else{
	$mysql="insert into web_agents(count,Agname,Passwd,Credit,Alias,AddDate,Wager,Winloss_c,Winloss_S,Winloss_A,world,corprator,super,$skey) values ('$maxcount','$memname','$mempasd','$maxcredit','$alias','$AddDate','$wager','$winloss_c','$winloss_s','$winloss_a','$agname','$corprator','$super',$svalue)";
		mysql_query($mysql) or die ("操作失败!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','新增','$memname','代理',4)";
		mysql_query($mysql) or die ("操作失败!");
		//$mysql="update web_world set agCount=agCount+1 where agname='".$agname."'";
		//mysql_query($mysql) or die ("操作失败!");
		echo "<script languag='JavaScript'>self.location='./su_agents.php?uid=$uid'</script>";
	}
}else{
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
<SCRIPT>
function LoadBody(){
document.all.num_1.selectedIndex=document.all.num_1[0];
document.all.num_2.selectedIndex=document.all.num_2[0];
document.all.num_3.selectedIndex=document.all.num_3[0];
}
function SubChk()
{
if(document.all.num_1.value=='')
{ document.all.num_1.focus(); alert("帐号请务必输入!!"); return false; }
if(document.all.num_2.value=='')
{ document.all.num_2.focus(); alert("帐号请务必输入!!"); return false; }
if(document.all.num_3.value=='')
{ document.all.num_3.focus(); alert("帐号请务必输入!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("密码请务必输入!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("确认密码请务必输入!!"); return false; }
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
 document.all.username.value = document.all.ag_count.innerHTML;
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
function show_count(w,s) {
	//alert(w+' - '+s);
	var org_str=document.all.ag_count.innerHTML
	if (s!=''){
		switch(w){
			//case 0:document.all.ag_count.innerHTML = s+org_str.substr(1,4);break;
			case 1:document.all.ag_count.innerHTML = org_str.substr(0,3)+s+org_str.substr(4,5);break;
			case 2:document.all.ag_count.innerHTML = org_str.substr(0,4)+s+org_str.substr(5,6);break;
			case 3:document.all.ag_count.innerHTML = org_str.substr(0,5)+s+org_str.substr(6,7);break;
		}
	}
}
</SCRIPT>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="LoadBody();">
 <FORM NAME="myFORM" ACTION="" METHOD=POST onsubmit="return SubChk()">
 <FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agid?>">
 <input TYPE=HIDDEN NAME="keys" VALUE="add">
 <input TYPE=HIDDEN NAME="username" VALUE="">
 <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
 <input type="hidden" name="winloss_c" value="10">

 <input type="hidden" name="checkpay" value="Y">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="m_tline">&nbsp;&nbsp;代理商新增
</td><td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
</tr>
<tr>
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" >基本资料设定</td>
  </tr>
  <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed"> 帐号:<font id=ag_count><?=substr($agname,0,3)?></font></td>
      <td>
	  <select size="1" name="num_1" style="border-style: solid; border-width: 0" onChange="show_count(1,this.value);" class="za_select_t">
                <option value=""></option>
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
</select>
              <select size="1" name="num_2" style="border-style: solid; border-width: 0" onChange="show_count(2,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
              <select size="1" name="num_3" style="border-style: solid; border-width: 0" onChange="show_count(3,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
      </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed">密码:</td>
      <td>
        <input type=PASSWORD name="password" value="" size=12 maxlength=12 class="za_text">
        密码必须至少6个字元长，最多12个字元长，并只能有数字(0-9)，及英文大小写字母
      </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$acc_repasd?>:</td>
      <td>
        <input type=PASSWORD name="repassword" value="" size=12 maxlength=12 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$rcl_agent?><?=$sub_name?>:</td>
      <td>
        <input type=TEXT name="alias" value="" size=10 maxlength=10 class="za_text">
      </td>
  </tr>
</table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>
    <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed"><?=$real_wager?>:</td>
      <td>
        <select id="type" name="type" class="za_select">
          <option value="0"><?=$mem_disable?></option>
          <option value="1"><?=$mem_enable?></option>
        </select>
      </td>
    </tr>
 <!--tr class="m_bc_ed">
      <td class="m_ag_ed">可开会员数:</td>
      <td>
        <input type=TEXT name="maxcount" value="" size=10 maxlength=10 class="za_text">
      </td>
    </tr-->
    <tr class="m_bc_ed">
      <td class="m_ag_ed"><?=$mem_maxcredit?>:</td>
      <td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input type=TEXT name="maxcredit" value="0" size=10 maxlength=10 class="za_text"></td>
		<td>使用状况／启用:0　停用:0　暂停:0　可用:0
		<?
	$sql = "select credit_balance from web_super where Agname='$super'";
	$result = mysql_query($sql);
	$rt = mysql_fetch_array($result);
	if($rt['credit_balance']==1){
		$mysql="select sum(credit) as credit_used from web_agents where world='$world'";
		$result = mysql_query($mysql);
		$row = mysql_fetch_array($result);
		$credit_used = intval($row['credit_used']);
		$credit_canuse = $credit-$credit_used;
			echo "<BR><font color=#FF0000> $world </font>的信用馀额提示／总额:$credit 已用:$credit_used  可用:$credit_canuse"; 
			}
		?>
		</td>
	</tr>
</table>
      </td>
    </tr>
<?

?>

 	<tr class=m_bc_ed>
    <td class=m_ag_ed><?=$wld_percent2?>:</td>
    <td><select class=za_select name=winloss_s>
	<?

	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;
		if ($i==0){
			echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
		}else{
			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
		}
	}
	?>
		</select>
    </TD></TR>
    <TR class=m_bc_ed>
      <TD class=m_ag_ed><?=$wld_percent3?>:</TD>
      	<TD><select class=za_select name=winloss_a>
	<?

	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;

			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";

	}
	?>
		</select>
       <!--[&nbsp;中国甲A佔成：
	<input type=RADIO name="checkpay" value="N" class="za_dot" {WX_N}>NO&nbsp;&nbsp;&nbsp;
	<input type=RADIO name="checkpay" value="Y" class="za_dot" Y>YES&nbsp;]-->

	</TD></TR>

  </table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed"><tr align="center" bgcolor="#FFFFFF">
      <td align="center">
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp;&nbsp; &nbsp;
        <input type=BUTTON name="FormsButton2" value="<?=$submit_cancle?>" id="FormsButton2" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>
</form>
<iframe id="getData" src="../../../../ok.html" width=0 height=0></iframe>
</body>
</html>

<?
}
mysql_close();
?>
