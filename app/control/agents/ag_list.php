<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];

$mysql = "select * from web_agents where oid='$uid'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agents_id=$wd_row["ID"];
$corprator=$wd_row["corprator"];

require ("../../member/include/traditional.zh-cn.inc.php");

$agents_name=$row["Agname"];
$alias=$row["Alias"];

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/superTables.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/tableStyle.css" type="text/css">
    <link rel="stylesheet" href="css/superTables.css" type="text/css">
    <link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
    <link rel="stylesheet" href="css/loader.css" type="text/css">
    <style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: center}
-->
</style>
<script language="javascript1.2" src="/js/ag_set.js"></script>
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<link id="bs-css" href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<ul class="list-group">
  <li class="list-group-item active">
    <a style="color:#ffffff;padding-right: 5px;" href="/app/control/agents/members/ag_members.php?uid=<?=$uid?>"
                                        target="main" onMouseOver="window.status='会员'; return true;" onMouseOut="window.status='';return true;"><font>会员</font></a>
    |
    <a style="color:#ffffff;padding-left: 5px;" href="/app/control/agents/ag_subuser.php?uid=<?=$uid?>"
       target="main" onMouseOver="window.status='子账号'; return true;" onMouseOut="window.status='';return true;"><font>子账号</font></a>
  </li>
