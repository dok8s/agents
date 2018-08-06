<?
error_reporting(0);
foreach ($_GET as $get_key=>$get_var)
{
    if (is_numeric($get_var))
 if (is_numeric($get_var)) {
  $get[strtolower($get_key)] = get_int($get_var);
 } else {
  $get[strtolower($get_key)] = get_str($get_var);
 }
}

/* 过滤所有POST过来的变?*/
foreach ($_POST as $post_key=>$post_var)
{
 if (is_numeric($post_var)) {
  $post[strtolower($post_key)] = get_int($post_var);
 } else {
  $post[strtolower($post_key)] = get_str($post_var);
 }
}
//判断编码utf8
function is_utf8($liehuo_net) 
{ 
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$liehuo_net) == true) { 
		return true; 
	} 
	else 
	{ 
		return false; 
	}
}
/* 过滤函数 */
//整型过滤函数
function get_int($number)
{
    return intval($number);
}
//字符串型过滤函数
function get_str($string)
{
    if (!get_magic_quotes_gpc()) {
 return addslashes($string);
    }
    return $string;
}
function LoadPNG($imgname,$code)
{
    $im = @imagecreatefrompng($imgname); /* Attempt to open */
    if(!$im) { /* See if it failed */
        $im  = imagecreatetruecolor(30, 30); /* Create a blank image */
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
        imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
    }
    $tc  = imagecolorallocate($im, 207, 0, 5);
    imagestring($im, 10, 12, 3, $code, $tc);
    return $im;
}


function TDate(){
	//$rq = array("2008-12-29","2009-01-26","2009-02-23","2009-03-23","2009-04-20","2009-05-18","2009-06-15","2009-07-13","2009-08-10","2009-09-07","2009-10-05","2009-11-02","2009-11-30","2009-12-28");
	$rq = array();
	$timestart = strtotime('2014-12-22');
	$D = 3600*24;
	$Q = $D*7*4;
	for($i=0; $i<24; $i++){
		if($i==1){
			$Q = $D*7*5;
			$rq[] = date('Y-m-d', $timestart+$i*$Q);
		}else{
			$Q = $D*7*4;
			$rq[] = date('Y-m-d', $timestart+$i*$Q);
		}
	}

	$t=date('Y-m-d',time()-3*24*3600);
	for($i=1;$i<=count($rq);$i++){
		if($rq[$i]>$t){
			$mon=$i;
			$nowday[0]=$rq[$mon-1];
			$Date_List_1=explode("-",$rq[$mon]);
			$d1=mktime(0,0,0,$Date_List_1[1],$Date_List_1[2],$Date_List_1[0]);
			$nowday[1]=date('Y-m-d',$d1-24*60*60);
			$nowday[2]='Y_'.$mon;
			return $nowday;
		}
	}
}

