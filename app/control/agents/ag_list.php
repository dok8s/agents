<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];

$mysql = "select * from web_agents where oid='$uid'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agents_id=$wd_row["ID"];
$corprator=$wd_row["corprator"];

require ("../../member/include/traditional.zh-cn.inc.php");

$agents_name=$row["Agname"];
$alias=$row["Alias"];

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/superTables.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/tableStyle.css" type="text/css">
    <link rel="stylesheet" href="css/superTables.css" type="text/css">
    <link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
    <link rel="stylesheet" href="css/loader.css" type="text/css">
    <style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: center}
-->
</style>
<script language="javascript1.2" src="/js/ag_set.js"></script>
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<link id="bs-css" href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
    var uid='<?=$uid?>';
    var level='<?=$level?>';
    function ch_level(i)
    {
        if(i === 1) {
            self.location = '/app/control/agents/members/ag_members.php?uid='+uid+'&level='+i;
        } else {
            self.location = '/app/control/agents/ag_subuser.php?uid='+uid+'&level='+i;
        }

    }
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" style="padding:1px;">
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann" >
    <div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">Thành viên</div>
    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">Tài khoản phụ</div>
</div>
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agents_id?>">
 <h3 style="position: relative;top: 0px;width: 100%;padding: 40px 0px 20px 20px;font-size: 17px;color: #3B3B3B;">Cài đặt chi tiết đại lý&nbsp;&nbsp;&nbsp;<?=$sub_user?>:<?=$agents_name?> --
     <?=$sub_name?>:<?=$alias?></h3>
 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
 <div id="my_div" class="fakeContainer first_div" style="padding:1px">
     <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
         <tr id="my_tr">
             <th class="center" rowspan="2">Bóng đá</th>
             <th class="center" colspan="4">Cài đặt thu hồi nước</th>
             <th class="center" colspan="2">Giới hạn đặt cược</th>
         </tr>
         <tr>
             <th class="center">A</th>
             <th class="center">B</th>
             <th class="center">C</th>
             <th class="center">D</th>
             <th class="center">Trường đơn</th>
             <th class="center">Ghi chú duy nhất</th>
         </tr>
         <tr  class="m_cen">
             <td nowrap align="right" class="m_ag_ed">Hãy để bóng, Kích thước, Đơn và đôi</td>
             <td nowrap><?=$row["FT_Turn_R_A"]?></td>
             <td nowrap><?=$row["FT_Turn_R_B"]?></td>
             <td nowrap><?=$row["FT_Turn_R_C"]?></td>
             <td nowrap><?=$row["FT_Turn_R_D"]?></td>
             <td nowrap><?=$row["FT_R_Scene"]?></td>
             <td nowrap><?=$row["FT_R_Bet"]?></td>
         </tr>
         <tr  class="m_cen">
             <td nowrap class="m_ag_ed">Lăn bóng để làm bóng, Kích thước bóng lăn</td>
             <td nowrap><?=$row["FT_Turn_RE_A"]?></td>
             <td nowrap><?=$row["FT_Turn_RE_B"]?></td>
             <td nowrap><?=$row["FT_Turn_RE_C"]?></td>
             <td nowrap><?=$row["FT_Turn_RE_D"]?></td>
             <td nowrap><?=$row["FT_RE_Scene"]?></td>
             <td nowrap><?=$row["FT_RE_Bet"]?></td>
         </tr>

         <tr  class="m_cen">
             <td nowrap class="m_ag_ed">Giành chiến thắng, Rolling ball thắng</td>
             <td nowrap colspan="4" ><?=$row["FT_Turn_M"]?></td>
             <td nowrap><?=$row["FT_M_Scene"]?></td>
             <td nowrap><?=$row["FT_M_Bet"]?></td>
         </tr>
         <tr  class="m_cen">
             <td nowrap class="m_ag_ed">Khác</td>
             <td nowrap colspan="4" ><?=$row["FT_Turn_PC"]?></td>
             <td nowrap><?=$row["FT_PC_Scene"]?></td>
             <td nowrap><?=$row["FT_PC_Bet"]?></td>
         </tr>
     </table>
 </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">Bóng rổ</th>
                 <th class="center" colspan="4">Cài đặt thu hồi nước</th>
                 <th class="center" colspan="2">Giới hạn đặt cược</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">Trường đơn</th>
                 <th class="center">Ghi chú duy nhất</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap align="right" class="m_ag_ed"> Hãy để bóng,  Kích thước, Đơn và đôi</td>
                 <td nowrap><?=$row["BK_Turn_R_A"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_B"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_C"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_D"]?></td>
                 <td nowrap><?=$row["BK_R_Scene"]?></td>
                 <td nowrap><?=$row["BK_R_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">Cán bóng Hãy để bóng, Cán bóng Kích thước</td>
                 <td nowrap><?=$row["BK_Turn_RE_A"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_B"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_C"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_D"]?></td>
                 <td nowrap><?=$row["BK_RE_Scene"]?></td>
                 <td nowrap><?=$row["BK_RE_Bet"]?></td>
             </tr>

             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">  Khác</td>
                 <td nowrap colspan="4" ><?=$row["BK_Turn_PC"]?></td>
                 <td nowrap><?=$row["BK_PC_Scene"]?></td>
                 <td nowrap><?=$row["BK_PC_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">Bóng tích hợp</th>
                 <th class="center" colspan="4">Cài đặt thu hồi nước</th>
                 <th class="center" colspan="2">Giới hạn đặt cược</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">Trường đơn</th>
                 <th class="center">Ghi chú duy nhất</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap align="right" class="m_ag_ed"> Hãy để bóng,  Kích thước, Đơn và đôi</td>
                 <td nowrap><?=$row["OP_Turn_R_A"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_B"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_C"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_D"]?></td>
                 <td nowrap><?=$row["OP_R_Scene"]?></td>
                 <td nowrap><?=$row["OP_R_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">Cán bóng Hãy để bóng, Cán bóng Kích thước</td>
                 <td nowrap><?=$row["OP_Turn_RE_A"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_B"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_C"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_D"]?></td>
                 <td nowrap><?=$row["OP_RE_Scene"]?></td>
                 <td nowrap><?=$row["OP_RE_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed"> Giành chiến thắng, Cán bóng Giành chiến thắng</td>
                 <td nowrap colspan="4" ><?=$row["OP_Turn_M"]?></td>
                 <td nowrap><?=$row["OP_M_Scene"]?></td>
                 <td nowrap><?=$row["OP_M_Bet"]?></td>
             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">Khác</td>
                 <td nowrap colspan="4" ><?=$row["OP_Turn_PC"]?></td>
                 <td nowrap><?=$row["OP_PC_Scene"]?></td>
                 <td nowrap><?=$row["OP_PC_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse; width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">Quán quân</th>
                 <th class="center" colspan="4">Cài đặt thu hồi nước</th>
                 <th class="center" colspan="2">Giới hạn đặt cược</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">Trường đơn</th>
                 <th class="center">Ghi chú duy nhất</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">Quán quân</td>
                 <td nowrap colspan="4" ><?=$row["FS_Turn_R"]?></td>
                 <td nowrap><?=$row["FS_R_Scene"]?></td>
                 <td nowrap><?=$row["FS_R_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>
<div id="show_table" style="visibility:hidden;position: absolute;"></div>
<div id="list" style="visibility:hidden;">
	<table border="0" cellpadding="1" cellspacing="1" class="ta_div">
		<tr class="m_title_ft_future">
			<td width=30>Số</td>
			<td width=100 >Tài khoản mới</td>
			<td width=100 >Tài khoản cũ</td>
			<td width=100 >Ngày sửa đổi</td>
		</tr>
		*LIST_RECORD*
		<tr><td colspan="4" class="m_cen"><input type="button" value="Đóng" onClick="close_divs();" class="za_button"></td></tr>
	</table>
</div>
<div id="hidden_list" style="visibility:hidden;">
	<tr bgcolor="#F9FED3">
		<td>*NUMBER*</td>
		<td>*NEW_NAME*</td>
		<td>*OLD_NAME*</td>
		<td>*EDIT_DATE*</td>
	</tr>
</div>
<iframe id="showdata" name="showdata" scrolling="no" width="0" height="0" src="../../../ok.html"></iframe>
</body>
</html>
<style>
  .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
    z-index: 2;
    color: #fff;
    background-color: #c12e36;
    border-color: #c12e36;
  }

  .list-group-item:first-child {
    border-top-right-radius: 0px;
    border-top-left-radius: 0px;
  }
</style>
<script type="text/javascript">
    $(window).load(function(){
        $('body').addClass('loaded').Chameleon({
            'current_item':'hoveralls',
            'json_url':'../Envato/items.json'
        });
        $('#loader-wrapper .load_title').remove();
    });
</script>