</ul>
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">正在加载...</div>
</div>
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agents_id?>">
 <h3 style="position: relative;top: 0px;width: 100%;padding: 20px 0px 20px 20px;font-size: 17px;color: #3B3B3B;">代理商详细设定&nbsp;&nbsp;&nbsp;<?=$sub_user?>:<?=$agents_name?> --
     <?=$sub_name?>:<?=$alias?></h3>
 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
 <div id="my_div" class="fakeContainer first_div" style="padding:1px">
     <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
         <tr id="my_tr">
             <th class="center" rowspan="2">足球</th>
             <th class="center" colspan="4">退水设定</th>
             <th class="center" colspan="2">投注限额</th>
         </tr>
         <tr>
             <th class="center">A</th>
             <th class="center">B</th>
             <th class="center">C</th>
             <th class="center">D</th>
             <th class="center">单场</th>
             <th class="center">单注</th>
         </tr>
         <tr  class="m_cen">
             <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
             <td nowrap><?=$row["FT_Turn_R_A"]?></td>
             <td nowrap><?=$row["FT_Turn_R_B"]?></td>
             <td nowrap><?=$row["FT_Turn_R_C"]?></td>
             <td nowrap><?=$row["FT_Turn_R_D"]?></td>
             <td nowrap><?=$row["FT_R_Scene"]?></td>
             <td nowrap><?=$row["FT_R_Bet"]?></td>
         </tr>
         <tr  class="m_cen">
             <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
             <td nowrap><?=$row["FT_Turn_RE_A"]?></td>
             <td nowrap><?=$row["FT_Turn_RE_B"]?></td>
             <td nowrap><?=$row["FT_Turn_RE_C"]?></td>
             <td nowrap><?=$row["FT_Turn_RE_D"]?></td>
             <td nowrap><?=$row["FT_RE_Scene"]?></td>
             <td nowrap><?=$row["FT_RE_Bet"]?></td>
         </tr>

         <tr  class="m_cen">
             <td nowrap class="m_ag_ed">独赢, 滚球独赢</td>
             <td nowrap colspan="4" ><?=$row["FT_Turn_M"]?></td>
             <td nowrap><?=$row["FT_M_Scene"]?></td>
             <td nowrap><?=$row["FT_M_Bet"]?></td>
         </tr>
         <tr  class="m_cen">
             <td nowrap class="m_ag_ed">其他</td>
             <td nowrap colspan="4" ><?=$row["FT_Turn_PC"]?></td>
             <td nowrap><?=$row["FT_PC_Scene"]?></td>
             <td nowrap><?=$row["FT_PC_Bet"]?></td>
         </tr>
     </table>
 </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">篮球</th>
                 <th class="center" colspan="4">退水设定</th>
                 <th class="center" colspan="2">投注限额</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">单场</th>
                 <th class="center">单注</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
                 <td nowrap><?=$row["BK_Turn_R_A"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_B"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_C"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_D"]?></td>
                 <td nowrap><?=$row["BK_R_Scene"]?></td>
                 <td nowrap><?=$row["BK_R_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
                 <td nowrap><?=$row["BK_Turn_RE_A"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_B"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_C"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_D"]?></td>
                 <td nowrap><?=$row["BK_RE_Scene"]?></td>
                 <td nowrap><?=$row["BK_RE_Bet"]?></td>
             </tr>

             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">其他</td>
                 <td nowrap colspan="4" ><?=$row["BK_Turn_PC"]?></td>
                 <td nowrap><?=$row["BK_PC_Scene"]?></td>
                 <td nowrap><?=$row["BK_PC_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">综合球类</th>
                 <th class="center" colspan="4">退水设定</th>
                 <th class="center" colspan="2">投注限额</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">单场</th>
                 <th class="center">单注</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
                 <td nowrap><?=$row["OP_Turn_R_A"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_B"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_C"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_D"]?></td>
                 <td nowrap><?=$row["OP_R_Scene"]?></td>
                 <td nowrap><?=$row["OP_R_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
                 <td nowrap><?=$row["OP_Turn_RE_A"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_B"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_C"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_D"]?></td>
                 <td nowrap><?=$row["OP_RE_Scene"]?></td>
                 <td nowrap><?=$row["OP_RE_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">独赢, 滚球独赢</td>
                 <td nowrap colspan="4" ><?=$row["OP_Turn_M"]?></td>
                 <td nowrap><?=$row["OP_M_Scene"]?></td>
                 <td nowrap><?=$row["OP_M_Bet"]?></td>
             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">其他</td>
                 <td nowrap colspan="4" ><?=$row["OP_Turn_PC"]?></td>
                 <td nowrap><?=$row["OP_PC_Scene"]?></td>
                 <td nowrap><?=$row["OP_PC_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse; width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">冠军</th>
                 <th class="center" colspan="4">退水设定</th>
                 <th class="center" colspan="2">投注限额</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">单场</th>
                 <th class="center">单注</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">冠军</td>
                 <td nowrap colspan="4" ><?=$row["FS_Turn_R"]?></td>
                 <td nowrap><?=$row["FS_R_Scene"]?></td>
                 <td nowrap><?=$row["FS_R_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>
<div id="show_table" style="visibility:hidden;position: absolute;"></div>
<div id="list" style="visibility:hidden;">
	<table border="0" cellpadding="1" cellspacing="1" class="ta_div">
		<tr class="m_title_ft_future">
			<td width=30>编号</td>
			<td width=100 >新帐号</td>
			<td width=100 >旧帐号</td>
			<td width=100 >修改日期</td>
		</tr>
		*LIST_RECORD*
		<tr><td colspan="4" class="m_cen"><input type="button" value="关闭" onClick="close_divs();" class="za_button"></td></tr>
	</table>
</div>
<div id="hidden_list" style="visibility:hidden;">
	<tr bgcolor="#F9FED3">
		<td>*NUMBER*</td>
		<td>*NEW_NAME*</td>
		<td>*OLD_NAME*</td>
		<td>*EDIT_DATE*</td>
	</tr>
</div>
<iframe id="showdata" name="showdata" scrolling="no" width="0" height="0" src="../../../ok.html"></iframe>
</body>
</html>
<style>
  .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
    z-index: 2;
    color: #fff;
    background-color: #c12e36;
    border-color: #c12e36;
  }

  .list-group-item:first-child {
    border-top-right-radius: 0px;
    border-top-left-radius: 0px;
  }
</style>
<script type="text/javascript">
    $(window).load(function(){
        $('body').addClass('loaded').Chameleon({
            'current_item':'hoveralls',
            'json_url':'../Envato/items.json'
        });
        $('#loader-wrapper .load_title').remove();
    });
</script>