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

$sql = "select * from web_world where Oid='$uid'";
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
require ("../../../member/include/traditional.$langx.inc.php");
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

$result = mysql_query( $mysql);
$cou_num=mysql_num_rows($result);

$page_size=40;
$page_count=$cou_num/$page_size;

$result = mysql_query( $sql);
while ($row=mysql_fetch_array($result)){
	if ($totaldata==''){
		$totaldata=','.$row['m_league'].'*'.$row['m_league'];
	}else{
		$totaldata=$totaldata.','.$row['m_league'].'*'.$row['m_league'];
	}
}

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
	$sql1 = "select mid,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>走地</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,m_letb as M_LetB_en,m_league_TW as league,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show from foot_match where r_show=1 and `m_Date` ='$mDate' and `m_start` > now( ) ".$sleague."  order by display,mid limit $offset,40";
	$sql2="select mid as mid2,sum(if(linetype=1 and mtype='H',1,0)) as mhc,sum(if(linetype=1 and mtype='H',betscore,0)) as mhs,sum(if(linetype=1 and mtype='C',1,0)) as mcc,sum(if(linetype=1 and mtype='C',betscore,0)) as mcs,sum(if(linetype=1 and mtype='N',1,0)) as mnc,sum(if(linetype=1 and mtype='N',betscore,0)) as mns,sum(if(linetype=2 and mtype='H',betscore,0)) as rhs,sum(if(linetype=2 and mtype='H',1,0)) as rhc,sum(if(linetype=2 and mtype='C',1,0)) as rcc,sum(if(linetype=2 and mtype='C',betscore,0)) as rcs,sum(if(linetype=3 and mtype='H',betscore,0)) as ouhs,sum(if(linetype=3 and mtype='H',1,0)) as ouhc,sum(if(linetype=3 and mtype='C',1,0)) as oucc,sum(if(linetype=3 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (1,2,3) and corprator='$agname' and hidden=0 and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$gid=$row['mid'];

		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);

		$mhc=$row['mhc']+0;
		$mhs=$row['mhs']+0;
		$mcc=$row['mcc']+0;
		$mcs=$row['mcs']+0;
		$mnc=$row['mnc']+0;
		$mns=$row['mns']+0;

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;

		$ouhc=$row['ouhc']+0;
		$ouhs=$row['ouhs']+0;
		$oucc=$row['oucc']+0;
		$oucs=$row['oucs']+0;

		echo "parent.GameFT[$K] = Array('$row[mid]','$row[pdate]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','Y','$row[M_LetB_en]','$row[M_LetB_en]','$MB_LetB_Rate','$TG_LetB_Rate','$rhc','$rcc','$rhs','$rcs','$row[MB_Dime_en]','$TG_Dime_Rate','$MB_Dime_Rate','$ouhc','$oucc','$ouhs','$oucs','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$mhc','$mcc','$mnc','$mhs','$mcs','$mns');\n";
		$K=$K+1;
	}
	break;
