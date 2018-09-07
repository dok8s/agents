<?
Session_start();
if (!$_SESSION["sksk"])
{
    echo "<script>window.open('/index.php','_top')</script>";
    exit;
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

require_once('../../member/include/config.inc.php');
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID from web_world where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
    echo "<script>window.open('$site/index.php','_top')</script>";
    exit;
}
$shistory='message';
?>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link id="bs-css" href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<link rel="stylesheet" href="./css/loader.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">正在加载...</div>
</div>
<ul class="list-group">
    <li class="list-group-item active">历史公告讯息</li>
    <?
    $sqlCount = "select count(id) as count from web_marquee where level=4 order by id desc";
    $resultCount = mysql_query($sqlCount);
    $totalCount = mysql_fetch_array($resultCount);
    $totalCount = $totalCount['count'];

    $page = 1;
    $pageSize = 10;
    if (isset($_GET['page'])) {
        $page = intval($_GET['page']) ? intval($_GET['page']) : $page;
    }
    if (isset($_GET['pageSize'])) {
        $pageSize = intval($_GET['pageSize']) ? intval($_GET['pageSize']) : $pageSize;
    }
    $offset = ($page - 1) * $pageSize;
    $pageCount = ceil($totalCount/$pageSize);
    $prePage = ($page -1) ? $page -1 : 1;

    $nextPage = ($page + 1 > $pageCount) ? $pageCount : $page + 1;

    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
    if (false !== strpos($url, '&page')) {
        $urls = explode('&page', $url , 2);
        $url = $urls[0];
    }


    $nextUrlPage = $url . (false === strpos($url, '?') ? "?page={$nextPage}" : "&page={$nextPage}");
    $preUrlPage = false === strpos($url, '?') ? "?page={$prePage}" : "&page={$prePage}" ;

    //echo $sql;
    $sql="select id,date_format(ntime,'%y-%m-%d') as ntime,$shistory as message from web_marquee where level=4 order by id desc limit {$pageSize} offset {$offset}";
    $result = mysql_query($sql);
    $icount=1;
    while ($row = mysql_fetch_array($result))
    {
        ?>
        <li class="list-group-item <?php if(rand(1, 100)< 0):?> active<?php endif;?>" >
            <span class="badge"><?=$row['ntime']?></span>
            <h4 class="list-group-item-heading">
                <span class="label label-success">公告<?=$row['id']?></span>
            </h4>
            <p class="list-group-item-text">
                <?=$row['message']?>
            </p>
        </li>
        <?
        $icount++;
    }
    mysql_close();
    ?>
</ul>
<ul class="pagination">
    <li><a href="<?=$preUrlPage?>">&laquo;</a></li>
    <?php for($i = 1; $i <= $pageCount ; $i++ ):?>
        <li><a href="<?= $url . "&page={$i}"?>"><?= $i?></a></li>
    <?php endfor;?>
    <li><a href="<?=$nextUrlPage?>">&raquo;</a></li>
</ul>
</form>
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
</style>
