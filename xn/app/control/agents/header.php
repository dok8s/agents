<?
Session_start();
if (!$_SESSION["bkbk"])
{
    echo "<script>window.open('/index.php','_top')</script>";
    exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
//Tổng số thành viên
$sql = "select * from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$agents = mysql_fetch_array($result);
$agname=$agents['Agname'];

$sql="select  count(*) as count from web_member where Agents='$agname' AND Status=1";
$web_marquee = mysql_query($sql);
$row = mysql_fetch_array($web_marquee);
$member_count=$row['count'];

$sql = "select id,subuser,agname,passwd_safe,subname,status,wager from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
    echo "<script>window.open('$site/index.php','_top')</script>";
    exit;
}

$row = mysql_fetch_array($result);
$agname=$row['agname'];
$passwd_safe=$row['passwd_safe'];
$subuser=$row['subuser'];
$wager=$row['wager']+0;
if ($subuser==1 || $row['status']==2){
    $PFLAG_S='';
    $GFLAG_S='!--';
    $PFLAG_E='';
    $GFLAG_E='--';
    $CFLAG_S='!--';
    $CFLAG_E='--';
}else{

    if($wager==0){
        $CFLAG_S='';
        $PFLAG_S='!--';
        $GFLAG_S='!--';
        $PFLAG_E='--';
        $GFLAG_E='--';
        $CFLAG_E='';
    }else{
        $CFLAG_S='';
        $PFLAG_S='!--';
        $GFLAG_S='';
        $PFLAG_E='--';
        $GFLAG_E='';
        $CFLAG_E='';
    }
}
?>
<script>
  top.str_FT = "Bóng đá";
  top.str_FS = "Quán quân";
  top.str_BK = "Bóng rổ";
  top.str_TN = "Quần vợt";
  top.str_VB = "Bóng chuyền";
  top.str_BS = "Bóng chày";
  top.str_OP = "Khác";
  top.str_RB = "Cán bóng";
  top.str_SFS = "Nhà vô địch đặc biệt";

  //信用额度
  top.str_maxcre = "Tổng hạn mức tín dụng chỉ có thể nhập số!!";

  top.str_gopen = "Mở";
  top.str_gameclose = "Đóng";
  top.str_gopenY = "Bạn có chắc chắn lịch biểu đang mở?";
  top.str_gopenN = "Bạn có chắc chắn lịch biểu đã bị đóng không?";
  top.str_strongH = "Bạn có chắc chắn về các giao dịch hoán đổi mạnh và yếu không?";
  top.str_strongC = "Bạn có chắc chắn về các giao dịch hoán đổi mạnh và yếu không?";
  top.str_close_ioratio = "Bạn có chắc chắn để đóng tỷ lệ cược?";
  top.str_checknum = "Mã xác minh không chính xác, vui lòng nhập lại";

  //新冠军
  top.str_scoreY = "Phủ định";
  top.str_scoreN = "Thắng";
  top.str_change = "Xác định kết quả đặt lại!!";
  top.str_eliminate = "Liệu có nên loại bỏ";
  top.str_format = "Vui lòng điền đúng định dạng";
  top.str_close_time = "Cho dù để xác định thời gian đóng cửa??"
  top.str_check_date = "Vui lòng kiểm tra định dạng ngày !!";
  top.str_champ_win = "Là nhà vô địch:";
  top.str_champ_wins = "Vui lòng xác nhận xem nhà vô địch có:";
  top.str_NOchamp = "Không có đội chiến thắng, vui lòng đặt lại!!";
  top.str_NOloser = "Không có nhóm loại trừ, vui lòng đặt lại!!";

  //帐号
  top.str_co = "Cổ đông";
  top.str_su = "Trụ sở chính";
  top.str_ag = "Đại lý";
  top.str_mem = "Thành viên";
  top.str_input_account = "Vui lòng nhập số tài khoản của bạn!!";
  top.str_input_alias = "Vui lòng đảm bảo nhập tên!!";
  top.str_input_credit = "Vui lòng nhập tổng hạn mức tín dụng!!";
  top.str_confirm_add_su = "Bạn có chắc chắn để viết Đại lý?";
  top.str_confirm_add_ag = "Bạn có chắc chắn để viết Đại lý?";
  top.chk_input_use_date = "Bạn có chắc chắn để viết Thành viên Thông tin?";
  top.str_sub_select ="Vui lòng chọn một loại tài khoản!!";
  top.str_mem_ag="Hãy chắc chắn để lựa chọn Đại lý!!";
  top.str_input_pwd_self="Mã bảo mật không được giống như mật khẩu tài khoản!!";
  top.str_input_name="Thành viênVui lòng đảm bảo nhập tên!!";
  top.str_use_length="Tài khoản dài ít nhất 4 ký tự!!!";
  top.str_use_ag_chg_Detail="你已变更此之Thành viênĐại lý商~~请重新设定该Thành viên之详细设定!!";
  top.str_Pre_inquiry_use="Vui lòng nhập số tài khoản được truy vấn trước!";
  top.str_Pre_inquiry_use1="Vui lòng nhập tài khoản truy vấn!!";
  top.ck_del_user="Xác nhận xóa tài khoản??";
  top.str_safe_paswrd="Mã bảo mật";
  top.str_longinuser="Đăng nhập tài khoản";
  top.str_confirm_enableY = "Có ổn không?\"Bật\"Các";
  top.str_confirm_enableN = "Có ổn không?\"Tắt\"Các";
  top.str_confirm_enableS = "Có ổn không?\"Tạm ngưng\"Các";
  top.str_input_please = "Vui lòng nhập";
  top.str_water_set = "Retreat";

  //成数
  top.str_winloss_set = "Nghề nghiệp";
  top.str_err_default_winloss = "Không thể đặt trước số đặt trước [ - ] Số";
  top.str_confirm_default_winloss1 = "Số mặc định sẽ là ";
  top.str_confirm_default_winloss2 = " Hiệu quả sau!!Xác nhận mặc định??";
  top.str_default = "Đặt trước";
  top.str_err_winloss_range = " 总Đại lý及Đại lý商的成数总和须在 5 - 8 成内 , 请重新设定 !! ";

  //密码
  top.str_input_pwd = "Vui lòng nhập mật khẩu của bạn;
  top.str_input_repwd = "Vui lòng xác nhận mật khẩu và nhập mật khẩu.!!";
  top.str_input_pwd2 = top.str_input_pwd;
  top.str_input_repwd2 = top.str_input_repwd;
  top.str_pwd_limit = "Mật khẩu của bạn phải dài từ 6 đến 12 ký tự, bạn chỉ có thể sử dụng số và chữ cái tiếng Anh và ít nhất 1 chữ cái tiếng Anh. 。";
  top.str_pwd_limit1 = "Mã bảo mật phải có ít nhất 2 chữ hoa và chữ thường và chữ số (0 ~ 9) giới hạn đầu vào kết hợp (6 ~ 12 ký tự)";
  top.str_pwd_limit2 = "Mật khẩu của bạn yêu cầu một chữ cái và một số!!";
  top.str_err_pwd = "Lỗi xác nhận mật khẩu, vui lòng nhập lại!!";
  top.str_err_pwd_fail = "Mật khẩu này đã được sử dụng. Để bảo mật cho bạn, vui lòng sử dụng mật khẩu mới.!!";

  top.str_input_longin_id = "Vui lòng đăng nhập để đăng nhập!!";
  top.str_longin_limit1 = "Tài khoản đăng nhập phải có ít nhất 2 chữ cái tiếng Anh và chữ thường và chữ số (0 ~ 9) giới hạn đầu vào kết hợp (6 ~ 12 ký tự)";
  top.str_longin_limit2 = "Tài khoản đăng nhập của bạn yêu cầu một chữ cái và một số!!";

  //私域网址
  top.dPrivate = "Miền riêng";
  top.dPublic = "Công khai";
  top.grep = "Nhóm";
  top.grepIP = "IP nhóm";
  top.IP_list = "Danh sách IP";
  top.Group = "Nhóm";
  top.choice = "Vui lòng chọn";
  top.webset="Mạng thông tin";

  top.str_oddf="Hãy nhớ nhập trò chơi";

  top.str_PlsSel = "Vui lòng chọn";
  top.str_please_select = "Vui lòng chọn";

  top.strRtypeSP = new Array();
  top.strRtypeSP["PGF"]="Bóng tiên tiến nhất";
  top.strRtypeSP["OSF"]="Việt vị đầu tiên";
  top.strRtypeSP["STF"]="Người chơi thay thế đầu tiên";
  top.strRtypeSP["CNF"]="Cú đá phạt góc đầu tiên";
  top.strRtypeSP["CDF"]="Thẻ đầu tiên";
  top.strRtypeSP["RCF"]="Điểm số sẽ";
  top.strRtypeSP["YCF"]="Thẻ vàng đầu tiên";
  top.strRtypeSP["GAF"]="Đã thừa nhận";
  top.strRtypeSP["PGL"]="Mục tiêu cuối cùng";
  top.strRtypeSP["OSL"]="Việt vị cuối cùng";
  top.strRtypeSP["STL"]="Người chơi băng ghế dự bị cuối cùng";
  top.strRtypeSP["CNL"]="Quả phạt góc cuối cùng";
  top.strRtypeSP["CDL"]="Thẻ cuối cùng";
  top.strRtypeSP["RCL"]="Sẽ không ghi bàn";
  top.strRtypeSP["YCL"]="Thẻ vàng cuối cùng";
  top.strRtypeSP["GAL"]="Không thừa nhận";
  top.strRtypeSP["PG"]="Đầu tiên/Đội mục tiêu cuối cùng";
  top.strRtypeSP["OS"]="Đầu tiên/Đội việt vị cuối cùng";
  top.strRtypeSP["ST"]="Đầu tiên/ Đội chơi thay thế cuối cùng";
  top.strRtypeSP["CN"]="Đầu tiên/Quả phạt góc cuối cùng";
  top.strRtypeSP["CD"]="Đầu tiên/Thẻ cuối cùng";
  top.strRtypeSP["RC"]="Điểm số sẽ/Sẽ không ghi bàn";
  top.strRtypeSP["YC"]="Đầu tiên/Thẻ vàng cuối cùng";
  top.strRtypeSP["GA"]="Đã thừa nhận/Không thừa nhận";

  //停權
  top.str_confirm_enable_priY = "Có ổn không?\"Bật\"Các";
  top.str_confirm_enable_priN = "Có ổn không?\"Không đăng nhập\"Các";
