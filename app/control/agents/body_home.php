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
$sql = "select agname from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];

$sql = "select agname from web_agents where subuser=1 and subname='$agname'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$ag=" M_czz='".$row['agname']."' or ";
}

$sql="select  message from web_marquee order by ntime desc limit 0,1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$messages=$row['message'];

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
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
<div>


  <div id="body_show" style=""><div>
      <div name="MaxTag" id="home" src="/js/home.js" linkage="home">

        <div id="home_contain" class="home_contain" onresize="setDivSize(this)" style="width: 100%;">
          <div id="home_box" class="home_box">
            <div id="top_title" class="top_title"><span>首页</span></div>
            <div id="account_contain" class="account_contain">
              <div id="ac_title" class="ac_title"><span class="left_panding">帐户摘要</span></div>
              <div id="credits" class="acc_box">
                <span class="left_panding">信用额度</span>
                <span id="credits_info" class="acc_info">100.00</span>
              </div>
              <div id="balance" class="acc_box">
                <span class="left_panding">剩余额度</span>
                <span id="balance_info" class="acc_info">100.00</span>
              </div>
              <div id="new" class="acc_box">
                <span class="left_panding">本期新会员数</span>
                <span id="new_info" class="acc_info">0</span>
              </div>
              <div id="last_login" class="acc_box">
                <span class="left_panding">最后登入日期</span>
                <span id="last_login_info" class="acc_info">2018-08-06</span>
              </div>
              <div id="password" class="acc_box bottom_line">
                <span class="left_panding">密码最后更新日期</span>
                <span id="password_info" class="acc_info">2018-08-05</span>
              </div>
            </div>

            <div id="status_contain" class="status_contain">
              <div id="status_title" class="status_title">
                <span class="title_box">时间</span>
                <span class="title_box2 margin_right">操作者</span>
                <span class="title_box2">项目</span>
                <span class="title_box2">帐号</span>
                <span class="title_box3">阶层</span>
              </div>
              <div id="member" class="acc_box " style="">
                      <?
                      if($ag==""){
                          $sql="select  * from agents_log  where Status=5 and M_czz='$agname' order by M_DateTime desc";
                      }else{
                          $sql="select  * from agents_log  where Status=5 and (".$ag." M_czz='$agname') order by M_DateTime desc";
                      }
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result)){
                          ?>
                        <span class="info_box"><?=$row["M_DateTime"]?></span>
                        <span class="info_box2 margin_right red"><font id="member_suspended"><?=$row["M_czz"]?></font></span>
                        <span class="info_box2 black"><font id="member_view"><?=$row["M_xm"]?></font></span>
                        <span class="info_box2 gray"><font id="member_inactive"><?=$row["M_user"]?></font></span>
                        <span class="info_box3 green"><font id="member_active"><?=$row["M_jc"]?></font></span>
                          <?
                      }
                      ?>
            </div>
            <div id="important_title" class="important_title"><span>重要公告</span></div>
            <div id="important_contain" class="important_contain">
              <table id="important_table" border="0" cellpadding="0" cellspacing="0">


                <tbody><tr id="important_tr" name="important_tr" class="anno_tr" style="display:none">
                  <td id="datetime" name="datetime" width="10%" class="table_line">
                    <div id="date" class="date_box">*MON*<br>*MDAY*</div>
                  </td>
                  <td id="text" name="text" width="90%" height="34" valign="top">
                    <!--span class="table_time">*TIME*</span-->
                    <span class="table_txt">*TEXT*</span>
                  </td>
                </tr><tr id="important_tr" name="important_tr" class="anno_tr" style="">
                  <td id="datetime" name="datetime" width="10%" class="table_line">
                    <div id="date" class="date_box">2月<br>25日</div>
                  </td>
                  <td id="text" name="text" width="90%" height="34" valign="top">
                    <!--span class="table_time">07:39:03</span-->
                    <span class="table_txt">微软已经宣佈停止支援10和以下的IE浏览器版本.这意味着如果您还在使用IE 6, 7, 8, 9或10的版本,您是在使用微软已经不再支援的浏览器.一旦浏览器不再被支援,保护您的网络安全程式将不会是最新的,这也会增加您被骇和资料被盗取的可能性.最新的浏览器能比较有效的保护您被网络诈骗,病毒,木马程式,网络钓鱼和其他等的威胁.而且,最新的浏览器也会经常修补您在使用的浏览器的网络安全漏洞.我们强烈的建议您下载最新的浏览器如Chrome, FireFox 或 Safari以保持目前最完善的网络安全级别.</span>
                  </td>
                </tr><tr id="important_tr" name="important_tr" class="anno_tr" style="">
                  <td id="datetime" name="datetime" width="10%" class="table_line">
                    <div id="date" class="date_box">5月<br>31日</div>
                  </td>
                  <td id="text" name="text" width="90%" height="34" valign="top">
                    <!--span class="table_time">07:19:24</span-->
                    <span class="table_txt">尊贵的客户，本公司已提供修复DNS的软件於所有管理下载，如您无法正常访问本公司网站，请到http://180.94.224.94 或新版管理端的“故障及疑难排解”下载此软件。</span>
                  </td>
                </tr><tr id="important_tr" name="important_tr" class="anno_tr" style="">
                  <td id="datetime" name="datetime" width="10%" class="table_line">
                    <div id="date" class="date_box">5月<br>23日</div>
                  </td>
                  <td id="text" name="text" width="90%" height="34" valign="top">
                    <!--span class="table_time">03:09:53</span-->
                    <span class="table_txt">敬请注意: 为了提高个人帐号密码的安全性, 请不要透过网址导航, 网址大全, 资讯网等等网站的超链接登录至我们的网站, 来路不明的第三方网站会使您的帐号密码被盗用的风险提高!!!</span>
                  </td>
                </tr><tr id="important_tr" name="important_tr" class="anno_tr" style="">
                  <td id="datetime" name="datetime" width="10%" class="table_line">
                    <div id="date" class="date_box">3月<br>28日</div>
                  </td>
                  <td id="text" name="text" width="90%" height="34" valign="top">
                    <!--span class="table_time">00:15:03</span-->
                    <span class="table_txt">敬请注意: 基於法律风险以及安全上的考量，本公司严格禁止来自美国和新加坡地区的投注， 如有发现任何来自美国和新加坡IP地址的注单，本公司将保留赛前或赛后取消注单的权利。</span>
                  </td>
                </tr><tr id="important_tr" name="important_tr" class="anno_tr bottom_line" style="">
                  <td id="datetime" name="datetime" width="10%" class="table_line">
                    <div id="date" class="date_box">3月<br>28日</div>
                  </td>
                  <td id="text" name="text" width="90%" height="34" valign="top">
                    <!--span class="table_time">00:14:53</span-->
                    <span class="table_txt">敬请注意: 本公司对於不正常获利行为如抄水, 软件投注, 或集团出货均视为非正常投注. 对於此类注单本公司有保留或取消注单的权利, 无论在赛前，赛中，或赛后.</span>
                  </td>
                </tr>


                </tbody></table>
            </div>
            <div id="viewmore_contain" class="viewmore_contain">
              <input id="btn" type="button" class="btn_more" value="查看更多">
              <div id="load" class="load"></div>
            </div>
          </div>
        </div>
      </div>
    </div></div>

