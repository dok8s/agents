<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$sql = "select id,subuser,agname,subname,status,super,setdata from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$super=$row['super'];
$d1set = @unserialize($row['setdata']);
$level=$_REQUEST['level']?$_REQUEST['level']:2;
$sql = "select Agname,ID,language,super from web_corprator where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row 		= mysql_fetch_array($result);
$agname	=	$row['Agname'];
$agid		=	$row['ID'];
$super	=	$row['super'];
$langx	=	$row['language'];
$langx	=	'zh-vn';

require ("../../member/include/traditional.$langx.inc.php");

$enable	=	$_REQUEST["enable"];
$enabled=	$_REQUEST["enabled"];
$sort		=	$_REQUEST["sort"];
$active	=	$_REQUEST["active"];
$orderby=	$_REQUEST["orderby"];
$super_agents_id=$_REQUEST['super_agents_id'];

$mid		=	$_REQUEST["mid"];
$page		=	$_REQUEST["page"];
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
	$mysql="update web_world set oid='',Status=$stop where ID=$mid";
	mysql_query($mysql);

	$mysql="select agname from web_world where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="update web_world set oid='',Status=$stop where subuser=1 and subname='$agent_name'";
	mysql_query($mysql);

	$mysql="update web_agents set oid='',Status=$stop where world='$agent_name'";
	mysql_query( $mysql);

	$mysql="update web_member set oid='',Status=$stop where world='$agent_name'";
	mysql_query( $mysql);

	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$agent_name','Đại lý tổng hợp',2)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
}

$sql = "select ID,Agname,passwd_safe,Alias,Credit,AgCount,date_format(AddDate,'%m-%d / %H:%i') as AddDate from web_world where corprator='$agname' and Status=$enabled and subuser=0 and  super='$super' order by ".$sort." ".$orderby;
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=30;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
if ($cou==0){
	$page_count=1;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title_suag {  background-color: #CD9A99; text-align: center}
-->
</style>
<SCRIPT language=javaScript src="/js/agents<?=$body_js?>.js" type=text/javascript></SCRIPT>
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
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad();">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Lỗi tỷ lệ cược......</div>
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
<form name="myFORM" action="body_super_agents.php?uid=<?=$uid?>" method=POST style="padding-left:20px;padding-top:10px;">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="85" >&nbsp;&nbsp;Quản lý đại lý chung:</td>
            <td>
              <select  name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y">Bật</option>
                <option value="N">Tắt</option>
                <option value="S">Tạm ngưng</option>
              </select>
	    </td>
            <td> -- <?=$mem_orderby?>:</td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="Alias"><?=$cor_name1?></option>
                <option value="Agname"><?=$cor_user?></option>
                <option value="AddDate"><?=$mem_adddate?></option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?>:</td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>

              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?> -- </td>
            <td>
              <input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='body_super_agents_add.php?uid=<?=$uid?>'" class="za_button">
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
$page_count=1;
?>
<table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="976061" class="m_tab">
    <tr class="m_title_suag">
      <td height="30" align=center>Hiện tại không có đại lý chung</td>
    </tr>
  </table>
<?
}else{
?>
    <table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="976061" class="m_tab">
    <tr class="m_title_suag"  bgcolor="86C0A6">
      <td width="80">Tên nhà phân phối</td>
      <td width="80">Tài khoản nhà phân phối</td>
      <td width="80">Mã bảo mật</td>
      <td width="80" >Hạn mức tín dụng</td>
      <td width="80">Tổng đại lý</td>
      <td width="80">Thêm ngày</td>
      <td width="55" >Trạng thái tài khoản</td>
      <td width="200">Chức năng</td>
      <td width="54" >Nhận xét</td>
    </tr>
	<?
	while ($row = mysql_fetch_array($result)){

		$sql = "select count(*) as cou from web_agents where world='".$row['Agname']."' order by id";
		$cresult = mysql_query( $sql);
		$crow = mysql_fetch_array($cresult)

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
<a href="javascript:CheckSTOP('/xn/app/corprator/super_agent/body_super_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=S','S')">Tạm ngưng</a> /
<?
}
?>
         <a href="javascript:CheckSTOP('/xn/app/corprator/super_agent/body_super_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a>
        / <a href="/xn/app/corprator/super_agent/body_super_agents_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&super_agents_id=<?=$agid?>"><?=$mem_acount?></a>
        / <a href="/xn/app/corprator/super_agent/body_super_agents_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&super_agents_id=<?=$agid?>"><?=$mem_setopt?></a></td>
    <td></td>

      </tr>
<?
}
}
?>
</table>
  </table>
</form>
</body>
</html>
<?
mysql_close();
?>
