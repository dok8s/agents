<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
require ("../../../member/include/traditional.$langx.inc.php");
$sql = "select * from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$agents = mysql_fetch_array($result);
$agname=$agents['Agname'];

$sql = "select agname from web_agents where subuser=1 and subname='$agname'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$ag=" M_czz='".$row['agname']."' or ";
}

//本期新会员数
$sql="select  count(*) as count from web_member where Agents='$agname' AND DATE_FORMAT( AddDate, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
$web_marquee = mysql_query($sql);
$row = mysql_fetch_array($web_marquee);
$member_count=$row['count'];

$sql="select  ndate,message from web_marquee WHERE `level` = 4  limit 5";
$im_web_marquee = mysql_query($sql);
$im_row = mysql_fetch_array($im_web_marquee);
$sql="select  ndate,message from web_marquee order by ntime desc limit 0,5";
$web_marquee = mysql_query($sql);
$row = mysql_fetch_array($web_marquee);
$messages=$row['message'];

//会员累积信用额度
$mysql="select sum(Credit) as credit,count(*) as count from web_member where Agents='$agname'";//and status=1";
$result = mysql_query($mysql);
$member_money = mysql_fetch_array($result);

$money = (int)$agents["Credit"] - (int)$member_money['credit'];

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<script src="/js/announcement.js" type="text/javascript"></script>
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
</head>
<!---->
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<div id="body_show" style=""><div>
        <div name="MaxTag" id="announcement" src="/js/announcement.js" linkage="announcement">

            <div id="announcement_contain" class="announcement_contain" onresize="setDivSize(this)" style="width: 1280px;">

                <div id="top_nav_container" name="fixHead" class="top_nav_container_ann" >
                    <div id="general_btn" class="nav_btn_on">一般公告</div>
                    <div id="important_btn" class="nav_btn">重要公告</div>
                    <div id="personal_btn" class="nav_btn">个人公告</div>
                </div>

                <div id="top_title" class="top_title_ann"><span id="title_span">一般公告</span>
                    <!--选择日期＆Search-->
                    <div id="date_select_box" class="date_select_box">
                        <span class="acc_specilSelect_first">日期</span>
                        <label id="sel_label">
                            <!--select id="sel_date" name="sel_date">
                            </select-->
                            <div id="sel_date" name="MaxTag" src="/js/ClassSelect_ag.js" linkage="ClassSelect_ag" class="acc_specilSelectDIV" >
                                <span id="nowText" class="divSelect">所有</span>
                                <div id="showDiv" class="acc_specilSelect" style="display: block;">
                                    <ul id="divUl" class="acc_specilSelect_options">
                                        <li id="value_All" class="divLi_selected">所有</li>
                                        <li id="value_Today" class="divLi">今日</li>
                                        <li id="value_Yesterday" class="divLi">昨日</li>
                                        <li id="value_Before" class="divLi">昨日之前</li>
                                    </ul>
                                </div>
                            </div>
                        </label>
                        <div id="search_box" class="search_box">
                            <input id="search_input" type="text" class="search_input" placeholder="搜寻">
                            <div id="search_btn" class="search_btn"></div>
                            <div id="delete_txt" class="delete_txt"></div>
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
                    <span id="title_btn" class="title_btn1">日期</span>
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
                                </tr><tr id="announceTr" name="announceTr" class="anno_tr" style="">
                                    <td id="datetime" name="datetime" width="10%" class="table_line">
                                        <div id="mdate" class="date_box">8月<br>16日</div>
                                    </td>
                                    <td id="text" name="text" width="90%" height="34" valign="top">
                                        <!--span class="table_time">14:01:28</span-->
                                        <span class="table_txt">敬请註意: 台球赛事派彩更改 - 局数盘口（如：1-5局，6-8局），所有已有明确结果并且之后对赛事没有任何影响的註单依然有效，除非另有特别说明。</span>
                                    </td>
                                </tr><tr id="announceTr" name="announceTr" class="anno_tr" style="">
                                    <td id="datetime" name="datetime" width="10%" class="table_line">
                                        <div id="mdate" class="date_box">8月<br>16日</div>
                                    </td>
                                    <td id="text" name="text" width="90%" height="34" valign="top">
                                        <!--span class="table_time">11:32:52</span-->
                                        <span class="table_txt">足球赛事:08月16日 埃及超级联赛 (伊蒂哈德亚历山大 VS 依斯麦里) 赛事已改期至08月17日开赛, 所有的注单本公司依然视为有效.</span>
                                    </td>
                                </tr><tr id="announceTr" name="announceTr" class="anno_tr bottom_line" style="">
                                    <td id="datetime" name="datetime" width="10%" class="table_line">
                                        <div id="mdate" class="date_box">8月<br>10日</div>
                                    </td>
                                    <td id="text" name="text" width="90%" height="34" valign="top">
                                        <!--span class="table_time">03:44:34</span-->
                                        <span class="table_txt">足球赛事: 马拉登拉姆杰亚纪念赛U19(在克罗地亚)-赛事将进行(40分钟x2), 所有的注单本公司视为有效.</span>
                                    </td>
                                </tr>
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


    </div></div>
