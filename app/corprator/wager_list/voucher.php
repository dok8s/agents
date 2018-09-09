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
    <td class="">��ע��ˮ --
	  <input name=button type=button class="za_button" onClick="reload()" value="����"></td>
    <td class=""> ����            <select name="sort" onChange="document.myFORM.submit();" class="za_select">
            <option value="bettime">Ͷעʱ��</option>
            <option value="betscore">Ͷע���</option>
            <option value="m_name">��Ա����</option>
            <option value="bettype">Ͷע����</option>

          </select>
              <select name="orderby" onChange="self.myFORM.submit()" class="za_select">
            <option value="asc">����(��С����)</option>
            <option value="desc">����(�ɴ�С)</option>
          </select>
</td>
        <td class="" align="right">��ʾ��1-25����¼���� <?=$cou?> ����¼������ <select name='page' onChange="self.myFORM.submit()">
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
ҳ���� <?=$page_count?> ҳ </td>
  </tr>
  <tr>
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="850" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">

        <tr class="m_title_ft">
          <td width="61"align="center">Ͷעʱ��</td>
          <td width="99" align="center">��ˮ��</td>
          <td width="99" align="center">�û�����</td>
          <td width="72" align="center">��������</td>
          <td width="189" align="center">����</td>
          <td width="80" align="center">Ͷע���</td>
          <td width="80" align="center">��Ӯ���</td>
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
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;ȷ����&nbsp;</b></font></font>';
	break;
case 2:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>δȷ��</b></font></font>';
	break;
case 3:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;ȷ��&nbsp;</b></font></font>';
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
$loginfo='��ˮע��';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','0')";
mysql_query($mysql);
mysql_close();
?>
