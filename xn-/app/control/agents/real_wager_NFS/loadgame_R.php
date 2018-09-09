<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select Agname,ID,language from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx='zh-cn';
require ("../../../member/include/traditional.$langx.inc.php");
?>

<html>
<head>
<title>�ھ�</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv='Page-Exit' content='revealTrans(Duration=0,Transition=5)'>
<!--link href="/style/control/control_body_fs.css" rel="stylesheet" type="text/css"-->
<script>top.base_url='uid=<?=$uid?>&username=<?=$agname?>&langx=zh-tw';
top.uid='<?=$uid?>';
top.aid='<?=$agid?>';
top.username='<?=$agname?>';
top.langx='zh-cn';
</script><script>

var Showtypes="R";
var ordersFS=new Array();
var keep_rs_windows="";
var se="90";
var sessions="2";
var keep_action1="";

var Ratio=new Array();
function showgame_table(){
init();
start_time=get_timer();
	var AllLayer="";
	var layers="";
	var shows=showlayers.innerHTML;
	var tr_data=document.getElementById('glist').innerHTML;
	document.getElementById('gsdate').value=top.gsdate;
	document.getElementById('gedate').value=top.gedate;
	doings="";

	for (i=0;i<gamount;i++){
		gid=GameFT[i][0];
		AllLayer+=layer_screen(gid,tr_data);

	}

	showgames.innerHTML=shows.replace("*ShowGame*",AllLayer);

	play_sound();
}
function layer_screen(gid,layers){
	//��������Ƿ��б䶯
	changeRatio=check_ratio(gid).split(",");
	//changeRatio[] [1=�䶯] 0:R_con  1:RH_Ratio 2:RH_Ratio 3:OU_con  4:OUH_Ratio 2:OUC_Ratio

		gno=gidx[gid];
		//GameFT[gno][4]=GameFT[gno][4].replace("[H]",top.str_home).replace("[M]",top.str_mid);
		layers=layers.replace("*GID*",GameFT[gno][0]);/*gid*/
		layers=layers.replace("*GID*",GameFT[gno][0]);/*gid*/
		layers=layers.replace("*TIME*",change_time(GameFT[gno][1]));/*Khi*/

		layers=layers.replace("*LEG*",GameFT[gno][2]);/*����*/
		layers=layers.replace("*ITEM*",GameFT[gno][3]); /*����*/
		//layers=layers.replace("*TEAM_H*",GameFT[gno][4]);/*����*/
		//layers=layers.replace("*TEAM_C*",GameFT[gno][5]);/*�Ͷ�*/
		//layers=layers.replace("*R_TODAY*",GameFT[gno][0]);


		if (GameFT[gno][4]=="N"){
			layers=layers.replace("*CLASS*",'bgcolor=#cccccc');
			TBG='bgcolor="#cccccc"';
			layers=layers.replace("*GOPEN*","<font color='blue' style='cursor:hand;' onclick=\"if (check_fl("+gid+",'6')) return;change_game('gopen','Y',"+gid+",'"+se+"');\">"+top.str_gopen+"</font>");/*����*/
		}else{
			layers=layers.replace("*CLASS*",'bgcolor=#ffffff');
			TBG='bgcolor="#ffffff"';
			layers=layers.replace("*GOPEN*","<font color='blue' style='cursor:hand;' onclick=\"if (check_fl("+gid+",'6')) return;change_game('gopen','N',"+gid+",'"+se+"');\">"+top.str_gameclose+"</font>");/*�ر�*/
		}
		if (GameFT[gno][5]*1 > 0){
			if (GameFT[gno][6]=="0"){
				layers=layers.replace("*FL_SET*"," | <font style='cursor:hand;' color='red' onclick=change_game('FL_enable','1',"+gid+",'"+se+"')>"+top.str_FL+"</font>");/*����*/
			}else{
				layers=layers.replace("*FL_SET*"," | <font style='cursor:hand;' onclick=change_game('FL_enable','0',"+gid+",'"+se+"')>"+top.str_cancel+"</font>");/*ȡ��*/
			}
		}else{
			layers=layers.replace("*FL_SET*","");
		}

		zero="";
		if (""+ordersFS[gid]=="undefined"){
			for (s=0;s<GameFT[gno][7];s++){
				zero+=",'0'";
			}
			//alert ("zero="+zero);
			eval("ordersFS[gid]=new Array(gid"+zero+")");
		}
		backgrounds="";
		//backgrounds=getcolor(changeRatio,2);
		tabledata='<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" class="line" >';

		teamdata=tabledata;
		teamdata_R=tabledata;
		result=tabledata;
		orders=tabledata;
		outorders=tabledata;
		advantage = 0;

		if (GameFT[gno][7]*1>0){
			for (k=0;k<GameFT[gno][7];k++){
				//�������̭,������Ҫ����-1
				sellgold=1;

				if (GameFT[gno][8+k*5]=="N"){
					tableBG=TBG;
					teamdata+="<tr "+tableBG+"><td class='w_bg2'>"+GameFT[gno][10+k*5]+"</td></tr>";
					result+="<tr "+tableBG+"><td class='w_bg'>&nbsp;</td></tr>";
					backgrounds=getcolor(changeRatio,k);
					teamdata_R+="<tr "+tableBG+" ><td class='w_bg'><font color=blue >"+printf(GameFT[gno][12+k*5],2)+"</font></td></tr>";
				}else{
					tableBG='bgcolor="#99CCFF"';

					teamdata+="<tr "+tableBG+"><td class='w_bg2'>"+GameFT[gno][10+k*5]+"</td></tr>";
					result+="<tr "+tableBG+"><td class='w_bg'>+</td></tr>";
					teamdata_R+="<tr "+tableBG+"><td class='w_bg'>"+printf(GameFT[gno][12+k*5],2)+"</td></tr>";
					sellgold=-1;
				}
				order_pos=3*k;
				if (""+ordersFS[gid][order_pos+1]=="undefined") ordersFS[gid][order_pos+1]='0';
				if (""+ordersFS[gid][order_pos+2]=="undefined") ordersFS[gid][order_pos+2]='0';
				if (""+ordersFS[gid][order_pos+3]=="undefined") ordersFS[gid][order_pos+3]='0';
				orders+="<tr "+tableBG+"><td class='w_bg'><a target=_blank href='../real_wager_NFS/FS_list_bet.php?"+top.base_url+"&type=DT&gtype=FS&aid="+top.aid+"&wtype=FS&tid="+(GameFT[gno][11+k*5])+"&rtype="+(GameFT[gno][9+k*5])+"&gid="+gid+"'><font color='#CC0000'>"+ordersFS[gid][order_pos+1]+ "/" + parseInt(ordersFS[gid][order_pos+2])+"</font></a></td></tr>";
				outorders+="<tr "+tableBG+"><td class='w_bg'><font color=#808080>"+(parseInt(ordersFS[gid][order_pos+3])*sellgold)+"</font></td></tr>";
				if (printf(GameFT[gno][12+k*5],2)>0){
					advantage += (100 / GameFT[gno][12+k*5]);
				}else{
					advantage += 0;
				}
			}


		}
		//teamdata+="</table>";
		teamdata  +="</table>";
		teamdata_R+="</table>";
		result    +="</table>";
		orders    +="</table>";
		outorders +="</table>";

		//alert(teamdata)

		//layers=layers.replace("*SET*",'<A HREF=\"javascript:\" onClick=\"window.open(\'../game_set/game_ctl_FS.php?gtype=FS&uid='+top.uid+'&gid='+gid+'\');\">'+top.str_set+'</A>');

		//layers=layers.replace("*ADVANTAGE*",(Math.round((advantage*100)+0.001))/100);
		//
		layers=layers.replace("*TEAM*",teamdata);
		layers=layers.replace("*OUT*",result);
		layers=layers.replace("*IORATIO*",teamdata_R);
		layers=layers.replace("*ORDERS*",orders);
		layers=layers.replace("*OUT_ORDER*",outorders);

		//layers=layers.replace("*RESULT*","<font color='blue' style='cursor:hand;' onclick=\"chk_result('"+gno+"');\">"+top.str_result+"</font>");/*����*/


	return layers;
}
function getcolor(changeRatio,Rpos){
	if (changeRatio[Rpos]=="1"){
		backgrounds=" style='background-color:yellow' ";
	}else{
		 backgrounds="";
	}
	return backgrounds;
	}
