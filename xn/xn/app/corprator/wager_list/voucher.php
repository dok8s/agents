<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$id=$_REQUEST["id"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];

$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
$active=$_REQUEST["active"];
if ($sort==""){
	$sort='bettime';
}

if ($orderby==""){
	$orderby='desc';
}


$active=$_REQUEST["active"];
$sql = "select c.agname from web_corprator as c, web_super as s where c.super=s.agname and s.d1edit=1  and c.oid='$uid'";//and c.edit=1
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}else{

$sql = "select danger,id,M_Name,TurnRate,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,BetType,Middle,BetScore,gwin from web_db_io where result_type=0 and corprator='$agname' and hidden=0 order by ".$sort." ".$orderby;

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
$page_size=20;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";

$result = mysql_query( $mysql);

?>
<script>if(self == top) parent.location='/'</script>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
<SCRIPT>

 function onLoad()
 {

  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }


	function reload()
{

	self.location.href='voucher.php?uid=<?=$uid?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>';
}
</script>
<?
$sql = "select wager,wager_sec from web_system";
$result4 = mysql_query($sql);
$row4 = mysql_fetch_array($result4);

$wager=$row4['wager'];
$wager_sec=$row4['wager_sec']*1000;

if($wager==1){
	echo "<SCRIPT>window.setTimeout(\"self.location.href='voucher.php?uid=$uid&sort=$sort&orderby=$orderby&page=$page'\",$wager_sec);</SCRIPT>";
}
?>
</HEAD>
<body  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onLoad="onLoad()">
<form name="myFORM" method="post" action="voucher.php?uid=<?=$uid?>">
<table width="773" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td width="3">&nbsp;
          </td>
    <td class="m_tline">下注流水 --
	  <input name=button type=button class="za_button" onClick="reload()" value="更新"></td>
    <td class="m_tline"> 排序：            <select name="sort" onChange="document.myFORM.submit();" class="za_select">
            <option value="bettime">Cá Khi</option>
            <option value="betscore">投注金额</option>
            <option value="m_name">会员名称</option>
            <option value="bettype">投注种类</option>

          </select>
              <select name="orderby" onChange="self.myFORM.submit()" class="za_select">
            <option value="asc">升序(由小到大)</option>
            <option value="desc">降序(由大到小)</option>
          </select>
</td>
        <td class="m_tline" align="right">显示第1-25条记录，共 <?=$cou?> 条记录　到第 <select name='page' onChange="self.myFORM.submit()">
<?
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			if ($i==$page){
				echo "<option selected value='$i'>".($i+1)."</option>";
			}else{
				echo "<option value='$i'>".($i+1)."</option>";
			}
		}
		?></select>
页，共 <?=$page_count?> 页 </td>
    <td width="33"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="850" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">

        <tr class="m_title_ft">
          <td width="61"align="center">Cá Khi</td>
          <td width="99" align="center">流水号</td>
          <td width="99" align="center">用户名称</td>
          <td width="72" align="center">球赛种类</td>
          <td width="189" align="center">內容</td>
          <td width="80" align="center">投注金额</td>
          <td width="80" align="center">可赢金额</td>
        </tr>
<?
while ($row = mysql_fetch_array($result))
{
?>
	<tr class="m_rig">
          <td align="center"><?=$row['BetTime'];?></td>
	  <td align="center"><?=show_voucher($row['LineType'],$row['ID'])?></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font></td>
          <td align="center"><?=str_replace(" ","",$row['BetType']);?>
<?
switch($row['danger']){
case 1:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认中&nbsp;</b></font></font>';
	break;
case 2:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>未确认</b></font></font>';
	break;
case 3:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认&nbsp;</b></font></font>';
	break;
default:
	break;

}
?>
</td>
          <td align="right"><?=$row['ShowTop'];?><?=$row['Middle'];?></td>
          <td align="center"><?
    	if($row['status']>0){
    		echo '<s>'.mynumberformat($row['BetScore'],1).'</s>';
    	}else{
    		echo mynumberformat($row['BetScore'],1);
    	}?></td>

      <td align="center">
      	<?
    	if($row['status']>0){
    		echo '<b><font color=red>['.$wager_vars_re[$row['status']].']</td>';
    	}else{
    		echo mynumberformat($row['gwin'],1);
    	}?></td>
        </tr>
<?
}
?>
     </table>
</form>
</BODY>
</html>
<?
}
$loginfo='流水注单';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','0')";
mysql_query($mysql);
mysql_close();
?>
