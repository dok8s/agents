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
  <title>-代理商界面</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="/style/control/control_header.css" type="text/css">
  <link rel="stylesheet" href="/style/home.css" type="text/css">
</head>
<script src="/js/wmenu.js" type="text/javascript"></script>
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
    window.open("/app/other_set/grp_ip_view.php?uid="+uid+"&layer="+LAYER,"GRP_IP","width=350,height=430,toolbar=yes,scrollbars=yes,resizable=no,personalbar=no");
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
                  <span id="sel_langx" name="sel_langx" class="lang_txt">简体</span>
                </div>
              </div>
              <div id="online_mem" class="online_btn" title="">线上会员: <span id="online_mem_count">0</span></div>
              <div id="update_browser" class="take_survey" style="display:none;">升级浏览器</div>
              <div id="take_survey" class="take_survey" style="display:none;">线上问卷</div>

              <div id="uesr_code" class="uesr_code">登入3--<?=$agname?>--<?=$passwd_safe?>|<a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status='登出'; return true;" onMouseOut="window.status='';return true;">登出</a></div>
              <div id="problem_account" class="problem_account" title="问题帐户" style="display: none;">
                <span id="problem_account_count" style="display:none;">0</span></div>
              <div id="note" class="note" title="个人公告"><span id="note_count" style="display:none;">0</span></div>
              <div id="contactus" class="contact_us">联系我们</div>
              <div id="live_chat" class="live_chat">在线客服
              </div>
              <div id="new_url" class="new_url"><a href="/url.html" target="_blank" >最新网址</a></div>
            </div>

            <div id="header_tr2" name="fixHead" class="nav_container">
              <div id="back_btn" class="nav_back">&nbsp;</div>
              <div id="home_btn" class="nav_box_on">首页</div>
              <div id="anno_btn" class="nav_box">公告内容</div>
              <div id="bet_btn" class="nav_box">赛果</div>
              <div id="account_btn" class="nav_box">现金系统</div>
              <div id="account_btn" class="nav_box">帐号管理</div>
              <div id="report_btn" class="nav_box">报表</div>
            </div>
          </div>

          <div id="lang_select" class="lang_select" style="display:none;" tabindex="9527">
            <span id="lang_en-us">ENG</span>
            <span id="lang_zh-cn">简体</span>
            <span id="lang_zh-tw">繁體</span>
          </div>
          <div id="user_select" class="user_select" style="display:none;" tabindex="9527">
            <span id="chg_pass"><a href="#" onClick="Go_Chg_pass(2);">变更密码</a></span>
            <span id="logout"><a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status='登出'; return true;" onMouseOut="window.status='';return true;">登出</a></span>
          </div>
          <div name="MaxTag" id="langxMC" src="/js/conf/zh_cn.js" linkage="zh_cn" style="display:none;"></div>
          <div name="MaxTag" id="zh-cn" src="/js/zh-cn.js?7742" style="display:none;"></div>
        </div>
      </div></div>
  </tr>
</table>
</body>
</html>
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
  .nav_box_on, .nav_box:hover {
    color: #FF9999;
    background: url(../../images/control/nav_btn_on.jpg) center bottom no-repeat;
  }
  #home_btn {
    margin: 0 25px 0 20px;
    background-position: center bottom;
  }
</style>
<?
mysql_close();
?>
