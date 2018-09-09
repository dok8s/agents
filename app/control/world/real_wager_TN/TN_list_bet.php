<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language from web_world where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
require ("../../../member/include/traditional.$langx.inc.php");
$rtype=$_REQUEST["rtype"];
$wtype=$_REQUEST["wtype"];
$otype=$_REQUEST["type"];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
if ($rtype==''){
	$rtype=$wtype;
}
if ($otype==''){
	$type='';
}else{
	$type=" and Mtype='".$otype."'";
}
$gid=$_REQUEST["gid"];
$sql="select date_format(BetTime,'%H:%i:%s') as BetTime,ID,$bettype as BetType,$middle as Middle,BetScore,M_Result,OpenType,TurnRate,M_Name,LineType from web_db_io where world='$agname' ".$type." and mid=$gid and rtype='$rtype' and active=4 order by BetTime asc";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if ($cou==0){
	$msg=wterror('未搜寻到指定相关资料');
	echo $msg;
}else{
	$page_size=30;
	$page_count=ceil($cou/$page_size);
	$offset=$page*$page_size;
	$mysql=$sql."  limit $offset,$page_size;";
	$result = mysql_query( $mysql);
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<FORM NAME="LAYOUTFORM" ACTION="" METHOD=POST>
  <table width="780" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
          <TD>&nbsp;&nbsp;<?=$rag_date?>:<?=date('Y-m-d')?>~<?=date('Y-m-d')?> -- <?=$rag_type?> -- <?=$bet_pages?>:</TD>
          <TD><SELECT class=za_select id=page onchange=self.LAYOUTFORM.submit() name=page>
		<?
		for($i=0;$i<$page_count;$i++){
			if ($i==$page){
				echo "<option value='$i' selected>".($i+1)."</option>";
			}else{
				echo "<option value='$i'>".($i+1)."</option>";
			}
		}
		?> </SELECT>
		  </TD>
          <TD>/ <?=$page_count?> <?=$mem_page?> -- <A href="javascript:history.go(-1)"><?=$return_back?></A></TD>
		 </TR>
		 </TBODY>
		</TABLE>
	</TD>
  <TR>
    <TD colSpan=2 height=4></TD></TR>
  <TR>
    <TD colSpan=2>&nbsp;&nbsp;<FONT color=#000099><?=$rel_contorl?></FONT> -- <FONT color=#cc0000><?=$bet_wager?></FONT></TD>
  </TR>
</TBODY>
</TABLE>
<table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab">
  <tr class="m_title_ft" >
    <td width="55" ><?=$rel_body_time?></td>
    <td width="120"><?=$rel_turnrate?></td>
    <td width="90"><?=$rel_voucher?></td>
    <td width="275"><?=$rag_text?></td>
    <td width="120" ><?=$rag_money?></td>
    <td width="120" ><?=$rag_result?></td>
  </tr>
  <?
	$icount=0;
	$m_bet=0;
  while ($row=mysql_fetch_array($result)){

	$icount+=1;
	$m_bet=$m_bet+$row['BetScore'];
	$m_win=$m_win+$row['M_Result'];
	?>
  <tr class="m_cen">
	<td align="center"><?=$row['BetTime']?></td>
    <td><?=$row['OpenType']?>&nbsp;&nbsp;<?=$row['M_Name']?>&nbsp;&nbsp;<font color="#CC0000"><?=$row['TurnRate']?></font></td>
    <td><?=substr(show_voucher($row['LineType'],$row['ID']),2,10)?><br><?=str_replace("<BR>","",$row['BetType'])?></td>
    <td align="right">
	<?
	$smiddle=explode("<br>",$row['Middle']);
	echo $smiddle[1].'<br>'.$smiddle[2];
	?>
	</td>
    <td align="right"   ><?=mynumberformat($row['BetScore'],2);?></td>
    <td align="right"   ><?=mynumberformat($row['M_Result'],2);?></td>
  </tr>
  <?
  }
  ?>
   <tr  class="m_rig">
    <td colspan="3" >&nbsp;</td>
      <td bgcolor="dcdcdc" ><?=$icount?></td>
      <td bgcolor="dcdcdc" ><?=mynumberformat($m_bet,2)?></td>
      <td bgcolor="#990000"  ><font color="#FFFFFF"><?=mynumberformat($m_win,2)?></font></td>
  </tr>
</table>
</form>
</body>
</html>
<?
}
?>
