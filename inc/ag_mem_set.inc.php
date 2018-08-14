<?

$action=$_REQUEST["act"];
$rtype=strtoupper($_REQUEST['rtype']);
$sc=$_REQUEST['SC'];
$so=$_REQUEST['SO'];
$st=$_REQUEST['war_set'];
$kind=$_REQUEST['kind'];
$mysql = "select * from web_agents where Agname='$aid'";

$ag_result = mysql_query($mysql);
$ag_row = mysql_fetch_array($ag_result);
$agents_id=$ag_row["ID"];
$agents_name=$ag_row["Agname"];


if ($action=='Y'){	
	$ag_scene=$kind.'_'.$rtype."_Scene";
	$ag_bet=$kind.'_'.$rtype."_Bet";
	$agscene=$ag_row[$ag_scene];
	$agbet=$ag_row[$ag_bet];
	
	if ($sc>$agscene){
		echo wterror("此会员的单场限额已超过代理商的单场限额，请回上一面重新输入");
		exit();
	}
	if ($so>$agbet){
		echo wterror("此会员的单注限额已超过代理商的单注限额，请回上一面重新输入");
		exit();
	}
	$upstr="";
	switch($kind){
		case "FT":
			switch($rtype){
				case "R":
					$upstr=$upstr."FT_R_Scene='".$sc."',FT_R_Bet='".$so."',FT_Turn_R='".$st."',";
					$upstr=$upstr."FT_OU_Scene='".$sc."',FT_OU_Bet='".$so."',FT_Turn_OU='".$st."',";
					$upstr=$upstr."FT_EO_Scene='".$sc."',FT_EO_Bet='".$so."',FT_Turn_EO='".$st."'";
				break;
				case "RE":
					$upstr=$upstr."FT_RE_Scene='".$sc."',FT_RE_Bet='".$so."',FT_Turn_RE='".$st."',";
					$upstr=$upstr."FT_ROU_Scene='".$sc."',FT_ROU_Bet='".$so."',FT_Turn_ROU='".$st."'";
				break;
				case "M":
					$upstr=$upstr."FT_M_Scene='".$sc."',FT_M_Bet='".$so."',FT_Turn_M='".$st."',";
					$upstr=$upstr."FT_RM_Scene='".$sc."',FT_RM_Bet='".$so."',FT_Turn_RM='".$st."'";
				break;
				case "PC":
					$upstr=$upstr."FT_P_Scene='".$sc."',FT_P_Bet='".$so."',FT_Turn_P='".$st."',";
					$upstr=$upstr."FT_PR_Scene='".$sc."',FT_PR_Bet='".$so."',FT_Turn_PR='".$st."',";
					$upstr=$upstr."FT_PC_Scene='".$sc."',FT_PC_Bet='".$so."',FT_Turn_PC='".$st."',";
					$upstr=$upstr."FT_PD_Scene='".$sc."',FT_PD_Bet='".$so."',FT_Turn_PD='".$st."',";
					$upstr=$upstr."FT_T_Scene='".$sc."',FT_T_Bet='".$so."',FT_Turn_T='".$st."',";
					$upstr=$upstr."FT_F_Scene='".$sc."',FT_F_Bet='".$so."',FT_Turn_F='".$st."'";
				break;	
			}
		break;
		case "BK":
			switch($rtype){
				case "R":
					$upstr=$upstr."BK_R_Scene='".$sc."',BK_R_Bet='".$so."',BK_Turn_R='".$st."',";
					$upstr=$upstr."BK_OU_Scene='".$sc."',BK_OU_Bet='".$so."',BK_Turn_OU='".$st."',";
					$upstr=$upstr."BK_EO_Scene='".$sc."',BK_EO_Bet='".$so."',BK_Turn_EO='".$st."'";
				break;
				case "RE":
					$upstr=$upstr."BK_RE_Scene='".$sc."',BK_RE_Bet='".$so."',BK_Turn_RE='".$st."',";
					$upstr=$upstr."BK_ROU_Scene='".$sc."',BK_ROU_Bet='".$so."',BK_Turn_ROU='".$st."'";
				break;
				case "PC":
					$upstr=$upstr."BK_PR_Scene='".$sc."',BK_PR_Bet='".$so."',BK_Turn_PR='".$st."',";
					$upstr=$upstr."BK_PC_Scene='".$sc."',BK_PC_Bet='".$so."',BK_Turn_PC='".$st."'";
					
				break;	
			}
		break;	
		
		case "OP":
			switch($rtype){
				case "R":
					$upstr=$upstr."TN_R_Scene='".$sc."',TN_R_Bet='".$so."',TN_Turn_R='".$st."',";
					$upstr=$upstr."TN_OU_Scene='".$sc."',TN_OU_Bet='".$so."',TN_Turn_OU='".$st."',";
					$upstr=$upstr."TN_EO_Scene='".$sc."',TN_EO_Bet='".$so."',TN_Turn_EO='".$st."',";
					
					$upstr=$upstr."VB_R_Scene='".$sc."',VB_R_Bet='".$so."',VB_Turn_R='".$st."',";
					$upstr=$upstr."VB_OU_Scene='".$sc."',VB_OU_Bet='".$so."',VB_Turn_OU='".$st."',";
					$upstr=$upstr."VB_EO_Scene='".$sc."',VB_EO_Bet='".$so."',VB_Turn_EO='".$st."',";
					
					$upstr=$upstr."BS_R_Scene='".$sc."',BS_R_Bet='".$so."',BS_Turn_R='".$st."',";
					$upstr=$upstr."BS_OU_Scene='".$sc."',BS_OU_Bet='".$so."',BS_Turn_OU='".$st."',";
					$upstr=$upstr."BS_EO_Scene='".$sc."',BS_EO_Bet='".$so."',BS_Turn_EO='".$st."',";
					
					$upstr=$upstr."OP_R_Scene='".$sc."',OP_R_Bet='".$so."',OP_Turn_R='".$st."',";
					$upstr=$upstr."OP_OU_Scene='".$sc."',OP_OU_Bet='".$so."',OP_Turn_OU='".$st."',";
					$upstr=$upstr."OP_EO_Scene='".$sc."',OP_EO_Bet='".$so."',OP_Turn_EO='".$st."'";
				break;
				case "RE":
					$upstr=$upstr."TN_RE_Scene='".$sc."',TN_RE_Bet='".$so."',TN_Turn_RE='".$st."',";
					$upstr=$upstr."TN_ROU_Scene='".$sc."',TN_ROU_Bet='".$so."',TN_Turn_ROU='".$st."',";
					
					$upstr=$upstr."VB_RE_Scene='".$sc."',VB_RE_Bet='".$so."',VB_Turn_RE='".$st."',";
					$upstr=$upstr."VB_ROU_Scene='".$sc."',VB_ROU_Bet='".$so."',VB_Turn_ROU='".$st."',";
					
					$upstr=$upstr."BS_RE_Scene='".$sc."',BS_RE_Bet='".$so."',BS_Turn_RE='".$st."',";
					$upstr=$upstr."BS_ROU_Scene='".$sc."',BS_ROU_Bet='".$so."',BS_Turn_ROU='".$st."',";
					
					$upstr=$upstr."OP_RE_Scene='".$sc."',OP_RE_Bet='".$so."',OP_Turn_RE='".$st."',";
					$upstr=$upstr."OP_ROU_Scene='".$sc."',OP_ROU_Bet='".$so."',OP_Turn_ROU='".$st."'";
				break;
				case "M":
					$upstr=$upstr."TN_M_Scene='".$sc."',TN_M_Bet='".$so."',TN_Turn_M='".$st."',";
					$upstr=$upstr."VB_M_Scene='".$sc."',VB_M_Bet='".$so."',VB_Turn_M='".$st."',";
					$upstr=$upstr."BS_M_Scene='".$sc."',BS_M_Bet='".$so."',BS_Turn_M='".$st."',";
					$upstr=$upstr."OP_M_Scene='".$sc."',OP_M_Bet='".$so."',OP_Turn_M='".$st."'";
				break;
				case "PC":
					$upstr=$upstr."TN_P_Scene='".$sc."',TN_P_Bet='".$so."',TN_Turn_P='".$st."',";
					$upstr=$upstr."TN_PR_Scene='".$sc."',TN_PR_Bet='".$so."',TN_Turn_PR='".$st."',";
					$upstr=$upstr."TN_PC_Scene='".$sc."',TN_PC_Bet='".$so."',TN_Turn_PC='".$st."',";
					$upstr=$upstr."TN_PD_Scene='".$sc."',TN_PD_Bet='".$so."',TN_Turn_PD='".$st."',";
					$upstr=$upstr."TN_T_Scene='".$sc."',TN_T_Bet='".$so."',TN_Turn_T='".$st."',";
					$upstr=$upstr."TN_F_Scene='".$sc."',TN_F_Bet='".$so."',TN_Turn_F='".$st."',";
					
					$upstr=$upstr."VB_P_Scene='".$sc."',VB_P_Bet='".$so."',VB_Turn_P='".$st."',";
					$upstr=$upstr."VB_PR_Scene='".$sc."',VB_PR_Bet='".$so."',VB_Turn_PR='".$st."',";
					$upstr=$upstr."VB_PC_Scene='".$sc."',VB_PC_Bet='".$so."',VB_Turn_PC='".$st."',";
					$upstr=$upstr."VB_PD_Scene='".$sc."',VB_PD_Bet='".$so."',VB_Turn_PD='".$st."',";
					$upstr=$upstr."VB_T_Scene='".$sc."',VB_T_Bet='".$so."',VB_Turn_T='".$st."',";
					$upstr=$upstr."VB_F_Scene='".$sc."',VB_F_Bet='".$so."',VB_Turn_F='".$st."',";
					
					$upstr=$upstr."BS_P_Scene='".$sc."',BS_P_Bet='".$so."',BS_Turn_P='".$st."',";
					$upstr=$upstr."BS_PR_Scene='".$sc."',BS_PR_Bet='".$so."',BS_Turn_PR='".$st."',";
					$upstr=$upstr."BS_PC_Scene='".$sc."',BS_PC_Bet='".$so."',BS_Turn_PC='".$st."',";
					$upstr=$upstr."BS_PD_Scene='".$sc."',BS_PD_Bet='".$so."',BS_Turn_PD='".$st."',";
					$upstr=$upstr."BS_T_Scene='".$sc."',BS_T_Bet='".$so."',BS_Turn_T='".$st."',";
					
					$upstr=$upstr."OP_P_Scene='".$sc."',OP_P_Bet='".$so."',OP_Turn_P='".$st."',";
					$upstr=$upstr."OP_PR_Scene='".$sc."',OP_PR_Bet='".$so."',OP_Turn_PR='".$st."',";
					$upstr=$upstr."OP_PC_Scene='".$sc."',OP_PC_Bet='".$so."',OP_Turn_PC='".$st."',";
					$upstr=$upstr."OP_PD_Scene='".$sc."',OP_PD_Bet='".$so."',OP_Turn_PD='".$st."',";
					$upstr=$upstr."OP_T_Scene='".$sc."',OP_T_Bet='".$so."',OP_Turn_T='".$st."',";
					$upstr=$upstr."OP_F_Scene='".$sc."',OP_F_Bet='".$so."',OP_Turn_F='".$st."'";
				break;	
			}
		break;
		case "FS":
			$upstr=$upstr."FS_R_Scene='".$sc."',FS_R_Bet='".$so."',FS_Turn_R='".$st."'";
		break;
	}
	$mysql="update web_member set $upstr where id=$mid";
	mysql_query($mysql) or die ("操作失败!");
}

