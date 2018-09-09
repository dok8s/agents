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
$sql = "select * from web_corprator where Oid='$uid'";

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

$super=$row['super'];
$langx=$row['language'];
$abcd=$row['winloss'];
$credit=$row['Credit'];
$winloss=$row['winloss'];
$super=$row['super'];
$corprator=$row['Agname'];
$name_left = substr($corprator,0,2);

require ("../../member/include/traditional.zh-vn.inc.php");
$keys=$_REQUEST['keys'];
if ($keys=='add'){

	$skey='';
	$svalue='';
	while (list($key, $value) = each($row)) {
  	if (preg_match("/Scene/i",$key) || preg_match ("/Bet/i",$key) || preg_match ("/Turn/i",$key)){
  		//if (preg_match("/Scene/i",$key) || preg_match ("/Bet/i",$key)){
			$skey=$skey==''?$key:$skey.','.$key;
			$svalue=$svalue==''?$value:$svalue."','".$value;
		}
	}
	$svalue="'".$svalue."'";

	$AddDate=date('Y-m-d H:i:s');
	$memname=$name_left.$_REQUEST['username'];
	$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
	$maxcredit=$_REQUEST['maxcredit'];
	$memcount=$_REQUEST['maxmember'];
	$chk=chk_pwd($mempasd);

	$winloss_s=$_REQUEST['winloss_s'];
	$winloss_a=$_REQUEST['winloss_a'];
	$alias=$_REQUEST['alias'];
	if($memcount==''){$memcount=99999;}
	$username=$memname;
	$mysql="select agname from web_world where Agname='$username'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
		echo wterror("Tài khoản bạn đã nhập $memname Đã được sử dụng, vui lòng quay lại trang trước và nhập lại");
		exit;
	}
/*
	$mysql="select count(*) as cou from web_member where corprator='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);

	if ($row['cou']+$memcount>$mcount){
		echo wterror("目前总代理商 可用人数 已超过股东已用人数，请回上一面重新输入");
		exit();
	}
*/

	$mysql="select sum(Credit) as credit,sum(mcount) as mcount from web_world where corprator='$agname'";
	$wdresult = mysql_query($mysql);
	$wdrow = mysql_fetch_array($wdresult);
