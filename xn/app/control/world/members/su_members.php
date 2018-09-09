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
$sql = "select super,Agname,ID,language from web_world where Oid='$uid'";
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
$level=$_REQUEST['level']?$_REQUEST['level']:4;
$langx=$row['language'];
require ("../../../member/include/traditional.zh-vn.inc.php");
$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$uname=$_REQUEST["uname"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
$mid=$_REQUEST["id"];
$active=$_REQUEST["active"];
$super_agents_id=$_REQUEST['super_agents_id'];
if ($enable==""){
    $enable='Y';
}
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
if ($sort=='' and $orderby==''){
	$order='';
}else if ($sort<>"" and $orderby==''){
	$order=' order by '.$sort." desc";
	$orderby='desc';
}else if ($sort=='' and $orderby<>''){
	$order=' order by alias '.$orderby;
	$sort='alias';
}else{
	$order=' order by '.$sort.' '.$orderby;
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

switch ($active){
case 2:
    $sql = "select Memname from web_member where id=$mid";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $memname=$row["Memname"];
    $mysql="update web_member set oid='',Status=$stop where id=$mid";
    mysql_query( $mysql);

	if ($stop==0){
		$mysql="update web_agents set mcount=mcount-1 where agname='$agents'";
	}else{
		$mysql="update web_agents set mcount=mcount+1 where agname='$agents'";
	}
	mysql_query( $mysql);
    $mysql="update web_member set oid='',Status=$stop where id=$mid";
    mysql_query( $mysql);
    $mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$memname','Đại lý',4)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
	break;
case 3:
	break;
}
if($uname<>""){
	$nu="Memname='$uname' and ";
}
if ($super_agents_id==''){
	$sql = "select ID,Memname,loginname,passwd,money,Alias,Credit,ratio,date_format(AddDate,'%m-%d/%H:%i') as AddDate,pay_type,Agents,OpenType from web_member where ".$nu." Status='$enabled' and super='$super' and corprator='$agname'".$order;
}else{
	$sql = "select ID,Memname,loginname,passwd,money,Alias,Credit,ratio,date_format(AddDate,'%m-%d/%H:%i') as AddDate,pay_type,Agents,OpenType from web_member where ".$nu." Status='$enabled' and super='$super' and Agents='$super_agents_id'".$order;
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
<style type="text/css">
<!--
.m_title {  background-color: #FEF5B5; text-align: center}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT language="javascript" src="/js/member.js"></script>
<SCRIPT>

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

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
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
<FORM NAME="myFORM" ACTION="/xn/app/control/world/members/su_members.php?uid=<?=$uid?>" METHOD=POST style="padding-left:20px;padding-top:10px;">
<input type="hidden" name="agent_id" value="<?=$agid?>">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="70">&nbsp;&nbsp;Quản lý thành viên</td>
            <td>
			<select class=za_select id=super_agents_id onchange=document.myFORM.submit(); name=super_agents_id>
				<option value="" selected><?=$rep_pay_type_all?></option>
				<?
				$mysql="select ID,Agname from web_agents where Status=1 and subuser=0 and corprator='".$agname."'";
				$su_result = mysql_query( $mysql);
				while ($su_row = mysql_fetch_array($su_result)){
					if ($super_agents_id==$su_row['Agname']){
						echo "<option value=".$su_row['Agname']." selected>".$su_row['Agname']."</option>";
						$sel_agents=$su_row['Agname'];
					}else{
						echo "<option value=".$su_row['Agname'].">".$su_row['Agname']."</option>";

					}
				}
				?>
			</select>

            <select name="enable" onChange="self.myFORM.submit()" class="za_select" >
								<option value="Y">Bật</option>
								<option value="N">Tắt</option>
								<option value="S">Tạm ngưng</option>
              </select>
            </td>
            <td width="40"> -- <?=$mem_orderby?></td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="alias"><?=$mem_name?></option>
                <option value="memname"><?=$mem_uid?></option>
                <option value="adddate"><?=$mem_adddate?></option>
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
			<td>&nbsp;&nbsp;<input type="text" name="uname" id="uname" style="width:70px;">&nbsp;<input type=BUTTON name="seledd" value="Thành viên truy vấn" onClick="document.myFORM.submit();" class="za_button"></td>
            <td>
              <input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='./su_mem_add.php?uid=<?=$uid?>'" class="za_button">
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
  <table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab">
    <tr class="m_title">
      <td height="30" ><?=$mem_nomem?></td>
    </tr>
  </table>
<?
}else{

 ?>
  <table width="796" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab">
    <tr class="m_title">
      <td width="70" >Đại lý</td>
      <td width="70">Tên thành viên</td>
      <td width="70">Tài khoản thành viên</td>
      <td width="70">Đăng nhập tài khoản</td>
<? if($edit==1){ ?>
	 <td width="80">Mật khẩu thành viên</td>
<? } ?>
	  <td width="80">Hạn mức tín dụng</td>
      <td width="70">Thêm ngày</td>
      <td width="60">Trạng thái tài khoản</td>
      <td width="180">Chức năng</td>
    </tr>
<?
	while ($row = mysql_fetch_array($result)){
	?>
    <tr class="m_cen">
      <td><?=$start_font?><?=$row['Agents'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['Alias'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['Memname'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['loginname'];?><?=$end_font?></td>
<? if($edit==1){ ?>	 
      <td><?=$start_font?><?=$row['passwd'];?><?=$end_font?></td>
<? } ?>
      <td align="right"><?=$start_font?>
    <?
     if ($row['pay_type']==1){
	echo mynumberformat($row['money']*$row['ratio'],2);
    }else{
	echo mynumberformat($row['Credit']*$row['ratio'],2);
    }
    ?><?=$end_font?></td>
<td><?=$row['AddDate'];?></td>
	  <td><?=$caption2?></td>
<td align=left><?
if($enable=='Y'){
?>
<a href="javascript:CheckSTOP('/app/control/world/members/su_members.php?uid=<?=$uid?>&active=2&id=<?=$row['ID']?>&enable=S','S')">Tạm ngưng</a> /
<?
}
?><a href="javascript:CheckSTOP('/app/control/world/members/su_members.php?uid=<?=$uid?>&active=2&id=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a> / <a href="./su_mem_edit.php?uid=<?=$uid?>&mid=<?=$row['ID']?>">Sửa đổi dữ liệu</a> / <a href="su_mem_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['pay_type']?>&agents_id=<?=$row['Agents']?>">Cài đặt chi tiết</a></td>
    </tr>
<?
}
}
?>
</table>
</form>
</body>
</html>