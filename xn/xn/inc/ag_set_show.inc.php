
<?

function get_set_table_show_ex($name,$class,$row,$wd_row,$qarr,$carr,$width='780'){
	$rt=array();
	$class_abcd=array();
	$class_ex=array();
	foreach($class as $v){
		if(count($class_abcd)<5){
			$class_abcd[]=$v;
		}else{
			$class_ex[]=$v;
		}
	}
	$FT=$qarr[$name];
	if($FT=='FS'){
		$class_ex=$class;
		$class_abcd=array();
	}

	$rt[]="<table width='$width' border='0' cellspacing='1' cellpadding='0' class='m_tab_ed'><tr class='m_title_edit'>";
	$rt[]="<td>$name </td>";
	foreach($class as $v){
		$rt[]="<td width='68'>$v</td>";
	}
	//退水s
	$rt[]="</tr><tr class='m_cen'>";
	$rt[]="<td align='right' class='m_ag_ed' nowrap>退水设定 <font color='#CC0000'>A</font></td>";
	foreach($class_abcd as $v){
		$FT_Turn_R="{$FT}_Turn_{$carr[$v]}_A";
		$rt[]="<td>$row[$FT_Turn_R]</td>";
	}
	foreach($class_ex as $v){
		$FT_Turn_R="{$FT}_Turn_{$carr[$v]}";
		$rt[]="<td rowspan='4'>$row[$FT_Turn_R]</td>";
	}
	$rt[]="</tr><tr class='m_cen'>";
	$rt[]="<td align='right' class='m_ag_ed'><font color='#CC0000'>B</font></td>";
	foreach($class_abcd as $v){
		$FT_Turn_R="{$FT}_Turn_{$carr[$v]}_B";
		$rt[]="<td>$row[$FT_Turn_R]</td>";
	}
	$rt[]="</tr><tr class='m_cen'>";
	$rt[]="<td align='right' class='m_ag_ed'><font color='#CC0000'>C</font></td>";
	foreach($class_abcd as $v){
		$FT_Turn_R="{$FT}_Turn_{$carr[$v]}_C";
		$rt[]="<td>$row[$FT_Turn_R]</td>";
	}
	$rt[]="</tr><tr class='m_cen'>";
	$rt[]="<td align='right' class='m_ag_ed'><font color='#CC0000'>D</font></td>";
	foreach($class_abcd as $v){
		$FT_Turn_R="{$FT}_Turn_{$carr[$v]}_D";
		$rt[]="<td>$row[$FT_Turn_R]</td>";
	}
	//退水e

	$rt[]="</tr><tr class='m_cen'>";
	$rt[]="<td align='right' class='m_ag_ed'>单场限额</td>";
	foreach($class as $v){
		$FT_Turn_R="{$FT}_{$carr[$v]}_Scene";
		$rt[]="<td>$row[$FT_Turn_R]</td>";
	}

	$rt[]="</tr><tr class='m_cen'>";
	$rt[]="<td align='right' class='m_ag_ed'>单注限额</td>";
	foreach($class as $v){
		$FT_Turn_R="{$FT}_{$carr[$v]}_Bet";
		$rt[]="<td>$row[$FT_Turn_R]</td>";
	}

	$rt[]="</tr></table>";
	return join('', $rt);
}
function get_set_table_show($row,$wd_row){
	$qarr=array(
		'足球'=>'FT',
		'篮球'=>'BK',
		'网球'=>'TN',
		'排球'=>'VB',
		'棒球'=>'BS',
		'其他'=>'OP',
		'冠军'=>'FS'
	);
	$carr=array(
		'让球'=>'R',
		'大小'=>'OU',
		'滚球'=>'RE',
		'滚球大小'=>'ROU',
		'单双'=>'EO',
		'独赢'=>'M',
		'滚球独赢'=>'RM',
		'标准过关'=>'P',
		'让球过关'=>'PR',
		'综合过关'=>'PC',
		'波胆'=>'PD',
		'入球'=>'T',
		'半全场'=>'F',
		'总得分'=>'T',
		'冠军'=>'R'
	);
	$return=array();
	$name='足球';
	$class=array('让球','大小','滚球','滚球大小','单双','滚球独赢','独赢','标准过关','让球过关','综合过关','波胆','入球','半全场');
	$return[]=get_set_table_show_ex($name,$class,$row,$wd_row,$qarr,$carr);
	
	$name='篮球';
	$class=array('让球','大小','滚球','滚球大小','单双','让球过关','综合过关');
	$bk=get_set_table_show_ex($name,$class,$row,$wd_row,$qarr,$carr,'580');

	$name='冠军';
	$class=array('冠军');
	$fs=get_set_table_show_ex($name,$class,$row,$wd_row,$qarr,$carr,'150');

	$return[]="<table width='780' border='0' cellspacing='0' cellpadding='0'><tr><td align='left'>$bk </td><td align='right'>$fs </td></tr></table>";

	$name='网球';
	$class=array('让球','大小','滚球','滚球大小','单双','独赢','标准过关','让球过关','综合过关','波胆','入球','半全场');
	$return[]=get_set_table_show_ex($name,$class,$row,$wd_row,$qarr,$carr);

	$name='排球';
	$class=array('让球','大小','滚球','滚球大小','单双','独赢','标准过关','让球过关','综合过关','波胆','入球','半全场');
	$return[]=get_set_table_show_ex($name,$class,$row,$wd_row,$qarr,$carr);

	$name='棒球';
	$class=array('让球','大小','滚球','滚球大小','单双','独赢','标准过关','让球过关','综合过关','波胆','总得分');
	$return[]=get_set_table_show_ex($name,$class,$row,$wd_row,$qarr,$carr);

	$name='其他';
	$class=array('让球','大小','滚球','滚球大小','单双','独赢','标准过关','让球过关','综合过关','波胆','入球','半全场');
	$return[]=get_set_table_show_ex($name,$class,$row,$wd_row,$qarr,$carr);

	return join('<br>',$return);
}
?>