<?
//@include("../include/msg.re.inc.php");

$exArr=array();
$exArr['zh-cn']='';
$exArr['zh-tw']='_tw';
$exArr['en-us']='_en';
$ex = isset($exArr[$langx]) ? $exArr[$langx] : $exArr['zh-tw'];

$sql = "select memname from web_member where oid='$uid'";
$result = mysql_query($sql) or exit('error inc001');
$row = mysql_fetch_array($result);
$memname = $row['memname'];

$sql = "select message,message_tw from message where member='$memname'";
$result = mysql_query($sql);// or exit("error 998".mysql_error());
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$talert = $cou>0 ? $row['message'.$ex] : '';
if(strlen($talert)>2){
	$type = strlen($ShowType)>1 ? $ShowType : $showtype;
	echo "window.parent.body_browse.setTimeout(\"alert(' $talert ')\",1000);";
	//echo "<script> alert('  $talert  '); </script>";
	/*
	echo "<script>
	try{top.game_alert.indexOf('$type')}catch(err){top.game_alert='';}
	if (top.game_alert.indexOf('$type')==-1){ alert('  $talert  '); top.game_alert+='$type,'} </script>";
	*/
}
//echo $sql;
//exit;
?>