//�������
function check_ratio(gid){

	gnos=gidx[gid];
	var changes="";
	if (""+Ratio[gid]=="undefined"){
		Ratio[gid]=new Array();
		}
	for (u=0;u<(GameFT[gnos][7]+1);u++){
		if (""+Ratio[gid][u]!="undefined"){
			if (Ratio[gid][u]!=GameFT[gnos][11+u*5]){
				changes+="1,";
				top.sound=true;
			}else changes+="0,";
		}else changes+="0,";
	eval("Ratio[gid]["+u+"]=GameFT[gnos]["+(11+u*5)+"];");
	}
	return changes;
}




function change_ratio(gid,rtype,pos,result){
	//alert(document.getElementById('rs_form').action)
	//alert(document.getElementById('pages').value)

	gno=gidx[gid];
	if (check_sel(gid)==false) return;
	rs_window.style.visibility="visible";
	show_xy();
	var tmp_data=(GameFT[gno][3]).split("<br>");
	document.getElementById('gid').value=gid;
	document.getElementById('rtype').value=rtype;

	document.getElementById('league_id').value=top.sel_league;
	document.getElementById('area_id').value=top.sel_area;
	document.getElementById('item_id').value=top.sel_item;
	document.getElementById('result').value=result;
	document.getElementById('r_title').innerHTML="("+(GameFT[gno][2])+"-"+tmp_data[0]+")<br>"+GameFT[gno][pos-2];
	document.getElementById('ioratio').value=printf(GameFT[gno][pos],2);
	document.getElementById('ioratio').focus();
	document.getElementById('ioratio').select();
}


