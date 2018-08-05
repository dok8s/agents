<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select corprator,agname,id,credit,super from web_world where Oid='$uid' and Oid<>''";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agname=$row['agname'];
$agid=$row['id'];
$super=$row['super'];
$corprator=$row['corprator'];
$credit=$row['credit'];
$keys=$_REQUEST['keys'];

if ($keys=='add'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	$mempasd=$_REQUEST['password'];
	$currency=$_REQUEST['currency'];
	$pay_type=$_REQUEST['pay_type'];
	$agents=$_REQUEST['agents_id'];
	$chk=chk_pwd($mempasd);

	$ag=explode("--",$agents);

	$agents_id=$ag[0];
	$count=$ag[1];

	$type=$_REQUEST['type'];

switch ($type){
		case 1:
			$type="A";
			break;
		case 2:
			$type="B";
			break;
		case 3:
			$type="C";
			break;
		case 4:
			$type="D";
			break;
		}

	$alias=$_REQUEST['alias'];
	$ratio=$_REQUEST['ratio']+0;
	$ratio=1;

	$sql = "select * from web_agents where Agname='$agents_id'";
	$result = mysql_db_query($dbname,$sql);
	$row = mysql_fetch_array($result);
	$credit=$row['Credit'];
	$agents=$row['Agname'];
	$world=$row['world'];
	$corprator=$row['corprator'];
	$super=$row['super'];

	while (list($key, $value) = each($row)) {

		if (preg_match("/Scene/i",$key) || preg_match ("/Bet/i",$key) || preg_match ("/Turn/i",$key)){
			$tt=split('_',$key);
			$cou=count($tt);

			if (preg_match("/_Turn/i",$key)){
				if($cou==4 && $tt[3]=="$type"){
					$skey=$skey==''?str_replace("_$type",'',$key):$skey.','.str_replace("_$type",'',$key);
					$svalue=$svalue==''?$value:$svalue."','".$value;
				}else if($cou==3){
					$skey=$skey==''?$key:$skey.','.$key;
					$svalue=$svalue==''?$value:$svalue."','".$value;
				}else{
					//$skey=$skey==''?$key:$skey.','.$key;
					//$svalue=$svalue==''?$value:$svalue."','".$value;
				}
			}else{
				$skey=$skey==''?$key:$skey.','.$key;
				$svalue=$svalue==''?$value:$svalue."','".$value;
			}
		}
	}
	$svalue="'".$svalue."'";

		$maxcredit=$_REQUEST['maxcredit'];
	if ($agents_id==''){
		echo wterror("会员名称不能为空，请回上一面重新输入");
		exit();
	}

	if ($pay_type==1){
		$maxcredit=0;
	}

	$mysql="select sum(Credit) as credit,count(*) as count from web_member where Agents='$agents_id' and status=1";

	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);
