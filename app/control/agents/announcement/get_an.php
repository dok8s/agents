<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$level=$_REQUEST['level']?$_REQUEST['level']:1;
$dateType=$_REQUEST['dateType']?$_REQUEST['dateType']:1;
$search=$_REQUEST['search'];
$order=$_REQUEST['order']?$_REQUEST['order']:"desc";

$where = "";
switch ($dateType) {
    case 1:
        break;
    case 2:
        $curDay = date("Y-m-d");
        $where .= " and ndate = '$curDay' ";
        break;
    case 3:
        $yesDay = date("Y-m-d",strtotime("-1 day"));
        $where .= " and ndate = '$yesDay' ";
        break;
    case 4:
        $yesDay = date("Y-m-d",strtotime("-1 day"));
        $where .= " and ndate < '$yesDay' ";
        break;
}
if ($search) {
    $where .= " and (message like '%$search%' or message_tw like '%$search%' or message_en like '%$search%') ";
}

$sql="select * from web_marquee where level=$level $where order by ntime $order";

$result = mysql_query($sql);

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<style type="text/css">
<!--
div.bac {
	width:740px;
	color: #000;
	padding:5px;
	border:1px solid #C00;
	line-height:1.3em;
	font-size:1em;
}
p.title { margin:0; padding:2px; background-color:#900; color:#FFF; text-align:center;}
b { color:#C30;}
-->
</style>
<script language="JavaScript">
    var uid='<?=$uid?>';
    var level='<?=$level?>';
    var dateType='<?=$dateType?>';
    var search = '<?=$search?>';
    var order  = '<?=$order?>';
    function ch_level(i)
    {
        self.location = './get_an.php?uid='+uid+'&level='+i;
    }
    function ch_date(i)
    {
        var val = $('#search_input').val();
        self.location = './get_an.php?uid='+uid+'&level='+level+'&dateType='+i+'&search='+val;
    }
    function search_an()
    {
        var val = $('#search_input').val();
        self.location = './get_an.php?uid='+uid+'&level='+level+'&dateType='+dateType+'&search='+val;
    }
    function del_search_an()
    {
        self.location = './get_an.php?uid='+uid+'&level='+level+'&dateType='+dateType+'&search=';
    }
    function ch_order()
    {
        var val = $('#search_input').val();
        if (order === 'asc') {
            order = 'desc';
        } else {
            order = 'asc';
        }
        self.location = './get_an.php?uid='+uid+'&level='+level+'&dateType='+dateType+'&search='+val+'&order='+order;
    }
</script>
</head>
<!---->
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<div id="body_show" style=""><div>
        <div name="MaxTag" id="announcement">

            <div id="announcement_contain" class="announcement_contain" onresize="setDivSize(this)" style="width: 1280px;">

                <div id="top_nav_container" name="fixHead" class="top_nav_container_ann" >
                    <div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">一般公告</div>
                    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">重要公告</div>
                    <div id="personal_btn" class="<? if ($level == 3) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(3);">个人公告</div>
                </div>

                <div id="top_title" class="top_title_ann">
                    <span id="title_span">
                        <?
                            if ($level == 1) {
                                echo '一般公告';
                            } elseif ($level == 2) {
                                echo '重要公告';
                            } else {
                                echo '个人公告';
                            }
                        ?>
                    </span>
                    <!--选择日期＆Search-->
                    <div id="date_select_box" class="date_select_box">
                        <span class="acc_specilSelect_first">日期</span>
                        <label id="sel_label">
                            <!--select id="sel_date" name="sel_date">
                            </select-->
                            <div id="sel_date" name="MaxTag" class="acc_specilSelectDIV"  onmouseover="javascript:document.all['showDiv'].style.display='block';$('.divLi').show();" onmouseout="javascript:document.all['showDiv'].style.display='none';$('.divLi').hide();">
                                <span id="nowText" class="divSelect">
                                    <?
                                        if ($dateType == 1) {
                                            echo '所有';
                                        } elseif ($dateType == 2) {
                                            echo '今日';
                                        } elseif ($dateType == 3) {
                                            echo '昨日';
                                        } else {
                                            echo '昨日之前';
                                        }
                                    ?>
                                </span>
                                <div id="showDiv" class="acc_specilSelect" style="display: none;">
                                    <ul id="divUl" class="acc_specilSelect_options" style="padding: 0px;">
                                        <li id="value_All" class="<? if ($dateType == 1) {echo 'divLi_selected';} else {echo 'divLi';}?>" onclick="ch_date(1)">所有</li>
                                        <li id="value_Today" class="<? if ($dateType == 2) {echo 'divLi_selected';} else {echo 'divLi';}?>" onclick="ch_date(2)">今日</li>
                                        <li id="value_Yesterday" class="<? if ($dateType == 3) {echo 'divLi_selected';} else {echo 'divLi';}?>" onclick="ch_date(3)">昨日</li>
                                        <li id="value_Before" class="<? if ($dateType == 4) {echo 'divLi_selected';} else {echo 'divLi';}?>" onclick="ch_date(4)">昨日之前</li>
                                    </ul>
                                </div>
                            </div>
                        </label>
                        <div id="search_box" class="search_box">
                            <input id="search_input" type="text" class="search_input" placeholder="搜寻" value="<?echo $search;?>">
                            <div id="search_btn" class="search_btn" onclick="search_an()"></div>
                            <div id="delete_txt" class="delete_txt" onclick="del_search_an()"></div>
                        </div>
                    </div>
                    <!--选择日期＆Search end--></div>

                <div id="date_container" class="date_container">

                    <!--公告-->
                    <div id="annoDiv" class="annoDiv">
                        <!--公告title-->
                        <div id="anno_table_title" class="anno_table_title">
                <span id="date_title_ann" class="date_title_ann">
                    <!--红色箭头往下  class="title_btn1", 红色箭头往上  class="title_btn2", 灰色箭头往下  class="title_btn3"-->
                    <span id="title_btn" class="<? $class = $order == 'asc'?'title_btn2':'title_btn1';echo $class; ?>" onclick="ch_order()">日期</span>
                </span>
                            <span class="anno_title">公告</span>
                        </div>
                        <!--公告title end-->
                        <div id="announceDiv" name="announceDiv" class="annoTable">
                            <table id="announceTable" name="announceTable" border="0" cellpadding="0" cellspacing="0" width="100%" style="">
                                <tbody><tr id="announceTr" name="announceTr" class="anno_tr" style="display: none;">
                                    <td id="datetime" name="datetime" width="10%" class="table_line">
                                        <div id="mdate" class="date_box">*MON*<br>*MDAY*</div>
                                    </td>
                                    <td id="text" name="text" width="90%" height="34" valign="top">
                                        <!--span class="table_time">*TIME*</span-->
                                        <span class="table_txt">*TEXT*</span>
                                    </td>
                                </tr>
                                <?
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <tr id="announceTr" name="announceTr" class="anno_tr" >
                                        <td id="datetime" name="datetime" width="10%" class="table_line">
                                            <div id="mdate" class="date_box"><?echo date('n',strtotime($row["ndate"]))?>月<br><?echo date('j',strtotime($row["ndate"]))?>日</div>
                                        </td>
                                        <td id="text" name="text" width="90%" height="34" valign="top">
                                            <!--span class="table_time">14:01:28</span-->
                                            <span class="table_txt"><?echo $row["message"]?></span>
                                        </td>
                                    </tr>
                                    <?
                                }
                                ?>
                                </tbody></table>
                        </div>
                        <div id="viewmore_contain" class="viewmore_contain" style="display:none;">
                            <input id="btn" type="button" class="btn_more" value="查看更多">
                            <!-- <div id="load" class="load"></div> -->
                        </div>
                        <div id="no_data" style="display:none;" class="no_found_div">无资料</div>
                    </div>
                    <!--公告 end-->
                </div>

                <div>

                </div>
                <!--div id="announceDiv" name="announceDiv" style="position:absolute;top:100px;overflow:auto;width:100%;height:100%;">
                        <table id="announceTable" name="announceTable" cellspacing=1 cellpadding=1 width=100%>
                            <tr id="announceTr" name="announceTr" height=10px>
                                <td id="datetime" name="datetime" width=15%>*DATE*</td>
                                <td id="text" name="text" width=15%>*TEXT*</td>
                            </tr>
                        </table>
                        <input id="btn" type="button" value="ViewMore" style="position:absolute;top:100px" />
            </div.-->

            </div>
        </div>


    </div>
</div>
<br>
</body>
</html>
<?
mysql_close();
?>
