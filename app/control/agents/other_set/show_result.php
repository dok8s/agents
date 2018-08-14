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
$data = array();
while ($row = mysql_fetch_array($result)){
	$data[$row["m_time"]][] = $row;
}
$rData = array();
foreach ($data as $time => $items) {
	foreach ($items as $item) {
		if ($item['m_sleague']==''){
			$leage = $item['m_league'];
		}else{
			$leage = $item['m_sleague'];
		}
		$rData[$time][$leage][] = $item;
	}
}

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
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
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

	function add_class()
	{
		$("#sport_sel li").each(function(){
			$(this).unbind("mouseover");
			$(this).unbind("mouseout");
			$(this).bind(
				"mouseover", function(){
					$(this).addClass("bet_selectBG");
				}
			).bind(
				"mouseout", function(){
					$(this).removeClass("bet_selectBG");
				}
			)
		});
	}
</SCRIPT>

</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"   onLoad="onLoad()" >
<div id="body_show" style="">
		<div id="bet_main" class="bet_main" onresize="setDivSize(this)" style="width: 1280px;">
			<div class="bet_mainpadding">
				<!---------main------------->
				<!---------yallowBTN------------->
				<div class="bet_resultBTNG noFloat">
					<span id="yellowEvent" class="bet_resultBTNon">赛事</span>
				</div>
				<div class="bet_inplayTitle">
        <span class="bet_TitleName">

        <!------特制下拉罢--------->
        <ul class="bet_selectSP" id="gtype_sel" onmouseover="javascript:document.all['sport_sel'].style.display='block';add_class();" onmouseout="javascript:document.all['sport_sel'].style.display='none'"><li><a class="bet_selectSP_first">足球</a>
        	<ul id="sport_sel" class="bet_selectSP_options" style="display:none;">
            	<li id="FT_sel" ><a>足球</a></li>
                <li id="BK_sel" ><a>篮球</a></li>
                <li id="TN_sel" ><a>网球</a></li>
                <li id="VB_sel" ><a>排球</a></li>
                <li id="BS_sel" ><a>棒球</a></li>
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
						<?
						foreach ($rData as $items) {
							foreach ($items as $leage => $rows) {
						?>
								<tbody>
								<tr class="bet_leagueNO_hand" style="display:*DISPLAY*;">
									<td width="60%" colspan="2" class="TDleft"><?=$leage?></td>
									<?
									if($gtype=='FT' || $gtype=='BS'){
									?>
										<td width="20%" class="TDcenter">半场</td>
										<td width="20%" class="TDcenter">全场</td>
									<?
									} else {
									?>
										<td width="20%" class="TDcenter">完赛</td>
									<?
									}
									?>
								</tr>
						<?
								foreach ($rows as  $row) {
									if (count(explode("PK", $row['m_league'])) == 1 && count(explode("延时", $row['m_league'])) == 1) {
						?>
								<!----------close TR-------------->
								<tr id="closeTR_3321728" class="bet_result_closeTR">
									<td id="td_3321728" width="15%" class="bet_result_padTD"><span
											id="close_btn_3321728"
											class="bet_resultOpenBTN"
											style="display: none;"></span><span><?=$row["m_date"]?> <?=$row["m_time"]?></span>
									</td>
									<td width="45%" class="TDleft"><?=$row['mb_team']?> v <?=$row['tg_team']?></td>
									<td width="20%">0 - 1</td>
									<td width="20%" class="noRightLine">2 - 2</td>
								</tr>
								</tbody>
						<?
									}
								}
							}
						}
						?>
					</table>
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
	</div>
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
<script language="JavaScript">
//	alert(document.getElementsByClassName('bet_selectSP_option'));
//	document.getElementsByClassName('bet_selectSP_option').onmouseover = function(event) { addClass(this, 'bet_selectBG') };
//	document.getElementsByClassName('bet_selectSP_option').onmouseout = function(event) { removeClass(this, 'bet_selectBG') };
</script>
	</html>
<?
mysql_close();
?>
