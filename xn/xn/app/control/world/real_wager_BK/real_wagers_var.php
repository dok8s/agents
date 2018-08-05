<?
Session_start();
if (!$_SESSION["sksk"])
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

$sql = "select * from web_world where Oid='$uid'";
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
<TITLE>足球變數值</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<SCRIPT language=JavaScript>
parent.t_page=<?=$page_count?>;
parent.totaldata='<?=$totaldata?>';
<!--
if(self == top) location='/app/control/agents/'
parent.uid='<?=$uid?>';
parent.stype_var = '<?=$rtype?>';
parent.ltype = <?=$ltype?>;
parent.retime = '<?=$retime?>';
parent.pct = '<?=$pct?>';
parent.sid = '';
parent.dt_now = '<?=date('Y-m-d H:i:s')?>';
parent.gmt_str = '<?=$rel_dtnow?>';
parent.draw = '<?=$rel_draw?>';
<?
$K=0;
switch ($rtype){
case "all":
	$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB as M_LetB_en,$m_league as M_League,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,R_Show,if(s_single='','',concat('雙',s_single)) as s_single,if(s_double='','',concat('單',s_double)) as s_double from bask_match where`m_start` > now( ) AND `m_Date` ='$mDate'".$sleague."  order by m_league desc,mid";
	$sql2="select mid as mid2,

	sum(if(linetype=5 and mtype='ODD',1,0)) as oc,
	sum(if(linetype=5 and mtype='ODD',betscore,0)) as os,
	sum(if(linetype=5 and mtype='EVEN',1,0)) as ec,
	sum(if(linetype=5 and mtype='EVEN',betscore,0)) as es,
	sum(if(linetype=2 and mtype='H',betscore,0)) as rhs,
	sum(if(linetype=2 and mtype='H',1,0)) as rhc,
	sum(if(linetype=2 and mtype='C',1,0)) as rcc,
	sum(if(linetype=2 and mtype='C',betscore,0)) as rcs,
	sum(if(linetype=3 and mtype='H',betscore,0)) as ouhs,
	sum(if(linetype=3 and mtype='H',1,0)) as ouhc,
	sum(if(linetype=3 and mtype='C',1,0)) as oucc,
	sum(if(linetype=3 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (5,2,3) and world='$agname' and hidden=0 and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=$row["MB_Dime_Rate"];
		$TG_Dime_Rate=$row["TG_Dime_Rate"];
		$MB_LetB_Rate=$row['MB_LetB_Rate'];
		$TG_LetB_Rate=$row['TG_LetB_Rate'];
		$mid=$row['MID'];

		$oc=$row["oc"]+0;
		$os=$row["os"]+0;
		$ec=$row["ec"]+0;
		$es=$row["es"]+0;

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;

		$ouhc=$row['oucc']+0;
		$ouhs=$row['oucs']+0;
		$oucc=$row['ouhc']+0;
		$oucs=$row['ouhs']+0;

		$mb_dime_hr=str_replace("Odd","",$row['MB_Dime_HR_en']);
		$league=$row['M_League'];

		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$league','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','Y','$row[M_LetB_en]','$row[M_LetB_en]','$MB_LetB_Rate','$TG_LetB_Rate','$rhc','$rcc','$rhs','$rcs','$row[MB_Dime_en]','$TG_Dime_Rate','$MB_Dime_Rate','$oucc','$ouhc','$oucs','$ouhs','$row[s_single]','$row[s_double]','','$ec','$oc','','$es','$os','','','','$mb_dime_hr','$mb_dime_hr','0','0','0','0','0','0');\n";
		$K=$K+1;
	}
	break;
case "ou":
	$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB as M_LetB_en,$m_league as M_League,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,R_Show,if(s_single='','',concat('雙',s_single)) as s_single,if(s_double='','',concat('單',s_double)) as s_double from bask_match where`m_start` > now( ) AND `m_Date` ='$mDate'".$sleague."  AND (mb_mid>700000 or mb_mid<100000) order by m_league desc,mid";
	$sql2="select mid as mid2,

	sum(if(linetype=5 and mtype='ODD',1,0)) as oc,
	sum(if(linetype=5 and mtype='ODD',betscore,0)) as os,
	sum(if(linetype=5 and mtype='EVEN',1,0)) as ec,
	sum(if(linetype=5 and mtype='EVEN',betscore,0)) as es,
	sum(if(linetype=2 and mtype='H',betscore,0)) as rhs,
	sum(if(linetype=2 and mtype='H',1,0)) as rhc,
	sum(if(linetype=2 and mtype='C',1,0)) as rcc,
	sum(if(linetype=2 and mtype='C',betscore,0)) as rcs,
	sum(if(linetype=3 and mtype='H',betscore,0)) as ouhs,
	sum(if(linetype=3 and mtype='H',1,0)) as ouhc,
	sum(if(linetype=3 and mtype='C',1,0)) as oucc,
	sum(if(linetype=3 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (5,2,3) and world='$agname' and hidden=0 and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=$row["MB_Dime_Rate"];
		$TG_Dime_Rate=$row["TG_Dime_Rate"];
		$MB_LetB_Rate=$row['MB_LetB_Rate'];
		$TG_LetB_Rate=$row['TG_LetB_Rate'];
		$mid=$row['MID'];

		$oc=$row["oc"]+0;
		$os=$row["os"]+0;
		$ec=$row["ec"]+0;
		$es=$row["es"]+0;

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;

		$ouhc=$row['oucc']+0;
		$ouhs=$row['oucs']+0;
		$oucc=$row['ouhc']+0;
		$oucs=$row['ouhs']+0;

		$mb_dime_hr=str_replace("Odd","",$row['MB_Dime_HR_en']);
		$league=$row['M_League'];

		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$league','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','Y','$row[M_LetB_en]','$row[M_LetB_en]','$MB_LetB_Rate','$TG_LetB_Rate','$rhc','$rcc','$rhs','$rcs','$row[MB_Dime_en]','$TG_Dime_Rate','$MB_Dime_Rate','$oucc','$ouhc','$oucs','$ouhs','$row[s_single]','$row[s_double]','','$ec','$oc','','$es','$os','','','','$mb_dime_hr','$mb_dime_hr','0','0','0','0','0','0');\n";
		$K=$K+1;
	}
	break;
case "r4":
	$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB as M_LetB_en,$m_league as M_League,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,R_Show,if(s_single='','',concat('雙',s_single)) as s_single,if(s_double='','',concat('單',s_double)) as s_double from bask_match where`m_start` > now( ) AND `m_Date` ='$mDate'".$sleague."  AND (mb_mid<800000 and mb_mid>100000) order by m_league desc,mid";
	$sql2="select mid as mid2,

	sum(if(linetype=5 and mtype='ODD',1,0)) as oc,
	sum(if(linetype=5 and mtype='ODD',betscore,0)) as os,
	sum(if(linetype=5 and mtype='EVEN',1,0)) as ec,
	sum(if(linetype=5 and mtype='EVEN',betscore,0)) as es,
	sum(if(linetype=2 and mtype='H',betscore,0)) as rhs,
	sum(if(linetype=2 and mtype='H',1,0)) as rhc,
	sum(if(linetype=2 and mtype='C',1,0)) as rcc,
	sum(if(linetype=2 and mtype='C',betscore,0)) as rcs,
	sum(if(linetype=3 and mtype='H',betscore,0)) as ouhs,
	sum(if(linetype=3 and mtype='H',1,0)) as ouhc,
	sum(if(linetype=3 and mtype='C',1,0)) as oucc,
	sum(if(linetype=3 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (5,2,3) and world='$agname' and hidden=0 and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=$row["MB_Dime_Rate"];
		$TG_Dime_Rate=$row["TG_Dime_Rate"];
		$MB_LetB_Rate=$row['MB_LetB_Rate'];
		$TG_LetB_Rate=$row['TG_LetB_Rate'];
		$mid=$row['MID'];

		$oc=$row["oc"]+0;
		$os=$row["os"]+0;
		$ec=$row["ec"]+0;
		$es=$row["es"]+0;

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;

		$ouhc=$row['oucc']+0;
		$ouhs=$row['oucs']+0;
		$oucc=$row['ouhc']+0;
		$oucs=$row['ouhs']+0;

		$mb_dime_hr=str_replace("Odd","",$row['MB_Dime_HR_en']);
		$league=$row['M_League'];

		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$league','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','Y','$row[M_LetB_en]','$row[M_LetB_en]','$MB_LetB_Rate','$TG_LetB_Rate','$rhc','$rcc','$rhs','$rcs','$row[MB_Dime_en]','$TG_Dime_Rate','$MB_Dime_Rate','$oucc','$ouhc','$oucs','$ouhs','$row[s_single]','$row[s_double]','','$ec','$oc','','$es','$os','','','','$mb_dime_hr','$mb_dime_hr','0','0','0','0','0','0');\n";
		$K=$K+1;
	}
	break;
case "re":
	$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB as M_LetB_en,$m_league as M_League,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,R_Show,if(s_single='','',concat('雙',s_single)) as s_single,if(s_double='','',concat('單',s_double)) as s_double from bask_match where date_add(uptime,interval 60 second) > now( ) AND `m_Date` ='$mDate'".$sleague."  order by m_league desc,mid";
	$sql2="select mid as mid2,

	sum(if(linetype=5 and mtype='ODD',1,0)) as oc,
	sum(if(linetype=5 and mtype='ODD',betscore,0)) as os,
	sum(if(linetype=5 and mtype='EVEN',1,0)) as ec,
	sum(if(linetype=5 and mtype='EVEN',betscore,0)) as es,
	sum(if(linetype=9 and mtype='H',betscore,0)) as rhs,
	sum(if(linetype=9 and mtype='H',1,0)) as rhc,
	sum(if(linetype=9 and mtype='C',1,0)) as rcc,
	sum(if(linetype=9 and mtype='C',betscore,0)) as rcs,
	sum(if(linetype=10 and mtype='H',betscore,0)) as ouhs,
	sum(if(linetype=10 and mtype='H',1,0)) as ouhc,
	sum(if(linetype=10 and mtype='C',1,0)) as oucc,
	sum(if(linetype=10 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (5,9,10) and world='$agname' and hidden=0 and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=$row["MB_Dime_Rate"];
		$TG_Dime_Rate=$row["TG_Dime_Rate"];
		$MB_LetB_Rate=$row['MB_LetB_Rate'];
		$TG_LetB_Rate=$row['TG_LetB_Rate'];
		$mid=$row['MID'];

		$oc=$row["oc"]+0;
		$os=$row["os"]+0;
		$ec=$row["ec"]+0;
		$es=$row["es"]+0;

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;

		$ouhc=$row['oucc']+0;
		$ouhs=$row['oucs']+0;
		$oucc=$row['ouhc']+0;
		$oucs=$row['ouhs']+0;

		$mb_dime_hr=str_replace("Odd","",$row['MB_Dime_HR_en']);
		$league=$row['M_League'];

		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$league','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','Y','$row[M_LetB_en]','$row[M_LetB_en]','$MB_LetB_Rate','$TG_LetB_Rate','$rhc','$rcc','$rhs','$rcs','$row[MB_Dime_en]','$TG_Dime_Rate','$MB_Dime_Rate','$oucc','$ouhc','$oucs','$ouhs','$row[s_single]','$row[s_double]','','$ec','$oc','','$es','$os','','','','$mb_dime_hr','$mb_dime_hr','0','0','0','0','0','0');\n";
		$K=$K+1;
	}
	break;

case "par":
	$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB as M_LetB_en,$m_league as M_League,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,R_Show,if(s_single='','',concat('雙',s_single)) as s_single,if(s_double='','',concat('單',s_double)) as s_double from bask_match  where`m_start` > now( ) AND `m_Date` ='$mDate'".$league." and PR_Show=1 order by m_start,mid";
	$sql2="select mid as mid2,
	sum(if(linetype=8 and mtype='H',betscore,0)) as rhs,
	sum(if(linetype=8 and mtype='H',1,0)) as rhc,
	sum(if(linetype=8 and mtype='C',1,0)) as rcc,
	sum(if(linetype=8 and mtype='C',betscore,0)) as rcs from web_db_io where linetype=8 and world='$agname' and hidden=0 and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=$row["MB_Dime_Rate"];
		$TG_Dime_Rate=$row["TG_Dime_Rate"];
		$MB_LetB_Rate=$row['MB_LetB_Rate'];
		$TG_LetB_Rate=$row['TG_LetB_Rate'];
		$mid=$row['MID'];

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;

		$show="Y";
		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$rhc','$rcc','0','$rhs','$rcs','0');\n";
		$K=$K+1;
		}
	break;
case "p":
	$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB as M_LetB_en,$m_league as M_League,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,R_Show,if(s_single='','',concat('雙',s_single)) as s_single,if(s_double='','',concat('單',s_double)) as s_double from bask_match where`m_start` < now( ) AND `m_Date` ='$mDate'".$sleague." order by m_league desc,mid";
	$sql2="select mid as mid2,

	sum(if(linetype=5 and mtype='ODD',1,0)) as oc,
	sum(if(linetype=5 and mtype='ODD',betscore,0)) as os,
	sum(if(linetype=5 and mtype='EVEN',1,0)) as ec,
	sum(if(linetype=5 and mtype='EVEN',betscore,0)) as es,

	sum(if(linetype=9 and mtype='H',betscore,0)) as rehs,
	sum(if(linetype=9 and mtype='H',1,0)) as rehc,
	sum(if(linetype=9 and mtype='C',1,0)) as recc,
	sum(if(linetype=9 and mtype='C',betscore,0)) as recs,
	sum(if(linetype=10 and mtype='H',betscore,0)) as rouhs,
	sum(if(linetype=10 and mtype='H',1,0)) as rouhc,
	sum(if(linetype=10 and mtype='C',1,0)) as roucc,
	sum(if(linetype=10 and mtype='C',betscore,0)) as roucs ,
	sum(if(linetype=8,betscore,0)) as ps,
	sum(if(linetype=8,1,0)) as pc,

	sum(if(linetype=2 and mtype='H',betscore,0)) as rhs,
	sum(if(linetype=2 and mtype='H',1,0)) as rhc,
	sum(if(linetype=2 and mtype='C',1,0)) as rcc,
	sum(if(linetype=2 and mtype='C',betscore,0)) as rcs,
	sum(if(linetype=3 and mtype='H',betscore,0)) as ouhs,
	sum(if(linetype=3 and mtype='H',1,0)) as ouhc,
	sum(if(linetype=3 and mtype='C',1,0)) as oucc,
	sum(if(linetype=3 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (5,2,3) and world='$agname' and hidden=0 and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=$row["MB_Dime_Rate"];
		$TG_Dime_Rate=$row["TG_Dime_Rate"];
		$MB_LetB_Rate=$row['MB_LetB_Rate'];
		$TG_LetB_Rate=$row['TG_LetB_Rate'];
		$mid=$row['MID'];

		$oc=$row["oc"]+0;
		$os=$row["os"]+0;
		$ec=$row["ec"]+0;
		$es=$row["es"]+0;

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;
		$rehc=$row['rehc']+0;
		$rehs=$row['rehs']+0;
		$recc=$row['recc']+0;
		$recs=$row['recs']+0;

		$oucc=$row['oucc']+0;
		$oucs=$row['oucs']+0;
		$ouhc=$row['ouhc']+0;
		$ouhs=$row['ouhs']+0;
		$rouhc=$row['roucc']+0;
		$rouhs=$row['roucs']+0;
		$roucc=$row['rouhc']+0;
		$roucs=$row['rouhs']+0;
		$pc=$row['pc']+0;
		$ps=$row['ps']+0;

		$mb_dime_hr=str_replace("Odd","",$row['MB_Dime_HR_en']);
		$league=$row['M_League'];

		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$league','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','Y','$row[M_LetB_en]','$row[M_LetB_en]','$MB_LetB_Rate','$TG_LetB_Rate','$rhc','$rcc','$rhs','$rcs','$rehc','$recc','$rehs','$recs','$oucc','$ouhc','$oucs','$ouhs','0','0','0','0','0','0','0','0','$oc','$os','$ec','$es','$pc','$ps','$roucc','$rouhc','$roucs','$rouhs','N');\n";
		$K=$K+1;
		}
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
$loginfo='篮球即时注单';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql);

mysql_close();
?>