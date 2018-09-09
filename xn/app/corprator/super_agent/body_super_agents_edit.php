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
$langx=$_REQUEST["langx"];
$sql = "select id,subuser,agname,subname,status,super,setdata from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$super=$row['super'];
$d1set = @unserialize($row['setdata']);
$level=$_REQUEST['level']?$_REQUEST['level']:2;
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
		echo wterror("Tổng hạn mức tín dụng của đại lý là$maxcredit<br>Giới hạn tín dụng tối đa của cổ đông hiện tại là$credit<br>,Tổng hạn mức tín dụng của tổng đại lý là$credit2<br>Đã vượt quá giới hạn tín dụng đại lý, vui lòng quay lại và nhập lại");
		exit();
	}else{
		if($_REQUEST['password']<>""){
			$mysql="update web_world set passwd='$mempasd',Credit='$maxcredit',Alias='$alias' where id=$mid";
		}else{
			$mysql="update web_world set Credit='$maxcredit',Alias='$alias' where id=$mid";
		}

		mysql_query($mysql) or die ("Thao tác thất bại!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','Thay đổi mật khẩu','$memname1','Đại lý tổng hợp',3)";
		mysql_query($mysql) or die ("Thao tác thất bại!");
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
 { document.all.alias.focus(); alert("Vui lòng tham khảo tên đại lý chung.!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("Vui lòng tham khảo giới hạn tín dụng đại lý chung.!"); return false; }
// if(document.all.winloss_s.value=='')
// { document.all.winloss_s.focus(); alert("请选择总代理商佔成数!!"); return false; }
// if (eval(document.all.winloss_c.value) > eval(document.all.winloss_s.value))
// { document.all.winloss_s.focus(); alert("总代理商佔成数超过股东佔成数!!"); return false; }
 if(!confirm("Bạn có chắc chắn viết thư cho đại lý chung không?"))
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
        if(i === 1) {
            self.location = '/xn/app/corprator/cor_list.php?uid='+uid+'&level='+i;
        } else if(i === 2) {
            self.location = '/xn/app/corprator/super_agent/body_super_agents.php?uid='+uid+'&level='+i;
        } else if(i === 3) {
            self.location = '/xn/app/corprator/agents/su_agents.php?uid='+uid+'&level='+i;
        } else if(i === 4) {
            self.location = '/xn/app/corprator/members/su_members.php?uid='+uid+'&level='+i;
        } else if(i === 6) {
            self.location = '/xn/app/corprator/wager_list/wager_add.php?uid='+uid+'&level='+i;
        } else if(i === 5) {
            self.location = '/xn/app/corprator/su_subuser.php?uid=='+uid+'&level='+i;
        }else {
            self.location = '/xn/app/corprator/wager_list/wager_hide.php?uid='+uid+'&level='+i;
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
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann" style="position: relative;">
    <div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">Cổ đông</div>
    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">Đại lý tổng hợp</div>
    <div id="general_btn1" class="<? if ($level == 3) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(3);">Đại lý</div>
    <div id="important_btn1" class="<? if ($level == 4) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(4);">Thành viên</div>
    <div id="general_btn2" class="<? if ($level == 5) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(5);">Tài khoản phụ</div>
    <? if($d1set['d1_wager_add']==1){ ?>
        <div id="general_btn3" class="<? if ($level == 6) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(6);">Thêm tài khoản</div>
    <? } ?>
    <? if($d1set['d1_wager_hide']==1){ ?>
        <div id="general_btn4" class="<? if ($level == 7) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(7);">Tài khoản ẩn</div>
    <? } ?
</div>
<FORM NAME="myFORM" ACTION="body_super_agents_edit.php" METHOD=POST onSubmit="return SubChk()" style="padding-left:20px;padding-top:10px;">
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
        Mật khẩu phải dài ít nhất 6 ký tự, dài tối đa 12 ký tự và chỉ có thể có số (0-9) và chữ hoa và chữ thường tiếng Anh. </td>
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
		<td>Sử dụng / bật:<?=$srow['credit']+0?>　Tắt:<?=$erow['credit']+0?>　Tạm ngưng:<?=$krow['credit']+0?>  Có sẵn:<?=($row['Credit']-$erow['credit']-$srow['credit']-$krow['credit'])+0?>
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
			echo "<BR><font color=#FF0000> $corprator </font>Giới hạn / lời nhắc giới hạn tín dụng:$credit Đã sử dụng:$credit_used  Có sẵn:$credit_canuse";
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
      <td class="m_suag_ed" width="120">Tổng nắp đại lý:</td>
      <td>
        <?=$row['winloss_parents']?>%</td>
    </tr>
		<tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">Tổng đại lý:</td>
      <td>
        <?=$row['winloss']?>%</td>
    </tr>
  <!--tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">Số lượng thành viên:</td>
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