case "HOU":

	$sql1 = "select mid,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>走地</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,m_letb as M_LetB_en,m_league_TW as league,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show from foot_match where r_show=2 and mid%2=0 and `m_Date` ='$mDate' and `m_start` > now( ) ".$sleague."  order by display,mid limit $offset,40";
	$sql2="select mid as mid2,sum(if(linetype=11 and mtype='H',1,0)) as mhc,sum(if(linetype=11 and mtype='H',betscore,0)) as mhs,sum(if(linetype=11 and mtype='C',1,0)) as mcc,sum(if(linetype=11 and mtype='C',betscore,0)) as mcs,sum(if(linetype=11 and mtype='N',1,0)) as mnc,sum(if(linetype=11 and mtype='N',betscore,0)) as mns,sum(if(linetype=12 and mtype='H',betscore,0)) as rhs,sum(if(linetype=12 and mtype='H',1,0)) as rhc,sum(if(linetype=12 and mtype='C',1,0)) as rcc,sum(if(linetype=12 and mtype='C',betscore,0)) as rcs,sum(if(linetype=13 and mtype='H',betscore,0)) as ouhs,sum(if(linetype=13 and mtype='H',1,0)) as ouhc,sum(if(linetype=13 and mtype='C',1,0)) as oucc,sum(if(linetype=13 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (11,12,13) and corprator='$agname'  and hidden=0  and m_date='$bdate' group by mid";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);

	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$gid=$row['mid'];
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);

		$mhc=$row['mhc']+0;
		$mhs=$row['mhs']+0;
		$mcc=$row['mcc']+0;
		$mcs=$row['mcs']+0;
		$mnc=$row['mnc']+0;
		$mns=$row['mns']+0;

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;

		$ouhc=$row['ouhc']+0;
		$ouhs=$row['ouhs']+0;
		$oucc=$row['oucc']+0;
		$oucs=$row['oucs']+0;

		echo "parent.GameFT[$K] = Array('$row[mid]','$row[pdate]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','Y','$row[M_LetB_en]','$row[M_LetB_en]','$MB_LetB_Rate','$TG_LetB_Rate','$rhc','$rcc','$rhs','$rcs','$row[MB_Dime_en]','$TG_Dime_Rate','$MB_Dime_Rate','$ouhc','$oucc','$ouhs','$oucs','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$mhc','$mcc','$mnc','$mhs','$mcs','$mns');\n";
		$K=$K+1;
	}
	break;
case "RE":

	$sql1 = "select mid,fopen,M_Date,if(m_time='H/T','<font style=background-color=red>中场</font>',M_Time) as M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_RE_LetB,$m_league as M_League,mb_re_dime_rate as MB_Dime_Rate,tg_re_dime_rate as TG_Dime_Rate,if(m_re_dime='','',concat('o',m_re_dime)) as MB_Dime_en,mb_re_letb_rate as MB_LetB_Rate,tg_re_letb_rate as TG_LetB_Rate,MB_MID,TG_MID,ShowType,mb_ball as balla,tg_ball as ballb  from foot_match where  date_add(uptime,interval 30 second)>now() and Re_Show=1 ".$league."  and mb_team<>'' and mb_team_tw<>'' and mb_team_en<>'' and cancel<>1 and m_start<now()  order by m_start,mid";
	$sql2	=	"select mid as mid2,sum(if(linetype=9 and mtype='H',betscore,0)) as rhs,sum(if(linetype=9 and mtype='H',1,0)) as rhc,sum(if(linetype=9 and mtype='C',1,0)) as rcc,sum(if(linetype=9 and mtype='C',betscore,0)) as rcs,sum(if(linetype=10 and mtype='H',betscore,0)) as ouhs,sum(if(linetype=10 and mtype='H',1,0)) as ouhc,sum(if(linetype=10 and mtype='C',1,0)) as oucc,sum(if(linetype=10 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (9,10) and corprator='$agname'  and hidden=0  and m_date='$bdate' group by mid";
	$sql3	=	"select mid as mid3,sum(if(linetype=19 and mtype='H',betscore,0)) as rhs2,sum(if(linetype=19 and mtype='H',1,0)) as rhc2,sum(if(linetype=19 and mtype='C',1,0)) as rcc2,sum(if(linetype=19 and mtype='C',betscore,0)) as rcs2,sum(if(linetype=30 and mtype='H',betscore,0)) as ouhs2,sum(if(linetype=30 and mtype='H',1,0)) as ouhc2,sum(if(linetype=30 and mtype='C',1,0)) as oucc2,sum(if(linetype=30 and mtype='C',betscore,0)) as oucs2 from web_db_io where linetype in (19,30) and corprator='$agname'  and hidden=0  and m_date='$bdate'  group by mid";
	$sql4 = "select mid as mid4,M_RE_LetB as M_RE_LetB2,mb_re_dime_rate as MB_Dime_Rate2,tg_re_dime_rate as TG_Dime_Rate2,if(m_re_dime='','',concat('o',m_re_dime)) as MB_Dime_en2,mb_re_letb_rate as MB_LetB_Rate2,tg_re_letb_rate as TG_LetB_Rate2,showtype as ShowType2 from foot_match where mid%2=0 and RE_Show=1 order by m_start,mid";
	$sql	=	"select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2) left join (($sql3) as hr) on (s.mid=hr.mid3-1) left join (($sql4) as re) on (s.mid=re.mid4-1)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=$row["MB_Dime_Rate"];
		$TG_Dime_Rate=$row["TG_Dime_Rate"];
		$MB_LetB_Rate=$row['MB_LetB_Rate'];
		$TG_LetB_Rate=$row['TG_LetB_Rate'];
		$mid=$row['mid'];
		$gid=$row['mid']+1;

		$MB_Dime_Rate1=$row["MB_Dime_Rate2"];
		$TG_Dime_Rate1=$row["TG_Dime_Rate2"];
		$MB_LetB_Rate1=$row['MB_LetB_Rate2'];
		$TG_LetB_Rate1=$row['TG_LetB_Rate2'];

		$rhc=$row['rhc']+0;
		$rhs=$row['rhs']+0;
		$rcc=$row['rcc']+0;
		$rcs=$row['rcs']+0;

		$ouhc=$row['ouhc']+0;
		$ouhs=$row['ouhs']+0;
		$oucc=$row['oucc']+0;
		$oucs=$row['oucs']+0;

		$hrhc=$row['rhc2']+0;
		$hrhs=$row['rhs2']+0;
		$hrcc=$row['rcc2']+0;
		$hrcs=$row['rcs2']+0;
		$houcc=$row['ouhc2']+0;
		$houcs=$row['ouhs2']+0;
		$houhc=$row['oucc2']+0;
		$houhs=$row['oucs2']+0;

		if ($row['fopen']=='1'){
			$show='Y';
		}else{
			$show='N';
		}
		echo "parent.GameFT[$K] = Array('$mid','<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$row[M_RE_LetB]','$row[M_RE_LetB]','$MB_LetB_Rate','$TG_LetB_Rate','$rhc','$rcc','$rhs','$rcs','$row[MB_Dime_en]','$TG_Dime_Rate','$MB_Dime_Rate','$ouhc','$oucc','$ouhs','$oucs','".$row['balla']."','".$row['ballb']."','$gid','$row[ShowType2]','$row[M_RE_LetB2]','$row[M_RE_LetB2]','$MB_LetB_Rate1','$TG_LetB_Rate1','$hrhc','$hrcc','$hrhs','$hrcs','$row[MB_Dime_en2]','$MB_Dime_Rate1','$TG_Dime_Rate1','$houcc','$houhc','$houcs','$houhs');\n";
		$K=$K+1;
	}

	break;
