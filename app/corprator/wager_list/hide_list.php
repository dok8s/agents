<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../member/include/traditional.zh-cn.inc.php");
$username=$_REQUEST['username'];
$active=$_REQUEST['active'];
$action=$_REQUEST['action'];
$id=$_REQUEST['id'];
$gid=$_REQUEST['gid'];

$pay_type=$_REQUEST['pay_type'];
$score=$_REQUEST['score'];
$result=-$_REQUEST['result'];

$gdate	=	$_REQUEST['gdate'];
if(empty($gdate)){$gdate=date('Y-m-d');}

$uid=$_REQUEST['uid'];

$sql = "select agname,super,setdata from web_corprator where oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if ($cou == 0 ){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>无权访问";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$super=$row['super'];
$admin_name="总后台/".$super."/".$agname;
$d1set = @unserialize($row['setdata']);

$sql = "select setdata,d1edit from web_super where agname='$super'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$d0set = @unserialize($row['setdata']);
$d0set['d1_edit']=$row['d1edit'];
foreach($d1set as $k=>$v){
	if($v==1 && substr($k,0,2)=='d1'){
		$d1set[$k] = $d0set[$k];
	}
}
if($d1set['d1_wager_add_edit']!=1 && $d1set['d1_wager_hide_edit']!=1 && $d1set['d1_edit']!=1){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>无权访问";
	exit;
}
if($cou==0){
	//echo "<script>window.open('$site/index.php','_top')<script>";
	exit;
}else{
if($action==10){
	$sql="update web_db_io set danger=3,status=10,result_type=0 where corprator='$agname' and id='$id'";
	mysql_query( $sql);
}else if($action==11){
	$sql="update web_db_io set danger=2,status=11,result_type=0 where corprator='$agname' and id='$id'";
	mysql_query( $sql);
}else{
	$sql="update web_db_io set status=$action,result_type=0 where corprator='$agname' and id='$id'";
	mysql_query( $sql);
}

switch ($active){
case 1:
	$mysql="select * from web_db_io where corprator='$agname' and id=$id";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);

	$middle		=	explode("<br>",$row['Middle']);
	$middle_tw	=	explode("<br>",$row['Middle_tw']);
	$middle_en	=	explode("<br>",$row['Middle_en']);

	$count=count($middle);
	if($count==4){
		$sid=explode('vs', $middle[1]);
		$sid=$sid[0].'vs'.$sid[1].'<br>';
		$middle1	=	$middle[0].'<br>(****)'.$middle[2].'<br>';
		$middle_tw1	=	$middle_tw[0].'<br>(****)'.$middle_tw[2].'<br>';
		$middle_en1	=	$middle_en[0].'<br>(****)'.$middle_en[2].'<br>';
	}else{
		$middle1	=	$middle[0].'<br>'.$middle[1].'<br>';
		$middle_tw1	=	$middle_tw[0].'<br>'.$middle_tw[1].'<br>';
		$middle_en1	=	$middle_en[0].'<br>'.$middle_en[1].'<br>';
	}
switch ($row['OpenType']){
	case "A":
		$arate=1.84;
		break;
	case "B":
		$arate=1.86;
		break;
	default:
		$arate=1.90;
		break;
	}
$arate=1.84;
	switch($row['odd_type']){
	case 'E':
		$rate=2+$arate-$row['M_Rate'];
		break;
	case 'I':
		if($row['M_Rate']>1){
			$rate=$arate-$row['M_Rate'];
		}else{
			$rate=$arate+round(1/$row['M_Rate'],2);
		}
		if($rate<1){

			$rate=-round(1/$rate,2);
		}

		break;
	case 'M':
		if($row['M_Rate']<0){
			$rate=$arate+round(1/$row['M_Rate'],2);
		}else{
			$rate=$arate-$row['M_Rate'];
			if($rate>1){
				$rate=round(-1/$rate,2);
			}
		}

		break;
	default:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.86-$row['M_Rate'];
			break;
		default:
			$rate=1.90-$row['M_Rate'];
			break;
		}

	}

	$rate=$rate.'0';

	$gwin	=	$row['BetScore']*$rate;

	switch ($row['LineType']){
  case 2:
		$gwin			=	$row['BetScore']*$rate;
		$team			=	explode("&nbsp;&nbsp;",$middle[$count-2]);
		$team_tw	=	explode("&nbsp;&nbsp;",$middle_tw[$count-2]);
		$team_en	=	explode("&nbsp;&nbsp;",$middle_en[$count-2]);

		if ($row[ShowType]=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='H';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='H';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}
		}
		$team=$middle[$count-1];
		if (strstr($team,'上半')){
			if($row['Active']<>3){
				$j10='半场';
				$j10_tw='半場';
				$j10_en='1st Half';
			}else{
				$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			}
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st Half]</font>&nbsp;";
		}else if(strstr($team,'下半')){
			$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[2st]</font>&nbsp;";
		}else if(strstr($team,'第1节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第1節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第1节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q1]</font>&nbsp;";
		}else if(strstr($team,'第2节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第2節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第2节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q2]</font>&nbsp;";
		}else if(strstr($team,'第3节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第3節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第3节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q3]</font>&nbsp;";
		}else if(strstr($team,'第4节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第4節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第4节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q4]</font>&nbsp;";
		}else{
			$bottom1_tw	=	'';
			$bottom1		=	'';
			$bottom1_en	=	'';
			$j10='全场';
			$j10_tw='全場';
			$j10_en='Full';
		}

		$lines2			=	$middle1.'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	$middle_tw1.'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	$middle_en1.'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';

		$st_old='<FONT COLOR=#0000BB><b>';
		$st_new='<FONT COLOR=#CC0000><b>';
		$middle12=str_replace($st_old,$st_new,$middle1);
		$middle_tw12=str_replace($st_old,$st_new,$middle_tw1);
		$middle_en12=str_replace($st_old,$st_new,$middle_en1);
		
		$lines2		=	str_replace('(****)','',$middle12).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',$middle_tw12).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',$middle_en12).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		
		
		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		
		}
		mysql_query( $mysql);

		break;
	case 3:
		$row['M_Place']=str_replace('UNDER','U',strtoupper($row['M_Place']));
		$row['M_Place']=str_replace('OVER','O',strtoupper($row['M_Place']));
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row[Mtype]=='C'){
			$mtype			=	'H';
			$m_place		=	'小'.$pan;
			$m_place_tw	=	'小'.$pan;
			$m_place_en	=	'Under'.$pan;
		}else{
			$mtype='C';
			$m_place		=	'大'.$pan;
			$m_place_tw	=	'大'.$pan;
			$m_place_en	=	'Over'.$pan;
		}

		$team=$middle[$count-1];
		if (strstr($team,'上半')){
			if($row['Active']<>3){
				$j10='半场';
				$j10_tw='半場';
				$j10_en='1st Half';
			}else{
				$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			}
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st Half]</font>&nbsp;";
		}else if(strstr($team,'下半')){
			$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[2st]</font>&nbsp;";
		}else if(strstr($team,'第1节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第1節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第1节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q1]</font>&nbsp;";
		}else if(strstr($team,'第2节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第2節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第2节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q2]</font>&nbsp;";
		}else if(strstr($team,'第3节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第3節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第3节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q3]</font>&nbsp;";
		}else if(strstr($team,'第4节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第4節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第4节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q4]</font>&nbsp;";
		}else{
			$bottom1_tw	=	'';
			$bottom1		=	'';
			$bottom1_en	=	'';
			$j10='全场';
			$j10_tw='全場';
			$j10_en='Full';
		}


		$lines2		=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle1)).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_tw1)).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_en1)).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		
		

		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		mysql_query( $mysql);
		break;
	case 9:
		$team			=	explode("&nbsp;&nbsp;",$middle[$count-2]);
		$team_tw	=	explode("&nbsp;&nbsp;",$middle_tw[$count-2]);
		$team_en	=	explode("&nbsp;&nbsp;",$middle_en[$count-2]);

		if ($row[ShowType]=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='H';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='H';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}
		}
		$team=$middle[$count-1];
		if (strstr($team,'上半')){
			if($row['Active']<>3){
				$j10='半场 滚球';
				$j10_tw='半場 滾球';
				$j10_en='1st Half Running Ball';
			}else{
				$j10='全场';
				$j10_tw='全場 滾球';
				$j10_en='Full Running Ball';
			}
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st Half]</font>&nbsp;";
		}else if(strstr($team,'下半')){
			$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='Full Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[2st]</font>&nbsp;";
		}else if(strstr($team,'第1节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='Full Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第1節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第1节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q1]</font>&nbsp;";
		}else if(strstr($team,'第2节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='Full Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第2節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第2节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q2]</font>&nbsp;";
		}else if(strstr($team,'第3节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='Full Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第3節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第3节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q3]</font>&nbsp;";
		}else if(strstr($team,'第4节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FullRunning Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第4節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第4节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q4]</font>&nbsp;";
		}else{
			$bottom1_tw	=	'';
			$bottom1		=	'';
			$bottom1_en	=	'';
			$j10='全场 滚球';
			$j10_tw='全場 滾球';
			$j10_en='Full Running Ball';
		}

		$st_old='<FONT COLOR=#0000BB><b>';
		$st_new='<FONT COLOR=#CC0000><b>';
		$middle12=str_replace($st_old,$st_new,$middle1);
		$middle_tw12=str_replace($st_old,$st_new,$middle_tw1);
		$middle_en12=str_replace($st_old,$st_new,$middle_en1);
		
		$lines2		=	str_replace('(****)','',$middle12).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',$middle_tw12).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',$middle_en12).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
	
		
		
		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		
		}
		mysql_query( $mysql);

		break;
	case 19:
		$gwin			=	$row['BetScore']*$rate;
		$team			=	explode("&nbsp;&nbsp;",$middle[$count-2]);
		$team_tw	=	explode("&nbsp;&nbsp;",$middle_tw[$count-2]);
		$team_en	=	explode("&nbsp;&nbsp;",$middle_en[$count-2]);

		if ($row[ShowType]=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='H';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='H';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}
		}
		$bottom1_tw	="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
		$bottom1		="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
		$bottom1_en="<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";

		$j10='半场 滚球';
		$j10_tw='半場 滾球';
		$j10_en='1st Half Running Ball';
		

		$st_old='<FONT COLOR=#0000BB><b>';
		$st_new='<FONT COLOR=#CC0000><b>';
		$middle12=str_replace($st_old,$st_new,$middle1);
		$middle_tw12=str_replace($st_old,$st_new,$middle_tw1);
		$middle_en12=str_replace($st_old,$st_new,$middle_en1);
		
		$lines2		=	str_replace('(****)','',$middle12).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',$middle_tw12).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',$middle_en12).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		
		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		
		}
		mysql_query( $mysql);
		break;
	case 10:
		$row['M_Place']=str_replace('UNDER','U',strtoupper($row['M_Place']));
		$row['M_Place']=str_replace('OVER','O',strtoupper($row['M_Place']));
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row[Mtype]=='C'){
			$mtype			=	'H';
			$m_place		=	'小'.$pan;
			$m_place_tw	=	'小'.$pan;
			$m_place_en	=	'Under'.$pan;
		}else{
			$mtype='C';
			$m_place		=	'大'.$pan;
			$m_place_tw	=	'大'.$pan;
			$m_place_en	=	'Over'.$pan;
		}

		$team=$middle[$count-1];
		if (strstr($team,'上半')){
			if($row['Active']<>3){
				$j10='半场 滚球';
				$j10_tw='半場 滾球';
				$j10_en='1st Half Running Ball';
			}else{
				$j10='全场';
				$j10_tw='全場 滾球';
				$j10_en='FullRunning Ball';
			}
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st Half]</font>&nbsp;";
		}else if(strstr($team,'下半')){
			$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FullRunning Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[2st]</font>&nbsp;";
		}else if(strstr($team,'第1节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FullRunning Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第1節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第1节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q1]</font>&nbsp;";
		}else if(strstr($team,'第2节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FullRunning Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第2節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第2节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q2]</font>&nbsp;";
		}else if(strstr($team,'第3节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FullRunning Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第3節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第3节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q3]</font>&nbsp;";
		}else if(strstr($team,'第4节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FullRunning Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第4節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第4节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q4]</font>&nbsp;";
		}else{
			$bottom1_tw	=	'';
			$bottom1		=	'';
			$bottom1_en	=	'';
			$j10='全场 滚球';
			$j10_tw='全場 滾球';
			$j10_en='Full Running Ball';
		}

		$lines2		=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle1)).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_tw1)).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_en1)).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		

		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		mysql_query( $mysql);
		break;
	case 30:
		$row['M_Place']=str_replace('UNDER','U',strtoupper($row['M_Place']));
		$row['M_Place']=str_replace('OVER','O',strtoupper($row['M_Place']));
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row[Mtype]=='C'){
			$mtype			=	'H';
			$m_place		=	'小'.$pan;
			$m_place_tw	=	'小'.$pan;
			$m_place_en	=	'Under'.$pan;
		}else{
			$mtype='C';
			$m_place		=	'大'.$pan;
			$m_place_tw	=	'大'.$pan;
			$m_place_en	=	'Over'.$pan;
		}


		$bottom1_tw	="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
		$bottom1		="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
		$bottom1_en="<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";

		$j10='半场 滚球';
		$j10_tw='半場 滾球';
		$j10_en='1st Half Running Ball';

		$lines2		=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle1)).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_tw1)).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_en1)).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		

		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		mysql_query( $mysql);
		break;
	case 12:
		$gwin			=	$row['BetScore']*$rate;
		$team			=	explode("&nbsp;&nbsp;",$middle[$count-2]);
		$team_tw	=	explode("&nbsp;&nbsp;",$middle_tw[$count-2]);
		$team_en	=	explode("&nbsp;&nbsp;",$middle_en[$count-2]);

		if ($row[ShowType]=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='H';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='H';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}
		}

		$bottom1_tw	="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
		$bottom1		="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
		$bottom1_en="<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";

		$j10='半场';
		$j10_tw='半場';
		$j10_en='1st Half';

		$st_old='<FONT COLOR=#0000BB><b>';
		$st_new='<FONT COLOR=#CC0000><b>';
		$middle12=str_replace($st_old,$st_new,$middle1);
		$middle_tw12=str_replace($st_old,$st_new,$middle_tw1);
		$middle_en12=str_replace($st_old,$st_new,$middle_en1);
		
		$lines2		=	str_replace('(****)','',$middle12).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',$middle_tw12).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',$middle_en12).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		
		}
		mysql_query( $mysql);

		break;
	case 13:
		$row['M_Place']=str_replace('UNDER','U',strtoupper($row['M_Place']));
		$row['M_Place']=str_replace('OVER','O',strtoupper($row['M_Place']));
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row[Mtype]=='C'){
			$mtype			=	'H';
			$m_place		=	'小'.$pan;
			$m_place_tw	=	'小'.$pan;
			$m_place_en	=	'Under'.$pan;
		}else{
			$mtype='C';
			$m_place		=	'大'.$pan;
			$m_place_tw	=	'大'.$pan;
			$m_place_en	=	'Over'.$pan;
		}


		$bottom1_tw	="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
		$bottom1		="<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
		$bottom1_en="<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";

		$j10='半场';
		$j10_tw='半場';
		$j10_en='1st Half';
		
		
		
		$lines2		=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle1)).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_tw1)).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_en1)).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		
		

		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		mysql_query( $mysql);

		break;
	}


	if($row['result_type']==1 and $row['pay_type']==1){
		$aa=$row['BetScore']+$row['M_Result'];
		$sql="update web_members set money=$money-$aa where m_name='".$row['M_Name']."'";
		mysql_query( $sql);
	}

	echo "<script languag='JavaScript'>self.location='hide_list.php?uid=$uid&username=$username&gdate=$gdate'</script>";
	break;
