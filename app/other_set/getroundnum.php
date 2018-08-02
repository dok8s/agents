<?
$uid		=	$_REQUEST['uid'];
$layer	=	$_REQUEST['layer'];
$userid	=	$_REQUEST['userid'];
$number	=	$_REQUEST['number'];
$active	=	$_REQUEST['active'];
$roundum=	$_REQUEST['roundum'];

//echo $_SERVER[HTTP_REFERER];

$crypt=substr(strtoupper(md5(time())),9,8);

if($active==2){
	$code=substr(strtoupper(md5($roundum)),11,4);

	if($code==strtoupper($number)){
		echo "<script>
parent.ShowNumber(2,'yes','');
</script>";
		exit;
	}else{
		echo "<html><head><meta http-equiv='Content-Type' content=\"text/html; charset=gb2312\">
<script>
alert('验证码错误,请重新输入')
parent.ShowNumber(2,'no','');
</script>";
	}	

}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>singbet2</title>
<link href="/style/control/control_main.css" rel="stylesheet" type="text/css">
</head>
<body onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;" style="background:transparent">
<form action="/app/other_set/getroundnum.php"  method="post" name="LoginForm" >
                 <input type=HIDDEN name="uid" value="<?=$uid?>">
				<input type=HIDDEN name="userid" value="<?=$userid?>">
				<input type=HIDDEN name="roundum" value="<?=$crypt?>">
				<input type=HIDDEN name="langx" value="zh-tw">
				<input type=HIDDEN name="layer" value="<?=$layer?>">
				<input type=HIDDEN name="active" value="2">
<div id="divbox">
<span>请输入验证码!!</span> 
<div class="info">
验证码&nbsp;<input name="number" type="text" id="number" size="14" maxlength="4" class="pic"><br>
<div class="showpic2"><img src='/app/other_set/ratio_encode.php?tmp_data=<?=$crypt?>'> &nbsp;<input type="submit" value="确定" class="confirm" ></div>
    </div>
</div>
</form>     

</body>
</html>
<script>
</script>

<script>
top.str_input_pwd = "密码请务必输入!!";
top.str_input_repwd = "确认密码请务必输入!!";
top.str_err_pwd = "密码确认错误,请重新输入!!";
top.str_err_pwd_fail = "该密码您已使用过, 为了安全起见, 请使用新密码!!";
top.str_pwd_limit = "您的密码必须6至12个字元长,您只能使用数字和英文字母并至少 1 个英文字母,其它 特殊符号不能使用 。";
top.str_pwd_limit2 = "您的密码需使用字母加上数字!!";
//信用额度
top.str_maxcre = "总信用额度仅能输入数字!!";

top.str_gopen="开放";
top.str_gameclose="关闭";
top.str_gopenY="是否确定赛程开放";
top.str_gopenN="是否确定赛程关闭";
top.str_strongH="是否确定强弱互换";
top.str_strongC="是否确定强弱互换";
top.str_close_ioratio="是否确定关闭赔率";
top.str_checknum="验证码错误,请重新输入";
//新冠军
top.str_scoreY="负";
top.str_scoreN="胜";
top.str_change="确定重置结果!!";
top.str_eliminate="是否淘汰";
top.str_format="请填入正确格式";
top.str_close_time="是否确定关闭时间??"
top.str_check_date="请检查日期格式 !!";
top.str_champ_win="冠军是否为:";
top.str_champ_wins="请再确认冠军是否为:";
top.str_NOchamp="无胜出队伍，请重新设定!!";
top.str_NOloser="无淘汰队伍，请重新设定!!";
top.str_FT="足球";
top.str_FS="冠军";
top.str_BK="篮球";
top.str_TN="网球";
top.str_VB="排球";
top.str_BS="棒球";
top.str_OP="其它 ";</script>