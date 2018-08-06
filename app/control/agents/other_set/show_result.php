<?
error_reporting(E_ALL^E_NOTICE^E_WARNING);
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
$uid   = $_REQUEST['uid'];
$gtype = $_REQUEST['gtype'];
$page  = $_REQUEST['page_no'];
$flag  = $_REQUEST['flag'];
$sql = "select Agname,ID from web_agents where Oid='$uid'";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

if ($flag==''){
	$bdate=date('m-d',time());
}else if($flag=='Y'){
	$bdate=date('m-d',time()-24*60*60);
}
$bdate = '05-14';
if ($gtype==''){
	$gtype='FT';
}
$sql="select mb_team,tg_team,m_date,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as m_time,mb_mid,tg_mid,m_league,mb_inball,tg_inball";

switch($gtype){
case 'FT':
	$table=',mb_inball_hr,tg_inball_hr from foot_match';
	$css='';
	$css1='_ft';
	break;
case 'BK':
	$table=' from bask_match';
	$css='';
	$css1='_ft';
	break;
case 'VB':
	$table=' from volleyball';
	$css='_vb';
	$css1='_vb';
	break;
case 'TN':
	$table=' from tennis';
	$css='_tn';
	$css1='_tn';
	break;
case 'BS':
	$table=' from baseball';
	$css='_bs';
	$css1='_bs';
	break;
default:
	$table='foot_match';
	$css1='_ft';
	$css='';
	$gtype='FT';
	break;
}
if ($gtype=='FT'){
	$sql=$sql.$table." where m_date='".$bdate."' and mid%2=1 and mb_inball!='' order by m_start,mid";
}else{
	$sql=$sql.$table." where m_date='".$bdate."' and mb_inball!='' order by m_start,mid";
}

$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=40;
$page_count=ceil($cou/$page_size);
$offset=($page)*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);

?>
<script>var pg='<?=$page?>';
var t_page='<?=$page_count?>';
var uid='<?=$uid?>';
var flag='<?=$flag?>';
var gtype='<?=$gtype?>';
</script><html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/result/r1.css" type="text/css">
<link rel="stylesheet" href="/style/control/result/r2.css" type="text/css">
<script language="JavaScript"> 
function show_page(){
	var temp="";
	var pg_str=""
	for(var i=0;i<t_page;i++){

		if (pg!=i)
			pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'><font color='#000099'>"+(i+1)+"</font></a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			pg_str=pg_str+"<B><font color='#FF0000'>"+(i+1)+"</font></B>&nbsp;&nbsp;&nbsp;&nbsp;";			
	}
	txt_bodyP= bodyP.innerHTML;			
	txt_bodyP =txt_bodyP.replace("*SHOW_P*",pg_str);    
	pg_txt.innerHTML=txt_bodyP;
}

 function onLoad()
 {
	show_page();
 }

function chg_pg(pg)
{
	self.location = './show_result.php?uid='+uid+'&page_no='+pg+'&flag='+flag+'&gtype='+gtype;
}
 
</SCRIPT>

