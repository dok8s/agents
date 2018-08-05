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
	$mysql="SELECT * FROM `volleyball` WHERE `m_Date` ='$mDate' and m_start<now()";
}else{
	$mysql="SELECT * FROM `volleyball` WHERE `m_start` > now( ) and `m_Date` ='$mDate'";
}
$result = mysql_query( $mysql);
$cou_num=mysql_num_rows($result);
$page_size=40;
$page_count=$cou_num/$page_size;

$mysql="SELECT m_league_tw as m_league FROM `volleyball` WHERE `m_start` > now( ) and `m_Date` ='$mDate' group by m_league";
$result = mysql_query( $mysql);
while ($row=mysql_fetch_array($result)){
	if ($totaldata==''){
		$totaldata=','.$row['m_league'].'*'.$row['m_league'];
	}else{
		$totaldata=$totaldata.','.$row['m_league'].'*'.$row['m_league'];
	}
}

?>
<HTML><HEAD><TITLE>¨¬²yÅÜ¼Æ­È</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
<SCRIPT language=JavaScript>
parent.t_page=<?=$page_count?>;
parent.totaldata='<?=$totaldata?>';
<?
if ($rtype=='OU' or $rtype=='V' or $rtype=='PD' or $rtype=='F' or $rtype=='P'){
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
switch ($rtype){
case "OU":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB_en,$m_league as M_League,$m_sleague as M_Sleague,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show,s_single,s_double from volleyball where`m_start` > now( ) AND `m_Date` ='$mDate'".$sleague."  order by m_start,mid";
	$result = mysql_query( $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;
	$mysql=$mysql."  limit $offset,40;";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
		$mid=$row['MID'];
		$sql="select mtype,linetype,count(*) as cou,sum(BetScore) as score FROM  `web_db_io` where MID =".$mid." and  `m_Date` ='$bdate' and LineType<4 and corprator = '".$agname."' group by LineType,Mtype order by LineType,Mtype";
		$res_data = mysql_query( $sql);
		$n1c=0;
		$n1s=0;
		$h1c=0;
		$h1s=0;
		$c1c=0;
		$c1s=0;
		$c2c=0;
		$c2s=0;
		$h2c=0;
		$h2s=0;
		$c3c=0;
		$c3s=0;
		$h3c=0;
		$h3s=0;
		while ($data=mysql_fetch_array($res_data)){
			switch ($data["linetype"]){
			case "1":
				if ($data["mtype"]=='H'){
					$h1c=$data["cou"]-0;
					$h1s=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c1c=$data["cou"]-0;
					$c1s=$data["score"]-0;
				}else if($data["mtype"]=='N'){
					$n1c=$data["cou"]-0;
					$n1s=$data["score"]-0;
				}
				break;
			case "2":
				if ($data["mtype"]=='H'){
					$h2c=$data["cou"]-0;
					$h2s=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c2c=$data["cou"]-0;
					$c2s=$data["score"]-0;
				}
				break;
			case "3":
				if ($data["mtype"]=='H'){
					$h3c=$data["cou"]-0;
					$h3s=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c3c=$data["cou"]-0;
					$c3s=$data["score"]-0;
				}
				break;
			}
		}
		if ($row['R_Show']==1){
			$show='Y';
		}else{
			$show='N';
		}
		if ($row['M_Type']==1){
			$gq=$run;
		}else{
			$gq='';
		}

		$league=$row[M_League];
		//if (strlen($lea)>5){
		//	$league=substr($lea,0,4)."<br>".substr($lea,4,4)."<br><font style=background-color=red>$gq</font>";
		//}else{
		//	$league=substr($lea,0,4)."<br><font style=background-color=red>$gq</font>";
		//}


		echo "parent.GameTN[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$league','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$row[M_LetB_en]','$row[M_LetB_en]','$MB_LetB_Rate','$TG_LetB_Rate','$h2c','$c2c','$h2s','$c2s','$row[MB_Dime_en]','$TG_Dime_Rate','$MB_Dime_Rate','$h3c','$c3c','$h3s','$c3s','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$h1c','$c1c','$n1c','$h1s','$c1s','$n1s','³æ','Âù','0.000','0.000','0','0','0','0','0','0');\n";
		$K=$K+1;
	}
	break;

case "RE":
	$mysql = "select MID,fopen,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB_HR_en,$m_league as M_League,$m_sleague as M_Sleague,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,MB_Dime_en,MB_LetB_Rate_HR,TG_LetB_Rate_HR,MB_MID,TG_MID,ShowType,M_Type,R_Show from volleyball where`m_start` < now( ) AND `m_Date` ='$mDate'  and RE_Show=1 order by m_start,mid";

	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
		$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);
		$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate_HR']);
		$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate_HR']);
		$mid=$row['MID'];

		$sql="select Mtype as mtype,LineType as linetype,count(*) as cou,sum(BetScore) as score FROM  `web_db_io` where MID =".$mid." and  LineType<11 and LineType>8 and corprator = '".$agname."' group by LineType,Mtype order by LineType,Mtype";
		$res_data = mysql_query( $sql);
		$n1c=0;
		$n1s=0;
		$h1c=0;
		$h1s=0;
		$c1c=0;
		$c1s=0;
		$c2c=0;
		$c2s=0;
		$h2c=0;
		$h2s=0;
		$c3c=0;
		$c3s=0;
		$h3c=0;
		$h3s=0;
		while ($data=mysql_fetch_array($res_data)){
			switch ($data["linetype"]){
			case "9":
				if ($data["mtype"]=='H'){
					$h2c=$data["cou"]-0;
					$h2s=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c2c=$data["cou"]-0;
					$c2s=$data["score"]-0;
				}
				break;
			case "10":
				if ($data["mtype"]=='H'){
					$h3c=$data["cou"]-0;
					$h3s=$data["score"]-0;
				}else if($data["mtype"]=='C'){
					$c3c=$data["cou"]-0;
					$c3s=$data["score"]-0;
				}
				break;
			}
		}
		if ($row['fopen']=='1'){
			$show='Y';
		}else{
			$show='N';
		}
		$MB_Dime=str_replace(' ','',strtolower($row['MB_Dime_en']));
		$PR_M_LetB=$row['M_LetB_HR_en'];
		echo "parent.GameTN[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$PR_M_LetB','$PR_M_LetB','$MB_LetB_Rate','$TG_LetB_Rate','$h2c','$c2c','$h2s','$c2s','$MB_Dime','$TG_Dime_Rate','$MB_Dime_Rate','$h3c','$c3c','$h3s','$c3s','$row[MB_Win]','$row[TG_Win]','$row[M_Flat]','$h1c','$c1c','$n1c','$h1s','$c1s','$n1s');\n";
		$K=$K+1;
	}

	break;
