<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");
$uid=$_REQUEST["uid"];
$mysql="select Agname,ID,status from web_corprator where Oid='$uid'";
$result = mysql_query($mysql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$langx=$_REQUEST["langx"];
$sql = "select id,subuser,agname,subname,status,super,setdata from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$super=$row['super'];
$d1set = @unserialize($row['setdata']);

if ($row['subuser']==1 or $row['status']==2){
	$PFLAG_S='';
	$GFLAG_S='!--';
	$PFLAG_E='';
	$GFLAG_E='--';
	$CFLAG_S='!--';
}else{
	$PFLAG_S='!--';
	$GFLAG_S='';
	$PFLAG_E='--';
	$GFLAG_E='';
	$CFLAG_E='';
}

$sql = "select setdata,d1edit from web_super where agname='$super'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$d0set = @unserialize($row['setdata']);
$d0set['d1_edit']=$row['d1edit'];
foreach($d1set as $k=>$v){
	if($v==1 && substr($k,0,2)=='d1'){
		$d1set[$k] = $d0set[$k];
	}
}

?>
<script>
top.str_FT = "Bóng đá";
top.str_FS = "Champion";
top.str_BK = "Bóng rổ";
top.str_TN = "quần vợt";
top.str_VB = "Bóng chuyền";
top.str_BS = "bóng chày";
top.str_OP = "Khác";
top.str_RB = "Rolling Ball";
top.str_SFS = "Nhà vô địch đặc biệt";

// giới hạn tín dụng
Top.str_maxcre = "Tổng hạn mức tín dụng chỉ có thể nhập số !!";

Top.str_gopen = "Mở";
Top.str_gameclose = "Đóng";
top.str_gopenY = "Lịch trình đã được xác nhận chưa?"
top.str_gopenN = "Lịch trình đã được xác nhận chưa?"
top.str_strongH = "Có trao đổi độ mạnh không?"
top.str_strongC = "Có trao đổi độ mạnh không?"
Top.str_close_ioratio = "Chắc chắn đóng các tỷ lệ cược";
Top.str_checknum = "Lỗi mã xác nhận, vui lòng nhập lại";

// nhà vô địch mới
top.str_scoreY = "negative";
top.str_scoreN = "Win";
Top.str_change = "OK để thiết lập lại kết quả !!";
Top.str_eliminate = "Cho dù để loại bỏ";
Top.str_format = "Hãy điền đúng định dạng";
Top.str_close_time = "Bạn có chắc chắn đóng thời gian không?"
Top.str_check_date = "Hãy kiểm tra định dạng ngày !!";
Top.str_champ_win = "Cho dù nhà vô địch có:";
Top.str_champ_wins = "Hãy xác nhận xem nhà vô địch có:";
top.str_NOchamp = "Không có đội chiến thắng, hãy đặt lại !!";
top.str_NOloser = "Không có nhóm loại trừ, hãy đặt lại !!";

// tài khoản
Top.str_co = "Cổ đông";
Top.str_su = "Đại lý chung";
Top.str_ag = "Đại lý";
Top.str_mem = "Thành viên";
Top.str_input_account = "Tài khoản phải được nhập !!";
Top.str_input_alias = "Tên phải được nhập !!";
Top.str_input_credit = "Tổng hạn mức tín dụng phải được nhập !!";
Top.str_confirm_add_su = "Có chắc chắn để viết các đại lý?";
Top.str_confirm_add_ag = "Bạn có chắc chắn viết thư cho tác nhân không?";
Top.chk_input_use_date = "Có thể viết thông tin thành viên được không?"
Top.str_sub_select = "Hãy chọn loại tài khoản !!";
Top.str_mem_ag = "Hãy chọn tác nhân !!";
Top.str_input_pwd_self = "Mã bảo vệ và mật khẩu tài khoản giống nhau !!";
Top.str_input_name = "Tên thành viên phải được nhập !!";
Top.str_use_length = "Tài khoản dài ít nhất 4 ký tự !!!";
top.str_use_ag_chg_Detail = "Bạn đã thay đổi cơ quan thành viên này ~~ Hãy thiết lập lại các thiết lập chi tiết của thành viên !!";
top.str_Pre_inquiry_use = "Vui lòng nhập số tài khoản trước khi truy vấn!";
top.str_Pre_inquiry_use1 = "Vui lòng nhập tài khoản truy vấn !!";
Top.ck_del_user = "OK để xóa tài khoản ??";
Top.str_safe_paswrd = "Mã bảo mật";
Top.str_longinuser = " nhập tài khoản";
top.str_confirm_enableY = "Chắc chắn \" đã bật \ "này";
top.str_confirm_enableN = "Có OK \" vô hiệu hóa \ "này";
top.str_confirm_enableS = "Chắc chắn" tạm dừng "";
Top.str_input_please = "Vui lòng nhập";
Top.str_water_set = "Backwater";

// vào một vài
Top.str_winloss_set = "lấy số";
Top.str_err_default_winloss = "Số đặt trước không thể có [-]";
Top.str_confirm_default_winloss1 = "Số cài sẵn sẽ ở" ;;
Top.str_confirm_default_winloss2 = "Sau khi có hiệu lực !! Xác nhận mặc định?";
Top.str_default = "cài sẵn";
Top.str_err_winloss_range = "Tổng số nhà phân phối và đại lý phải nằm trong khoảng 5 - 8, vui lòng cài lại !!";

// mật khẩu
Top.str_input_pwd = "Mật khẩu phải được nhập !!";
Top.str_input_repwd = "Xác nhận mật khẩu phải được nhập !!";
Top.str_input_pwd2 = top.str_input_pwd;
Top.str_input_repwd2 = top.str_input_repwd;
top.str_pwd_limit = "Mật khẩu của bạn phải là 6-12 ký tự, bạn chỉ có thể sử dụng số và chữ cái, và ít nhất một chữ cái tiếng Anh, biểu tượng đặc biệt khác có thể không được sử dụng.";
top.str_pwd_limit1 = "mã bảo vệ phải có ít nhất hai chữ cái viết bằng tiếng Anh và số (0-9) kết hợp của các giới hạn đầu vào (6-12 ký tự)";
Top.str_pwd_limit2 = "Mật khẩu của bạn phải dùng chữ cái cộng với số !!";
Top.str_err_pwd = "Mật khẩu không chính xác, vui lòng nhập lại !!";
Top.str_err_pwd_fail = "Mật khẩu này đã được sử dụng. Vì mục đích an toàn, hãy sử dụng mật khẩu mới !!";

Top.str_input_longin_id = " nhập Vui lòng nhập !!"
top.str_longin_limit1 = "đăng nhập tài khoản phải có ít nhất hai chữ cái viết bằng tiếng Anh và số (0-9) kết hợp của các giới hạn đầu vào (6-12 ký tự)";
Top.str_longin_limit2 = "Tài khoản đăng nhập của bạn cần sử dụng chữ cái cộng với số !!";

// URL miền riêng
top.dPrivate = "Riêng tư";
top.dPublic = "Công khai";
Top.grep = "nhóm";
top.grepIP = "Nhóm IP";
top.IP_list = "Danh sách IP";
top.Group = "Nhóm";
Top.choice = "Vui lòng chọn";
Top.webset = "Mạng thông tin";

Top.str_oddf = "Hãy chắc chắn để vào trò chơi";

top.str_PlsSel = "Vui lòng chọn";
Top.str_please_select = "Hãy chọn";

top.strRtypeSP = new Array();
top.strRtypeSP ["PGF"] = "Quả bóng tiên tiến nhất";
top.strRtypeSP ["OSF"] = "Offside đầu tiên";
top.strRtypeSP ["STF"] = "Người chơi thay thế đầu tiên";
top.strRtypeSP ["CNF"] = "Góc đầu tiên";
top.strRtypeSP ["CDF"] = "Thẻ đầu tiên";
top.strRtypeSP ["RCF"] = "Sẽ ghi điểm";
top.strRtypeSP ["YCF"] = "Thẻ vàng đầu tiên";
top.strRtypeSP ["GAF"] = "Bối rối";
top.strRtypeSP ["PGL"] = "điểm số cuối cùng";
top.strRtypeSP ["OSL"] = "việt vị cuối cùng";
top.strRtypeSP ["STL"] = "người chơi thay thế cuối cùng";
top.strRtypeSP ["CNL"] = "Cú đá góc cuối cùng";
top.strRtypeSP ["CDL"] = "thẻ cuối cùng";
top.strRtypeSP ["RCL"] = "sẽ không ghi điểm";
top.strRtypeSP ["YCL"] = "thẻ vàng cuối cùng";
top.strRtypeSP ["GAL"] = "Không bị thừa nhận";
top.strRtypeSP ["PG"] = "Đội ghi bàn đầu tiên / cuối cùng";
top.strRtypeSP ["OS"] = "Đội offside đầu tiên / cuối cùng";
top.strRtypeSP ["ST"] = "Đội chơi sao lưu đầu tiên / cuối cùng";
top.strRtypeSP ["CN"] = "cú đá góc đầu tiên / cuối cùng";
top.strRtypeSP ["CD"] = "Thẻ đầu tiên / cuối cùng";
top.strRtypeSP ["RC"] = "sẽ ghi điểm / sẽ không ghi điểm";
top.strRtypeSP ["YC"] = "Thẻ vàng đầu tiên / cuối cùng";
top.strRtypeSP ["GA"] = "Conceded / Unconcealed";

//停權
top.str_confirm_enable_priY = "Chắc chắn \" Đã bật \ "này";
top.str_confirm_enable_priN = "OK để vô hiệu hóa đăng nhập?"
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>1</title>
<link rel="stylesheet" href="/style/control/control_header.css" type="text/css">
<script src="/js/lock.js" type="text/javascript"></script>
<script src="/js/wmenu.js" type="text/javascript"></script>
</head>
<script type="text/javascript">
<!--
document.onmousedown = initDown;
document.onmouseup   = initUp;
document.onmousemove = initMove;
ad_count=0;
mad_count=0;
mo_count=0;
rp_count=0;
function initDown() {
	doDown();
	moveme_onmousedown();
}
function initUp() {
	doUp();
	moveme_onmouseup();
}
function initMove() {
	moveme_onmousemove();
}
//-->
function show_webs(sw) {
	try{
		ad_list.style.display='none';
	}catch(e){
	}
	try{
		mad_list.style.display='none';
	}catch(e){
	}
	try{
		mo_list.style.display='none';
	}catch(e){
	}
	try{
		rp_list.style.display='none';
	}catch(e){
	}
	switch(sw){
		case'ad':
			if (ad_count==0){
				ad_list.style.display='block';
				ad_count=1;
				mad_count=0;
				mo_count=0;
				rp_count=0;
			}else{
				ad_list.style.display='none';
				ad_count=0;
			}
			break;
		case'mad':
			if (mad_count==0){
				mad_list.style.display='block';
				ad_count=0;
				mad_count=1;
				mo_count=0;
				rp_count=0;
			}else{
				mad_list.style.display='none';
				mad_count=0;
			}
			break;
		case'mo':
			if (mo_count==0){
				mo_list.style.display='block';
				mo_count=1;
				ad_count=0;
				mad_count=0;
				rp_count=0;
			}else{
				mo_list.style.display='none';
				mo_count=0;
			}
			break;
		case'rp':
			if (rp_count==0){
				rp_list.style.display='block';
				mo_count=0;
				ad_count=0;
				mad_count=0;
				rp_count=1;
			}else{
				rp_list.style.display='none';
				rp_count=0;
			}
			break;
	}
}
function go_web(sw1,sw2,sw3) {
	if(sw1==1 && sw2==5){Go_Chg_pass(1);}
	else{window.open('corp.php?sw1='+sw1+'&sw2='+sw2+'&sw3='+sw3,'main');}
}
function Go_Chg_pass(a){
  var uid="<?=$uid?>";
  Real_Win=window.open("chg_passwd.php"+"?uid="+uid+"&flag="+a,"main","width=255,height=135,status=no");
}
function ShowNumber(){
	var uid="<?=$uid?>";
	var LAYER="ag";
	window.open("/app/other_set/grp_ip_view.php?uid="+uid+"&layer="+LAYER,"GRP_IP","width=350,height=430,toolbar=yes,scrollbars=yes,resizable=no,personalbar=no");
}

</script>
<body onLoad="show_webs();" oncontextmenu="window.event.returnValue=false"  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" >

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="183"><img src="/images/800/800_top_01.gif" width="183" height="29"></td>
    <td class="top_color"> nhập1--<?=$agname?>
	<? if($d1set['d1_ag_online_show']==1){ ?>
	<a href='system/syslog.php?uid=<?=$uid?>' target="main"><span style='color:#FFFF66'>Diễn xuất trực tuyến</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<? } ?>
	<? if($d1set['d1_mem_online_show']==1){ ?>
	<a href='system/memlog.php?uid=<?=$uid?>' target="main"><span style='color:#FFFF66'>Thành viên trực tuyến</span></a>
	<? } ?>
	<div class="rig">
                    <a href="/url.html" target="_blank" >Trang web mới nhất</a>
                    | <a href="javascript:void(0);" OnClick="" class="customer"><img src="/images/control/header_customer.gif" width="16" height="15" border="0">Dịch vụ khách hàng trực tuyến</a>
                    | <a href="javascript:void(0);" OnClick=""><font class="service">Liên lạc với chúng tôi</font></a>
					| <a href="#" onClick="Go_Chg_pass(2);" style="cursor:hand">Thay đổi mật khẩu</a>
                    | <a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status=' xuất'; return true;" onMouseOut="window.status='';return true;"> xuất</a>
      </div>
	</td>
  </tr>
  <tr>
    <td><img src="/images/800/800_top_02.gif" width="183" height="21"></td>
    <td  class="coolBar">
	<table border="0" cellspacing="0" cellpadding="0"  style="position: relative; z-index: 99; top: 0px; left: 0px;" id="toolbar1">
	<tr>
	<td nowrap class="coolButton" onClick="show_webs('ad');">&nbsp;<nobr>[Ghi chú tức thì]</nobr>&nbsp;</td>
	<td id=ad_list style="color: blue;"><nobr>
	<a onClick="go_web(0,0,'/app/corprator/real_wager/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bóng đá</a>
	<a onClick="go_web(0,1,'/app/corprator/real_wager_BK/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bóng rổ / Mizuo </a>
	<a onClick="go_web(0,0,'/app/corprator/real_wager_TN/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Quần vợt</a>
	<a onClick="go_web(0,0,'/app/corprator/real_wager_VB/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bóng chuyền</a>
	<a onClick="go_web(0,0,'/app/corprator/real_wager_BS/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bóng chày</a>
	<a onClick="go_web(0,1,'/app/corprator/voucher.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Lưu ý luồng</a>
	</nobr></td>
	<td nowrap class="coolButton" onClick="show_webs('mad');">&nbsp;<nobr>[Ghi chú bữa sáng]</nobr>&nbsp;</td>
	<td id=mad_list style="color: blue;"><nobr>
	<a onClick="go_web(0,1,'/app/corprator/real_wager_FU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng bóng đá</a>
	<a onClick="go_web(0,1,'/app/corprator/real_wager_BU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng kiểu Mỹ / Bóng rổ</a>
	<a onClick="go_web(0,1,'/app/corprator/real_wager_BSFU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng bóng chày</a>
	<a onClick="go_web(0,0,'/app/corprator/real_wager_TU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng quần vợt</a>
	<a onClick="go_web(0,0,'/app/corprator/real_wager_VU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng bóng chuyền</a>
	</nobr></td>
	
	
	
	<<?=$CFLAG_S?>td nowrap class="coolButton" onClick="show_webs('mo');">&nbsp;<nobr>[Quản lý tài khoản]</nobr>&nbsp;</td>
	<td id=mo_list style="color: blue;"><nobr>
	<a onClick="go_web(1,1,'/app/corprator/cor_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Cổ đông</a>
	<a onClick="go_web(1,1,'/app/corprator/super_agent/body_super_agents.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Nhà phân phối</a>
	<a onClick="go_web(1,2,'/app/corprator/agents/su_agents.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Quyền</a>
	<a onClick="go_web(1,3,'/app/corprator/members/su_members.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Thành viên</a>
	<a onClick="go_web(1,4,'/app/corprator/su_subuser.php?uid=<?=$uid?>');" style="cursor:hand;"><img src="/images/control/tri.gif">Subaccount</a>
	<? if($d1set['d1_wager_add']==1){ ?>
	<a onClick="go_web(1,6,'/app/corprator/wager_list/wager_add.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Tài khoản đơn Tim</a>
	<? } ?>
	<? if($d1set['d1_wager_hide']==1){ ?>
	<a onClick="go_web(1,7,'/app/corprator/wager_list/wager_hide.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Tài khoản ẩn</a>
	<? } ?>
	</nobr></td><?=$GFLAG_E?>>
	<td nowrap><a href="/app/corprator/report_new/report.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='Báo cáo'; return true;" onMouseOut="window.status='';return true;">&nbsp;[Báo cáo]</a></td>
	<<?=$GFLAG_S?>td nowrap><a href="/app/corprator/other_set/show_currency.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='Giá trị tiền tệ'; return true;" onMouseOut="window.status='';return true;">&nbsp;[Giá trị tiền tệ]</a></td>
	<td nowrap><a href="/app/corprator/other_set/show_result.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='Kết quả'; return true;" onMouseOut="window.status='';return true;">&nbsp;[Kết quả]</a></td><?=$GFLAG_E?>>
	<td nowrap><A HREF="javascript://" style="cursor:hand;color:#bb0000" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>&scoll_set=scoll_set3','','help:no')">&nbsp;[历史讯息]</a></td>
	<td nowrap><A HREF="javascript://" style="cursor:hand;color:#bb0000" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>&scoll_set=scoll_cor_set','','help:no')">&nbsp;[Thông tin lịch sử cổ đông]</a></td>
	<td nowrap><a href="/app/corprator/body_home.php?uid=<?=$uid?>&langx=<?=$langx?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='Thông báo'; return true;" onMouseOut="window.status='';return true;">&nbsp;[Thông báo]</a></td>
	</tr>
	</table>
    </td>
  </tr>
</table>
</body>
</html>