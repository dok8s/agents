<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$keys=$_REQUEST["keys"];
$mid=$_REQUEST["mid"];
$sql = "select Agname,ID,language,Credit from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$sql = "SELECT * FROM web_system ";
$result = mysql_query($sql);
$sysconf = mysql_fetch_array($result);

$agname=$row['Agname'];
$agid=$row['ID'];
$langx='zh-cn';
$credit=$row['Credit'];
require ("../../../member/include/traditional.$langx.inc.php");

if ($keys=='upd'){
	$gold=$_REQUEST["maxcredit"];
	$pasd=$_REQUEST["password"];
	$alias=$_REQUEST["alias"];
	$opentype=$_REQUEST["type"];
	$mem_line=$_REQUEST["mem_line"];
	$chk=chk_pwd($pasd);

	$maxcredit=$_REQUEST["maxcredit"]+0;

	$sql = "select * from web_member where memname='".$_REQUEST[username]."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	$mysql="select sum(Credit) as credit from web_member where Agents='$agname' and status=1";
	$aresult = mysql_query($mysql);
	$arow = mysql_fetch_array($aresult);
	$abcdef=$arow[credit]-$row[Credit];

	if($sysconf['setmin']==1 && $_POST['mem_max_edit']=='yes'){
		$mysql="update web_member set m='$_POST[SC1]',r='$_POST[SC2]',ou='$_POST[SC3]',pd='$_POST[SC4]',t='$_POST[SC5]',f='$_POST[SC6]',p='$_POST[SC7]',fs='$_POST[SC8]',`max`='$_POST[SC9]' where memname='$_REQUEST[username]'";
		mysql_query($mysql) or die ("error 2");
	}

	if ($row['pay_type']==1){
		$mysql="update web_member set oid='',lastpawd=adddate,Passwd='$pasd',Alias='$alias' where memname='$_REQUEST[username]'";
		mysql_query($mysql) or die ("error 1!");
		echo "<Script language=javascript>self.location='./ag_members.php?uid=$uid';</script>";
		exit;
	}

	if ($arow['credit']+$maxcredit-$row['Credit']>$credit){
		echo wterror("此会员的信用额度为$maxcredit<br>目前代理商 最大信用额度为$credit<br>,所属会员累计信用额度为$abcdef<br>已超过代理商信用额度，请回上一面重新输入");
		exit();
	}else{
		$mysql="select sum(betscore) as betscore from web_db_io where m_name='".$_REQUEST[username]."' and m_date='".date('Y-m-d')."'";
		$result = mysql_query($mysql);
		$row = mysql_fetch_array($result);
		$betscore=$row['betscore'];

		$money=$maxcredit-$betscore+0;
		if($money<0){
			echo wterror("此会员的原信用额度为$maxcredit<br>已投注信用额度为$betscore<br>,已超过限制，请回上一面重新输入");
			exit;		
		}

		$mysql="update web_member set oid='',Credit='$maxcredit',money='$money',Passwd='$pasd',Alias='$alias' where memname='".$_REQUEST[username]."'";
		mysql_query($mysql) or die ("操作失败!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','密码更改','".$_REQUEST[username]."','会员',5)";
		mysql_query($mysql) or die ("操作失败!");

		echo "<Script language=javascript>self.location='./ag_members.php?uid=$uid';</script>";
	}
}else{
	$sql = "select * from web_member where ID='$mid'";

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
	default:
		$type=4;
		break;
	}

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<script src="/idz_indeziner/scriptaculous/lib/prototype.js" type="text/javascript"></script>
<script src="/idz_indeziner/scriptaculous/src/effects.js" type="text/javascript"></script>
<script type="text/javascript" src="/idz_indeziner/validation.js"></script>
<link title="style1" rel="stylesheet" href="/idz_indeziner/style.css" type="text/css" />
<link title="style2" rel="alternate stylesheet" href="/idz_indeziner/style2.css" type="text/css" />
<link title="style3" rel="alternate stylesheet" href="/idz_indeziner/style3.css" type="text/css" />
<style type="text/css">
<!--
.m_mem_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
    <style>
        .list-group {
            padding-left: 0;
            margin-bottom: 20px;
        }
        .list-group-item:first-child {
            border-top-right-radius: 0px;
            border-top-left-radius: 0px;
        }
        .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
            z-index: 2;
            color: #fff;
            background-color: #c12e36;
            border-color: #c12e36;
        }
        a:link {
            text-decoration: none;
        }
    </style>
<script language="javascript" src="/js/mem_edit.js"></script>
<script language="javascript" src="/js/set_odd_f.js"></script>
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
	document.getElementById('type').value = '<?=$type?>';
	show_Line_Date();
}

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("总信用额度仅能输入数字!!"); return false;}
}
</SCRIPT>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad();Chg_Mcy('now')">
<ul class="list-group">
    <li class="list-group-item active" style="
    position: relative;
    display: block;
    padding: 10px 15px;
    font-size: 14px;">
        <a style="color:#ffffff;padding-right: 5px;" href="/xn/app/control/agents/members/ag_members.php?uid=<?=$uid?>"
           target="main" onMouseOver="window.status='会员'; return true;" onMouseOut="window.status='';return true;"><font>会员</font></a>
        >><span>修改会员</span>
    </li>