/*
	if ($row['count']>=$count){
		echo wterror("目前代理商 可开最大会员数为$count<br>,所属累计会员数为$row[count]<br>已超过代理商最大数，请回上一面重新输入");
		exit;
	}
*/
	if ($row['credit']+$maxcredit>$credit){
		echo wterror("此会员的信用额度为$maxcredit<br>目前代理商 最大信用额度为$credit<br>,所属会员累计信用额度为".($row[credit]+0)."<br>已超过代理商信用额度，请回上一面重新输入");
		exit;
	}else{

		switch ($type){
		case 1:
			$type="A";
			break;
		case 2:
			$type="B";
			break;
		case 3:
			$type="C";
			break;
		case 4:
			$type="D";
			break;
		}
		$mysql="select * from web_member where memname='$memname'";
		$result = mysql_db_query($dbname,$mysql);
		$count=mysql_num_rows($result);
		if ($count>0){
			echo wterror("您输入的帐号 $memname 已经有人使用了，请回上一页重新输入");
			exit;
		}else{
			$mysql="insert into web_member(Memname,Passwd,Credit,Money,Alias,Agents,Opentype,AddDate,lastpawd,corprator,world,pay_type,super,$skey) values ('$memname','$mempasd','$maxcredit','$maxcredit','$alias','$agents_id','$type','$AddDate','$AddDate','$corprator','$agname','$pay_type','$super',$svalue)";
			mysql_db_query($dbname,$mysql) or die ("操作失败!");
			$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','新增','$memname','会员',4)";
			mysql_query($mysql) or die ("操作失败!");
			//$mysql="update web_agents set mcount=mcount+1 where agname='".$agname."'";
			//mysql_db_query($dbname,$mysql) or die ("操作失败!");
			echo "<script languag='JavaScript'>self.location='./su_members.php?uid=$uid'</script>";
		}
	}
}else{
				$mysql="select if(DATE_ADD(max(adddate),INTERVAL 60 second)>now(),0,1) as action from web_member where world='$agname' and status=1";
	$result = mysql_db_query($dbname,$mysql);
	$row = mysql_fetch_array($result);

	if ($row['action']==0){
echo "<meta http-equiv='Content-Type' content='text/html; charset=big5'>
<script>
alert('帐号处理中');
location.href = './su_members.php?&uid=$uid';
</script>";
		exit;
	}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_mem_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<SCRIPT>
function LoadBody(){
document.all.type.selectedIndex=document.all.type[0];
}
function SubChk(){
 	if(document.all.sname.value=='')
 		{ document.all.sname.focus(); alert("请输入帐号!!"); return false; }
	if(document.all.type.value=='')
		{ document.all.type.focus(); alert("请选择开放球类!!"); return false; }
	if(document.all.password.value=='')
		{ document.all.password.focus(); alert("密码请务必输入!!"); return false; }
	if(document.all.repassword.value=='')
	{ document.all.repassword.focus(); alert("确认密码请务必输入!!"); return false; }
	if(document.all.password.value != document.all.repassword.value)
		{ document.all.password.focus(); alert("密码确认错误,请重新输入!!"); return false; }
	if(document.all.alias.value=='')
		{ document.all.alias.focus(); alert("会员名称请务必输入!!"); return false; }
	if(document.all.pay_type[0].checked && (document.all.maxcredit.value=='0' || document.all.maxcredit.value==''))
 { document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; }
	if(!confirm("是否确定写入会员资料?")){return false;}
	document.all.username.value = document.all.ag_count.innerHTML+document.all.sname.value;

}
	function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
// -->

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
function show_count(w,s) {
	var org_str=document.all.ag_count.innerHTML
	switch(w){
		case 0:
			switch(s){
				case '1':document.all.ag_count.innerHTML = 'a'+org_str.substr(1,4);break;
				case '2':document.all.ag_count.innerHTML = 'b'+org_str.substr(1,4);break;
				case '3':document.all.ag_count.innerHTML = 'c'+org_str.substr(1,4);break;
				case '4':document.all.ag_count.innerHTML = 'd'+org_str.substr(1,4);break;
			}
			break;
		case 1:document.all.ag_count.innerHTML = org_str.substr(0,1)+s.substr(0,3);break;
	}
}


function Chg_Mcy(a){
	curr=new Array();
	curr_now=new Array();
	curr['RMB']=1;
curr['HKD']=1.07;
curr['USD']=8.3;
curr['MYR']=2.178;
curr['SGD']=4.76;
curr['THB']=0.1983;
curr['GBP']=14;
curr['JPY']=0.076;
curr['EUR']=9.7;
curr['IND']=0.001;
curr_now['RMB']=1;
curr_now['HKD']=1.042;
curr_now['USD']=8.10;
curr_now['MYR']=2.13;
curr_now['SGD']=4.8;
curr_now['THB']=0.198;
curr_now['GBP']=14.5;
curr_now['JPY']=0.075;
curr_now['EUR']=9.7;
curr_now['IND']=0.0008;


    if (document.all.ratio.value==''){
      tmp=document.all.currency.options[document.all.currency.selectedIndex].value;
	  ratio=eval(curr[tmp]);
      ratio_now=eval(curr_now[tmp]);
    }else{
	  ratio=eval(document.all.ratio.value);
      ratio_now=eval(document.all.ratio_now.value);
    }
    if (a=='mx')
    {
      tmp_count=ratio*eval(document.all.maxcredit.value);
      tmp_count=Math.round(tmp_count*100);
	  tmp_count=tmp_count/100;
      document.all.mcy_mx.innerHTML=tmp_count;
    }
    if (a=='now')
    {
      document.all.mcy_now.innerHTML=ratio_now;
    }
}

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("总信用额度仅能输入数字!!"); return false;}
}
function checkaccKey(keycode){
	if ((keycode>=65 && keycode<=90)  || (keycode>=97 && keycode<=122)||(keycode>=48 && keycode<=57)) return true;
 	return false;
}
function ChkMem(){
	D=document.all.ag_count.innerHTML+document.all.sname.value;
	document.getElementById('getData').src='su_mem_chk.php?uid=<?=$uid?>&langx=zh-tw&username='+D;
}
</SCRIPT>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="LoadBody();Chg_Mcy('now');Chg_Mcy('mx')">
<div id="Layer1" style="position:absolute; width:780px; height:26px; z-index:1; left: 0px; top: 268px; visibility: hidden; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000"></div>
 <FORM NAME="myFORM" ACTION="su_mem_add.php" METHOD=POST onSubmit="return SubChk()">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="add">
  <INPUT TYPE=HIDDEN NAME="username" VALUE="">
  <input type="hidden" name="aid" value="28752">
  <input type="hidden" name="ratio" value="">
  <input type="hidden" name="uid" value="<?=$uid?>">

  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
                <td width="125" >&nbsp;&nbsp;会员管理--新增及修改:</td>
            <td>
              <select name="agents_id" class="za_select" onChange="show_count(1,this.options[this.options.selectedIndex].text);">
                <option value=""></option>
          	<?
			$mysql="select ID,Agname,count from web_agents where status=1 and world='".$agname."' and subuser=0";
			$ag_result = mysql_db_query($dbname, $mysql);
			while ($ag_row = mysql_fetch_array($ag_result)){
				echo "<option value=".$ag_row['Agname']."--".$ag_row['count'].">".$ag_row['Agname']."</option>";
			}
			?>
              </select>
	</td>
      <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