$sql = "select * from web_member where ID=$mid";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$opentype=$row['OpenType'];

$r_turn='FT_Turn_R_'.$opentype;
$r_turn=$ag_row[$r_turn];
$ou_turn='FT_Turn_OU_'.$opentype;
$ou_turn=$ag_row[$ou_turn];
$re_turn='FT_Turn_RE_'.$opentype;
$re_turn=$ag_row[$re_turn];
$rou_turn='FT_Turn_ROU_'.$opentype;
$rou_turn=$ag_row[$rou_turn];
$eo_turn='FT_Turn_EO_'.$opentype;
$eo_turn=$ag_row[$eo_turn];

//////////////////////////////
$vb_r_turn='VB_Turn_R_'.$opentype;
$vb_turn=$ag_row[$vb_r_turn];
$vb_ou_turn='VB_Turn_OU_'.$opentype;
$vb_ou_turn=$ag_row[$vb_ou_turn];
$vb_re_turn='VB_Turn_RE_'.$opentype;
$vb_re_turn=$ag_row[$vb_re_turn];
$vb_rou_turn='VB_Turn_ROU_'.$opentype;
$vb_rou_turn=$ag_row[$vb_rou_turn];
$vb_eo_turn='VB_Turn_EO_'.$opentype;
$vb_eo_turn=$ag_row[$vb_eo_turn];
////////////////////////
$bs_r_turn='BS_Turn_R_'.$opentype;
$bs_r_turn=$ag_row[$bs_r_turn];
$bs_ou_turn='BS_Turn_OU_'.$opentype;
$bs_ou_turn=$ag_row[$bs_ou_turn];
$bs_re_turn='BS_Turn_RE_'.$opentype;
$bs_re_turn=$ag_row[$bs_re_turn];
$bs_rou_turn='BS_Turn_ROU_'.$opentype;
$bs_rou_turn=$ag_row[$bs_rou_turn];
$bs_eo_turn='BS_Turn_EO_'.$opentype;
$bs_eo_turn=$ag_row[$bs_eo_turn];
////////////////////////
$tn_r_turn='TN_Turn_R_'.$opentype;
$tn_r_turn=$ag_row[$tn_r_turn];
$tn_ou_turn='TN_Turn_OU_'.$opentype;
$tn_ou_turn=$ag_row[$tn_ou_turn];
$tn_re_turn='TN_Turn_RE_'.$opentype;
$tn_re_turn=$ag_row[$tn_re_turn];
$tn_rou_turn='TN_Turn_ROU_'.$opentype;
$tn_rou_turn=$ag_row[$tn_rou_turn];
$tn_eo_turn='TN_Turn_EO_'.$opentype;
$tn_eo_turn=$ag_row[$tn_eo_turn];

