<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");

$uid				=	$_REQUEST["uid"];
$rtype			=	$_REQUEST["rtype"];

$page				=	$_REQUEST["page"]+0;
$gid				=	$_REQUEST["gid"]+0;
$tid				=	$_REQUEST["tid"]+0;

$sql 	= "select Agname,ID,language from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$agname	=	$row['Agname'];
$langx	=	$row['language'];
require ("../../member/include/traditional.$langx.inc.php");

$search=" and mid=$tid and mtype='$rtype'";

$sql="select date_format(BetTime,'%m%d%H%i%s')+id as ID,date_format(BetTime,'%H:%i:%s') as BetTime,$bettype as BetType,$middle as Middle,BetScore,M_Result,OpenType,TurnRate,M_Name,LineType from web_db_io where active=6 and linetype=16 and corprator='$agname' ".$search." order by BetTime asc";

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
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<FORM NAME="LAYOUTFORM" ACTION="" METHOD=POST>
  <table width="780" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">
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
    <TD width=30><IMG height=24 src="/images/control/zh-tw/top_04.gif" width=30></TD></TR>
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
	echo $smiddle[count($smiddle)-2].'<br>'.$smiddle[count($smiddle)-1];
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
<?
$loginfo='冠军即时注单明细';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','1')";
mysql_query($mysql);

mysql_close();
?>