function edit(change){
	document.getElementById('ioratio').value=printf(Math.round((document.getElementById('ioratio').value*1+change*1)*1000)/1000,2);
	if ((document.getElementById('ioratio').value)<0){
	document.getElementById('ioratio').value=printf(Math.round((document.getElementById('ioratio').value*1-change*1)*1000)/1000,2);
	}
}
/*
function edit(change){
document.getElementById('ioratio').value=printf(Math.round((document.getElementById('ioratio').value*1+change*1)*1000)/1000,3);

}
*/
function Chk_ratio(){
	//alert(document.getElementById('rs_form').action)
	//alert(document.getElementById('pages').value)
//	gno=gidx[document.getElementById('gid').value*1];
	//alert(document.getElementById('rtype').value);
	//alert(GameFT[gno][10]*1+"=="+document.getElementById('ioratio').value*1);
//	if (document.getElementById('rtype').value=='MH')
//	   if (GameFT[gno][10]*1==document.getElementById('ioratio').value*1) return false;
//	if (document.getElementById('rtype').value=='MC')
//	   if (GameFT[gno][11]*1==document.getElementById('ioratio').value*1) return false;
//	if (document.getElementById('rtype').value=='MN')
//	   if (GameFT[gno][12]*1==document.getElementById('ioratio').value*1) return false;



return true;

}
//function key_result(gid,rtype,result,pos){
function key_result(resultFrom){
	var tt=document.getElementById('rs_form');
	rs_window.style.visibility="hidden";
	a=confirm("sure!!");
	if (a==true){
		var gid=tt.gid.value;
		var rtype=tt.rtype.value;
		var result = "Y";
		var url_str = "FS_eliminate.php?"+get_pageparam()+"&gid="+gid+"&result="+result+"&rtype="+rtype+"&ShowType="+Showtypes;
		self.location = url_str;
	}
}


function gtype_close(){
str_close=top.str_close_ioratio;/*�Ƿ�ȷ���ر�����*/
a=confirm(str_close);
	if (a==true){
		grtypes="";
		gratios="0";
		//if (document.getElementById('rtype').value.substring(0,2)=="FS"){
			for (k=0;k<GameFT[gno][7];k++){
				//if (k<10)  grtypes+="FS0"+k;
				//else grtypes+="FS"+k;
				grtypes+=(GameFT[gno][9+k*5]);
				gratios+="0";
				if (k!=(GameFT[gno][7]-1)){
					grtypes+=",";
					gratios+=",";
					}
			}
			//alert("rtype"+grtypes+",00="+gratios);

		document.getElementById('rtype').value=grtypes;
		//}
		document.getElementById('ioratio').value=gratios;


		rs_form.submit();
	}
}
function check_sel(gid){
	return true;
	//return check_fl(gid,13);
	}
//�Զ��ر�
function openWin(obj_Name,gid){
	var obj = document.getElementById(obj_Name);
	obj.style.display = "block";
	obj.style.top = document.body.scrollTop+event.clientY+15;
	obj.style.left = document.body.scrollLeft+event.clientX-20;
	document.getElementById('AutoGid').value = gid;
	var tmp = dt_now.split(" ");
	document.getElementById('setDate').value = tmp[0];
	document.getElementById('setTime').value = tmp[1].substr(0,5);
}
function close_win(cw){
	document.all[cw].style.display = "none";
}
function check(forms){
	var D;
	var T;
	var C = new Array();
	var OK = true;
	if((D = forms.setDate.value) ==""){
		OK = false;
	}

	C = D.split("-");
	if(C.length != 3){
		OK = false;
	}

	if((T = forms.setTime.value) ==""){
		OK = false;
	}
	C = T.split(":");
	if(C.length != 2){
		OK = false;
	}

	if(!OK){
		alert("��������ȷ��ʽ");
		return OK;
	}
	forms.uid.value = top.uid;
	forms.gsdate1.value = document.getElementById('gsdate').value;
	forms.gedate1.value = document.getElementById('gedate').value;
	if(!confirm("�Ƿ�ȷ���ر�Khi??")){
		return false;
	}
	var obj = document.getElementById('AutoClose');
	obj.style.display = "none";
	return OK;
}

function chgDate() {

	var gsdate = document.getElementById('gsdate').value;
	var gedate = document.getElementById('gedate').value;

	var tmpFlag = true;
	var tmpGS = gsdate.split('-');
	var tmpGE = gedate.split('-');

	if(!chkCurrentDate(gsdate) || !chkCurrentDate(gedate)) tmpFlag = false;

	// �ж���ʼ�����Ƿ�С����ֹ����
	if(tmpGS[0]*1 > tmpGE[0] *1) tmpFlag = false;
	else if(tmpGS[0]*1 == tmpGE[0]*1 && tmpGS[1]*1 > tmpGE[1]*1) tmpFlag = false;
	else if(tmpGS[1]*1 == tmpGE[1]*1 && tmpGS[2]*1 > tmpGE[2]*1) tmpFlag = false;

	if(!tmpFlag) {alert(top.str_check_date); return false;}

	homepage="reloadgame_R.php?"+get_pageparam()+"&gsdate="+gsdate+"&gedate="+gedate;
	//alert(homepage);
	reloadPHP.location.href=homepage;

}
// �ж��Ƿ�Ϊ��ȷ�����ڸ�ʽ
function chkCurrentDate(val){
	var mydate = val.split("-");
	var year = mydate[0] % 4;	// ȡ���Ƿ�����
	var month = mydate[1];		// ȡ����
	var day = mydate[2];		// ȡ����

	if(mydate[0].length != 4) return false;
	if(month > 12 || month == 0 || day == 0) {return false;}
	if(month == 4 || month == 6 || month == 9 || month == 11) {
		if(day>30) return false;
		else return true;
	} else if(month==2) {
		if(year == 0 && day > 29) return  false;  // ����
		else if(year !=0 && day > 28) return false;
		else return true;
	} else {
		if(day>31) return  false;
		else return  true;
	}
}

function chg_gtype(gtype){
	top.show_gtype=gtype;
	top.sel_league="";
	reload_var();
}



