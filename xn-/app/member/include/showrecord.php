<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require ("config.inc.php");

$sql = "select wager from web_system";
$result4 = mysql_query($sql);
$row4 = mysql_fetch_array($result4);

$wager=$row4['wager'];

echo $wager;
?>