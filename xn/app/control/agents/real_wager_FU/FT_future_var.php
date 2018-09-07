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
$gdate=substr($_REQUEST['gdate'],5,5);
$page_no=$_REQUEST['page_no'];
$league=$_REQUEST['league_id'];
if ($league==''){
	$sleague="";
}else{
	$sleague=" and m_league='".$league."'";
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

$sql = "select Agname,ID,language from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];
$langx='zh-cn';
require ("../../../member/include/traditional.$langx.inc.php");

$mDate=date('m-d');
$bdate=date('Y-m-d');

if($rtype=='HOU' || $rtype=='HPD'){
	$show=4;
	$mid=0;
}else{
	$show=3;
	$mid=1;
}

if ($gdate==''){
	$mysql="SELECT * FROM `foot_match` WHERE mid%2=$mid and `m_Date` > '$mDate'";
}else{
	$mysql="SELECT * FROM `foot_match` WHERE mid%2=$mid  and `m_Date` = '$gdate'";
}

$result = mysql_query( $mysql);
$cou_num=mysql_num_rows($result);
$page_size=40;
$page_count=$cou_num/$page_size;
if ($gdate==''){
	$mysql="SELECT m_league as m_league FROM `foot_match` WHERE `m_Date` >'$mDate' group by m_league";
}else{
	$mysql="SELECT m_league as m_league FROM `foot_match` WHERE `m_Date`='$gdate' group by m_league";
}
$result = mysql_query( $mysql);
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
parent.uid='<?=$uid?>';
parent.ltype = <?=$ltype?>;
parent.stype_var = '<?=$rtype?>';
parent.aid = '';
parent.gdate = '<?=$gdate?>';
parent.dt_now = '<?=date('Y-m-d H:i:s')?>';
parent.t_page=<?=$page_count?>;
parent.totaldata='<?=$totaldata?>';

parent.ShowLeague('<?=$league?>');
parent.show_page();
parent.gmt_str = '<?=$rel_dtnow?>';
parent.g_r = '让球';
parent.g_ou = '大小盘';
parent.g_m = '独赢';
parent.draw = '<?=$Draw?>';
parent.open = '开放';
parent.close = '关闭';
parent.set = '设定';
parent.strong = '?弱';
parent.g_re = '滚球';
parent.g_score = '入球';
parent.receive = '收单';
parent.noreceive = '停押';
parent.update = '更新';
parent.result = 'Khán giả đầy đủ';
<?
$K=0;
$offset=$page_no*40;
switch ($rtype){
case "OU":
	if ($gdate==''){
		$sql1 = "select mid,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>ǐ</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,m_letb as M_LetB_en,$m_league as league,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('O',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show from foot_match where mid%2=1 and `m_Date` >'$mDate'".$sleague." order by display,mid limit $offset,40";
	}else{
		$sql1 = "select mid,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>ǐ</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,m_letb as M_LetB_en,$m_league as league,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('O',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show from foot_match where mid%2=1 and `m_Date`='$gdate'".$sleague." order by display,mid limit $offset,40";
	}
	$sql2="select mid as mid2,sum(if(linetype=1 and mtype='H',1,0)) as mhc,sum(if(linetype=1 and mtype='H',betscore,0)) as mhs,sum(if(linetype=1 and mtype='C',1,0)) as mcc,sum(if(linetype=1 and mtype='C',betscore,0)) as mcs,sum(if(linetype=1 and mtype='N',1,0)) as mnc,sum(if(linetype=1 and mtype='N',betscore,0)) as mns,sum(if(linetype=2 and mtype='H',betscore,0)) as rhs,sum(if(linetype=2 and mtype='H',1,0)) as rhc,sum(if(linetype=2 and mtype='C',1,0)) as rcc,sum(if(linetype=2 and mtype='C',betscore,0)) as rcs,sum(if(linetype=3 and mtype='H',betscore,0)) as ouhs,sum(if(linetype=3 and mtype='H',1,0)) as ouhc,sum(if(linetype=3 and mtype='C',1,0)) as oucc,sum(if(linetype=3 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (1,2,3) and agents='$agname' and hidden=0 group by mid order by id";
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
	if ($gdate==''){
		$sql1 = "select MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>ǐ</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,m_letb as M_LetB_en,$m_league as league,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('O',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show from foot_match where mid%2=0 and `m_Date` >'$mDate'".$sleague." order by display,mid limit $offset,40";
	}else{
		$sql1 = "select MID,concat(M_Date,'<br>',M_Time,if(m_type=0,'','<br><font style=background-color=red>ǐ</font>')) as pdate,$mb_team as MB_Team,$tg_team as TG_Team,m_letb as M_LetB_en,$m_league as league,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,if(m_dime='','',concat('O',m_dime)) as MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show from foot_match where mid%2=0 and `m_Date`='$gdate'".$sleague." order by display,mid limit $offset,40";
	}
	$sql2="select mid as mid2,sum(if(linetype=11 and mtype='H',1,0)) as mhc,sum(if(linetype=11 and mtype='H',betscore,0)) as mhs,sum(if(linetype=11 and mtype='C',1,0)) as mcc,sum(if(linetype=11 and mtype='C',betscore,0)) as mcs,sum(if(linetype=11 and mtype='N',1,0)) as mnc,sum(if(linetype=11 and mtype='N',betscore,0)) as mns,sum(if(linetype=12 and mtype='H',betscore,0)) as rhs,sum(if(linetype=12 and mtype='H',1,0)) as rhc,sum(if(linetype=12 and mtype='C',1,0)) as rcc,sum(if(linetype=12 and mtype='C',betscore,0)) as rcs,sum(if(linetype=13 and mtype='H',betscore,0)) as ouhs,sum(if(linetype=13 and mtype='H',1,0)) as ouhc,sum(if(linetype=13 and mtype='C',1,0)) as oucc,sum(if(linetype=13 and mtype='C',betscore,0)) as oucs from web_db_io where linetype in (11,12,13) and agents='$agname' and hidden=0 group by mid order by id";
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
case "PD":
	if ($gdate==''){
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType,PD_Show from foot_match where mid%2=1 and `m_start` > now( ) AND `m_Date` >'$mDate'".$sleague." order by display,mid limit $offset,40";
	}else{
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType,PD_Show from foot_match where mid%2=1 and `m_start` > now( ) AND `m_Date` ='$gdate'".$sleague." order by display,mid limit $offset,40";
	}

	$sql2	=	"select mid as mid2,count(*) as cou,sum(BetScore) as score FROM `web_db_io` where linetype=4 and agents='$agname' and hidden=0  group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID'];
		$n4c=$row["cou"]+0;
		$n4s=$row["score"]+0;
		$show='Y';
		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','".($row[MB1TG0]+0)."','".($row[MB2TG0]+0)."','".($row[MB2TG1]+0)."','".($row[MB3TG0]+0)."','".($row[MB3TG1]+0)."','".($row[MB3TG2]+0)."','".($row[MB4TG0]+0)."','".($row[MB4TG1]+0)."','".($row[MB4TG2]+0)."','".($row[MB4TG3]+0)."','".($row[MB0TG0]+0)."','".($row[MB1TG1]+0)."','".($row[MB2TG2]+0)."','".($row[MB3TG3]+0)."','".($row[MB4TG4]+0)."','".($row[OVMB]+0)."','".($row[MB0TG1]+0)."','".($row[MB0TG2]+0)."','".($row[MB1TG2]+0)."','".($row[MB0TG3]+0)."','".($row[MB1TG3]+0)."','".($row[MB2TG3]+0)."','".($row[MB0TG4]+0)."','".($row[MB1TG4]+0)."','".($row[MB2TG4]+0)."','".($row[MB3TG4]+0)."','".($row[OVTG]+0)."','$n4c','$n4s');\n";
		$K=$K+1;
	}
	break;
case "HPD":
	if ($gdate==''){
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType,PD_Show from foot_match where mid%2=0 and `m_start` > now( ) AND `m_Date` >'$mDate'".$sleague." order by display,mid limit $offset,40";
	}else{
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,ShowType,PD_Show from foot_match where mid%2=0 and `m_start` > now( ) AND `m_Date` ='$gdate'".$sleague." order by display,mid limit $offset,40";
	}
	$sql2	=	"select mid as mid2,count(*) as cou,sum(BetScore) as score FROM `web_db_io` where linetype=34 and agents='$agname' and hidden=0  group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID'];
		$n4c=$row["cou"]+0;
		$n4s=$row["score"]+0;
		$show='Y';
		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','".($row[MB1TG0]+0)."','".($row[MB2TG0]+0)."','".($row[MB2TG1]+0)."','".($row[MB3TG0]+0)."','".($row[MB3TG1]+0)."','".($row[MB3TG2]+0)."','".($row[MB4TG0]+0)."','".($row[MB4TG1]+0)."','".($row[MB4TG2]+0)."','".($row[MB4TG3]+0)."','".($row[MB0TG0]+0)."','".($row[MB1TG1]+0)."','".($row[MB2TG2]+0)."','".($row[MB3TG3]+0)."','".($row[MB4TG4]+0)."','".($row[OVMB]+0)."','".($row[MB0TG1]+0)."','".($row[MB0TG2]+0)."','".($row[MB1TG2]+0)."','".($row[MB0TG3]+0)."','".($row[MB1TG3]+0)."','".($row[MB2TG3]+0)."','".($row[MB0TG4]+0)."','".($row[MB1TG4]+0)."','".($row[MB2TG4]+0)."','".($row[MB3TG4]+0)."','".($row[OVTG]+0)."','$n4c','$n4s');\n";
		$K=$K+1;
	}
	break;