function chg_league(){
	var obj_league = document.getElementById('sel_lid');
	sel_league=obj_league.value;
	top.sel_league=sel_league;
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	//alert(homepage);
	reloadPHP.location.href=homepage;

}

function ShowLeague(lid){
	bowling_data = "";
	var temp = "";
	var temparray = new Array();
	var bowling = document.getElementById("bowling");
	var bodyH = document.getElementById("bodyH");
	var show_h = document.getElementById("show_h");
	var tempbowling = bowling.innerHTML;
	txt_bodyH = bodyH.innerHTML;
	if(totaldata != '') {
		bowling_data = totaldata.split(",");
		for(i=1; i<bowling_data.length; i++) {
			temparray = bowling_data[i].split("*");
			txt_bowling = tempbowling.replace("*LEAGUE_ID*",temparray[0]);
			if(lid == temparray[0]) txt_bowling = txt_bowling.replace("*SELECT*","SELECTED");
			else txt_bowling = txt_bowling.replace("*SELECT*","");
			txt_bowling = txt_bowling.replace("*LEAGUE_NAME*",temparray[1]);
			temp += txt_bowling;
		}
		txt_bodyH = txt_bodyH.replace("*SHOW_H*",temp);
	} else {
		txt_bodyH =txt_bodyH.replace("*SHOW_H*","");
	}
	sel_leg.innerHTML=txt_bodyH;
}

//===ѡ������===
function chg_area(){
	var obj_area = document.getElementById('sel_aid');
	sel_area=obj_area.value;
	top.sel_area=sel_area;
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	//alert(homepage);
	reloadPHP.location.href=homepage;

}

function ShowArea(aid){
	area_data = "";
	var temp = "";
	var temparray = new Array();
	var area = document.getElementById("area");
	var bodyA = document.getElementById("bodyA");
	var show_a = document.getElementById("show_a");
	var temparea = area.innerHTML;
	txt_bodyA = bodyA.innerHTML;
	if(areasarray != '') {
		area_data = areasarray.split(",");
		for(i=1; i<area_data.length; i++) {
			temparray = area_data[i].split("*");
			txt_area = temparea.replace("*AREA_ID*",temparray[0]);
			if(aid == temparray[0]) txt_area = txt_area.replace("*SELECT_AREA*","SELECTED");
			else txt_area = txt_area.replace("*SELECT_AREA*","");
			txt_area = txt_area.replace("*AREA_NAME*",temparray[1]);
			temp += txt_area;
		}
		txt_bodyA = txt_bodyA.replace("*SHOW_A*",temp);
	} else {
		txt_bodyA =txt_bodyA.replace("*SHOW_A*","");
	}
	sel_areas.innerHTML=txt_bodyA;
}

//===ѡ�����===
function chg_item(){
	var obj_item = document.getElementById('sel_itemid');
	sel_item=obj_item.value;
	top.sel_item=sel_item;
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	//alert(homepage);
	reloadPHP.location.href=homepage;

}

function ShowItem(FS_items){
	item_data = "";
	var temp = "";
	var temparray = new Array();
	var item = document.getElementById("item");
	var bodyI = document.getElementById("bodyI");
	var show_i = document.getElementById("show_i");
	var tempitem = item.innerHTML;
	txt_bodyI = bodyI.innerHTML;
	if(itemsarray != '') {
		item_data = itemsarray.split(",");
		for(i=1; i<item_data.length; i++) {
			temparray = item_data[i].split("*");
			txt_item = tempitem.replace("*ITEM_ID*",temparray[0]);
			if(FS_items == temparray[0]) txt_item = txt_item.replace("*SELECT_ITEM*","SELECTED");
			else txt_item = txt_item.replace("*SELECT_ITEM*","");
			txt_item = txt_item.replace("*ITEM_NAME*",temparray[1]);
			temp += txt_item;
		}
		txt_bodyI = txt_bodyI.replace("*SHOW_I*",temp);
	} else {
		txt_bodyI =txt_bodyI.replace("*SHOW_I*","");
	}
	sel_items.innerHTML=txt_bodyI;
}

function chk_result(arr_idx)
{
	 return false;
}
function chg_account(set_account){
	//alert(set_account);
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam()+"&set_account="+set_account;
	reloadPHP.location.href=homepage;
}
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

//�¹ھ�
top.str_scoreY="��";
top.str_scoreN="ʤ";
top.str_change="ȷ�����ý��!!";
top.str_eliminate="�Ƿ���̭";
top.str_format="��������ȷ��ʽ";
top.str_close_time="�Ƿ�ȷ���ر�Khi??"
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
top.str_BS="����";</script>
<script>
//if(top.uid=="" || self==top || top.document.domain!=document.domain){ top.location="http://"+document.domain;}
var rangMax=0;
var rangMin=0;
var keep_action="";
var bgclass="";
var GameFT=new Array();
var gidx=new Array();
var chg_se=new Array('','90','90','1st','RB','','','','1st');
top.keep_listbet="nokeep";
top.choice="";
top.pages=1;
top.records=-1;
top.show_gtype="";
function set_rang(){
	rangMin=0;
	rangMax=rangMin+2;
	}
