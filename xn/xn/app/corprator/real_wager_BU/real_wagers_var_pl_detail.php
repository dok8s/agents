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
$mtype=$_REQUEST['mtype'];
$retime=$_REQUEST['retime'];
$rtype=strtoupper(trim($_REQUEST['rtype']));
$sql = "select * from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];


$gid=$_REQUEST['gid'];
$sql="select LineType as linetype,Mtype as mtype,count(*) as cou,sum(BetScore) as score FROM  `web_db_io` where $gid in (mid) and hidden=0  group by LineType,Mtype";

		$h51c=0;
		$h53c=0;
		$h51s=0;
		$h53s=0;
		$h1c=0;
		$h1s=0;
		$c1c=0;
		$c1s=0;
		$n1c=0;
		$n1s=0;
		$h2c=0;
		$h2s=0;
		$h3c=0;
		$h6c=0;
		$h6s=0;
		$h7c=0;
		$h7s=0;
		$h3s=0;
		$c2c=0;
		$c2s=0;
		$c3c=0;
		$c3s=0;
		$n11c=0;
		$n11s=0;
		$n4c=0;
		$n4s=0;
		$h11c=0;
		$h11s=0;
		$c11c=0;
		$c11s=0;
		$h12c=0;
		$h12s=0;
		$c12c=0;
		$c12s=0;
		$h13c=0;
		$h13s=0;
		$c13c=0;
		$c13s=0;
		$n14c=0;
		$n14s=0;
		$h9c=0;
		$h9s=0;
		$c9c=0;
		$c9s=0;
		$h10c=0;
		$h10s=0;
		$c10c=0;
		$c10s=0;
		$h8c=0;
		$h8s=0;

		$h15c=0;
		$h15s=0;
		$c15c=0;
		$c15s=0;

		$res_data = mysql_query( $sql);
		while ($data=mysql_fetch_array($res_data)){;

			switch ($data["linetype"]){
			case "1":
				if ($data["mtype"]=='H'){
					$h1c+=$data["cou"]-0;
					$h1s+=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c1c+=$data["cou"]-0;
					$c1s+=$data["score"]-0;
				}else if($data["mtype"]=='N'){
					$n1c+=$data["cou"]-0;
					$n1s+=$data["score"]-0;
				}
				break;
			case "2":
				if ($data["mtype"]=='H'){
					$h2c+=$data["cou"]-0;
					$h2s+=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c2c+=$data["cou"]-0;
					$c2s+=$data["score"]-0;
				}
				break;
			case "3":
				if ($data["mtype"]=='H'){
					$h3c+=$data["cou"]-0;
					$h3s+=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c3c+=$data["cou"]-0;
					$c3s+=$data["score"]-0;
				}
				break;
			case "4":
				$n4c+=$data["cou"]-0;
				$n4s+=$data["score"]-0;
				break;
			case "5":
				$h51c=$h51c+$data["cou"]-0;
				$h51s=$h51s+$data["score"]-0;
				break;
			case "6":
				$h53c=$h53c+$data["cou"]-0;
				$h53s=$h53s+$data["score"]-0;
				break;
			case "7":
				$h7c=$h7c+$data["cou"]-0;
				$h7s=$h7s+$data["score"]-0;
				break;
			case "8":
				$h8c+=$h8c+$data["cou"]-0;
				$h8s+=$h8s+$data["score"]-0;
				break;
			case "9":
				if ($data["mtype"]=='H'){
					$h9c+=$data["cou"]-0;
					$h9s+=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c9c+=$data["cou"]-0;
					$c9s+=$data["score"]-0;
				}
				break;
			case "10":
				if ($data["mtype"]=='C'){
					$h10c+=$data["cou"]-0;
					$h10s+=$data["score"]-0;
				}else if($data["mtype"]=='H'){
					$c10c+=$data["cou"]-0;
					$c10s+=$data["score"]-0;
				}
				break;
			case "11":
				if ($data["mtype"]=='H'){
					$h11c+=$data["cou"]-0;
					$h11s+=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c11c+=$data["cou"]-0;
					$c11s+=$data["score"]-0;
				}else if($data["mtype"]=='N'){
					$n11c+=$data["cou"]-0;
					$n11s+=$data["score"]-0;
				}
				break;
			case "12":
				if ($data["mtype"]=='H'){
					$h12c+=$data["cou"]-0;
					$h12s+=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c12c+=$data["cou"]-0;
					$c12s+=$data["score"]-0;
				}
				break;
			case "13":
				if ($data["mtype"]=='H'){
					$h13c+=$data["cou"]-0;
					$h13s+=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c13c+=$data["cou"]-0;
					$c13s+=$data["score"]-0;
				}
				break;
			case "14":
				$n14c+=$data["cou"]-0;
				$n14s+=$data["score"]-0;
				break;
			case "15":
				if ($data["mtype"]=='ROD'){
					$h15c+=$data["cou"]-0;
					$h15s+=$data["score"]-0;
				}else if($data["mtype"]=='REV'){
					$c15c+=$data["cou"]-0;
					$c15s+=$data["score"]-0;
				}
			}
		}

?>
<script>
top.divFT = Array('<?=$gid?>','','','60134','60133','','','C','','','','','','0','0','0','0','','','','','0','0','0','0','','','','','','','','<?=$h1c?>','<?=$c1c?>','<?=$n1c?>','<?=$h1s?>','<?=$c1s?>','<?=$n1s?>','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','314360','','','','','N','0','0','0','0','0','0','0','0','0','0');
parent.show_one();
</script>