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
$sql = "select Agname,ID,super,count,language from web_agents where Oid='$uid'";

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
$count=$row['count'];

$langx='zh-cn';
require ("../../../member/include/traditional.$langx.inc.php");
$enable=$_REQUEST["enable"];

$enabled=$_REQUEST["enabled"];
$uname=$_REQUEST["uname"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
$mid=$_REQUEST["id"];
$active=$_REQUEST["active"];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
if ($enable==""){
	$enable='Y';
}

if ($sort=='' and $orderby==''){
	$order='';
}else if ($sort<>"" and $orderby==''){
	$order=' order by '.$sort." desc";
	$orderby='desc';
}else if ($sort=='' and $orderby<>''){
	$order=' order by alias '.$orderby;
	$sort='alias';
}else{
	$order=' order by '.$sort.' '.$orderby;
}
switch($enable){
case "Y":
	$enabled=1;
	$memstop='N';
	$stop=1;
	$start_font="";
	$end_font="";
	$caption1=$mem_disable;
	$caption2=$mem_enable;
	$xm="启用";
	break;
case "N":
	$enable='N';
	$memstop='Y';
	$enabled=0;
	$stop=0;
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(255,0,0);'>$mem_disable</SPAN>";
	$xm="停用";
	$caption1=$mem_enable;
	break;
default:
	//$enable='S';
	$memstop='Y';
	$enabled=2;
	$stop=2;
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(0,255,0);'>暂停</SPAN>";
	$caption1=$mem_enable;
	$xm="暂停";
	break;
}


if ($active==2){
/*
	if ($stop==1){
		$mysql="select count(*) as count from web_member where Agents='$agname' and status=1";
		$result = mysql_query($mysql);
		$row = mysql_fetch_array($result);

		if ($row['count']>=$count){
			echo wterror("醴?测烩妀 褫羲郔湮颇埜杅峈$count<br>,垀扽濛数颇埜杅峈$row[count]<br>眒闭彻测烩妀郔湮杅ㄛ?隙奻珨醱笭陔怀?");
			exit;
		}
	}
*/
	$sql = "select * from web_member  where id=$mid";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$mysql="update web_member set Status=$stop where id=$mid";
	mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','".$xm."','".$row["Memname"]."','会员',5)";
	mysql_query($mysql) or die ("操作失败!");
/*
	$mysql="select agents from web_member where ID=$mid";
	mysql_query( $mysql);

	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agents=$row['agents'];
	if ($stop==0){
		$mysql="update web_agents set mcount=mcount-1 where agname='$agents'";
	}else{
		$mysql="update web_agents set mcount=mcount+1 where agname='$agents'";
	}
	mysql_query( $mysql);*/
}
if($uname==""){
	$sql = "select ID,Memname,loginname,Alias,Credit,money,ratio,pay_type,date_format(AddDate,'%m-%d / %H:%i') as AddDate from web_member where Status=$enabled and Agents='$agname' and super='$super' ".$order;
}else{
	$sql = "select ID,Memname,loginname,Alias,Credit,money,ratio,pay_type,date_format(AddDate,'%m-%d / %H:%i') as AddDate from web_member where Memname='$uname' and Status=$enabled and Agents='$agname' and super='$super' ".$order;
}

$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=30;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";

$result = mysql_query( $mysql);

if ($cou<=0){
	$note='//';
}
$level=$_REQUEST['level']?$_REQUEST['level']:1;
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title {  background-color: #FEF5B5; text-align: center}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/account_management.css" type="text/css">
<link rel="stylesheet" href="/style/control/edit_agents2.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<SCRIPT>
    var uid='<?=$uid?>';
    var level='<?=$level?>';
    function ch_level(i)
    {
        if(i === 1) {
            self.location = '/xn/app/control/agents/members/ag_members.php?uid='+uid+'&level='+i;
        } else {
            self.location = '/xn/app/control/agents/ag_subuser.php?uid='+uid+'&level='+i;
        }

    }
function onLoad(){
	var obj_enable = document.getElementById('enable');
	obj_enable.value = '<?=$enable?>';
	var obj_page = document.getElementById('page');
	obj_page.value = '0';
	var obj_sort=document.getElementById('sort');
	obj_sort.value='';
	var obj_orderby=document.getElementById('orderby');
	obj_orderby.value='';
	var add_player ='Y';
	var obj_append=document.all('append');
	if(add_player =="N")
		obj_append.style.display ="none";
}
function ShowNumber(flag,check){
	if(check == "no"){
		if (flag == 1){
			top.mouseX = document.body.scrollLeft+event.clientX+25;
			top.mouseY = document.body.scrollTop+event.clientY+15;
			//subMitStr=actionstr;
		}
		document.getElementById('roundnumber').style.top = top.mouseY;
		document.getElementById('roundnumber').style.left = top.mouseX;
		document.getElementById("roundnumber").style.display = "block";
		reloadPHP.location='/xn/app/other_set/getroundnum_mem.php?uid=<?=$uid?>&layer=ag&userid=<?=$agname?>';
		return false;
	}else{
		//if (SubChk()) myFORM.submit();
		document.location='/xn/app/control/agents/members/ag_mem_add.php?uid=<?=$uid?>';
	}
}
function ChkSearch(){
	if (document.getElementById("mem_name").value == ""){
		alert("请输入预查询之帐号!");
	}else{
		self.location="./ag_members.php?mem_name="+document.getElementById("mem_name").value+"&uid=<?=$uid?>";
	}
}
</SCRIPT>
<SCRIPT language="javascript" src="/js/member.js"></script>
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann">
    <div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">会员</div>
    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">子账号</div>
</div>
<FORM NAME="myFORM" ACTION="/xn/app/control/agents/members/ag_members.php?uid=<?=$uid?>" METHOD=POST style="padding-top: 62px;">
<input type="hidden" name="agent_id" value="28752">
<table width="1024" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
<tr>
<td>
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr style="font-size: 15px;">
            <td>&nbsp;&nbsp;会员管理：</td>
            <td style="padding-right:30px;">
		<select name="enable" onChange="self.myFORM.submit()" class="za_select" >
                <option value="Y">请选择</option>
                <option value="Y">启用</option>
                <option value="N">停用</option>
                <option value="S">只能看帐</option>
                <option value="F">禁止登入</option>
              </select>
            </td>
            <?
            if ($cou>0){
            ?>
            <td>排序：</td>
            <td style="padding-right:30px;">
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="alias">会员名称</option>
                <option value="memname">会员帐号</option>
                <option value="adddate">新增日期</option>
              </select>
              <select id="super_agents_id" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc">升幂(由小到大)</option>
                <option value="desc">降幂(由大到小)</option>
              </select>
            <?
            }
            ?>
            </td>
            <td >总页数：</td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
              <?
              if ($page_count==0){
                  echo "<option value='0'>0</option>";
              }else{
                for($i=0;$i<$page_count;$i++){
                  echo "<option value='$i'>".($i+1)."</option>";
                }
              }
              ?>
              </select>
            </td>
            <td style="padding-right:30px;"> / <?=$page_count?> <?=$mem_page?></td>
            <td style="padding-right: 15px;">
              <input type="text" name="uname" id="uname" style="width: 120px;height: 30px;">&nbsp;
              <button type="button" class="btn btn-primary" onClick="document.myFORM.submit();">查询会员</button>
            </td>
            <td>
              <button type="button" class="btn btn-success" onClick="document.location='./ag_mem_add.php?uid=<?=$uid?>'">新增会员</button>
            </td>
            </td>
          </tr>
        </table>
</td>
</tr>
<tr>
</tr>
  <div class="container-fluid">
    <div class="row-fluid">
      <table class="table" style="width: 70%;margin-left:20px;">
        <thead>
        <tr style="background: #F4F1F1;height: 30px;">
          <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
            会员名称
          </th>
          <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
            会员账号
          </th>
          <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
            登录账号
          </th>
          <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
            信用额度
          </th>
          <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
            新增日期
          </th>
          <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:8%">
            账号状况
          </th>
          <th style="border: none;border-bottom: #bfbfbf 1px solid;white-space: nowrap;color: #3B3B3B;width:20%">
            功能
          </th>
        </tr>
        </thead>
        <tbody>
        <? if ($cou==0){
            ?>
          <tr class="m_title">
            <td>目前无任何会员</td>
          </tr>
            <?
        }else {
            ?>
            <?
            while ($row = mysql_fetch_array($result)) {
                ?>
              <tr class="">
                <!--<td>xli365</td>-->
                <td style="width:8%"><?= $row['Alias']; ?></td>
                <td style="width:8%"><?= $row['Memname']; ?></td>
                <td style="width:8%"><?= $row['loginname']; ?></td>
                <td style="width:8%"><? if ($row['pay_type'] == 1) {
                        echo mynumberformat($row['money'] * $row['ratio'], 2);
                    } else {
                        echo mynumberformat($row['Credit'] * $row['ratio'], 2);
                    } ?></td>
                <td style="width:8%"><?= $row['AddDate']; ?></td>
                <td style="width:8%"><?= $caption2 ?></td>
                <td align="left" style="width:20%">
                  <a HREF="#"
                     onClick="CheckENABLEPRI('/xn/app/control/agents/members/ag_members.php?uid=<?= $uid ?>&active=2&id=<?= $row['ID'] ?>&enable=<?= $memstop ?>','<?= $memstop ?>'); return false;"><?= $caption1 ?>
                    /</a>&nbsp;
                  <SPAN style="color:#000FF0">暂停</SPAN>
                  <a HREF="#"
                     onClick="MouEnter('/xn/app/control/agents/members/ag_members.php?uid=<?= $uid ?>&active=2&id=<?= $row['ID'] ?>&enable=S','S','/xn/app/control/agents/members/ag_members.php?uid=<?= $uid ?>&active=2&id=<?= $row['ID'] ?>&enable=F&enable_pri=N','N'); return false;">▼ </a>/&nbsp;
                  <a href="./ag_mem_edit.php?uid=<?= $uid ?>&mid=<?= $row['ID'] ?>&aid=<?= $agname ?>">修改资料</a>&nbsp;/&nbsp;
                  <a href="ag_mem_set.php?uid=<?= $uid ?>&pay_type=0&id=<?= $row['ID'] ?>&agents_id=<?= $agname ?>">详细设定</a>

                </td>
              </tr>
                <?
            }
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</table>
</form>

<div id="show_enable_table" style="display:none; position: absolute;" onMouseLeave="CLOSE_STOP_DIV();"></div>
<div id="showSW" style="display:none;">
	<table border="0" cellpadding="0" cellspacing="0" class="stop_div">
		<tr>
			<td><span class="stop_td"><SPAN style="color:#000FF0" >暂停</SPAN >	<a HREF="#" onClick="CLOSE_STOP_DIV(); return false;">▼ </a></span></td>
		</tr>
		<tr>
			<td class="stop_td stop_line"><a HREF="#" onClick="CheckENABLEPRI('*ACTION_PAUSE_TYPE*','*PAUSE_SHOW_TYPE*'); return false;">只能看帐</a>	</td>
		</tr>
		<tr>
			<td class="stop_td"><a HREF="#" onClick="CheckENABLEPRI('*ENABLE_PRI_URL*','*PRI_SHOW_TYPE*'); return false;">禁止登入</a>	</td>
		</tr>
	</table>
</div>
<!-- STOP DIV END-->	

<div id="show_table" style="visibility:hidden;position: absolute;"></div>
<div id="list" style="visibility:hidden;">
	<table border="0" cellpadding="1" cellspacing="1" class="ta_div">
		<tr class="m_title_ft_future">
			<td width=30>编号</td>
			<td width=100 >新帐号</td>
			<td width=100 >旧帐号</td>
			<td width=100 >修改日期</td>
		</tr>
		*LIST_RECORD*
		<tr><td colspan="4" class="m_cen"><input type="button" value="关闭" onClick="close_divs();" class="za_button"></td></tr>
	</table>
</div>
<div id="hidden_list" style="visibility:hidden;">
	<tr bgcolor="#F9FED3" align="center">
		<td>*NUMBER*</td>
		<td>*NEW_NAME*</td>
		<td>*OLD_NAME*</td>
		<td>*EDIT_DATE*</td>
	</tr>
</div>
<iframe id="showdata" name="showdata" scrolling="no" width="0" height="0" src="../../../../ok.html"></iframe>
<div id="roundnumber" style="position:absolute; display: block">
	<p><iframe id=reloadPHP name=reloadPHP frameborder="NO" framespacing="0" cellspacing="0" cellpadding="0"></iframe></p>
</div>
</body>
</html>
<style>
    .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
        z-index: 2;
        color: #fff;
        background-color: #c12e36;
        border-color: #c12e36;
    }

    .list-group-item:first-child {
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
    }
    .za_select {
        font-family: "Arial";
        font-size: 15px;
        height: 30px;
    }
</style>
<?
mysql_close();
?>