function mouseover_pointer(mouseTR){
	bgclass=mouseTR.bgColor;
	trid=(mouseTR.id).replace("C","");
	eval("document.getElementById('"+trid+"').bgColor='gold'");
	try{
	eval("document.getElementById('"+trid+"C').bgColor='gold'");
	}catch(E){}

}
function mouseout_pointer(mouseTR){
	if (bgclass!="")
		{
		trid=(mouseTR.id).replace("C","");
		eval("document.getElementById('"+trid+"').bgColor='"+bgclass+"'");
		try{
			eval("document.getElementById('"+trid+"C').bgColor='"+bgclass+"'");
		}catch(E){}
	}
}
/*
---------------reload time------------------
*/
var ReloadTimeID="";
function set_reloadtime()
{
	 j=0;
	 for(i=0;i<document.getElementById('retime').length;i++){
			if(document.getElementById('retime').options[i].value==top.retime) document.getElementById('retime').selectedIndex=j;
			j++;
			}
	top.retime=document.getElementById('retime').options[document.getElementById('retime').selectedIndex].value;
	clearInterval(ReloadTimeID);
	if(top.retime != -1){
		ReloadTimeID = setInterval("reload_var()",top.retime*1000);

	}

}
function reloadtime(){
	reload_var();
	top.retime=document.getElementById('retime').options[document.getElementById('retime').selectedIndex].value;
	clearInterval(ReloadTimeID);
	if(top.retime != -1){
		ReloadTimeID = setInterval("reload_var()",top.retime*1000);

	}
}
function reload_var(){
	//alert("reload");
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	//alert(homepage);

	reloadPHP.location.href=homepage;

}
/*
----------------����menu--------------
*/
function change_game(gtype,vals,gid,se){
//alert(gtype);
//alert(gid);


str_gopenY=top.str_gopenY;
str_gopenN=top.str_gopenN;
str_strongH=top.str_strongH;
str_strongC=top.str_strongC;
str_FL_enable1="ȷ���ı����״̬";
str_FL_enable0="ȷ���ı����״̬";

a=true;
if ((gtype=="gopen" || gtype=="strong" || gtype=="FL_enable") && (gid!="all"))
	a=confirm(eval("str_"+gtype+vals));
else {
	if (gid=="all"){
		if (gtype=="gopen") a=confirm(top.str_close_fl_gopen);
		if (gtype=="gacpt") a=confirm(top.str_close_fl_gacpt);
		if (gtype=="auto") a=confirm(top.str_allfellow);
	}

};
if (a==true){
	//alert('FT_Game_change.php?gid='+gid+"&"+gtype+"="+vals+"&ShowType="+Showtypes+"&se="+se+"&"+get_pageparam()+"&gsdate="+top.gsdate+"&gedate="+top.gedate+"&league_id="+top.sel_league+"&area_id="+top.sel_area+"&item_id="+top.sel_item);
	reloadPHP.location.href='FT_Game_change.php?gid='+gid+"&"+gtype+"="+vals+"&ShowType="+Showtypes+"&se="+se+"&"+get_pageparam()+"&gsdate="+top.gsdate+"&gedate="+top.gedate+"&league_id="+top.sel_league+"&area_id="+top.sel_area+"&item_id="+top.sel_item;
	}
}
/*
���� FUNC
С����λ��
*/
function printf(vals,points){
	vals=""+vals;
	var cmd=new Array();
	cmd=vals.split(".");
	if (cmd.length>1){
		for (ii=0;ii<(points-cmd[1].length);ii++)vals=vals+"0";
	}else{
		vals=vals+".";
		for (ii=0;ii<points;ii++)vals=vals+"0";
	}
	return vals;
}
/*
������
*/
function get_timer(){return (new Date()).getTime();}
/*
����
*/
document.onkeypress=checkfunc;
function checkfunc(e) {
	switch(event.keyCode){
	}
}

