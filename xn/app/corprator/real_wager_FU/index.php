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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	if (bowling!=null){
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
}
//判断目前应显示页面并显示
 function ShowGameList()
 {
  if(loading == 'Y') return;
  ltype_obj = body_browse.document.getElementById('ltype');
  ltype_obj.value  = ltype;
  dt_obj = body_browse.document.getElementById("dt_now");
  dt_obj.innerText = '--'+gmt_str+':'+dt_now;
  show_table = body_browse.document.getElementById("glist_table");
  switch(ShowType)
  {
   case 'OU':	//单式
    ShowData_OU(show_table,GameFT,gamount);
    break;
   case 'HOU':	//上半场
    ShowData_HOU(show_table,GameFT,gamount);
    break;
   case 'RE':	//走地
    ShowData_RE(show_table,GameFT,gamount);
    break;
   case 'PD':	//波胆
    ShowData_PD(show_table,GameFT,gamount);
    break;
   case 'HPD':	//波胆
    ShowData_HPD(show_table,GameFT,gamount);
    break;
   case 'EO':	//总入球
    ShowData_EO(show_table,GameFT,gamount);
    break;
   case 'F':	//半全场
    ShowData_F(show_table,GameFT,gamount);
    break;
   case 'P':	//过关
    ShowData_P(show_table,GameFT,gamount);
    break;
   case 'FS':	//特殊
    ShowData_FS(show_table,GameFT,gamount);
    break;
   case 'PL':	//已开赛
    ShowData_PL(show_table,GameFT,gamount);
    break;
  }
 }

//显示单式画面资料
 function ShowData_OU(obj_table,GameData,data_amount)
 {
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen_top';
    else
     nowTR.className = 'm_cen_top_close';
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
     nowTD.innerHTML = '<BR>'+GameData[i][2];
     //场次
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //队伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#009900\">'+draw+'</font></div>';
     //让球/注单
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
	      '<tr align=\"right\">';
     //开始写入赔率
     if(GameData[i][7] == 'H') //强队是主队
     {
//      $ratio_h = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ratio.php?call=ou&rtype=R&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][9]+'</A>';
      $ratio_h = GameData[i][9];
      $ratio_c = '&nbsp';
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
     }
     else  //强队是客队
     {
      $ratio_h = '&nbsp';
//      $ratio_c = '<A  href=\"#\" onClick=\"window.open(\'FT_chg_ratio.php?call=ou&rtype=R&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][10]+'</A>';
      $ratio_c = GameData[i][10];
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
     }
     tmpStr += '<td width=\"48%\">'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
               '<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=2\"><font color=\"#CC0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
	       '<tr align=\"right\">'+
	       '<td>'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
	       '<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=2\"><font color=\"#CC0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td></tr>';
     tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
     nowTD.innerHTML = tmpStr;
     //上下盘/注单
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"52%\">'+GameData[i][17]+'&nbsp'+GameData[i][19]+'<br>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=3\"><font color=\"#CC0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></A></td></tr>'+
		       '<tr align=\"right\"><td>'+GameData[i][18]+'<br>'+
		       '<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=3\"><font color=\"#CC0000\">'+GameData[i][20]+'/'+GameData[i][22]+'</font></A></td></tr>'+
	 	       '<tr><td colspan=\"3\">&nbsp;</td></tr></table>';
     //独赢/注单
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"30%\" align=\"left\">'+GameData[i][24]+'<BR></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=1\"><font color=\"#CC0000\">'+GameData[i][27]+'/'+GameData[i][30]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][25]+'<BR></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=1\"><font color=\"#CC0000\">'+GameData[i][28]+'/'+GameData[i][31]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][26]+'<br></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=N&linetype=1\"><font color=\"#CC0000\">'+GameData[i][29]+'/'+GameData[i][32]+'</font></A></td></tr></table>';
    }//with(TR)
   }
  }//with(obj_table);
 }

