<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select id,subuser,agname,subname,status,super,setdata from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$super=$row['super'];
$d1set = @unserialize($row['setdata']);
$level=$_REQUEST['level']?$_REQUEST['level']:4;
$sql = "select language,Agname from web_corprator where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$langx=$row['language'];
$agname=$row['Agname'];
$agname1=$row['Agname'];
require ("../../member/include/traditional.zh-vn.inc.php");

$keys=$_REQUEST['keys'];
if ($keys=='add'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	$mempasd=$_REQUEST['password'];
	$currency=$_REQUEST['currency'];
	$pay_type=$_REQUEST['pay_type'];
	$type=$_REQUEST['type'];
	$alias=$_REQUEST['alias'];
	$ratio=$_REQUEST['new_ratio'];
	$ratio=1;
	/*
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
		}*/
	$typearr = array(1=>'A', 2=>'B', 3=>'C', 4=>'D');
	$type    = isset($typearr[$type]) ? $typearr[$type] : 'C';

	$maxcredit=$_REQUEST['maxcredit'];
	$agname=$_REQUEST['agents_id'];
	$chk=chk_pwd($mempasd);

	$agents_id=$_REQUEST['agents_id'];
	if ($agents_id==''){
		echo wterror("Tên thành viên không được để trống. Vui lòng quay lại và nhập lại");
		exit();
	}

	$sql = "select * from web_agents where Agname='$agname'";
	$result = mysql_query($sql);
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

	$mysql="select sum(Credit) as credit from web_member where Agents='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	if ($row['credit']+$maxcredit>$credit){
		echo wterror("Giới hạn tín dụng của thành viên này là$maxcredit<br>Hạn mức tín dụng tối đa của đại lý hiện tại là$credit<br>,Giới hạn tín dụng tích lũy của thành viên lànum_format($row[credit],0)<br>Đã vượt quá giới hạn tín dụng đại lý, vui lòng quay lại và nhập lại");
		exit();
	}else{

		
		$mysql="select * from web_member where memname='$memname'";
		$result = mysql_query($mysql);
		$count=mysql_num_rows($result);
		if ($count>0){
			echo wterror("Tài khoản bạn đã nhập $memname Đã được sử dụng, vui lòng quay lại trang trước và nhập lại");
			exit;
		}else{
			if ($pay_type==1){
				$maxcredit=0;
			}
			$mysql="insert into web_member(Memname,Passwd,Credit,Money,Alias,Agents,pay_type,Opentype,AddDate,lastpawd,corprator,world,super,$skey) values ('$memname','$mempasd','$maxcredit','$maxcredit','$alias','$agents','$pay_type','$type','$AddDate','$AddDate','$corprator','$world','$super',$svalue)";
			
		mysql_query($mysql) or die ("Thao tác thất bại!");
			$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname1','新增','$memname','会员',3)";
		mysql_query($mysql) or die ("Thao tác thất bại!");
			//$mysql="update web_agents set mCount=mCount+1 where agname='".$agname."'";
			//mysql_query($mysql) or die ("操作失败!");
			echo "<script languag='JavaScript'>self.location='./su_members.php?uid=$uid'</script>";
		}
	}
}else{

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
 		{ document.all.sname.focus(); alert("Vui lòng nhập số tài khoản!!"); return false; }
	if(document.all.type.value=='')
		{ document.all.type.focus(); alert("Vui lòng chọn bóng mở!!"); return false; }
	if(document.all.password.value=='')
		{ document.all.password.focus(); alert("Vui lòng nhập mật khẩu của bạn!!"); return false; }
	if(document.all.repassword.value=='')
	{ document.all.repassword.focus(); alert("Vui lòng xác nhận mật khẩu và nhập mật khẩu.!!"); return false; }
	if(document.all.password.value != document.all.repassword.value)
		{ document.all.password.focus(); alert("Lỗi xác nhận mật khẩu, vui lòng nhập lại!!"); return false; }
	if(document.all.alias.value=='')
		{ document.all.alias.focus(); alert("Vui lòng nhập tên thành viên.!!"); return false; }
	if(document.all.pay_type[0].checked && (document.all.maxcredit.value=='0' || document.all.maxcredit.value==''))
 { document.all.maxcredit.focus(); alert("Vui lòng nhập tổng hạn mức tín dụng!!"); return false; }
	if(!confirm("Bạn có chắc chắn để viết thông tin thành viên??")){return false;}
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
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("Tổng hạn mức tín dụng chỉ có thể nhập số!!"); return false;}
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
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/account_management.css" type="text/css">
<link rel="stylesheet" href="/style/control/edit_agents2.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<script>
    var uid='<?=$uid?>';
    var level='<?=$level?>';
    function ch_level(i)
    {
        if(i === 1) {
            self.location = '/xn/app/corprator/cor_list.php?uid='+uid+'&level='+i;
        } else if(i === 2) {
            self.location = '/xn/app/corprator/super_agent/body_super_agents.php?uid='+uid+'&level='+i;
        } else if(i === 3) {
            self.location = '/xn/app/corprator/agents/su_agents.php?uid='+uid+'&level='+i;
        } else if(i === 4) {
            self.location = '/xn/app/corprator/members/su_members.php?uid='+uid+'&level='+i;
        } else if(i === 6) {
            self.location = '/xn/app/corprator/wager_list/wager_add.php?uid='+uid+'&level='+i;
        } else if(i === 5) {
            self.location = '/xn/app/corprator/su_subuser.php?uid=='+uid+'&level='+i;
        }else {
            self.location = '/xn/app/corprator/wager_list/wager_hide.php?uid='+uid+'&level='+i;
        }

    }
</script>