</script>
<html>
<head>
  <title>-Đại lý Giao diện kinh doanh</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="/style/control/control_header.css" type="text/css">
  <link rel="stylesheet" href="/style/home.css" type="text/css">
</head>
<script src="/js/wmenu.js" type="text/javascript"></script>
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script type="text/javascript">
  <!--
  document.onmousedown = initDown;
  document.onmouseup   = initUp;
  document.onmousemove = initMove;
  ad_count=0;
  mad_count=0;
  mo_count=0;
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

    switch(sw){
      case'ad':
        if (ad_count==0){
          ad_list.style.display='block';
          ad_count=1;
          mad_count=0;
          mo_count=0;
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
        }else{
          mo_list.style.display='none';
          mo_count=0;
        }
        break;
    }
  }
  function go_web(sw1,sw2,sw3) {
    if(sw1==1 && sw2==5){Go_Chg_pass(1);}
    else{window.open('../trans.php?sw1='+sw1+'&sw2='+sw2+'&sw3='+sw3,'main');}
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
  function openWin(obj_Name){
    var obj = document.getElementById(obj_Name);
    obj.style.display = (obj.style.display == "none")? "block": "none";
    obj.style.left = event.clientX-150;
  }
  function onclickDown(){
    var uid="<?=$uid?>";
    var langx="{LANGX}";
    window.open("getVworldheader.php?uid="+uid+"&langx="+langx,"showVworld","width=1024,height=768,toolbar=no,scrollbars=yes,resizable=no,personalbar=no");
    //parent.window.location.href = "./getVworldheader.php?uid="+uid+"&langx="+langx;
  }

</script>
<body onLoad="show_webs();" oncontextmenu="window.event.returnValue=false"  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <div id="header_show" style="position: fixed;width:100%;z-index:99; top:0px;"><div>
        <div name="MaxTag" id="header" src="/js/header.js" linkage="header">
          <div id="header_div">
            <div id="header_tr" name="fixHead" class="top_option_contain">
              <div id="header_td" class="lang_contain">
                <div id="lang_btn" class="lang_btn">
                  <span id="sel_langx" name="sel_langx" class="lang_txt">Đơn giản hóa</span>
                </div>
              </div>
              <div id="online_mem" class="online_btn" title="">Tổng số thành viên: <span id="online_mem_count"><?=$member_count?></span></div>

              <div id="uesr_code" class="uesr_code"><span style="color:#7e1414;">Đăng nhập 3--<?=$agname?>--<?=$passwd_safe?><span style="padding-left:7px;">|<a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status='Đăng xuất'; return true;" onMouseOut="window.status='';return true;" style="color: #1e1e1e;padding: 7px;">Đăng xuất</a>|<a href="#" onClick="Go_Chg_pass(2);" style="color:#8C8B8B;padding-left:3px;padding-right:7px;">Thay đổi mật khẩu</a></div>
                <div id="contactus" class="contact_us" onclick="notice();">Liên lạc với chúng tôi</div>
              <div id="live_chat" class="live_chat" style="width: 52px;" onclick="notice();">Dịch vụ khách hàng trực tuyến</div>
              <div id="new_url" class="new_url"><a href="/url.html" style="color:#5b534f" target="main" onMouseOver="window.status='URL mới nhất'; return true;" onMouseOut="window.status='';return true;">URL mới nhất</a></div>
            </div>
          </div>
                <div class="navbox">
                    <div class="nav">

                        <li class="drop-menu-effect"><a href="/xn/app/control/agents/body_home.php?uid=<?$uid?>&langx=<?=$langx?>"
                                                        target="main" onMouseOver="window.status='Trang chủ'; return true;" onMouseOut="window.status='';return true;">
                                <span>Trang chủ</span></a>
                        </li>
                        <li class="drop-menu-effect"><a href="/xn/app/control/agents/announcement/get_an.php?uid=<?$uid?>&langx=<?=$langx?>" target="main" onMouseOver="window.status='Nội dung thông báo'; return true;" onMouseOut="window.status='';return true;"><span>Nội dung thông báo</span></a>
                        </li>

                        <li class="drop-menu-effect"> <a href="/xn/app/control/agents/other_set/show_result.php?uid=<?=$uid?>"
                                                         target="main" onMouseOver="window.status='Kết quả'; return true;" onMouseOut="window.status='';return true;"><span>Kết quả</span></a>
                        </li>
                        <li class="drop-menu-effect"> <a onclick="notice();"
                                                         target="main" onMouseOver="window.status='Hệ thống tiền mặt'; return true;" onMouseOut="window.status='';return true;"><span>Hệ thống tiền mặt</span></a>
                        </li>
                        <li class="drop-menu-effect"> <a href="/xn/app/control/agents/ag_list.php?uid=<?$uid?>" target="main" onMouseOver="window.status='Quản lý tài khoản'; return true;" onMouseOut="window.status='';return true;"><span>Quản lý tài khoản</span></a>
                            <div class="submenu">
                                <div class="mj_menu_pro_bg">
                                    <div class="mj_menu_pro_main">
                                        <div class="mj_menu_pro_li">
                                            <div class="mj_menu_li_txt">
                                                <a href="/xn/app/control/agents/ag_list.php?uid=<?=$uid?>"
                                                   target="main" onMouseOver="window.status='Đại lý'; return true;" onMouseOut="window.status='';return true;">Đại lý</font></a><br />
                                            </div>
                                        </div>
                                        <div class="mj_menu_pro_li" style="padding-left:48px;">
                                            <div class="mj_menu_li_txt">
                                                <a href="/xn/app/control/agents/members/ag_members.php?uid=<?=$uid?>"
                                                   target="main" onMouseOver="window.status='Thành viên'; return true;" onMouseOut="window.status='';return true;"><font>Thành viên</font></a><br />
                                            </div>
                                        </div>
                                        <div class="mj_menu_pro_li" style="padding-left:48px;">
                                            <div class="mj_menu_li_txt">
                                                <a href="/xn/app/control/agents/ag_subuser.php?uid=<?=$uid?>"
                                                   target="main" onMouseOver="window.status='Tài khoản phụ'; return true;" onMouseOut="window.status='';return true;"><font>Tài khoản phụ</font></a><br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="drop-menu-effect"> <a href="/xn/app/control/agents/report/report.php?uid=<?=$uid?>"
                                                         target="main" onMouseOver="window.status='Báo cáo'; return true;" onMouseOut="window.status='';return true;"><span>Báo cáo</span></a>
                        </li>
                      <li class="drop-menu-effect"> <a href="/xn/app/control/agents/scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>"
                                                       target="main" onMouseOver="window.status='Thông tin lịch sử'; return true;" onMouseOut="window.status='';return true;"><span>Thông tin lịch sử</span></a>
                      </li>
                    </div>
                </div>
          </div>

          <div id="lang_select" class="lang_select" style="display:none;" tabindex="9527">
            <span id="lang_en-us">ENG</span>
            <span id="lang_zh-cn">Đơn giản hóa</span>
            <span id="lang_zh-tw">繁體</span>
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
        lanrenzhijia(".drop-menu-effect");
        $('.nav li').click(function(){
            $(this).addClass('highlight').siblings().removeClass('highlight');
        })
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
