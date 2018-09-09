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
top.str_FT = "bóng đá";
top.str_FS = "champion";
top.str_BK = "Bóng rổ";
top.str_TN = "quần vợt";
top.str_VB = "Bóng chuyền";
top.str_BS = "bóng chày";
top.str_OP = "Khác";
top.str_RB = "rolling ball";
top.str_SFS = "Special Champion";

//信用额度
top.str_maxcre = "Tổng hạn mức tín dụng chỉ có thể nhập số !!";
top.str_gopen = "mở";
top.str_gameclose = "Đóng";
top.str_gopenY = "Bạn có chắc là lịch trình đang mở";
top.str_gopenN = "Bạn có chắc là lịch trình đã bị đóng";
top.str_strongH = "Bạn có chắc chắn về các giao dịch hoán đổi mạnh và yếu";
top.str_strongC = "Bạn có chắc chắn về các giao dịch hoán đổi mạnh và yếu";
top.str_close_ioratio = "Bạn có chắc chắn muốn đóng các tỷ lệ cược";
top.str_checknum = "Lỗi mã xác nhận, vui lòng nhập lại";

//新冠军
top.str_scoreY = "negative";
top.str_scoreN = "Win";
top.str_change = "OK đặt lại kết quả !!";
top.str_eliminate = "Bạn có lỗi thời hay không";
top.str_format = "Hãy điền đúng định dạng";
top.str_close_time = "Bạn có chắc chắn thời gian đóng cửa?"
top.str_check_date = "Hãy kiểm tra định dạng ngày !!";
top.str_champ_win = "Là nhà vô địch a:";
top.str_champ_wins = "Hãy xác nhận xem nhà vô địch có:";
top.str_NOchamp = "Không thắng, hãy đặt lại !!";
top.str_NOloser = "Không có nhóm loại trừ, hãy đặt lại !!";

//帐号
top.str_co = "Cổ đông";
top.str_su = "Tổng tác nhân";
top.str_ag = "Agent";
top.str_mem = "Thành viên";
top.str_input_account = "Vui lòng nhập số tài khoản của bạn !!";
top.str_input_alias = "Hãy nhập tên !!";
top.str_input_credit = "Vui lòng nhập tổng hạn mức tín dụng !!";
top.str_confirm_add_su = "Bạn có chắc chắn viết thư cho đại lý chung không?";
top.str_confirm_add_ag = "Bạn có chắc chắn viết thư cho tác nhân không?";
top.chk_input_use_date = "Bạn có chắc chắn viết thông tin thành viên không?";
top.str_sub_select = "Hãy chọn loại tài khoản !!";
top.str_mem_ag = "Hãy chắc chắn chọn một tác nhân !!";
top.str_input_pwd_self = "Không sử dụng cùng một mã bảo vệ như mật khẩu tài khoản !!";
top.str_input_name = "Hãy chắc chắn nhập tên thành viên !!";
top.str_use_length = "Tài khoản dài ít nhất 4 ký tự !!!";
top.str_use_ag_chg_Detail = "Bạn đã thay đổi tác nhân thành viên này ~~ Vui lòng thiết lập lại các thiết lập chi tiết của thành viên !!";
top.str_Pre_inquiry_use = "Vui lòng nhập tài khoản truy vấn trước!";
top.str_Pre_inquiry_use1 = "Vui lòng nhập tài khoản truy vấn !!";
top.ck_del_user = "Bạn có chắc chắn muốn xóa tài khoản?";
top.str_safe_paswrd = "Mã bảo mật";
top.str_longinuser = "Đăng nhập tài khoản";
top.str_confirm_enableY = "Có chắc \" Kích hoạt \ "Điều này";
top.str_confirm_enableN = "Bạn có chắc chắn" để vô hiệu hóa \ "này";
top.str_confirm_enableS = "Bạn có chắc \" Tạm dừng \ "này";
top.str_input_please = "Vui lòng nhập";
top.str_water_set = "Retreat";

//成数
top.str_winloss_set = "chiếm số";
top.str_err_default_winloss = "Số mặc định không thể là [-] số";
top.str_confirm_default_winloss1 = "Số mặc định sẽ ở";
top.str_confirm_default_winloss2 = "Sau khi hiệu lực !! Xác nhận mặc định?";
top.str_default = "Cài sẵn";
top.str_err_winloss_range = "Tổng số nhà phân phối và đại lý phải nằm trong vòng 5 - 8%, hãy đặt lại !!";