</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"   onLoad="onLoad()" >
<div id="body_show" style=""><div id="result_all_FT" name="MaxTag" src="/js/result_all_FT.js" linkage="result_all_FT">
		<div id="fastTemplate_ag" name="MaxTag" src="/js/lib/fastTemplate_ag.js" linkage="fastTemplate_ag"></div>
		<!---------- 盘面切换 start ---------->
		<div id="top_nav_container" name="fixHead" class="top_nav_container">
			<div class="bet_MaxTag" name="MaxTag" src="/js/header_totalbets.js" linkage="header_totalbets">
				<div id="overview_btn" class="nav_btn">总览</div>
				<div id="inplay_btn" class="nav_btn">滚球</div>
				<div id="today_btn" class="nav_btn">今日</div>
				<div id="early_btn" class="nav_btn">早盘</div>
				<div id="started_btn" class="nav_btn">已开赛</div>
				<div id="parlay_btn" class="nav_btn">过关</div>
				<div id="outright_btn" class="nav_btn">冠军</div>
				<div id="results_btn" class="nav_btn_on">赛果</div>
				<div id="wmc_btn" class="bet_wager">注单监视视窗<span id="wager_new" class="bet_wager_new"></span></div>
			</div>
		</div>
		<!---------- 盘面切换 end ---------->


		<div id="bet_main" class="bet_main" onresize="setDivSize(this)" style="width: 1280px;">
			<div class="bet_mainpadding">
				<!---------main------------->
				<!---------yallowBTN------------->
				<div class="bet_resultBTNG noFloat">
					<span id="yellowEvent" class="bet_resultBTNon">赛事</span><span id="yellowOutright" class="bet_resultBTN">冠军</span>
				</div>
				<div class="bet_inplayTitle">
        <span class="bet_TitleName">

        <!------特制下拉罢--------->
        <ul class="bet_selectSP" id="gtype_sel"><li><a class="bet_selectSP_first">足球</a>
        	<ul id="sport_sel" class="bet_selectSP_options" style="display:none;">
            	<li id="FT_sel"><a>足球</a></li>
                <li id="BK_sel"><a>篮球 / 美式足球</a></li>
                <li id="TN_sel"><a>网球</a></li>
                <li id="VB_sel"><a>排球</a></li>
                <li id="BM_sel"><a>羽毛球</a></li>
                <li id="TT_sel"><a>乒乓球</a></li>
                <li id="BS_sel"><a>棒球</a></li>
                <li id="SK_sel"><a>斯诺克/台球</a></li>
                <li id="OP_sel"><a>其他球类</a></li>
            </ul>
        </li></ul>
        <h2>赛果</h2></span>
					<div id="bets_search_setting" name="MaxTag" class="bet_DetailTitle" src="/js/bets_search_setting.js" linkage="bets_search_setting">
						<span id="dateresult_span" class="bet_DetailName"><h1 id="dateresult">日期</h1><h2 id="dateresult_set">今日</h2></span>
						<span id="league_span" class="bet_DetailName"><h1 id="league">联盟</h1><h2 id="league_set">所有联盟</h2></span>
					</div>
				</div>

				<div id="div_show">
					<table id="MainTable" cellspacing="0" cellpadding="0" class="bet_MainTable">



						<tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">澳布里斯班女超</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3321728" class="bet_result_closeTR">
							<td id="td_3321728" width="15%" class="bet_result_padTD"><span id="close_btn_3321728" class="bet_resultOpenBTN" style="display: none;"></span><span>08-06 00:01</span></td>
							<td width="45%" class="TDleft">维吉尼亚联(女)  v 潘尼苏拉(女)</td>
							<td width="20%">0 - 1</td>
							<td width="20%" class="noRightLine">2 - 2</td>
						</tr>



						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">俄U21</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3317724" class="bet_result_closeTR">
							<td id="td_3317724" width="15%" class="TDleft"><span id="close_btn_3317724" class="bet_resultOpenBTN"></span><span>08-06 02:00</span></td>
							<td width="45%" class="TDleft">乌法U21  v 安郅马哈奇卡拉U21</td>
							<td width="20%">0 - 0</td>
							<td width="20%" class="noRightLine">0 - 1</td>
						</tr>


						<tr id="openMORE_3317724_PGF" class="bet_result_openTR" style="display: none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">安郅马哈奇卡拉U21</td>
						</tr>

						<tr id="openMORE_3317724_PGL" class="bet_result_openTR" style="display: none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">安郅马哈奇卡拉U21</td>
						</tr>


						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">越杯21外</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3321848" class="bet_result_closeTR">
							<td id="td_3321848" width="15%" class="TDleft"><span id="close_btn_3321848" class="bet_resultOpenBTN"></span><span>08-06 03:30</span></td>
							<td width="45%" class="TDleft">同塔U21  v 平福U21</td>
							<td width="20%">2 - 1</td>
							<td width="20%" class="noRightLine">3 - 1</td>
						</tr>


						<tr id="openMORE_3321848_PGF" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">平福U21</td>
						</tr>

						<tr id="openMORE_3321848_PGL" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">同塔U21</td>
						</tr>


						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">中后备</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3325350" class="bet_result_closeTR">
							<td id="td_3325350" width="15%" class="bet_result_padTD"><span id="close_btn_3325350" class="bet_resultOpenBTN" style="display: none;"></span><span>08-06 04:00</span></td>
							<td width="45%" class="TDleft">河北华夏幸福(后备)  v 天津泰达(后备)</td>
							<td width="20%">1 - 1</td>
							<td width="20%" class="noRightLine">2 - 1</td>
						</tr>


						<!----------close TR-------------->
						<tr id="closeTR_3326628" class="bet_result_closeTR">
							<td id="td_3326628" width="15%" class="bet_result_padTD"><span id="close_btn_3326628" class="bet_resultOpenBTN" style="display: none;"></span><span>08-06 04:00</span></td>
							<td width="45%" class="TDleft">江苏苏宁(后备)  v 贵州恒丰(后备)</td>
							<td width="20%">1 - 0</td>
							<td width="20%" class="noRightLine">3 - 0</td>
						</tr>



						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">澳维20</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3318882" class="bet_result_closeTR">
							<td id="td_3318882" width="15%" class="TDleft"><span id="close_btn_3318882" class="bet_resultOpenBTN"></span><span>08-06 04:30</span></td>
							<td width="45%" class="TDleft">布琳狮子U20  v 帕斯科华伦U20</td>
							<td width="20%">1 - 0</td>
							<td width="20%" class="noRightLine">2 - 2</td>
						</tr>


						<tr id="openMORE_3318882_PGF" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">布琳狮子U20</td>
						</tr>

						<tr id="openMORE_3318882_PGL" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">帕斯科华伦U20</td>
						</tr>


						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">捷克联赛U21</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3318890" class="bet_result_closeTR">
							<td id="td_3318890" width="15%" class="TDleft"><span id="close_btn_3318890" class="bet_resultOpenBTN"></span><span>08-06 05:00</span></td>
							<td width="45%" class="TDleft">斯洛瓦茨科U21  v 布尔诺U21</td>
							<td width="20%">1 - 1</td>
							<td width="20%" class="noRightLine">2 - 2</td>
						</tr>


						<tr id="openMORE_3318890_AGMH" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">0 - 14:59</td>
							<td colspan="2" class="noRightLine">0 - 0</td>
						</tr>

						<tr id="openMORE_3318890_BGMH" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">15 - 29:59</td>
							<td colspan="2" class="noRightLine">0 - 1</td>
						</tr>

						<tr id="openMORE_3318890_CGMH" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">30 – 半场</td>
							<td colspan="2" class="noRightLine">1 - 0</td>
						</tr>

						<tr id="openMORE_3318890_DGMH" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">45 – 59:59</td>
							<td colspan="2" class="noRightLine">0 - 1</td>
						</tr>

						<tr id="openMORE_3318890_EGMH" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">60 – 74:59</td>
							<td colspan="2" class="noRightLine">0 - 0</td>
						</tr>

						<tr id="openMORE_3318890_FGMH" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">75 – 全场</td>
							<td colspan="2" class="noRightLine">1 - 0</td>
						</tr>

						<tr id="openMORE_3318890_ARG" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第一进球</td>
							<td colspan="2" class="noRightLine">布尔诺U21</td>
						</tr>

						<tr id="openMORE_3318890_BRG" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第二进球</td>
							<td colspan="2" class="noRightLine">斯洛瓦茨科U21</td>
						</tr>

						<tr id="openMORE_3318890_CRG" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第三进球</td>
							<td colspan="2" class="noRightLine">布尔诺U21</td>
						</tr>

						<tr id="openMORE_3318890_DRG" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第四进球</td>
							<td colspan="2" class="noRightLine">斯洛瓦茨科U21</td>
						</tr>

						<tr id="openMORE_3318890_ERG" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第五进球</td>
							<td colspan="2" class="noRightLine">否</td>
						</tr>

						<tr id="openMORE_3318890_T1G" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">首个进球时间</td>
							<td colspan="2" class="noRightLine">15 - 29:59</td>
						</tr>

						<tr id="openMORE_3318890_T3G" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">首个进球时间-三项</td>
							<td colspan="2" class="noRightLine">27分钟+</td>
						</tr>

						<tr id="openMORE_3318890_PGF" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">布尔诺U21</td>
						</tr>

						<tr id="openMORE_3318890_PGL" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">斯洛瓦茨科U21</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3318896" class="bet_result_closeTR">
							<td id="td_3318896" width="15%" class="TDleft"><span id="close_btn_3318896" class="bet_resultOpenBTN"></span><span>08-06 05:00</span></td>
							<td width="45%" class="TDleft">卡尔维纳U21  v 奥斯泰华U21</td>
							<td width="20%">1 - 0</td>
							<td width="20%" class="noRightLine">1 - 0</td>
						</tr>


						<tr id="openMORE_3318896_PGF" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">卡尔维纳U21</td>
						</tr>

						<tr id="openMORE_3318896_PGL" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">卡尔维纳U21</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3318894" class="bet_result_closeTR">
							<td id="td_3318894" width="15%" class="TDleft"><span id="close_btn_3318894" class="bet_resultOpenBTN"></span><span>08-06 05:00</span></td>
							<td width="45%" class="TDleft">斯洛瓦茨科U21  v 布尔诺U21</td>
							<td width="20%">4 - 0</td>
							<td width="20%" class="noRightLine">4 - 2</td>
						</tr>


						<tr id="openMORE_3318894_RNC1" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第一个角球</td>
							<td colspan="2" class="noRightLine">斯洛瓦茨科U21</td>
						</tr>

						<tr id="openMORE_3318894_RNC2" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第二个角球</td>
							<td colspan="2" class="noRightLine">斯洛瓦茨科U21</td>
						</tr>

						<tr id="openMORE_3318894_RNC3" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第三个角球</td>
							<td colspan="2" class="noRightLine">斯洛瓦茨科U21</td>
						</tr>

						<tr id="openMORE_3318894_RNC4" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第四个角球</td>
							<td colspan="2" class="noRightLine">斯洛瓦茨科U21</td>
						</tr>

						<tr id="openMORE_3318894_RNC5" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第五个角球</td>
							<td colspan="2" class="noRightLine">布尔诺U21</td>
						</tr>

						<tr id="openMORE_3318894_RNC6" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第六个角球</td>
							<td colspan="2" class="noRightLine">布尔诺U21</td>
						</tr>

						<tr id="openMORE_3318894_RNC7" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">第七个角球</td>
							<td colspan="2" class="noRightLine">没有角球</td>
						</tr>


						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">澳昆士超20</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3318874" class="bet_result_closeTR">
							<td id="td_3318874" width="15%" class="TDleft"><span id="close_btn_3318874" class="bet_resultOpenBTN"></span><span>08-06 05:30</span></td>
							<td width="45%" class="TDleft">威斯顿普德U20  v 瑞德兰茨联U20</td>
							<td width="20%">1 - 1</td>
							<td width="20%" class="noRightLine">5 - 3</td>
						</tr>


						<tr id="openMORE_3318874_PGF" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">瑞德兰茨联U20</td>
						</tr>

						<tr id="openMORE_3318874_PGL" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">威斯顿普德U20</td>
						</tr>


						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">越杯21外</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3321844" class="bet_result_closeTR">
							<td id="td_3321844" width="15%" class="TDleft"><span id="close_btn_3321844" class="bet_resultOpenBTN"></span><span>08-06 05:30</span></td>
							<td width="45%" class="TDleft">胡志明市足球俱乐部U21  v 安江U21</td>
							<td width="20%">0 - 1</td>
							<td width="20%" class="noRightLine">3 - 4</td>
						</tr>


						<tr id="openMORE_3321844_PGF" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">安江U21</td>
						</tr>

						<tr id="openMORE_3321844_PGL" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">安江U21</td>
						</tr>


						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">澳昆士超20</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3318878" class="bet_result_closeTR">
							<td id="td_3318878" width="15%" class="TDleft"><span id="close_btn_3318878" class="bet_resultOpenBTN"></span><span>08-06 05:36</span></td>
							<td width="45%" class="TDleft">布里斯班奥林匹克U20  v 布里斯班城U20</td>
							<td width="20%">1 - 0</td>
							<td width="20%" class="noRightLine">4 - 2</td>
						</tr>


						<tr id="openMORE_3318878_PGF" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">布里斯班奥林匹克U20</td>
						</tr>

						<tr id="openMORE_3318878_PGL" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">布里斯班奥林匹克U20</td>
						</tr>


						</tbody><tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">越杯21外</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>

						<!----------close TR-------------->
						<tr id="closeTR_3321852" class="bet_result_closeTR">
							<td id="td_3321852" width="15%" class="TDleft"><span id="close_btn_3321852" class="bet_resultOpenBTN"></span><span>08-06 05:40</span></td>
							<td width="45%" class="TDleft">贝卡麦克斯U21  v 隆奈U21</td>
							<td width="20%">2 - 0</td>
							<td width="20%" class="noRightLine">3 - 2</td>
						</tr>


						<tr id="openMORE_3321852_PGF" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最先进球</td>
							<td colspan="2" class="noRightLine">贝卡麦克斯U21</td>
						</tr>

						<tr id="openMORE_3321852_PGL" class="bet_result_openTR" style="display:none;">
							<td></td>
							<td class="TDleft">最后进球</td>
							<td colspan="2" class="noRightLine">贝卡麦克斯U21</td>
						</tr>






						<!-- START DYNAMIC BLOCK: WTYPE2 -->
						<tr id="openMORE_*NO*_*WTYPE*" class="*TR_CLASS*" style="display:none;">
							<td></td>
							<td class="TDleft">*MORE_WTYPE*</td>
							<td>*WTYPE_RSH*</td>
							<td colspan="" class="noRightLine">*WTYPE_RSC*</td>
						</tr>
						<!-- END DYNAMIC BLOCK: WTYPE2 -->

						</tbody></table>
				</div>

				<div id="div_model" style="display:none;">
					<table id="MainTable" cellspacing="0" cellpadding="0" class="bet_MainTable">

						<!-- START DYNAMIC BLOCK: RESULT -->

						<tbody><tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
							<td width="60%" colspan="2" class="TDleft">*LEAGUE*</td>
							<td width="20%" class="TDcenter">半场</td>
							<td width="20%" class="TDcenter">全场</td>
						</tr>
						<!-- END DYNAMIC BLOCK: RESULT -->

						<!-- START DYNAMIC BLOCK: GAME -->
						<!----------close TR-------------->
						<tr id="closeTR_*NO*" class="*TR_CLASS*">
							<td id="td_*NO*" width="15%" class="TDleft"><span id="close_btn_*NO*" class="bet_resultOpenBTN"></span><span>*MON*-*MDAY* *TIME*</span></td>
							<td width="45%" class="TDleft">*TEAMH*  v *TEAMC*</td>
							<td width="20%">*HGMH*</td>
							<td width="20%" class="noRightLine">*GMH*</td>
						</tr>

						<!-- END DYNAMIC BLOCK: GAME -->

						<!-- START DYNAMIC BLOCK: WTYPE -->
						<tr id="openMORE_*NO*_*WTYPE*" class="*TR_CLASS*" style="display:none;">
							<td></td>
							<td class="TDleft">*MORE_WTYPE*</td>
							<td colspan="2" class="noRightLine">*WTYPE_RS*</td>
						</tr>
						<!-- END DYNAMIC BLOCK: WTYPE -->

						<!-- START DYNAMIC BLOCK: WTYPE2 -->
						<tr id="openMORE_*NO*_*WTYPE*" class="*TR_CLASS*" style="display:none;">
							<td></td>
							<td class="TDleft">*MORE_WTYPE*</td>
							<td>*WTYPE_RSH*</td>
							<td colspan="" class="noRightLine">*WTYPE_RSC*</td>
						</tr>
						<!-- END DYNAMIC BLOCK: WTYPE2 -->

						</tbody></table>
				</div>

				<!-----pageBTN--------->
				<div id="pageBTN" name="MaxTag" src="/js/lib/Page_ag.js" linkage="Page_ag">
					<div class="bet_pageDIV">
						<ul>
							<li id="btn_first" class="bet_firstBTN" style="display:none;"><a>&nbsp;</a></li>
							<li id="btn_pre" class="bet_preBTN" style="display:none;"><a>&nbsp;</a></li>
							<span id="pageBox">
									<li id="pg_1" class="On" style="display: none;"><a>1</a></li>
								</span>
							<li id="btn_next" class="bet_nextBTN" style="display:none;"><a>&nbsp;</a></li>
							<li id="btn_last" class="bet_lastBTN" style="display:none;"><a>&nbsp;</a></li>
						</ul>
					</div>
					<div id="model_page" style="display:none;">
						<li id="pg_*PAGEID*" class="*PGCLASS*"><a>*PAGEID*</a></li>
					</div>
				</div>
				<!-----pageBTN--------->








			</div>
		</div>
	</div></div>