case "PD":
	$sql1 = "select mid,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league_TW as league,ShowType,if(PD_Show=1,'Y','N') as pd_show from foot_match where pd_show=1 and mid%2=1 and `m_start` > now( ) AND `m_Date` ='$mDate' ".$sleague." order by m_start,mid limit $offset,40";
	$sql2	=	"select mid as mid2,count(*) as cou,sum(BetScore) as score FROM `web_db_io` where linetype=4 and corprator='$agname' and hidden=0  and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";

	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID'];
		$show=$row['pd_show'];
		$n4c=$row["cou"]+0;
		$n4s=$row["score"]+0;
		echo "parent.GameFT[$K] = Array('$row[mid]','$row[M_Date]<br>$row[M_Time]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$n4c','$n4s');\n";
		$K=$K+1;
		}
	break;
case "HPD":
	$sql1 = "select mid,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league_TW as league,ShowType,if(PD_Show=2,'Y','N') as pd_show from foot_match where pd_show=2 and mid%2=0 and `m_start` > now( ) AND `m_Date` ='$mDate' ".$sleague." order by m_start,mid limit $offset,40";
	$sql2	=	"select mid as mid2,count(*) as cou,sum(BetScore) as score FROM `web_db_io` where linetype=34 and corprator='$agname' and hidden=0 and m_date='$bdate'  group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";

	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID'];
		$show=$row['pd_show'];
		$n4c=$row["cou"]+0;
		$n4s=$row["score"]+0;
		echo "parent.GameFT[$K] = Array('$row[mid]','$row[M_Date]<br>$row[M_Time]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$n4c','$n4s');\n";
		$K=$K+1;
		}
	break;