case "PD":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB1TG0,MB2TG0,MB2TG1,MB3TG0,MB3TG1,MB3TG2,MB4TG0,MB4TG1,MB4TG2,MB4TG3,MB0TG0,MB1TG1,MB2TG2,MB3TG3,MB4TG4,OVMB,MB0TG1,MB0TG2,MB1TG2,MB0TG3,MB1TG3,MB2TG3,MB0TG4,MB1TG4,MB2TG4,MB3TG4,OVTG,ShowType,PD_Show from volleyball where`m_start` > now( ) AND `m_Date` ='$mDate' order by m_start,mid";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$mid=$row['MID'];
		$sql="select count(*) as cou,sum(BetScore) as score FROM `web_db_io` where MID =".$mid." and  linetype=4 and corprator = '".$agname."'";
    	$res_data = mysql_query( $sql);
		$data=mysql_fetch_array($res_data);
		$n4c=0;
		$n4s=0;
		$n4c=$data["cou"]-0;
		$n4s=$data["score"]-0;
		if ($row['PD_Show']==1){
			$show='Y';
		}else{
			$show='N';
		}
		echo "parent.GameTN[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_League]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$n4c','$n4s');\n";
		$K=$K+1;
		}
	break;
case "P":
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_Sleague,MB_P_Win,TG_P_Win,M_P_Flat,MB_MID,TG_MID,ShowType,MB_PR_LetB,TG_PR_LetB,M_PR_LetB from volleyball where`m_start` > now( ) AND `m_Date` ='$mDate'".$league." and R_Show=1 order by m_start,mid";

	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";
	while ($row=mysql_fetch_array($result)){
		$n1c=0;
		$n1s=0;
		$h1c=0;
		$h1s=0;
		$c1c=0;
		$c1s=0;

		$mid=$row['MID'];
		$sql="select Mid,Mtype,count(*) as cou,sum(betscore) as score FROM `web_db_io` where FIND_IN_SET($mid,MID)>0 AND `m_Date` ='$mDate' and (linetype=7 or linetype=8) and corprator = '".$agname."' group by Mid,Mtype";
		$res_data = mysql_query( $sql);

		while ($data=mysql_fetch_array($res_data)){;

			$pdata=explode(",",$data['Mid']);
			$place=explode(",",$data['Mtype']);
			$cou=sizeof($place);
			for($i=0;$i<$cou;$i++){
			if ($pdata[$i]==$mid){
				switch ($place[$i]){
				case "H":
					$h1c=$h1c+$data["cou"]-0;
					$h1s=$h1s+$data["score"]-0;
					break;
				case "C":
					$c1c=$c1c+$data["cou"]-0;
					$c1s=$c1s+$data["score"]-0;
					break;
				case "N":
					$n1c=$n1c+$data["cou"]-0;
					$n1s=$n1s+$data["score"]-0;
					break;
				}
			}
		}
		}


		$show="Y";
		echo "parent.GameTN[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$h1c','$c1c','$n1c','$h1s','$c1s','$n1s');\n";
		$K=$K+1;
		}
	break;