function wterror($msg){
	$test=$test."<html>";
	$test=$test."<head>";
	$test=$test."<title>error</title>";
	$test=$test."<meta http-equiv=Content-Type content=text/html; charset=utf-8>";
	$test=$test."<STYLE> A:visit { color=#6633cc; text-decoration: none ;}";
	$test=$test."tr {  font-family: Arial; font-size: 12px; color: #CC0000}";
	$test=$test.".b_13set {  font-size: 15px; font-family: Arial; color: #FFFFFF; padding-top: 2px; padding-left: 5px}";
	$test=$test.".b_tab {  border: 1px #000000 solid; background-color: #D2D2D2}";
	$test=$test.".b_back {  height: 20px; padding-top: 5px; color: #FFFFFF; cursor: hand; padding-left: 50px}";
	$test=$test."a:link {  color: #0000FF}";
	$test=$test."a:hover {  color: #CC0000}";
	$test=$test."a:visited {  color: #0000FF}";
	$test=$test."</STYLE>";
	$test=$test."</head>";
	$test=$test."<body text=#000000 leftmargin=0 topmargin=10 bgcolor=535E63 vlink=#0000FF alink=#0000FF>";
	$test=$test."<table width=600 border=0 cellspacing=0 cellpadding=0 align=center>";
	$test=$test."  <tr>";
	$test=$test."    <td width=36><img src=/images/control/error_p11.gif width=36 height=63></td>";
	$test=$test."    <td background=/images/control/error_p12b.gif>&nbsp;</td>";
	$test=$test."    <td width=160><img src=/images/control/error_p13.gif width=160 height=63></td>";
	$test=$test."  </tr>";
	$test=$test."</table>";
	$test=$test."<table width=598 border=0 cellspacing=0 cellpadding=0 align=center class=b_tab>";
	$test=$test."  <tr bgcolor=#000000> ";
	$test=$test."    <td ><img src=/images/control/error_dot.gif width=23 height=22></td>";
	$test=$test."    <td class=b_13set width=573>错误讯息</td>";
	$test=$test."  </tr>";
	$test=$test."  <tr> ";
	$test=$test."    <td colspan=2 align=center><br>";
	$test=$test."      $msg<BR><br>";
	$test=$test."      &nbsp; </td>";
	$test=$test."  </tr>";
	$test=$test."  <tr> ";
	$test=$test."    <td colspan=2>";
	$test=$test."      <table width=598 border=0 cellspacing=0 cellpadding=0 bgcolor=A0A0A0>";
	$test=$test."        <tr>";
	$test=$test."          <td>&nbsp;</td>";
	$test=$test."          <td background=/images/control/error_p3.gif width=120><a href='javascript:history.go(-1)';><span class=b_back>回上一页</span></a></td>";
	$test=$test."        </tr>";
	$test=$test."      </table>";
	$test=$test."    </td>";
	$test=$test."  </tr>";
	$test=$test."</table>";
	$test=$test."</body>";
	$test=$test."</html>";
//	exit();
	return $test;
}


function show_voucher($line,$id){

	$id=$id+1000000000;
	switch($line){
	case 4:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 34:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 5:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 15:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 17:
		$show_voucher='PM48'.substr(($id-002714),2);
		break;
	case 25:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 104:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 105:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 6:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 7:
		$show_voucher='P48'.substr(($id-088782),2);
		break;
	case 8:
		$show_voucher='PR48'.substr(($id-065782),2);
		break;
	case 14:
		$show_voucher='DT48'.substr(($id-012714),2);
	case 24:
		$show_voucher='DT48'.substr(($id-012714),2);
	case 16:
		$show_voucher='DT48'.substr(($id-012714),2);
		break;
	default:
		$show_voucher='OU48'.substr($id,2);
		break;
	}
	return $show_voucher;
}

function change_rate($c_type,$c_rate){
	switch($c_type){
	case 'A':
		$t_rate='0.03';
		break;
	case 'B':
		$t_rate='0.01';
		break;
	case 'C':
		$t_rate='0';
		break;
	case 'D':
		$t_rate='-0.015';
		break;
	}

	$change_rate=number_format($c_rate-$t_rate,3);
	if ($change_rate<=0){
		$change_rate='';
	}
	return $change_rate;
}
function change_current($c_type){
	switch(trim($c_type)){
	case 'HKD':
		$change_current='$mem_radio_HKD';
		break;
	case 'USD':
		$change_current=$mem_radio_USD;
		break;
	case 'MYR':
		$change_current=$mem_radio_MYR;
		break;
	case 'SGD':
		$change_current=$mem_radio_SGD;
		break;
	case 'THB':
		$change_current=$mem_radio_THB;
		break;
	case 'GBP':
		$change_current=$mem_radio_GBP;
		break;
	case 'JPY':
		$change_current=$mem_radio_JPY;
		break;
	case 'EUR':
		$change_current=$mem_radio_EUR;
		break;
	case 'RMB':
		$change_current='$mem_current';
		break;
	case '':
		$change_current='$mem_current';
		break;
	}
	return $change_current;
}

