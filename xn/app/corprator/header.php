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
	window.open("/xn/app/other_set/grp_ip_view.php?uid="+uid+"&layer="+LAYER,"GRP_IP","width=350,height=430,toolbar=yes,scrollbars=yes,resizable=no,personalbar=no");
}

</script>
<body onLoad="show_webs();" oncontextmenu="window.event.returnValue=false"  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" >

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="183"><img src="/images/800/800_top_01.gif" width="183" height="29"></td>
    <td class="top_color">登入1--<?=$agname?>
	<? if($d1set['d1_ag_online_show']==1){ ?>
	<a href='system/syslog.php?uid=<?=$uid?>' target="main"><span style='color:#FFFF66'>代理在线</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<? } ?>
	<? if($d1set['d1_mem_online_show']==1){ ?>
	<a href='system/memlog.php?uid=<?=$uid?>' target="main"><span style='color:#FFFF66'>会员在线</span></a>
	<? } ?>
	<div class="rig">
                    <a href="/url.html" target="_blank" >最新网址</a>
                    | <a href="javascript:void(0);" OnClick="" class="customer"><img src="/images/control/header_customer.gif" width="16" height="15" border="0">在线客服</a>
                    | <a href="javascript:void(0);" OnClick=""><font class="service">联系我们</font></a>
					| <a href="#" onClick="Go_Chg_pass(2);" style="cursor:hand">变更密码</a>
                    | <a href="/quit.php?level=3&uid=<?=$uid?>" target="_top" onMouseOver="window.status='登出'; return true;" onMouseOut="window.status='';return true;">登出</a>
      </div>
	</td>
  </tr>
  <tr>
    <td><img src="/images/800/800_top_02.gif" width="183" height="21"></td>
    <td  class="coolBar">
	<table border="0" cellspacing="0" cellpadding="0"  style="position: relative; z-index: 99; top: 0px; left: 0px;" id="toolbar1">
	<tr>
	<td nowrap class="coolButton" onClick="show_webs('ad');">&nbsp;<nobr>[即时注单]</nobr>&nbsp;</td>
	<td id=ad_list style="color: blue;"><nobr>
	<a onClick="go_web(0,0,'/xn/app/corprator/real_wager/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">足球</a>
	<a onClick="go_web(0,1,'/xn/app/corprator/real_wager_BK/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">篮球/美足</a>
	<a onClick="go_web(0,0,'/xn/app/corprator/real_wager_TN/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">网球</a>
	<a onClick="go_web(0,0,'/xn/app/corprator/real_wager_VB/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">排球</a>
	<a onClick="go_web(0,0,'/xn/app/corprator/real_wager_BS/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">棒球</a>
	<a onClick="go_web(0,1,'/xn/app/corprator/voucher.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">流水注单</a>
	</nobr></td>
	<td nowrap class="coolButton" onClick="show_webs('mad');">&nbsp;<nobr>[早餐注单]</nobr>&nbsp;</td>
	<td id=mad_list style="color: blue;"><nobr>
	<a onClick="go_web(0,1,'/xn/app/corprator/real_wager_FU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">足球早餐</a>
	<a onClick="go_web(0,1,'/xn/app/corprator/real_wager_BU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">篮球/美足早餐</a>
	<a onClick="go_web(0,1,'/xn/app/corprator/real_wager_BSFU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">棒球早餐</a>
	<a onClick="go_web(0,0,'/xn/app/corprator/real_wager_TU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">网球早餐</a>
	<a onClick="go_web(0,0,'/xn/app/corprator/real_wager_VU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">排球早餐</a>
	</nobr></td>
	
	
	
	<<?=$CFLAG_S?>td nowrap class="coolButton" onClick="show_webs('mo');">&nbsp;<nobr>[帐号管理]</nobr>&nbsp;</td>
	<td id=mo_list style="color: blue;"><nobr>
	<a onClick="go_web(1,1,'/xn/app/corprator/cor_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">股东</a>
	<a onClick="go_web(1,1,'/xn/app/corprator/super_agent/body_super_agents.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">总代理</a>
	<a onClick="go_web(1,2,'/xn/app/corprator/agents/su_agents.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">代理</a>
	<a onClick="go_web(1,3,'/xn/app/corprator/members/su_members.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">会员</a>
	<a onClick="go_web(1,4,'/xn/app/corprator/su_subuser.php?uid=<?=$uid?>');" style="cursor:hand;"><img src="/images/control/tri.gif">子帐号</a>
	<? if($d1set['d1_wager_add']==1){ ?>
	<a onClick="go_web(1,6,'/xn/app/corprator/wager_list/wager_add.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">添单帐号</a>
	<? } ?>
	<? if($d1set['d1_wager_hide']==1){ ?>
	<a onClick="go_web(1,7,'/xn/app/corprator/wager_list/wager_hide.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">隐单帐号</a>
	<? } ?>
	</nobr></td<?=$GFLAG_E?>>
	<td nowrap><a href="/xn/app/corprator/report_new/report.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='报表'; return true;" onMouseOut="window.status='';return true;">&nbsp;[报表]</a></td>
	<<?=$GFLAG_S?>td nowrap><a href="/xn/app/corprator/other_set/show_currency.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='币值'; return true;" onMouseOut="window.status='';return true;">&nbsp;[币值]</a></td>
	<td nowrap><a href="/xn/app/corprator/other_set/show_result.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='赛果'; return true;" onMouseOut="window.status='';return true;">&nbsp;[赛果]</a></td<?=$GFLAG_E?>>
	<td nowrap><A HREF="javascript://" style="cursor:hand;color:#bb0000" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>&scoll_set=scoll_set3','','help:no')">&nbsp;[历史讯息]</a></td>
	<td nowrap><A HREF="javascript://" style="cursor:hand;color:#bb0000" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>&scoll_set=scoll_cor_set','','help:no')">&nbsp;[股东历史讯息]</a></td>
	<td nowrap><a href="/xn/app/corprator/body_home.php?uid=<?=$uid?>&langx=<?=$langx?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='公告'; return true;" onMouseOut="window.status='';return true;">&nbsp;[公告]</a></td>
	</tr>
	</table>
    </td>
  </tr>
</table>
</body>
</html>