//密码
top.str_input_pwd = "Hãy nhập mật khẩu của bạn !!";
top.str_input_repwd = "Hãy xác nhận mật khẩu, vui lòng nhập !!";
top.str_input_pwd2 = top.str_input_pwd;
top.str_input_repwd2 = top.str_input_repwd;
top.str_pwd_limit = "Mật khẩu của bạn phải dài từ 6 đến 12 ký tự. Bạn chỉ có thể sử dụng số và chữ cái tiếng Anh và ít nhất 1 chữ cái tiếng Anh. Các ký hiệu đặc biệt khác không thể sử dụng được.";
top.str_pwd_limit1 = "Mã bảo mật phải có ít nhất 2 chữ hoa và chữ thường và chữ số (0 ~ 9) giới hạn đầu vào kết hợp (6 ~ 12 ký tự)";
top.str_pwd_limit2 = "Mật khẩu của bạn yêu cầu một chữ cái cộng với một số !!";
top.str_err_pwd = "Lỗi xác nhận mật khẩu, vui lòng nhập lại !!";
top.str_err_pwd_fail = "Mật khẩu bạn đã sử dụng, vì lý do bảo mật, hãy sử dụng mật khẩu mới !!";

top.str_input_longin_id = "Hãy nhập tài khoản đăng nhập của bạn !!";
top.str_longin_limit1 = "Tài khoản đăng nhập phải có ít nhất 2 chữ hoa và chữ thường và chữ số (0 ~ 9) giới hạn đầu vào kết hợp (6 ~ 12 ký tự)";
top.str_longin_limit2 = "Tài khoản đăng nhập của bạn yêu cầu một chữ cái cộng với một số !!";

//私域网址
top.dPrivate = "Tên miền riêng";
top.dPublic = "public";
top.grep = "nhóm";
top.grepIP = "Nhóm IP";
top.IP_list = "Danh sách IP";
top.Group = "group";
top.choice = "Vui lòng chọn";
top.webset = "Mạng thông tin";

top.str_oddf = "Hãy chắc chắn nhập game"

top.str_PlsSel = "Vui lòng chọn";
top.str_please_select = "Hãy chọn";

top.strRtypeSP = new Array();
top.strRtypeSP ["PGF"] = "Quả bóng tiên tiến nhất";
top.strRtypeSP ["OSF"] = "việt vị đầu tiên";
top.strRtypeSP ["STF"] = "Người chơi thay thế đầu tiên";
top.strRtypeSP ["CNF"] = "quả phạt góc đầu tiên";
top.strRtypeSP ["CDF"] = "thẻ đầu tiên";
top.strRtypeSP ["RCF"] = "sẽ ghi điểm";
top.strRtypeSP ["YCF"] = "Thẻ vàng đầu tiên";
top.strRtypeSP ["GAF"] = "Có một mục tiêu thừa nhận";
top.strRtypeSP ["PGL"] = "Mục tiêu cuối cùng";
top.strRtypeSP ["OSL"] = "Vị việt vị cuối cùng";
top.strRtypeSP ["STL"] = "Người chơi thay thế cuối cùng";
top.strRtypeSP ["CNL"] = "Quả bóng góc cuối cùng";
top.strRtypeSP ["CDL"] = "thẻ cuối cùng";
top.strRtypeSP ["RCL"] = "Không ghi điểm";
top.strRtypeSP ["YCL"] = "Thẻ vàng cuối cùng";
top.strRtypeSP ["GAL"] = "Không thừa nhận";
top.strRtypeSP ["PG"] = "Đội mục tiêu đầu tiên / cuối cùng";
top.strRtypeSP ["OS"] = "Đội offside đầu tiên / cuối cùng";
top.strRtypeSP ["ST"] = "Đội chơi thay thế đầu tiên / cuối cùng";
top.strRtypeSP ["CN"] = "góc đầu tiên / cuối cùng";
top.strRtypeSP ["CD"] = "thẻ đầu tiên / cuối cùng";
top.strRtypeSP ["RC"] = "sẽ ghi điểm / sẽ không ghi điểm";
top.strRtypeSP ["YC"] = "Thẻ vàng đầu tiên / cuối cùng";
top.strRtypeSP ["GA"] = "Có một sự thừa nhận / không thừa nhận";

//停權
top.str_confirm_enable_priY = "Bạn có chắc \" Enable \ "này";
top.str_confirm_enable_priN = "Bạn có chắc chắn?" bị cấm đăng nhập \ "này";
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Đăng nhập1</title>
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
	window.open("/xn/app/other_set/grp_ip_view.php?uid="+uid+"&layer="+LAYER,"GRP_IP","width=350,height=430,toolbar=yes,scrollbars=yes,resizable=no,personalbar=no");
}

