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
$sql = "select id,subuser,agname,subname,status,super,setdata from web_world where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$super=$row['super'];
$d1set = @unserialize($row['setdata']);
$level=$_REQUEST['level']?$_REQUEST['level']:3;

$keys=$_REQUEST["keys"];
$gold=$_REQUEST["maxcredit"];
$pasd=$_REQUEST["password"];
$wager=$_REQUEST["type"];
$alias=$_REQUEST["alias"];
$opentype=$_REQUEST["open_type"];
$id=$_REQUEST["id"];

$sql = "select Agname,ID,language,super,Credit,Agname from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agname1=$row['Agname'];

$mysql="select credit,world from web_agents where id='$id'";

$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$credit1=$row['credit'];
$world=$row['world'];


$mysql="select id,agname,credit,mcount,winloss from web_world where agname='$world'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$mcount1=$row['mcount'];
$agname=$row['agname'];
$agid=$row['id'];
$credit=$row['credit'];
$abcd=100-$row['winloss'];

$langx='zh-cn';
require ("../../../member/include/traditional.zh-vn.inc.php");


if ($keys=="upd"){

	$id=$_REQUEST["super_agents_id"];
	$gold=$_REQUEST["maxcredit"]+0;
	if($_REQUEST["password"]<>"admin111"){
		$pasd=substr(md5(md5($_REQUEST["password"]."abc123")),0,16);
		$chk=chk_pwd($pasd);
	}
	$alias=$_REQUEST["alias"];
	$winloss_a=100-$_REQUEST['winloss_a'];
	$winloss_s=100-$_REQUEST['winloss_s'];
	$winloss_c=$abcd-$winloss_a-$winloss_s;
	$mcount=$_REQUEST["maxmember"];

	

	$mysql="select credit,world ,Agname from web_agents where id='$id'";

	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit1=$row['credit'];
	$world=$row['world'];
	$memname1=$row["Agname"];


	$mysql="select credit,mcount from web_world where agname='$world'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$mcount1=$row['mcount'];
/*
	if ($mcount>$mcount1){
		echo wterror("已超过总代理商人数限制，请回上一面重新输入");
		exit();
	}

	$mysql="select count(*) as cou from web_member where world='$agents_id'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	if ($row['cou']+$mcount>$mcount1){
		echo wterror("目前代理商 可用人数 已超过总代理商可用人数，请回上一面重新输入");
		exit();
	}
*/

	$mysql="select sum(credit) as credit from web_agents where world='$world'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
/*	if ($row['mcount']+$maxmember>$mcount){
		echo wterror("目前代理商 可用人数 已超过总代理商可用人数，请回上一面重新输入");
		exit();
	}
*/
	$credit2=$row['credit']-$credit1;
	if ($credit2+$gold>$credit){
		echo wterror("Hạn mức tín dụng của đại lý này là$gold<br>Hiện tại, giới hạn tín dụng tối đa của tổng đại lý là$credit<br>,Giới hạn tín dụng tích lũy của đại lý là$credit2<br>Đã vượt quá giới hạn tín dụng đại lý, vui lòng quay lại và nhập lại");
		exit();
	}else{
		if($_REQUEST["password"]<>"admin111"){
			$mysql="update web_agents set Credit='$gold',Passwd='$pasd',Alias='$alias',Wager='$wager' where ID=$id";
		}else{
			$mysql="update web_agents set Credit='$gold',Alias='$alias',Wager='$wager' where ID=$id";
		}
		mysql_query($mysql) or die ("Thao tác thất bại!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname1','密码更改','$memname1','代理商',3)";
		mysql_query($mysql) or die ("Thao tác thất bại!");
		echo "<Script language=javascript>self.location='su_agents.php?uid=$uid';</script>";
	}
}else{
	$sql = "select * from web_agents where ID='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$world = $row['world'];
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
<SCRIPT language="javascript" src="/js/ag_edit.js"></SCRIPT>
<script language="javascript">
 function onLoad()
 {
  //var obj_super_agents_id = document.getElementById('super_agents_id');
  //obj_super_agents_id.value = '<?=$row['ID']?>';
  //var obj_winloss_s = document.getElementById('winloss_s');
  //obj_winloss_s.value = '<?=$row['Winloss_S']?>';
  //var obj_winloss_a = document.getElementById('winloss_a');
  //obj_winloss_a.value = '<?=$row['Winloss_A']?>'; oncontextmenu="window.event.returnValue=false"
  var obj_type = document.getElementById('type');
  obj_type.value = '<?=$row['Wager']?>';
 }
</script>
</head>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/account_management.css" type="text/css">
<link rel="stylesheet" href="/style/control/edit_agents2.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<script>
    var uid='<?=$uid?>';
    var level='<?=$level?>';
    function ch_level(i)
    {
        if(i === 2) {
            self.location = '/app/control/world/su_list.php?uid='+uid+'&level='+i;;
        } else if(i === 3) {
            self.location = '/app/control/world/agents/su_agents.php?uid='+uid+'&level='+i;
        } else if(i === 4) {
            self.location = '/app/control/world/members/su_members.php?uid='+uid+'&level='+i;
        } else if(i === 6) {
            self.location = '/app/control/world/wager_list/wager_add.php?uid='+uid+'&level='+i;
        } else if(i === 5) {
            self.location = '/app/control/world/su_subuser.php?uid=='+uid+'&level='+i;
        }else {
            self.location = '/app/control/world/wager_list/wager_hide.php?uid='+uid+'&level='+i;
        }

    }
</script>

<link rel="stylesheet" href="../css/loader.css" type="text/css">
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann" style="position: relative;">
    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">Đại lý tổng hợp</div>
    <div id="general_btn1" class="<? if ($level == 3) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(3);">Đại lý</div>
    <div id="important_btn1" class="<? if ($level == 4) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(4);">Thành viên</div>
    <div id="general_btn2" class="<? if ($level == 5) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(5);">Tài khoản phụ</div>
    <? if($d1set['d1_wager_add']==1){ ?>
        <div id="general_btn3" class="<? if ($level == 6) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(6);">Thêm tài khoản</div>
    <? } ?>
    <? if($d1set['d1_wager_hide']==1){ ?>
        <div id="general_btn4" class="<? if ($level == 7) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(7);">Tài khoản ẩn</div>
    <? } ?>
</div>
 <FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return ag_SubChk()" style="padding-left:20px;padding-top:10px;">
 <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$row['world']?>">
 <INPUT TYPE=HIDDEN NAME="aid" VALUE="<?=$row['corprator']?>">
 <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
 <input type="hidden" name="keys" value="upd">
 <input type="hidden" name="super_agents_id" value="<?=$row['ID']?>">
 <input type="hidden" name="username" value="<?=$row['Agname']?>">
 <INPUT TYPE=HIDDEN NAME="winloss_s" id="winloss_s">
 <INPUT TYPE=HIDDEN NAME="winloss_a" id="winloss_a">

 <input type="hidden" name="old_sid" value="<?=$row['ID']?>">
 <input type=HIDDEN name="uid" value="<?=$uid?>">
 <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="">&nbsp;&nbsp; <?=$wld_selagent?></td>
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
          Mật khẩu phải dài ít nhất 6 ký tự, dài tối đa 12 ký tự và chỉ có thể có số (0-9) và chữ hoa và chữ thường tiếng Anh. </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$acc_repasd?>:</td>
      <td>
        <input type=PASSWORD name="repassword" value="admin111" size=12 maxlength=12 class="za_text">

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
    <tr class="m_bc_ed">
      <td class="m_ag_ed"><?=$mem_maxcredit?>:</td>
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
		<td>Sử dụng / bật:<?=$srow['credit']+0?>　Tắt:<?=$erow['credit']+0?>　Tạm ngưng:<?=$krow['credit']+0?>  Có sẵn:<?=($row['Credit']-$erow['credit']-$srow['credit']-$krow['credit'])+0?>
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
			echo "<BR><font color=#FF0000> $world </font>Giới hạn / lời nhắc giới hạn tín dụng:$credit Đã sử dụng:$credit_used  Có sẵn:$credit_canuse";
	}
		?>
		</td>
	</tr>

</table>
      </td>
    </tr>
<!--tr class="m_bc_ed">
      <td class="m_ag_ed">Số thành viên có thể mở:</td>
      <td>
        <input type=TEXT name="maxmember" value="<?=$row['count']?>" size=10 maxlength=10 class="za_text">
      </td>
    </tr-->
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