/*
	if ($wdrow['mcount']+$memcount>$mcount){
		echo wterror("Hiện tại, tổng số đại lý có sẵn đã vượt quá số lượng cổ đông có sẵn. Vui lòng quay lại bên và nhập lại");
		exit();
	}
*/
	if ($wdrow['credit']+$maxcredit>$credit){
		echo wterror("Tổng hạn mức tín dụng của đại lý là$maxcredit<br>Giới hạn tín dụng tối đa của cổ đông hiện tại là$credit<br>,Tổng số tiền tín dụng của tổng đại lý là$row[credit]<br>Đã vượt quá giới hạn tín dụng của cổ đông, vui lòng quay lại và nhập lại");
		exit;
	}

	$mysql="insert into web_world(Agname,Passwd,Credit,Alias,corprator,AddDate,super,mcount,winloss,winloss_parents,$skey) values ('$memname','$mempasd','$maxcredit','$alias','$agname','$AddDate','$super','$memcount','$winloss_a','$winloss_s',$svalue)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
	$mysql="update web_corprator set agCount=agCount+1 where agname='$agname'";
	mysql_query($mysql) or die ("Thao tác thất bại!");
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','Thêm','$memname','Đại lý tổng hợp',3)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
	echo "<script languag='JavaScript'>self.location='body_super_agents.php?uid=$uid'</script>";
}else{
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
function show_count(w,s) {
	//alert(w+' - '+s);
	var org_str=document.all.username.value;//org_str.substr(1,5)
	if (s!=''){
		switch(w){
			case 0:	document.all.username.value = s.substr(0,3);break;
			case 1:document.all.username.value = org_str.substr(0,3)+s+org_str.substr(4,3);break;
			case 2:document.all.username.value = org_str.substr(0,4)+s+org_str.substr(5,2);break;
			case 3:document.all.username.value = org_str.substr(0,5)+s+org_str.substr(6,1);break;
			case 4:document.all.username.value= org_str.substr(0,6)+s;break;
		}
	}
}

function SubChk()
{
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("Vui lòng nhập số tài khoản của bạn!!"); return false; }
 if(document.all.password.value=='' )
 { document.all.password.focus(); alert("Vui lòng nhập mật khẩu của bạn !"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("Vui lòng xác nhận mật khẩu của bạn và nhập mật khẩu !"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("Lỗi xác nhận mật khẩu, vui lòng nhập lại !"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("Vui lòng nhập tên của đại lý!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("Vui lòng nhập tổng hạn mức tín dụng !"); return false; }
 if(!confirm("Bạn có chắc chắn để viết các đại lý?"))
 {
  return false;
 }
}


 function onLoad()
 {
  var obj_type_id = document.getElementById('type');
  obj_type_id.value = '{TYPE}';
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
            self.location = '/app/corprator/cor_list.php?uid='+uid+'&level='+i;
        } else if(i === 2) {
            self.location = '/app/corprator/super_agent/body_super_agents.php?uid='+uid+'&level='+i;
        } else if(i === 3) {
            self.location = '/app/corprator/agents/su_agents.php?uid='+uid+'&level='+i;
        } else if(i === 4) {
            self.location = '/app/corprator/members/su_members.php?uid='+uid+'&level='+i;
        } else if(i === 6) {
            self.location = '/app/corprator/wager_list/wager_add.php?uid='+uid+'&level='+i;
        } else if(i === 5) {
            self.location = '/app/corprator/su_subuser.php?uid=='+uid+'&level='+i;
        }else {
            self.location = '/app/corprator/wager_list/wager_hide.php?uid='+uid+'&level='+i;
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
    <? } ?>
</div>
<FORM NAME="myFORM" ACTION="body_super_agents_add.php" METHOD=POST onSubmit="return SubChk()" style="padding-left:20px;padding-top:10px;">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="{ID}">
 <INPUT TYPE=HIDDEN NAME="adddate" VALUE="{ADDDATE}">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="add">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="{ENABLE}">
  <input TYPE=HIDDEN NAME="s_type" VALUE="{TYPE}">
  <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="">&nbsp;&nbsp;Quản lý đại lý chung - Thêm và sửa đổi</td>
</tr>
<tr>
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" >Cài đặt dữ liệu cơ bản</td>
  </tr>


<input type="HIDDEN" value="" name="type">
  <tr class="m_bc_ed">
      <td width="120" class="m_suag_ed"><!--input type=button name="chk" value="Xác nhận" class="za_button" onclick='ChkMem();'--><?=$sub_user?></td>
      
              <td>
				<?=$name_left?><input type="text" name="username" value="" size="10" maxlength="5" class="za_text" onKeyPress="return ChkKeyCode();"> 
			</td>
      </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed">Mật khẩu:</td>
    <td>
      <input type=PASSWORD name="password" value="" size=12 maxlength=12 class="za_text">
          Mật khẩu phải dài ít nhất 6 ký tự, dài tối đa 12 ký tự và chỉ có thể có số (0-9) và chữ hoa và chữ thường tiếng Anh. </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed">Xác nhận mật khẩu:</td>
    <td>
      <input type=PASSWORD name="repassword" value="" size=12 maxlength=12 class="za_text">
    </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed">Tên tác nhân tổng:</td>
    <td>
      <input type=TEXT name="alias" value="" size=10 maxlength=10 class="za_text">
    </td>
  </tr>
</table>

  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" >Cài đặt dữ liệu đặt cược</td>
    </tr>
    <!--tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">Số lượng thành viên:</td>
      <td>
        <input type=TEXT name="maxmember" value="" size=10 maxlength=10 class="za_text">
         </td>
    </tr--><tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">Tổng hạn mức tín dụng:</td>
      <td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input type=TEXT name="maxcredit" value="0" size=10 maxlength=10 class="za_text"></td>
		<td>Sử dụng / Kích hoạt: 0 Tắt: 0 Tạm dừng: 0 Sẵn có: 0
		<?
	
	$sql = "select credit_balance from web_super where Agname='$super'";
	$result = mysql_query($sql);
	$rt = mysql_fetch_array($result);
	if($rt['credit_balance']==1){
		$mysql="select sum(credit) as credit_used from web_world where corprator='$corprator'";
		$result = mysql_query($mysql);
		$rt = mysql_fetch_array($result);
		$credit_used = intval($rt['credit_used']);
		$credit_canuse = $credit-$credit_used;
			echo "<BR><font color=#FF0000> $corprator </font>Giới hạn / lời nhắc giới hạn tín dụng:$credit Đã sử dụng:$credit_used  Có sẵn:$credit_canuse";
	}
		?>
		</td>
	</tr>
</table>
         </td>
    </tr>
	<tr class=m_bc_ed>
    <td class=m_suag_ed>Tổng nắp đại lý:</td>
    <td><select class=za_select name=winloss_s>
	<?
	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;
		echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
	}
	?>
		</select>
    </TD></TR>
	<tr class=m_bc_ed>
    <td class=m_suag_ed>Tổng đại lý:</td>
    <td><select class=za_select name=winloss_a>
	<?
	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;
		if($i==0){$sele=" selected";}
		echo "<option value=$abc".$sele.">".($i/10).$wor_percent."</option>\n";
	}
	?>
		</select>
    </TD></TR>
     	<!--tr class=m_bc_ed>
    <td class=m_suag_ed><?=$wld_percent2?>:</td>
    <td><select class=za_select name=winloss_s>
	<?

	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;
			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";

	}
	?>
		</select>
    </TD></TR-->
    <tr class="m_bc_ed" align="center">
      <td  colspan="2">

        <input type=hidden name="winloss" value="100">
        <input type=SUBMIT name="OK" value="Xác định" class="za_button">
        &nbsp; &nbsp; &nbsp;
        <input type=BUTTON name="FormsButton2" value="Hủy bỏ" id="FormsButton2" onClick="javascript:history.go(-1)" class="za_button">
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
