<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$ltype=$_REQUEST['ltype'];
$pct=$_REQUEST['pct'];
$page_no=$_REQUEST['page_no'];
$league=$_REQUEST['league_id'];

if ($league==''){
	$sleague="";
}else{
	$sleague=" and m_league_tw='".$league."'";
}

if ($page_no==''){
	$page_no=0;
}

$rtype=strtoupper(trim($_REQUEST['rtype']));

if ($ltype=='' or $ltype==3){
	$ltype=3;
	$open='C';
}else if($ltype==1){
	$open='A';
}else if($ltype==2){
	$open='B';
}else if($ltype==4){
	$open='D';
}

$sql = "select * from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];
$langx=$row['language'];
require ("../../member/include/traditional.$langx.inc.php");
$mDate=date('m-d');
$bdate=date('Y-m-d');

switch($rtype){
case 'OU':
	$mysql="SELECT * FROM `foot_match` WHERE r_show=1 and `m_start` > now( ) and `m_Date` ='$mDate'";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE r_show=1 and `m_start` > now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
case 'HOU':
	$mysql="SELECT * FROM `foot_match` WHERE mid%2=0 and r_show=2 and `m_start` > now( ) and `m_Date` ='$mDate'";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE r_show=2 and `m_start` > now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
case 'RE':
	$mysql="SELECT * FROM `foot_match` WHERE re_show=1 and `m_start` > now( ) and `m_Date` ='$mDate'";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE re_show=1 and `m_start` > now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
case 'PD':
	$mysql="SELECT * FROM `foot_match` WHERE pd_show=1 and `m_start` > now( ) and `m_Date` ='$mDate'";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE pd_show=1 and `m_start` > now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
case 'HPD':
	$mysql="SELECT * FROM `foot_match` WHERE mid%2=0 and pd_show=2 and `m_start` > now( ) and `m_Date` ='$mDate'";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE pd_show=2 and `m_start` > now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
case 'F':
	$mysql="SELECT * FROM `foot_match` WHERE f_show=1 and `m_start` > now( ) and `m_Date` ='$mDate'";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE f_show=1 and `m_start` > now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
case 'T':
	$mysql="SELECT * FROM `foot_match` WHERE t_show=1 and `m_start` > now( ) and `m_Date` ='$mDate'";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE t_show=1 and `m_start` > now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
case 'P':
	$mysql="SELECT * FROM `foot_match` WHERE p_show=1 and `m_start` > now( ) and `m_Date` ='$mDate'";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE p_show=1 and `m_start` > now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
case 'PL':
	$mysql="SELECT * FROM `foot_match` WHERE mid%2=1 and `m_Date` ='$mDate' and m_start<now()";
	$sql="SELECT m_league_tw as m_league FROM `foot_match` WHERE r_show=1 and `m_start` < now( ) and `m_Date` ='$mDate' group by m_league order by gid";
	break;
}

$page_count=0;


?>
<HTML><HEAD><TITLE>足球变数值</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<SCRIPT language=JavaScript>
parent.t_page=<?=$page_count?>;
parent.totaldata='<?=$totaldata?>';
<?
if ($rtype=='OU' or $rtype=='HOU' or $rtype=='PD'  or $rtype=='HPD' or $rtype=='F' or $rtype=='P'){
?>
parent.ShowLeague('<?=$league?>');
<?
}
if ($rtype!='RE'){
?>
parent.show_page();
<?
}
?>
<!--
if(self == top) location='/app/control/agents/'
parent.uid='<?=$uid?>';
parent.stype_var = '<?=$rtype?>';
parent.ltype = <?=$ltype?>;
parent.retime = '-1';
parent.pct = '<?=$pct?>';
parent.sid = '';
parent.dt_now = '<?=date('Y-m-d H:i:s')?>';
parent.gmt_str = '<?=$rel_dtnow?>';
parent.draw = '<?=$rel_draw?>';
<?
$K=0;
$offset=$page_no*40;
$bdate=date('Y-m-d');

switch ($rtype){
case "OU":

	echo "parent.gamount=0;\n";

	break;
case "HOU":

		echo "parent.gamount=0;\n";

	break;
case "RE":
	echo "parent.gamount=0;\n";

	break;
case "PD":
	echo "parent.gamount=0;\n";

	break;

case "EO":
		echo "parent.gamount=0;\n";

	break;
case "P":
	echo "parent.gamount=0;\n";

	break;
case "PL":
	echo "parent.gamount=0;\n";

	break;
}

?>

  function onLoad()
 {
  if(parent.retime > 0)
   parent.retime_flag='Y';
  else
   parent.retime_flag='N';
  parent.loading_var = 'N';
  if(parent.loading == 'N' && parent.ShowType != '')
  {
   parent.ShowGameList();
   obj_layer = parent.body_browse.document.getElementById('LoadLayer');
   obj_layer.style.display = 'none';
  }
 }
// -->
</script>
</head>
<body bgcolor="#FFFFFF" onLoad="onLoad()">
</body>
</html>
<?
$loginfo='棒球即时注单';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','1')";
mysql_query($mysql);

mysql_close();
?>