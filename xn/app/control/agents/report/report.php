<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
if($uid==""){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$sql = "select super,Agname,ID,language,subname,subuser from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$week1=date('w+1');
$row = mysql_fetch_array($result);
$subuser=$row['subuser'];
if ($row['subuser']==1){
	$agname=$row['subname'];
	$loginfo=$agname.'Tài khoản phụ:'.$row['Agname'].'Báo cáo kỳ truy vấn';
}else{
	$agname=$row['Agname'];
	$loginfo='Thời gian truy vấn'.$date_start.'Để'.$date_end.'Báo cáo';
}
$agid=$row['ID'];
$super=$row['super'];

$langx='zh-cn';
require ("../../../member/include/traditional.$langx.inc.php");

$langx='zh-cn';
$date_s=date('Y-m-d');
$date_e=date('Y-m-d');

$today=date('Y-m-d');
$nowday=TDate();
$week1=date('w');
if($week1==0){
	$week1=6;
}else{
	$week1=$week1-1;
}
?>
<?php if(!isset($_GET['test'])):?>
<meta charset="UTF-8">
<link href="/style/control/report_new.css" rel="stylesheet" type="text/css">
<link href="/style/control/common_style.css" rel="stylesheet" type="text/css">
<link href="/style/jquery.selectlist.css" rel="stylesheet" type="text/css">
<link id="bs-css" href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link id="bsdp-css" href="/datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/loader.css" type="text/css">
    <script src="../js/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        // 等待所有加载
        $(window).load(function(){
            $('body').addClass('loaded');
            $('#loader-wrapper .load_title').remove();
        });
    </script>
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
        <div class="load_title">Đang tải...</div>
    </div>
	<div id="report_contain" class="reportNew" name="MaxTag" src="/js/w_report.js" linkage="w_report" extends="base_report">
		<div id="base_report" class="" name="MaxTag" src="/js/base/base_report.js" linkage="base_report"></div>
		<div id="Search_div" class="reportSearch">
			<!--div id="top_title">
			<span>报表</span>
			</div-->

			<!--创建报表-->
			<div id="create_report_contain" class="DIVsearch">
				<div id="creat_title" class="reportTitle">Tạo báo cáo</div>
				<!--报表设定-->
				<div id="create_box">
					<!--切页btn-->
					<div id="btn_box_create" class="reportHead">
						<ul>
							<li id="btn_wager" data-id="#result_label" class="modeBtn now reportHead1">Ghi chú</li>
							<li id="btn_cancelled"data-id="#cancel_label"  class="modeBtn reportHead1">Hủy phân tích đơn lẻ</li>
						</ul>
					<!--
						<div id="btn_wager">注单报表</div>
						<div id="btn_cancelled">r</div>
					-->
					</div>
					<!--切页btn end-->

					<FORM id="myFORM" ACTION="report_all.php" METHOD=POST onSubmit="return onSubmit();" name="FrmData">
						<input type=HIDDEN name="uid" value="<?=$uid?>">
						<input type="hidden" id="langx" name="langx" value="">
    	            <div id="cancel_label" class="result_cancle" style="display: none;">
						<div id="abnormal_label" class="selectBar selectBarLabel" style="margin-bottom: 5px;">
    						 <select id="report_kind" name="report_kind" >
    							<OPTION VALUE="D">Hủy bỏ</OPTION>
    							<OPTION VALUE="D4">Vé cược bất thường</OPTION>
        					</select>
                        </div>
                    </div>
					<div id="result_label" class="result_cancle" style="display: block;">
						<div id="abnormal_label" class="selectBar selectBarLabel" style="margin-bottom: 5px;">
    						<select id="result_type" name="result_type" >
    							<OPTION VALUE="Y">Có kết quả</OPTION>
    							<?php if($subuser != 1):?>
    							<OPTION VALUE="N">Không có kết quả</OPTION>
    							<?php endif; ?>
    						</select>
                        </div>
                    </div>

						<div class="input-daterange input-group" id="datepicker">
                            <input id="datepicker_start" type="text" class="input-sm form-control" name="date_start" 
                            	placeholder="Thời gian bắt đầu" value="<?=date('Y-m-d', strtotime('-1 day'))?>"  style="width:150px;height:30px;"/>
                            <span class="input-group-addon"> to </span>
                            <input id="datepicker_end" type="text" class="input-sm form-control" name="date_end" 
                            	placeholder="Thời gian kết thúc" value="<?=date('Y-m-d', strtotime('-1 day')) ?>" style="width:150px;height:30px;" />
                        </div>
                        
						<!--  <div id="date_start" class="dateSet" name="MaxTag" src="/js/calendar_ag.js" linkage="calendar_ag">
							<input id="date_input" type="text" value="">
							<span id="date_photo" class="iconSelect"></span>
						</div>
						<span class="dateSet">至</span>
						<div id="date_end" class="dateSet" name="MaxTag" src="/js/calendar_ag.js" linkage="calendar_ag">
							<input id="date_input" type="text" value="" class="">
						</div>-->

						<!--div id="date_start_title">
							<input id="date_start" name="date_start" type="text">
							<span id="date_start_photo"></span>
						</div-->
						<!--div id="date_end_title">
							<input id="date_end" name="date_end" type="text">
							<span id="date_end_photo"></span>
						</div-->

						<div id="date_box" class="dateBox">
							<div id="today_btn" class="dateBoxBtn" data-val='0'>Hôm nay</div>
							<div id="yesterday_btn" class="dateBoxBtn now" data-val="-86400000">Hôm qua</div>
							<div id="tomorrow_btn" class="dateBoxBtn dateBoxBtn2" data-val="86400000">Ngày mai</div>
						</div>
						<div id="date_box2" class="dateBox2">
							<div id="thisw_btn" class="dateBoxBtn" data-val="currentWeek">Tuần này</div>
							<div id="lastw_btn" class=" dateBoxBtn dateBoxBtn2" data-val="lastWeek">Tuần trước</div>
						</div>
						<div id="date_box3" class="dateBox3">
							<div id="priod_btn" class="dateBoxBtn" data-val="current">Vấn đề hiện tại</div>
							<!--  <div id="lastp_btn" class="dateBoxBtn dateBoxBtn2">上期</div>-->
						</div>

						<!--div id="sport_title">球类</div-->
						<div id="sport_label" class="selectBar selectSport selectBarLabel" style="margin-bottom: 5px;">
    	            	 <select name="gtype" id="gtype">
        					<option value="">Tất cả các quả bóng</option>
        					<option value="FT">Bóng đá</option>
        					<option value="BK">Bóng rổ</option>
        					<option value="TN">Quần vợt</option>
        					<option value="VB">Bóng chuyền</option>
        					<option value="BS">Bóng chày</option>
        					<option value="OP">Khác </option>
        					<option value="FS">Quán quân</option>
    					</select>
						</div>

						<!--div id="sport_title">玩法</div-->
						<div id="bet_type_label" class="selectBar selectType selectBarLabel" style="margin-bottom: 5px;">
    	           <select name="wtype" id="wtype">
                    	<option value="">Tất cả chơi</option>
                    	<option value="R">Hãy để bóng(Phút)</option>
                    	<option value="RE">Cán bóng</option>
                    	<option value="P">Tiêu chuẩn giải phóng mặt bằng</option>
                    	<option value="PR">Hãy để bóng(Phút)Vượt qua</option>
                    	<option value="PC">Giải phóng mặt bằng toàn diện</option>
                    	<option value="OU">Kích thước</option>
                    	<option value="ROU">Kích thước bóng lăn</option>
                    	<option value="PD">Làn sóng</option>
                    	<option value="T">Mục tiêu</option>
                    	<option value="M">Giành chiến thắng</option>
                    	<option value="F">Trường toàn bộ một nửa</option>
                    	<option value="HR">Nửa đầu chấp(Phút)</option>
                    	<option value="HOU">Kích thước nửa đầu</option>
                    	<option value="HM">Nửa chiến thắng đầu tiên</option>
                    	<option value="HRE">Nửa đầu bóng làm bóng(Phút)</option>
                    	<option value="HROU">Kích thước bóng đầu tiên</option>
                        <option value="HPD">Nửa trên</option>
                    </select>
				</div>
				<div id="bet_type_label" class="selectBar selectType selectBarLabel" style="margin-bottom: 5px;">
					<select name="pay_type" id="pay_type">
        				<option value="" >Trạng thái ghi chú</option>
        				<option value="0">Hạn mức tín dụng</option>
        				<option value="1">Tiền mặt</option>
        			</select>
				</div>
				
				<div id="btn_box" class="btnBox">
					<input id="clear_btn" type="button" class="btnClear" value="Xóa">
					<input type=SUBMIT id="view_btn name="SUBMIT" value="Truy vấn" class="btnSubmit">
					<!--  <input id="view_btn" type="button" class="btnSubmit" value="查询">-->
				</div>
			</form>
		</div>
		<!--报表设定 end-->
	</div>
	<!--创建报表 end-->



			<div id="creat_titleBTNG" class="DIVresult">

				<div id="btn_box_create" class="reportHead">
					<ul>
						<li id="summary_title" class="modeBtn1 modeBtn now">Tóm tắt kết quả của sự kiện</li>
						<li id="sheet_title" class="modeBtn1 modeBtn">Kỳ tài khoản hàng tháng</li>
					</ul>
					<!--
					<span id="summary_title" class="On">赛事结果概要</span><tt>|</tt><span id="sheet_title">月帐期数表</span>
					-->
				</div>


	<?php
	$mdate_t=date('m-d');
	$mdate_y=date('m-d',time()-24*60*60);
	$mysql="select * from foot_match where mid%2=1 and m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$ft_cou=mysql_num_rows($result)+0;

	$mysql="select * from foot_match where mid%2=1 and m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$ft_cou1=mysql_num_rows($result)+0;

	$mysql="select * from foot_match where mid%2=1 and m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$ft_cou2=mysql_num_rows($result)+0;

	$mysql="select * from foot_match where mid%2=1 and m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$ft_cou3=mysql_num_rows($result)+0;

	$mysql="select * from bask_match where m_Date='$mdate_t' and MB_Inball<>'' and mb_mid<100000";
	$result = mysql_query($mysql);
	$bk_cou=mysql_num_rows($result)+0;

	$mysql="select * from bask_match where m_Date='$mdate_t' and MB_Inball='' and mb_mid<100000";
	$result = mysql_query($mysql);
	$bk_cou1=mysql_num_rows($result)+0;

	$mysql="select * from bask_match where m_Date='$mdate_y' and MB_Inball<>'' and mb_mid<100000";
	$result = mysql_query($mysql);
	$bk_cou2=mysql_num_rows($result)+0;

	$mysql="select * from bask_match where m_Date='$mdate_y' and MB_Inball='' and mb_mid<100000";
	$result = mysql_query($mysql);
	$bk_cou3=mysql_num_rows($result)+0;

	$mysql="select * from tennis where m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$tn_cou=mysql_num_rows($result)+0;

	$mysql="select * from tennis where m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$tn_cou1=mysql_num_rows($result)+0;

	$mysql="select * from tennis where m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$tn_cou2=mysql_num_rows($result)+0;

	$mysql="select * from tennis where m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$tn_cou3=mysql_num_rows($result)+0;

	$mysql="select * from volleyball where m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$vb_cou=mysql_num_rows($result)+0;

	$mysql="select * from volleyball where m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$vb_cou1=mysql_num_rows($result)+0;

	$mysql="select * from volleyball where m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$vb_cou2=mysql_num_rows($result)+0;

	$mysql="select * from volleyball where m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$vb_cou3=mysql_num_rows($result)+0;

	$mysql="select * from baseball where m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$bs_cou=mysql_num_rows($result)+0;

	$mysql="select * from baseball where m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$bs_cou1=mysql_num_rows($result)+0;

	$mysql="select * from baseball where m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$bs_cou2=mysql_num_rows($result)+0;

	$mysql="select * from baseball where m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$bs_cou3=mysql_num_rows($result)+0;


	$mysql="select * from sp_match where date_format(mstart,'%m-%d')='$mdate_t' and QQ526738=1 group by mid";
	$result = mysql_query($mysql);
	$sp_cou=mysql_num_rows($result)+0;


	$mysql="select * from sp_match where date_format(mstart,'%m-%d')='$mdate_t' and QQ526738=0 group by mid";
	$result = mysql_query($mysql);
	$sp_cou1=mysql_num_rows($result)+0;

	$mysql="select * from sp_match where date_format(mstart,'%m-%d')='$mdate_y' and QQ526738=1 group by mid";
	$result = mysql_query($mysql);
	$sp_cou2=mysql_num_rows($result)+0;


	$mysql="select * from sp_match where date_format(mstart,'%m-%d')='$mdate_y' and QQ526738=0 group by mid";
	$result = mysql_query($mysql);
	$sp_cou3=mysql_num_rows($result)+0;

    $mysql="select * from other_play where m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$op_cou=mysql_num_rows($result)+0;

	$mysql="select * from other_play where m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$op_cou1=mysql_num_rows($result)+0;

	$mysql="select * from other_play where m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$op_cou2=mysql_num_rows($result)+0;

	$mysql="select * from other_play where m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$op_cou3=mysql_num_rows($result)+0;
	if(($ft_cou1+$bk_cou1+$tn_cou1+$vb_cou1+$bs_cou1+$sp_cou1+$op_cou1)==0){
		$kkk1="<b><font class='show_ok'>Hoàn thành</font></b>";
	}else{
		$kkk1="<b><font class='show_no'>Chưa hoàn thành</font></b>";
	}
	if(($ft_cou3+$bk_cou3+$tn_cou3+$vb_cou3+$bs_cou3+$sp_cou3+$op_cou3)==0){
		$kkk3="<b><font class='show_ok'>Hoàn thành</font></b>";
	}else{
		$kkk3="<b><font class='show_no'>Chưa hoàn thành</font></b>";
	}
	?>

				<!--赛事结果概要-->
				<!--结果列表-->
				<div id="summary_box" class="reportBox">
					<table id="summaryTable" name="summaryTable" class="resultTable summaryTable">
						<tbody id="summaryTbody">
							<tr id="psTr" name="psTr" class="noHover">
								<th>&nbsp;</th>

								<th id="psTd" align="center" colspan="2">
									<span id="yesterday_finish"><font class="txtGreen">Hoàn thành</font></span>
									<br>
									Hôm qua(<span id="yesterday_date"><?= date('Y-m-d', strtotime('-1 day')) ?></span>)
								</th>

								<th id="psTd_2" align="center" colspan="2">
									<span id="today_finish"><font class="txtRed">Chưa hoàn thành</font></span>
									<br>
									Hôm nay(<span id="today_date"><?= date('Y-m-d') ?></span>)
								</th>
							</tr>
							<tr id="titleTr" name="tidleTr" class="subTh noHover">
								<td class="sportName">&nbsp;</td>
								<td class="todayNo">Không có</td>
								<td class="todayYes">Có</td>
								<td class="yestNo">Không có </td>
								<td class="yestYes">Có</td>
							</tr>
							<tr id="FTTr" name="soccerTr" class="">
								<td id="title" class="sportName" name="title">Bóng đá</td>
								<td id="yes_un" class="todayNo" name="com_un"><?= $ft_cou3?></td>
								<td id="yes_set" class="todayYes" name="com_set"><?=$ft_cou2?></td>
								<td id="to_un" class="yestNo" name="incom_un"><?=$ft_cou1?></td>
								<td id="to_set" class="yestYes" name="incom_set"><?=$ft_cou?></td>
							</tr>
							<tr id="BKTr" name="bsTr" class="">
								<td id="title" class="sportName" name="title">Bóng rổ</td>
								<td id="yes_un" class="todayNo" name="com_un"><?= $bk_cou3?></td>
								<td id="yes_set" class="todayYes" name="com_set"><?= $ft_cou2?></td>
								<td id="to_un" class="yestNo" name="incom_un"><?= $ft_cou1?></td>
								<td id="to_set" class="yestYes" name="incom_set"><?= $ft_cou?></td>
							</tr>
							<tr id="TNTr" name="bsTr" class="">
								<td id="title" class="sportName" name="title">Quần vợt</td>
								<td id="yes_un" class="todayNo" name="com_un"><?= $tn_cou3?></td>
								<td id="yes_set" class="todayYes" name="com_set"><?= $tn_cou2?></td>
								<td id="to_un" class="yestNo" name="incom_un"><?= $tn_cou1?></td>
								<td id="to_set" class="yestYes" name="incom_set"><?= $tn_cou?></td>
							</tr>
							<tr id="VBTr" name="bsTr" class="">
								<td id="title" class="sportName" name="title">Bóng chuyền</td>
								<td id="yes_un" class="todayNo" name="com_un"><?= $vb_cou3?></td>
								<td id="yes_set" class="todayYes" name="com_set"><?= $vb_cou2?></td>
								<td id="to_un" class="yestNo" name="incom_un"><?= $vb_cou1?></td>
								<td id="to_set" class="yestYes" name="incom_set"><?= $vb_cou?></td>
							</tr>
							<tr id="BSTr" name="basTr" class="">
								<td id="title" class="sportName" name="title">Bóng chày</td>
								<td id="yes_un" class="todayNo" name="com_un"><?= $bs_cou3?></td>
								<td id="yes_set" class="todayYes" name="com_set"><?= $bs_cou2?></td>
								<td id="to_un" class="yestNo" name="incom_un"><?= $bs_cou1?></td>
								<td id="to_set" class="yestYes" name="incom_set"><?= $bs_cou?></td>
							</tr>
							<tr id="FSTr" name="outTr" class="">
								<td id="title" class="sportName" name="title">Quán quân</td>
								<td id="yes_un" class="todayNo" name="com_un"><?= $sp_cou3?></td>
								<td id="yes_set" class="todayYes" name="com_set"><?=$sp_cou2 ?></td>
								<td id="to_un" class="yestNo" name="incom_un"><?=$sp_cou1 ?></td>
								<td id="to_set" class="yestYes" name="incom_set"><?=$sp_cou ?></td>
							</tr>
							<tr id="OPTr" name="otherTr" class="">
								<td id="title" class="sportName" name="title">Quả bóng khác</td>
								<td id="yes_un" class="todayNo" name="com_un"><?=$op_cou3?></td>
								<td id="yes_set" class="todayYes" name="com_set"><?=$op_cou2?></td>
								<td id="to_un" class="yestNo" name="incom_un"><?=$op_cou1?></td>
								<td id="to_set" class="yestYes" name="incom_set"><?=$op_cou?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!--结果列表 end-->
				<!--赛事结果概要 end-->
				<?php 
				    $currentYear = date('Y');
				    $currentDate = date('Y-m-d');
				    $lastYear = $currentYear - 1;
				    
				    $step = 27 * 3600 * 24;
				    $currentYearStart = '2017-12-25';
				    $lastYearStart = '2016-12-26';
				    $allData = [];
				    for ($i = 1 ; $i <= 13; $i++) {
				        $oneDay = $i > 1 ? 24 * 3600 * ($i-1) : 0;
				        $temp['current'][0] = date('Y-m-d', strtotime($currentYearStart) + $step * ($i-1) + $oneDay);
				        $temp['current'][1] = date('Y-m-d', strtotime($currentYearStart) + $step * ($i) + $oneDay);
				        $temp['class'] = '';
				        if ($temp['current'][0] < $currentDate && $currentDate < $temp['current'][1]) {
				            $temp['class'] = 'now';
				        }
				        $temp['last'][0] = date('Y-m-d', strtotime($lastYearStart) + $step * ($i-1) + $oneDay);
				        $temp['last'][1] = date('Y-m-d', strtotime($lastYearStart) + $step * ($i) + $oneDay);
				        array_push($allData, $temp);
				    }
				?>
				<!--月帐期数表-->
				<div id="sheet_box" class="reportBox" style="display:none;">
					<table id="sheetTable" name="sheetTable" class="resultTable sheetTable">
						<tbody id="sheetTbody">
							<tr id="titleTr" name="titleTr" class="noHover" >
								<th class="reportTd" style="text-align:center;"><?= $currentYear?></th>
								<th class="reportTd" style="text-align:center;"><?= $lastYear?></th>
							</tr>
							<?php foreach ($allData as $key =>$data):?>
								<!--期数1-->
								<tr id="sheetTr_1" name="sheetTr_1" class="">
								<td id="year_<?= $currentYear?>" class="reportTd <?=$data['class'] ?>">
									<span class="reportNo"><?=$key+1?>.</span>
									<span class="reportYear" name="year_<?= $currentYear?>">
										<div id="pink_bg"><?= $data['current'][0]?> ~ <?= $data['current'][1]?></div>
									</span>
								</td>
								<td id="year_<?= $lastYear?>" class="reportTd">
									<span class="reportNo"><?=$key+1?>.</span>
									<span class="reportYear" name="year_<?= $lastYear?>">
										<div id="pink_bg"><?= $data['last'][0]?> ~ <?= $data['last'][1]?></div>
									</span>
								</td>
								</tr>
							    <!--期数1 end-->
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<!--月帐期数表 end-->
			</div>

		<!--报表-->
		</div>
		<div id="report_data_div" class="report_data_div" style="display:none;"></div>
		<!--报表end-->

		<div id="debug_div"></div>
		
	<div name="fank_calander_element" class="cal_div" style="position: absolute; display: none;"><div name="fank_calander_element" class="cal_YearContain"><span name="fank_calander_element" class="cal_previous"></span><label name="fank_calander_element" class="cal_month_label"><select name="fank_calander_element" class="cal_month"><option value="0">Tháng giêng</option><option value="1">Tháng hai</option><option value="2">Tháng ba</option><option value="3">Tháng Bốn</option><option value="4">Tháng Năm</option><option value="5">Tháng Sáu</option><option value="6">Tháng Bảy</option><option value="7">Tháng Tám</option><option value="8">Tháng Chín</option><option value="9">Tháng Mười</option><option value="10">Tháng Mười một</option><option value="11">Tháng Mười hai</option></select></label><label name="fank_calander_element" class="cal_year_label"><select name="fank_calander_element" class="cal_year"><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option><option value="2031">2031</option><option value="2032">2032</option><option value="2033">2033</option><option value="2034">2034</option><option value="2035">2035</option><option value="2036">2036</option><option value="2037">2037</option><option value="2038">2038</option></select></label><span name="fank_calander_element" class="cal_next"></span></div><div name="fank_calander_element"><span name="fank_calander_element" class="cal_week_left">日</span><span name="fank_calander_element" class="cal_week">Một</span><span name="fank_calander_element" class="cal_week">Hai</span><span name="fank_calander_element" class="cal_week">ba</span><span name="fank_calander_element" class="cal_week">bốn</span><span name="fank_calander_element" class="cal_week">năm</span><span name="fank_calander_element" class="cal_week">sáu</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date ">1</span><span name="fank_calander_element" class="cal_date ">2</span><span name="fank_calander_element" class="cal_date ">3</span><span name="fank_calander_element" class="cal_date ">4</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">5</span><span name="fank_calander_element" class="cal_date cal_goal">6</span><span name="fank_calander_element" class="cal_date ">7</span><span name="fank_calander_element" class="cal_date ">8</span><span name="fank_calander_element" class="cal_date ">9</span><span name="fank_calander_element" class="cal_date ">10</span><span name="fank_calander_element" class="cal_date ">11</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">12</span><span name="fank_calander_element" class="cal_date ">13</span><span name="fank_calander_element" class="cal_date ">14</span><span name="fank_calander_element" class="cal_date ">15</span><span name="fank_calander_element" class="cal_date ">16</span><span name="fank_calander_element" class="cal_date ">17</span><span name="fank_calander_element" class="cal_date ">18</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">19</span><span name="fank_calander_element" class="cal_date ">20</span><span name="fank_calander_element" class="cal_date ">21</span><span name="fank_calander_element" class="cal_date ">22</span><span name="fank_calander_element" class="cal_date ">23</span><span name="fank_calander_element" class="cal_date ">24</span><span name="fank_calander_element" class="cal_date ">25</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">26</span><span name="fank_calander_element" class="cal_date ">27</span><span name="fank_calander_element" class="cal_date ">28</span><span name="fank_calander_element" class="cal_date ">29</span><span name="fank_calander_element" class="cal_date ">30</span><span name="fank_calander_element" class="cal_date ">31</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span></div></div><div name="fank_calander_element" class="cal_div" style="position: absolute; display: none;"><div name="fank_calander_element" class="cal_YearContain"><span name="fank_calander_element" class="cal_previous"></span><label name="fank_calander_element" class="cal_month_label"><select name="fank_calander_element" class="cal_month"><option value="0">Tháng giêng</option><option value="1">Tháng hai</option><option value="2">Tháng ba</option><option value="3">Tháng Bốn</option><option value="4">Tháng Năm</option><option value="5">Tháng Năm</option><option value="6">Tháng Sáu</option><option value="7">Tháng Tám</option><option value="8">Tháng Chín</option><option value="9">Tháng Mười</option><option value="10">Tháng Mười một</option><option value="11">Tháng Mười hai</option></select></label><label name="fank_calander_element" class="cal_year_label"><select name="fank_calander_element" class="cal_year"><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option><option value="2031">2031</option><option value="2032">2032</option><option value="2033">2033</option><option value="2034">2034</option><option value="2035">2035</option><option value="2036">2036</option><option value="2037">2037</option><option value="2038">2038</option></select></label><span name="fank_calander_element" class="cal_next"></span></div><div name="fank_calander_element"><span name="fank_calander_element" class="cal_week_left">日</span><span name="fank_calander_element" class="cal_week">Một</span><span name="fank_calander_element" class="cal_week">Hai</span><span name="fank_calander_element" class="cal_week">ba</span><span name="fank_calander_element" class="cal_week">bốn</span><span name="fank_calander_element" class="cal_week">năm</span><span name="fank_calander_element" class="cal_week">sáu</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span><span name="fank_calander_element" class="cal_date ">1</span><span name="fank_calander_element" class="cal_date ">2</span><span name="fank_calander_element" class="cal_date ">3</span><span name="fank_calander_element" class="cal_date ">4</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">5</span><span name="fank_calander_element" class="cal_date cal_goal">6</span><span name="fank_calander_element" class="cal_date ">7</span><span name="fank_calander_element" class="cal_date ">8</span><span name="fank_calander_element" class="cal_date ">9</span><span name="fank_calander_element" class="cal_date ">10</span><span name="fank_calander_element" class="cal_date ">11</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">12</span><span name="fank_calander_element" class="cal_date ">13</span><span name="fank_calander_element" class="cal_date ">14</span><span name="fank_calander_element" class="cal_date ">15</span><span name="fank_calander_element" class="cal_date ">16</span><span name="fank_calander_element" class="cal_date ">17</span><span name="fank_calander_element" class="cal_date ">18</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">19</span><span name="fank_calander_element" class="cal_date ">20</span><span name="fank_calander_element" class="cal_date ">21</span><span name="fank_calander_element" class="cal_date ">22</span><span name="fank_calander_element" class="cal_date ">23</span><span name="fank_calander_element" class="cal_date ">24</span><span name="fank_calander_element" class="cal_date ">25</span><br name="fank_calander_element"><span name="fank_calander_element" class="cal_date_left ">26</span><span name="fank_calander_element" class="cal_date ">27</span><span name="fank_calander_element" class="cal_date ">28</span><span name="fank_calander_element" class="cal_date ">29</span><span name="fank_calander_element" class="cal_date ">30</span><span name="fank_calander_element" class="cal_date ">31</span><span name="fank_calander_element" class="cal_date cal_space">&nbsp;&nbsp;</span></div></div></div>
</div></div>
<?php else:?>



<?php endif;?>
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://www.agents.com/js/jquery.selectlist.js"></script>
<script src="/datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(window).load(function(){
        $('body').addClass('loaded').Chameleon({
            'current_item':'hoveralls',
            'json_url':'../Envato/items.json'
        });
        $('#loader-wrapper .load_title').remove();
    });
