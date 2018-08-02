<script>
var msg = '';
var grp_show = 'N';
</script>
<script>
top.str_FT = "足球";
top.str_FS = "冠軍";
top.str_BK = "籃球";
top.str_TN = "網球";
top.str_VB = "排球";
top.str_BS = "棒球";
top.str_OP = "其他";

//信用額度
top.str_maxcre = "總信用額度僅能輸入數字!!";

top.str_gopen = "開放";
top.str_gameclose = "關閉";
top.str_gopenY = "是否確定賽程開放";
top.str_gopenN = "是否確定賽程關閉";
top.str_strongH = "是否確定強弱互換";
top.str_strongC = "是否確定強弱互換";
top.str_close_ioratio = "是否確定關閉賠率";
top.str_checknum = "驗證碼錯誤,請重新輸入";

//新冠軍
top.str_scoreY = "負";
top.str_scoreN = "勝";
top.str_change = "確定重置結果!!";
top.str_eliminate = "是否淘汰";
top.str_format = "請填入正確格式";
top.str_close_time = "是否確定關閉時間??"
top.str_check_date = "請檢查日期格式 !!";
top.str_champ_win = "冠軍是否為:";
top.str_champ_wins = "請再確認冠軍是否為:";
top.str_NOchamp = "無勝出隊伍，請重新設定!!";
top.str_NOloser = "無淘汰隊伍，請重新設定!!";

//帳號
top.str_co = "股東";
top.str_su = "總代理";
top.str_ag = "代理商";
top.str_input_account = "帳號請勿必輸入!!";
top.str_input_alias = "名稱請務必輸入!!";
top.str_input_credit = "信用額度請務必輸入!!";
top.str_confirm_add_su = "是否確定寫入總代理?";

//密碼
top.str_input_pwd = "密碼請務必輸入!!";
top.str_input_repwd = "確認密碼請務必輸入!!";
top.str_input_pwd2 = top.str_input_pwd;
top.str_input_repwd2 = top.str_input_repwd;
top.str_pwd_limit = "您的密碼必須6至12個字元長,您只能使用數字和英文字母並至少 1 個英文字母,其他特殊符號不能使用 。";
top.str_pwd_limit2 = "您的密碼需使用字母加上數字!!";
top.str_err_pwd = "密碼確認錯誤,請重新輸入!!";
top.str_err_pwd_fail = "該密碼您已使用過, 為了安全起見, 請使用新密碼!!";

//私域網址
top.dPrivate = "私域";
top.dPublic = "公有";
top.grep = "群組";
top.grepIP = "群組IP";
top.IP_list = "IP列表";
top.Group = "組別";
top.choice = "請選擇";
top.webset="資訊網";
</script>

<script>
function reload_table() {
	//alert("aaa===>"+grp_show);
	if (grp_show == "Y") {
		var shows = document.getElementById("showlayer").innerHTML; //=== 第二層 div
		var tr_data = document.getElementById("show_tr").innerHTML; //=== 第三層 div
		var AllLayer = ""; //=== 第三層 div
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


//光棒
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
<!-- 查無資料時 start -->
<div id="no_data" style="display: none;">
	<table align="center" width="300" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" >
		<tr class="m_title">
			<td width="300" align="center">*WEBSET*</td>
		</tr>
	</table>
</div>
<!-- 查無資料時 end -->

<div id="show_tr" style="display: none;">
	<tr onmouseover="colorTRx(0)" onmouseout="colorTRx(1)" class="m_cen" >
		<td>*MSG*</td>
	</tr>
</div>
</body>
</html>