case "EO":
	if ($gdate==''){
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,S_Single,S_Double,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowType,T_Show from foot_match where mid%2=1 and `m_Date` >'$mDate'".$sleague." order by display,mid limit $offset,40";
	}else{
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,S_Single,S_Double,S_0_1,S_2_3,S_4_6,S_7UP,MB_MID,TG_MID,ShowType,T_Show from foot_match where mid%2=1 and  `m_Date`='$gdate'".$sleague." order by display,mid limit $offset,40";
	}
	$sql2	=	"select mid as mid2,sum(if(mtype='ODD',1,0)) as oc,sum(if(mtype='ODD',betscore,0)) as os,	sum(if(mtype='EVEN',1,0)) as ec,sum(if(mtype='EVEN',betscore,0)) as es,sum(if(mtype='0~1',1,0)) as 1c,sum(if(mtype='0~1',betscore,0)) as 1s,	sum(if(mtype='2~3',1,0)) as 2c,sum(if(mtype='2~3',betscore,0)) as 2s,sum(if(mtype='4~6',1,0)) as 4c,sum(if(mtype='4~5',betscore,0)) as 4s,	sum(if(mtype='OVER',1,0)) as 7c,sum(if(mtype='OVER',betscore,0)) as 7s	from web_db_io where linetype in (5,6) and agents='$agname'  and hidden=0  group by mid";
	$sql	=	"select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$S_Single=$row['S_Single']+0;
		$S_Double=$row['S_Double']+0;
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
		if ($row['T_Show']==3){
			$show='Y';
		}else{
			$show='N';
		}
		$show='Y';
		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$S_Single','$h52c','$h52s','$S_Double','$h51c','$h51s','$a1','$h53c','$h53s','$a2','$h54c','$h54s','$a3','$h55c','$h55s','$a4','$h56c','$h56s');\n";
		$K=$K+1;
	}
	break;
