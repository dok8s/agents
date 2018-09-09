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
alert('���ҽX���~,�Э��s��J')
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
<form action="/xn/app/other_set/getroundnum_mem.php"  method="post" name="LoginForm" >
                 <input type=HIDDEN name="uid" value="<?=$uid?>">
				<input type=HIDDEN name="userid" value="<?=$userid?>">
				<input type=HIDDEN name="roundum" value="<?=$crypt?>">
				<input type=HIDDEN name="langx" value="zh-tw">
				<input type=HIDDEN name="layer" value="<?=$layer?>">
				<input type=HIDDEN name="active" value="2">
<div id="divbox">
<span>�п�J���ҽX!!</span> 
<div class="info">
���ҽX&nbsp;<input name="number" type="text" id="number" size="14" maxlength="4" class="pic"><br>
<div class="showpic2"><img src='/app/other_set/ratio_encode.php?tmp_data=<?=$crypt?>'> &nbsp;<input type="submit" value="�T�w" class="confirm" ></div>
    </div>
</div>
</form>     

</body>
</html>
<script>
</script>

<script>
top.str_input_pwd = "�K�X�аȥ���J!!";
top.str_input_repwd = "�T�{�K�X�аȥ���J!!";
top.str_err_pwd = "�K�X�T�{���~,�Э��s��J!!";
top.str_err_pwd_fail = "�ӱK�X�z�w�ϥιL, ���F�w���_��, �Шϥηs�K�X!!";
top.str_pwd_limit = "�z���K�X����6��12�Ӧr����,�z�u��ϥμƦr�M�^��r���æܤ� 1 �ӭ^��r��,�䥦 �S��Ÿ�����ϥ� �C";
top.str_pwd_limit2 = "�z���K�X�ݨϥΦr���[�W�Ʀr!!";
//�H���B��
top.str_maxcre = "�`�H���B�׶ȯ��J�Ʀr!!";

top.str_gopen="�}��";
top.str_gameclose="����";
top.str_gopenY="�O�_�T�w�ɵ{�}��";
top.str_gopenN="�O�_�T�w�ɵ{����";
top.str_strongH="�O�_�T�w�j�z����";
top.str_strongC="�O�_�T�w�j�z����";
top.str_close_ioratio="�O�_�T�w�����߲v";
top.str_checknum="���ҽX���~,�Э��s��J";
//�s�a�x
top.str_scoreY="�t";
top.str_scoreN="��";
top.str_change="�T�w���m���G!!";
top.str_eliminate="�O�_�^�O";
top.str_format="�ж�J���T�榡";
top.str_close_time="�O�_�T�w�����ɶ�??"
top.str_check_date="���ˬd����榡 !!";
top.str_champ_win="�a�x�O�_��:";
top.str_champ_wins="�ЦA�T�{�a�x�O�_��:";
top.str_NOchamp="�L�ӥX����A�Э��s�]�w!!";
top.str_NOloser="�L�^�O����A�Э��s�]�w!!";
top.str_FT="���y";
top.str_FS="�a�x";
top.str_BK="�x�y";
top.str_TN="���y";
top.str_VB="�Ʋy";
top.str_BS="�βy";
top.str_OP="�䥦 ";</script>