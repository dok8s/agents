<?
error_reporting(E_ALL^E_NOTICE^E_WARNING);
Session_start();
if (!$_SESSION["akak"])
{
    echo "<script>window.open('/index.php','_top')</script>";
    exit;
}
require ("../../member/include/config.inc.php");
$uid   = $_REQUEST['uid'];
$gtype = $_REQUEST['gtype'];
$page  = $_REQUEST['page_no'];
$flag  = $_REQUEST['flag'];
$sql = "select Agname,ID from web_corprator where Oid='$uid'";

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
//$bdate = '05-14';
if ($gtype==''){
    $gtype='FT';
}
$sql="select mb_team,tg_team,m_date,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as m_time,mb_mid,tg_mid,m_league,mb_inball,tg_inball";

switch($gtype){
    case 'FT':
        $table=',mb_inball_hr,tg_inball_hr from foot_match';
        $css='';
        $css1='_ft';
        $gname = '足球';
        break;
    case 'BK':
        $table=' from bask_match';
        $css='';
        $css1='_ft';
        $gname = '篮球';
        break;
    case 'VB':
        $table=' from volleyball';
        $css='_vb';
        $css1='_vb';
        $gname = '排球';
        break;
    case 'TN':
        $table=' from tennis';
        $css='_tn';
        $css1='_tn';
        $gname = '网球';
        break;
    case 'BS':
        $table=' from baseball';
        $css='_bs';
        $css1='_bs';
        $gname = '棒球';
        break;
    default:
        $table='foot_match';
        $css1='_ft';
        $css='';
        $gtype='FT';
        $gname = '足球';
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
    <link rel="stylesheet" href="../css/loader.css" type="text/css">
    <script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script type="text/javascript">
        // 等待所有加载
        $(window).load(function(){
            $('body').addClass('loaded');
            $('#loader-wrapper .load_title').remove();
        });
    </script>
    <script language="JavaScript">
        function show_page(){
            var temp="";
            var pg_str=""
            for(var i=0;i<t_page;i++){
                if (pg!=i)
                    pg_str=pg_str+"<li class><a onclick='chg_pg("+i+");'>"+(i+1)+"</a></li>";
                else
                    pg_str=pg_str+"<li class='On'><a onclick='chg_pg("+i+");'>"+(i+1)+"</a></li>";
            }
            $("#pageBox").html(pg_str);
            if (pg < (t_page-1)) {
                document.getElementById("btn_next").style.display="";
            } else {
                document.getElementById("btn_next").style.display="none";
            }

            if (pg > 0) {
                document.getElementById("btn_pre").style.display="";
            } else {
                document.getElementById("btn_pre").style.display="none";
            }
        }

        function onLoad()
        {
            show_page();
        }

        function chg_pg(i)
        {
            if (i === '-') {
                i = parseInt(pg) - 1;
            } else if (i === '+') {
                i = parseInt(pg) + 1;
            }
            self.location = './show_result.php?uid='+uid+'&page_no='+i+'&flag='+flag+'&gtype='+gtype;
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

        function chg_game(i)
        {
            self.location = './show_result.php?uid='+uid+'&gtype='+i;
        }
    </SCRIPT>

</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"   onLoad="onLoad()" >
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">正在加载...</div>
</div>
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
        <ul class="bet_selectSP" id="gtype_sel" onmouseover="javascript:document.all['sport_sel'].style.display='block';add_class();" onmouseout="javascript:document.all['sport_sel'].style.display='none'">
            <li>
                <a class="bet_selectSP_first">
                    <? echo $gname; ?>
                </a>
        	<ul id="sport_sel" class="bet_selectSP_options" style="display:none;">
            	<li id="FT_sel" onclick="chg_game('FT')"><a >足球</a></li>
                <li id="BK_sel" onclick="chg_game('BK')"><a >篮球</a></li>
                <li id="TN_sel" onclick="chg_game('TN')"><a >网球</a></li>
                <li id="VB_sel" onclick="chg_game('VB')"><a >排球</a></li>
                <li id="BS_sel" onclick="chg_game('BS')"><a >棒球</a></li>
            </ul>
        </li></ul>
        <h2>赛果</h2></span>
                <div id="bets_search_setting" name="MaxTag" class="bet_DetailTitle" src="/js/bets_search_setting.js" linkage="bets_search_setting">
						<span id="dateresult_span" class="bet_DetailName"><h1 id="dateresult">日期</h1>
                            <h2 id="dateresult_set">
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
                            </h2>
                        </span>
                    <span id="league_span" class="bet_DetailName">
<!--                            <h1 id="league">联盟</h1><h2 id="league_set">所有联盟</h2>-->
                        </span>
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
                                    <td width="20%" class="TDcenter">赛果</td>
                                    <?
                                }
                                ?>
                            </tr>
                            <?
                            foreach ($rows as  $row) {
                                if (count(explode("PK", $row['m_league'])) == 1 && count(explode("延时", $row['m_league'])) == 1) {
                                    ?>
                                    <!----------close TR-------------->
                                    <tr id="closeTR_<?=$row['mb_mid']?>" class="bet_result_closeTR">
                                        <td id="td_<?=$row['mb_mid']?>" width="15%" class="bet_result_padTD"><span><?=$row["m_date"]?> <?=$row["m_time"]?></span>
                                        </td>
                                        <td width="45%" class="TDleft"><?=$row['mb_team']?> v <?=$row['tg_team']?></td>
                                        <?
                                        if($gtype=='FT' || $gtype=='BS'){
                                            if ($row['mb_inball_hr']==-1 || $row['mb_inball_hr']==-1){
                                                $ball_hr='赛事延赛';
                                            }else{
                                                $ball_hr=$row['mb_inball_hr'].' - '.$row['tg_inball_hr'];
                                            }

                                            if ($row['mb_inball']==-1 || $row['tg_inball']==-1){
                                                if ($row['mb_inball_hr']==-1 || $row['mb_inball_hr']==-1){
                                                    $ball='赛事延赛';
                                                }else{
                                                    $ball='赛事腰斩';
                                                }
                                            }else{
                                                $ball=$row['mb_inball'].' - '.$row['tg_inball'];
                                            }
                                            ?>
                                            <td width="20%"><?=$ball_hr?></td>
                                            <td width="20%" class="noRightLine"><?=$ball?></td>
                                            <?
                                        } else {
                                            ?>
                                            <td width="20%" class="noRightLine"><?=$row['mb_inball']?> - <?=$row['tg_inball']?></td>
                                            <?
                                        }
                                        ?>
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
            <div id="pageBTN" name="MaxTag"  linkage="Page_ag">
                <div class="bet_pageDIV">
                    <ul>
                        <li id="btn_pre" class="bet_preBTN" style="display:none;" onclick="chg_pg('-')"><a>&nbsp;</a></li>
                        <span id="pageBox">
								</span>
                        <li id="btn_next" class="bet_nextBTN" style="display:none;" onclick="chg_pg('+')"><a>&nbsp;</a></li>
                    </ul>
                </div>
            </div>
            <!-----pageBTN--------->








        </div>
    </div>
</div></div>
</div>
</body>
<script type="text/javascript">
    $(window).load(function(){
        $('body').addClass('loaded').Chameleon({
            'current_item':'hoveralls',
            'json_url':'../Envato/items.json'
        });
        $('#loader-wrapper .load_title').remove();
    });
</script>
<script language="JavaScript">
    //	alert(document.getElementsByClassName('bet_selectSP_option'));
    //	document.getElementsByClassName('bet_selectSP_option').onmouseover = function(event) { addClass(this, 'bet_selectBG') };
    //	document.getElementsByClassName('bet_selectSP_option').onmouseout = function(event) { removeClass(this, 'bet_selectBG') };
</script>
</html>
<?
mysql_close();
?>