<FORM NAME="REFORM">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline"> 
      <table border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          
          <td width="100" >&nbsp;&nbsp;
<?
if ($flag==''){
?><A HREF="./show_result.php?uid=<?=$uid?>&gtype=<?=$gtype?>&flag=Y" target="_self">昨日</A>
<?
}else{
?>
<A HREF="./show_result.php?uid=<?=$uid?>&gtype=<?=$gtype?>" target="_self">今日</A>
<?
}
?>
&nbsp;&nbsp;&nbsp;&nbsp;赛程:
</td>
          
        <td width="220" > 
		<A HREF="./show_result.php?uid=<?=$uid?>&gtype=FT" target="_self">[足球]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&gtype=BK" target="_self">[篮球]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&gtype=TN" target="_self">[网球]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&gtype=VB" target="_self">[排球]</A> &nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&gtype=BS" target="_self">[棒球]</A> 
        </td>
        <td>
        <span id="pg_txt"></span>
        </td>
        </tr>
      </table>
    </td>
    
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab<?=$css?>" width="610">
  <tr  class="m_title<?=$css1?>"> 
		<td width="40">时间</td>
		<td width="50" nowrap>联盟</td>
		<td width="40">场次</td>
		<td width="180">队伍</td>
		<?
		if($gtype=='FT' || $gtype=='BS'){
			?>
		<td width="150">上半</td>
		<?
	}
	?>
		<td width="150">完赛</td>
	</tr>
  </tr>
