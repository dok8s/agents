<?
error_reporting(0);
require ("app/member/include/config.inc.php");
$langx=$_REQUEST['langx'];
$sql = "select website,systime,systime1 from web_system";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if ($row['website']==1){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>System Maintenance</title>
<style type="text/css">
<!--
html, body { margin:0; padding:0; text-align:center; background:url(images/fix_bg.gif) repeat-x 0 298px; font-size:12px; font-family:Arial, Helvetica, sans-serif;}
body { padding-top:110px;}
#box {margin:0 auto;}
.main { background:url(images/fix_line.gif) no-repeat right top; text-align:left; color:#FFF;}
.main2 { text-align:left; color:#FFF;}
.info td  { padding-left:19px;text-align:left; }
p { line-height:24px; font-weight:bold; margin:8px  0 0;}
em {	font-style: normal;	font-weight: normal;}
td.email { padding-left:0;}
.foot { text-align:center; line-height:24px;}
-->
</style>
</head>
<body>
<? 
$m=date('m');
switch($m){
	case '1':
		$m_en="Jan";
		break;
	case '2':
		$m_en="Feb";
		break;
	case '3':
		$m_en="Mar";
		break;
	case '4':
		$m_en="Apr";
		break;
	case '5':
		$m_en="May";
		break;
	case '6':
		$m_en="Jun";
		break;
	case '7':
		$m_en="Jul";
		break;
	case '8':
		$m_en="Aug";
		break;
	case '9':
		$m_en="Sep";
		break;
	case '10':
		$m_en="Oct";
		break;
	case '11':
		$m_en="Nov";
		break;
	case '12':
		$m_en="Dec";
		break;
}
?>
<table width="1049" border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td align="right"><img src="images/fix_1.jpg" width="263" height="188" /><img src="images/fix_2.gif" width="613" height="188" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" height="219">
      <tr>
        <td valign="top" class="main"><table width="351" border="0" cellspacing="0" cellpadding="0" class="info">
          <tr>
            <td colspan="2"><img src="images/fix_3.gif" width="303" height="84" /></td>
          </tr>
          <tr>
            <td height="73" colspan="2" valign="top">
            <p>服务中断期间 - <em><?=date('Y')?>年<?=date('m')?>月<?=date('d')?>日</em><br />
           <?=date('m/d')?>   <?=$row['systime']?>（北京时间）</p>
            </td>
          </tr>
          <tr>
            <td width="147">电话号码: <br />
              +63 915 195 0193<br />
              +63 915 195 5533</td>
            <td valign="top" class="email">电子邮箱:<br />
royal888crown@hotmail.com</td>
          </tr>
        </table></td>
        <td valign="top" class="main"><table width="364" border="0" cellspacing="0" cellpadding="0" class="info">
          <tr>
            <td colspan="2"><img src="images/fix_4.gif" alt="" width="327" height="84" /></td>
          </tr>
          <tr>
            <td height="73" colspan="2" valign="top"><p>Service Disruption Period - <em><?=date('d')?> <?=$m_en?> <?=date('Y')?></em><br />
            <?=date('m/d')?>  <?=$row['systime']?>(GMT +08:00) </p></td>
          </tr>
          <tr>
            <td width="163">Telephone Nos.: <br />
              +63 915 195 0193<br />
+63 915 195 5533</td>
            <td valign="top" class="email">Email :<br />
              royal888crown@hotmail.com</td>
          </tr>
          </table></td>
        <td valign="top" class="main2"><table width="334" border="0" cellspacing="0" cellpadding="0" class="info">
          <tr>
            <td colspan="2"><img src="images/fix_5.gif" alt="" width="314" height="84" /></td>
          </tr>
          <tr>
            <td height="73" colspan="2" valign="top"><p>ระยะเวลาที่ไม่สามารถให้บริการ - <em><?=date('d')?> <?=$m_en?> <?=date('Y')?></em><br />
            <?=date('m/d')?>  <?=$row['systime']?>(GMT +08:00)</p></td>
          </tr>
          <tr class="info">
            <td width="164">เบอร์โทรศัพท์: <br />
              +63 915 195 0193<br />
+63 915 195 5533</td>
            <td valign="top" class="email">อีเมล:<br />
              royal888crown@hotmail.com</td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="foot">© Copyright  2006 - 2012  SBC.com</td>
  </tr>
</table>
<div style="display:none">
<script src="https://s95.cnzz.com/z_stat.php?id=1260314708&web_id=1260314708" language="JavaScript"></script></div>
</body>
</html>
<?
}else{
?>
<html>
<head>
<title>管理端</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<frameset rows="*,0" frameborder="NO" border="0" framespacing="0"> 
<frame name="ddnet_corp_index" src="new_index.php?type_chk=&langx=<?=$langx?>">
<frame name="ddnet_corp_func" scrolling="NO" noresize src="ok.html">
</frameset>
<noframes> 
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>
<?
}
?>
