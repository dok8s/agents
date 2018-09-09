<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
require ("../../../member/include/traditional.zh-cn.inc.php");

$report_kind = $_REQUEST['report_kind'];
$pay_type    = $_REQUEST['pay_type'];
$wtype       = $_REQUEST['wtype'];
$date_start  = $_REQUEST['date_start'];
$date_end    = $_REQUEST['date_end'];
$gtype       = $_REQUEST['gtype'];
$cid         = $_REQUEST['cid'];
$aid         = $_REQUEST['aid'];
$sid         = $_REQUEST['sid'];
$mid         = $_REQUEST['mid'];
$uid         = $_REQUEST['uid'];
$result_type = $_REQUEST['result_type'];

$date_start	=	cdate($date_start);
$date_end		=	cdate($date_end);
switch ($pay_type){
case "0":
	$credit="block";
	$sgold="block";
	break;
case "1":
	$credit="block";
	$sgold="block";
	break;
case "":
	$credit="block";
	$sgold="block";
	break;
}

if($uid==""){
	//echo "<script>window.open('$site/index.php','_top')</script>";
	//exit;
}
$sql = "select super,Agname,ID,language,subname,subuser,world,corprator from web_world where Oid='$uid'";
$$result = mysql_query($sql);
$cou=mysql_num_rows($result);

if($cou==0 ){
	//echo "<script>window.open('$site/index.php','_top')</script>";
	//exit;
}

$user = $row = mysql_fetch_array($result);

if ($result_type=='Y'){
	$QQ526738='<font color=green>有结果</font>';
}else{
	$QQ526738='<font color=green>无结果</font>';
}

if ($row['subuser']==1){
	$agname=$row['subname'];
	$loginfo=$agname.'子帐号:'.$row['subuser'].'查询期间'.$date_start.'至'.$date_end.$QQ526738.'报表';
}else{
	$agname=$row['Agname'];
	$loginfo='代理商:'.$row['Agname'].'查询期间'.$date_start.'至'.$date_end.$QQ526738.'报表';
}

$agid=$row['ID'];
$super=$row['super'];
$corprator=$row['corprator'];
$world=$row['world'];
$where=get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end,$row['subuser']);

$sql="select agents as name,count(*) as coun,sum(betscore) as score,sum(m_result) as result,sum(a_result) as a_result,sum(result_a) as result_a,sum(vgold) as vgold,round(agent_point*0.01,2) as agent_point from web_db_io where ".$where." and super='$super' and Agents='$agname'";
?>
<script>
if(self == top) {
	//location='/';
}
</script>

