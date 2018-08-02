<<<<<<< HEAD
<?php

require ("./app/member/include/config.inc.php");
$level=$_GET['level'];
$uid=$_GET['uid'];

$tarr = array('','corprator','world','agents');

if(strlen($tarr[$level])>1){
	mysql_query("update web_$tarr[$level] set oid='',logintime='2008-01-01 12:00:00' where oid='$uid'");
}

echo "<script>top.location='/';</script>";
=======
<?php

require ("./app/member/include/config.inc.php");
$level=$_GET['level'];
$uid=$_GET['uid'];

$tarr = array('','corprator','world','agents');

if(strlen($tarr[$level])>1){
	mysql_query("update web_$tarr[$level] set oid='',logintime='2008-01-01 12:00:00' where oid='$uid'");
}

echo "<script>top.location='/';</script>";
>>>>>>> bf841b75f7a17bcbe0192419782a1ed7c86f8fa4
?>