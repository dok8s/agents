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
   case 'RE':	//走地
    ShowData_RE(show_table,GameFT,gamount);
    break;
   case 'PD':	//波胆
    ShowData_PD(show_table,GameFT,gamount);
    break;
   case 'EO':	//总入球
    ShowData_EO(show_table,GameFT,gamount);
    break;
   case 'P':	//过关
    ShowData_P(show_table,GameFT,gamount);
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
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]; //+'<div align=right><font color=\"#009900\">'+draw+'</font></div>';
     //让球/注单
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
	      '<tr align=\"right\">';
     //开始写入赔率
     if(GameData[i][7] == 'C') //强队是主队
     {
      $ratio_c = '&nbsp';
      $ratio_h = GameData[i][10];
      $ioratio_c = GameData[i][11];
      $ioratio_h = GameData[i][12];
     }
     else  //强队是客队
     {
      $ratio_c = GameData[i][9];
      $ratio_h = '&nbsp';
      $ioratio_c = GameData[i][11];
      $ioratio_h = GameData[i][12];
     }
     tmpStr += '<td width=\"48%\">'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
               '<td><a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=R\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
	       '<tr align=\"right\">'+
	       '<td>'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
	       '<td><a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=R\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td></tr>';
     tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
     nowTD.innerHTML = tmpStr;
     //上下盘/注单
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"52%\">'+GameData[i][17]+'&nbsp'+GameData[i][19]+'<br>'+
		       '<td><A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=OU\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></A></td></tr>'+
		       '<tr align=\"right\"><td>'+GameData[i][18]+'<br>'+
		       '<td><a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=OU\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][20]+'/'+GameData[i][22]+'</font></A></td></tr>'+
	 	       '<tr><td colspan=\"3\">&nbsp;</td></tr></table>';
     //独赢/注单
     //nowTD = insertCell();
     //nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"30%\" align=\"left\">'+GameData[i][25]+'<BR></td>'+
		       '<td><A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=M\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][28]+'/'+GameData[i][31]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][24]+'<BR></td>'+
		       '<td><A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=M\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][27]+'/'+GameData[i][30]+'</font></A></td></tr>'+
                       '</table>';
      	       '<tr><td colspan=\"3\">&nbsp;</td></tr></table>';
     //单双/注单
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"30%\" align=\"left\">'+GameData[i][33]+GameData[i][25]+'<BR></td>'+
		       '<td><A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=T&rtype=ODD\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][28]+'/'+GameData[i][31]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][34]+GameData[i][24]+'<BR></td>'+
		       '<td><A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=T&rtype=EVEN\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][27]+'/'+GameData[i][30]+'</font></A></td></tr>'+
                       '</table>';                  
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
     if(GameData[i][7] == 'C') //强队是主队
     {
      $ratio_h = GameData[i][10];
      $ratio_c = '&nbsp';
      $ioratio_h = GameData[i][11];
//      $ioratio_h = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ioratio.php?call=ou&type=H&rtype=RE&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][11]+'</A>';
      $ioratio_c = GameData[i][12];
     }
     else  //强队是客队
     {
      $ratio_h = '&nbsp';
      $ratio_c = GameData[i][9];
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
//      $ioratio_c = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ioratio.php?call=ou&type=C&rtype=RE&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][12]+'</A>';
     }
     tmpStr += '<td width=\"48%\">'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
               '<td><a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=RE\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
	       '<tr align=\"right\">'+
	       '<td>'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
	       '<td><a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=RE\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td></tr>';
     tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
     nowTD.innerHTML = tmpStr;
     //上下盘/注单
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"52%\">'+GameData[i][17]+'&nbsp'+GameData[i][19]+'<br></td>'+
		       '<td><A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=ROU\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></A></td></tr>'+
		       '<tr align=\"right\"><td>&nbsp'+GameData[i][18]+'<br></td>'+
		       '<td><A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=ROU\" target=\"_parent\"><font color=\"#CC0000\">'+GameData[i][20]+'/'+GameData[i][22]+'</font></A></td></tr>'+
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
//     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1];
     //联盟
     nowTD = insertCell();
//     nowTD.rowSpan = 2;
     nowTD.innerHTML = '<br>'+GameData[i][2];
     //队伍
     nowTD = insertCell();
     nowTD.align = 'left';
     //nowTD.innerHTML = '<a href=\"BK_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=PD\" onmouseover=\"javascript:show_bet(\''+GameData[i][6]+' vs '+GameData[i][5]+': '+GameData[i][36]+' / '+GameData[i][37]+'\');\";>'+GameData[i][5]+'</a>';
     nowTD.innerHTML = GameData[i][5]+'<br>'+GameData[i][6];
     
     //-----------------------------
     nowTD = insertCell();
     nowTD.align = 'right';
     nowTD.innerHTML = '<a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=PD\"><font color=\"#CC0000\">'+GameData[i][9]+'/'+GameData[i][10]+'</font></a>';    
     //-----------------------------
