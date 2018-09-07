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
top.str_FT = "足球";
top.str_FS = "冠军";
top.str_BK = "篮球";
top.str_TN = "网球";
top.str_VB = "排球";
top.str_BS = "棒球";
top.str_OP = "其他";
top.str_RB = "滚球";
top.str_SFS = "特殊冠军";

//信用额度
top.str_maxcre = "总信用额度仅能输入数字!!";

top.str_gopen = "开放";
top.str_gameclose = "关闭";
top.str_gopenY = "是否确定赛程开放";
top.str_gopenN = "是否确定赛程关闭";
top.str_strongH = "是否确定强弱互换";
top.str_strongC = "是否确定强弱互换";
top.str_close_ioratio = "是否确定关闭赔率";
top.str_checknum = "验证码错误,请重新输入";

//新冠军
top.str_scoreY = "负";
top.str_scoreN = "胜";
top.str_change = "确定重置结果!!";
top.str_eliminate = "是否淘汰";
top.str_format = "请填入正确格式";
top.str_close_time = "是否确定关闭时间??"
top.str_check_date = "请检查日期格式 !!";
top.str_champ_win = "冠军是否为:";
top.str_champ_wins = "请再确认冠军是否为:";
top.str_NOchamp = "无胜出队伍，请重新设定!!";
top.str_NOloser = "无淘汰队伍，请重新设定!!";

//帐号
top.str_co = "股东";
top.str_su = "总代理";
top.str_ag = "代理商";
top.str_mem = "会员";
top.str_input_account = "帐号请务必输入!!";
top.str_input_alias = "名称请务必输入!!";
top.str_input_credit = "总信用额度请务必输入!!";
top.str_confirm_add_su = "是否确定写入总代理?";
top.str_confirm_add_ag = "是否确定写入代理商?";
top.chk_input_use_date = "是否确定写入会员资料?";
top.str_sub_select ="请选择类型帐号!!";
top.str_mem_ag="请务必选择代理商!!";
top.str_input_pwd_self="安全代码请勿和帐号密码相同!!";
top.str_input_name="会员名称请务必输入!!";
top.str_use_length="帐号至少4个字元长!!!";
top.str_use_ag_chg_Detail="你已变更此之会员代理商~~请重新设定该会员之详细设定!!";
top.str_Pre_inquiry_use="请输入预查询之帐号!";
top.str_Pre_inquiry_use1="请输入查询帐号!!";
top.ck_del_user="确定删除帐号??";
top.str_safe_paswrd="安全代码";
top.str_longinuser="登录帐号";
top.str_confirm_enableY = "是否确定\"启用\"该";
top.str_confirm_enableN = "是否确定\"停用\"该";
top.str_confirm_enableS = "是否确定\"暂停\"该";
top.str_input_please = "请输入";
top.str_water_set = "退水";

//成数
top.str_winloss_set = "占成数";
top.str_err_default_winloss = "预设成数不可有 [ - ] 号";
top.str_confirm_default_winloss1 = "预设的成数将在 ";
top.str_confirm_default_winloss2 = " 后生效!!确认预设吗?";
top.str_default = "预设";
top.str_err_winloss_range = " 总代理及代理商的成数总和须在 5 - 8 成内 , 请重新设定 !! ";

//密码
top.str_input_pwd = "密码请务必输入!!";
top.str_input_repwd = "确认密码请务必输入!!";
top.str_input_pwd2 = top.str_input_pwd;
top.str_input_repwd2 = top.str_input_repwd;
top.str_pwd_limit = "您的密码必须6至12个字元长,您只能使用数字和英文字母并至少 1 个英文字母,其他特殊符号不能使用 。";
top.str_pwd_limit1 = "安全代码最少必须有2个英文大小写字母和数字(0~9)组合输入限制(6~12字元)";
top.str_pwd_limit2 = "您的密码需使用字母加上数字!!";
top.str_err_pwd = "密码确认错误,请重新输入!!";
top.str_err_pwd_fail = "该密码您已使用过, 为了安全起见, 请使用新密码!!";

top.str_input_longin_id = "登录帐号请务必输入!!";
top.str_longin_limit1 = "登录帐号最少必须有2个英文大小写字母和数字(0~9)组合输入限制(6~12字元)";
top.str_longin_limit2 = "您的登录帐号需使用字母加上数字!!";

//私域网址
top.dPrivate = "私域";
top.dPublic = "公有";
top.grep = "群组";
top.grepIP = "群组IP";
top.IP_list = "IP列表";
top.Group = "组别";
top.choice = "请选择";
top.webset="资讯网";

top.str_oddf="盘口玩法请务必输入";

top.str_PlsSel = "请选择";
top.str_please_select = "请选择";