<link rel="stylesheet" href="../css/loader.css" type="text/css">
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="LoadBody();Chg_Mcy('now');Chg_Mcy('mx')">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann" style="position: relative;">
    <div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">Cổ đông</div>
    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">Đại lý tổng hợp</div>
    <div id="general_btn1" class="<? if ($level == 3) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(3);">Đại lý</div>
    <div id="important_btn1" class="<? if ($level == 4) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(4);">Thành viên</div>
    <div id="general_btn2" class="<? if ($level == 5) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(5);">Tài khoản phụ</div>
    <? if($d1set['d1_wager_add']==1){ ?>
        <div id="general_btn3" class="<? if ($level == 6) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(6);">Thêm tài khoản</div>
    <? } ?>
    <? if($d1set['d1_wager_hide']==1){ ?>
        <div id="general_btn4" class="<? if ($level == 7) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(7);">Tài khoản ẩn</div>
    <? } ?>
</div>
<div id="Layer1" style="position:absolute; width:780px; height:26px; z-index:1; left: 0px; top: 268px; visibility: hidden; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000"></div>
 <FORM NAME="myFORM" ACTION="su_mem_add.php" METHOD=POST onSubmit="return SubChk()" style="padding-left:20px;padding-top:10px;">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="add">
  <INPUT TYPE=HIDDEN NAME="username" VALUE="">
  <input type="hidden" name="aid" value="28752">
  <input type="hidden" name="ratio" value="">
  <input type="hidden" name="uid" value="<?=$uid?>">

  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
                <td width="150" >&nbsp;&nbsp;Quản lý thành viên--Thêm và sửa đổi:</td>
            <td>
              <select name="agents_id" class="za_select" onChange="show_count(1,this.options[this.options.selectedIndex].text);">
                <option value=""></option>
          	<?
			$mysql="select ID,Agname from web_agents where status=1 and corprator='".$agname."' and subuser=0";
			$ag_result = mysql_query( $mysql);
			while ($ag_row = mysql_fetch_array($ag_result)){
				echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";
			}
			?>
              </select>
	</td>
</tr>
<tr>
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" >Cài đặt dữ liệu cơ bản</td>
  </tr>
  <tr class="m_bc_ed">
    <td width="120" class="m_mem_ed"><input type=button name="chk" value="Xác nhận" class="za_button" onclick='ChkMem();'>  Số tài khoản:</td>
      <td>
      <font id="ag_count">___</font>
 <input type=TEXT name="sname" size=4 maxlength=4 class="za_text" onKeyPress="return checkaccKey(event.keyCode);">
Tài khoản phải có ít nhất 1 ký tự, dài tối đa 4 ký tự và chỉ có thể có số (0-9) và chữ hoa và chữ thường tiếng Anh
</td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_mem_ed">Mật khẩu:</td>
      <td>
        <input type=PASSWORD name="password" size=12 maxlength=12 class="za_text">
          Mật khẩu phải dài ít nhất 6 ký tự, dài tối đa 12 ký tự và chỉ có thể có số (0-9) và chữ hoa và chữ thường tiếng Anh.</td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_mem_ed">Xác nhận mật khẩu:</td>
      <td>
        <input type=PASSWORD name="repassword" size=8 maxlength=12 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed">
      <td class="m_mem_ed">Tên thành viên:</td>
      <td>
        <input type=TEXT name="alias" size=10 maxlength=10 class="za_text">
      </td>
  </tr>
</table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" >Cài đặt dữ liệu đặt cược</td>
    </tr>
    <tr class="m_bc_ed">
      <td width="120" class="m_mem_ed">Mở bóng:</td>
      <td>
        <select name="type" class="za_select" onChange="show_count(0,this.value);">
		<option value=""></option>
          <option value="1">A Đĩa</option>
          <option value="2">B Đĩa</option>
          <option value="3">C Đĩa</option>
          <option value="4">D Đĩa</option>
        </select>
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">Phương thức đặt cược:</td>
      <td><table border="0" cellspacing="0" cellpadding=0>
	<tr>
		<td>
			<input name="pay_type" class="za_select_02" type="radio" value="0" onClick="MM_showHideLayers('Layer1','','hide')" checked>
		</td>
		<td>
            Hạn mức tín dụng
		</td>
		<td>
			<input name="pay_type" class="za_select_02" type="radio" value="1" onClick="MM_showHideLayers('Layer1','','show')">
		</td>
		<td>
            Tiền mặt
		</td>
	</tr>
</table></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">Cài đặt tỷ giá hối đoái:</td>
      <td>
<select name="currency" class="za_select" onChange="Chg_Mcy('now');Chg_Mcy('mx')">
	  <option value="RMB">Renminbi -> Renminbi</option>


        </select>
          Tỷ giá hối đoái hiện tại:<font color="#FF0033" id="mcy_now">0</font>&nbsp;(Tỷ giá hối đoái hiện tại chỉ để tham khảo)</td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">Tổng hạn mức tín dụng:</td>
      <td>
        <input type=TEXT name="maxcredit" value="0" size=12 maxlength=12 class="za_text" onKeyUp="Chg_Mcy('mx');" onKeyPress="return CheckKey();">
          Đô la Mỹ:<font color="#FF0033" id="mcy_mx">0</font> </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_mem_ed">Số tiền hiện tại:</td>
      <td>0 </td>
    </tr>
  </table>
	<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr align="center" bgcolor="#FFFFFF">
      <td>
        <input type=SUBMIT name="OK2" value="Xác định" class="za_button">
        &nbsp; &nbsp; &nbsp;
        <input type=BUTTON name="CANCEL2" value="Hủy bỏ" id="CANCEL" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>
</form>
<iframe id="getData" src="../../../../ok.html" width=0 height=0></iframe>
</body>
</html>
<?
}
mysql_close();
?>

