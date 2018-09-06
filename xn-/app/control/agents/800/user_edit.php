<?
Session_start();
if (!$_SESSION["bkbk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language,world from web_agents where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}


$mid=explode("-",$_REQUEST["mid"]);
$sid=$_REQUEST["sid"];
$aid=$_REQUEST["aid"];
$payway=$_REQUEST["payway"];
$type=$_REQUEST["type"];
$gold=$_REQUEST["gold"];
$send_form=$_REQUEST["send_form"];

if ($send_form=='OK'){
	switch($payway){
	case 'C':
		$no=$_REQUEST[cc1]-$_REQUEST[cc2]-$_REQUEST[cc3]-$_REQUEST[cc4]-$_REQUEST[authorize];	
		break;
	case 'A':
		$no=$_REQUEST[atm_no];			
		break;
	case 'W':
		$no=$_REQUEST[water_no];	
		break;
	}
	$bdate=date('Y-m-d');	
	$mysql="insert into sys800(payway,gold,type,memname,agents,world,curtype,indate,waterno) values ('$payway','$gold','$type','$mid[0]','$aid','$sid','$mid[1]','$bdate','$no')";
	mysql_query($mysql) or exit("error 1");
//	echo $mysql;

	$ok_alert = $type=='S' ? "alert('存入成功，待审核中');" : "alert('提出成功，待审核中');";
}



$row = mysql_fetch_array($result);

?>
<script language=javascript>
function showParent(){ 
  document.forms[0].sid.options.length=1;
  document.forms[0].sid.options[0].text="<?=$row['world']?>";
  document.forms[0].sid.options[0].value="<?=$row['world']?>";
}
function showChild(){
if(document.forms[0].sid.options[0].selected==true){
  document.forms[0].aid.options.length=1
  document.forms[0].aid.options[0].text="<?=$row['Agname']?>";
  document.forms[0].aid.options[0].value="<?=$row['Agname']?>";
  document.forms[0].aid.selectedIndex=0;
  return true
}
if(document.forms[0].sid.options[1].selected==true){
  document.forms[0].aid.selectedIndex=0;
  return true
}
}
</script>
<html>
<head>
<title>CashAdmin系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/800/control_800main.css" type="text/css">
</head>
<!--<base target="net_ctl_main">-->
<script language="JavaScript">
<?=$ok_alert?>
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
// -->

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>

      <script language="JavaScript">
function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("存入金额仅能输入数字!!"); return false;}
}

function Chg_Mcy(){
	curr=new Array();
	curr['RMB']=1;
curr['HKD']=1.045;
curr['USD']=8.12;
curr['MYR']=2.18;
curr['SGD']=4.9;
curr['THB']=0.21;
curr['GBP']=14.5;
curr['JPY']=0.078;
curr['EUR']=9.93;
curr['IND']=0.0009;

    tmp=document.all.mid.options[document.all.mid.selectedIndex].value;
    tmp=tmp.split("-");
	str=tmp[1];
	
	ratio=eval(curr[str]);
    tmp_count=ratio*eval(document.all.gold.value);
    document.all.mcy_gold.innerHTML=tmp_count;
}

function SubChk()
{
 if (document.all.type[0].checked==true){
 if (document.all.payway[0].checked==true) //选择信用卡
 {
   if (document.all.cc1.value.length < 4)
   {
     alert('请输入信用卡号第1组数字，补满四位');
     document.all.cc1.focus();
     return false;
   }
   if (document.all.cc2.value.length < 4)
   {
     alert('请输入信用卡号第2组数字，补满四位');
     document.all.cc2.focus();
     return false;
   }
   if (document.all.cc3.value.length < 4)
   {
     alert('请输入信用卡号第3组数字，补满四位');
     document.all.cc3.focus();
     return false;
   }
   if (document.all.cc4.value.length < 4)
   {
     alert('请输入信用卡号第4组数字，补满四位');
     document.all.cc4.focus();
     return false;
   }
   if (document.all.authorize.value.length==0)
   {
     alert('请输入授权码');
     document.all.authorize.focus();
     return false;
   }
 }

 if (document.all.payway[1].checked==true)//ATM
 {
   if (document.all.atm_no.value.length ==0)
   {
     alert('请输入atm号码');
     document.all.atm_no.focus();
     return false;
   }
 }

 if (document.all.payway[2].checked==true)//水单
 {
   if (document.all.water_no.value.length ==0)
   {
     alert('请输入水单号码');
     document.all.water_no.focus();
     return false;
   }
 }
}
 if (document.all.gold.value.length==0 || document.all.gold.value==0){
     alert('请输入金额');
     document.all.gold.focus();
     return false;
 }

 if (confirm('确定 存入/提出 该帐号??'))
 {
	 return true;
 }else{
	 return false;
 }
}


