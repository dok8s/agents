<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select Agname,ID,language from web_world where Oid='$uid'";
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
require ("../../../member/include/traditional.$langx.inc.php");
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

//判斷目前應顯示頁面並顯示
function ShowGameList(){
	if(loading == 'Y') return;
	var game_type = top.game_type;

	ltype_obj = body_browse.document.getElementById('ltype');
	ltype_obj.value  = ltype;
	dt_obj = body_browse.document.getElementById("dt_now");
	dt_obj.innerText = ' -- '+gmt_str+':'+dt_now;
	show_table = body_browse.document.getElementById("glist_table");
	switch(ShowType){
		case 'FS':	//特殊
			ShowData_FS(show_table,GameFT,gamount,game_type);
			break;
		//   case 'PL':	//已開賽
		//    ShowData_PL(show_table,GameFT,gamount);
		//    break;
	}
}

//顯示特殊賽程畫面資料
function ShowData_FS(obj_table,GameData,data_amount,gtype){
	with(obj_table){
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
		//開始顯示開放中賽程資料
		flag = 0;
		for(i=0; i<data_amount; i++){
			//判斷是否有選則球類
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

			//主隊半全場資料顯示
			with(nowTR){
				//日期時間
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//聯盟
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
 if(self == top) location='/app/control/agents/';
 var uid=''; //user's session ID
 var loading = 'Y'; //是否正在讀取瀏覽頁面
 var stype_var = ''; //目前讀取變數值頁面
 var ShowType = ''; //目前顯示頁面
 var ltype = 1; //目前顯示line
 var spage = ''; //目前顯示頁面
 var dt_now = ''; //目前日期時間
 var aid='';
 var sel_league='';

 var gamount = 0; //目前顯示賽程數
 var GameFT = new Array(1024); //最多設定顯示1024筆賽程
 for(var i=0; i<1024; i++){
 	GameFT[i] = new Array(37); //為各賽程宣告 37 個欄位
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