</ul>
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
     <div class="form_content">
     <form id="test" action="#" method="get">
         <fieldset>
             <legend>基本资料设定</legend>
             <div class="form-row">
                 <div class="field-label"><label for="field1"><?=$sub_user?>:</label></div>
                 <div class="field-widget">
                     <font id="ag_count"><?=$row['Memname']?></font>
                     /
                     <font color =red><?=$row['loginname'];?></font>
                 </div>
             </div>

             <div class="form-row">
                 <div class="field-label"><label for="field7"><?=$sub_pass?></label>:</div>
                 <div class="field-widget">
                     <input value="<?=$row['Passwd']?>" type="password" name="password" id="password" class="required validate-password" title="Enter a password greater than 6 characters" />
                 </div>
                 <div class="field-widget" style="color:red;">密码必须至少6个字元长，最多12个字元长，并只能有数字(0-9)，及英文大小写字母</div>

             </div>


             <div class="form-row">
                 <div class="field-label"><label for="field9"><?=$acc_repasd?></label>:</div>
                 <div class="field-widget"><input value="<?=$row['Passwd']?>" type="password" name="repassword" id="repassword" class="required validate-password-confirm" title="Enter the same password for confirmation" /></div>
             </div>

             <div class="form-row">
                 <div class="field-label"><label for="field2"><?=$mem_name?></label>:</div>
                 <div class="field-widget"><input value="<?=$row['Alias']?>" name="alias" id="alias" class="required" title="请输入会员名称！" /></div>
             </div>

         </fieldset>
         <fieldset>
             <legend>下注资料设定</legend>
             <div class="form-row">
                 <div class="field-label"><label for="field4"><?=$mem_maxcredit?></label>:</div>
                 <div class="field-widget">
                     <?
                     if ($row[pay_type]==0){
                         $credit=$row['Credit']*$row['ratio'];
                         ?>
                         <input type=TEXT name="maxcredit" value="<?=$credit?>" size=12 maxlength=12 class="za_text" onKeyUp="Chg_Mcy('mx');" onKeyPress="return CheckKey();">
                         <?
                     }else{
                         $credit=$row['Money']*$row['ratio'];
                         echo $credit;
                     }
                     ?>&nbsp; &nbsp; &nbsp;         <?=$mem_current?>:<font color="#FF0033" id="mcy_mx"><?=$credit;?></font>
                 </div>
                 美金:<font color="#FF0033" id="mcy_mx">0</font>
             </div>

             <div class="form-row">
                 <div class="field-label"><label for="field5">盘口玩法</label>:</div>
                 <div class="field-widget"><span id=show_cb></span></div>
             </div>
             <div class="form-row">
                 <div class="field-label"><label for="field6"><?=$mem_otype?></label>:</div>
                 <div class="field-widget">
                     <select id="type" name="type" class="validate-selection" title="Choose your department" onChange="show_count(0,this.value);" disabled>
                         <option value="">请选择</option>
                         <option value="1">A<?=$mem_opentype?></option>
                         <option value="2">B<?=$mem_opentype?></option>
                         <option value="3">C<?=$mem_opentype?></option>
                         <option value="4">D<?=$mem_opentype?></option>
                     </select>
                 </div>
             </div>
             <div class="form-row">
                 <div class="field-label"><label for="field6"><?=$mem_radioset?></label>:</div>
                 <div class="field-widget">
                     <?
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
                     ?> ; <?=$mem_curradio?>:<font color="#FF0033" id="mcy_now"><?=$row['ratio']?></font>&nbsp;<?=$mem_radiored?>
                 </div>
             </div>

             <div class="form-row-select">
                 <fieldset>
                     <legend class="optional"><?=$rep_pay_type?></legend>
                     <label class="left">
                         <?
                         if ($row['pay_type']==0){
                             echo $mem_credit;
                         }else{
                             echo $mem_moncredit;
                         }
                         ?>
                     </label>
                 </fieldset>

             </div>

         </fieldset>
         <input type="submit" class="submit" value="确认" /> <input class="reset" type="button" value="取消" onclick="valid.reset(); return false" />
     </form>
     </div>
<? if($sysconf['setmin']==1) { ?>
<? } ?>
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
<SCRIPT>
var odd_f='H,M,I,E';
var Format=new Array();
Format[0]=new Array('H','香港盘','Y');
Format[1]=new Array('M','马来盘','Y');
Format[2]=new Array('I','印尼盘','Y');
Format[3]=new Array('E','欧洲盘','Y');
</SCRIPT>

<? 
}
?>
