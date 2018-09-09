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

$sql = "select ID,Agname,language from web_corprator where Oid='$uid'";

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

?>
<html>
<head>
<title>足球變數值</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<script language="JavaScript">
<!--
if(self == top) location='/app/control/agents/'
parent.uid='<?=$uid?>';
parent.ltype = <?=$ltype?>;
parent.stype_var = 'fs';
parent.aid = '';
parent.dt_now = '<?=date('Y-m-d H:i:s')?>';
parent.gmt_str = '美東時間';
parent.draw = '和局';
<?
	echo "parent.retime=0;\n";
	echo "parent.gamount=0;\n";
	?>

function onLoad(){
	if(parent.retime > 0){
		parent.retime_flag = "Y";
	}else{
		parent.retime_flag = "N";
	}
	parent.loading_var = "N";

	if(parent.loading == "N" && parent.ShowType != ""){
		parent.ShowGameList();
		obj_layer = parent.body_browse.document.getElementById("LoadLayer");
		obj_layer.style.display = "none";
	}
}
// -->
</script>
</head>
<body bgcolor="#000000" onLoad="onLoad()">
</body>
</html>