//显示上半场画面资料
 function ShowData_HOU(obj_table,GameData,data_amount)
 {
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen_top';
    else
     nowTR.className = 'm_cen_top_close';
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
     nowTD.innerHTML = '<BR>'+GameData[i][2];
     //场次
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //队伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#009900\">'+draw+'</font></div>';
     //让球/注单
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
	      '<tr align=\"right\">';
     //开始写入赔率
     if(GameData[i][7] == 'H') //强队是主队
     {
//      $ratio_h = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ratio.php?call=ou&rtype=R&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][9]+'</A>';
      $ratio_h = GameData[i][9];
      $ratio_c = '&nbsp';
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
     }
     else  //强队是客队
     {
      $ratio_h = '&nbsp';
//      $ratio_c = '<A  href=\"#\" onClick=\"window.open(\'FT_chg_ratio.php?call=ou&rtype=R&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][10]+'</A>';
      $ratio_c = GameData[i][10];
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
     }
     tmpStr += '<td width=\"48%\">'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
               '<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=12\"><font color=\"#CC0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
	       '<tr align=\"right\">'+
	       '<td>'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
	       '<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=12\"><font color=\"#CC0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td></tr>';
     tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
     nowTD.innerHTML = tmpStr;
     //上下盘/注单
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"52%\">'+GameData[i][17]+'&nbsp'+GameData[i][19]+'<br>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=13\"><font color=\"#CC0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></A></td></tr>'+
		       '<tr align=\"right\"><td>'+GameData[i][18]+'<br>'+
		       '<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=13\"><font color=\"#CC0000\">'+GameData[i][20]+'/'+GameData[i][22]+'</font></A></td></tr>'+
	 	       '<tr><td colspan=\"3\">&nbsp;</td></tr></table>';
     //独赢/注单
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"30%\" align=\"left\">'+GameData[i][24]+'<BR></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=11\"><font color=\"#CC0000\">'+GameData[i][27]+'/'+GameData[i][30]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][25]+'<BR></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=11\"><font color=\"#CC0000\">'+GameData[i][28]+'/'+GameData[i][31]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][26]+'<br></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=N&linetype=11\"><font color=\"#CC0000\">'+GameData[i][29]+'/'+GameData[i][32]+'</font></A></td></tr></table>';
    }//with(TR)
   }
  }//with(obj_table);
 }

