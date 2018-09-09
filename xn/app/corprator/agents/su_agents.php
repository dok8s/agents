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
$level=$_REQUEST['level']?$_REQUEST['level']:3;
$sql = "select Agname,ID,language,super from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$super=$row['super'];

$langx=$row['language'];
$abcd=$row['winloss_c'];

require ("../../member/include/traditional.zh-vn.inc.php");

$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$active=$_REQUEST["active"];
$orderby=$_REQUEST["orderby"];
$super_agents_id=$_REQUEST["super_agents_id"];
$mid=$_REQUEST["mid"];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
if ($enable==""){
	$enable='Y';
}

if ($sort==""){
	$sort='Alias';
}

if ($orderby==""){
	$orderby='asc';
}

switch($enable){
case "Y":
	$enabled=1;
	$memstop='N';
	$stop=1;
	$start_font="";
	$end_font="";
	$caption1=$mem_disable;
	$caption2=$mem_enable;
	$xm="Bật";
	break;
case "N":
	$enable='N';
	$memstop='Y';
	$enabled=0;
	$stop=0;
	//$start_font="<font color=#999999>";
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(255,0,0);'>$mem_disable</SPAN>";
	$caption1=$mem_enable;
	$xm="Tắt";
	break;
default:
	$enable='S';
	$memstop='Y';
	$enabled=2;
	$stop=2;
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(0,255,0);'>Tạm ngưng</SPAN>";
	$caption1=$mem_enable;
	$xm="Tạm ngưng";
	break;
}

if ($active==2){
	$mysql="update web_agents set oid='',Status=$stop where ID=$mid";
	mysql_query( $mysql);

	$mysql="select agname,world from web_agents where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="update web_agents set oid='',Status=$stop where subuser=1 and subname='$agent_name'";
	mysql_query($mysql);

	$mysql="update web_member set oid='',Status=$stop where agents='$agent_name'";
	mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$agent_name','Đại lý',3)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
/*
	if ($agstop==0){
		$mysql="update web_world set agcount=agcount-1 where agname='$world'";
	}else{
		$mysql="update web_world set agcount=agcount+1 where agname='$world'";
	}

	mysql_query( $mysql);
	*/
}
if ($super_agents_id==''){
	$sql = "select ID,Agname,passwd_safe,Alias,Credit,mCount,world,date_format(AddDate,'%m-%d / %H:%i') as AddDate,mcount from web_agents where Status=$enabled and corprator='$agname' and subuser=0 and super='$super' order by ".$sort." ".$orderby;
}else{
	$sql = "select ID,Agname,passwd_safe,Alias,Credit,mCount,world,date_format(AddDate,'%m-%d / %H:%i') as AddDate,mcount from web_agents where Status=$enabled and corprator='$agname' and world='$super_agents_id' and subuser=0 and super='$super' order by ".$sort." ".$orderby;
}

