<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$id=$_REQUEST["id"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];

$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
$active=$_REQUEST["active"];
if ($sort==""){
	$sort='bettime';
}

if ($orderby==""){
	$orderby='desc';
}


$active=$_REQUEST["active"];
$sql = "select Agname,super from web_world where oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}else{
$super = $row['super'];
$agname = $row['Agname'];
$sql = "select danger,id,M_Name,TurnRate,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,BetType,Middle,BetScore,Gwin from web_db_io where world='".$row['Agname']."' and result_type=0 and super='$super' and hidden=0 order by ".$sort." ".$orderby;

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
$page_size=20;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
$result = mysql_query( $mysql);
$sql = "select wager,wager_sec from web_system";
$result4 = mysql_query($sql);
$row4 = mysql_fetch_array($result4);

$wager_sec=$row4['wager_sec']*1000;

?>
<script>if(self == top) parent.location='/'</script>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">

<link rel="stylesheet" href="/style/control/mem_body_ft.css" type="text/css">
<link rel="stylesheet" href="/style/control/mem_body_his.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
<script src="/js/prototype.js" type="text/javascript"></script>
<SCRIPT>

 function onLoad()
 {

  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }

	function refresh(){
		self.location.href='voucher.php?uid=<?=$uid?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>';
	}
	function reload()
{
    var url = '/app/member/include/showrecord.php';
    var pars = 'uid=<?=$uid?>';
    var myAjax = new Ajax.Request(
    url,{
        method: 'get',
        parameters: pars,
        onComplete: show3RecordResponse
    }
    );
}
function show3RecordResponse(originalRequest){
    var strRecord = originalRequest.responseText;
    if(strRecord!=0){
 			self.location.href='voucher.php?uid=<?=$uid?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>';
    }else{
    	window.setTimeout("self.reload()",<?=$wager_sec?>);
    }
}
</script>

<SCRIPT>window.setTimeout("self.reload()",<?=$wager_sec?>);</SCRIPT>

</HEAD>
<body onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onLoad="onLoad()">
<form name="myFORM" method="post" action="voucher.php?uid=<?=$uid?>">
<table width="773" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td width="3">&nbsp;
          </td>
    <td class="m_tline">Đặt cược --
	  <input name=button type=button class="za_button" onClick="refresh()" value="Đã cập nhật"></td>
    <td class="m_tline"> 排序：            <select name="sort" onChange="document.myFORM.submit();" class="za_select">
           <option value = "bettime"> Thời gian đặt cược </ option>
             <option value = "betscore"> Số tiền đặt cược </ option>
             <option value = "m_name"> tên thành viên </ option>
             <option value = "bettype"> loại đặt cược </ option>

           </ select>
               <select name = "orderby" onChange = "self.myFORM.submit ()" class = "za_select">
             <option value = "asc"> Tăng dần (nhỏ đến lớn) </ option>
             <option value = "desc"> Giảm dần (từ lớn đến nhỏ) </ option>
          </select>
</td>
        <td class="m_tline" align="right">Hiển thị<?=($page)*20?>-<?=($page+1)*20?>Hồ sơ, tổng số <?=$cou?> Hồ sơ bài viết <select name='page' onChange="self.myFORM.submit()">
<?
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			if ($i==$page){
				echo "<option selected value='$i'>".($i+1)."</option>";
			}else{
				echo "<option value='$i'>".($i+1)."</option>";
			}
		}
		?></select>
Tổng số trang <?=$page_count?> Trang </td>
    <td width="33"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="778" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">

        <tr class="m_title_ft">
          <td width = "61" align = "center"> Thời gian đặt cược </ td>
           <td width = "90" align = "center"> Số </ td>
           <td width = "90" align = "center"> Tên người dùng </ td>
           <td width = "60" align = "center"> Loại phát </ td>
           <td width = "200" align = "center"> Nội dung </ td>
           <td width = "100" align = "center"> cược </ td>
<td width = "100" align = "center"> Số tiền thắng </ td>
        </tr>
<?
while ($row = mysql_fetch_array($result))
{
?>
	<tr class="m_rig">
          <td align="center"><?=$row['BetTime'];?></td>
	  <td align="center"><?=show_voucher($row['LineType'],$row['ID'])?></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font></td>
          <td align="center"><?=str_replace(" ","",$row['BetType']);?>
<?
switch($row['danger']){
case 1:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;Xác nhận&nbsp;</b></font></font>';
	break;
case 2:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>Chưa được xác nhận</b></font></font>';
	break;
case 3:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;Xác nhận&nbsp;</b></font></font>';
	break;
default:
	break;

}
?>
</td>
          <td align="right"><?=$row['ShowTop'];?><?=$row['Middle'];?></td>
<td><?
$wager_vars_re=array('Ghi chú bình thường',
'bất thường',
'Hủy mục tiêu',
'Hủy thẻ đỏ',
'Cuộc đua của trò chơi',
'Sự kiện trì hoãn',
'Tỷ lệ cược lẻ',
'Không có giờ cộng / giờ',
'Người chơi bị kìm',
'Lỗi tên nhóm',
'Ghi chú xác nhận',
'Ghi chú chưa được xác nhận',
'Hủy');
    	if($row['status']>0){
    		echo '<s>'.mynumberformat($row['BetScore'],1).'</s>';
    	}else{
    		echo mynumberformat($row['BetScore'],1);
    	}?></td>

      <td>
      	<?
    	if($row['status']>0){
    		echo '<b><font color=red>['.$wager_vars_re[$row['status']].']</td>';
    	}else{
    		echo mynumberformat($row['Gwin'],1);
    	}?>
		</td>
        </tr>
<?
}
?>
     </table>
</form>
</BODY>
</html>
<?
}
$loginfo='Chi tiết ghi chú phun nước';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql);

mysql_close();
?>
