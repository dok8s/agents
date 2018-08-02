<?
require( "../../member/include/config.inc.php" );
$longIP = ip2long($_REQUEST['ip']);
if($longIP!=0){
	$sql = "SELECT address FROM web_ip WHERE StartIp<='$longIP' AND EndIp>='$longIP' ORDER BY Weight ASC LIMIT 0, 1";
	$IPrt = mysql_fetch_array(mysql_query($sql));
	$address = $IPrt['address'];
}else{
	$address = "IP ERROR";
}
?>