case "EO":
	$sql1 = "select if(t_show=1,'Y','N') as t_show,mid,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league_tw as M_Sleague,S_Single,S_Double,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowType from foot_match where`m_start` > now( ) AND `m_Date` ='$mDate' and t_show=1 ".$sleague." order by m_start,mid limit $offset,40";
	$sql2	=	"select mid as mid2,sum(if(mtype='ODD',1,0)) as oc,sum(if(mtype='ODD',betscore,0)) as os,	sum(if(mtype='EVEN',1,0)) as ec,sum(if(mtype='EVEN',betscore,0)) as es,sum(if(mtype='0~1',1,0)) as 1c,sum(if(mtype='0~1',betscore,0)) as 1s,	sum(if(mtype='2~3',1,0)) as 2c,sum(if(mtype='2~3',betscore,0)) as 2s,sum(if(mtype='4~6',1,0)) as 4c,sum(if(mtype='4~5',betscore,0)) as 4s,	sum(if(mtype='OVER',1,0)) as 7c,sum(if(mtype='OVER',betscore,0)) as 7s	from web_db_io where linetype in (5,6) and corprator='$agname'  and hidden=0 and m_date='$bdate'  group by mid";
	$sql	=	"select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);

	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$S_Single=$row['S_Single'];
		$S_Double=$row['S_Double'];
		$mid=$row['MID'];
		$a1=$row['S_0_1']-0;
		$a2=$row['S_2_3']-0;
		$a3=$row['S_4_6']-0;
		$a4=$row['S_7UP']-0;

		$h51c=$row["ec"]+0;
		$h51s=$row["es"]+0;
		$h52c=$data["oc"]+0;
		$h52s=$data["os"]+0;
		$h53c=$data["1c"]+0;
		$h53s=$data["1s"]+0;
		$h54c=$data["2c"]+0;
		$h54s=$data["2s"]+0;
		$h55c=$data["4c"]+0;
		$h55s=$data["4s"]+0;
		$h56c=$data["7c"]+0;
		$h56s=$data["7s"]+0;

		$show=$row['t_show'];
		echo "parent.GameFT[$K] = Array('$row[mid]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$S_Single','$h52c','$h52s','$S_Double','$h51c','$h51s','$a1','$h53c','$h53s','$a2','$h54c','$h54s','$a3','$h55c','$h55s','$a4','$h56c','$h56s');\n";
		$K=$K+1;
	}
	break;

case "F":
	$sql1 = "select mid,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league_tw as league,MBMB,MBFT,MBTG,FTMB,FTFT,FTTG,TGMB,TGFT,TGTG,MB_MID,TG_MID,ShowType,if(f_Show=1,'Y','N') as f_show from foot_match where f_show=1 and `m_start` > now( ) AND `m_Date` ='$mDate' ".$sleague." order by m_start,mid limit $offset,40";
	$sql2	=	"select mid as mid2,count(*) as cou,sum(BetScore) as score FROM `web_db_io` where linetype=14 and corprator='$agname' and hidden=0 and m_date='$bdate'  group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";

	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$mid=$row['mid'];
		$n4c=$row["cou"]+0;
		$n4s=$row["score"]+0;
		$show=$row['f_show'];

		echo "parent.GameFT[$K] = Array('$row[mid]','$row[M_Date]<br>$row[M_Time]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$n4c','$n4s');\n";
		$K=$K+1;
		}
	break;
