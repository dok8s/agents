<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../../inc/ag_set.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$sql = "select id,subuser,agname,subname,status,super,setdata from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$super=$row['super'];
$d1set = @unserialize($row['setdata']);
$level=$_REQUEST['level']?$_REQUEST['level']:2;
$mid=$_REQUEST["id"];
$id=$_REQUEST["id"];

$mysql = "select * from web_corprator where oid='$uid'";

$wd_result = mysql_query($mysql);
$cou=mysql_num_rows($wd_result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$wd_row = mysql_fetch_array($wd_result);
$agents_id=$wd_row["ID"];

$langx='zh-vn';
require ("../../member/include/traditional.$langx.inc.php");

$agents_id=	$_REQUEST["super_agents_id"];
$act			=	$_REQUEST["act"];
$rtype		=	$_REQUEST['rtype'];
$sc				=	$_REQUEST['SC'];
$so				=	$_REQUEST['SO'];
$st				=	$_REQUEST['war_set'];
$kind			=	$_REQUEST['kind'];
$id				=	$_REQUEST["id"];

$war_set_1=$_REQUEST["war_set_1"];
$war_set_2=$_REQUEST["war_set_2"];
$war_set_3=$_REQUEST["war_set_3"];
$war_set_4=$_REQUEST["war_set_4"];
if ($war_set_2!=''){
	$sc=$_REQUEST['SC'];
	$so=$_REQUEST['SO'];
	$updsql=$kind."_Turn_".$rtype."_A='".$war_set_1."',".$kind."_Turn_".$rtype."_B='".$war_set_2."',".$kind."_Turn_".$rtype."_C='".$war_set_3."',".$kind."_Turn_".$rtype."_D='".$war_set_4."'";
}else{
	$sc=$_REQUEST['SC_2'];
	$so=$_REQUEST['SO_2'];
	$updsql=$kind."_Turn_".$rtype."='".$war_set_1."'";
}

$st=$war_set;
if ($act=='Y'){
	$sql = "select agname from web_world where ID='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$agname=$row["agname"];

	$ag_scene=$kind.'_'.$rtype."_Scene";
	$ag_bet=$kind.'_'.$rtype."_Bet";
	$agscene=$wd_row[$ag_scene];
	$agbet=$wd_row[$ag_bet];

	if ($sc>$agscene){
		echo wterror("此总代理的单场限额已超过股东的单场限额，请回上一面重新输入");
		exit;
	}
	if ($so>$agbet){
		echo wterror("此总代理的单注限额已超过股东的单注限额，请回上一面重新输入");
		exit;
	}
	$sql="update web_agents set $ag_scene='$sc' where world='$agname' and $ag_scene>$sc";

	mysql_query($sql) or die ("操作失败!1");
	$sql="update web_agents set $ag_bet='$so' where world='$agname' and $ag_bet>$so";
	mysql_query($sql) or die ("操作失败!2");

	$sql="update web_member set $ag_scene='$sc' where world='$agname' and $ag_scene>$sc";
	mysql_query($sql) or die ("操作失败!3");
	$sql="update web_member set $ag_bet='$so' where world='$agname' and $ag_bet>$so";
	mysql_query($sql) or die ("操作失败!4");

	$mysql="update web_world set ".$kind.'_'.$rtype."_Scene='".$sc."',".$kind.'_'.$rtype."_Bet='".$so."',".$updsql." where ID='$id'";
	mysql_query($mysql) or die ("操作失败!");
}

$sql = "select * from web_world where ID='$mid'";
$result = mysql_query($sql);

$row = mysql_fetch_array($result);
$opentype=$row['OpenType'];
$agents_name=$row["Agname"];
$alias=$row["Alias"];

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<script language="javascript1.2" src="/js/ag_set.js"></script>
</head>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/account_management.css" type="text/css">
<link rel="stylesheet" href="/style/control/edit_agents2.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<script>
    var uid='<?=$uid?>';
    var level='<?=$level?>';
    function ch_level(i)
    {
        if(i === 1) {
            self.location = '/xn/app/corprator/cor_list.php?uid='+uid+'&level='+i;
        } else if(i === 2) {
            self.location = '/xn/app/corprator/super_agent/body_super_agents.php?uid='+uid+'&level='+i;
        } else if(i === 3) {
            self.location = '/xn/app/corprator/agents/su_agents.php?uid='+uid+'&level='+i;
        } else if(i === 4) {
            self.location = '/xn/app/corprator/members/su_members.php?uid='+uid+'&level='+i;
        } else if(i === 6) {
            self.location = '/xn/app/corprator/wager_list/wager_add.php?uid='+uid+'&level='+i;
        } else if(i === 5) {
            self.location = '/xn/app/corprator/su_subuser.php?uid=='+uid+'&level='+i;
        }else {
            self.location = '/xn/app/corprator/wager_list/wager_hide.php?uid='+uid+'&level='+i;
        }

    }
</script>

<link rel="stylesheet" href="../css/loader.css" type="text/css">
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
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
<table width="780" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;padding-top:10px;">
  <tr>
    <td class="">&nbsp;&nbsp;代理商详细设定&nbsp;&nbsp;&nbsp;<?=$sub_user?>:<?=$agents_name?> --
      <?=$sub_name?>:<?=$alias?> -- <a href="./body_super_agents.php?uid=<?=$uid?>">回上一页</a></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
echo get_set_table($row,$wd_row);
echo get_rs_window($sid,$mid);
?>
<BR><BR><BR>
</body>
</html>