/*
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
*/
    }//with(TR)主队
    /*
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
    */
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
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=T&rtype=ODD\"><font color=\"#FF0000\">'+GameData[i][10]+'/'+GameData[i][11]+'</font></A></td>';
     //双数赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][12]+'<BR>'+
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=T&rtype=EVEN\"><font color=\"#FF0000\">'+GameData[i][13]+'/'+GameData[i][14]+'</font></A></td>';
     //0~1赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][15]+'<BR>'+
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=T&rtype=0~1\"><font color=\"#FF0000\">'+GameData[i][16]+'/'+GameData[i][17]+'</font></A></td>';
     //2~3赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][18]+'<BR>'+
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=T&rtype=2~3\"><font color=\"#FF0000\">'+GameData[i][19]+'/'+GameData[i][20]+'</font></A></td>';
     //4~6赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][21]+'<BR>'+
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=T&rtype=4~6\"><font color=\"#FF0000\">'+GameData[i][22]+'/'+GameData[i][23]+'</font></A></td>';
     //7up赔率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][24]+'<BR>'+
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=T&rtype=OVER\"><font color=\"#FF0000\">'+GameData[i][25]+'/'+GameData[i][26]+'</font></A></td>';
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
     nowTD.innerHTML = GameData[i][4]+'<BR>'+GameData[i][3];
     //队伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][6]+'<BR>'+GameData[i][5];
     //过关注单数量/金额
     nowTD = insertCell();
     nowTD.align = 'right';
     nowTD.innerHTML = '<a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=P\"><font color=\"#CC0000\">'+GameData[i][10]+'/'+GameData[i][13]+'</font></a><br>'+
                       '<a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=P\"><font color=\"#CC0000\">'+GameData[i][9]+'/'+GameData[i][12]+'</font></a><br>';
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
    nowTR = insertRow();
    nowTR.align = 'right';
    nowTR.bgColor = '#FFFFFF';
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
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#006600\">&nbsp</font></div>';

     //让球/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr align=right>';
     //开始写入赔率
     if(GameData[i][7] == 'C') //强队是主队
     {
      ratio_RC = '&nbsp';
      ratio_RH = GameData[i][10];
     }
     else  //强队是客队
     {
      ratio_RC = GameData[i][9];
      ratio_RH = '&nbsp';
     }
     nowTD.innerHTML = '<table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr align=right><td width=\"65\"><font color=#0000bb>'+ratio_RC+'</font>&nbsp;</td>'+
		'<td width=\"30\">'+GameData[i][11]+'&nbsp;</td>'+
		'<td ><a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=R\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][13]+'/'+GameData[i][15]+'</font></a></td></tr>'+
                '<tr align=right><td width=\"65\"><font color=#0000bb>'+ratio_RH+'</font>&nbsp;</td>'+
                '<td width=\"30\">'+GameData[i][12]+'&nbsp;</td>'+
                '<td ><a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=R\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][14]+'/'+GameData[i][16]+'</font></a></td>'+
                '</tr></table></td>';
/*
     //走地
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=RE\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][17]+'/'+GameData[i][19]+'</font></a><br>'+
                       '<a href=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=RE\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][18]+'/'+GameData[i][20]+'</font></a>';
*/
     //上下盘/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=OU\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][21]+'/'+GameData[i][23]+'</font></A><BR>'+
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=OU\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][22]+'/'+GameData[i][24]+'</font></A>';
/*
     //走地大小/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=ROU\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][51]+'/'+GameData[i][53]+'</font></A><BR>'+
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=ROU\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][52]+'/'+GameData[i][54]+'</font></A>';
*/
     //独赢/注单
     //单双/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=C&wtype=T&rtype=ODD\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][33]+'/'+GameData[i][34]+'</font></A><BR>'+
                       '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&type=H&wtype=T&rtype=EVEN\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][35]+'/'+GameData[i][36]+'</font></A><BR>';
/*
     //波胆/注单
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=PD&st=1\" target=\"_parent\"><font color=\"#FF0000\">'+GameData[i][31]+'/'+GameData[i][32]+'</font></A>';
     //单双/注单
     wargeEO = eval(GameData[i][33] + '+' + GameData[i][35]); //单双注单加总
     goldEO = eval(GameData[i][34] + '+' + GameData[i][36]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=T&rtype=EO&st=1\" target=\"_parent\"><font color=\"#FF0000\">'+wargeEO+'/'+goldEO+'</font></A>';
     //总入球/注单
     warge_A = eval(GameData[i][37] + '+' + GameData[i][39] + '+' + GameData[i][41] + '+' + GameData[i][43]);
     gold_A= eval(GameData[i][38] + '+' + GameData[i][40] + '+' + GameData[i][42] + '+' + GameData[i][44]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=T&rtype=T&st=1\" target=\"_parent\"><font color=\"#FF0000\">'+warge_A+'/'+gold_A+'</font></A>';
*/
     //过关/注单
     warge_RP = eval(GameData[i][45] + '+' + GameData[i][46] + '+' + GameData[i][47]); //主客队注单加总
     gold_RP = eval(GameData[i][48] + '+' + GameData[i][49] + '+' + GameData[i][50]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"BK_list_bet.php?uid='+uid+'&aid='+aid+'&gid='+GameData[i][0]+'&wtype=P&st=1\" target=\"_parent\"><font color=\"#FF0000\">'+warge_RP+'/'+gold_RP+'</font></A>';
    }//with(TR)
   }
  }//with(obj_table);
 }