</script>
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<body onLoad="show_webs();" oncontextmenu="window.event.returnValue=false"  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <div id="header_show" style="position: fixed;width:100%;z-index:99; top:0px;"><div>
                <div name="MaxTag" id="header" src="/js/header.js" linkage="header">
                    <div id="header_div">
                        <div id="header_tr" name="fixHead" class="top_option_contain">
                            <div id="header_td" class="lang_contain">
                                <div id="lang_btn" class="lang_btn">
                                    <span id="sel_langx" name="sel_langx" class="lang_txt">Người việt</span>
                                </div>
                            </div>
                            <? if($d1set['d1_ag_online_show']==1){ ?>
                                <a href='system/syslog.php?uid=<?=$uid?>' target="main"><span style='color:#FFFF66'>Đại lý trực tuyến</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <? } ?>
                            <? if($d1set['d1_mem_online_show']==1){ ?>
                                <a href='system/memlog.php?uid=<?=$uid?>' target="main"><span style='color:#FFFF66'>Thành viên trực tuyến</span></a>
                            <? } ?>

                            <div id="uesr_code" class="uesr_code"><span style="color:#7e1414;">Đăng nhập 1--<?=$agname?><span style="padding-left:7px;">|<a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status='Đăng xuất'; return true;" onMouseOut="window.status='';return true;" style="color: #1e1e1e;padding: 7px;">Đăng xuất</a>|<a href="#" onClick="Go_Chg_pass(2);" style="color:#8C8B8B;padding-left:3px;padding-right:7px;">Thay đổi mật khẩu</a></div>
                            <div id="contactus" class="contact_us" onclick="notice();">Liên lạc với chúng tôi</div>
                            <div id="live_chat" class="live_chat" style="width: 52px;" onclick="notice();">Dịch vụ khách</div>
                            <div id="new_url" class="new_url"><a href="/url.html" style="color:#5b534f" target="main" onMouseOver="window.status='URL mới nhất'; return true;" onMouseOut="window.status='';return true;">URL mới nhất</a></div>
                        </div>
                    </div>
                    <div class="navbox">
                        <div class="nav">

                            <li class="drop-menu-effect"><a href="/xn/app/corprator/body_home.php?uid=<?=$uid?>&langx=<?=$langx?>"
                                                            target="main" onMouseOver="window.status='Trang chủ'; return true;" onMouseOut="window.status='';return true;">
                                    <span>Trang chủ</span></a>
                            </li>
                            <li class="drop-menu-effect"><a href="/xn/app/corprator/announcement/get_an.php?uid=<?=$uid?>&langx=<?=$langx?>" target="main" onMouseOver="window.status='Nội dung thông báo'; return true;" onMouseOut="window.status='';return true;"><span>Nội dung thông báo</span></a>
                            </li>

                            <li class="drop-menu-effect"> <a href="/xn/app/corprator/other_set/show_result.php?uid=<?=$uid?>"
                                                             target="main" onMouseOver="window.status='Kết quả'; return true;" onMouseOut="window.status='';return true;"><span>Kết quả</span></a>
                            </li>
                            <li class="drop-menu-effect"> <a href="/xn/app/corprator/other_set/show_currency.php?uid=<?=$uid?>"
                                                             target="main" onMouseOver="window.status='Tiền tệ'; return true;" onMouseOut="window.status='';return true;"><span>Tiền tệ</span></a>
                            </li>
                            <li class="drop-menu-effect"> <a href="/xn/app/corprator/cor_list.php?uid=<?=$uid?>" target="main" onMouseOver="window.status='Quản lý tài khoản'; return true;" onMouseOut="window.status='';return true;"><span>Quản lý tài khoản</span></a>
                            </li>

                            <li class="drop-menu-effect"> <a href="/xn/app/corprator/report_new/report.php?uid=<?=$uid?>"
                                                         target="main" onMouseOver="window.status='Báo cáo'; return true;" onMouseOut="window.status='';return true;"><span>Báo cáo</span></a>
                            </li>
                            <li class="drop-menu-effect"> <a href="/xn/app/corprator/scroll_history.php?uid=<?=$uid?>"
                                                       target="main" onMouseOver="window.status='Thông tin lịch sử'; return true;" onMouseOut="window.status='';return true;"><span>Thông tin lịch sử</span></a>
                            </li>
                        </div>
                    </div>
                </div>

                <div id="lang_select" class="lang_select" style="display:none;" tabindex="9527">
                    <span id="lang_en-us">ENG</span>
            <span id="lang_zh-cn">简体</span>
                    <span id="lang_zh-vn">Người việt</span>
                </div>
                <div id="user_select" class="user_select" style="display:none;" tabindex="9527">
            <span id="chg_pass"><a href="#" onClick="Go_Chg_pass(2);">Thay đổi mật khẩu</a></span>
            <span id="logout"><a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status='Đăng xuất'; return true;" onMouseOut="window.status='';return true;" style="color: #000000;">Đăng xuất</a></span>
                </div>
                <div name="MaxTag" id="langxMC" src="/js/conf/zh_cn.js" linkage="zh_cn" style="display:none;"></div>
                <div name="MaxTag" id="zh-cn" src="/js/zh-cn.js?7742" style="display:none;"></div>
            </div>
        </div>
        </div>
    </tr>
