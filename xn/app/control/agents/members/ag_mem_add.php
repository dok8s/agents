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
$sql = "select * from web_agents where oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agname=$row['Agname'];
$agid=$row['ID'];
$super=$row['super'];
$corprator=$row['corprator'];
$world=$row['world'];
$credit=$row['Credit'];
$count=$row['count'];
$keys=$_REQUEST['keys'];
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


if ($keys=='add'){

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
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	$mempasd=$_REQUEST['password'];
	$currency=$_REQUEST['currency'];
	$pay_type=$_REQUEST['pay_type'];
	$type=$_REQUEST['type'];
	$alias=$_REQUEST['alias'];
	$ratio=$_REQUEST['new_ratio'];
	$maxcredit=$_REQUEST['maxcredit'];
	$ratio=1;

	$chk=chk_pwd($mempasd);

	$mysql="select sum(Credit) as credit,count(*) as count from web_member where Agents='$agname'";//and status=1";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	

	if ($row['credit']+$maxcredit>$credit){
		echo wterror("此会员的信用额度为$maxcredit<br>目前代理商 最大信用额度为$credit<br>,所属会员累计信用额度为$row[credit]<br>已超过代理商信用额度，请回上一面重新输入");
		exit;
	}else{
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
		}
*/
		$typearr = array(1=>'A', 2=>'B', 3=>'C', 4=>'D');
		$type    = isset($typearr[$type]) ? $typearr[$type] : 'C';

		$mysql="select * from web_member where memname='$memname'";
		$result = mysql_query($mysql);
		$count=mysql_num_rows($result);
		if ($count>0){
			echo wterror("您输入的帐号 $memname 已经有人使用了，请回上一页重新输入");
			exit;
		}else{
			if ($pay_type==1){
				$maxcredit=0;
			}
			$mysql="insert into web_member(super,Memname,Passwd,Credit,Money,Alias,Agents,Opentype,addDate,lastpawd,corprator,world,pay_type,$skey) values ('$super','$memname','$mempasd','$maxcredit','$maxcredit','$alias','$agname','$type','$AddDate','$AddDate','$corprator','$world','$pay_type','$svalue')";
			//echo $mysql;
			mysql_query($mysql) or die ("操作失败11111!");
			$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','新增','$memname','会员',5)";
			mysql_query($mysql) or die ("操作失败!");
			echo "<script languag='JavaScript'>self.location='./ag_members.php?uid=$uid'</script>";
		}
	}
}else{

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
    <script src="/idz_indeziner/scriptaculous/lib/prototype.js" type="text/javascript"></script>
    <script src="/idz_indeziner/scriptaculous/src/effects.js" type="text/javascript"></script>
    <script type="text/javascript" src="/idz_indeziner/validation.js"></script>
    <script type="text/javascript">
        //<![CDATA[

// Alternative Style: Working With Alternate Style Sheets
// http://www.alistapart.com/articles/alternate/
            function setActiveStyleSheet(title) {
                var i, a, main;
                for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
                    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
                        a.disabled = true;
                        if(a.getAttribute("title") == title) a.disabled = false;
                    }
                }
            }
        //-->
        //]]>
    </script>
<style type="text/css">
<!--
.m_mem_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
    <link title="style1" rel="stylesheet" href="/idz_indeziner/style.css" type="text/css" />
    <link title="style2" rel="alternate stylesheet" href="/idz_indeziner/style2.css" type="text/css" />
    <link title="style3" rel="alternate stylesheet" href="/idz_indeziner/style3.css" type="text/css" />
    <script language="javascript" src="/js/set_odd_f.js"></script>
<SCRIPT>
function LoadBody(){
document.getElementById("type").value = "3";
show_count(0,"3");
show_Line_Date();
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
<style>
    .list-group {
        padding-left: 0;
        margin-bottom: 20px;
    }
    .list-group-item:first-child {
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
    }
    .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
        z-index: 2;
        color: #fff;
        background-color: #c12e36;
        border-color: #c12e36;
    }
    a:link {
        text-decoration: none;
    }
</style>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="LoadBody();Chg_Mcy('now');Chg_Mcy('mx')">
<ul class="list-group">
    <li class="list-group-item active" style="
    position: relative;
    display: block;
    padding: 10px 15px;
    font-size: 14px;">
        <a style="color:#ffffff;padding-right: 5px;" href="/xn/app/control/agents/members/ag_members.php?uid=<?=$uid?>"
           target="main" onMouseOver="window.status='会员'; return true;" onMouseOut="window.status='';return true;"><font>会员</font></a>
        >><span>新增会员</span>
    </li>
</ul>
<FORM NAME="myFORM" ACTION="ag_mem_add.php" METHOD=POST onSubmit="return SubChk()">
    <INPUT TYPE=HIDDEN NAME="keys" VALUE="add">
    <INPUT TYPE=HIDDEN NAME="username" VALUE="">
    <input type="hidden" name="aid" value="<?=$agid?>">
    <input type="hidden" name="ratio" value="">
    <input type="hidden" name="uid" value="<?=$uid?>">
    <input type="hidden" name="odd_f_str" value="">