//显示走地画面资料
 function ShowData_RE(obj_table,GameData,data_amount)
 {
  winset = '';
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen_top';
    else
     nowTR.className = 'm_cen_top_close';
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][2];
     //场次
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //队伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = '<font style=\"background-color:#FFFF00\">'+GameData[i][5]+'&nbsp;&nbsp;'+GameData[i][24]+'<BR>'+GameData[i][6]+'&nbsp;&nbsp;'+GameData[i][25]+'</font><div align=right><font color=\"#009900\">'+draw+'</font></div>';
     //让球/注单
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
	      '<tr align=\"right\">';
     //开始写入赔率
     if(GameData[i][7] == 'H') //强队是主队
     {
      $ratio_h = GameData[i][9];
      $ratio_c = '&nbsp';
      $ioratio_h = GameData[i][11];
//      $ioratio_h = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ioratio.php?call=ou&type=H&rtype=RE&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][11]+'</A>';
      $ioratio_c = GameData[i][12];
     }
     else  //强队是客队
     {
      $ratio_h = '&nbsp';
      $ratio_c = GameData[i][10];
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
//      $ioratio_c = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ioratio.php?call=ou&type=C&rtype=RE&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][12]+'</A>';
     }
     tmpStr += '<td width=\"48%\">'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
               '<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=9\"><font color=\"#CC0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
	       '<tr align=\"right\">'+
	       '<td>'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
	       '<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=9\"><font color=\"#CC0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td></tr>';
     tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
     nowTD.innerHTML = tmpStr;
     //上下盘/注单
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"52%\">'+GameData[i][17]+'&nbsp'+GameData[i][19]+'<br></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=10\"><font color=\"#CC0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></A></td></tr>'+
		       '<tr align=\"right\"><td>&nbsp'+GameData[i][18]+'<br></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=10\"><font color=\"#CC0000\">'+GameData[i][20]+'/'+GameData[i][22]+'</font></A></td></tr>'+
	 	       '<tr><td colspan=\"2\">&nbsp;</td></tr></table>';

	 	R_rtype="HRE";
				OU_rtype="HROU";
				nowTD = insertCell();
				nowTD.className = 'm_cen_top_one';
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
					'<tr align=\"right\">';
				//开始写入赔率
				if(GameData[i][27] == 'H') {	//强队是主队
					$ratio_h = GameData[i][28];
					$ratio_c = '&nbsp';
					$ioratio_h = GameData[i][30];
					$ioratio_c = GameData[i][31];
				} else {	//强队是客队
					$ratio_h = '&nbsp';
					$ratio_c = GameData[i][29];
					$ioratio_h = GameData[i][30];
					$ioratio_c = GameData[i][31];
				}
				tmpStr += '<td width=\"52%\">'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
					'<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][26]+'&type=H&linetype=19\"><font color=\"#CC0000\">'+GameData[i][32]+'/'+GameData[i][34]+'</font></a></td></tr>'+
					'<tr align=\"right\">'+
					'<td>'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
					'<td><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][26]+'&type=C&linetype=19\"><font color=\"#CC0000\">'+GameData[i][33]+'/'+GameData[i][35]+'</font></a></td></tr>';
				tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
				nowTD.innerHTML = tmpStr;
				//上下盘/注单
				nowTD = insertCell();
				nowTD.className = 'm_cen_top_one';
				nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
						'<tr align=\"right\">'+
						'<td width=\"52%\">'+GameData[i][36]+'&nbsp'+GameData[i][38]+'<br></td>'+
						'<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][26]+'&type=C&linetype=30\"><font color=\"#CC0000\">'+GameData[i][40]+'/'+GameData[i][42]+'</font></A></td></tr>'+
						'<tr align=\"right\"><td>&nbsp'+GameData[i][37]+'<br></td>'+
						'<td><A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][26]+'&type=H&linetype=30\"><font color=\"#CC0000\">'+GameData[i][39]+'/'+GameData[i][41]+'</font></A></td></tr>'+
						'<tr><td colspan=\"2\">&nbsp;</td></tr></table>';

    }//with(TR)
   }
  }//with(obj_table);
 }