function CheckKey(){
	if(event.keyCode == 13) return true;
	if(event.keyCode == 45) return true;
	if (event.keyCode!=46){
		if((event.keyCode < 48 || event.keyCode > 57))
		{
			alert(top.str_noly_number);
			return false;
		}
	}
}
/*
parser ��ͷ
*/
function get_cr_str(cr){
	var crs=new Array();
	var word ="";
	if (cr.indexOf("+")>0) {
		crs=cr.split("+");
		if(crs[0]=="0"){
			if(crs[1]=="0") word = crs[1].replace('0',top.str_ratio[0]);
		}else{
			switch(crs[1]){
				case '100':
					//alert(cr);
					if(crs[0]*1==1){
						word =top.str_ratio[1];
					}else{

						word =""+(crs[0]*1 - 0.5);

						word = word.replace('.5',top.str_ratio[2]);
					}
				break;
				case '50':
					if(crs[0]*1==1){
							word =top.str_ratio[1]+"/"+crs[0]+top.str_ratio[3];
					}else{
							word =(crs[0]*1 - 0.5)+"/"+crs[0]+top.str_ratio[3];
							word = word.replace('.5',top.str_ratio[2]);
					}
				break;
				case '0':
					word = crs[0]+top.str_ratio[3];
				break;
			}
		}
	}

	if (cr.indexOf("-")>0) {
		crs=cr.split("-");
		crs[1]="-"+crs[1];
		if(crs[0]=="0")	word = top.str_ratio[0]+"/"+top.str_ratio[1];
		else{
			word =crs[0]+top.str_ratio[3]+"/"+(1+crs[0]*1 - 0.5);
			word = word.replace('.5',top.str_ratio[2]);
		}

	}
	if(word=="") return cr;
	return word;
}
function get_ou_str(cr){
	var crs=new Array();
	var word ="";
	if (cr.indexOf("+")>0) {
		crs=cr.split("+");
		if(crs[0]=="0"){
			if(crs[1]=="0") word = crs[1];
			if(crs[1]=="50") word = crs[0]+" / "+(crs[0]*1+1 - 0.5);
		}else{
			switch(crs[1]){
				case '100':
					word =crs[0]*1 - 0.5;
				break;
				case '50':
					word =(crs[0]*1 - 0.5)+" / "+crs[0];
				break;
				case '0':
					word =crs[0];
				break;
			}
		}
	}

	if (cr.indexOf("-")>0) {
		crs=cr.split("-");
		crs[1]="-"+crs[1];
		word =crs[0]+" / "+(1+crs[0]*1 - 0.5);
	}


	if(word=="")return cr;
	return word;
}
function  change_time(get_time){
	var dates=get_time.split(" ");
	if (dates.length>1) get_time=dates[1];
	gtime=get_time.split(":");
	if (gtime[0]>12){
		return dates[0].substring(5,10) + "<br>" +(gtime[0]*1-12)+":"+gtime[1]+"p";
	}

	return dates[0].substring(5,10) + "<br>" +gtime[0]+":"+gtime[1]+"a";
}
/*
�趨��ҳ
*/
function setpage(){

	document.getElementById('times').innerHTML=nowtime;

//	var pagehtml="";
//	if (""+top.pages=="undefined") top.pages=1;
//	if (totalcount<=(top.records*(top.pages-1))) top.pages=1;
//	for (cc=1;cc<=(Math.ceil(totalcount/top.records));cc++) pagehtml+="<font class='b_ti' style='cursor:hand' onclick=change_page('"+cc+"')>"+cc+"</font> ";
//	if (top.records==-1){
//		top.pages=1;
//		document.getElementById('pages').innerHTML=" 1/1";
//	}else{
//		document.getElementById('pages').innerHTML=top.pages+" / "+(Math.ceil(totalcount/top.records)) + " "+pagehtml;
//	}
}
function change_page(pages){
	top.pages=pages;
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	reloadPHP.location.href=homepage;
	}
function change_date(){
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	reloadPHP.location.href=homepage;
	}
function change_showtype(){
	top.pages=1;
	ptypes=document.getElementById('ptype').options[document.getElementById('ptype').selectedIndex].value;
	homepage="loadgame_"+ptypes+".php?"+get_pageparam();
	window.location.href=homepage;
	}
function show_showRecord(){

	if (""+top.records=="undefined") top.records=-1;
//	j=0;
//	for(i=0;i<document.getElementById('showRecord').length;i++){
//		if(document.getElementById('showRecord').options[i].value==top.records) document.getElementById('showRecord').selectedIndex=j;
//		j++;
//	}


}
function set_showRecord(){
	top.pages=1;
	top.records=document.getElementById('showRecord').options[document.getElementById('showRecord').selectedIndex].value;
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	reloadPHP.location.href=homepage;
}

function init(){
	top.sound=false;
	set_rang();
	setpage();
	set_reloadtime();
	show_showRecord();
//	if (keep_action==""){
//		keep_actions=document.getElementById('rs_form').action.split("?");
//		keep_action=keep_actions[0];
//	}
	//alert("----"+keep_action+"?"+get_pageparam());
	//document.getElementById('rs_form').action=keep_action+"?"+get_pageparam();

}
function get_pageparam(){
	//alert(top.choice)
	//alert("aaaa");
	if (top.choice=="") top.choice="ALL";
	if (""+top.pages=="undefined") top.pages=1;
	if (""+top.records=="undefined") top.records=-1;
	if (""+top.sel_league=="undefined") top.sel_league="";
	if (""+top.sel_area=="undefined") top.sel_area="";
	if (""+top.sel_item=="undefined") top.sel_item="";
	if (""+top.gsdate=="undefined") top.gsdate="";
	if (""+top.gedate=="undefined") top.gedate="";
	if (""+top.set_account=="undefined") top.set_account="0";

	//alert(top.choice)
	var dated="";
	try{
	dated=document.getElementById('dates').options[document.getElementById('dates').selectedIndex].value;
	}catch(E){}
	return "choice="+top.choice+"&pages="+top.pages+"&records="+top.records+"&date="+dated+"&uid="+top.uid+"&aid="+top.aid+"&langx="+top.langx+"&username="+top.username+"&gsdate="+top.gsdate+"&gedate="+top.gedate+"&showgtype="+top.show_gtype+"&league_id="+top.sel_league+"&item_id="+top.sel_item+"&area_id="+top.sel_area+"&set_account="+top.set_account;
}
function get_pageparam1(){

	return "uid="+top.uid+"&langx="+top.langx+"&username="+top.username;;
}
function check_fl(gid,pos){

	gno=gidx[gid];
	//alert("gno="+gno+"GameFT["+gno+"]["+pos+"]="+GameFT[gno][pos]);
	if (GameFT[gno][pos]!="0") {
		alert(top.str_now_fl);
		return true;
	}
	return false;
}

