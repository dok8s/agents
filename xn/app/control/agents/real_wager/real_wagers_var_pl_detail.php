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
$mtype=$_REQUEST['mtype'];
$retime=$_REQUEST['retime'];
$rtype=strtoupper(trim($_REQUEST['rtype']));
$sql = "select * from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];

$gid=$_REQUEST['gid'];
$gid2=$gid+1;
$sql="select if(mb_inball='','N','Y') as score,mb_mid,tg_mid from foot_match where mid=$gid";

$result = mysql_query( $sql);
$row=mysql_fetch_array($result);
$show=$row['score'];
$mb_mid=$row['mb_mid'];
$tg_mid=$row['tg_mid'];

$sql="select
	sum(if(linetype=1 and mtype='H',1,0)) as mhc,
	sum(if(linetype=1 and mtype='H',betscore,0)) as mhs,
	sum(if(linetype=1 and mtype='C',1,0)) as mcc,
	sum(if(linetype=1 and mtype='C',betscore,0)) as mcs,
	sum(if(linetype=1 and mtype='N',1,0)) as mnc,
	sum(if(linetype=1 and mtype='N',betscore,0)) as mns,
	sum(if(linetype=4,betscore,0)) as pds,
	sum(if(linetype=4,1,0)) as pdc,
	sum(if(linetype=5,betscore,0)) as es,
	sum(if(linetype=5,1,0)) as ec,
	sum(if(linetype=6,betscore,0)) as ts,
	sum(if(linetype=6,1,0)) as tc,
	sum(if(linetype=14,betscore,0)) as fs,
	sum(if(linetype=14,1,0)) as fc,
	sum(if((linetype=7 or linetype=8),betscore,0)) as ps,
	sum(if((linetype=7 or linetype=8),1,0)) as pc

	 from web_db_io where agents='$agname' and hidden=0 and mid=$gid";

		$result = mysql_query( $sql);
		$row=mysql_fetch_array($result);

		$mhc=$row["mhc"]+0;
		$mcc=$row["mcc"]+0;
		$mnc=$row["mnc"]+0;
		$mhs=$row["mhs"]+0;
		$mcs=$row["mcs"]+0;
		$mns=$row["mns"]+0;

		$pds=$row["pds"]+0;
		$pdc=$row["pdc"]+0;
		$es=$row["es"]+0;
		$ec=$row["ec"]+0;
		$tc=$row["tc"]+0;
		$ts=$row["ts"]+0;
		$fc=$row["fc"]+0;
		$fs=$row["fs"]+0;
		$pc=$row["pc"]+0;
		$ps=$row["ps"]+0;


$sql="select
	sum(if(linetype=11 and mtype='H',1,0)) as mhc,
	sum(if(linetype=11 and mtype='H',betscore,0)) as mhs,
	sum(if(linetype=11 and mtype='C',1,0)) as mcc,
	sum(if(linetype=11 and mtype='C',betscore,0)) as mcs,
	sum(if(linetype=11 and mtype='N',1,0)) as mnc,
	sum(if(linetype=11 and mtype='N',betscore,0)) as mns,

	sum(if(linetype=12 and mtype='H',1,0)) as hc,
	sum(if(linetype=12 and mtype='H',betscore,0)) as hs,
	sum(if(linetype=12 and mtype='C',1,0)) as cc,
	sum(if(linetype=12 and mtype='C',betscore,0)) as cs,

	sum(if(linetype=13 and mtype='H',1,0)) as ouhc,
	sum(if(linetype=13 and mtype='H',betscore,0)) as ouhs,
	sum(if(linetype=13 and mtype='C',1,0)) as oucc,
	sum(if(linetype=13 and mtype='C',betscore,0)) as oucs,

	sum(if(linetype=19 and mtype='H',1,0)) as rhc,
	sum(if(linetype=19 and mtype='H',betscore,0)) as rhs,
	sum(if(linetype=19 and mtype='C',1,0)) as rcc,
	sum(if(linetype=19 and mtype='C',betscore,0)) as rcs,

	sum(if(linetype=30 and mtype='H',1,0)) as rouhc,
	sum(if(linetype=30 and mtype='H',betscore,0)) as rouhs,
	sum(if(linetype=30 and mtype='C',1,0)) as roucc,
	sum(if(linetype=30 and mtype='C',betscore,0)) as roucs,

	sum(if(linetype=34,betscore,0)) as pds,
	sum(if(linetype=34,1,0)) as pdc

	 from web_db_io where agents='$agname' and hidden=0 and mid=$gid2";

		$result = mysql_query( $sql);
		$row=mysql_fetch_array($result);

		$mhc2=$row["mhc"]+0;
		$mcc2=$row["mcc"]+0;
		$mnc2=$row["mnc"]+0;
		$mhs2=$row["mhs"]+0;
		$mcs2=$row["mcs"]+0;
		$mns2=$row["mns"]+0;

		$pds2=$row["pds"]+0;
		$pdc2=$row["pdc"]+0;

		$hs=$row["hs"]+0;
		$hc=$row["hc"]+0;
		$cs=$row["cs"]+0;
		$cc=$row["cc"]+0;

		$rhs=$row["rhs"]+0;
		$rhc=$row["rhc"]+0;
		$rcs=$row["rcs"]+0;
		$rcc=$row["rcc"]+0;

		$ouhc=$row["oucc"]+0;
		$ouhs=$row["oucs"]+0;
		$oucc=$row["ouhc"]+0;
		$oucs=$row["ouhs"]+0;

		$rouhc=$row["roucc"]+0;
		$rouhs=$row["roucs"]+0;
		$roucc=$row["rouhc"]+0;
		$roucs=$row["rouhs"]+0;


?>
<script>
top.divFT = Array('<?=$gid?>','','','<?=$tg_mid?>','<?=$mb_mid?>','','','C','','','','','','0','0','0','0','','','','','0','0','0','0','','','','','','','','<?=$mhc?>','<?=$mcc?>','<?=$mnc?>','<?=$mhs?>','<?=$mcs?>','<?=$mns?>','<?=$pdc?>','<?=$pds?>','<?=$ec?>','<?=$es?>','0','0','<?=$tc?>','<?=$ts?>','0','0','0','0','0','0','<?=$pc?>','0','0','<?=$ps?>','0','0','','','','0','0','0','0','<?=$fc?>','<?=$fs?>','<?=$hc?>','<?=$cc?>','<?=$hs?>','<?=$cs?>','<?=$ouhc?>','<?=$oucc?>','<?=$ouhs?>','<?=$oucs?>','<?=$mhc2?>','<?=$mcc2?>','<?=$mnc2?>','<?=$mhs2?>','<?=$mcs2?>','<?=$mns2?>','<?=$gid2?>','','','','','<?=$show?>','<?=$rhc?>','<?=$rcc?>','<?=$rhs?>','<?=$rcs?>','<?=$rouhc?>','<?=$roucc?>','<?=$rouhs?>','<?=$roucs?>','<?=$pdc2?>','<?=$pds2?>');
parent.show_one();
</script>