</script>
    
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C" onLoad="showParent();showChild();">
<div id="Layer1" style="position:absolute; left:183px; top:47px; width:65px; height:40px; z-index:1; visibility: hidden" onMouseOver="MM_showHideLayers('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')"> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" >
    <tr> 
      <td  class="mou"><a href="user_list.php?uid=<?=$uid?>" >帐户查询</a></td>
    </tr>
    <tr> 
      <td class="mou"  ><a href="user_edit.php?uid=<?=$uid?>">存入帐户</a></td>
    </tr>
  </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="183"><img src="/images/800/800_top_01.gif" width="183" height="29"></td>
    <td bgcolor="475854" class=m_title_he><font color="#FFFFFF">CashAdmin 线上客服系统</font></td>
  </tr>
  <tr height="18"> 
    <td><img src="/images/800/800_top_02.gif" width="183" height="19"></td>
    <td bgcolor="#2F4540" class="m_title_he1">&nbsp; &nbsp; <!--<a href="#" target="_top" onMouseOver="MM_showHideLayers('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')">帐户作业</a> 
      <font color="#FFFFFF"> - <a href=#>800作业</a> - </font>-->
	 <a href="user_list.php?uid=<?=$uid?>" >帐户查询</a> - 
	 <a href="user_edit.php?uid=<?=$uid?>" >存入帐户</a> - 
	 <a href="/index.php?uid=<?=$uid?>" target='_top'>登出</a></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline"></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_top">
      <table border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td >&nbsp;<img src="/images/control/zh-tw/main_dot.gif" width="13" height="15">&nbsp; 
          </td>
          <td ><font color="#000099">存入帐户</font></td>
        </tr>
      </table>
    </td>
    <td width="221"><img src="/images/800/800_title_p1.gif" width="221" height="31"></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0" class="m_tab">
  <tr>
    <td> 
      <form method="post" action="" target="_top" onSubmit="return SubChk()">
        <table width="600" border="0" cellspacing="1" cellpadding="0" class="m_tab_main">
          <tr bgcolor="E1E1D2"> 
            <td width="110" class="m_title">存入帐号</td>
            <td> &nbsp;总代理 
              <select name="sid"  class="za_select" onChange="showChild();showMem();Chg_Mcy();">
                <option value=''>---------------- </option>
              </select>
              &nbsp;&nbsp;代理商 
              <select name="aid"  class="za_select" onChange="showMem();Chg_Mcy();">
                <option value=''>---------------- </option>
              </select>
              &nbsp;&nbsp;会员 
		<select name="mid" class="za_select" onChange="Chg_Mcy();">
<?
$sql = "select id,memname,curtype from web_member where agents='$row[Agname]' and pay_type=1";
echo $sql;
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
	echo "<option value=$row[memname]-$row[curtype]>$row[memname]-$row[curtype]</option>";
}
?>              </select>
            </td>
          </tr>
          <tr bgcolor="E1E1D2"> 
            <td class="m_title">付款类别</td>
            <td > 
              <table width="450" border="0" cellspacing="0" cellpadding="0" class="m_tab_main">
                <tr> 
                  <td width="12"> 
                    <input type="radio" name="payway" value="C" class="za_dot" checked>
                  </td>
                  <td width="40">信用卡</td>
                  <td> 
                    <input type="text" name="cc1" size="4" maxlength="4" class="za_text_card">
                    - 
                    <input type="text" name="cc2" size="4" maxlength="4" class="za_text_card">
                    - 
                    <input type="text" name="cc3" size="4" maxlength="4" class="za_text_card">
                    - 
                    <input type="text" name="cc4" size="4" maxlength="4" class="za_text_card">
                  </td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td>授权码</td>
                  <td> 
                    <input type="text" name="authorize" size="4" maxlength="4" class="za_text_card">
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <input type="radio" name="payway" value="A" class="za_dot">
                  </td>
                  <td>ATM</td>
                  <td> 
                    <input type="text" name="atm_no" size="16" maxlength="16" class="za_text">
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <input type="radio" name="payway" value="W" class="za_dot">
                  </td>
                  <td>水单</td>
                  <td> 
                    <input type="text" name="water_no" size="16" maxlength="16" class="za_text">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr bgcolor="E1E1D2"> 
            <td class="m_title">方式</td>
            <td>
              <input type="radio" name="type" value="S" checked>
              存入 
              <input type="radio" name="type" value="T">
              提出 </td>
          </tr>
          <tr bgcolor="E1E1D2"> 
            <td class="m_title">金额</td>
            <td>&nbsp; 
              <input type="text" name="gold" size="10" maxlength="10" class="za_text" onKeyUp="Chg_Mcy();" onKeyPress="return CheckKey()" value="0">
              美金 :<font color=red id=mcy_gold>0</font></td>
          </tr>
          <tr bgcolor="E1E1D2"> 
            <td class="m_title">&nbsp;</td>
            <td align="center" height="30" > 
              <input type="submit" name="Submit" value="确定" class="za_button">
              &nbsp;&nbsp;&nbsp; 
              <input type="reset" name="Submit2" value="重设" class="za_button">
              <input type="hidden" name="send_form" value="OK">
              <input type="hidden" name="uid" value="<?=$uid?>">
            </td>
          </tr>
        </table>
</form>
    </td>
  </tr>
</table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="/images/800/800_title_p21b.gif">&nbsp;</td>
    <td width="18"><img src="/images/800/800_title_p22.gif" width="18" height="15"></td>
    <td width="200" class="m_foot">  &nbsp;&nbsp;Welcom to CashAdmin Online System</td>
  </tr>
</table>
</body>
</html>
<script language='javascript'>
function cancelMouse()
{
    return false;
}
document.oncontextmenu=cancelMouse;
</script>