function setups(gid,se){
	//'<A HREF=\"javascript:\" onClick=\"window.open(\'../game_set/game_ctl_FT_sp.php?gtype='+GameData[i][(GameData[i].length-1)]+'&uid='+uid+'&gid='+GameData[i][0]+'\');\">'+set+'</A> / '+

	window.open('../profile/FS_'+chg_se[se]+'_set.php?gid='+gid+'&uid='+top.uid+'&username='+top.username+'&langx='+top.langx+'&game_session='+se,'setup','width=800,height=500,left=0,top=0,toolbar=no,location=no,directories=no,menubar=no,status=no,scrollbars=yes');
}
function set_grp(gid,grp,se,rtype){
	var types='FS';
	var way='set';
	if(se=='3' || se=='8') types='1st';
	else if(se=='4' ||se=='5'||se=='6') types='rb';
	else{
		if(rtype=='PD'||rtype=='M'||rtype=='F'||rtype=='HM'){
			way='single';
			se+='&rtype='+rtype;
		}
	}

	window.open('../profile/'+types+'_grp_'+way+'.php?gid='+gid+'&gtype=FS&uid='+top.uid+'&username='+top.username+'&langx='+top.langx+'&grp='+grp+'&game_session='+se,'setup','width=800,height=500,left=0,top=0,toolbar=no,location=no,directories=no,menubar=no,status=no,scrollbars=yes');
}
function show_xy(){
	try{
	if (rs_window.style.visibility=="visible"){
			top_y=document.body.scrollTop;
			rs_window.style.top=top_y+200;
			}
	}catch(E){}
}
function show_layer(showlayer,scrollY){

	try{
	if (eval(showlayer+".style.visibility=='visible'")){
			top_y=document.body.scrollTop;
			eval(showlayer+".style.top=top_y+"+scrollY);
			}
	}catch(E){}
}

function value_set(){

	document.getElementById('ShowType').value=Showtypes;

	try{
		document.getElementById('choice').value=top.choice;
		document.getElementById('pages').value=top.pages;
		document.getElementById('records').value=top.records;
		document.getElementById('uid').value=top.uid;
		document.getElementById('langx').value=top.langx;
	}catch(E){}
	try{
	dated=document.getElementById('dates').options[document.getElementById('dates').selectedIndex].value;
	document.getElementById('date').value=dated;
	}catch(E){}
	}
function play_sound(){
 	//alert(top.sound);
 	try{
		if(top.sound) bsound_nt.src="c:/winnt/media/ding.wav";
	}catch(E){}
	try{
		if(top.sound) bsound_windows.src="c:/windows/media/ding.wav";
	}catch(E){}
top.sound=false;
 }
</script>
<script>
var dragswitch=0
var nsx
var keep_drop_layers;
function drag_dropns(name){
	temp=eval(name)
	temp.captureEvents(Event.MOUSEDOWN | Event.MOUSEUP)
	temp.onmousedown=gons
	temp.onmousemove=dragns
	temp.onmouseup=stopns
}

function gons(e){
	temp.captureEvents(Event.MOUSEMOVE)
	nsx=e.x
	nsy=e.y
}
function dragns(e){
	if (dragswitch==1){
		temp.moveBy(e.x-nsx,e.y-nsy)
		return false
	}
}

function stopns(){
	temp.releaseEvents(Event.MOUSEMOVE)
}


var dragapproved=false

function drag_dropie(){
	if (dragapproved==true){
		eval("document.all."+keep_drop_layers+".style.pixelLeft=tempx+event.clientX-iex");
		eval("document.all."+keep_drop_layers+".style.pixelTop=tempy+event.clientY-iey");
		return false
	}
}
function initializedragie(drop_layers){
	keep_drop_layers=drop_layers;
	iex=event.clientX
	iey=event.clientY
	eval("tempx="+drop_layers+".style.pixelLeft")
	eval("tempy="+drop_layers+".style.pixelTop")
	dragapproved=true
	document.onmousemove=drag_dropie
}

if (document.all){
	document.onmouseup=new Function("dragapproved=false")
}
function hidebox(){
	if (document.all)
		showimage.style.visibility="hidden"
	else if (document.layers)
		document.showimage.visibility="hide"
}
function chk_Key(obj,value){
	//var chk_num = /[^0-9]+/ ;
	//if(chk_num.test(value)){
	//  obj.value=value.replace(chk_num,'');
	//}
}</script>

<link href="../../../../style/control/control_main.css" rel="stylesheet" type="text/css">

</head>


<body id="main_body" onLoad="reload_var();">
<a name="top"></a>
<bgsound id=bsound_windows loop=1>
<bgsound id=bsound_nt loop=1>

<table width="810" border="0" cellpadding="0" cellspacing="0">
  <tr><td width="780" class="">
 <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="60">&nbsp;&nbsp;�ھ�ȫ�� :</td>
<td>
<select id="game_type" name="game_type" onChange="chg_gtype(this.value);" class="za_select">
	<option value="">ȫ��</option>
	<option value="FT">����</option>
	<option value="BK" >����</option>
	<option value="BS">����</option>
	<option value="TN">����</option>
	<option value="VB">����</option>
</select>
</td>
<td width="65">&nbsp;--&nbsp;��������:</td>
<td>
<select name="retime" class="za_select" id="retime" onChange="reloadtime()">
	<option value="-1">������</option>
	<option value="10">10 sec</option>
	<option value="20">20 sec</option>
	<option value="60">60 sec</option>
</select>
</td>
<td>����Khi:<span id=times></span></td>