case 2:
	$sql='select result_type,betscore,m_result,m_name,pay_type from web_db_io where id='.$id;
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);
	if ($row['pay_type']==1){
		if ($row['result_type']==0){
			$sql="update web_member set money=money+$row[betscore] where memname='".$row[m_name]."'";
		}else{
			$sql="update web_member set money=money-$row[m_result] where memname='".$row[m_name]."'";
		}
		mysql_query( $sql);
	}
	$sql='update web_db_io set vgold=0,m_result=0,a_result=0,w_result=0,c_result=0,cancel=1,result_a=0,result_s=0,result_type=1 where id='.$id;
	mysql_query( $sql);
	echo "<script languag='JavaScript'>self.location='hide_list.php?uid=$uid&username=$username&gdate=$gdate'</script>";
	break;
case 3:
	$sql="select result_type,if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore) as betscore,m_result,m_name,pay_type from web_db_io where id=".$id;
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);
	if ($row['pay_type']==1){
		if ($row['result_type']==0){
			$sql="update web_member set money=money+$row[betscore] where memname='".$row[m_name]."'";
		}else{
			$sql="update web_member set money=money-$row[m_result] where memname='".$row[m_name]."'";
		}
		mysql_query( $sql);
	}else{
		$sql="update web_member set money=money+$row[betscore] where memname='".$row[m_name]."'";
		mysql_query( $sql);
	}
	$mysql="delete from web_db_io where id=".$id;
	mysql_query($mysql);
	echo "<script languag='JavaScript'>self.location='hide_list.php?uid=$uid&username=$username&gdate=$gdate'</script>";
	break;
