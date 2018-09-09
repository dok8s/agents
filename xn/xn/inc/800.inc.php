<?php

function get_gold($class,$type,$name,$time_start,$time_end,$paytype=1,$paysucces=1){
	if(!in_array($class,array('memname','agents','world','corprator','super'))){
		return '';
	}
	$time_start = date('Y-m-d 00:00:00',strtotime($time_start));
	$time_end = date('Y-m-d 23:59:59',strtotime($time_end));
	$sql = "select SUM(gold) as gold from sys800 where `$class`='$name' and indate>='$time_start' and indate<='$time_end' and type='$type'";
	$type=='S' && $sql .= " and paysucces='$paysucces'";
	$result = mysql_query( $sql ) or exit('error 800.8');
	$row = mysql_fetch_array( $result );
	return $row['gold'];
}

function get_gold_memname($type,$name,$time_start,$time_end,$paytype=1,$paysucces=1){
	return get_gold('memname',$type,$name,$time_start,$time_end,$paytype,$paysucces);
}

function get_gold_agents($type,$name,$time_start,$time_end,$paytype=1,$paysucces=1){
	return get_gold('agents',$type,$name,$time_start,$time_end,$paytype,$paysucces);
}

function get_gold_world($type,$name,$time_start,$time_end,$paytype=1,$paysucces=1){
	return get_gold('world',$type,$name,$time_start,$time_end,$paytype,$paysucces);
}

function get_gold_corprator($type,$name,$time_start,$time_end,$paytype=1,$paysucces=1){
	return get_gold('corprator',$type,$name,$time_start,$time_end,$paytype,$paysucces);
}

function get_gold_super($type,$name,$time_start,$time_end,$paytype=1,$paysucces=1){
	return get_gold('super',$type,$name,$time_start,$time_end,$paytype,$paysucces);
}

function get_now_money($class,$name){
	$sqlarr = array();
	$sqlarr['memname']   = " and memname='$name'";
	$sqlarr['agents']    = " and agents='$name'";
	$sqlarr['world']     = " and world='$name'";
	$sqlarr['corprator'] = " and corprator='$name'";
	$sqlarr['super']     = " and super='$name'";
	if(isset($sqlarr[$class])){
		$sql = "SELECT SUM(money) as money FROM web_member WHERE pay_type='1' and status='1' $sqlarr[$class]";
		$result = mysql_query( $sql ) or exit('error 800.5');
		$row = mysql_fetch_array( $result );
		return $row['money'];
	}
	
	return '';
}
?>