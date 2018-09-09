<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];

$mysql = "select * from web_world where Oid='$uid' and oid<>''";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agents_id=$wd_row["ID"];
$corprator=$wd_row["corprator"];

require ("../../member/include/traditional.zh-vn.inc.php");

$agents_name=$row["Agname"];
$alias=$row["Alias"];
$level=$_REQUEST['level']?$_REQUEST['level']:2;
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<script language="javascript1.2" src="/js/ag_set.js"></script>
        <link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
        <link rel="stylesheet" href="/style/control/account_management.css" type="text/css">
        <link rel="stylesheet" href="/style/control/edit_agents2.css" type="text/css">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" type="text/css">
        <link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
        <link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
        <script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
        <script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
        <style type="text/css">
            <!--
            .m_ag_ed {  background-color: #bdd1de; text-align: right}
            -->
        </style>
        <script>
            var uid='<?=$uid?>';
            var level='<?=$level?>';
            function ch_level(i)
            {
                if(i === 2) {
                    self.location = '/xn/app/control/world/su_list.php?uid='+uid+'&level='+i;
                } else if(i === 3) {
                    self.location = '/xn/app/control/world/agents/su_agents.php?uid='+uid+'&level='+i;
                } else if(i === 4) {
                    self.location = '/xn/app/control/world/members/su_members.php?uid='+uid+'&level='+i;
                } else if(i === 6) {
                    self.location = '/xn/app/control/world/wager_list/wager_add.php?uid='+uid+'&level='+i;
                } else if(i === 5) {
                    self.location = '/xn/app/control/world/su_subuser.php?uid=='+uid+'&level='+i;
                }else {
                    self.location = '/xn/app/control/world/wager_list/wager_hide.php?uid='+uid+'&level='+i;
                }

            }
        </script>
        <script language="javascript1.2" src="/js/ag_set.js"></script>
    </head>
    <link rel="stylesheet" href="./css/loader.css" type="text/css">
    <script type="text/javascript">
        // 等待所有加载
        $(window).load(function(){
            $('body').addClass('loaded');
            $('#loader-wrapper .load_title').remove();
        });
    </script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
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
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agents_id?>">
<table width="780" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;padding-top:10px;">
  <tr>
        <td class="">&nbsp;&nbsp;Cài đặt chi tiết đại lý&nbsp;&nbsp;&nbsp;Số tài khoản:<?=$agents_name?> --
      <?=$sub_name?>:<?=$alias?> -- <a href="./body_home.php?uid=<?=$uid?>&super_agents_id=<?=$id?>">Quay lại trang trước</a></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
<td> Bóng đá </td>
     <td width = "68"> Đưa bóng </td>
     <td width = "68"> Kích thước </td>
     <td width = "68"> Lăn bóng </td>
     <td width = "68"> Kích thước bi lăn </td>
     <td width = "68"> Đơn và đôi </td>
     <td width = "68"> Chỉ giành chiến thắng </td>
     <td width = "68"> Giải phóng mặt bằng tiêu chuẩn </td>
     <td width = "68"> Để bóng đi qua </td>
     <td width = "68"> Giải phóng mặt bằng toàn diện </td>
     <td width = "68"> Làn sóng </td>
     <td width = "68"> Đi vào bóng </td>
     <td width = "68"> Half full court </td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu hồi nước <font color="#CC0000">A</font></td>
    <td><?=$row['FT_Turn_R_A']?></td>
    <td><?=$row['FT_Turn_OU_A']?></td>
    <td><?=$row['FT_Turn_RE_A']?></td>
    <td><?=$row['FT_Turn_ROU_A']?></td>
    <td><?=$row['FT_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['FT_Turn_M']?></td>
    <td rowspan="4"><?=$row['FT_Turn_P']?></td>
    <td rowspan="4"><?=$row['FT_Turn_PR']?></td>
    <td rowspan="4"><?=$row['FT_Turn_PC']?></td>
    <td rowspan="4"><?=$row['FT_Turn_PD']?></td>
    <td rowspan="4"><?=$row['FT_Turn_T']?></td>
    <td rowspan="4"><?=$row['FT_Turn_F']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['FT_Turn_R_B']?></td>
    <td><?=$row['FT_Turn_OU_B']?></td>
    <td><?=$row['FT_Turn_RE_B']?></td>
    <td><?=$row['FT_Turn_ROU_B']?></td>
    <td><?=$row['FT_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['FT_Turn_R_C']?></td>
    <td><?=$row['FT_Turn_OU_C']?></td>
    <td><?=$row['FT_Turn_RE_C']?></td>
    <td><?=$row['FT_Turn_ROU_C']?></td>
    <td><?=$row['FT_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['FT_Turn_R_D']?></td>
    <td><?=$row['FT_Turn_OU_D']?></td>
    <td><?=$row['FT_Turn_RE_D']?></td>
    <td><?=$row['FT_Turn_ROU_D']?></td>
    <td><?=$row['FT_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
	<td><?=$row['FT_R_Scene']?></td>
    <td><?=$row['FT_OU_Scene']?></td>
	<td><?=$row['FT_RE_Scene']?></td>
	<td><?=$row['FT_ROU_Scene']?></td>
    <td><?=$row['FT_EO_Scene']?></td>
    <td><?=$row['FT_M_Scene']?></td>
    <td><?=$row['FT_P_Scene']?></td>
    <td><?=$row['FT_PR_Scene']?></td>
    <td><?=$row['FT_PC_Scene']?></td>
    <td><?=$row['FT_PD_Scene']?></td>
    <td><?=$row['FT_T_Scene']?></td>
    <td><?=$row['FT_F_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn ghi</td>
    <td><?=$row['FT_R_Bet']?></td>
    <td><?=$row['FT_OU_Bet']?></td>
    <td><?=$row['FT_RE_Bet']?></td>
    <td><?=$row['FT_ROU_Bet']?></td>
    <td><?=$row['FT_EO_Bet']?></td>
    <td><?=$row['FT_M_Bet']?></td>
    <td><?=$row['FT_P_Bet']?></td>
    <td><?=$row['FT_PR_Bet']?></td>
    <td><?=$row['FT_PC_Bet']?></td>
    <td><?=$row['FT_PD_Bet']?></td>
    <td><?=$row['FT_T_Bet']?></td>
    <td><?=$row['FT_F_Bet']?></td>
  </tr>
</table>
<BR>
<table width='780'>
<tr>
<td align='left'>
<table width="515" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td>Bóng rổ </td>
<td width="68">Hãy để bóng</td>
    <td width="68">Kích thước</td>
    <td width="68">Cán bóng</td>
    <td width="68">Kích thước</td>
    <td width="68">Đơn và đôi</td>
    <td width="68">Để bóng</td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed">Cài đặt thu<font color="#CC0000">A</font></td>
    <td><?=$row['BK_Turn_R_A']?></td>
    <td><?=$row['BK_Turn_OU_A']?></td>
    <td><?=$row['BK_Turn_RE_A']?></td>
    <td><?=$row['BK_Turn_ROU_A']?></td>
    <td><?=$row['BK_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['BK_Turn_PR']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['BK_Turn_R_B']?></td>
    <td><?=$row['BK_Turn_OU_B']?></td>
    <td><?=$row['BK_Turn_RE_B']?></td>
    <td><?=$row['BK_Turn_ROU_B']?></td>
    <td><?=$row['BK_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['BK_Turn_R_C']?></td>
    <td><?=$row['BK_Turn_OU_C']?></td>
    <td><?=$row['BK_Turn_RE_C']?></td>
    <td><?=$row['BK_Turn_ROU_C']?></td>
    <td><?=$row['BK_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn đơn:</td>
    <td><?=$row['BK_R_Scene']?></td>
    <td><?=$row['BK_OU_Scene']?></td>
    <td><?=$row['BK_RE_Scene']?></td>
    <td><?=$row['BK_ROU_Scene']?></td>
    <td><?=$row['BK_EO_Scene']?></td>
    <td><?=$row['BK_PR_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn ghi:</td>
    <td><?=$row['BK_R_Bet']?></td>
    <td><?=$row['BK_OU_Bet']?></td>
    <td><?=$row['BK_RE_Bet']?></td>
    <td><?=$row['BK_ROU_Bet']?></td>
    <td><?=$row['BK_EO_Bet']?></td>
    <td><?=$row['BK_PR_Bet']?></td>
  </tr>
</table>
</td>
<td align='right'>
<table width="150" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td>Quán quân</td>
    <td width="68">Quán quân</td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed">Cài đặt thu hồi nước:</td>
    <td><?=$row['FS_Turn_R']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn đơn:</td>
    <td><?=$row['FS_R_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn ghi:</td>
    <td><?=$row['FS_R_Bet']?></td>
  </tr>
</table>
</td>
</tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
<td> quần vợt </td>
     <td width = "68"> Đưa bóng </td>
     <td width = "68"> Kích thước </td>
     <td width = "68"> Lăn bóng </td>
     <td width = "68"> Kích thước bi lăn </td>
     <td width = "68"> Đơn và đôi </td>
     <td width = "68"> Chỉ giành chiến thắng </td>
     <td width = "68"> Giải phóng mặt bằng tiêu chuẩn </td>
     <td width = "68"> Để bóng đi qua </td>
     <td width = "68"> Làn sóng </td>
     <td width = "68"> Đi vào bóng </td>
     <td width = "68"> Half full court </td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu <font color="#CC0000">A</font></td>
    <td><?=$row['TN_Turn_R_A']?></td>
    <td><?=$row['TN_Turn_OU_A']?></td>
    <td><?=$row['TN_Turn_RE_A']?></td>
    <td><?=$row['TN_Turn_ROU_A']?></td>
    <td><?=$row['TN_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['TN_Turn_M']?></td>
    <td rowspan="4"><?=$row['TN_Turn_P']?></td>
    <td rowspan="4"><?=$row['TN_Turn_PR']?></td>
    <td rowspan="4"><?=$row['TN_Turn_PD']?></td>
    <td rowspan="4"><?=$row['TN_Turn_T']?></td>
    <td rowspan="4"><?=$row['TN_Turn_F']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['TN_Turn_R_B']?></td>
    <td><?=$row['TN_Turn_OU_B']?></td>
    <td><?=$row['TN_Turn_RE_B']?></td>
    <td><?=$row['TN_Turn_ROU_B']?></td>
    <td><?=$row['TN_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['TN_Turn_R_C']?></td>
    <td><?=$row['TN_Turn_OU_C']?></td>
    <td><?=$row['TN_Turn_RE_C']?></td>
    <td><?=$row['TN_Turn_ROU_C']?></td>
    <td><?=$row['TN_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['TN_Turn_R_D']?></td>
    <td><?=$row['TN_Turn_OU_D']?></td>
    <td><?=$row['TN_Turn_RE_D']?></td>
    <td><?=$row['TN_Turn_ROU_D']?></td>
    <td><?=$row['TN_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
	<td><?=$row['TN_R_Scene']?></td>
    <td><?=$row['TN_OU_Scene']?></td>
	<td><?=$row['TN_RE_Scene']?></td>
	<td><?=$row['TN_ROU_Scene']?></td>
    <td><?=$row['TN_EO_Scene']?></td>
    <td><?=$row['TN_M_Scene']?></td>
    <td><?=$row['TN_P_Scene']?></td>
    <td><?=$row['TN_PR_Scene']?></td>
    <td><?=$row['TN_PD_Scene']?></td>
    <td><?=$row['TN_T_Scene']?></td>
    <td><?=$row['TN_F_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn ghi chú</td>
    <td><?=$row['TN_R_Bet']?></td>
    <td><?=$row['TN_OU_Bet']?></td>
    <td><?=$row['TN_RE_Bet']?></td>
    <td><?=$row['TN_ROU_Bet']?></td>
    <td><?=$row['TN_EO_Bet']?></td>
    <td><?=$row['TN_M_Bet']?></td>
    <td><?=$row['TN_P_Bet']?></td>
    <td><?=$row['TN_PR_Bet']?></td>
    <td><?=$row['TN_PD_Bet']?></td>
    <td><?=$row['TN_T_Bet']?></td>
    <td><?=$row['TN_F_Bet']?></td>
  </tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
<td> Bóng chuyền </td>
     <td width = "68"> Đưa bóng </td>
     <td width = "68"> Kích thước </td>
     <td width = "68"> Lăn bóng </td>
     <td width = "68"> Kích thước bi lăn </td>
     <td width = "68"> Đơn và đôi </td>
     <td width = "68"> Chỉ giành chiến thắng </td>
     <td width = "68"> Giải phóng mặt bằng tiêu chuẩn </td>
     <td width = "68"> Để bóng đi qua </td>
     <td width = "68"> Làn sóng </td>
     <td width = "68"> Đi vào bóng </td>
     <td width = "68"> Half full court </td>
  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu hồi<font color="#CC0000">A</font></td>
    <td><?=$row['VB_Turn_R_A']?></td>
    <td><?=$row['VB_Turn_OU_A']?></td>
    <td><?=$row['VB_Turn_RE_A']?></td>
    <td><?=$row['VB_Turn_ROU_A']?></td>
    <td><?=$row['VB_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['VB_Turn_M']?></td>
    <td rowspan="4"><?=$row['VB_Turn_P']?></td>
    <td rowspan="4"><?=$row['VB_Turn_PR']?></td>
    <td rowspan="4"><?=$row['VB_Turn_PD']?></td>
    <td rowspan="4"><?=$row['VB_Turn_T']?></td>
    <td rowspan="4"><?=$row['VB_Turn_F']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['VB_Turn_R_B']?></td>
    <td><?=$row['VB_Turn_OU_B']?></td>
    <td><?=$row['VB_Turn_RE_B']?></td>
    <td><?=$row['VB_Turn_ROU_B']?></td>
    <td><?=$row['VB_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['VB_Turn_R_C']?></td>
    <td><?=$row['VB_Turn_OU_C']?></td>
    <td><?=$row['VB_Turn_RE_C']?></td>
    <td><?=$row['VB_Turn_ROU_C']?></td>
    <td><?=$row['VB_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['VB_Turn_R_D']?></td>
    <td><?=$row['VB_Turn_OU_D']?></td>
    <td><?=$row['VB_Turn_RE_D']?></td>
    <td><?=$row['VB_Turn_ROU_D']?></td>
    <td><?=$row['VB_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
	<td><?=$row['VB_R_Scene']?></td>
    <td><?=$row['VB_OU_Scene']?></td>
	<td><?=$row['VB_RE_Scene']?></td>
	<td><?=$row['VB_ROU_Scene']?></td>
    <td><?=$row['VB_EO_Scene']?></td>
    <td><?=$row['VB_M_Scene']?></td>
    <td><?=$row['VB_P_Scene']?></td>
    <td><?=$row['VB_PR_Scene']?></td>
    <td><?=$row['VB_PD_Scene']?></td>
    <td><?=$row['VB_T_Scene']?></td>
    <td><?=$row['VB_F_Scene']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn ghi chú</td>
    <td><?=$row['VB_R_Bet']?></td>
    <td><?=$row['VB_OU_Bet']?></td>
    <td><?=$row['VB_RE_Bet']?></td>
    <td><?=$row['VB_ROU_Bet']?></td>
    <td><?=$row['VB_EO_Bet']?></td>
    <td><?=$row['VB_M_Bet']?></td>
    <td><?=$row['VB_P_Bet']?></td>
    <td><?=$row['VB_PR_Bet']?></td>
    <td><?=$row['VB_PD_Bet']?></td>
    <td><?=$row['VB_T_Bet']?></td>
    <td><?=$row['VB_F_Bet']?></td>
  </tr>
</table><BR><table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
<td> bóng chày </td>
     <td width = "68"> Đưa bóng </td>
     <td width = "68"> Kích thước </td>
     <td width = "68"> Lăn bóng </td>
     <td width = "68"> Kích thước bi lăn </td>
     <td width = "68"> Đơn và đôi </td>
     <td width = "68"> Chỉ giành chiến thắng </td>
     <td width = "68"> Giải phóng mặt bằng tiêu chuẩn </td>
     <td width = "68"> Để bóng đi qua </td>
     <td width = "68"> Giải phóng mặt bằng toàn diện </td>
     <td width = "68"> Làn sóng </td>
     <td width = "68"> Đi vào bóng </td>

  </tr>
  <tr  class="m_cen">
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu<font color="#CC0000">A</font></td>
    <td><?=$row['BS_Turn_R_A']?></td>
    <td><?=$row['BS_Turn_OU_A']?></td>
    <td><?=$row['BS_Turn_RE_A']?></td>
    <td><?=$row['BS_Turn_ROU_A']?></td>
    <td><?=$row['BS_Turn_EO_A']?></td>
    <td rowspan="4"><?=$row['BS_Turn_M']?></td>
    <td rowspan="4"><?=$row['BS_Turn_P']?></td>
    <td rowspan="4"><?=$row['BS_Turn_PR']?></td>
    <td rowspan="4"><?=$row['BS_Turn_PC']?></td>
    <td rowspan="4"><?=$row['BS_Turn_PD']?></td>
    <td rowspan="4"><?=$row['BS_Turn_T']?></td>

  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
    <td><?=$row['BS_Turn_R_B']?></td>
    <td><?=$row['BS_Turn_OU_B']?></td>
    <td><?=$row['BS_Turn_RE_B']?></td>
    <td><?=$row['BS_Turn_ROU_B']?></td>
    <td><?=$row['BS_Turn_EO_B']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
    <td><?=$row['BS_Turn_R_C']?></td>
    <td><?=$row['BS_Turn_OU_C']?></td>
    <td><?=$row['BS_Turn_RE_C']?></td>
    <td><?=$row['BS_Turn_ROU_C']?></td>
    <td><?=$row['BS_Turn_EO_C']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
    <td><?=$row['BS_Turn_R_D']?></td>
    <td><?=$row['BS_Turn_OU_D']?></td>
    <td><?=$row['BS_Turn_RE_D']?></td>
    <td><?=$row['BS_Turn_ROU_D']?></td>
    <td><?=$row['BS_Turn_EO_D']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
	<td><?=$row['BS_R_Scene']?></td>
    <td><?=$row['BS_OU_Scene']?></td>
	<td><?=$row['BS_RE_Scene']?></td>
	<td><?=$row['BS_ROU_Scene']?></td>
    <td><?=$row['BS_EO_Scene']?></td>
    <td><?=$row['BS_M_Scene']?></td>
    <td><?=$row['BS_P_Scene']?></td>
    <td><?=$row['BS_PR_Scene']?></td>
    <td><?=$row['BS_PC_Scene']?></td>
    <td><?=$row['BS_PD_Scene']?></td>
    <td><?=$row['BS_T_Scene']?></td>

  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">Giới hạn ghi chú</td>
    <td><?=$row['BS_R_Bet']?></td>
    <td><?=$row['BS_OU_Bet']?></td>
    <td><?=$row['BS_RE_Bet']?></td>
    <td><?=$row['BS_ROU_Bet']?></td>
    <td><?=$row['BS_EO_Bet']?></td>
    <td><?=$row['BS_M_Bet']?></td>
    <td><?=$row['BS_P_Bet']?></td>
    <td><?=$row['BS_PR_Bet']?></td>
    <td><?=$row['BS_PC_Bet']?></td>
    <td><?=$row['BS_PD_Bet']?></td>
    <td><?=$row['BS_T_Bet']?></td>

  </tr>
</table>
<!----------------------结帐视窗1---------------------------->
<div id=rs_window style="display: none;position:absolute">
  <form name=rs_form action="" method=post onSubmit="return Chk_acc();">
    <input type=hidden name=rtype value="">
<input type=hidden name=act value="N">
<input type=hidden name=sid value="<?=$agents_id?>">
<input type=hidden name=id value="<?=$mid?>">
<input type=hidden name=kind value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
  <tr>
    <td bgcolor="#FFFFFF">
          <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix">
            <tr bgcolor="0163A2">
          <td width="200" id=r_title><font color="#FFFFFF">&nbsp;Vui lòng nhập</font></td>
          <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
            <tr bgcolor="#A4C0CE">
              <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr align="center">
                    <td>A Đĩa</td>
                    <td>B Đĩa</td>
                    <td>C Đĩa</td>
                     <td>D Đĩa</td>
                  </tr>
                  <tr align="center">
                    <td>
                      <select class="za_select" name="war_set_1">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_2">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_3">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_4">
                      </select>
                    </td>
                  </tr>
                </table>
              </td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">Giới hạn đơn&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SC" value="" size=8 maxlength=8 class="za_text" onKeyUp="count_so(1)"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">Giới hạn ghi chú&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SO" value="" size=8 maxlength=8 class="za_text"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
              <td colspan="2" align="center">
                <input type=submit name=rs_ok value="Xác định" class="za_button">
              </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>
<!----------------------结帐视窗1---------------------------->
<!----------------------结帐视窗2---------------------------->
<div id=rs_window_2 style="display: none;position:absolute">
  <form name=rs_form_2 action="" method=post onSubmit="return Chk_acc2();">
    <input type=hidden name=rtype value="">
<input type=hidden name=act value="N">
<input type=hidden name=sid value="<?=$agents_id?>">
<input type=hidden name=id value="<?=$mid?>">
<input type=hidden name=kind value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
  <tr>
    <td bgcolor="#FFFFFF">
            <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix">
              <tr bgcolor="0163A2">
          <td width="200" id=r_title_2><font color="#FFFFFF">&nbsp;Vui lòng nhập</font></td>
          <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win_2();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">Cài đặt thu &nbsp;&nbsp;<select class="za_select" name="war_set_1">
                  </select></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">Giới hạn đơn &nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SC_2" value="" size=8 maxlength=8 class="za_text" onKeyUp="count_so(2)"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">Giới hạn ghi &nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SO_2" value="" size=8 maxlength=8 class="za_text"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
                <td colspan="2" align="center">
                  <input type=submit name=rs_ok value="Xác định" class="za_button">
                </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>
<!----------------------结帐视窗2---------------------------->
</body>
</html>
<?
mysql_close();
?>