case 4:
	$sql="select if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore) as betscore,m_name,pay_type from web_db_io where id=".$id;
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);
	if ($row['pay_type']==1){
		$sql="update web_member set money=money-$row[betscore] where memname='".$row[m_name]."'";
		mysql_query( $sql);
	}
	$sql="update web_db_io set vgold=0,m_result=0,a_result=0,w_result=0,c_result=0,status=0,result_a=0,result_s=0,result_type=0 where id=".$id;

	mysql_query($sql);
	echo "<script languag='JavaScript'>self.location='hide_list.php?uid=$uid&username=$username&gdate=$gdate'</script>";
	break;
case 5:
	$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore from web_db_io where hidden=0 and id<>$id and m_name='$username' and result_type=0 and m_date='".date('Y-m-d')."'";
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);

	$betscore=$row['betscore']+0;
	$sql="update web_member set money=credit-".$betscore." where memname='$username'";
	mysql_query( $sql);

	$sql="update web_db_io set hidden=1 where id=".$id;

	mysql_query($sql);
	echo "<script languag='JavaScript'>self.location='hide_list.php?uid=$uid&username=$username&gdate=$gdate'</script>";
	break;
case 6:
	$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore from web_db_io where hidden=0 and id<>$id and m_name='$username' and result_type=0 and m_date='".date('Y-m-d')."'";
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);
	$betscore=$row['betscore']+0;
	$sql="update web_member set money=credit-".$betscore." where memname='$username'";
	mysql_query( $sql);
	$sql="update web_db_io set hidden=0 where id=".$id;

	mysql_query($sql);
	echo "<script languag='JavaScript'>self.location='hide_list.php?uid=$uid&username=$username&gdate=$gdate'</script>";
	break;
}