</div>

<table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
  <tr> 
    <td width="150" align="right">系统公告：</td>
    <td width="520"><marquee scrollDelay=200><?=$messages?></marquee></td>
    <td align="center">
    	<A HREF="javascript://" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','help:no')">
    	历史讯息
	  </a>
    </td>
  </tr>
  <tr align="center" > 
    <td colspan="3" bgcolor="6EC13E">&nbsp; </td>

  </tr>
</table>
	
</div>
<br>
</body>
</html>
<style>
  .home_box {
    position: relative;
    margin: 0 20px;
  }
  .top_title {
    position: relative;
    top: 0px;
    width: 100%;
    padding: 20px 0px 20px 0px;
    font-size: 17px;
    color: #3B3B3B;
  }
  .account_contain, .status_contain {
    display: block;
    width: 48.5%;
    height: 235px;
    /* background: #E9CBCB; */
    float: left;
    color: #3b3b3b;
    font-size: 15px;
  }
  .ac_title, .status_title {
    width: 100%;
    height: 30px;
    background: #F4F1F1;
    border-bottom: #BFBFBF 1px solid;
    line-height: 30px;
  }
  .left_panding {
    padding-left: 10px;
  }
  .acc_box, .total_box {
    width: 100%;
    height: 40px;
    background: #FFFFFF;
    border-bottom: #E5E5E5 1px solid;
    line-height: 40px;
  }
  /* CSS Document */
  body { margin:0px; padding:0px; width:100%; height:100%; font-family: Arial, SimSun;}
  html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, caption {margin: 0;padding: 0;border: 0;outline: 0;font-size: 100%;vertical-align: baseline;background: transparent;}
  p{ margin:10px 0px;}
  * { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;}

  /*.clearfix {
      content: " ";
      display: block;
      height: 0;
      line-height: 0;
      clear: both;
      overflow: hidden;
      visibility: hidden;
      }*/

  .home_contain { width:100%;}
  @media (min-width: 1280px) {
    .home_contain {
      width: 1260px;
    }
  }
  @media (max-width: 1024px) {
    .home_contain {
      width: 1004px;
    }
  }

  .home_box { position:relative; margin:0 20px;}
  /* IE9+ */
  /*@media screen and (min-width:0\0) {
  .home_box { top:105px;}
  }*/

  .top_title { position: relative; top:0px; width:100%; padding:20px 0px 20px 0px; font-size:17px; color:#3B3B3B;}
  .account_contain,.status_contain { display:block; width:48.5%; height:235px; /*background:#E9CBCB;*/ float:left; color:#3b3b3b; font-size:15px;}
  .status_contain { float:right;}

  .ac_title,.status_title { width:100%; height:30px; background:#F4F1F1; border-bottom:#BFBFBF 1px solid; line-height:30px;}
  .left_panding { padding-left:10px;}
  .acc_box .left_panding { float:left;}
  .acc_box,.total_box { width:100%; height:40px; background:#FFFFFF; border-bottom:#E5E5E5 1px solid; line-height:40px; }
  .total_box { background:#ecf4e2; border-bottom:#E5E5E5 1px solid; font-weight:bold;}

  .acc_info { float:right; padding-right:10px;}
  .title_box,.title_box2,.title_box3 { width:19%; height:30px; line-height:30px; float:left; padding-left:10px; white-space:nowrap}
  .info_box,.info_box2,.info_box3,.total_info_box2,.total_info_box3 { width:19%; height:40px; line-height:40px; float:left; padding-left:10px;}
  .title_box2,.info_box2,.total_info_box2 { float:right; text-align:center; padding:0px;}
  .title_box3,.info_box3,.total_info_box3 { width:14.5%; float:right; padding:0px; text-align:center;}
  .info_box2 font,.info_box3 font{ cursor:pointer;}
  .total_info_box2,.total_info_box3 { cursor:auto;}
  .margin_right { margin-right:10px;}

  .green { color:#27a67b;}
  .gray { color:#8a8a8a;}
  .black { color:#3b3b3b;}
  .red { color:#7e1414;}

  .red_line { border-bottom:#F4DED6 1px solid;}

  .important_title,.important_title2 { display:block; width:100%;font-size:15px; margin:26px 0 0 0; height:30px; background:#F4F1F1; border-bottom:#BFBFBF 1px solid; line-height:30px; float:left;}
  .important_title2 { margin:0px;}
  .important_title span,.important_title2 span { padding-left:10px;}
  .important_contain { width:100%; float:left;}
  .important_contain table,.viewmore_contain table { width:100%;}
  /*IE8---
  @media \0screen\,screen\9 {
  .important_title,.important_title2 { width:96%;}
  .important_contain { width:96%;}
  }*/

  .anno_tr { height:auto;}
  .anno_tr:hover{background: #D7EAFB;}
  .anno_tr td { border-bottom:#E5E5E5 1px solid;}
  .table_line { text-align:center \9;}
  .table_txt { display:block; font-size:15px; padding:19px 0 22px 15px; word-wrap:break-word;}
  .table_time { display:block; font-size:15px;padding-left:15px;color:#27a67b;margin-top:17px;}
  .date_box { width:40px; height:40px; background:#27a67b; color:#FFFFFF; text-align:center; line-height:16px; font-size:15px; padding-top:4px; margin:0px auto;}

  .viewmore_contain { width:100%; padding:20px 0; text-align:center;float:left;}
  /*IE8---*/
  @media \0screen\,screen\9 {
    .viewmore_contain { width:96%;}
  }

  .btn_more { width:100px; height:30px; background:#A5A5A5; color:#FFFFFF; border:none; font-size:12px; cursor:pointer; outline:none;}
  .btn_more:hover { background-color:#8C8B8B;}
  /*大寫字體*/
  .CapitalWord{ text-transform:uppercase;}

  td.bottom_line, .bottom_line td, div.bottom_line { border-bottom:#BFBFBF 1px solid;}

  .account_contain>div:hover{background:#D7EAFB;}
  .account_contain>div.ac_title:hover{background:#F4F1F1;}
  .status_contain>.acc_box:hover{background:#D7EAFB;}
</style>
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