<html>
<head>
<title>reports_all</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_reall {  background-color: #687780; text-align: center; color: #FFFFFF}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT language=javaScript src="/js/report_func.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript src="/js/report_super_agent.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript src="/js/FlashContent.js" type=text/javascript></SCRIPT>
<script>
function init(){
	callas(getCommand("report"));
}
</script>
 <link href="/style/control/report_new.css" rel="stylesheet" type="text/css">
 <link href="/style/control/common_style.css" rel="stylesheet" type="text/css">
 <link href="/style/control/reset.css" rel="stylesheet" type="text/css">
</head>
<?php if(!isset($_GET['test'])):?>
 <body>
			<div id="report_contain" class="reportNew" name="MaxTag" src="/js/w_report.js" linkage="w_report_suagent" extends="base_report">
				<div id="base_report" class="" name="MaxTag" src="/js/base/base_report.js" linkage="base_report"></div>
				<div id="fastTemplate_ag" name="MaxTag" src="/js/lib/fastTemplate_ag.js" linkage="fastTemplate_ag"></div>
				<div id="report_data_div" class="reportHead">
					<ul>
						<li id="result_name" class="reportTitle">有结果</li>
						<li id="settle_btn" class="modeBtn">交收</li>
						<li id="valid_btn" class="modeBtn now">有效金额</li>
						<li class="rightBtn">
							<span id="mainBtn" class="mainBtn" style="">
								<a id="back_main" href="report.php?uid=<?=$uid ?>">主页</a>
								<i style="display:none" =""=""></i><a id="layer0" style="display:none" =""="" data-history="&amp;php_name=report_suagent.php"></a>
								<i style="display:none" =""=""></i><a id="layer1" style="display:none" =""="" data-history="&amp;php_name=report_agent.php"></a>
							</span>
							<i id="burger_btn" class="burgerBtn"></i>
							<div id="burger_menu" class="burgerMenu" style="display: none;">
								<div>
									<i class="iconTop"></i>
									<ul>
										<li id="download_excel_btn" class="LIexcel"><tt>导出Excel</tt><i class="iconExcel"></i></li>
									</ul>
								</div>
							</div>
							
						</li>
					</ul>
					
					
				</div>
				<div id="filters" class="showFilters">
					<ul>
						<!--<li id="filters_closs_btn" class="btnxClose"></li>-->
						<li class="liSelect">
							<span class="itemSelect">球类</span>
							<div class="nowSelect">
								<div id="sub_gtype" name="MaxTag" src="/js/ClassSelect_ag.js" linkage="ClassSelect_ag" class="">
					                <span id="nowText" class="nowChoose">所有球类</span>
					                <i class="searchArrow" style="display: none;"></i>
					                <div id="showDiv" class="DIVSelect" style="display: none;">
					                    <ul id="divUl" class="">
					                      <li id="value_" class="_selected">所有球类</li>
					                      <li id="value_FT" class="">足球</li>
					                      <li id="value_BK" class="">篮球 / 美式足球</li>
					                      <li id="value_TN" class="">网球</li>
					                      <li id="value_VB" class="">排球</li>
					                      <li id="value_BS" class="">棒球</li>
					                      <li id="value_OP" class="">其他</li>
					                      <li id="value_FS" class="">冠军</li>
					                      <li id="value_BM" class="">羽毛球</li>
					                      <li id="value_TT" class="">乒乓球</li>
					                      <li id="value_SK" class="">斯诺克/台球</li>
					                    </ul>
					                </div>
		            			</div>
							</div>
						</li>
						<li class="liSelect">
							<span class="itemSelect">从<?=$date_start?> </span>
							<div class="dateSelect">
							  <div id="sub_date_start" name="MaxTag" src="/js/calendar_ag.js" linkage="calendar_ag">
									<input id="date_input" type="text" value="" disabled="">
									<span id="date_photo" class="searchArrow" style="display: none;"></span>
								</div>
							</div>
						</li>
						<li class="liSelect">
							<span class="itemSelect">至<?=$date_end?></span>
							<div class="dateSelect">
							  <div id="sub_date_end" name="MaxTag" src="/js/calendar_ag.js" linkage="calendar_ag">
									<input id="date_input" type="text" value="" disabled="">
									<span id="date_photo" class="searchArrow" style="display: none;"></span>
								</div>
							</div>
						</li>
						<li class="liSelect">
							<span class="itemSelect">玩法</span>
							<label class="nowSelect nowSelectType">
								<div id="sub_wtype" name="MaxTag" src="/js/ClassSelect_ag_click.js" linkage="ClassSelect_ag_click" class="">
								<span id="nowText" class="nowChoose">所有玩法</span>
								<i class="searchArrow" style="display: none;"></i>
									<div id="showDiv" class="DIVSelect" style="display: none;">
										<ul id="divUl" class="">
											<li id="value_" class="_selected">所有玩法</li>
											<li id="value_R" class="">让球(分)</li>
											<li id="value_RE" class="">滚球</li>
											<li id="value_P" class="">综合过关</li>
											<li id="value_OU" class="">大小</li>
											<li id="value_ROU" class="">滚球大小</li>
											<li id="value_PD" class="">波胆(最后一位数)</li>
											<li id="value_RPD" class="">滚球波胆(最后一位数)</li>
											<li id="value_PD3" class="">波胆(3 set)</li>
											<li id="value_RPD3" class="">滚球波胆(3 set)</li>
											
										</ul>
									</div>
								</div>
							</label>
						</li>
	
						<li class="liSelect liSubmit">
							<span id="show_filters_btn" class="btnSubmit">更改</span>

							<span id="filters_closs_btn" class="btnCancle" style="display:none">取消</span>
							<span id="sub_submit" class="btnSubmit" style="display:none">提交</span>
						</li>
					</ul>
				</div>
				<div id="sub_message" style="display:none" class="subMessage"><i></i><tt>您的子帐号已被选择观看部分的帐号，帐目只显示 <span id="sub_num">10</span> / <span id="total_num">500</span> 个帐号</tt></div>
				<div id="report_data_show" class="reportCont">
					<?php
    					$mysql = $sql." and pay_type=0 group by agents order by name asc";
    					$result = mysql_query($mysql);
    					$cou=mysql_num_rows($result);
    					if ($cou==0){
    					    $credit='none';
    					} 
                  	?>
					<table id="report_data_table" class="reportTable vAG">
						<tbody id="report_data_tbody">
							<tr>
								<th class="TDCode TDpaddingLeft"><span data-sort="NAME0"><tt>代理帐号</tt><i class="iconUp"></i></span></th>
								<th class="TDName"><span data-sort="ALIAS0"><tt>名称</tt><i class="iconDown"></i></span></th>
								<th class="TDWagers"><span data-sort="WCOUNT0"><tt>笔数</tt><i class="iconDown"></i></span></th>
								<th class="TDStake"><span data-sort="GOLD0"><tt>下注金额</tt><i class="iconDown"></i></span></th>
								<th class="TDValid"><span data-sort="VGOLD0"><tt>有效金额</tt><i class="iconDown"></i></span></th>
								<th class="TDMem"><span data-sort="WINGOLD0"><tt>会员</tt><i class="iconDown"></i></span></th>
								<th class="TDMemCur"><span data-sort="RESULT_D0"><tt>代理商币值</tt><i class="iconDown"></i></span></th>
								<th class="TDicon TDpaddingRight"></th>
							</tr>
							<?php if($cou):?>
    							<?php 
        							while ($row = mysql_fetch_array($result)){
        							    $c_score+=$row['score'];
        							    $c_num+=$row['coun'];
        							    $c_m_result+=$row['result'];
        							    $c_vscore+=$row['vgold'];
        							    $c_a_result+=$row['a_result'];
        							    $c_result_a+=$row['result_a'];
        							    $c_vgold+=(1-$row['agent_point'])*$row['vgold'];
    							?>
    								<!-- START DYNAMIC BLOCK: row0 -->
        							<tr id="listTr*LIST_NUM0*" class="TRuser" style="display:none" =""="">
        								<td class="TDCode TDpaddingLeft"><span data-url="*ACTION0*"><?=$user['Agname']?></span></td>
        								<td class="TDName"><?=$row['name']?></td>
        								<td class="TDWagers"><?=$row['coun']?></td>
        								<td class="TDStake"><A href="report_agent.php?uid=<?=$uid?>&result_type=<?=$result_type?>&aid=<?=$row['name']?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=mynumberformat($row['score'],1)?></a></td>
        								<td class="TDValid"><?=mynumberformat($row['vgold'],1)?></td>
        								<td class="TDMem"><?=mynumberformat($row['result'],1)?></td>
        								<td class="TDMemCur"><?=mynumberformat($row['result_a'],1)?></td>
        								<td id="list_icon_td" class="TDicon TDpaddingRight"><div id="list_icon_div" *detial_display0*=""><i id="infoBtn" class="infoBtn" data-winloss="{id_type:&#39;sid&#39;,sid:&#39;*SID0*&#39;,aid:&#39;*AID0*&#39;}"></i></div></td>
        							</tr>
        							<!-- END DYNAMIC BLOCK: row0 -->
    							<?php 
        							}
    							?>
							
							<tr class="TRtotal" style="display:none" =""="">
								<td class="TDCode TDpaddingLeft">总计</td>
								<td class="TDName"></td>
								<td class="TDWagers"><?=$c_num?></td>
								<td class="TDStake"><?=mynumberformat($c_vscore, 1)?></td>
								<td class="TDValid"><?=mynumberformat($c_m_result,1)?></td>
								<td class="TDMem"></td>
								<td class="TDMemCur"><?=mynumberformat($c_result_a,1)?></td>
								<td class="TDicon TDpaddingRight"></td>
							</tr>
						<?php else:?>
						  <tr class="TRnodata" =""="">
						  	<td colspan="8">查无任何资料</td>
						  </tr>
						<?php endif;?>
						  <tr class="TRnodata" style="display:none" =""="">
						  	<td colspan="8">此功能暂停服务,请稍候..</td>
						  </tr>
						</tbody>
					</table>
				</div>
				
				<div id="report_data_show_valid" class="reportCont" style="display: none;">
					<table id="report_data_table" class="reportTable vAG">
						<tbody id="report_data_tbody">
							<!-- START DYNAMIC BLOCK: title -->
							<tr>
								<th class="TDCode TDpaddingLeft"><span data-sort="NAME0"><tt>代理帐号</tt><i class="iconUp"></i></span></th>
								<th class="TDName"><span data-sort="ALIAS0"><tt>名称</tt><i class="iconDown"></i></span></th>
								<th class="TDWagers"><span data-sort="WCOUNT0"><tt>笔数</tt><i class="iconDown"></i></span></th>
								<th class="TDStake"><span data-sort="GOLD0"><tt>下注金额</tt><i class="iconDown"></i></span></th>
								<th class="TDValid"><span data-sort="VGOLD0"><tt>有效金额</tt><i class="iconDown"></i></span></th>
								<th class="TDMem"><span data-sort="WINGOLD0"><tt>会员</tt><i class="iconDown"></i></span></th>
								<th class="TDMemCur"><span data-sort="RESULT_D0"><tt>代理商币值</tt><i class="iconDown"></i></span></th>
								<th class="TDicon TDpaddingRight"></th>
							</tr>
							<!-- END DYNAMIC BLOCK: title -->
							<!-- START DYNAMIC BLOCK: total -->
							<tr class="TRtotal" *list_credit*="">
								<td class="TDCode TDpaddingLeft">总计</td>
								<td class="TDName"></td>
								<td class="TDWagers">*WCOUNT0*</td>
								<td class="TDStake">*GOLD0*</td>
								<td class="TDValid">*VGOLD0*</td>
								<td class="TDMem">*WINGOLD0*</td>
								<td class="TDMemCur">*RESULT_D0*</td>
								<td class="TDicon TDpaddingRight"></td>
							</tr>
							<!-- END DYNAMIC BLOCK: total -->
							<!-- START DYNAMIC BLOCK: row0 -->
							<tr id="listTr*LIST_NUM0*" class="TRuser" *list_credit*="">
								<td class="TDCode TDpaddingLeft"><span data-url="*ACTION0*">*NAME0*</span></td>
								<td class="TDName">*ALIAS0*</td>
								<td class="TDWagers">*WCOUNT0*</td>
								<td class="TDStake">*GOLD0*</td>
								<td class="TDValid">*VGOLD0*</td>
								<td class="TDMem">*WINGOLD0*</td>
								<td class="TDMemCur">*RESULT_D0*</td>
								<td id="list_icon_td" class="TDicon TDpaddingRight"><div id="list_icon_div" *detial_display0*=""><i id="infoBtn" class="infoBtn" data-winloss="{id_type:&#39;sid&#39;,sid:&#39;*SID0*&#39;,aid:&#39;*AID0*&#39;}"></i></div></td>
							</tr>
							<!-- END DYNAMIC BLOCK: row0 -->
						  <tr class="TRnodata" *list_nodata*="">
						  	<td colspan="8">查无任何资料</td>
						  </tr>
						  <tr class="TRnodata" *list_closedata*="">
						  	<td colspan="8">此功能暂停服务,请稍候..</td>
						  </tr>
						</tbody>
					</table>
				</div>
				
				<div id="report_data_show_settle" class="reportCont" style="display: none;">
					<table id="report_data_table" class="reportTable AG">
						<tbody id="report_data_tbody">
							<!-- START DYNAMIC BLOCK: title -->
							<tr>
								<th class="TDCode TDpaddingLeft"><span data-sort="NAME0"><tt>代理帐号</tt><i class="iconUp"></i></span></th>
								<th class="TDName"><span data-sort="ALIAS0"><tt>名称</tt><i class="iconDown"></i></span></th>
								<th class="TDAGent"><span data-sort="AWINGOLD0"><tt>代理商</tt><i class="iconDown"></i></span></th>
								<th class="TDAGposs"><span data-sort="AWINLOSS0"><tt>代理商成数</tt><i class="iconDown"></i></span></th>
								<th class="TDAGrusult"><span data-sort="ARESULT0"><tt>代理商结果</tt><i class="iconDown"></i></span></th>
								<th class="TDAGstock"><span data-sort="SGOLD0"><tt>代理商实货量</tt><i class="iconDown"></i></span></th>
								<th class="TDMAposs" *cosu_enable*=""><span data-sort="SWINLOSS0"><tt>总代理成数</tt><i class="iconDown"></i></span></th>
								<th class="TDMArusult TDpaddingRight" *cosu_enable*=""><span data-sort="SRESULT0"><tt>总代理结果</tt><i class="iconDown"></i></span></th>
							</tr>
							<BR>
                            <?php
                            if ($sgold=='block'){
                            	$mysql=$sql." and pay_type=1 group by agents order by name asc";
                            	$result = mysql_query($mysql);
                            	$cou=mysql_num_rows($result);
                            	if ($cou==0){
                            		$sgold='none';
                            	}
                            }else{
                            	$sgold='block';
                            }
                            ?>
                            <?php if($cou):?>
							
							<?php
                        	while ($row = mysql_fetch_array($result)){
                        		$c_score1+=$row['score'];
                        		$c_num1+=$row['coun'];
                        		$c_m_result1+=$row['result'];
                        		$c_vscore1+=$row['vgold'];
                        		$c_a_result1+=$row['a_result'];
                        		$c_result_a1+=$row['result_a'];
                        		$c_vgold1+=(1-$row['agent_point'])*$row['vgold'];
                          	?>
                          		<!-- START DYNAMIC BLOCK: row0 -->
    							<tr id="listTr*LIST_NUM0*" class="TRuser" *list_credit*="">
    								<td class="TDCode TDpaddingLeft"><span data-url="*ACTION0*"><?=$user['Agname']?></span></td>
    								<td class="TDName"><?=$row['name']?></td>
    								<td class="TDAGent"><?=mynumberformat($row['a_result'],1)?></td>
    								<td class="TDAGposs"><?=$row['agent_point']?></td>
    								<td class="TDAGrusult"><?=mynumberformat($row['result_a'],1)?></td>
    								<td class="TDAGstock"><?=mynumberformat((1-$row['agent_point'])*$row['vgold'],1)?></td>
    								<td class="TDMAposs" *cosu_enable*=""><?=mynumberformat($row['result_a'],1)?></td>
    								<td class="TDMArusult TDpaddingRight" *cosu_enable*="">*SRESULT0*</td>
    							</tr>
    							<!-- END DYNAMIC BLOCK: row0 -->
                          	<?php }?>
                        							<!-- END DYNAMIC BLOCK: title -->
							<!-- START DYNAMIC BLOCK: total -->
							<tr class="TRtotal" *list_credit*="">
								<td class="TDCode TDpaddingLeft">总计</td>
								<td class="TDName"></td>
								<td class="TDAGent"><?=$c_a_result1 ?></td>
								<td class="TDAGposs"></td>
								<td class="TDAGrusult"><?=$c_result_a1 ?></td>
								<td class="TDAGstock"><?=mynumberformat($c_vgold1,1)?></td>
								<td class="TDMAposs" *cosu_enable*=""></td>
								<td class="TDMArusult TDpaddingRight" *cosu_enable*=""><?=mynumberformat($c_result_a1,1)?></td>
							</tr>
							<!-- END DYNAMIC BLOCK: total -->
						  <?php else:?>	
						  <tr class="TRnodata" *list_nodata*="">
						  	<td colspan="8">查无任何资料</td>
						  </tr>
						  <?php endif;?>
						  <tr class="TRnodata"  *list_closedata*="" style="display:none">
						  	<td colspan="8">此功能暂停服务,请稍候..</td>
						  </tr>
						</tbody>
					</table>
				</div>
				<div id="winloss_show" class="add_super_container" onresize="setDivSize(this,1);" style="display: none; width: 100%;"></div>
				
				<div id="edit_time_container" style="display:none;">
					<div id="edit_time_box" class="infoBox">
						<div>
							<i class="iconTop"></i>
							<ul>
								<i id="btnxClose" class="btnxClose"></i>
								<!-- START DYNAMIC BLOCK: INFO -->
								<li>
									<span>新占成 *WINLOSS*</span>
									<tt>更新时间</tt><tt>*DATE* *TIME*</tt>
								</li>
								<!-- END DYNAMIC BLOCK: INFO -->
							</ul>
						</div>
					</div>
				</div>
				
				<div id="tipsMask" class="tipsMask" style="display: none;">
					<div class="blackMask"></div>
					<div class="reportHead">
						<ul>
							<li class="modeBtn now">交收</li>
							<li class="modeBtn">有效金额</li>
						</ul>
					</div>
					<div class="DIVtips">
						<div>
							<i class="iconTop"></i>
							<ul>
								<li class="tipsText">切换项目查看更多资料</li>
								<li id="tipsMask_close_btn" class="btnxClose"></li>
							</ul>
						</div>
					</div>
				</div>
			<div name="fank_calander_element" class="cal_div" style="position: absolute; display: none;">
			<div name="fank_calander_element" class="cal_YearContain"><span name="fank_calander_element" class="cal_previous"></span>
				<label name="fank_calander_element" class="cal_month_label"><select name="fank_calander_element" class="cal_month"><option value="0">一月</option><option value="1">二月</option><option value="2">三月</option><option value="3">四月</option><option value="4">五月</option><option value="5">六月</option><option value="6">七月</option><option value="7">八月</option><option value="8">九月</option><option value="9">十月</option><option value="10">十一月</option><option value="11">十二月</option></select></label><label name="fank_calander_element" class="cal_year_label"><select name="fank_calander_element" class="cal_year"><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option><option value="2031">2031</option><option value="2032">2032</option><option value="2033">2033</option><option value="2034">2034</option><option value="2035">2035</option><option value="2036">2036</option><option value="2037">2037</option><option value="2038">2038</option></select></label><span name="fank_calander_element" class="cal_next"></span></div><div name="fank_calander_element"><span name="fank_calander_element" class="cal_week_left">日</span><span name="fank_calander_element" class="cal_week">一</span><span name="fank_calander_element" class="cal_week">二</span><span name="fank_calander_element" class="cal_week">三</span><span name="fank_calander_element" class="cal_week">四</span><span name="fank_calander_element" class="cal_week">五</span><span name="fank_calander_element" class="cal_week">六</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date ">1</span><span name="fank_calander_element" class="cal_date ">2</span><span name="fank_calander_element" class="cal_date ">3</span><span name="fank_calander_element" class="cal_date ">4</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">5</span><span name="fank_calander_element" class="cal_date ">6</span><span name="fank_calander_element" class="cal_date ">7</span><span name="fank_calander_element" class="cal_date cal_goal">8</span><span name="fank_calander_element" class="cal_date ">9</span><span name="fank_calander_element" class="cal_date ">10</span><span name="fank_calander_element" class="cal_date ">11</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">12</span><span name="fank_calander_element" class="cal_date ">13</span><span name="fank_calander_element" class="cal_date ">14</span><span name="fank_calander_element" class="cal_date ">15</span><span name="fank_calander_element" class="cal_date ">16</span><span name="fank_calander_element" class="cal_date ">17</span><span name="fank_calander_element" class="cal_date ">18</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">19</span><span name="fank_calander_element" class="cal_date ">20</span><span name="fank_calander_element" class="cal_date ">21</span><span name="fank_calander_element" class="cal_date ">22</span><span name="fank_calander_element" class="cal_date ">23</span><span name="fank_calander_element" class="cal_date ">24</span><span name="fank_calander_element" class="cal_date ">25</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">26</span><span name="fank_calander_element" class="cal_date ">27</span><span name="fank_calander_element" class="cal_date ">28</span><span name="fank_calander_element" class="cal_date ">29</span><span name="fank_calander_element" class="cal_date ">30</span><span name="fank_calander_element" class="cal_date ">31</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span></div></div><div name="fank_calander_element" class="cal_div" style="position: absolute; display: none;"><div name="fank_calander_element" class="cal_YearContain"><span name="fank_calander_element" class="cal_previous"></span><label name="fank_calander_element" class="cal_month_label"><select name="fank_calander_element" class="cal_month"><option value="0">一月</option><option value="1">二月</option><option value="2">三月</option><option value="3">四月</option><option value="4">五月</option><option value="5">六月</option><option value="6">七月</option><option value="7">八月</option><option value="8">九月</option><option value="9">十月</option><option value="10">十一月</option><option value="11">十二月</option></select></label><label name="fank_calander_element" class="cal_year_label"><select name="fank_calander_element" class="cal_year"><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option><option value="2031">2031</option><option value="2032">2032</option><option value="2033">2033</option><option value="2034">2034</option><option value="2035">2035</option><option value="2036">2036</option><option value="2037">2037</option><option value="2038">2038</option></select></label><span name="fank_calander_element" class="cal_next"></span></div><div name="fank_calander_element"><span name="fank_calander_element" class="cal_week_left">日</span><span name="fank_calander_element" class="cal_week">一</span><span name="fank_calander_element" class="cal_week">二</span><span name="fank_calander_element" class="cal_week">三</span><span name="fank_calander_element" class="cal_week">四</span><span name="fank_calander_element" class="cal_week">五</span><span name="fank_calander_element" class="cal_week">六</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date ">1</span><span name="fank_calander_element" class="cal_date ">2</span><span name="fank_calander_element" class="cal_date ">3</span><span name="fank_calander_element" class="cal_date ">4</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">5</span><span name="fank_calander_element" class="cal_date ">6</span><span name="fank_calander_element" class="cal_date ">7</span><span name="fank_calander_element" class="cal_date cal_goal">8</span><span name="fank_calander_element" class="cal_date ">9</span><span name="fank_calander_element" class="cal_date ">10</span><span name="fank_calander_element" class="cal_date ">11</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">12</span><span name="fank_calander_element" class="cal_date ">13</span><span name="fank_calander_element" class="cal_date ">14</span><span name="fank_calander_element" class="cal_date ">15</span><span name="fank_calander_element" class="cal_date ">16</span><span name="fank_calander_element" class="cal_date ">17</span><span name="fank_calander_element" class="cal_date ">18</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">19</span><span name="fank_calander_element" class="cal_date ">20</span><span name="fank_calander_element" class="cal_date ">21</span><span name="fank_calander_element" class="cal_date ">22</span><span name="fank_calander_element" class="cal_date ">23</span><span name="fank_calander_element" class="cal_date ">24</span><span name="fank_calander_element" class="cal_date ">25</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">26</span><span name="fank_calander_element" class="cal_date ">27</span><span name="fank_calander_element" class="cal_date ">28</span><span name="fank_calander_element" class="cal_date ">29</span><span name="fank_calander_element" class="cal_date ">30</span><span name="fank_calander_element" class="cal_date ">31</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span></div></div></div>

<?php else:?>


<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="init();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="" width="750">&nbsp;&nbsp;<?=$rag_date?>:<?=$date_start?>~<?=$date_end?>
      -- <?=$rep_kind?>:<?=$rep_kind_a?> -- <?=$rep_pay_type?>:<?=$rep_pay?> -- <?=$rep_wtype?>:<?=$type_caption?> -- <?=$rag_type?> -- <a href="javascript:history.go( -1 );">回上一页</a></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
if ($credit=='block'){
	$mysql=$sql." and pay_type=0 group by agents order by name asc";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$credit='none';
	}
}else{
	$credit='none';
}
?>
<!-----------------↓ 信用额度资料区段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: <?=$credit?>" width="880">
  <tr class="m_title_reall" >
    <td colspan="10">信用额度</td>
  </tr>
  <tr class="m_title_reall" >
    <td width="50"  >名称</td>
    <td width="80"  >笔数</td>
    <td width="110"  >下注金额</td>
    <td width="110"  >有效金额</td>
    <td width="90"  >会员</td>
    <td width="90"  >代理商</td>
    <td width="90"  >代理商成数</td>
    <td width="90"  >代理商结果</td>
    <td width="90"  >原币值</td>
    <td width="80"  >实货量</td>
  </tr>
   	<?
	while ($row = mysql_fetch_array($result)){
		$c_score+=$row['score'];
		$c_num+=$row['coun'];
		$c_m_result+=$row['result'];
		$c_vscore+=$row['vgold'];
		$c_a_result+=$row['a_result'];
		$c_result_a+=$row['result_a'];
		$c_vgold+=(1-$row['agent_point'])*$row['vgold'];
  	?>
	<tr class="m_rig" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF="report_agent.php?uid=<?=$uid?>&result_type=<?=$result_type?>&aid=<?=$row['name']?>&pay_type=0&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=mynumberformat($row['score'],1)?></a></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td><?=mynumberformat($row['result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td><?=$row['agent_point']?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat((1-$row['agent_point'])*$row['vgold'],1)?></td>
  </tr>
	<?
	}
	?>
  <tr class="m_rig_to">
    <td>总计</td>
    <td><?=$c_num?></td>
    <td><?=mynumberformat($c_score,1)?></td>
    <td><?=mynumberformat($c_vscore,1)?></td>
    <td><?=mynumberformat($c_m_result,1)?></td>
    <td><?=mynumberformat($c_a_result,1)?></td>
    <td></td>
    <td><?=mynumberformat($c_result_a,1)?></td>
    <td><?=mynumberformat($c_result_a,1)?></td>
    <td><?=mynumberformat($c_vgold,1)?></td>
    </tr>
