<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
$date_start = $_REQUEST['date_start'];
$agents_id = $_REQUEST['agents_id'];
$uid = $_REQUEST['uid'];
$user = $_REQUEST['user'];
$level = $_REQUEST['level'];
if ( $level == "" )
{
	$level = 3;
}
$active = $_REQUEST['active'];
$sql = "select id,subuser,agname,subname,status,super,setdata from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit( );
}

$row = mysql_fetch_array($result);
$corprator=$row['agname'];
$super=$row['super'];
$d1set = @unserialize($row['setdata']);

$sql = "select setdata,d1edit from web_super where agname='$super'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$d0set = @unserialize($row['setdata']);
$d0set['d1_edit']=$row['d1edit'];
foreach($d1set as $k=>$v){
	if($v==1 && substr($k,0,2)=='d1'){
		$d1set[$k] = $d0set[$k];
	}
}
if($d1set['d1_mem_online_show']!=1){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>无权访问";
	exit;
}

$so_log_name=trim($_REQUEST['so_log_name']);
if($so_log_name){
	$sql = "SELECT username,level FROM web_mem_log WHERE username = '$so_log_name' LIMIT 1";
	$result=mysql_query( $sql);
	$row=mysql_fetch_array($result);
	if($row['username']){
		$url="showlog.php?uid=$uid&agents_id=$row[username]&level=$row[level]";
	}else{
		echo "<script>alert('没找到($so_log_name)的日志！');</script>";
		$url="syslog.php?uid=$uid";
	}
	echo "<script>self.location.href='$url';</script>";
	exit;
}

if ( $date_start == "" )
{
				$date_start = date( "m-d" );
}
if ( $active == 1 )
{
				$sql = "update web_agents set oid='',logintime='2008-01-01 12:00:00' where corprator='$corprator' and agname='".$user."'";
				mysql_query( $sql );
				$sql = "update web_world set oid='',logintime='2008-01-01 12:00:00' where corprator='$corprator' and agname='".$user."'";
				mysql_query( $sql );
				echo "<script language='javascript'>self.location='syslog.php?uid=".$uid."&level={$level}';</script>";
}

$sql = "select username,logtime,system,logip,context,level from web_mem_log where level='$level' and DATE_ADD(logtime, INTERVAL 20 MINUTE)>now() order by id desc";
$result = mysql_query( $sql ) or exit('error 21');
$rts=array();
$sqlarr=array();
$sqlarr[0] = "select domain from web_super where 1>2";
$sqlarr[1] = "select domain,super from web_corprator where 1>2";
$sqlarr[2] = "select domain,super,corprator from web_world where corprator='$corprator' and oid!='' and oid!='out'";
$sqlarr[3] = "select domain,super,corprator,world from web_agents where corprator='$corprator' and oid!='' and oid!='out'";
while( $row=mysql_fetch_array($result) ){
	if(!isset($rts[$row['username']])){
		$sql = $sqlarr[$row['level']]." and agname='$row[username]'";
		$query = mysql_query( $sql ) or exit('error 22');
		if(mysql_num_rows($query)>0){
			$rt=mysql_fetch_array($query);
			foreach($rt as $k=>$v){
				$row[$k]=$v;
			}
			$rts[$row['username']]=$row;
		}
	}
}

?>
<script>if(self == top) location='/'</script>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title></title>
<script>
<!--

 function onLoad()
 {
  var level = document.getElementById('level');
  level.value = '<?=$level?>';
 }

function Changlevl(){
  	var level = document.getElementById('level').value;
	self.location='syslog.php?uid=<?=$uid?>&level='+level;
}
function reload()
{
	var level = document.getElementById('level').value;
	self.location.href='syslog.php?uid=<?=$uid?>&level='+level;
}
function so_log()
{
	var so_log_name = document.getElementById('so_log_name').value;
	if(so_log_name!=''){
		self.location.href='syslog.php?uid=<?=$uid?>&so_log_name='+so_log_name;
	}
}
var limit='60'
if (document.images){
	var parselimit=limit
}
function beginrefresh(){
if (!document.images)
	return
if (parselimit==1)
	//var obj_agent = document.getElementById('agents_id');
	//alert(obj_agent.value);
	window.location.reload();
else{
	parselimit-=1
	curmin=Math.floor(parselimit)
	if (curmin!=0)
		curtime=curmin+'秒后自动更新！'
	else
		curtime=cursec+'秒后自动更新！'
		timeinfo.innerText=curtime
		setTimeout('beginrefresh()',1000)
	}
}

window.onload=beginrefresh
file://-->
</script>
<link rel='stylesheet' href='/style/control/control_main.css' type='text/css'>
</head>
<body _oncontextmenu='window.event.returnValue=false' bgcolor='#FFFFFF' text='#000000' leftmargin='0' topmargin='0' onLoad='onLoad();beginrefresh()'>
<form name="myFORM" method="post" action="" >
 <table width='773' border='0' cellspacing='0' cellpadding='0'>
    <tr>
      <td class='' width='746'>&nbsp;<font color='#CC0000'>代理日志</font>&nbsp;&nbsp;&nbsp; <input name=button type=button class='za_button' onclick='reload()' value='更新'>&nbsp;&nbsp;&nbsp;
	 <select name='level'  onChange="document.myFORM.submit();" class='za_select'>
            <option value='3'>代理商</option>
            <option value='2'>总代理</option>
            
          </select>
        <span id='timeinfo'></span> -- 20分钟内在线人数据(<?=count($rts)?>) -- 代理的历史日志:<INPUT TYPE="text" size=10 NAME="so_log_name"> <input name=button type=button onclick='so_log()' value='搜索'> -- <a href='javascript:history.go( -1 );'>回上一页</a>
      </td>
    </tr>
  </table>
  <table width='774' border='0' cellspacing='0' cellpadding='0'>
    <tr>
      <td width='774' height='4'></td>
    </tr>
    <tr>
      <td ></td>
    </tr>
  </table>

<table id='glist_table' border='0' cellspacing='1' cellpadding='0'  bgcolor='006255' class='m_tab' width='1030'>
  <tr class='m_title_ft'>
    <td align='middle' width='80'> 代理商名称</td>
    <td align='middle' width='130'>活动时间</td>
    <td align='right'  width='300'>活动内容</td>
    <td align='middle' width='140'>登陆IP/地区</td>
	<td align='middle' width='140'>网址</td>
	<td align='middle' width='140'>上级</td>
    <td align='middle' width='100'>操作</td>
  </tr>
<?
foreach($rts as $row){
	$up = join(' / ', array('',$row['corprator'],$row['world']));
	echo "
	<tr class='m_cen'>
	<td width='83'>$row[username]</td>
    <td> <font color='#CC0000'>$row[logtime]</font> </td>
    <td>$row[context]</td>
	<td><a href='http://ip138.com/ips138.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a> </td>
	<td>$row[domain]</td>
	<td>$up</td>
    <td width='120' align=center><a href='showlog.php?uid=$uid&agents_id=$row[username]&level=$level'>查看日志</a>
    / <a href='./syslog.php?uid=$uid&active=1&user=$row[username]&level=$row[level]'>踢线</a></td>
	</tr>
	";
}
echo "</table>\r\n</form></body>\r\n</html>\r\n";



	$loginfo='查看代理在线';
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$corprator',now(),'$loginfo','$ip_addr','1')";
	mysql_query($mysql);
?>