</tr>
<tr>
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" >基本资料设定</td>
  </tr>
  <tr class="m_bc_ed">
    <td width="120" class="m_mem_ed"><input type=button name="chk" value="确认" class="za_button" onclick='ChkMem();'>  帐号:</td>
      <td>
      <font id="ag_count">___</font>
 <input type=TEXT name="sname" size=4 maxlength=4 class="za_text" onKeyPress="return checkaccKey(event.keyCode);">
 帐号必须至少1个字元长，最多4个字元长，并只能有数字(0-9)，及英文大小写字母
</td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_mem_ed">密码:</td>
      <td>
        <input type=PASSWORD name="password" size=12 maxlength=12 class="za_text">
        密码必须至少6个字元长，最多12个字元长，并只能有数字(0-9)，及英文大小写字母 </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_mem_ed">确认密码:</td>
      <td>
        <input type=PASSWORD name="repassword" size=12 maxlength=12 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed">
      <td class="m_mem_ed">会员名称:</td>
      <td>
        <input type=TEXT name="alias" size=10 maxlength=10 class="za_text">
      </td>
  </tr>
</table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" >下注资料设定</td>
    </tr>
    <tr class="m_bc_ed">
      <td width="120" class="m_mem_ed">开放球类:</td>
      <td>
        <select name="type" class="za_select" onChange="show_count(0,this.value);">
		<option value=""></option>
          <option value="1">A盘</option>
          <option value="2">B盘</option>
          <option value="3">C盘</option>
          <option value="4">D盘</option>
        </select>
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">投注方式:</td>
      <td><table border="0" cellspacing="0" cellpadding=0>
	<tr>
		<td>
			<input name="pay_type" class="za_select_02" type="radio" value="0" onClick="MM_showHideLayers('Layer1','','hide')" checked>
		</td>
		<td>
			信用额度
		</td>
		<td>
			<input name="pay_type" class="za_select_02" type="radio" value="1" onClick="MM_showHideLayers('Layer1','','show')">
		</td>
		<td>
			现金
		</td>
	</tr>
</table></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">汇率设定:</td>
      <td>
<select name="currency" class="za_select" onChange="Chg_Mcy('now');Chg_Mcy('mx')">
	  <option value="RMB">人民币 -> 人民币</option>
<!--option value="HKD">人民币 -> 港币</option>
<option value="USD">人民币 -> 美金</option>
<option value="MYR">人民币 -> 马币</option>
<option value="SGD">人民币 -> 新币</option>
<option value="THB">人民币 -> 泰铢</option>
<option value="GBP">人民币 -> 英磅</option>
<option value="JPY">人民币 -> 日币</option>
<option value="EUR">人民币 -> 欧元</option>
<option value="IND">人民币 -> 印尼盾</option-->

        </select>
        目前汇率:<font color="#FF0033" id="mcy_now">0</font>&nbsp;(目前汇率仅供参考)</td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">总信用额度:</td>
      <td>
        <input type=TEXT name="maxcredit" value="0" size=12 maxlength=12 class="za_text" onKeyUp="Chg_Mcy('mx');" onKeyPress="return CheckKey();">
        人民币:<font color="#FF0033" id="mcy_mx">0</font> </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">现金额度:</td>
      <td>0 </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">盘口玩法:</td>
      <td><font color="#800000">香港盘,马来盘,印尼盘,欧洲盘</font></td>
    </tr>
  </table>
	<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr align="center" bgcolor="#FFFFFF">
      <td>
        <input type=SUBMIT name="OK2" value="确定" class="za_button">
        &nbsp; &nbsp; &nbsp;
        <input type=BUTTON name="CANCEL2" value="取消" id="CANCEL" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>
</form>
<iframe id="getData" src="../../../../ok.html" width=0 height=0></iframe>
</body>
</html>
<?
}
?>