$mysql="select odd_type,status,date_format(BetTime,'%m%d%H%i%s')+id as WID,danger,QQ526738,result_type,cancel,id,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,M_Name,TurnRate,BetType,BetIP,M_result,Middle,BetScore,pay_type,linetype,hidden from web_db_io where corprator='$agname' and m_name='".trim($username)."' and m_date='$gdate' order by bettime desc,linetype,mtype";
$result = mysql_query( $mysql);
?>
<html>
<head>
<title></title>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/css.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
<SCRIPT>
<!--
 function onLoad()
 {
  var gdate = document.getElementById('gdate');
  gdate.value = '<?=$gdate?>';
 }
function CheckCLOSE(str)
 {
  if(confirm("确实要取消本场比赛吗?"))
  document.location=str;
 }
 function reload()
{

	self.location.href='hide_list.php?uid=<?=$uid?>&username=<?=$username?>&gdate=<?=$gdate?>';
}
function Del(str)
 {
  if(confirm("确实要删除比投注纪录吗?"))
  document.location=str;
 }

// -->
</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"  onload="onLoad()";>
<form name="myFORM" method="post" action="">
<table width="769" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="" width="744">注单管理&nbsp;&nbsp;<input name=button type=button class="za_button" onClick="reload()" value="更新"> &nbsp;&nbsp;投注日期：<font color="#cc0000">
      <select class=za_select onchange=document.myFORM.submit(); name=gdate>
				<option value=""></option>
				<?
				$dd = 24*60*60;
				$t = time();
				$aa=0;
				$bb=0;
				for($i=0;$i<10;$i++)
				{
					$today=date('Y-m-d',$t);
					if ($gdate==date('Y-m-d',$t)){
						echo "<option value='$today' selected>".date('Y-m-d',$t)."</option>";
					}else{
						echo "<option value='$today'>".date('Y-m-d',$t)."</option>";
					}
				$t -= $dd;
				}
				?>
				</select>
            </font>&nbsp;&nbsp;&nbsp;&nbsp;帐号:<font color="cc0000">
            <?=$username?>
            </font>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.go( -1 );"> 回上一页</a>&nbsp;&nbsp;</font></font></td>
  </tr>
  <tr>
    <td colspan="2" height="4" width="778">