case "PL":
	$mDate=date('m-d');
	$mysql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,M_LetB,$m_league as M_Sleague,MB_Win,TG_Win,M_Flat,MB_Dime_Rate,TG_Dime_Rate,MB_Dime_en,MB_LetB_Rate,TG_LetB_Rate,MB_MID,TG_MID,ShowType,M_Type,R_Show from volleyball where `m_Date` ='$mDate' and m_start<now() order by m_start,mid";
	$result = mysql_query( $mysql);
	$cou_num=mysql_num_rows($result);
	$page_size=40;
	$page_count=$cou_num/$page_size;
	$offset=$page_no*40;
	$mysql=$mysql."  limit $offset,40;";
	$result = mysql_query( $mysql);
	$cou=mysql_num_rows($result);
	echo "parent.gamount=$cou;\n";

	while ($row=mysql_fetch_array($result)){
		$PR_M_LetB=$row['M_LetB_en'];
		$mid=$row['MID'];
		$sql="select LineType as linetype,Mtype as mtype,count(*) as cou,sum(BetScore) as score FROM  `web_db_io` where FIND_IN_SET($mid,MID)>0 AND `m_Date` ='$bdate' AND corprator ='".$agname."' group by LineType,Mtype";

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
		//if ($row['MB_Inball']<>""){
			$show="Y";
		//}else{
		//	$show="N" ;
		//}
		echo "parent.GameTN[$K] = Array('$row[MID]','$row[M_Date]<br>$row[M_Time]','$row[M_Sleague]','$row[MB_MID]','$row[TG_MID]','$row[MB_Team]','$row[TG_Team]','$row[ShowType]','$show','$PR_M_LetB','$PR_M_LetB','$row[MB_LetB_Rate]','$row[TG_LetB_Rate]','$h2c','$c2c','$h2s','$c2s','$h9c','$c9c','$h9s','$c9s','$c3c','$h3c','$c3s','$h3s','$h1c','$c1c','$n1c','$h1s','$c1s','$n1s','$n4c','$n4s','$h51c','$h51s','0','0','$h53c','$h53s','0','0','0','0','0','0','0','$h8c','$h7c','$h8s','$h7s','0','$h10c','$c10c','$h10s','$c10s','0','$n14c','$n14s','$h12c','$c12c','$h12s','$c12s','$h13c','$c13c','$h13s','$c13s','$h11c','$c11c','$n11c','$h11s','$c11s','$n11s','$h15c','$h15s','$c15c','$c15s');\n";
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
$loginfo='²éÑ¯ÅÅÇò'.$rtype.'Àà:¼´Ê±×¢µ¥';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','3')";
mysql_query($mysql);
?>