<?
while ($row = mysql_fetch_array($result)){

if(count(explode("PK",$row['m_league']))==1 && count(explode("延时",$row['m_league']))==1){
?>
  <tr  bgcolor='#FFFFFF'> 
    <td><?=$row['m_date']?><BR><?=$row['m_time']?></td>

    <td align='center'><?
	if ($row['m_sleague']==''){
		echo $row['m_league'];
	}else{
		echo $row['m_sleague'];
	}?></td>
    <td ><?=$row['mb_mid']?><br><?=$row['tg_mid']?></td>
    <td ><?=$row['mb_team']?><br><?=$row['tg_team']?></td>
    <!--td ></td-->
<?
		if($gtype=='FT' || $gtype=='BS'){
			if ($row['mb_inball_hr']==-1 || $row['mb_inball_hr']==-1){
				$ball_hr='<font color="#CC0000">赛事延赛</font>';
			}else{
				$ball_hr=$row['mb_inball_hr'].'<br>'.$row['tg_inball_hr'];
			}

			if ($row['mb_inball']==-1 || $row['tg_inball']==-1){
				if ($row['mb_inball_hr']==-1 || $row['mb_inball_hr']==-1){
					$ball='<font color="#CC0000">赛事延赛</font>';
				}else{
					$ball='<font color="#CC0000">赛事腰斩</font>';
				}
			}else{
				$ball=$row['mb_inball'].'<br>'.$row['tg_inball'];
			}
			
			?>
    <td align='center'><?=$ball_hr?></td>
    <td align='center'><?=$ball?></td>
    <?
  }else{
?>    <td align='center'><?=$row['mb_inball']?><br><?=$row['tg_inball']?></td>
  <?	
  	}
  	?>
  </tr> 
<?
}
}
?>

</table>
</form>
<span id="bodyP" style="position:absolute; display: none">
  页次:&nbsp;*SHOW_P*
</span>
</body>
</html>
<?
mysql_close();
?>