/////////////////////
$bk_r_turn='BK_Turn_R_'.$opentype;
$bk_r_turn=$ag_row[$bk_r_turn];
$bk_ou_turn='BK_Turn_OU_'.$opentype;
$bk_ou_turn=$ag_row[$bk_ou_turn];
$bk_eo_turn='BK_Turn_EO_'.$opentype;
$bk_eo_turn=$ag_row[$bk_eo_turn];

$bk_re_turn='BK_Turn_RE_'.$opentype;
$bk_re_turn=$ag_row[$bk_re_turn];

$bk_rou_turn='BK_Turn_ROU_'.$opentype;
$bk_rou_turn=$ag_row[$bk_rou_turn];

////////////////////
$op_r_turn='OP_Turn_R_'.$opentype;
$op_r_turn=$ag_row[$op_r_turn];
$op_ou_turn='OP_Turn_OU_'.$opentype;
$op_ou_turn=$ag_row[$op_ou_turn];
$op_re_turn='OP_Turn_RE_'.$opentype;
$op_re_turn=$ag_row[$op_re_turn];
$op_rou_turn='OP_Turn_ROU_'.$opentype;
$op_rou_turn=$ag_row[$op_rou_turn];
$op_eo_turn='OP_Turn_EO_'.$opentype;
$op_eo_turn=$ag_row[$op_eo_turn];
	
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
?>
<script>if(self == top) parent.location='/'</script>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {background-color: #bdd1de; text-align: center}
-->
</style>
<SCRIPT LANGUAGE="JAVASCRIPT1.2">
var admin_type='';
//上层(预设)金额设定(SC,S0);
/*upMenSet = new Array();
upMenSet['FT_R']  = new Array('<?=$row['FT_R_Scene']?>','<?=$row['FT_R_Bet']?>');
upMenSet['FT_RE']  = new Array('<?=$row['FT_RE_Scene']?>','<?=$row['FT_RE_Bet']?>');
upMenSet['FT_M']  = new Array('<?=$row['FT_M_Scene']?>','<?=$row['FT_M_Bet']?>');
upMenSet['FT_DT']  = new Array('<?=$row['FT_PC_Scene']?>','<?=$row['FT_PC_Bet']?>');
upMenSet['BK_R']  = new Array('<?=$row['BK_R_Scene']?>','<?=$row['BK_R_Bet']?>');
upMenSet['BK_RE']  = new Array('<?=$row['BK_RE_Scene']?>','<?=$row['BK_RE_Bet']?>');
upMenSet['BK_DT']  = new Array('<?=$row['BK_PC_Scene']?>','<?=$row['BK_PC_Bet']?>');
upMenSet['FS_FS']  = new Array('<?=$row['FS_R_Scene']?>','<?=$row['FS_R_Bet']?>');
upMenSet['OP_R']  = new Array('<?=$row['OP_R_Scene']+0?>','<?=$row['OP_R_Bet']+0?>');
upMenSet['OP_RE']  = new Array('<?=$row['OP_RE_Scene']+0?>','<?=$row['OP_RE_Bet']+0?>');
upMenSet['OP_M']  = new Array('<?=$row['OP_M_Scene']+0?>','<?=$row['OP_M_Bet']+0?>');
upMenSet['OP_DT']  = new Array('<?=$row['OP_PC_Scene']+0?>','<?=$row['OP_PC_Bet']+0?>');
*/
upMenSet = new Array();
upMenSet['FT_R']  = new Array('500000','500000');
upMenSet['FT_RE']  = new Array('500000','500000');
upMenSet['FT_M']  = new Array('500000','500000');
upMenSet['FT_PC']  = new Array('500000','500000');
upMenSet['BK_R']  = new Array('500000','500000');
upMenSet['BK_RE']  = new Array('500000','500000');
upMenSet['BK_PC']  = new Array('500000','500000');
upMenSet['FS_R']  = new Array('500000','500000');
upMenSet['OP_R']  = new Array('500000','500000');
upMenSet['OP_RE']  = new Array('500000','500000');
upMenSet['OP_M']  = new Array('500000','500000');
upMenSet['OP_PC']  = new Array('500000','500000');


FT_chg_box_R_title = "请输入足球-让球, 大小, 单双设定";
FT_chg_box_RE_title = "请输入足球-滚球让球, 滚球大小设定";
FT_chg_box_M_title = "请输入足球-独赢, 滚球独赢设定";
FT_chg_box_PC_title = "请输入足球-其他设定";
BK_chg_box_R_title = "请输入篮球-让球, 大小, 单双设定";
BK_chg_box_RE_title = "请输入篮球-滚球让球, 滚球大小设定";
BK_chg_box_PC_title = "请输入篮球-其他设定";
OP_chg_box_R_title = "请输入综合球类-让球, 大小, 单双设定";
OP_chg_box_RE_title = "请输入综合球类-滚球让球, 滚球大小设定";
OP_chg_box_M_title = "请输入综合球类-独赢, 滚球独赢设定";
OP_chg_box_PC_title = "请输入综合球类-其他设定";
FS_chg_box_R_title = "请输入冠军-冠军设定";
</SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT1.2" src="/js/mem_set.js"></SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="228509">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="{SID}">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>  
    <td class="m_tline">&nbsp;&nbsp;<?=$mnu_member?><?=$mem_setopt?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;帐号:<?=$row['Memname']?> 
      -- 会员名称:<?=$row['Alias']?> -- 盘口:<?=$row['OpenType']?> -- 使用币别:<?=$row['CurType']?> -- <?=$rep_pay_type?>: <?
	  if ($row['pay_type']==0){
	  	echo $rep_pay_type_c;
	  }else{
  	  	echo $rep_pay_type_m;
	  }
	  ?> --  <a href="./ag_members.php?uid=<?=$uid?>">回上一页</a></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">足球</th>
                 <th class="center" colspan="4">退水设定</th>
                 <th class="center" colspan="2">投注限额</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">单场</th>
                 <th class="center">单注</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
                 <td nowrap><?=$row["FT_Turn_R_A"]?></td>
                 <td nowrap><?=$row["FT_Turn_R_B"]?></td>
                 <td nowrap><?=$row["FT_Turn_R_C"]?></td>
                 <td nowrap><?=$row["FT_Turn_R_D"]?></td>
                 <td nowrap><?=$row["FT_R_Scene"]?></td>
                 <td nowrap><?=$row["FT_R_Bet"]?></td>
             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
                 <td nowrap><?=$row["FT_Turn_RE_A"]?></td>
                 <td nowrap><?=$row["FT_Turn_RE_B"]?></td>
                 <td nowrap><?=$row["FT_Turn_RE_C"]?></td>
                 <td nowrap><?=$row["FT_Turn_RE_D"]?></td>
                 <td nowrap><?=$row["FT_RE_Scene"]?></td>
                 <td nowrap><?=$row["FT_RE_Bet"]?></td>
             </tr>

             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">独赢, 滚球独赢</td>
                 <td nowrap colspan="4" ><?=$row["FT_Turn_M"]?></td>
                 <td nowrap><?=$row["FT_M_Scene"]?></td>
                 <td nowrap><?=$row["FT_M_Bet"]?></td>
             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">其他</td>
                 <td nowrap colspan="4" ><?=$row["FT_Turn_PC"]?></td>
                 <td nowrap><?=$row["FT_PC_Scene"]?></td>
                 <td nowrap><?=$row["FT_PC_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">篮球</th>
                 <th class="center" colspan="4">退水设定</th>
                 <th class="center" colspan="2">投注限额</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">单场</th>
                 <th class="center">单注</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
                 <td nowrap><?=$row["BK_Turn_R_A"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_B"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_C"]?></td>
                 <td nowrap><?=$row["BK_Turn_R_D"]?></td>
                 <td nowrap><?=$row["BK_R_Scene"]?></td>
                 <td nowrap><?=$row["BK_R_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
                 <td nowrap><?=$row["BK_Turn_RE_A"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_B"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_C"]?></td>
                 <td nowrap><?=$row["BK_Turn_RE_D"]?></td>
                 <td nowrap><?=$row["BK_RE_Scene"]?></td>
                 <td nowrap><?=$row["BK_RE_Bet"]?></td>
             </tr>

             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">其他</td>
                 <td nowrap colspan="4" ><?=$row["BK_Turn_PC"]?></td>
                 <td nowrap><?=$row["BK_PC_Scene"]?></td>
                 <td nowrap><?=$row["BK_PC_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse;width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">综合球类</th>
                 <th class="center" colspan="4">退水设定</th>
                 <th class="center" colspan="2">投注限额</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">单场</th>
                 <th class="center">单注</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
                 <td nowrap><?=$row["OP_Turn_R_A"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_B"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_C"]?></td>
                 <td nowrap><?=$row["OP_Turn_R_D"]?></td>
                 <td nowrap><?=$row["OP_R_Scene"]?></td>
                 <td nowrap><?=$row["OP_R_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
                 <td nowrap><?=$row["OP_Turn_RE_A"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_B"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_C"]?></td>
                 <td nowrap><?=$row["OP_Turn_RE_D"]?></td>
                 <td nowrap><?=$row["OP_RE_Scene"]?></td>
                 <td nowrap><?=$row["OP_RE_Bet"]?></td>

             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">独赢, 滚球独赢</td>
                 <td nowrap colspan="4" ><?=$row["OP_Turn_M"]?></td>
                 <td nowrap><?=$row["OP_M_Scene"]?></td>
                 <td nowrap><?=$row["OP_M_Bet"]?></td>
             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">其他</td>
                 <td nowrap colspan="4" ><?=$row["OP_Turn_PC"]?></td>
                 <td nowrap><?=$row["OP_PC_Scene"]?></td>
                 <td nowrap><?=$row["OP_PC_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>

 <div id="div_container" style="text-align:center;position: relative;
    margin: 0 20px;">
     <div id="my_div" class="fakeContainer first_div" style="padding:1px">
         <table border="1" id="demoTable" style="margin-top:5px;border-collapse: collapse; width: 1024px;">
             <tr id="my_tr">
                 <th class="center" rowspan="2">冠军</th>
                 <th class="center" colspan="4">退水设定</th>
                 <th class="center" colspan="2">投注限额</th>
             </tr>
             <tr>
                 <th class="center">A</th>
                 <th class="center">B</th>
                 <th class="center">C</th>
                 <th class="center">D</th>
                 <th class="center">单场</th>
                 <th class="center">单注</th>
             </tr>
             <tr  class="m_cen">
                 <td nowrap class="m_ag_ed">冠军</td>
                 <td nowrap colspan="4" ><?=$row["FS_Turn_R"]?></td>
                 <td nowrap><?=$row["FS_R_Scene"]?></td>
                 <td nowrap><?=$row["FS_R_Bet"]?></td>
             </tr>
         </table>
     </div>
 </div>
<table id="FT_Coor" width="540" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td rowspan="2" width="140">足球 </td>
    <td align="center" width="100">退水设定</td>
    <td id ="FT_MY_col" colspan="2" >投注限额</td>
	<!--td colspan="4">投注限额</td-->
	<td rowspan="2" width="50" >功能</td>

  </tr>
   <tr class="m_title_edit" align="center">
    <td width="100"><?=$row['OpenType']?></td>
	<td width="125">单场</td>
    <td width="125">单注</td>
  </tr>
  <tr  class="m_cen">
    <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
    <td nowrap><?=$row['FT_Turn_R']?></td>
	<td nowrap><?=$row['FT_R_Scene']?></td>
	<td nowrap><?=$row['FT_R_Bet']?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','R','<?=$row['FT_R_Scene']?>','<?=$row['FT_R_Bet']?>',<?=$row['FT_Turn_R']?>,0.25,<?=$r_turn?>,'FT');"> 修改</a></td>
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
    <td nowrap><?=$row['FT_Turn_RE']?></td>
	<td nowrap><?=$row['FT_RE_Scene']?></td>
	<td nowrap><?=$row['FT_RE_Bet']?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','RE','<?=$row['FT_RE_Scene']?>','<?=$row['FT_RE_Bet']?>',<?=$row['FT_Turn_RE']?>,0.25,<?=$re_turn?>,'FT');"> 修改</a></td>

  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">独赢, 滚球独赢</td>
    <td nowrap><?=$row['FT_Turn_M']?></td>
	<td nowrap><?=$row['FT_M_Scene']?></td>
	<td nowrap><?=$row['FT_M_Bet']?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','M','<?=$row['FT_M_Scene']?>','<?=$row['FT_M_Bet']?>',<?=$row['FT_Turn_M']?>,1,<?=$ag_row['FT_Turn_M']?>,'FT');"> 修改</a></td>
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">其他</td>
    <td nowrap><?=$row['FT_Turn_PC']?></td>
	<td nowrap><?=$row['FT_PC_Scene']?></td>
	<td nowrap><?=$row['FT_PC_Bet']?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','PC','<?=$row['FT_PC_Scene']?>','<?=$row['FT_PC_Bet']?>',<?=$row['FT_Turn_PC']?>,1,<?=$ag_row['FT_Turn_PC']?>,'FT');"> 修改</a></td>
  </tr>
</table>
<BR>

<table id="BK_Coor" width="540" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td rowspan="2" width="140">篮球 </td>
    <td align="center" width="100">退水设定</td>
    <td id ="BK_MY_col" colspan="2" >投注限额</td>
	<!--td colspan="4">投注限额</td-->
	<td rowspan="2" width="50" >功能</td>

  </tr>
   <tr class="m_title_edit">
    <td width="100"><?=$row['OpenType']?></td>
	<td width="125">单场</td>
    <td width="125">单注</td>
  </tr>
  <tr  class="m_cen">
    <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
    <td nowrap><?=$row['BK_Turn_R']?></td>
	<td nowrap><?=$row['BK_R_Scene']?></td>
	<td nowrap><?=$row['BK_R_Bet']?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','R','<?=$row['BK_R_Scene']?>','<?=$row['BK_R_Bet']?>',<?=$row['BK_Turn_R']?>,0.25,<?=$bk_r_turn?>,'BK');"> 修改</a></td>
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
    <td nowrap><?=$row['BK_Turn_RE']?></td>
	<td nowrap><?=$row['BK_RE_Scene']?></td>
	<td nowrap><?=$row['BK_RE_Bet']?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','RE','<?=$row['BK_RE_Scene']?>','<?=$row['BK_RE_Bet']?>',<?=$row['BK_Turn_RE']?>,0.25,<?=$bk_re_turn?>,'BK');"> 修改</a></td>
  
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">其他</td>
    <td nowrap><?=$row['BK_Turn_PC']?></td>
	<td nowrap><?=$row['BK_PC_Scene']?></td>
	<td nowrap><?=$row['BK_PC_Bet']?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','PC','<?=$row['BK_PC_Scene']?>','<?=$row['BK_PC_Bet']?>',<?=$row['BK_Turn_PC']?>,1,<?=$ag_row['BK_Turn_PC']?>,'BK');"> 修改</a></td>
  </tr>
</table>
<BR>

<table id="OP_Coor" width="540" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td rowspan="2" width="140">综合球类</td>
    <td align="center" width="100">退水设定</td>
    <td id ="OP_MY_col" colspan="2" >投注限额</td>
	<!--td colspan="4">投注限额</td-->
	<td rowspan="2" width="50" >功能</td>

  </tr>
   <tr class="m_title_edit">
    <td width="100"><?=$row['OpenType']?></td>
	<td width="125">单场</td>
    <td width="125">单注</td>
  </tr>
  <tr  class="m_cen">
    <td nowrap align="right" class="m_ag_ed">让球, 大小, 单双</td>
    <td nowrap><?=$row['OP_Turn_R']+0?></td>
	<td nowrap><?=$row['OP_R_Scene']+0?></td>
	<td nowrap><?=$row['OP_R_Bet']+0?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','R','<?=$row['OP_R_Scene']+0?>','<?=$row['OP_R_Bet']+0?>',<?=$row['OP_Turn_R']+0?>,0.25,<?=$op_r_turn?>,'OP');"> 修改</a></td>
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">滚球让球, 滚球大小</td>
    <td nowrap><?=$row['OP_Turn_RE']+0?></td>
	<td nowrap><?=$row['OP_RE_Scene']+0?></td>
	<td nowrap><?=$row['OP_RE_Bet']+0?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','RE','<?=$row['OP_RE_Scene']+0?>','<?=$row['OP_RE_Bet']+0?>',<?=$row['OP_Turn_RE']+0?>,0.25,<?=$op_re_turn?>,'OP');"> 修改</a></td>
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">独赢, 滚球独赢</td>
    <td nowrap><?=$row['OP_Turn_M']+0?></td>
	<td nowrap><?=$row['OP_M_Scene']+0?></td>
	<td nowrap><?=$row['OP_M_Bet']+0?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','M','<?=$row['OP_M_Scene']+0?>','<?=$row['OP_M_Bet']+0?>',<?=$row['OP_Turn_M']+0?>,1,<?=$ag_row['OP_Turn_M']+0?>,'OP');"> 修改</a></td>
  </tr>
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">其他</td>
    <td nowrap><?=$row['OP_Turn_PC']+0?></td>
	<td nowrap><?=$row['OP_PC_Scene']+0?></td>
	<td nowrap><?=$row['OP_PC_Bet']+0?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','PC','<?=$row['OP_PC_Scene']+0?>','<?=$row['OP_PC_Bet']+0?>',<?=$row['OP_Turn_PC']+0?>,1,<?=$ag_row['OP_Turn_PC']+0?>,'OP');"> 修改</a></td>
  </tr>
</table>
<BR>

<table id="FS_Coor" width="540" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td rowspan="2" width="140">冠军</td>
    <td align="center" width="100">退水设定</td>
    <td id ="FS_MY_col" colspan="2" >投注限额</td>
	<!--td colspan="4">投注限额</td-->
	<td rowspan="2" width="50" >功能</td>

  </tr>
   <tr class="m_title_edit">
    <td width="100"><?=$row['OpenType']?></td>
	<td width="125">单场</td>
    <td width="125">单注</td>
  </tr>			
  <tr  class="m_cen">
    <td nowrap class="m_ag_ed">冠军</td>
    <td nowrap><?=$row['FS_Turn_R']?></td>
	<td nowrap><?=$row['FS_R_Scene']?></td>
	<td nowrap><?=$row['FS_R_Bet']?></td>
	<td ><a href="javascript:void(0)" onClick="show_win('','R','<?=$row['FS_R_Scene']?>','<?=$row['FS_R_Bet']?>',<?=$row['FS_Turn_R']?>,1,<?=$ag_row['FS_Turn_R']?>,'FS');"> 修改</a></td>
  </tr>

</table>

<!----------------------修改视窗2---------------------------->
<div id=rs_window style="display: none;position:absolute">
	<form name=rs_form action="" method="POST" onSubmit="return Chk_acc();">
		<input type="hidden" name="act" value="N">
		<input type="hidden" name="mid" value="<?=$mid?>">
		<input type="hidden" name="agents_id" value="<?=$aid?>">
		<input type="hidden" name="pay_type" value="<?=$pay_type?>">
		<input type="hidden" name="currency" value="RMB">
		<input type="hidden" name="ratio" value="1">
		<input type="hidden" name="rtype" value="">
		<input type="hidden" name="kind" value="">
		 
		<table width="320" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
		  <tr>
			<td bgcolor="#FFFFFF">
					<table width="320" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix"  bgcolor="A4C0CE">
					  <tr bgcolor="0163A2">
				  <td colspan="2" width="310" id=r_title><font color="#FFFFFF">请输入足球”让球, 大小, 单双”的设定。</font></td>
				  <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
				</tr>
				<tr bgcolor="#000000">
				  <td colspan="3" height="1"></td>
				</tr>
				<tr>
				  <td  bgcolor="#FFFF00" height="10" colspan="3">您所输入的数值是个别玩法的设定。</td>
				  </tr>
				<tr>
				  <td colspan="3">退水设定&nbsp;&nbsp;<select class="za_select" name="war_set"></select></td>
				</tr>
				<tr bgcolor="#000000">
				  <td colspan="3" height="1"></td>
				</tr>
				<tr>
				  <td>单场限额&nbsp;&nbsp;<input type=TEXT id="SC" name="SC" value="" size=8 maxlength=8 class="za_text" onKeyUp="count_so();" onKeyPress="return CheckKey()"></td>
				  <td align="left" nowrap width="100">&nbsp;&nbsp;最大值:<a href="javascript:void(0)" id = "SC_pro"  style="text-decoration: underline; color:#0000FF;" onClick="putToText('SC');" ></a><!--&nbsp;&nbsp;人民币:<font color="#FF0033" id="mcy_sc">0</font--></td>
				  <td>&nbsp;</td>
				</tr>
				<tr bgcolor="#000000">
				  <td colspan="3" height="1"></td>
				</tr>
				<tr>
				  <td >单注限额&nbsp;&nbsp;<input type=TEXT id="SO" name="SO" value="" size=8 maxlength=8 class="za_text"  onKeyPress="return CheckKey()"></td>
				  <td align="left" nowrap>&nbsp;&nbsp;最大值:<a href="javascript:void(0)" id = "SO_pro"  style="text-decoration: underline; color:#0000FF;" onClick="putToText('SO');" ></a><!--&nbsp;&nbsp;人民币:<font color="#FF0033" id="mcy_so">0</font--></td>
				  <td>&nbsp;</td>
				</tr>
				<tr bgcolor="#000000">
				  <td colspan="3" height="1"></td>
				</tr>
				<tr>

				  <td colspan="3" align="center">
						  <input type=submit name=rs_ok value="确定" class="za_button">						</td>
				</tr>
			  </table>
			</td>
		  </tr>
		</table>
	</form>
</div>
<!----------------------修改视窗2---------------------------->
</body>
</html>