top.strRtypeSP = new Array();
top.strRtypeSP["PGF"]="最先进球";
top.strRtypeSP["OSF"]="最先越位";
top.strRtypeSP["STF"]="最先替补球员";
top.strRtypeSP["CNF"]="第一颗角球";
top.strRtypeSP["CDF"]="第一张卡";
top.strRtypeSP["RCF"]="会进球";
top.strRtypeSP["YCF"]="第一张黄卡";
top.strRtypeSP["GAF"]="有失球";
top.strRtypeSP["PGL"]="最后进球";
top.strRtypeSP["OSL"]="最后越位";
top.strRtypeSP["STL"]="最后替补球员";
top.strRtypeSP["CNL"]="最后一颗角球";
top.strRtypeSP["CDL"]="最后一张卡";
top.strRtypeSP["RCL"]="不会进球";
top.strRtypeSP["YCL"]="最后一张黄卡";
top.strRtypeSP["GAL"]="没有失球";
top.strRtypeSP["PG"]="最先/最后进球球队";
top.strRtypeSP["OS"]="最先/最后越位球队";
top.strRtypeSP["ST"]="最先/最后替补球员球队";
top.strRtypeSP["CN"]="第一颗/最后一颗角球";
top.strRtypeSP["CD"]="第一张/最后一张卡";
top.strRtypeSP["RC"]="会进球/不会进球";
top.strRtypeSP["YC"]="第一张/最后一张黄卡";
top.strRtypeSP["GA"]="有失球/没有失球";

//停權
top.str_confirm_enable_priY = "是否确定\"启用\"该";
top.str_confirm_enable_priN = "是否确定\"禁止登入\"该";
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>登入1</title>
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
                                    <span id="sel_langx" name="sel_langx" class="lang_txt">简体</span>
                                </div>
                            </div>
                            <? if($d1set['d1_ag_online_show']==1){ ?>
                                <a href='system/syslog.php?uid=<?=$uid?>' target="main"><span style='color:#FFFF66'>代理在线</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <? } ?>
                            <? if($d1set['d1_mem_online_show']==1){ ?>
                                <a href='system/memlog.php?uid=<?=$uid?>' target="main"><span style='color:#FFFF66'>会员在线</span></a>
                            <? } ?>

                            <div id="uesr_code" class="uesr_code"><span style="color:#7e1414;">登入1--<?=$agname?><span style="padding-left:7px;">|<a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status='登出'; return true;" onMouseOut="window.status='';return true;" style="color: #1e1e1e;padding: 7px;">登出</a>|<a href="#" onClick="Go_Chg_pass(2);" style="color:#8C8B8B;padding-left:3px;padding-right:7px;">变更密码</a></div>
                            <div id="contactus" class="contact_us" onclick="notice();">联系我们</div>
                            <div id="live_chat" class="live_chat" style="width: 52px;" onclick="notice();">在线客服</div>
                            <div id="new_url" class="new_url"><a href="/url.html" style="color:#5b534f" target="main" onMouseOver="window.status='最新网址'; return true;" onMouseOut="window.status='';return true;">最新网址</a></div>
                        </div>
                    </div>
                    <div class="navbox">
                        <div class="nav">

                            <li class="drop-menu-effect"><a href="/app/corprator/body_home.php?uid=<?=$uid?>&langx=<?=$langx?>"
                                                            target="main" onMouseOver="window.status='首页'; return true;" onMouseOut="window.status='';return true;">
                                    <span>首页</span></a>
                            </li>
                            <li class="drop-menu-effect"><a href="/app/corprator/announcement/get_an.php?uid=<?=$uid?>&langx=<?=$langx?>" target="main" onMouseOver="window.status='公告内容'; return true;" onMouseOut="window.status='';return true;"><span>公告内容</span></a>
                            </li>

                            <li class="drop-menu-effect"> <a href="/app/corprator/other_set/show_result.php?uid=<?=$uid?>"
                                                             target="main" onMouseOver="window.status='赛果'; return true;" onMouseOut="window.status='';return true;"><span>赛果</span></a>
                            </li>
                            <li class="drop-menu-effect"> <a href="/app/corprator/other_set/show_currency.php?uid=<?=$uid?>"
                                                             target="main" onMouseOver="window.status='币值'; return true;" onMouseOut="window.status='';return true;"><span>币值</span></a>
                            </li>
                            <li class="drop-menu-effect"> <a href="/app/corprator/cor_list.php?uid=<?=$uid?>" target="main" onMouseOver="window.status='帐号管理'; return true;" onMouseOut="window.status='';return true;"><span>帐号管理</span></a>
                            </li>

                            <li class="drop-menu-effect"> <a href="/app/corprator/report_new/report.php?uid=<?=$uid?>"
                                                             target="main" onMouseOver="window.status='报表'; return true;" onMouseOut="window.status='';return true;"><span>报表</span></a>
                            </li>
                            <li class="drop-menu-effect"> <a href="/app/corprator/scroll_history.php?uid=<?=$uid?>"
                                                             target="main" onMouseOver="window.status='历史讯息'; return true;" onMouseOut="window.status='';return true;"><span>历史讯息</span></a>
                            </li>
                        </div>
                    </div>
                </div>

                <div id="lang_select" class="lang_select" style="display:none;" tabindex="9527">
                    <span id="lang_en-us">ENG</span>
                    <span id="lang_zh-cn">简体</span>
                    <span id="lang_zh-tw">繁體</span>
                </div>
                <div id="user_select" class="user_select" style="display:none;" tabindex="9527">
                    <span id="chg_pass"><a href="#" onClick="Go_Chg_pass(2);">变更密码</a></span>
                    <span id="logout"><a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status='登出'; return true;" onMouseOut="window.status='';return true;" style="color: #000000;">登出</a></span>
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
            alert("该模块即将上线，敬请期待！");
        }
    </script>
<?
mysql_close();
?>