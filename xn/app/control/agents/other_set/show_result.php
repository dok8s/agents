<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
$uid   = $_REQUEST['uid'];
$gtype = $_REQUEST['gtype'];
$page  = $_REQUEST['page_no'];
$flag  = $_REQUEST['flag'];
$sql = "select Agname,ID from web_agents where Oid='$uid'";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

if ($flag==''){
	$bdate=date('m-d',time());
}else if($flag=='Y'){
	$bdate=date('m-d',time()-24*60*60);
}
if ($gtype==''){
	$gtype='FT';
}
$sql="select mb_team,tg_team,m_date,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as m_time,mb_mid,tg_mid,m_league,mb_inball,tg_inball";

switch($gtype){
case 'FT':
	$table=',mb_inball_hr,tg_inball_hr from foot_match';
	$css='';
	$css1='_ft';
	break;
case 'BK':
	$table=' from bask_match';
	$css='';
	$css1='_ft';
	break;
case 'VB':
	$table=' from volleyball';
	$css='_vb';
	$css1='_vb';
	break;
case 'TN':
	$table=' from tennis';
	$css='_tn';
	$css1='_tn';
	break;
case 'BS':
	$table=' from baseball';
	$css='_bs';
	$css1='_bs';
	break;
default:
	$table='foot_match';
	$css1='_ft';
	$css='';
	$gtype='FT';
	break;
}
if ($gtype=='FT'){
	$sql=$sql.$table." where m_date='".$bdate."' and mid%2=1 and mb_inball!='' order by m_start,mid";
}else{
	$sql=$sql.$table." where m_date='".$bdate."' and mb_inball!='' order by m_start,mid";
}

$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=40;
$page_count=ceil($cou/$page_size);
$offset=($page)*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);

?>
<script>var pg='<?=$page?>';
var t_page='<?=$page_count?>';
var uid='<?=$uid?>';
var flag='<?=$flag?>';
var gtype='<?=$gtype?>';
</script><html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<script language="JavaScript"> 
function show_page(){
	var temp="";
	var pg_str=""
	for(var i=0;i<t_page;i++){

		if (pg!=i)
			pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'><font color='#000099'>"+(i+1)+"</font></a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			pg_str=pg_str+"<B><font color='#FF0000'>"+(i+1)+"</font></B>&nbsp;&nbsp;&nbsp;&nbsp;";			
	}
	txt_bodyP= bodyP.innerHTML;			
	txt_bodyP =txt_bodyP.replace("*SHOW_P*",pg_str);    
	pg_txt.innerHTML=txt_bodyP;
}

 function onLoad()
 {
	show_page();
 }

function chg_pg(pg)
{
	self.location = './show_result.php?uid='+uid+'&page_no='+pg+'&flag='+flag+'&gtype='+gtype;
}
 
</SCRIPT>

</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"   onLoad="onLoad()" >
<FORM NAME="REFORM">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline"> 
      <table border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          
          <td width="100" >&nbsp;&nbsp;
<?
if ($flag==''){
?><A HREF="./show_result.php?uid=<?=$uid?>&gtype=<?=$gtype?>&flag=Y" target="_self">昨日</A>
<?
}else{
?>
<A HREF="./show_result.php?uid=<?=$uid?>&gtype=<?=$gtype?>" target="_self">今日</A>
<?
}
?>
&nbsp;&nbsp;&nbsp;&nbsp;赛程:
</td>
          
        <td width="220" > 
		<A HREF="./show_result.php?uid=<?=$uid?>&gtype=FT" target="_self">[足球]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&gtype=BK" target="_self">[篮球]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&gtype=TN" target="_self">[网球]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&gtype=VB" target="_self">[排球]</A> &nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&gtype=BS" target="_self">[棒球]</A> 
        </td>
        <td>
        <span id="pg_txt"></span>
        </td>
        </tr>
      </table>
    </td>
    
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab<?=$css?>" width="610">
  <tr  class="m_title<?=$css1?>"> 
		<td width="40">时间</td>
		<td width="50" nowrap>联盟</td>
		<td width="40">场次</td>
		<td width="180">队伍</td>
		<?
		if($gtype=='FT' || $gtype=='BS'){
			?>
		<td width="150">上半</td>
		<?
	}
	?>
		<td width="150">完赛</td>
	</tr>
  </tr>
<?
while ($row = mysql_fetch_array($result)){

if(count(explode("PK",$row['m_league']))==1 && count(explode("延时",$row['m_league']))==1){
?>
  <tr  bgcolor='#FFFFFF'> 
    <td><?=$row['m_date']?><BR><?=$row['m_time']?></td>

    <td align='center'><?
	if ($row['m_sleague']==''){
		echo $row['m_league'];
	}else{
		echo $row['m_sleague'];
	}?></td>
    <td ><?=$row['mb_mid']?><br><?=$row['tg_mid']?></td>
    <td ><?=$row['mb_team']?><br><?=$row['tg_team']?></td>
    <!--td ></td-->
<?
		if($gtype=='FT' || $gtype=='BS'){
			if ($row['mb_inball_hr']==-1 || $row['mb_inball_hr']==-1){
				$ball_hr='<font color="#CC0000">赛事延赛</font>';
			}else{
				$ball_hr=$row['mb_inball_hr'].'<br>'.$row['tg_inball_hr'];
			}

			if ($row['mb_inball']==-1 || $row['tg_inball']==-1){
				if ($row['mb_inball_hr']==-1 || $row['mb_inball_hr']==-1){
					$ball='<font color="#CC0000">赛事延赛</font>';
				}else{
					$ball='<font color="#CC0000">赛事腰斩</font>';
				}
			}else{
				$ball=$row['mb_inball'].'<br>'.$row['tg_inball'];
			}
			
			?>
    <td align='center'><?=$ball_hr?></td>
    <td align='center'><?=$ball?></td>
    <?
  }else{
?>    <td align='center'><?=$row['mb_inball']?><br><?=$row['tg_inball']?></td>
  <?	
  	}
  	?>
  </tr> 
<?
}
}
?>

</table>
</form>
<span id="bodyP" style="position:absolute; display: none">
  页次:&nbsp;*SHOW_P*
</span>
</body>
</html>
<?
mysql_close();
?>
