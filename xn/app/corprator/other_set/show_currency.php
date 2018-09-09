<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
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
.m_title_set {  background-color: #86C0A6; text-align: center}
-->
</style>
</head>
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<link rel="stylesheet" href="../css/loader.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" style="padding-left:20px;padding-top:10px;">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <form name="LAYOUTFORM" action="" method=POST >
    <input type="HIDDEN" name="active" value="0">
    <tr>
      <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
  </form>
</table>
  <table width="600" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" >
  <tr class="m_title_set">
    <td width="115" >Tên tiền tệ</td>
    <td width="115">Mã tiền tệ</td>
    <td width="115">Tỷ giá hối đoái</td>
    <td width="115">Tỷ giá hối</td>
  </tr>
  <tr  class="m_cen" >
    <td>Renminbi</td>
    <td>RMB</td>
    <td>1</td>
    <td>1</td>
  </tr>
  <tr  class="m_cen" >
    <td>Đô la Hồng Kông</td>
    <td>HKD</td>
    <td>1.042</td>
    <td>1.07</td>
  </tr>
  <tr  class="m_cen" >
    <td>Đô la Mỹ</td>
    <td>USD</td>
    <td>8.10</td>
    <td>8.3</td>
  </tr>
  <tr  class="m_cen" >
    <td>RM</td>
    <td>MYR</td>
    <td>2.13</td>
    <td>2.178</td>
  </tr>
  <tr  class="m_cen" >
    <td>Tiền tệ mới</td>
    <td>SGD</td>
    <td>4.8</td>
    <td>4.76</td>
  </tr>
  <tr  class="m_cen" >
    <td>Baht Thái</td>
    <td>THB</td>
    <td>0.198</td>
    <td>0.1983</td>
  </tr>
  <tr  class="m_cen" >
    <td>Bảng Anh</td>
    <td>GBP</td>
    <td>14.5</td>
    <td>14</td>
  </tr>
  <tr  class="m_cen" >
    <td>Tiền tệ Nhật Bản</td>
    <td>JPY</td>
    <td>0.075</td>
    <td>0.076</td>
  </tr>
  <tr  class="m_cen" >
    <td>Euro</td>
    <td>EUR</td>
    <td>9.7</td>
    <td>9.7</td>
  </tr>
  <tr  class="m_cen" >
    <td>Đồng rupiah Indonesia</td>
    <td>IND</td>
    <td>0.0008</td>
    <td>0.001</td>
  </tr>

</table>
</body>
</html>