<div class="style_changer" style="display: none;">
    <div class="style_changer_text">选择主题:</div>
    <input type="submit" value="1" onclick="setActiveStyleSheet('style1');" />
    <input type="submit" value="2" onclick="setActiveStyleSheet('style2');" />
    <input type="submit" value="3" onclick="setActiveStyleSheet('style3');" />
</div>

<div class="form_content">
    <form id="test" action="#" method="get">
        <fieldset>
            <legend>基本资料设定</legend>
            <div class="form-row">
                <div class="field-label"><label for="field1">账号(<font id="ag_count">_<?=substr($agname,0,3)?></font>)</label>:</div>
                <div class="field-widget"><input name="sname" id="sname" class="required"
                                                                                                     onKeyPress="return checkaccKey(event.keyCode);"
                                                                                                     title="帐号必须至少1个字元长，最多4个字元长，并只能有数字(0-9)，及英文大小写字母" />

                </div>
                <input class="reset" type="button" value="Check" onclick="ChkMem();" />
                <p style="color:red;">帐号必须至少1个字元长，最多4个字元长，并只能有数字(0-9)，及英文大小写字母</p>
            </div>

            <div class="form-row">
                <div class="field-label"><label for="field7">密码</label>:</div>
                <div class="field-widget">
                    <input type="password" name="password" id="password" class="required validate-password" title="Enter a password greater than 6 characters" />
                </div>
                <div class="field-widget" style="color:red;">密码必须至少6个字元长，最多12个字元长，并只能有数字(0-9)，及英文大小写字母</div>

            </div>


            <div class="form-row">
                <div class="field-label"><label for="field9">确认密码</label>:</div>
                <div class="field-widget"><input type="password" name="repassword" id="repassword" class="required validate-password-confirm" title="Enter the same password for confirmation" /></div>
            </div>

            <div class="form-row">
                <div class="field-label"><label for="field2">会员名称</label>:</div>
                <div class="field-widget"><input name="alias" id="alias" class="required" title="请输入会员名称！" /></div>
            </div>

        </fieldset>
        <fieldset>
            <legend>下注资料设定</legend>
            <div class="form-row">
                <div class="field-label"><label for="field4">总信用额度</label>:</div>
                <div class="field-widget"><input name="maxcredit" id="maxcredit" class="required" title="请填写总信用额度" onKeyUp="Chg_Mcy('mx');" onKeyPress="return CheckKey();"/></div>
                美金:<font color="#FF0033" id="mcy_mx">0</font> </td>
            </div>

            <div class="form-row">
                <div class="field-label"><label for="field5">现金额度</label>:</div>
                <div class="field-widget">0</div>
            </div>

            <div class="form-row">
                <div class="field-label"><label for="field6">开放球类</label>:</div>
                <div class="field-widget">
                    <select id="type" name="type" class="validate-selection" title="Choose your department" onChange="show_count(0,this.value);">
                        <option value="">请选择</option>
                        <option value="1">A盘</option>
                        <option value="2">B盘</option>
                        <option value="3">C盘</option>
                        <option value="4">D盘</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="field-label"><label for="field6">汇率设定</label>:</div>
                <div class="field-widget">
                    <select id="field6" name="currency" class="validate-selection" title="Choose your department" onChange="Chg_Mcy('now');Chg_Mcy('mx')">
                        <option value="RMB">美金 -> 美金</option>
                    </select>
                    目前汇率:<font color="#FF0033" id="mcy_now">0</font>&nbsp;(目前汇率仅供参考)</td>
                </div>
            </div>

            <div class="form-row-select">

                <fieldset>
                    <legend class="optional">投注方式</legend>
                    <label class="left">
                        <input type="radio" class="radio_input" name="pay_type" id="pay_type-male" value="0" onClick="MM_showHideLayers('Layer1','','hide')" checked/>信用额度 <br />
                    </label>
                    <label class="left">
                        <input type="radio" class="radio_input" name="pay_type" id="pay_type-female" value="1" onClick="MM_showHideLayers('Layer1','','show')"/>现金<br />
                    </label>

                </fieldset>

            </div>

        </fieldset>
        <input type="submit" class="submit" value="确认" /> <input class="reset" type="button" value="取消" onclick="valid.reset(); return false" />
    </form>
</div>
<script type="text/javascript">
    function formCallback(result, form) {
        window.status = "valiation callback for form '" + form.id + "': result = " + result;
    }

    var valid = new Validation('test', {immediate : true, onFormValidate : formCallback});
    Validation.addAllThese([
        ['validate-password', '> 6 characters', {
            minLength : 7,
            notOneOf : ['password','PASSWORD','1234567','0123456'],
            notEqualToField : 'field1'
        }],
        ['validate-password-confirm', 'please try again.', {
            equalToField : 'field8'
        }]
    ]);
</script>
</FORM>
<iframe id="getData" src="../../../../ok.html" width=0 height=0></iframe>

</body>
</html>
<SCRIPT>
var odd_f='H,M,I,E';
var Format=new Array();
Format[0]=new Array('H','香港盘','Y');
Format[1]=new Array('M','马来盘','Y');
Format[2]=new Array('I','印尼盘','Y');
Format[3]=new Array('E','欧洲盘','Y');
</SCRIPT>

<? 
}
?>