$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=30;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title {  background-color: #86C0A6; text-align: center}
-->
</style>
<SCRIPT language=javaScript src="/js/agents.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript>
<!--
 function onLoad()
 {
  var obj_sagent_id = document.getElementById('super_agents_id');
  obj_sagent_id.value = '<?=$super_agents_id?>';
  var obj_enable = document.getElementById('enable');
  obj_enable.value = '<?=$enable?>';
  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
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
<form name="myFORM" action="/xn/app/corprator/agents/su_agents.php?uid=<?=$uid?>" method=POST style="padding-left:20px;padding-top:10px;">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="70">&nbsp;&nbsp;<?=$wld_selagent?></td>
            <td>	<select class=za_select id=super_agents_id onchange=document.myFORM.submit(); name=super_agents_id>
				<option value="" selected><?=$rep_pay_type_all?></option>
				<?
				$mysql="select ID,Agname from web_world where Status=1 and subuser=0 and corprator='".$agname."'";
				$ag_result = mysql_query( $mysql);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($super_agents_id==$ag_row['Agname']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";

					}
				}
				?>
			</select>
              <select  name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y">Bật</option>
                <option value="N">Tắt</option>
                <option value="S">Tạm ngưng</option>
              </select>
            </td>
            <td> -- <?=$mem_orderby?></td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="Alias"><?=$mem_name?></option>
                <option value="Agname"><?=$mem_uid?></option>
                <option value="Adddate"><?=$mem_adddate?></option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?></td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>
              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?> -- </td>
            <td>
              <input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='./su_ag_add.php?uid=<?=$uid?>'" class="za_button">
            </td>
          </tr>
        </table>
	</td>
</tr>
<tr>
	<td colspan="2" height="4"></td>
</tr>
</table>
<?

if ($cou==0){
?>
<table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">    <tr class="m_title">
      <td height="30" >Hiện tại không có đại lý</td>
    </tr>
  </table>
<?
}else{
 ?>
<table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
   <tr class="m_title">
      <td width="80"><?=$rcl_agent?><?=$sub_name?></td>
      <td width="80"><?=$rcl_agent?><?=$sub_user?></td>
      <td width="80">Đăng nhập tài khoản</td>
	  <td width="110"><?=$rep_pay_type_c?></td>
      <td width="50"><?=$wld_memcount?></td>
      <td width="80"><?=$mem_adddate?></td>
      <td width="64">Thời gian hết hạn</td>
      <td width="220"><?=$mem_option?></td>
    </tr>
	<?
	while ($row = mysql_fetch_array($result)){
		$mysql="select id from web_world where Agname='".trim($row['world'])."'";
		$memresult = mysql_query( $mysql);
		$memrow = mysql_fetch_array($memresult);

		$sql = "select count(*) as cou from web_member where agents='".$row['Agname']."' order by id";
		$cresult = mysql_query( $sql);
		$crow = mysql_fetch_array($cresult);
		
	?>
    <tr  class="m_cen">
      <td><?=$row['Alias']?></td>
      <td><?=$row['Agname']?></td>
      <td><?=$row['passwd_safe']?></td>
     <td align="right"><?=$row['Credit']?></td>
      <td><?=$crow['cou']?></td>
      <td><?=$row['AddDate']?></td>
      <td><?=$caption2?></td>
            <td align="left">
<?
if($enable=='Y'){
?>
<a href="javascript:CheckSTOP('/xn/app/corprator/agents/su_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=S','S')">Tạm ngưng</a> /
<?
}
?>
        <a href="javascript:CheckSTOP('/app/corprator/agents/su_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a>
        / <a href="/xn/app/corprator/agents/su_ag_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&agents_id=<?=$memrow['id']?>"><?=$mem_acount?></a>
        / <a href="/xn/app/corprator/agents/su_ag_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&agents_id=<?=$memrow['id']?>"><?=$mem_setopt?></a></td>
    </tr>
<?
}
}
?>
</table>
  </table>
</form>
<div id=acc_window style="display: none;position:absolute">
<form name=agAcc action="../acc_proc.php?uid=<?=$uid?>&url=agents/su_agents.php?uid=<?=$uid?>" method=post onSubmit="return Chk_acc();" target="win_agAcc">
<input type=hidden name=aid value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="0163A2">
  <tr>
    <td bgcolor="#FFFFFF">
    <table width="220" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix">
      <tr bgcolor="0163A2">
        <td id=acc_title><font color="#FFFFFF">Vui lòng nhập ngày kiểm tra</font></td>
    <td align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
      </tr>
       <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
      <tr>
        <td colspan="2">Ngày tháng:
          <input type=text name=acc_date value="2005-06-06" class="za_text" size="12" maxlength="10" >
          &nbsp;&nbsp;
          <input type=submit name=acc_ok value="Xác định" class="za_button">
          &nbsp; </td>
      </tr>
    </table>
   </td>
  </tr>
</table>
</form>
</div>

<div id=re_window style="display: none;position:absolute">
<form name=agre action="../recover_credit.php?uid=<?=$uid?>" method=post onSubmit="return Chk_acc();" target="win_agAcc">
<input type=hidden name=aid value="">
<input type=hidden name=cdate value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="0163A2">
  <tr>
    <td bgcolor="#FFFFFF">
      <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix" >
        <tr bgcolor="0163A2">
          <td width="200" id=re_title><font color="#FFFFFF">&nbsp;Vui lòng nhập ngày phản hồi</font></td>
          <td align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr>
          <td colspan="2">Ngày tháng：
          <input type=text name=acc_date value="2005-06-06" class="za_text" size="12" maxlength="10">
          &nbsp;&nbsp;
          <input type=submit name=acc_ok value="Xác định" class="za_button"></td>
       </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>

</body>
</html>
<script language='javascript'>
function cancelMouse()
{
    return false;
}
document.oncontextmenu=cancelMouse;
</script>
<?
mysql_close();
?>