</script>
<script>
$(function(){
	$('select').selectlist({
		zIndex: 10,
		width: 360,
		height: 32
	});		
})

$('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    todayBtn: "linked",
    language: "zh-CN", //en
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    toggleActive: true
});

$('#today_btn').click(function () {
	 var myDate = new Date();
	 $('#datepicker_start').datepicker('setDate', myDate);
});

$(".dateBoxBtn").click(function() {
	$(".dateBoxBtn").each(function() {
		$(this).removeClass('now')
	});
	$(this).addClass('now');

	var val = $(this).attr('data-val');
	if (val == 'current') {
		$('#datepicker_start').datepicker('setDate', 0);
		$('#datepicker_end').datepicker('setDate', 0);
	} else if (val == 'currentWeek') {
		$('#datepicker_start').datepicker('setDate', getWeekStartDate());
		$('#datepicker_end').datepicker('setDate', getWeekEndDate());
	} else if (val == 'lastWeek') {
		$('#datepicker_start').datepicker('setDate', getLastWeekStartDate());
		$('#datepicker_end').datepicker('setDate', getLastWeekEndDate());
	} else {
		var myDate = new Date();
		myDate.setTime(myDate.getTime() + parseInt(val));
		//console.log(myDate.getTime());
		$('#datepicker_start').datepicker('setDate', myDate);
		$('#datepicker_end').datepicker('setDate', myDate);
	}
	
	
});

