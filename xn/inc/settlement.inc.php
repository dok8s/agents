<?php

require_once('running_account.inc.php');

function settlement($id, $mb_inball, $tg_inball, $matche_status=0, $more=array())
{
	settlement_cancel($id);
	$mysql = "select odd_type,status,danger,id,result_type,linetype,showtype,mtype,pay_type,bettime,m_name,middle,turnrate,m_place,m_rate,betscore,gwin,agent_rate,world_rate,agent_point,world_point,corpor_turn,m_result,corpor_point from web_db_io where id='$id'";
	$result = mysql_query( $mysql );
	$row = mysql_fetch_array( $result );
	
	$ball = "$mb_inball:$tg_inball";

	if( in_array($row['linetype'],array(1,11,51,52)) ){ //独赢
		$graded=win_chk($mb_inball,$tg_inball,$row['mtype']);
	}
	elseif( in_array($row['linetype'],array(2,12)) ){ //让分
		$row['showtype']=='C' && $ball="$tg_inball:$mb_inball";
		$graded=odds_letb($mb_inball,$tg_inball,$row['showtype'],$row['m_place'],$row['mtype']);
	}
	elseif( in_array($row['linetype'],array(9,19)) ){ //滚球让分		
		$score=explode('<FONT color=red><b>',$row['middle']);
		$msg=explode("</b></FONT><br>",$score[1]);
		$bcd=explode(":",$msg[0]);
		$row['showtype']=='C' && $ball="$tg_inball:$mb_inball";
		$row['showtype']=='C' && $bcd=array($bcd[1],$bcd[0]);
		$graded=odds_letb($mb_inball-$bcd[0],$tg_inball-$bcd[1],$row['showtype'],$row['m_place'],$row['mtype']);
	}
	elseif( in_array($row['linetype'],array(3,13,10,20,30)) ){ //大小
		$graded=odds_dime($mb_inball,$tg_inball,$row['m_place'],$row['mtype']);
	}
	elseif( in_array($row['linetype'],array(4,34)) ){ //波胆
		$graded=odds_pd($mb_inball,$tg_inball,$row['mtype']);
	}
	elseif( in_array($row['linetype'],array(5)) ){ //单双
		$graded = ($mb_inball+$tg_inball)%2==1 ? 1 : -1;
		if(strtolower($row['mtype'])=='even'){
			$graded = $graded==1 ? -1 : 1;
		}
	}
	elseif( in_array($row['linetype'],array(6)) ){ //总入球
		$inball=$mb_inball+$tg_inball;
		if ($inball>=0 and $inball<=1){
			$goin_place="0~1";
		}elseif ($inball>=2 and $inball<=3){
			$goin_place="2~3";
		}elseif ($inball>=4 and $inball<=6){
			$goin_place="4~6";
		}elseif ($inball>=7){
			$goin_place="over";
		}
		$graded = strtolower($row['mtype'])==$goin_place ? 1 : -1;
	}
	elseif( in_array($row['linetype'],array(14)) ){ //半全场
		if(isset($more[1])){
			$ball="($more[0])$mb_inball:($more[1])$tg_inball";
			$graded=odds_half($more[0],$more[1],$mb_inball,$tg_inball,$row['mtype']);
		}
	}
	else{
		return ;
	}

	$notgraded=1;
	if($row['m_rate']<0 && $row['odd_type']<>''){
		if($graded==1 or $graded==0.5){
			$wingold = $row['betscore']*$graded;
		}
		elseif($graded==-1 or $graded==-0.5){
			$wingold = $row['betscore']*$row['m_rate']*abs($graded);
		}
		elseif($graded==0){
			$wingold=0;
		}
		elseif($graded==77){
			$wingold=0;
			$graded=0;
		}else{
			$wingold=0;
			$notgraded=0;
		}
	}else{
		if($graded==1 or $graded==0.5){
			$wingold = $row['gwin']*$graded;
		}
		elseif($graded==-1 or $graded==-0.5){
			$wingold = -$row['betscore']*abs($graded);
		}
		elseif($graded==0){
			$wingold=0;
		}
		elseif($graded==77){
			$wingold=0;
			$graded=0;
		}else{
			$wingold=0;
			$notgraded=0;
		}
	}

	$cancel=0;
	$status=0;
	if($matche_status>0){
		$status=$matche_status+0;
		if($status==1){
			$status=12;
		}else if($status==2){
			$status=5;
		}else if($status==3){
			$status=4;
		}else if($status==4){
			$status=7;
		}else if($status==5){
			$status=8;
		}else if($status==6){
			$status=9;
		}
		$cancel=1;
		$ball=$matche_status;
	}
	if($row['status']>0 && !in_array($row['status'], array(4,5,7,8,9))){ //注单状态不是来自比赛状态的
		$status=intval($row['status']);
	}
	if($mb_inball=='-1' or $tg_inball=='-1' or $status>0){
		$graded=0;
		$cancel=1;
	}
	if($status==0 && $cancel==1){//注单被取消但注单状态是“正常注单”
		$status=12;//取消
	}

	if ($notgraded==1){
		if($cancel==1){
			$gold_d			=	0;
			$wradio_a		=	0;
			$wradio_m		=	0;
			$members		=	0;
			$agents			=	0;
			$result_a		=	0;
			$result_s		=	0;
			$result_c		=	0;
		}else{
			//$gold_d			=	abs($graded)*$row['betscore'];//有效金额
			$gold_d			=	abs($wingold);// 输赢金额  有效金额

			$wradio_a		=	($row['agent_rate']-$row['turnrate'])*0.01*$gold_d;//代理退水=有效金额*(代理退水率-会员退水率)
			$wradio_m		=	$row['turnrate']*0.01*$gold_d;								//会员退水=有效金额*会员退水率

			$members		=	$wingold+$wradio_m;							//会员结果=会员输赢+会员退水
			$agents			=	$members+$wradio_a;							//代理商=会员输赢+代理退水

			$result_a		=	$agents*(100-$row['agent_point'])*0.01;	//代理商结果
			$result_s		=	$agents*(100-$row['agent_point']-$row['world_point'])*0.01+($row['world_rate']-$row['agent_rate'])*0.01*$gold_d;	//总代理商结果
			$result_c		=	$agents*(100-$row['agent_point']-$row['world_point']-$row['corpor_point'])*0.01+($row['corpor_turn']-$row['world_rate'])*0.01*$gold_d;	//总代理商结果

			$cancel			=	0;
		}

		if($row['danger']==2){
			$sql="update web_db_io set status='$status',QQ526738='$ball',vgold=0,m_result=0,a_result=0,result_a=0,result_s=0,result_c=0,result_type=1 where id=".$row['id'];
		}else if($row['danger']==1){
			$sql="update web_db_io set status='$status',danger=3,QQ526738='$ball',vgold=$gold_d,m_result=$members,a_result=$agents,result_a=$result_a,result_s=$result_s,result_c=$result_c,result_type=1 where id=".$row['id'];
		}else{
			$sql="update web_db_io set status='$status',QQ526738='$ball',vgold=$gold_d,m_result=$members,a_result=$agents,result_a=$result_a,result_s=$result_s,result_c=$result_c,result_type=1 where id=".$row['id'];
		}
		$result = mysql_query( $sql );

		if ($row['pay_type']==1){
			$changes_money=round($row['betscore']+$members,2);
			mysql_query("LOCK TABLE web_member WRITE");
			mysql_query("update web_member set money=money+$changes_money where memname='$row[m_name]'");
			$result = mysql_query("SELECT money FROM web_member WHERE memname='$row[m_name]'");
			mysql_query("UNLOCK TABLES");
			$memrow = mysql_fetch_array($result);

			$fid = running_account_get_fid($row['id']);
			$info = $cancel==1 ? "cancel" : $ball;
			$info = "$row[middle] <br><FONT color=#FF0099>($info) $row[betscore]</FONT>";
			running_account_add($fid, $row['m_name'], $row['id'], 12, time(), $info, $changes_money, $memrow['money']);
		}
	}
}

function settlement_cancel($id){
	$mysql = "select id,pay_type,m_name,middle,betscore,m_result,result_type from web_db_io where id='$id'";
	$result = mysql_query( $mysql );
	$row = mysql_fetch_array( $result );
	if($row['id']==$id && $row['pay_type']==1 && ($row['m_result']!=0 || $row['result_type']!=0)){
		$sql = "update web_db_io set QQ526738='',vgold=0,m_result=0,a_result=0,result_a=0,result_s=0,result_c=0,result_type=0 where id='$id' ";
		mysql_query($sql) or exit('error 192');
		
		$agold = $row['betscore']+$row['m_result'];
		mysql_query("LOCK TABLE web_member WRITE");
		mysql_query("update web_member set money=money-$agold where memname='$row[m_name]'") or exit("Settlement Cancel Error 178 ");
		$mem = mysql_fetch_array(mysql_query("select money from web_member where memname='$row[M_Name]'"));
		mysql_query("UNLOCK TABLES");
		running_account_cancel($id, 0, -$agold, $mem['money']);
	}
}

function settlement_is_hr($linetype){
	return in_array($linetype,array(52,34,19,30,11,12,13));
}
?>