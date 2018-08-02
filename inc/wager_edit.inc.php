<?php

require_once('settlement.inc.php');

function wager_update($sql, $id){
	$lower = strtolower($sql);
	$lower = str_replace(' ','', $lower);
	$lower = str_replace("'",'', $lower);
	if('updateweb_db_ioset' != substr($lower,0,18)) return;

	if(strpos($lower, 'result_type=0')) {
		
		settlement_cancel($id);
	}
	
	return mysql_query($sql);
}

?>