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
alert('��֤�����,����������')
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
<form action="/xn/app/other_set/getroundnum.php"  method="post" name="LoginForm" >
                 <input type=HIDDEN name="uid" value="<?=$uid?>">
				<input type=HIDDEN name="userid" value="<?=$userid?>">
				<input type=HIDDEN name="roundum" value="<?=$crypt?>">
				<input type=HIDDEN name="langx" value="zh-tw">
				<input type=HIDDEN name="layer" value="<?=$layer?>">
				<input type=HIDDEN name="active" value="2">
<div id="divbox">
<span>��������֤��!!</span> 
<div class="info">
��֤��&nbsp;<input name="number" type="text" id="number" size="14" maxlength="4" class="pic"><br>
<div class="showpic2"><img src='/xn/app/other_set/ratio_encode.php?tmp_data=<?=$crypt?>'> &nbsp;<input type="submit" value="ȷ��" class="confirm" ></div>
    </div>
</div>
</form>     

</body>
</html>
<script>
</script>

<script>
top.str_input_pwd = "�������������!!";
top.str_input_repwd = "ȷ���������������!!";
top.str_err_pwd = "����ȷ�ϴ���,����������!!";
top.str_err_pwd_fail = "����������ʹ�ù�, Ϊ�˰�ȫ���, ��ʹ��������!!";
top.str_pwd_limit = "�����������6��12����Ԫ��,��ֻ��ʹ�����ֺ�Ӣ����ĸ������ 1 ��Ӣ����ĸ,���� ������Ų���ʹ�� ��";
top.str_pwd_limit2 = "����������ʹ����ĸ��������!!";
//���ö��
top.str_maxcre = "�����ö�Ƚ�����������!!";

top.str_gopen="����";
top.str_gameclose="�ر�";
top.str_gopenY="�Ƿ�ȷ�����̿���";
top.str_gopenN="�Ƿ�ȷ�����̹ر�";
top.str_strongH="�Ƿ�ȷ��ǿ������";
top.str_strongC="�Ƿ�ȷ��ǿ������";
top.str_close_ioratio="�Ƿ�ȷ���ر�����";
top.str_checknum="��֤�����,����������";
//�¹ھ�
top.str_scoreY="��";
top.str_scoreN="ʤ";
top.str_change="ȷ�����ý��!!";
top.str_eliminate="�Ƿ���̭";
top.str_format="��������ȷ��ʽ";
top.str_close_time="�Ƿ�ȷ���ر�ʱ��??"
top.str_check_date="�������ڸ�ʽ !!";
top.str_champ_win="�ھ��Ƿ�Ϊ:";
top.str_champ_wins="����ȷ�Ϲھ��Ƿ�Ϊ:";
top.str_NOchamp="��ʤ�����飬�������趨!!";
top.str_NOloser="����̭���飬�������趨!!";
top.str_FT="����";
top.str_FS="�ھ�";
top.str_BK="����";
top.str_TN="����";
top.str_VB="����";
top.str_BS="����";
top.str_OP="���� ";</script>