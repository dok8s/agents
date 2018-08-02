<?
$uid		=	$_REQUEST['uid'];
$layer	=	$_REQUEST['layer'];
$userid	=	$_REQUEST['userid'];
$number	=	$_REQUEST['number'];
$active	=	$_REQUEST['active'];
$roundum=	$_REQUEST['roundum'];

$crypt=substr(strtoupper(md5(time())),9,8);

if($active==2){
	$code=substr(strtoupper(md5($roundum)),11,4);

	if($code==strtoupper($number)){
		echo "<script>
parent.ShowNumber(2,'yes');
</script>";
	}else{
		echo "<html><head><meta http-equiv='Content-Type' content=\"text/html; charset=big5\">
<script>
alert('驗證碼錯誤,請重新輸入')
parent.ShowNumber(2,'no');
</script>";

	}	

}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Big5">
<title>singbet2</title>
<link href="/style/control/control_main.css" rel="stylesheet" type="text/css">
</head>
<body onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;" style="background:transparent">
<form action="/app/other_set/getroundnum_mem.php"  method="post" name="LoginForm" >
                 <input type=HIDDEN name="uid" value="<?=$uid?>">
				<input type=HIDDEN name="userid" value="<?=$userid?>">
				<input type=HIDDEN name="roundum" value="<?=$crypt?>">
				<input type=HIDDEN name="langx" value="zh-tw">
				<input type=HIDDEN name="layer" value="<?=$layer?>">
				<input type=HIDDEN name="active" value="2">
<div id="divbox">
<span>請輸入驗證碼!!</span> 
<div class="info">
驗證碼&nbsp;<input name="number" type="text" id="number" size="14" maxlength="4" class="pic"><br>
<div class="showpic2"><img src='/app/other_set/ratio_encode.php?tmp_data=<?=$crypt?>'> &nbsp;<input type="submit" value="確定" class="confirm" ></div>
    </div>
</div>
</form>     

</body>
</html>
<script>
</script>

<script>
top.str_input_pwd = "密碼請務必輸入!!";
top.str_input_repwd = "確認密碼請務必輸入!!";
top.str_err_pwd = "密碼確認錯誤,請重新輸入!!";
top.str_err_pwd_fail = "該密碼您已使用過, 為了安全起見, 請使用新密碼!!";
top.str_pwd_limit = "您的密碼必須6至12個字元長,您只能使用數字和英文字母並至少 1 個英文字母,其它 特殊符號不能使用 。";
top.str_pwd_limit2 = "您的密碼需使用字母加上數字!!";
//信用額度
top.str_maxcre = "總信用額度僅能輸入數字!!";

top.str_gopen="開放";
top.str_gameclose="關閉";
top.str_gopenY="是否確定賽程開放";
top.str_gopenN="是否確定賽程關閉";
top.str_strongH="是否確定強弱互換";
top.str_strongC="是否確定強弱互換";
top.str_close_ioratio="是否確定關閉賠率";
top.str_checknum="驗證碼錯誤,請重新輸入";
//新冠軍
top.str_scoreY="負";
top.str_scoreN="勝";
top.str_change="確定重置結果!!";
top.str_eliminate="是否淘汰";
top.str_format="請填入正確格式";
top.str_close_time="是否確定關閉時間??"
top.str_check_date="請檢查日期格式 !!";
top.str_champ_win="冠軍是否為:";
top.str_champ_wins="請再確認冠軍是否為:";
top.str_NOchamp="無勝出隊伍，請重新設定!!";
top.str_NOloser="無淘汰隊伍，請重新設定!!";
top.str_FT="足球";
top.str_FS="冠軍";
top.str_BK="籃球";
top.str_TN="網球";
top.str_VB="排球";
top.str_BS="棒球";
top.str_OP="其它 ";</script>