case "F":
	if ($gdate=='')	{
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,MBMB+0 as MBMB,MBFT+0 as MBFT,MBTG+0 as MBTG,FTMB+0 as FTMB,FTFT+0 as FTFT,FTTG+0 as FTTG,TGMB+0 as TGMB,TGFT+0 as TGFT,TGTG+0 as TGTG,MB_MID,TG_MID,ShowType from foot_match where mid%2=1 and `m_Date` >'$mDate'".$sleague." order by display,mid limit $offset,40";
	}else{
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,MBMB+0 as MBMB,MBFT+0 as MBFT,MBTG+0 as MBTG,FTMB+0 as FTMB,FTFT+0 as FTFT,FTTG+0 as FTTG,TGMB+0 as TGMB,TGFT+0 as TGFT,TGTG+0 as TGTG,MB_MID,TG_MID,ShowType from foot_match where mid%2=1 and `m_Date`='$gdate'".$sleague." order by display,mid limit $offset,40";
	}

	$sql2	=	"select mid as mid2,count(*) as cou,sum(BetScore) as score FROM `web_db_io` where linetype=14 and agents='$agname' and hidden=0  group by mid order by id";
	$sql="select * from (($sql1) as s) left join (($sql2) as o) on (s.mid=o.mid2)";
	$result = mysql_query( $sql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$mid=$row['mid'];
		$n4c=$row["cou"]+0;
		$n4s=$row["score"]+0;
		$show=$row['f_show'];
		$show="Y";
		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$row[MBMB]','$row[MBFT]','$row[MBTG]','$row[FTMB]','$row[FTFT]','$row[FTTG]','$row[TGMB]','$row[TGFT]','$row[TGTG]','$n4c','$n4s');\n";
		$K=$K+1;
		}
	break;
case "P":
	if ($gdate=='')	{
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,MB_MID,TG_MID,ShowType from foot_match where `m_Date`>'$mDate'".$sleague." and mid%2=1 order by display,mid limit $offset,40";
	}else{
		$sql1 = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,m_league as league,MB_MID,TG_MID,ShowType from foot_match where `m_Date`='$gdate'".$sleague." and mid%2=1 order by display,mid limit $offset,40";
	}
	$sql2="select mid as mid2,
	sum(if(mtype='H',1,0)) as mhc,
	sum(if(mtype='H',betscore,0)) as mhs,
	sum(if(mtype='C',1,0)) as mcc,
	sum(if(mtype='C',betscore,0)) as mcs,
	sum(if(mtype='N',1,0)) as mnc,
	sum(if(mtype='N',betscore,0)) as mns from web_db_io where linetype in (7,8) and agents='$agname' and hidden=0 group by mid order by id";
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
		echo "parent.GameFT[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[league]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$mhc','$mcc','$mnc','$mhs','$mcs','$mns');\n";
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
$loginfo='足球早餐即时注单';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','3')";
mysql_query($mysql);

mysql_close();
?>