</table>
<!-----------------↑ 信用额度资料区段 ↑------------------------->
<BR>
<?
if ($sgold=='block'){
	$mysql=$sql." and pay_type=1 group by agents order by name asc";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$sgold='none';
	}
}else{
	$sgold='block';
}
?>
<!-----------------↓ 现金资料区段 ↓------------------------->
<table border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="m_tab"  style="display: <?=$sgold?>" width="940">
  <tr class="m_title_reall" >
    <td colspan="10">现金</td>
  </tr>
  <tr class="m_title_reall" >
   <td width="50"  >名称</td>
    <td width="80"  >笔数</td>
    <td width="110"  >下注金额</td>
    <td width="110"  >有效金额</td>
    <td width="90"  >会员</td>
    <td width="90"  >代理商</td>
    <td width="90"  >代理商成数</td>
    <td width="90"  >代理商结果</td>
    <td width="90"  >原币值</td>
    <td width="80"  >实货量</td>
  </tr>
	<?
	while ($row = mysql_fetch_array($result)){
		$c_score1+=$row['score'];
		$c_num1+=$row['coun'];
		$c_m_result1+=$row['result'];
		$c_vscore1+=$row['vgold'];
		$c_a_result1+=$row['a_result'];
		$c_result_a1+=$row['result_a'];
		$c_vgold1+=(1-$row['agent_point'])*$row['vgold'];
  	?>

	<tr class="m_rig" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
    <td align="left"><?=$row['name']?></td>
    <td><?=$row['coun']?></td>
    <td><A HREF="report_agent.php?uid=<?=$uid?>&result_type=<?=$result_type?>&aid=<?=$row['name']?>&pay_type=1&date_start=<?=$date_start?>&date_end=<?=$date_end?>&report_kind=<?=$report_kind?>&gtype=<?=$gtype?>&wtype=<?=$wtype?>"><?=mynumberformat($row['score'],1)?></a></td>
    <td><?=mynumberformat($row['vgold'],1)?></td>
    <td><?=mynumberformat($row['result'],1)?></td>
    <td><?=mynumberformat($row['a_result'],1)?></td>
    <td><?=$row['agent_point']?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat($row['result_a'],1)?></td>
    <td><?=mynumberformat((1-$row['agent_point'])*$row['vgold'],1)?></td>
  </tr>
	<?
	}
	?>
  <tr>
    <td height="1" colspan="10"></td>
  </tr>
  <!-- END DYNAMIC BLOCK: group0 -->
  <tr class="m_rig_to">
    <td>总计</td>
    <td><?=$c_num1?></td>
    <td><?=mynumberformat($c_score1,1)?></td>
    <td><?=mynumberformat($c_vscore1,1)?></td>
    <td><?=mynumberformat($c_m_result1,1)?></td>
    <td><?=mynumberformat($c_a_result1,1)?></td>
    <td></td>
    <td><?=mynumberformat($c_result_a1,1)?></td>
    <td><?=mynumberformat($c_result_a1,1)?></td>
    <td><?=mynumberformat($c_vgold1,1)?></td>
  </tr>
</table>
<BR>
<?
if ($credit=='none' and $sgold=='none'){
	$nosearch='block';
}else{
	$nosearch='none';
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="display: <?=$nosearch?>">
  <tr >
    <td align=center height="30" bgcolor="#CC0000"><marquee align="middle" behavior="alternate" width="200"><font color="#FFFFFF">查无任何资料</font></marquee></td>

  <tr>
    <td align=center height="20" bgcolor="#CCCCCC"><a href="javascript:history.go(-1);">离开</a></td>

</table>
<?php endif;?>
</body>
</html>
<?
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','3')";
mysql_query($mysql);
mysql_close();
?>
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script>
$('.modeBtn').click(function() {
	$('.modeBtn').each(function(){
		$(this).removeClass('now');
	});	
	$(this).addClass('now');
	
	var id = $(this).attr('id');
	if (id == 'valid_btn') {
		$('#report_data_show_settle').hide();
		$('#report_data_show').show();
	} else if (id == 'settle_btn') {
		$('#report_data_show').hide();
		$('#report_data_show_settle').show();
	}
});	
</script>