var now = new Date(); //当前日期
var nowDay = now.getDate(); //当前日
var nowMonth = now.getMonth(); //当前月
var nowYear = now.getYear(); //当前年
nowYear += (nowYear < 2000) ? 1900 : 0; //
var nowDayOfWeek = now.getDay()-1; //今天本周的第几天


//获得本周的开始日期
function getWeekStartDate() {
  	var weekStartDate = new Date(nowYear, nowMonth, nowDay - nowDayOfWeek);
  	console.log(nowDayOfWeek);
  	return weekStartDate;
}
//获得本周的结束日期
function getWeekEndDate() {
	return new Date(nowYear, nowMonth, nowDay + (6 - nowDayOfWeek));
}
//获得上周的开始日期
function getLastWeekStartDate() {
	return new Date(nowYear, nowMonth, nowDay - nowDayOfWeek - 7);
}
//获得上周的结束日期
function getLastWeekEndDate() {
	return new Date(nowYear, nowMonth, nowDay - nowDayOfWeek - 1);
}

$('.modeBtn1').click(function() {
	$('.modeBtn1').each(function(){
		$(this).removeClass('now');
	});	
	$(this).addClass('now');
	var id = $(this).attr('id');
	if (id == 'summary_title') {
		$('#summary_box').show();
		$('#sheet_box').hide();
	} else if (id == 'sheet_title') {
		$('#summary_box').hide();
		$('#sheet_box').show();
	}
});

$('.reportHead1').click(function() {
	$('.reportHead1').each(function(){
		$(this).removeClass('now');
	});	
	$(this).addClass('now');
	var id  = $(this).attr('data-id');
	$('.result_cancle').each(function() {
		$(this).hide();
		});
	$(id).show();
});


</script>