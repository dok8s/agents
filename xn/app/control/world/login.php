<?
Session_start();
require ("../../member/include/config.inc.php");
require_once('../../member/include/define_function_list.inc.php');
$langx=$_REQUEST['langx'];
$str = time();

$langx=$_REQUEST['langx'];
$uid=$_REQUEST['uid'];
if ($uid==''){
	$uid=substr(md5($str),0,14);
}
if ($langx==''){
	$langx="zh-cn";
}

$username=$_REQUEST["username"];
$password=substr(md5(md5($_REQUEST["passwd"]."abc123")),0,16);
$passwd_safe=$_REQUEST["passwd_safe"];

$sql = "select Agname from `web_world` where Agname ='$username' and Passwd='$password' and passwd_safe=''";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou>0){	
	echo "<SCRIPT language='javascript'>self.location='account/chg_passwd_safe.php?username=$username&password=$password&langx=$langx';</script>";
	exit;
}

$sql = "select id,if(time_to_sec(timediff(now(),if(logintime='0000-00-00 00:00:00','2007-12-01 12:00:00',logintime)))>180,0,1) as timeout from `web_world` where Agname='$username' and Passwd='$password' and passwd_safe='$passwd_safe' and (Status=1 or Status=2)";
$result = mysql_query($sql);
$count=mysql_num_rows($result);

if ($count==0){
	echo "<script>alert('LOGIN ERROR!!\\nPlease check username/passwd and try again!!');window.open('/index.php','_top')</script>";
	exit;
}else{
	$row = mysql_fetch_array($result);
	$uid=$uid.'l'.$row['id'];
	
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		$sql="update web_world set oid='$uid',logintime=now(),domain='$_SERVER[HTTP_HOST]',language='zh-cn',logip='$ip_addr' where Agname='".$username."'";
		mysql_query($sql) or die ("操作失败!");
		 	$tu=rand(13455150,83459150);
             $_SESSION["sksk"]=$tu;
		$loginfo='用户登入成功';
		$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$username',now(),'$loginfo','$ip_addr','2')";
		mysql_query($mysql);
		show_message('d2:'.$username);
	echo '<script>
top.user_id = \''.$uid.'\';
top.flash_cont_cutoff = \'Y\';top.flash_cont_flag = \'300\';top.langx = \'zh-tw\';
</script>
<html>
<head>
<title>登入1</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<frameset rows="51,*,0" frameborder="NO" border="0" framespacing="0">
<frame name="topFrame" scrolling="NO" noresize src="header.php?langx=zh-tw&uid='.$uid.'">
<frame name="main" src="body_home.php?langx=zh-tw&uid='.$uid.'">
<frame name="swfFrame" scrolling="NO" noresize src="../../../tpl/FlashContent.html">
</frameset>
<noframes>
<body bgcolor="#FFFFFF" text="#000000" oncontextmenu="window.event.returnValue=false">
</body>
</noframes>
</html>';
	
}

?>
