<?php
// �趨��Ҫ���BOM�ĸ�Ŀ¼�����Զ�ɨ��������Ŀ¼���ļ���
$HOME = dirname(__FILE__);
// �����Windowsϵͳ���޸�Ϊ��$WIN = 1;
$WIN = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UTF8 BOM �����</title>
<style>
body { font-size: 10px; font-family: Arial, Helvetica, sans-serif; background: #FFF; color: #000; }
.FOUND { color: #F30; font-size: 14px; font-weight: bold; }
</style>
</head>
<body>
<?php
$BOMBED = array();
RecursiveFolder($HOME);
echo '<h2>These files had UTF8 BOM, but i cleaned them:</h2><p class="FOUND">';
foreach ($BOMBED as $utf) { echo $utf ."<br />\n"; }
echo '</p>';
// �ݹ�ɨ��
function RecursiveFolder($sHOME) {
 global $BOMBED, $WIN;
 $win32 = ($WIN == 1) ? "\\" : "/";
 $folder = dir($sHOME);
 $foundfolders = array();
 while ($file = $folder->read()) {
  if($file != "." and $file != "..") {
   if(filetype($sHOME . $win32 . $file) == "dir"){
    $foundfolders[count($foundfolders)] = $sHOME . $win32 . $file;
   } else {
    $content = file_get_contents($sHOME . $win32 . $file);
    $BOM = SearchBOM($content);
    if ($BOM) {
     $BOMBED[count($BOMBED)] = $sHOME . $win32 . $file;
     // �Ƴ�BOM��Ϣ
     $content = substr($content,3);
     // д�ص�ԭʼ�ļ�
     file_put_contents($sHOME . $win32 . $file, $content);
    }
   }
  }
 }
 $folder->close();
 if(count($foundfolders) > 0) {
  foreach ($foundfolders as $folder) {
   RecursiveFolder($folder, $win32);
  }
 }
}
// ������ǰ�ļ��Ƿ���BOM
function SearchBOM($string) { 
  if(substr($string,0,3) == pack("CCC",0xef,0xbb,0xbf)) return true;
  return false; 
}
?>
</body>
=======
<?php 
// �趨��Ҫ���BOM�ĸ�Ŀ¼�����Զ�ɨ��������Ŀ¼���ļ���
$HOME = dirname(__FILE__);
// �����Windowsϵͳ���޸�Ϊ��$WIN = 1;
$WIN = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UTF8 BOM �����</title>
<style>
body { font-size: 10px; font-family: Arial, Helvetica, sans-serif; background: #FFF; color: #000; }
.FOUND { color: #F30; font-size: 14px; font-weight: bold; }
</style>
</head>
<body>
<?php
$BOMBED = array();
RecursiveFolder($HOME);
echo '<h2>These files had UTF8 BOM, but i cleaned them:</h2><p class="FOUND">';
foreach ($BOMBED as $utf) { echo $utf ."<br />\n"; }
echo '</p>';
// �ݹ�ɨ��
function RecursiveFolder($sHOME) {
 global $BOMBED, $WIN;
 $win32 = ($WIN == 1) ? "\\" : "/";
 $folder = dir($sHOME);
 $foundfolders = array();
 while ($file = $folder->read()) {
  if($file != "." and $file != "..") {
   if(filetype($sHOME . $win32 . $file) == "dir"){
    $foundfolders[count($foundfolders)] = $sHOME . $win32 . $file;
   } else {
    $content = file_get_contents($sHOME . $win32 . $file);
    $BOM = SearchBOM($content);
    if ($BOM) {
     $BOMBED[count($BOMBED)] = $sHOME . $win32 . $file;
     // �Ƴ�BOM��Ϣ
     $content = substr($content,3);
     // д�ص�ԭʼ�ļ�
     file_put_contents($sHOME . $win32 . $file, $content);
    }
   }
  }
 }
 $folder->close();
 if(count($foundfolders) > 0) {
  foreach ($foundfolders as $folder) {
   RecursiveFolder($folder, $win32);
  }
 }
}
// ������ǰ�ļ��Ƿ���BOM
function SearchBOM($string) { 
  if(substr($string,0,3) == pack("CCC",0xef,0xbb,0xbf)) return true;
  return false; 
}
?>
</body>
>>>>>>> bf841b75f7a17bcbe0192419782a1ed7c86f8fa4
</html>