
<?
function turn_rate($start_rate,$rate_split,$end_rate,$sel_rate){
	$turn_rate='';
	for($i=$start_rate;$i<$end_rate+$rate_split;$i+=$rate_split){
		if ($turn_rate==''){
			$turn_rate='<option>'.$i.'</option>';
		}else if($i==$sel_rate){
			$turn_rate=$turn_rate.'<option selected>'.$i.'</option>';
		}else{
			$turn_rate=$turn_rate.'<option>'.$i.'</option>';
		}
	}
	return $turn_rate;
}
function get_set_table_ex($name,$class,$row,$wd_row,$qarr,$carr,$width='780'){
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

	$rt[]="</tr><tr class='m_cen'>";
	$rt[]="<td align='right' class='m_ag_ed'>&nbsp;</td>";
	foreach($class as $v){
		$show_win = in_array($v,$class_abcd) ? 'show_win' : 'show_win2';
		$FT_R="{$FT}_{$carr[$v]}";
		$FT_R_Scene="{$FT_R}_Scene";
		$FT_R_Bet="{$FT_R}_Bet";
		$FT_Turn_R="{$FT}_Turn_{$carr[$v]}";
		$FT_Turn_R_A="{$FT_Turn_R}_A";
		$FT_Turn_R_B="{$FT_Turn_R}_B";
		$FT_Turn_R_C="{$FT_Turn_R}_C";
		$FT_Turn_R_D="{$FT_Turn_R}_D";
		if( in_array($v,$class_abcd) ){
			$rt[]="<td><a href='javascript:void(0)' onClick=\"show_win('$name-$v','$carr[$v]','$row[$FT_R_Scene]','$row[$FT_R_Bet]','$row[$FT_Turn_R_A]','$row[$FT_Turn_R_B]','$row[$FT_Turn_R_C]','$row[$FT_Turn_R_D]',0.25,'{$wd_row[$FT_Turn_R_A]}','{$wd_row[$FT_Turn_R_B]}','{$wd_row[$FT_Turn_R_C]}','{$wd_row[$FT_Turn_R_D]}','$FT');\"> 修改</a></td>";
		}else{
			$rt[]="<td><a href='javascript:void(0)' onClick=\"show_win2('$name-$v','$carr[$v]','$row[$FT_R_Scene]','$row[$FT_R_Bet]','$row[$FT_Turn_R]',1,'{$wd_row[$FT_Turn_R]}','$FT');\"> 修改</a></td>";
		}
	}
	$rt[]="</tr></table>";
	return join('', $rt);
}
function get_set_table($row,$wd_row){
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
	$return[]=get_set_table_ex($name,$class,$row,$wd_row,$qarr,$carr);
	
	$name='篮球';
	$class=array('让球','大小','滚球','滚球大小','单双','让球过关','综合过关');
	$bk=get_set_table_ex($name,$class,$row,$wd_row,$qarr,$carr,'580');

	$name='冠军';
	$class=array('冠军');
	$fs=get_set_table_ex($name,$class,$row,$wd_row,$qarr,$carr,'150');

	$return[]="<table width='780' border='0' cellspacing='0' cellpadding='0'><tr><td align='left'>$bk </td><td align='right'>$fs </td></tr></table>";

	$name='网球';
	$class=array('让球','大小','滚球','滚球大小','单双','独赢','标准过关','让球过关','综合过关','波胆','入球','半全场');
	$return[]=get_set_table_ex($name,$class,$row,$wd_row,$qarr,$carr);

	$name='排球';
	$class=array('让球','大小','滚球','滚球大小','单双','独赢','标准过关','让球过关','综合过关','波胆','入球','半全场');
	$return[]=get_set_table_ex($name,$class,$row,$wd_row,$qarr,$carr);

	$name='棒球';
	$class=array('让球','大小','滚球','滚球大小','单双','独赢','标准过关','让球过关','综合过关','波胆','总得分');
	$return[]=get_set_table_ex($name,$class,$row,$wd_row,$qarr,$carr);

	$name='其他';
	$class=array('让球','大小','滚球','滚球大小','单双','独赢','标准过关','让球过关','综合过关','波胆','入球','半全场');
	$return[]=get_set_table_ex($name,$class,$row,$wd_row,$qarr,$carr);

	return join('<br>',$return);
}

function get_rs_window($sid,$mid){
?>

<!----------------------结帐视窗1---------------------------->
<div id=rs_window style="display: none;position:absolute">
  <form name=rs_form action="" method=post onsubmit="return Chk_acc();">
    <input type=hidden name=rtype value="">
<input type=hidden name=act value="N">
<input type=hidden name=sid value="<?=$sid?>">
<input type=hidden name=id value="<?=$mid?>">
<input type=hidden name=kind value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
  <tr>
    <td bgcolor="#FFFFFF">
          <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix">
            <tr bgcolor="0163A2">
          <td width="200" id=r_title><font color="#FFFFFF">&nbsp;请输入</font></td>
          <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
            <tr bgcolor="#A4C0CE">
              <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr align="center">
                    <td>A盘</td>
                    <td>B盘</td>
                    <td>C盘</td>
                     <td>D盘</td>
                  </tr>
                  <tr align="center">
                    <td>
                      <select class="za_select" name="war_set_1">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_2">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_3">
                      </select>
                    </td>
                    <td>
                      <select class="za_select" name="war_set_4">
                      </select>
                    </td>
                  </tr>
                </table>
              </td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">单场限额&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SC" value="" size=8 maxlength=8 class="za_text" onkeyup="count_so(1)"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">单注限额&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SO" value="" size=8 maxlength=8 class="za_text"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
              <td colspan="2" align="center">
                <input type=submit name=rs_ok value="确定" class="za_button">
              </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>
<!----------------------结帐视窗1---------------------------->
<!----------------------结帐视窗2---------------------------->
<div id=rs_window_2 style="display: none;position:absolute">
  <form name=rs_form_2 action="" method=post onsubmit="return Chk_acc2();">
    <input type=hidden name=rtype value="">
<input type=hidden name=act value="N">
<input type=hidden name=sid value="<?=$sid?>">
<input type=hidden name=id value="<?=$mid?>">
<input type=hidden name=kind value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
  <tr>
    <td bgcolor="#FFFFFF">
            <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix">
              <tr bgcolor="0163A2">
          <td width="200" id=r_title_2><font color="#FFFFFF">&nbsp;请输入</font></td>
          <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win_2();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">退水设定&nbsp;&nbsp;<select class="za_select" name="war_set_1">
                  </select></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">单场限额&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SC_2" value="" size=8 maxlength=8 class="za_text" onkeyup="count_so(2)"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
          <td colspan="2">单注限额&nbsp;&nbsp;<input type=TEXT id=ft_b4_1 name="SO_2" value="" size=8 maxlength=8 class="za_text"></td>
        </tr>
        <tr bgcolor="#000000">
          <td colspan="2" height="1"></td>
        </tr>
        <tr bgcolor="#A4C0CE">
                <td colspan="2" align="center">
                  <input type=submit name=rs_ok value="确定" class="za_button">
                </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>
<!----------------------结帐视窗2---------------------------->
<? } ?>