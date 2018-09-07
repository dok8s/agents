<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
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

$rtype=strtolower(trim($_REQUEST['rtype']));

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

$sql = "select * from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];
$langx=$row['language'];
require ("../../../member/include/traditional.$langx.inc.php");
$mDate=date('m-d');
$bdate=date('Y-m-d');

if ($rtype=='PL'){
	$mysql="SELECT * FROM `bask_match` WHERE `m_Date` ='$mDate' and m_start<now()";
}else{
	$mysql="SELECT * FROM `bask_match` WHERE `m_start` > now( ) and `m_Date` ='$mDate'";
}
$result = mysql_query( $mysql);
$cou_num=mysql_num_rows($result);
$page_size=40;
$page_count=$cou_num/$page_size;

$mysql="SELECT m_league_tw as m_league FROM `bask_match` WHERE `m_start` > now( ) and `m_Date` ='$mDate' group by m_league";
$result = mysql_query( $mysql);
while ($row=mysql_fetch_array($result)){
	if ($totaldata==''){
		$totaldata=','.$row['m_league'].'*'.$row['m_league'];
	}else{
		$totaldata=$totaldata.','.$row['m_league'].'*'.$row['m_league'];
	}
}
echo $rtype;

?>
<HTML>
<HEAD>
<TITLE>足球变数值</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<SCRIPT language=JavaScript>
parent.t_page=<?=$page_count?>;
parent.totaldata='<?=$totaldata?>';
<!--
if(self == top) location='/xn/app/control/agents/'
parent.uid='<?=$uid?>';
parent.stype_var = '<?=$rtype?>';
parent.ltype = <?=$ltype?>;
parent.retime = '<?=$retime?>';
parent.pct = '<?=$pct?>';
parent.sid = '';
parent.dt_now = '<?=date('Y-m-d H:i:s')?>';
parent.gmt_str = '<?=$rel_dtnow?>';
parent.draw = '<?=$rel_draw?>';
parent.gamount=0;

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
$loginfo='篮球即时注单';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','3')";
mysql_query($mysql);

mysql_close();
?>