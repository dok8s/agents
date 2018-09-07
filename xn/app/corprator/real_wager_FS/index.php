<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select Agname,ID,language from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
require ("../../member/include/traditional.$langx.inc.php");
?>
<html>
<head>
<title>Football_Control</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<script>
function show_page(){
	var temp="";
	var pg_str=""
	bodyP=body_browse.document.getElementById("bodyP");
	pg_txt=body_browse.document.getElementById("pg_txt");
	if(sel_league==''){
		for(var i=0;i<t_page;i++){
			if (pg!=i)
				pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'><font color='#000099'>"+(i+1)+"</font></a>&nbsp;&nbsp;&nbsp;&nbsp;";
			else
				pg_str=pg_str+"<B><font color='#FF0000'>"+(i+1)+"</font></B>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		txt_bodyP= bodyP.innerHTML;
		txt_bodyP =txt_bodyP.replace("*SHOW_P*",pg_str);
	 	pg_txt.innerHTML=txt_bodyP;
	 }else{pg_txt.innerHTML="";}
}

function ShowLeague(lid){
	bowling_data="";
	var temp="";
	var temparray=new Array();
	bowling = body_browse.document.getElementById("bowling");
	bodyH=body_browse.document.getElementById("bodyH");
	show_h=body_browse.document.getElementById("show_h");
	var tempbowling = bowling.innerHTML;
	txt_bodyH= bodyH.innerHTML;
	if (totaldata!=''){
		bowling_data=totaldata.split(",");
		for(i=1;i<bowling_data.length;i++){
			temparray=bowling_data[i].split("*");
			txt_bowling = tempbowling.replace("*LEAGUE_ID*",temparray[0]);
			if(lid==temparray[0])txt_bowling = txt_bowling.replace("*SELECT*","SELECTED");
			else txt_bowling = txt_bowling.replace("*SELECT*","");
			txt_bowling = txt_bowling.replace("*LEAGUE_NAME*",temparray[1]);
			temp+=txt_bowling;

		}
		txt_bodyH =txt_bodyH.replace("*SHOW_H*",temp);
  	}else{
	  	txt_bodyH =txt_bodyH.replace("*SHOW_H*","");
  	}
  	show_h.innerHTML=txt_bodyH;
}

//�P�_�ثe����ܭ��������
function ShowGameList(){
	if(loading == 'Y') return;
	var game_type = top.game_type;

	ltype_obj = body_browse.document.getElementById('ltype');
	ltype_obj.value  = ltype;
	dt_obj = body_browse.document.getElementById("dt_now");
	dt_obj.innerText = ' -- '+gmt_str+':'+dt_now;
	show_table = body_browse.document.getElementById("glist_table");
	switch(ShowType){
		case 'FS':	//�S��
			ShowData_FS(show_table,GameFT,gamount,game_type);
			break;
		//   case 'PL':	//�w�}��
		//    ShowData_PL(show_table,GameFT,gamount);
		//    break;
	}
}

//��ܯS���ɵ{�e�����
function ShowData_FS(obj_table,GameData,data_amount,gtype){
	with(obj_table){
		//�M��table���
		while(rows.length > 1) deleteRow(rows.length-1);
		//�}�l��ܶ}���ɵ{���
		flag = 0;
		for(i=0; i<data_amount; i++){
			//�P�_�O�_����h�y��
			if ((gtype != null && gtype != "")&& GameData[i][(GameData[i].length-1)] != gtype) {continue;}

			if(GameData[i][4] == 'Y'){
				tr_class = 'm_cen';
				input_class = 'za_text_f';
			}else{
				tr_class = 'm_cen_close';
				input_class = 'za_text_f_close';
			}
			nowTR = insertRow();
			nowTR.className = tr_class;

			//�D���b����������
			with(nowTR){
				//����ɶ�
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//�p��
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][2];
				tx=0;
				team_list='<form name='+GameData[i][0]+'><table cellspacing=\"1\" class=\"m_tab\"><tr class=\"'+tr_class+'\">';
				for(t=0; t<GameData[i][3]; t++){
					_offset=t*5+5;
					if(GameData[i][_offset+4]=='N'){
						addx='-';lossx='Y';
					}else{
						addx='+';lossx='N';
					}
					team_list=team_list+'<td width=120>'+GameData[i][_offset]+addx
						  +'<br><a href=\"FS_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=FS&rtype='+GameData[i][_offset+3]+'\"><font color=red>'+GameData[i][_offset+2]+'</a></td>'+
						  '<td width=30>'+GameData[i][_offset+1]+'</td>';
					if(tx++ > 2){
						team_list=team_list+'</tr><tr class=\"'+tr_class+'\">';
						tx=0;
					}
				}
				nowTD = insertCell();
				nowTD.Align = 'left';
				nowTD.innerHTML = team_list+'<INPUT TYPE=\"HIDDEN\" NAME=\"'+GameData[i][0]+'teams\" value="'+GameData[i][3]+'"></form>';
			}
		}
	}//with(obj_table);
}</script>
<SCRIPT LANGUAGE="JAVASCRIPT">
<!--
 if(self == top) location='/xn/app/control/agents/';
 var uid=''; //user's session ID
 var loading = 'Y'; //�O�_���bŪ���s������
 var stype_var = ''; //�ثeŪ���ܼƭȭ���
 var ShowType = ''; //�ثe��ܭ���
 var ltype = 1; //�ثe���line
 var spage = ''; //�ثe��ܭ���
 var dt_now = ''; //�ثe����ɶ�
 var aid='';
 var sel_league='';

 var gamount = 0; //�ثe����ɵ{��
 var GameFT = new Array(1024); //�̦h�]�w���1024���ɵ{
 for(var i=0; i<1024; i++){
 	GameFT[i] = new Array(37); //���U�ɵ{�ŧi 37 �����
 }
// -->
</SCRIPT>
</head>

<frameset rows="0,*" frameborder="NO" border="0" framespacing="0">
  <frame name="body_var" scrolling="NO" noresize src="real_wagers_var.php?uid=<?=$uid?>" >
  <frame name="body_browse" src="real_wagers.php?uid=<?=$uid?>">
</frameset>
<noframes><body bgcolor="#FFFFFF">

</body></noframes>
</html>