<?
Session_start();
if (!$_SESSION["sksk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title_set {  background-color: #86C0A6; text-align: center}
-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <form name="LAYOUTFORM" action="" method=POST >
    <input type="HIDDEN" name="active" value="0">
    <tr> 
      <td class="m_tline"> 
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td width="85" >&nbsp;&nbsp;����</td>
          </tr>
        </table>
      </td>
      <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>
  </form>
</table>
  <table width="600" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
  <tr class="m_title_set"> 
    <td width="115" >�f���W��</td>
    <td width="115">�f���N�X</td>
    <td width="115">�ثe�ײv</td>
    <td width="115">�w�]�ײv</td>
  </tr>
  <tr  class="m_cen" > 
    <td>�H����</td>
    <td>USD</td>
    <td>1</td>
    <td>1</td>
  </tr>
  <tr  class="m_cen" > 
    <td>���</td>
    <td>HKD</td>
    <td>1.042</td>
    <td>1.07</td>
  </tr>
  <tr  class="m_cen" > 
    <td>����</td>
    <td>USD</td>
    <td>8.10</td>
    <td>8.3</td>
  </tr>
  <tr  class="m_cen" > 
    <td>����</td>
    <td>MYR</td>
    <td>2.13</td>
    <td>2.178</td>
  </tr>
  <tr  class="m_cen" > 
    <td>�s��</td>
    <td>SGD</td>
    <td>4.8</td>
    <td>4.76</td>
  </tr>
  <tr  class="m_cen" > 
    <td>����</td>
    <td>THB</td>
    <td>0.198</td>
    <td>0.1983</td>
  </tr>
  <tr  class="m_cen" > 
    <td>�^�S</td>
    <td>GBP</td>
    <td>14.5</td>
    <td>14</td>
  </tr>
  <tr  class="m_cen" > 
    <td>���</td>
    <td>JPY</td>
    <td>0.075</td>
    <td>0.076</td>
  </tr>
  <tr  class="m_cen" > 
    <td>�ڤ�</td>
    <td>EUR</td>
    <td>9.7</td>
    <td>9.7</td>
  </tr>
  <tr  class="m_cen" > 
    <td>�L����</td>
    <td>IND</td>
    <td>0.0008</td>
    <td>0.001</td>
  </tr>

</table>
</body>
</html>


