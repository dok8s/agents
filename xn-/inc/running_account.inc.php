<?
$G_running_account = array(
	'types' => array(11=>'下注', 12=>'结算', 21=>'存款', 22=>'提款', 24=>'提款取消', 41=>'取消', 51=>'修改')
	);

function running_account_add($fid, $memname, $wagerid, $type, $time, $info, $changes_money, $member_money, $remark=''){
	global $G_running_account;
	//$memname = is_numeric($memberid) ? '' : addslashes($memberid);
	$mem = running_account_get_member($memberid, $memname);
	if($mem['id']>0 && isset($G_running_account['types'][abs($type)])){
	}else{
		exit("id or type error 8390,$mem[id],$type");
	}
	if($member_money='now_money'){
		$member_money = $mem['money'];
	}
	$memberid = $mem['id'];
	$memname  = $mem['memname'];
	$fid      = intval($fid);
	$wagerid  = intval($wagerid);
	$date =  date('Y-m-d', $time);

	$sql = "INSERT INTO web_running_account(fid,memberid,d0id,d1id,d2id,d3id,wagerid,type,date,time,memname,info,changes_money,member_money,remark) values ('$fid','$memberid','$mem[d0id]','$mem[d1id]','$mem[d2id]','$mem[d3id]','$wagerid','$type','$date','$time','$memname','$info','$changes_money','$member_money','$remark')";
	$query = mysql_query($sql) or exit("mysql error 8391");
	$raid  = mysql_insert_id();
	
	$logid=date('Ymd',$time).$memberid;
	mysql_query("REPLACE INTO web_money_log (logid,date,memid,memname,money) values ('$logid','$date','$memberid','$memname','$member_money')");
	return $raid;
}

function running_account_get($idtype, $id, $date_start, $date_end, $type='all', $show_cancel='yes', $limit='0, 50'){
	global $G_running_account;
	$types = $G_running_account['types'];
	
	$rt = array();
	$rt_count = 0;
	$id=intval($id);
	if(in_array($idtype,array('fid','memberid','d0id','d1id','d2id','d3id','wagerid'))){
		$sqladd = "$idtype='$id' and date>='$date_start' and date<='$date_end'";
		if(isset($types[$type])){
			$sqladd .= $show_cancel!='yes' ? " and type='$type'" : " and (type='$type' or type='-$type')" ;
		}else{
			$sqladd .= $show_cancel!='yes' ? " and type>'0' " : "";
		}
		
		$sql = "SELECT count(*) as count FROM web_running_account WHERE $sqladd";
		$query = mysql_query($sql) or exit("mysql error 8392");
		$row = mysql_fetch_array($query);
		$rt_count = intval($row['count']);

		$sql = "SELECT *,type as typeid FROM web_running_account WHERE $sqladd ORDER BY id ASC LIMIT $limit";
		$query = mysql_query($sql) or exit("mysql error 8393");
		while($row=mysql_fetch_array($query, MYSQL_ASSOC)){
			$row['type'] = $types[abs($row['type'])];
			$row['time'] = date("H:i:s",$row['time']);
			$rt[] = $row;
		}
	}
	return array($rt_count, $rt);
}

function running_account_cancel($wagerid, $raid, $changes_money, $member_money){
	global $G_running_account;
	
	if($raid<1){
		$sql = "SELECT * FROM web_running_account WHERE wagerid='$wagerid' and type=12 ORDER BY id DESC";
	}else{
		$sql = "SELECT * FROM web_running_account WHERE id='$raid' and type=12 ORDER BY id DESC";
	}
	$query = mysql_query($sql) or exit("mysql error 8392");
	$row = mysql_fetch_array($query);
	if($row['id']<1) {
		echo "running account cancel error";
		return ;
	}
	$row['type']=-$row['type'];

	$sql="UPDATE web_running_account SET type='$row[type]' WHERE id='$row[id]'";
	mysql_query($sql);

	$fid  = running_account_get_fid($wagerid);
	$remark = "取消结算($row[id])";
	running_account_add($fid, $row['memname'], $row['wagerid'], -41, time(), $row['info'], $changes_money, $member_money, $remark);
}

function running_account_get_member($memberid, $memname=''){
	$rt = array();
	$sql = "select id,memname,money,agents,world,corprator,super,pay_type from web_member where ";
	$sql.= $memname!='' ? "memname='$memname'" : "id='$memberid'";
	$query = mysql_query($sql) or exit("mysql error 8399");
	$row = mysql_fetch_array($query);
	$rt = $row;
	if($rt['id']>0){
		$row = mysql_fetch_array(mysql_query("SELECT id FROM web_super WHERE agname='$rt[super]'"));
		$rt['d0id'] = $row['id'];
		$row = mysql_fetch_array(mysql_query("SELECT id FROM web_corprator WHERE agname='$rt[corprator]'"));
		$rt['d1id'] = $row['id'];
		$row = mysql_fetch_array(mysql_query("SELECT id FROM web_world WHERE agname='$rt[world]'"));
		$rt['d2id'] = $row['id'];
		$row = mysql_fetch_array(mysql_query("SELECT id FROM web_agents WHERE agname='$rt[agents]'"));
		$rt['d3id'] = $row['id'];
	}
	return $rt;
}

function running_account_get_fid($wagerid, $type=11){
	$sql = "SELECT id FROM web_running_account WHERE wagerid='$wagerid' and type='$type'";
	$query = mysql_query($sql) or exit("mysql error 8392");
	$row = mysql_fetch_array($query);
	return intval($row['id']);
}

?>