<div>


  <div id="body_show" style=""><div>
      <div name="MaxTag" id="home" src="/js/home.js" linkage="home">

        <div id="home_contain" class="home_contain" onresize="setDivSize(this)" style="width: 67%;min-width: 1200px;">
          <div id="home_box" class="home_box">
            <div id="top_title" class="top_title"><span>首页</span></div>
            <div id="account_contain" class="account_contain">
              <div id="ac_title" class="ac_title"><span class="left_panding">帐户摘要</span></div>
              <div id="credits" class="acc_box">
                <span class="left_panding">信用额度</span>
                <span id="credits_info" class="acc_info"><?=$agents["Credit"]?></span>
              </div>
              <div id="balance" class="acc_box">
                <span class="left_panding">剩余额度</span>
                <span id="balance_info" class="acc_info"><?=$money?></span>
              </div>
              <div id="new" class="acc_box">
                <span class="left_panding">本期新会员数</span>
                <span id="new_info" class="acc_info"><?= $member_count?></span>
              </div>
              <div id="last_login" class="acc_box">
                <span class="left_panding">最后登入日期</span>
                <span id="last_login_info" class="acc_info"><?=$agents["LoginTime"]?></span>
              </div>
              <div id="password" class="acc_box bottom_line">
                <span class="left_panding">账号开通日期</span>
                <span id="password_info" class="acc_info"><?=$agents["AddDate"]?></span>
              </div>
            </div>

            <div id="status_contain" class="status_contain">
              <div id="status_title" class="status_title">
                <span class="title_box" style="min-width: 150px;">时间</span>
                <span class="title_box2 margin_right" style="min-width: 60px;">操作者</span>
                <span class="title_box2" style="min-width: 60px;">项目</span>
                <span class="title_box2" style="min-width: 60px;">帐号</span>
                <span class="title_box3" style="min-width: 60px;">阶层</span>
              </div>
              <div id="member" class="acc_box">
                <div style="height:205px;overflow-y:auto">
                      <?
                      if($ag==""){
                          $sql="select  * from agents_log  where Status=5 and M_czz='$agname' order by M_DateTime desc";
                      }else{
                          $sql="select  * from agents_log  where Status=5 and (".$ag." M_czz='$agname') order by M_DateTime desc";
                      }
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result)){
                          ?>
                      <div id="last_login" class="acc_box">
                        <span class="info_box" style="min-width: 150px;"><?=$row["M_DateTime"]?></span>
                        <span class="info_box2 margin_right red" style="min-width: 60px;"><font id="member_suspended"><?=$row["M_czz"]?></font></span>
                        <span class="info_box2 black" style="min-width: 60px;"><font id="member_view"><?=$row["M_xm"]?></font></span>
                        <span class="info_box2 gray" style="min-width: 60px;"><font id="member_inactive"><?=$row["M_user"]?></font></span>
                        <span class="info_box3 green" style="min-width: 60px;"><font id="member_active"><?=$row["M_jc"]?></font></span>
                      </div>
                          <?
                      }
                      ?>
                </div>
            </div>
          </div>
              <div id="important_title" class="important_title"><span>重要公告</span></div>
              <div id="important_contain" class="important_contain">
                  <table id="important_table" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                      <?
                      while ($row = mysql_fetch_array($im_web_marquee)){
                          ?>
                          <tr id="important_tr" name="important_tr" class="anno_tr" style="">
                              <td id="datetime" name="datetime" width="20%" class="table_line">
                                  <div id="date" class="date_box"><?=$row["ndate"]?></div>
                              </td>
                              <td id="text" name="text" width="75%" height="34" valign="top">
                                  <span class="table_txt"><?=$row["message"]?></span>
                              </td>
                          </tr>
                          <?
                      }
                      ?>
                      </tbody></table>
              </div>
              <div id="viewmore_contain" class="viewmore_contain">
                  <input id="btn" type="button" class="btn_more" value="查看更多">
                  <div id="load" class="load"></div>
              </div>

              <div id="important_title" class="important_title"><span>最新公告</span></div>
              <div id="important_contain" class="important_contain">
                  <table id="important_table" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                      <?
                      while ($row = mysql_fetch_array($web_marquee)){
                          ?>
                          <tr id="important_tr" name="important_tr" class="anno_tr" style="">
                              <td id="datetime" name="datetime" width="20%" class="table_line">
                                  <div id="date" class="date_box"><?=$row["ndate"]?></div>
                              </td>
                              <td id="text" name="text" width="75%" height="34" valign="top">
                                  <span class="table_txt"><?=$row["message"]?></span>
                              </td>
                          </tr>
                          <?
                      }
                      ?>
                      </tbody></table>
              </div>
              <div id="viewmore_contain" class="viewmore_contain">
                  <input id="btn" type="button" class="btn_more" value="查看更多">
                  <div id="load" class="load"></div>
              </div>
        </div>
      </div>
    </div>

      </div>

</div>

<!--<table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >-->
<!--  <tr> -->
<!--    <td width="150" align="right">系统公告：</td>-->
<!--    <td width="520"><marquee scrollDelay=200>--><?//=$messages?><!--</marquee></td>-->
<!--    <td align="center">-->
<!--        <frame name="main" src="scroll_history.php?uid=$uid&langx=$langx">-->
<!--        历史讯息-->
<!--	  </a>-->
<!--    </td>-->
<!--  </tr>-->
<!--</table>-->
	
</div>
<br>
</body>
</html>
<?
$sql='select salert as salert,alert_tw as alert from web_system';
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$talert=$row['alert'];
if ($row['salert']==1 and $talert<>''){
	echo "<script>alert('$talert');</script>";
}
mysql_close();
?>