<td>--��������: </td>
<td><input type="text" id="gsdate" name="gsdate" value="" size="9" maxlength="10"></td>
<td>~</td>
<td><input type="text" id="gedate" name="gedate" value="" size="9" maxlength="10"></td>
<td><input type="button" value="ȷ��" onClick="chgDate();"></td>
          </tr>
      </table>
 </td>
  </tr>

</table>


<table height="0" cellpadding="1" cellspacing="1">
  <tr>
<td><font color="#000099">&nbsp;����:</font></td><td><span id="sel_areas"></span></td>

<td>&nbsp;&nbsp;ѡ������ :</td><td><span id="sel_leg"></span></td>

<td>&nbsp;&nbsp;ѡ����� :</td><td><span id="sel_items"></span></td>
<td>�ۿ���ʽ :&nbsp;<select id="set_account" name="set_account" onChange="chg_account(this.value);" class="za_select">
        		<option value="0">ȫ��</option>
			<option value="1">�Լ�</option>
		</select></td>
</tr></table>
</div>

<div id=showlayers style="display: none">
<table id="glist_table"  border="0" cellspacing="1" cellpadding="0" bgcolor="#CC9900" class="m_tab">
   <tr class="m_title_nfs">
   <td>Khi</td>
      <td>���� / ��Ŀ</td>
      <td>���� (��Ա)</td>
      <td>��̭</td>
      <td>����</td>
      <td>ע��</td>


    </tr>
   *ShowGame*
</table>
</div>
<div id=showgames></div>

<div id="glist" style="display: none">

  <tr id="TR*GID*" *CLASS* align="center">
    <td>*TIME*</td>
    <td>*LEG*<br>*ITEM*</td>
    <td class="td_2">*TEAM*</td>
	<td class="td_2">*OUT*</td>
	<td class="td_2">*IORATIO*</td>
	<td class="td_2">*ORDERS*</td>


 </tr>

</div>


<div class="bord"><b></b><a href="#">TO TOP</a></div>
<!----------------------���������Ӵ�---------------------------->

<!----------------�Զ��ر��趨�Ӵ�---------------->
<div id=AutoClose style="display: none;position: absolute;">
<FORM NAME="FS_RatioForm" ACTION="FS_ctl_fs_ratio.php" METHOD="POST" target="reloadPHP" onSubmit="return check(this);">
	<INPUT TYPE="HIDDEN" NAME="uid" value="">
	<INPUT TYPE="HIDDEN" NAME="gid" value="" id="AutoGid">
	<INPUT TYPE="HIDDEN" NAME="act" value="AutoClose">
	<input type="hidden" name="gsdate1" value="">
	<input type="hidden" name="gedate1" value="">
	<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="#00558E">
	  <tr>
	    <td bgcolor="#FFFFFF">
	      <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix">
	          <tr bgcolor="#0163A2">
	          <td width="200" id=bet_title><font color="#FFFFFF">���趨�ر�Khi</font></td>
	          <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win('AutoClose');"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
	          </tr>
	          <tr bgcolor="#CC0000">
	          	<td width="200" colspan="2" >
	          		<font color="#FFFFFF" >���ڣ�</font>
	          		<input type="text" name="setDate" id="setDate"  size="10" maxlength="10"><font color="#FFFFFF"  size="1">(YYYY-MM-DD)</font>
	          	</td>
	          </tr>
	          <tr bgcolor="#CC0000">
	          	<td width="200" colspan="2">
	          		<font color="#FFFFFF">Khi��</font>
	          		<input type="text" name="setTime" id="setTime" size="5" maxlength="5"><font color="#FFFFFF" size="1">(HH:MM)</font>
	          	</td>
	          </tr>
	          <tr bgcolor="#CC0000">
	          	<td width="200" colspan="2" id="setTime">
	          		<input type="submit" name="confirm" value="ȷ��">
	          	</td>
	          </tr>
	      </table>
	    </td>
	  </tr>
	</table>

</FORM>
</div>
<!----------------------���������Ӵ�---------------------------->
<!--ѡ������ START-->
<span id="bowling" style="position:absolute; display: none">
	<option value="*LEAGUE_ID*" *SELECT*>*LEAGUE_NAME*</option>
</span>
<span id="bodyH" style="position:absolute; display: none">
	<select id="sel_lid" name="sel_lid" onChange="chg_league();" class="za_select">
	<option value="">ȫ��</option>
		*SHOW_H*
	</select>
</span>
<!--ѡ������ END-->

<!--���� START-->
<span id="area" style="position:absolute; display: none">
	<option value="*AREA_ID*" *SELECT_AREA*>*AREA_NAME*</option>
</span>
<span id="bodyA" style="position:absolute; display: none">
	<select id="sel_aid" name="sel_aid" onChange="chg_area();" class="za_select">
	<option value="">ȫ��</option>
		*SHOW_A*
	</select>
</span>
<!--���� END-->

<!--��� START-->
<span id="item" style="position:absolute; display: none">
	<option value="*ITEM_ID*" *SELECT_ITEM*>*ITEM_NAME*</option>
</span>
<span id="bodyI" style="position:absolute; display: none">
	<select id="sel_itemid" name="sel_itemid" onChange="chg_item();" class="za_select">
	<option value="">ȫ��</option>
		*SHOW_I*
	</select>
</span>
<!--��� END-->


<iframe id=reloadPHP name=reloadPHP width=0 height=0></iframe>
</body>
</html>
