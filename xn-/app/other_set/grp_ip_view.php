<script>
var msg = '';
var grp_show = 'N';
</script>
<script>
top.str_FT = "���y";
top.str_FS = "�a�x";
top.str_BK = "�x�y";
top.str_TN = "���y";
top.str_VB = "�Ʋy";
top.str_BS = "�βy";
top.str_OP = "��L";

//�H���B��
top.str_maxcre = "�`�H���B�׶ȯ��J�Ʀr!!";

top.str_gopen = "�}��";
top.str_gameclose = "����";
top.str_gopenY = "�O�_�T�w�ɵ{�}��";
top.str_gopenN = "�O�_�T�w�ɵ{����";
top.str_strongH = "�O�_�T�w�j�z����";
top.str_strongC = "�O�_�T�w�j�z����";
top.str_close_ioratio = "�O�_�T�w�����߲v";
top.str_checknum = "���ҽX���~,�Э��s��J";

//�s�a�x
top.str_scoreY = "�t";
top.str_scoreN = "��";
top.str_change = "�T�w���m���G!!";
top.str_eliminate = "�O�_�^�O";
top.str_format = "�ж�J���T�榡";
top.str_close_time = "�O�_�T�w�����ɶ�??"
top.str_check_date = "���ˬd����榡 !!";
top.str_champ_win = "�a�x�O�_��:";
top.str_champ_wins = "�ЦA�T�{�a�x�O�_��:";
top.str_NOchamp = "�L�ӥX����A�Э��s�]�w!!";
top.str_NOloser = "�L�^�O����A�Э��s�]�w!!";

//�b��
top.str_co = "�ѪF";
top.str_su = "�`�N�z";
top.str_ag = "�N�z��";
top.str_input_account = "�b���Фť���J!!";
top.str_input_alias = "�W�ٽаȥ���J!!";
top.str_input_credit = "�H���B�׽аȥ���J!!";
top.str_confirm_add_su = "�O�_�T�w�g�J�`�N�z?";

//�K�X
top.str_input_pwd = "�K�X�аȥ���J!!";
top.str_input_repwd = "�T�{�K�X�аȥ���J!!";
top.str_input_pwd2 = top.str_input_pwd;
top.str_input_repwd2 = top.str_input_repwd;
top.str_pwd_limit = "�z���K�X����6��12�Ӧr����,�z�u��ϥμƦr�M�^��r���æܤ� 1 �ӭ^��r��,��L�S��Ÿ�����ϥ� �C";
top.str_pwd_limit2 = "�z���K�X�ݨϥΦr���[�W�Ʀr!!";
top.str_err_pwd = "�K�X�T�{���~,�Э��s��J!!";
top.str_err_pwd_fail = "�ӱK�X�z�w�ϥιL, ���F�w���_��, �Шϥηs�K�X!!";

//�p����}
top.dPrivate = "�p��";
top.dPublic = "����";
top.grep = "�s��";
top.grepIP = "�s��IP";
top.IP_list = "IP�C��";
top.Group = "�էO";
top.choice = "�п��";
top.webset="��T��";
</script>

<script>
function reload_table() {
	//alert("aaa===>"+grp_show);
	if (grp_show == "Y") {
		var shows = document.getElementById("showlayer").innerHTML; //=== �ĤG�h div
		var tr_data = document.getElementById("show_tr").innerHTML; //=== �ĤT�h div
		var AllLayer = ""; //=== �ĤT�h div
		var layers = "";
		AllLayer=Show_Data(tr_data);
		shows = shows.replace("*SHOWLIST*",AllLayer);
		shows = shows.replace("*WEBSET*",top.webset);
		show_table.innerHTML = shows;	
	}else{
		var no_data = document.getElementById("no_data").innerHTML;
		no_data = no_data.replace("*WEBSET*",top.webset);
		show_table.innerHTML = no_data;
	}
	
}
	
function Show_Data(layers){
	//layers = layers.replace('*MSG*',Chkarray[i][2]);
	layers = layers.replace('*MSG*',msg);
	return layers;
}


//����
var current = null;
function colorTRx(flag){
	if(flag==1 && current!=null){
		current.style.backgroundColor = current._background;
		current.style.color = current._font;
		current = null;
		return;
	}
	if ((self.event.srcElement.parentElement.rowIndex!=0) && (self.event.srcElement.parentElement.tagName=="TR") && (current!=self.event.srcElement.parentElement)) {
		if (current!=null){
			current.style.backgroundColor = current._background;
			current.style.color = current._font;
		}
		self.event.srcElement.parentElement._background = self.event.srcElement.parentElement.style.backgroundColor;
		self.event.srcElement.parentElement._font = self.event.srcElement.parentElement.style.color;
		self.event.srcElement.parentElement.style.backgroundColor = "#F5CE6C";
		self.event.srcElement.parentElement.style.color = "";
		current = self.event.srcElement.parentElement;
	}
}
</script>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title {  background-color: #86C0A6; text-align: center}
-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onload="reload_table();">
	<br>
<div id="show_table" ></div>
<div id="showlayer" style="display: none;">
	<table width="300" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" >
		<tr class="m_title">
			<td width="300" align="center">*WEBSET*</td>
		</tr>
		*SHOWLIST*
	</table>
<div>
<!-- �d�L��Ʈ� start -->
<div id="no_data" style="display: none;">
	<table align="center" width="300" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" >
		<tr class="m_title">
			<td width="300" align="center">*WEBSET*</td>
		</tr>
	</table>
</div>
<!-- �d�L��Ʈ� end -->

<div id="show_tr" style="display: none;">
	<tr onmouseover="colorTRx(0)" onmouseout="colorTRx(1)" class="m_cen" >
		<td>*MSG*</td>
	</tr>
</div>
</body>
</html>