function chk_pwd($str=''){
	$r=0;
	$len=strlen($str);
	if($len<6 || $len>32){
		$r=1;
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script>
  alert(\'⊕密码必须至少6个字符，最12个字符，并只能有数字(0-9)，及英文大小字母 \')
</script>
<script>
   history.go(-1);</script>';
		exit;
	}
}

function formatNumber( $number, $decimals=2, $dec_point=".", $thousands_sep=",") {
   $nachkomma = abs($in - floor($in));
   $strnachkomma = number_format($nachkomma , $decimals, ".", "");

   for ($i = 1; $i <= $decimals; $i++) {
       if (substr($strnachkomma, ($i * -1), 1) != "0") {
           break;
       }
   }

   return number_format($in, ($decimals - $i +1), $dec_point, $thousands_sep);
}

function mynumberformat($number, $decimals=2, $dec_point=".", $thousands_sep=""){
	return number_format($number, $decimals, $dec_point, $thousands_sep);
}

function cdate($date_start){
	$Date_List_1=explode("-",$date_start);
	$d1=mktime(0,0,0,$Date_List_1[1],$Date_List_1[2],$Date_List_1[0]);
	return date('Y-m-d',$d1);
}

function get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end,$subuser){
	switch($gtype){
	case 'FT':
		$active=' active<3 and ';
		break;
	case 'BK':
		$active=' active=3 and ';
		break;
	case 'TN':
		$active=' active=4 and ';
		break;
	case 'VB':
		$active=' active=5 and ';
		break;
	case 'BS':
		$active=' active=7 and ';
		break;
	case 'FS':
		$active=' active=6 and ';
		break;
	case 'OP':
		$active=' active=8 and ';
		break;
	default:
		$active='';
		break;
	}

	if($wtype!=''){
		$w_type=" wtype='$wtype' and ";
	}else{
		$w_type='';
	}

	if($subuser==0){
		if ($result_type=='Y'){
			$result_type1=" result_type=1 and ";
		}else{
			$result_type1=" result_type=0 and ";
		}
	}else{
		$result_type1=" result_type=1 and ";
	}

	switch ($report_kind){
	case "D":
		$cancel=' status>1 and ';
		break;
	case "D4":
		$cancel=' status=1 and ';
		break;
	default:
		$cancel='';
		break;
	}
	return $active.$w_type.$result_type1.$cancel." m_date>='$date_start' and  hidden=0 and m_date<='$date_end' ";
}

function getscore($mid,$active,$showtype,$linetype,$dbname){
	if($active<3){
		$table='foot_match';
	}else if($active==3){
		$table='bask_match';
	}
	$sql='select (mb_ball+0) as balla,(tg_ball+0) as ballb from '.$table.' where mid='.$mid;
	$result1 = mysql_query($sql);
	$row1 = mysql_fetch_array($result1);

		if($showtype=='C'){
			if($linetype==2 || $linetype==12 || $linetype==9 || $linetype==19){
				$score=$row1['ballb'].':'.$row1['balla'];
			}else{
				$score=$row1['balla'].':'.$row1['ballb'];
			}
		}else{
			$score=$row1['balla'].':'.$row1['ballb'];
		}
	return '<font color="#009900"><b>'.$score.'</b></font>  ';

}
function ip_drop(){
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$sql = "select setdata from web_system limit 0,1";
	$result = mysql_query( $sql );
	$rt = mysql_fetch_array( $result );
	$setdata = @unserialize($rt['setdata']);
	$agents_ip_drop = str_replace("\r",'',$setdata['agents_ip_drop']);
	return strpos("\n$agents_ip_drop\n", "\n$ip\n")!==false;
}

function show_message($memname){	
	mysql_query("update message set readcount=readcount+1 where member='$memname' limit 1");
	$sql = "select message,message_tw from message where member='$memname' limit 0,1";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$cou=mysql_num_rows($result);
	if($cou!=0){
		$talert=$row['message_tw'];
		if ($talert<>''){
			echo '<meta http-equiv="Content-Type" content="text/html; charset=big5">';				
			echo "<script>alert('$talert');</script>";
		}

	}
}
?>