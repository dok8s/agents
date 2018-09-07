<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
require ("../../member/include/traditional.$langx.inc.php");
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
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
<link rel="stylesheet" href="/style/home.css" type="text/css">
<link rel="stylesheet" href="css/loader.css" type="text/css">
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
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<!---->
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
<div>
  <div id="body_show" style=""><div>
      <div name="MaxTag" id="home" src="/js/home.js" linkage="home">

        <div id="home_contain" class="home_contain" onresize="setDivSize(this)" style="width: 67%;min-width: 1200px;">
          <div id="home_box" class="home_box">
            <div id="top_title" class="top_title"><span>Trang chủ</span></div>
            <div id="account_contain" class="account_contain">
              <div id="ac_title" class="ac_title"><span class="left_panding">Tóm tắt tài khoản</span></div>
              <div id="credits" class="acc_box">
                <span class="left_panding">Hạn mức tín dụng</span>
                <span id="credits_info" class="acc_info"><?=$agents["Credit"]?></span>
              </div>
              <div id="balance" class="acc_box">
                <span class="left_panding">Số tiền còn lại</span>
                <span id="balance_info" class="acc_info"><?=$money?></span>
              </div>
              <div id="new" class="acc_box">
                <span class="left_panding">Thành viên mới trong số này</span>
                <span id="new_info" class="acc_info"><?= $member_count?></span>
              </div>
              <div id="last_login" class="acc_box">
                <span class="left_panding">Ngày đăng nhập cuối cùng</span>
                <span id="last_login_info" class="acc_info"><?=$agents["LoginTime"]?></span>
              </div>
              <div id="password" class="acc_box bottom_line">
                <span class="left_panding">Ngày mở tài khoản</span>
                <span id="password_info" class="acc_info"><?=$agents["AddDate"]?></span>
              </div>
            </div>

            <div id="status_contain" class="status_contain">
              <div id="status_title" class="status_title">
                <span class="title_box" style="min-width: 150px;">Thời gian</span>
                <span class="title_box2 margin_right" style="min-width: 60px;">Nhà điều hành</span>
                <span class="title_box2" style="min-width: 60px;">Dự án</span>
                <span class="title_box2" style="min-width: 60px;">Số tài khoản</span>
                <span class="title_box3" style="min-width: 60px;">Lớp</span>
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
              <div id="important_title" class="important_title"><span>Layer</span></div>
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
                  <a href="/xn/app/control/agents/announcement/get_an.php?uid=<?$uid?>&langx=<?=$langx?>">
                      <input id="btn" type="button" class="btn_more" value="Lớp">
                  </a>
                  <div id="load" class="load"></div>
              </div>

              <div id="important_title" class="important_title"><span>Thông báo mới nhất</span></div>
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
                  <a href="/xn/app/control/agents/announcement/get_an.php?uid=<?$uid?>&langx=<?=$langx?>">
                      <input id="btn" type="button" class="btn_more" value="Thông báo mới nhất">
                  </a>
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
<script type="text/javascript">
    $(window).load(function(){
        $('body').addClass('loaded').Chameleon({
            'current_item':'hoveralls',
            'json_url':'../Envato/items.json'
        });
        $('#loader-wrapper .load_title').remove();
    });
</script>
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