<table width="769" border="0" align="left" cellPadding="0" cellSpacing="0" background="/images/body_title_ph12b.gif" class="b_title">
  <tbody>

    <tr>
       <td width="394"><div align="right"></div></td>
                  <td width="375">&nbsp;</td>
    </tr>

  </tbody>
</table>
    </td>
  </tr>
</table>

<table width="1000" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
  <tr class="m_title_ft">
         <td width="90"align="center">投注时间</td>
          <td width="90" align="center">用户名称</td>
          <td width="150" align="center">球赛种类</td>
          <td width="350" align="center">內容</td>
          <td width="70" align="center">投注</td>
          <td width="70" align="center">会员</td>
          <td width="150" align="center">功能</td>
	  <td width="90">注单状态</td>
  </tr>
        <?
			while ($row = mysql_fetch_array($result)){
				$url="hide_list.php?uid=$uid&id=".$row[id]."&active=1&username=".$username."&gdate=".$gdate;
				if($row['hidden']== 1){
					$css='_close';
				}else{
					$css='';
				}
				?>
        <tr class="m_rig<?=$css?>">
          <td align="center"><?=$row['BetTime']?></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font><br><font color=blue><?=show_voucher($row['linetype'],$row['WID'])?><br><font color=green><?=$ODD[$row['odd_type']]?></font></td>
          <td align="center"><?=$row['BetType']?>
          	<?
							switch($row['danger']){
							case 1:
								echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认中&nbsp;</b></font></font>';
								break;
							case 2:
								echo '<br><font color=#ffffff style=background-color:#ff0000><b>未确认</b></font></font>';
								break;
							case 3:
								echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认&nbsp;</b></font></font>';
								break;
							default:
								break;
							}
							?>
</td>
  <td align="right">
  <?
	if ($row['linetype']==7 or $row['linetype']==8){
		$midd=explode('<br>',$row['Middle']);
		$ball=explode('<br>',$row['QQ526738']);

		for($t=0;$t<(sizeof($midd)-1)/2;$t++){
			echo $midd[2*$t].'<br>';
			if($row['result_type']==1){
				echo '<font color="#009900"><b>'.$ball[$t].'</b></font>  ';
			}
			echo $midd[2*$t+1].'<br>';
		}
	}else{
		$midd=explode('<br>',$row['Middle']);
		for($t=0;$t<sizeof($midd)-1;$t++){
			echo $midd[$t].'<br>';
		}
		if($row['result_type']==1){
			echo '<font color="#009900"><b>'.$row['QQ526738'].'</b></font>  ';
		}
		echo $midd[sizeof($midd)-1];
	}
if($row['linetype']==9 || $row['linetype']==10 || $row['linetype']==19 || $row['linetype']==30 || $row['linetype']==51 || $row['linetype']==52){
						$wager=$wager_vars_re;
					}else if($row['linetype']==7 || $row['linetype']==8 ){
						$wager=$wager_vars_p;
					}else{
						$wager=$wager_vars;
					}

	?>
	</td>
  <td align="center"><?=$row['BetScore']?></td>
  <td><?=mynumberformat($row['M_result'],1)?></td>
  <td align="left">&nbsp;&nbsp;
  	<?
	$htmlarr = array();
	if ($d1set['d1_edit_list_re']==1 && in_array($row['linetype'], array(2,3,12,13,9,10,19,30)) ){
		$htmlarr[]="<a href='$url'>对调</a>";
	}
	if($d1set['d1_edit_list_edit']==1){
		$htmlarr[]="<a href='wager_edit.php?uid=$uid&id=$row[id]&username=$row[M_Name]&gdate=$gdate'>修改</a>";
	}
	if($d1set['d1_edit_list_del']==1){
		$htmlarr[]="<a href='javascript:Del(\"?uid=$uid&id=$row[id]&active=3&username=$username&gdate=$gdate\")'>删除</a>";
	}
	if($d1set['d1_edit_list_hide']==1){
		$tmpa = $row['hidden']==0 ? 5 : 6;
		$tmpb = $row['hidden']==0 ? '<font color=red><b>隐藏</b></font>' : '不隐藏';
		$htmlarr[]="<a href='?uid=$uid&id=$row[id]&username=$username&active=$tmpa&gdate=$gdate'>$tmpb</a>";
	}
	echo join('&nbsp;/&nbsp;', $htmlarr);
	?>
 	</td>
<td align="left"><DIV class=menu2 onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">
          <div align="center"><FONT color=red><b><?=$wager[$row['status']]?><b></FONT></div>
          <UL style="LEFT: 28px">
					<?


					while (list($key, $value) = each($wager)) {
						if($value<>''){
					?>
             <LI><A href="?username=<?=$row['M_Name']?>&gdate=<?=$gdate?>&uid=<?=$uid?>&gid=<?=$gid?>&id=<?=$row['id']?>&action=<?=$key?>&gtype=<?=$gtype?>" target=_self><?=$value?></A>
					<?
						}
					}
					?>
					</UL>
					</DIV>
					<? if($d0set['d0show_memip']==1){ ?>
<div align="center"><a href="http://ip138.com/ips138.asp?ip=<?=$row["BetIP"]?>" target="_blank"><font color=blue><?=$row['BetIP']?></font></a></div>
					<? } ?>
</td>
        </tr>
        <?
$gold+=$row['BetScore'];
$wingold+=$row['M_result'];
$mcount++;
}
?>
<tr class="m_title_ft">
          <td width="60"align="center"></td>
          <td width="90" align="center"></td>
          <td width="100" align="center"></td>
          <td width="230" align="center"><?=$mcount?></td>
          <td width="70" align="center"><?=$gold?></td>
          <td width="70" align="center"><?=$wingold?></td>
          <td width="90" align="center"></td>
	  <td width="120"></td>
        </tr>
      </table>

<?
}
$loginfo='注单管理列表';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','1')";
mysql_query($mysql);
mysql_close();
?>
</table>
</form>
</BODY>
</html>
