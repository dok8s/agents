<?
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");

$password_safe = $_REQUEST['password_safe'];
$username	=	$_REQUEST['username'];
$password	=	$_REQUEST['password'];
$langx		=	$_REQUEST['langx'];
$action		=	$_REQUEST['action'];

if($action==1){
	
	$sql = "select id from web_corprator where Agname='$username' and passwd = '$password'";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		show_error("密码错误,请重新输入");
		exit;
	}
		$sql="update web_corprator set passwd_safe='$password_safe' where Agname='$username' and passwd = '$password'";
		mysql_query($sql);
		
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		echo "<script>alert('已成功设置安全代码~~请回重新登入');self.location='/index.php';</script>";
	exit;
}

function show_error($errstring){
	echo '
<html>
<head>
<title>error</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<style>
<!--
body { text-align:center; background-color:#535E63;}
div { width:230px; font:12px Arial, Helvetica, sans-serif; border:1px solid #333; margin:auto;}
p { color:#C00; background-color:#CCC; margin:0; padding:15px 6px;}
h1 { font-size:1.2em; margin:0; padding:4px; background-color:#000; color:#FFF;letter-spacing: 0.5em;}
span { display:block; background-color:#A0A0A0; padding:4px; margin:0;}
a:link, a:visited {  color: #FFF; text-decoration: none;}
a:hover {  color: #FF0}
-->
</style>
</head>
<body>

<div>
  <h1>错误讯息</h1>
  <p>'.$errstring.'</p>

  <span><a href="javascript:history.go(-1)">&raquo; 回上一页</a></span>  
</div>

</body>
</html>
';
}
?>

<html>
<head>
<title>设置安全代码</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/safe.css" type="text/css">
<style type="text/css">
<!--
iframe { width:0; height:0; border:0; clear:right;}
-->
</style>
</head>
<script language="JavaScript" src="/js/zh-tw-password_safe.js" type="text/javascript"></script>
<script language="JavaScript" src="/js/chg_long_id.js" type="text/javascript"></script>
<script>
var passwd = '<?=$password?>';
var langx='zh-tw';
</script>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" id="PWD">
<table width="450" border="0" align="center" cellpadding="1" cellspacing="1" class="pwd_side">
	<tr class="pwd_bg">
		<td colspan="2">
			<table border="0" cellpadding="1" cellspacing="1">
			  	<tr>
			  		<td width="450" class="pwd_title">设置安全代码</td>
			  	</tr>
		 	</table>
	 	</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
			请使用阁下容易记得的名字或代号设定<font class="red_txt">「安全代码」</font>以供登入使用。
		</td>
	</tr>
	<tr>
		<td colspan="2" class="pwd_txt">
			设置规则 : 必须有2个英文大小写字母和数字(0~9)组合输入限制(6~12字元)
			<br>例：oicq888 , england228 , tudou668 , soccer2009 , 888yahoo等...简易的名字或代号，皆可依照您所喜好设置。

		</td>
	</tr>	
	<form name="ChgPwdForm" method="post">
		<tr>		
			<td width="100"align="right"   class="pwd_txt" >安全代码</td>
			<td width="350"class="pwd_txt">
				<input type="TEXT" name="password_safe" value="" size=12 maxlength=12 class="za_text_02">
				<font class="red_txt">注意：</font>设置后将无法修改。
			</td>
		</tr>
		<tr >
			<td colspan="2" align="center"  class="pwd_bg">
				<input type="button" value="确认" onClick="return SubChk();" class="za_button_01">&nbsp;
				<input type="button" name="cancel" value="取消" class="za_button_01" onClick="javascript:history.go(-2);">
				<input type="hidden" name="action" value="1">
				<input type="hidden" name="uid" value="<?=$uid?>">
				<input type="hidden" name="username" value="<?=$username?>">
				<input type="hidden" name="password" value="<?=$password?>">
			</td>
		</tr>
	</form>
</table>
<iframe id="getData"></iframe>
</body>
</html>