case "P":
	$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league_tw as M_Sleague,MB_MID,TG_MID,ShowType from foot_match where `m_start` > now( ) AND `m_Date` ='$mDate'".$league." and R_Show=1 order by m_start,mid";
	//$sql1 = "select mid,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>走地</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,m_letb as M_LetB_en,m_league_TW as league,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('o',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show from foot_match where r_show=1 and `m_Date` ='$mDate' and `m_start` > now( ) ".$sleague."  order by display,mid limit $offset,40";
	$sql2="select mid as mid2,
	sum(if(mtype='H',1,0)) as mhc,
	sum(if(mtype='H',betscore,0)) as mhs,
	sum(if(mtype='C',1,0)) as mcc,
	sum(if(mtype='C',betscore,0)) as mcs,
	sum(if(mtype='N',1,0)) as mnc,
	sum(if(mtype='N',betscore,0)) as mns from web_db_io where linetype in (7,8) and corprator='$agname' and hidden=0 and m_date='$bdate' group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$gid=$row['mid'];

		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);

		$mhc=$row['mhc']+0;
		$mhs=$row['mhs']+0;
		$mcc=$row['mcc']+0;
		$mcs=$row['mcs']+0;
		$mnc=$row['mnc']+0;
		$mns=$row['mns']+0;

		$show="Y";
		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$mhc','$mcc','$mnc','$mhs','$mcs','$mns');\n";
		$K=$K+1;
		}
	break;
case "PL":
	$sql1 = "select mid,M_Date,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_letb,$m_league as M_League,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,concat('O',m_dime) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show,if(MB_Inball='','N','Y') as shown from foot_match where mid%2=1 and `m_Date` ='$mDate' and m_start<now() order by m_start,mid limit $offset,40";
	$sql2	=	"select mid as mid2,sum(if(linetype=2 and mtype='H',betscore,0)) as rhs,sum(if(linetype=2 and mtype='H',1,0)) as rhc,sum(if(linetype=2 and mtype='C',1,0)) as rcc,sum(if(linetype=2 and mtype='C',betscore,0)) as rcs,sum(if(linetype=3 and mtype='H',betscore,0)) as ouhs,sum(if(linetype=3 and mtype='H',1,0)) as ouhc,sum(if(linetype=3 and mtype='C',1,0)) as oucc,sum(if(linetype=3 and mtype='C',betscore,0)) as oucs,sum(if(linetype=9 and mtype='H',betscore,0)) as rhs9,sum(if(linetype=9 and mtype='H',1,0)) as rhc9,sum(if(linetype=9 and mtype='C',1,0)) as rcc9,sum(if(linetype=9 and mtype='C',betscore,0)) as rcs9,sum(if(linetype=10 and mtype='H',betscore,0)) as ouhs10,sum(if(linetype=10 and mtype='H',1,0)) as ouhc10,sum(if(linetype=10 and mtype='C',1,0)) as oucc10,sum(if(linetype=10 and mtype='C',betscore,0)) as oucs10 from web_db_io where linetype in (9,10,2,3) and corprator='$agname' and hidden=0  and m_date='$bdate' group by mid";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";

	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$PR_M_LetB=$row['M_LetB'];
		$mid=$row['MID'];

		$h2c=$row['rhc']+0;
		$h2s=$row['rhs']+0;
		$c2c=$row['rcc']+0;
		$c2s=$row['rcs']+0;

		$h3c=$row['ouhc']+0;
		$h3s=$row['ouhs']+0;
		$c3c=$row['oucc']+0;
		$c3s=$row['oucs']+0;

		$h9c=$row['rhc9']+0;
		$h9s=$row['rhs9']+0;
		$c9c=$row['rcc9']+0;
		$c9s=$row['rcs9']+0;

		$c10c=$row['ouhc10']+0;
		$c10s=$row['ouhs10']+0;
		$h10c=$row['oucc10']+0;
		$h10s=$row['oucs10']+0;

		echo "parent.GameFT[$K] = Array('$row[mid]','$row[M_Date]<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$row[m_letb]','$row[m_letb]','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$h2c','$c2c','$h2s','$c2s','$h9c','$c9c','$h9s','$c9s','$c3c','$h3c','$c3s','$h3s','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','$h10c','$c10c','$h10s','$c10s','$row[shown]');\n";
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
$loginfo='足球即时注单明细';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','1')";
mysql_query($mysql);
mysql_close();
?>