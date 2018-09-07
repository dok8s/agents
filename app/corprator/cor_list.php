<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");
require ("../member/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];

$mysql = "select * from web_corprator where oid='$uid'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agents_id=$wd_row["ID"];
$corprator=$wd_row["corprator"];

require ("../member/include/traditional.zh-tw.inc.php");

$agents_name=$row["Agname"];
$alias=$row["Alias"];
$level=$_REQUEST['level']?$_REQUEST['level']:1;
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/account_management.css" type="text/css">
<link rel="stylesheet" href="/style/control/edit_agents2.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
    <script>
        var uid='<?=$uid?>';
        var level='<?=$level?>';
        function ch_level(i)
        {
            if(i === 1) {
                self.location = '/app/corprator/cor_list.php?uid='+uid+'&level='+i;
            } else if(i === 2) {
                self.location = '/app/corprator/super_agent/body_super_agents.php?uid='+uid+'&level='+i;
            } else if(i === 3) {
                self.location = '/app/corprator/agents/su_agents.php?uid='+uid+'&level='+i;
            } else if(i === 4) {
                self.location = '/app/corprator/members/su_members.php?uid='+uid+'&level='+i;
            } else if(i === 6) {
                self.location = '/app/corprator/wager_list/wager_add.php?uid='+uid+'&level='+i;
            } else if(i === 5) {
                self.location = '/app/corprator/su_subuser.php?uid=='+uid+'&level='+i;;
            }else {
                self.location = '/app/corprator/wager_list/wager_hide.php?uid='+uid+'&level='+i;
            }

        }
    </script>
<script language="javascript1.2" src="/js/ag_set.js"></script>
</head>
<link rel="stylesheet" href="./css/loader.css" type="text/css">
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">正在加载...</div>
</div>
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann" style="position: relative;">
    <div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">股东</div>
    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">总代理</div>
    <div id="general_btn1" class="<? if ($level == 3) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(3);">代理</div>
    <div id="important_btn1" class="<? if ($level == 4) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(4);">会员</div>
    <div id="general_btn2" class="<? if ($level == 5) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(5);">子账号</div>
    <? if($d1set['d1_wager_add']==1){ ?>
        <div id="general_btn3" class="<? if ($level == 6) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(6);">添单帐号</div>
    <? } ?>
    <? if($d1set['d1_wager_hide']==1){ ?>
        <div id="general_btn4" class="<? if ($level == 7) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(7);">隐单帐号</div>
    <? } ?>
</div>
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agents_id?>">
<table width="780" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px;margin-top:10px;">
    <tr>
        <td class="">&nbsp;&nbsp;代理商详细设定&nbsp;&nbsp;&nbsp;帐号:<?=$agents_name?> --
            名称:<?=$alias?> -- <a href="javascript:history.go( -1 );">回上一页</a></td>
    </tr>
    <tr>
        <td colspan="2" height="4"></td>
    </tr>
</table>
<?
require ("../../inc/ag_set_show.inc.php");
echo get_set_table_show($row,$wd_row);
?>
<BR><BR><BR>
</body>
</html>