</table>
</body>
</html>
    <style>
        .highlight{
            background-color: #bb1720;
        }
    </style>
    <script>
        $(function(){
            $('.nav>li').hover(function(){
                var $ul=$(this).find('ul');
                var oW=$(this).width();//li
                var otrigW=$(this).find('.trig').width();
                var oNavListL=$('.nav-list').offset().left;
                var oTL=$(this).offset().left-oNavListL;//距离最左边的距离
                var oTR=$('.nav-list').width()-oTL-oW;//距离最右边的距离
                console.log(oNavListL+":"+oTL);

                if($ul.find('li').length>0){
                    $('.second-bg').show();
                    $(this).find('.trig').show();
                    $ul.show();
                    var sum=0;
                    var oLeft=0;
                    for(var i=0;i<$ul.find('li').length;i++){
                        sum+=$ul.find('li').eq(i).width()+4;
                    }
                    $ul.width(sum);
                    oLeft=(sum-oW)/2;
                    if(oLeft>oTL){//到达左侧边界
                        oLeft=oTL;
                        $ul.css('left',-oLeft+'px');
                        return ;
                    }
                    if(oLeft>oTR){
                        $ul.css('right',-oTR+'px');
                        return ;
                    }
                    $ul.css('left',-oLeft+'px');

                }
            },function(){
                $('.second-bg').hide();
                $(this).find('ul').hide();
                $(this).find('.trig').hide();
            });
            lanrenzhijia(".drop-menu-effect");
            $('.nav li').click(function(){
                $(this).addClass('highlight').siblings().removeClass('highlight');
            });
        });
        function lanrenzhijia(_this){
            $(_this).each(function(){
                var $this = $(this);
                var theMenu = $this.find(".submenu");
                var tarHeight = theMenu.height();
                theMenu.css({height:0});
                $this.hover(
                    function(){
                        $(this).addClass("mj_hover_menu");
                        theMenu.stop().show().animate({height:tarHeight},400);
                    },
                    function(){
                        $(this).removeClass("mj_hover_menu");
                        theMenu.stop().animate({height:0},400,function(){
                            $(this).css({display:"none"});
                        });
                    }
                );
            });
        }
    </script>
    <style>
        .top_option_contain {
            position: relative;
            width: 100%;
            height: 35px;
            background-color: #FFFFFF;
            color: #5b534f;
            font-size: 13px;
        }
        .lang_contain {
            margin-left: 20px;
            width: 66px;
            float: left;
            -display: inline;
        }
        .lang_btn {
            background: url(../../images/control/icon_lang.jpg) left no-repeat;
            height: 35px;
            line-height: 35px;
        }
        .lang_txt {
            display: block;
            padding: 0px 0px 0px 19px;
            background: url(../../images/control/icon_arrow.jpg) right no-repeat;
            width: auto;
            cursor: pointer;
        }
        .online_btn {
            margin-left: 27px;
            width: auto;
            height: 35px;
            white-space: nowrap;
            line-height: 35px;
            float: left;
            cursor: pointer;
        }
        .online_btn span {
            color: #7e1414;
        }
        .uesr_code {
            float: right;
            margin-right: 20px;
            -display: inline;
            height: 35px;
            line-height: 35px;
            background: url(../../images/control/icon_arrow.jpg) right no-repeat;
            cursor: pointer;
            padding-right: 22px;
        }
        .note {
            position: relative;
            float: right;
            width: 16px;
            height: 17px;
            background: url(../../images/control/icon_note.png) no-repeat;
            margin-right: 23px;
            margin-top: 12px;
            cursor: pointer;
            z-index: 100;
        }
        .contact_us {
            width: 52px;
            height: 35px;
            float: right;
            line-height: 35px;
            margin-right: 25px;
            cursor: pointer;
        }
        .live_chat {
            width: 70px;
            height: 35px;
            float: right;
            line-height: 35px;
            margin-right: 18px;
            text-align: right;
            cursor: pointer;
            background: url(../../images/control/icon_chat.jpg) no-repeat left center;
        }
        .new_url {
            height: 35px;
            line-height: 35px;
            float: right;
            margin-right: 25px;
            cursor: pointer;
        }
        .nav_container {
            position: relative;
            clear: both;
            width: 100%;
            height: 40px;
            background-color: #7E1414;
            color: #FFFFFF;
            font-size: 15px;
        }
        .nav_back {
            margin: 0;
            width: 40px;
            background: url(../../images/control/nav_back.gif) no-repeat 0 0;
        }
        .nav_box, .nav_box_on, .nav_back {
            float: left;
            height: 40px;
            text-align: center;
            line-height: 40px;
            display: inline;
            cursor: pointer;
            margin: 0 25px;
            text-transform: uppercase;
        }
        .nav_box_on, .nav_box, .top_a:hover {
            color: #FF9999;
            background: url(../../images/control/nav_btn_on.jpg) center bottom no-repeat;
        }
        #home_btn {
            margin: 0 25px 0 20px;
            background-position: center bottom;
        }
        .top_a {
            float: left;
            height: 40px;
            text-align: center;
            line-height: 40px;
            display: inline;
            cursor: pointer;
            margin: 0 25px;
            text-transform: uppercase;
            color: #ffffff;
        }
        a:visited {
            text-decoration: none;
            color: #ffffff;
        }
        a:link {
            text-decoration: none;
            color: #ffffff;
        }
        .navbox{height:40px;position:relative;z-index:9; margin:auto;background:#7E1414;filter:alpha(opacity=90);-moz-opacity:0.90;opacity:0.90;font-family:'微软雅黑';}
        .nav{width:1002px;height:40px; list-style:none;}
        .nav li{float:left;height:40px;position:relative; list-style:none;}
        .nav li.last{background:none;}
        .nav li a{text-decoration:none;}
        .nav li a span{float:left;display:block;line-height:40px;font-size:14px;color:#ffffff;cursor:pointer;width:143px;text-align:center; }
        .mj_hover_menu{text-decoration:none; width:143px; background:url(images/menu_hover.jpg); height:40px;}
        .nav li.selected .submenu{display:block;z-index: 1000;}
        .nav li .submenu{display:none;position:absolute;top:40px;left:-9px;}
        .nav li .submenu li{float:none;padding:0;background:none;height:auto;border-bottom:dotted 0px #BEBEBE;}
        .mj_menu_pro_bg{width:825px; height:235px; background:url(images/menu_pro_bg.png) no-repeat;}
        .mj_menu_pro_main{width:765px; margin:auto; padding-top:12px;}
        .mj_menu_pro_li{ float:left;}
        .mj_menu_li_txt{line-height:22px; font-size:12px; color:#7E1414;}
        .mj_menu_li_txt font{font-size:14px; color:#bb1721;}
        .mj_menu_li_txt a{color:#7E1414; text-decoration:none;}
        .mj_menu_li_txt a:hover{color:#7E1414; text-decoration:underline;}

        .mj_menu_news_bg{width:480px; height:185px; background:url(images/menu_news_bg.png) no-repeat;}
        .mj_menu_news_main{width:440px; margin:auto; padding-top:12px;}
        .mj_menu_news_li{padding:0px 30px; margin-right:30px; height:150px; float:left; border-right:solid 1px #cccccc; }
        .mj_menu_news_img{float:left; text-align:left; color:#bb1721; line-height:30px; font-size:14px;}
        .mj_menu_news_li2{padding:0px 30px; height:150px; float:right; border-left:solid 1px #cccccc; }
        .mj_menu_news_img2{float:left; margin-left:30px; text-align:left; color:#bb1721; line-height:30px; font-size:14px;}
        .mj_menu_news_li3{padding:0px 25px; height:150px; float:right; border-left:solid 1px #cccccc; }
        .mj_menu_news_img3{float:left; margin-left:10px; text-align:left; color:#bb1721; line-height:30px; font-size:14px;}
    </style>
    <script>
        function notice() {
            alert("Mô-đun đang trực tuyến, vì vậy hãy chú ý theo dõi！");
        }
    </script>
<?
mysql_close();
?>