//显示波胆画面资料
 function ShowData_PD(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   flag = 0;
   for(i=0; i<data_amount; i++)
   {
    if(GameData[i][8] == 'Y')
    {
     tr_class = 'm_cen';
     input_class = 'za_text_pd';
    }
    else
    {
     tr_class = 'm_cen_close';
     input_class = 'za_text_pd_close';
    }
    nowTR = insertRow();
    nowTR.className = tr_class;
    //主队波胆资料显示
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = '<br>'+GameData[i][2];
     //队伍
     nowTD = insertCell();
     nowTD.align = 'left';
     //nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=4\" onmouseover=\"javascript:show_bet(\''+GameData[i][6]+' vs '+GameData[i][5]+': '+GameData[i][36]+' / '+GameData[i][37]+'\');\";>'+GameData[i][5]+'</a>';
     nowTD.innerHTML = GameData[i][5]+'<br>';
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.align = 'right';
     if (GameData[i][36]=='') GameData[i][36]=0;
     if (GameData[i][37]=='') GameData[i][37]=0;
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=4\");\";>'+GameData[i][36]+' / '+GameData[i][37]+'</a>';
     //写入波胆赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][9];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][10];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][11];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][12];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][13];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][14];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][15];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][16];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][17];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][18];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][19];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][20];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML =  GameData[i][21];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML =  GameData[i][22];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][23];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][24];
    }//with(TR)主队
    nowTR = insertRow();
    nowTR.className = tr_class;
    //客队波胆资料显示
    with(nowTR)
    {
     //写入波胆赔率
     nowTD = insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][6]+'<br>';
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][25];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][26];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][27];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][28];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][29];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][30];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][31];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][32];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][33];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][34];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][35];
    }//with(TR)客队
   }
  }//with(obj_table);
 }
 function ShowData_HPD(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   flag = 0;
   for(i=0; i<data_amount; i++)
   {
    if(GameData[i][8] == 'Y')
    {
     tr_class = 'm_cen';
     input_class = 'za_text_pd';
    }
    else
    {
     tr_class = 'm_cen_close';
     input_class = 'za_text_pd_close';
    }
    nowTR = insertRow();
    nowTR.className = tr_class;
    //主队波胆资料显示
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = '<br>'+GameData[i][2];
     //队伍
     nowTD = insertCell();
     nowTD.align = 'left';
     //nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=34\" onmouseover=\"javascript:show_bet(\''+GameData[i][6]+' vs '+GameData[i][5]+': '+GameData[i][36]+' / '+GameData[i][37]+'\');\";>'+GameData[i][5]+'</a>';
     nowTD.innerHTML = GameData[i][5]+'<br>';
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.align = 'right';
     if (GameData[i][36]=='') GameData[i][36]=0;
     if (GameData[i][37]=='') GameData[i][37]=0;
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=34\");\";>'+GameData[i][36]+' / '+GameData[i][37]+'</a>';
     //写入波胆赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][9];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][10];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][11];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][12];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][13];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][14];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][15];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][16];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][17];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][18];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][19];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][20];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML =  GameData[i][21];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML =  GameData[i][22];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][23];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][24];
    }//with(TR)主队
    nowTR = insertRow();
    nowTR.className = tr_class;
    //客队波胆资料显示
    with(nowTR)
    {
     //写入波胆赔率
     nowTD = insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][6]+'<br>';
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][25];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][26];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][27];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][28];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][29];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][30];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][31];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][32];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][33];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][34];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][35];
    }//with(TR)客队
   }
  }//with(obj_table);
 }
//显示半全场画面资料
 function ShowData_F(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   flag = 0;
   for(i=0; i<data_amount; i++)
   {
    if(GameData[i][8] == 'Y')
    {
     tr_class = 'm_cen';
     input_class = 'za_text_f';
    }
    else
    {
     tr_class = 'm_cen_close';
     input_class = 'za_text_f_close';
    }
    nowTR = insertRow();
    nowTR.className = tr_class;
    //主队半全场资料显示
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
     nowTD.innerHTML = '<br>'+GameData[i][2];
     //队伍
     nowTD = insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'[主]<br>'+GameData[i][6];
     //注单 / 金额
     nowTD = insertCell();
     nowTD.align = 'right';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=14\">'+ GameData[i][18]+' / '+GameData[i][19]+'</a>';
     //写入半全场赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][9];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][10];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][11];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][12];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][13];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][14];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][15];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][16];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][17];
    }
   }
  }//with(obj_table);
 }

//显示总入球画面资料
 function ShowData_EO(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen_top';
    else
     nowTR.className = 'm_cen_top_close';
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.align = "center";
     nowTD.innerHTML = GameData[i][1];
     //队伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
     //单数赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][9]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=5&type=ODD\"><font color=\"#FF0000\">'+GameData[i][10]+'/'+GameData[i][11]+'</font></A></td>';
     //双数赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][12]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=5&type=EVEN\"><font color=\"#FF0000\">'+GameData[i][13]+'/'+GameData[i][14]+'</font></A></td>';
     //0~1赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][15]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=6&type=0~1\"><font color=\"#FF0000\">'+GameData[i][16]+'/'+GameData[i][17]+'</font></A></td>';
     //2~3赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][18]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=6&type=2~3\"><font color=\"#FF0000\">'+GameData[i][19]+'/'+GameData[i][20]+'</font></A></td>';
     //4~6赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][21]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=6&type=4~6\"><font color=\"#FF0000\">'+GameData[i][22]+'/'+GameData[i][23]+'</font></A></td>';
     //7up赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][24]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=6&type=OVER\"><font color=\"#FF0000\">'+GameData[i][25]+'/'+GameData[i][26]+'</font></A></td>';

    }//with(TR)
   }
  }//with(obj_table);
 }

//显示过关画面资料
 function ShowData_P(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen';
    else
     nowTR.className = 'm_cen_close';
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
     nowTD.innerHTML = '<BR>'+GameData[i][2];
     //场次
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //队伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
     //过关注单数量/金额
     nowTD = insertCell();
     nowTD.align = 'right';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=8\"><font color=\"#CC0000\">'+GameData[i][9]+'/'+GameData[i][12]+'</font></a><br>'+
                       '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=8\"><font color=\"#CC0000\">'+GameData[i][10]+'/'+GameData[i][13]+'</font></a><br>'+
                       '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=N&linetype=8\"><font color=\"#CC0000\">'+GameData[i][11]+'/'+GameData[i][14]+'</font></a>';
    }//with(TR)
   }
  }//with(obj_table);
 }

//显示已开赛画面资料
 function ShowData_PL(obj_table,GameData,data_amount)
 {
  with(obj_table)
  {
   //清除table资料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //开始显示开放中赛程资料
   for(i=0; i<data_amount; i++)
   {
    if(GameData[i][55] == 'N')
    {
     tr_class = 'm_cen';
     input_class = 'za_text_pd';
    }
    else
    {
     //tr_class = 'm_cen_close';
     //input_class = 'za_text_pd_close';
     tr_class = 'm_cen';
     input_class = 'za_text_pd';
    }
    nowTR = insertRow();
    nowTR.align = 'right';
    //nowTR.bgColor = '#FFFFFF';
    nowTR.className = tr_class;
    with(nowTR)
    {
     //日期时间
     nowTD = insertCell();
     nowTD.align = 'center';
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
     nowTD.align = 'center';
     nowTD.innerHTML = '<BR>'+GameData[i][2];
     //场次
     nowTD = insertCell();
     nowTD.align = 'center';
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //队伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#006600\">'+draw+'</font></div>';

     //让球/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr align=right>';
     //开始写入赔率
     if(GameData[i][7] == 'H') //强队是主队
     {
      ratio_RH = GameData[i][9];
      ratio_RC = '&nbsp';
     }
     else  //强队是客队
     {
      ratio_RH = '&nbsp';
      ratio_RC = GameData[i][10];
     }
     nowTD.innerHTML = '<table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr align=right><td width=\"50\"><font color=#0000bb>'+ratio_RH+'</font>&nbsp;</td>'+
		'<td width=\"30\">'+GameData[i][11]+'&nbsp;</td>'+
		'<td ><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=R\"><font color=\"#FF0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
                '<tr align=right><td width=\"50\"><font color=#0000bb>'+ratio_RC+'</font>&nbsp;</td>'+
                '<td width=\"30\">'+GameData[i][12]+'&nbsp;</td>'+
                '<td ><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=R\"><font color=\"#FF0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td>'+
                '</tr></table></td>';
     //走地
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=RE\"><font color=\"#FF0000\">'+GameData[i][17]+'/'+GameData[i][19]+'</font></a><br>'+
                       '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=RE\"><font color=\"#FF0000\">'+GameData[i][18]+'/'+GameData[i][20]+'</font></a>';
     //上下盘/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=OU\"><font color=\"#FF0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=OU\"><font color=\"#FF0000\">'+GameData[i][22]+'/'+GameData[i][24]+'</font></A>';
     //走地大小/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=ROU\"><font color=\"#FF0000\">'+GameData[i][51]+'/'+GameData[i][53]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=ROU\"><font color=\"#FF0000\">'+GameData[i][52]+'/'+GameData[i][54]+'</font></A>';
     //独赢/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&linetype=1\"><font color=\"#FF0000\">'+GameData[i][25]+'/'+GameData[i][28]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&linetype=1\"><font color=\"#FF0000\">'+GameData[i][26]+'/'+GameData[i][29]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=N&linetype=1\"><font color=\"#FF0000\">'+GameData[i][27]+'/'+GameData[i][30]+'</font></A>';
     //波胆/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=4&st=1\"><font color=\"#FF0000\">'+GameData[i][31]+'/'+GameData[i][32]+'</font></A>';
     //单双/注单
     wargeEO = eval(GameData[i][33] + '+' + GameData[i][35]); //单双注单加总
     goldEO = eval(GameData[i][34] + '+' + GameData[i][36]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=T&rtype=EO&st=1\"><font color=\"#FF0000\">'+wargeEO+'/'+goldEO+'</font></A>';
     //总入球/注单
     warge_A = eval(GameData[i][37] + '+' + GameData[i][39] + '+' + GameData[i][41] + '+' + GameData[i][43]);
     gold_A= eval(GameData[i][38] + '+' + GameData[i][40] + '+' + GameData[i][42] + '+' + GameData[i][44]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=T&rtype=T&st=1\"><font color=\"#FF0000\">'+warge_A+'/'+gold_A+'</font></A>';
     //半全场/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=14&st=1\"><font color=\"#FF0000\">'+GameData[i][56]+'/'+GameData[i][57]+'</font></A>';
     //过关/注单
     warge_RP = eval(GameData[i][45] + '+' + GameData[i][46] + '+' + GameData[i][47]); //主客队注单加总
     gold_RP = eval(GameData[i][48] + '+' + GameData[i][49] + '+' + GameData[i][50]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=P&st=1\"><font color=\"#FF0000\">'+warge_RP+'/'+gold_RP+'</font></A>';
     //半场让球
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][72]+'&type=H&linetype=12\"><font color=\"#FF0000\">'+GameData[i][58]+'/'+GameData[i][60]+'</font></a><br>'+
                       '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][72]+'&type=C&linetype=12\"><font color=\"#FF0000\">'+GameData[i][59]+'/'+GameData[i][61]+'</font></a>';
     //半场上下盘/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][72]+'&type=C&linetype=13\"><font color=\"#FF0000\">'+GameData[i][62]+'/'+GameData[i][64]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][72]+'&type=H&linetype=13\"><font color=\"#FF0000\">'+GameData[i][63]+'/'+GameData[i][65]+'</font></A>';

     //半场独赢/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][72]+'&type=H&linetype=11\"><font color=\"#FF0000\">'+GameData[i][66]+'/'+GameData[i][69]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][72]+'&type=C&linetype=11\"><font color=\"#FF0000\">'+GameData[i][67]+'/'+GameData[i][70]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][72]+'&type=N&linetype=11\"><font color=\"#FF0000\">'+GameData[i][68]+'/'+GameData[i][71]+'</font></A>';

     //0521
    }//with(TR)
   }
  }//with(obj_table);
 }

//显示特殊赛程画面资料
function ShowData_FS(obj_table,GameData,data_amount){
	with(obj_table){
		//清除table资料
		while(rows.length > 1) deleteRow(rows.length-1);
		//开始显示开放中赛程资料
		flag = 0;
		for(i=0; i<data_amount; i++){
			if(GameData[i][4] == 'Y'){
				tr_class = 'm_cen';
				input_class = 'za_text_f';
			}else{
				tr_class = 'm_cen_close';
				input_class = 'za_text_f_close';
			}
			nowTR = insertRow();
			nowTR.className = tr_class;
			//主队半全场资料显示
			with(nowTR){
				//日期时间
				nowTD = insertCell();
				nowTD.innerHTML = GameData[i][1];
				//联盟
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
						  +'<br><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&linetype=14S&rtype='+GameData[i][_offset+3]+'\"><font color=red>'+GameData[i][_offset+2]+'</a></td>'+
						  '<td width=30>'+GameData[i][_offset+1]+'</td>';
					if(tx++ > 2){
						team_list=team_list+'</tr><tr class=\"'+tr_class+'\">';
						tx=0;
					}
				}
				nowTD = insertCell();
				nowTD.Align = 'left';
				nowTD.innerHTML = team_list+'<INPUT TYPE=\"HIDDEN\" NAME=\"'+GameData[i][0]+'teams\" value="'+GameData[i][3]+'"></form>';
				//功能选单
				/*
				nowTD = insertCell();
				nowTD.align = 'center';
				//是否为开放中
				if(GameData[i][_offset+6]=='Y')
				  //result_str='<A HREF=\"./FS_result.php?uid='+uid+'&gid='+GameData[i][0]+'\">'+result+'</A>';
				  result_str='<A HREF=\"./FS_result.php?uid='+uid+'&gid='+GameData[i][0]+'&tid='+GameData[i][_offset+5]+'\">'+result+'</A>';
				else
				  result_str=result;
				if(GameData[i][4] == 'Y')
					nowTD.innerHTML = '<A HREF=\"./function_FT.php?uid='+uid+'&rtype=fs&ltype='+ltype+'&game_open=N&gid='+GameData[i][0]+'\" target=\"body_var\">'+close+'</A> / '+
							  '<A href=\"javascript:\" onClick=\"chg_ratio_submit(\''+GameData[i][0]+'\');\" style=\"cursor:hand\">'+update+'</A><BR>'+
					        	  '<A HREF=\"javascript:\" onClick=\"window.open(\'../game_set/game_ctl_FT_sp.php?uid='+uid+'&gid='+GameData[i][0]+'\');\">'+set+'</A> / '+
					        	  result_str;
				else
					nowTD.innerHTML = '<A HREF=\"./function_FT.php?uid='+uid+'&rtype=fs&ltype='+ltype+'&game_open=Y&gid='+GameData[i][0]+'\" target=\"body_var\">'+open+'</A> / '+
							  '<A href=\"javascript:\" onClick=\"chg_ratio_submit(\''+GameData[i][0]+'\');\" style=\"cursor:hand\">'+update+'</A><BR>'+
					        	  '<A HREF=\"javascript:\" onClick=\"window.open(\'../game_set/game_ctl_FT_sp.php?uid='+uid+'&gid='+GameData[i][0]+'\');\">'+set+'</A> / '+
					        	  result_str;
				*/
			}
		}
	}//with(obj_table);
}


</script>
<!--SCRIPT language=javaScript src="/js/FT_agents_showgame.js" type=text/javascript></SCRIPT-->
<SCRIPT LANGUAGE="JAVASCRIPT">
<!--
 if(self == top) location='https://61.14.145.170/xn/app/control/agents/';
 var uid='<?=$uid?>'; //user's session ID
 var loading = 'Y'; //是否正在读取浏览页面
 var stype_var = ''; //目前读取变数值页面
 var ShowType = ''; //目前显示页面
 var ltype = 1; //目前显示line
 var spage = ''; //目前显示页面
 var dt_now = ''; //目前日期时间
 var aid='';
 var sel_league='';
 var pg = 0;
 var gamount = 0; //目前显示赛程数
 var GameFT = new Array(1024); //最多设定显示1024笔赛程
 for(var i=0; i<1024; i++){
 	GameFT[i] = new Array(37); //为各赛程宣告 37 个栏位
 }
// -->
</SCRIPT>
</head>

<frameset rows="0,*" frameborder="NO" border="0" framespacing="0">
  <frame name="body_var" scrolling="NO" noresize src="FT_future_var.php?uid=<?=$uid?>" >
  <frame name="body_browse" src="FT_future.php?uid=<?=$uid?>">
</frameset>
<noframes><body bgcolor="#FFFFFF">

</body></noframes>
</html>