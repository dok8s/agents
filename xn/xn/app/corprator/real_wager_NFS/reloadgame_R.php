<?
Session_start();
if (!$_SESSION["akak"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
$ntime=date('Y-m-d H:i:s');

require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");

$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$mtype=$_REQUEST['mtype'];
$rtype=$_REQUEST['rtype'];
$item_id=$_REQUEST['item_id'];
$area_id=$_REQUEST['area_id'];
$league_id=$_REQUEST['league_id'];
$gsdate=$_REQUEST['gsdate'];
$gedate=$_REQUEST['gedate'];

if($gsdate<>'' and $gedate<>''){
	$gtime=" and date_format(mstart,'%Y-%m-%d')>='$gsdate' and date_format(mstart,'%Y-%m-%d')<='$gedate'";
}else{

	$sql="select date_format(min(mstart),'%Y-%m-%d') as gsdate,date_format(max(mstart),'%Y-%m-%d') as gedate from sp_match where mstart>now()";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$gsdate=$row['gsdate'];
	$gedate=$row['gedate'];
}

if($item_id<>''){
	$itemid=' and lid='.($item_id+0);
}

if($league_id<>''){
	$leagueid=" and sleague_tw='".$league_id."'";
}

$sql = "select ID,Agname,language from web_corprator where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];
$langx=$row['language'];
require ("../../member/include/traditional.$langx.inc.php");

$sql="select GROUP_CONCAT(lea) as lea from (select concat(lid,'*',league_tw) as lea from sp_match where mstart>now() group by lid order by id desc) as s";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$leas=','.$row['lea'];

$sql="select GROUP_CONCAT(lea) as lea from (select concat(sleague_tw,'*',sleague_tw) as lea from sp_match where mstart>now() group by sleague_tw order by id desc) as s";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$lea2=','.$row['lea'];



$k=0;
$js='';
$js1='';
$sql = "select gtype,mid,mstart,mshow,league_tw as lea,sleague_tw as leas,mcount from sp_match where mstart>now() ".$itemid.$leagueid.$gtime." group by mid order by mstart";

$result1 = mysql_query( $sql);
$cou=mysql_num_rows($result1);
while ($row1=mysql_fetch_array($result1)){
	$gid=$row1['mid'];
	$sql="select count,score,id,mshow2,gid,team_tw as team,rate from sp_match as t left join (select mid,count(*) as count,sum(betscore) as score from web_db_io where linetype=16 and corprator='$agname' and result_type=0 group by mid order by id) as s on t.id=s.mid where t.mid=$gid order by rate,id ASC";
	$result = mysql_query( $sql);
	$str_data='';
	$str_data1='';

	while ($row=mysql_fetch_array($result)){
		if ($str_data==''){
			$str_data="'$row[mshow2]','$row[gid]','$row[team]','$row[id]','$row[rate]'";
		}else{
			$str_data=$str_data.",'$row[mshow2]','$row[gid]','$row[team]','$row[id]','$row[rate]'";
		}
		$c=$row['count']+0;
		$s=$row['score']+0;
		if ($str_data1==''){
			$str_data1="'$c','$s','0'";
		}else{
			$str_data1=$str_data1.",'$c','$s','0'";
		}
	}

	$js2="ordersFS[".$row1['mid']."]=new Array('".$row1['mid']."',$str_data1);";
	$js1="GameFT[$k]=new Array('".$row1['mid']."','".$row1['mstart']."','".$row1['leas']."','".$row1['lea'].'<br><a style="javascript;" '."openWin(\'AutoClose\',\'77\');>自動關閉</a>','".$row1['mshow']."','0','0','".$row1['mcount']."',".$str_data.",'".$row1['gtype']."');";
	$js1=$js1."\ngidx[".$row1['mid'].']='.$k.';';

	if($js==''){
		$js=$js1;
	}else{
		$js=$js."\n".$js1;
	}
	if($js3==''){
		$js3=$js2;
	}else{
		$js3=$js3."\n".$js2;
	}
	$k++;
}

?>

<meta http-equiv='Content-Type' content='text/html; charset=Big5'>
<script>
parent.sessions='2';
parent.nowtime='<?=$ntime?>';
parent.records=-1;
parent.gamount=<?=$k?>;
parent.totalcount=<?=$k?>;
top.set_account=0;
parent.dt_now ='<?=$ntime?>';
top.gsdate='<?=$gsdate?>';
top.gedate='<?=$gedate?>';
parent.totaldata='<?=$lea2?>';
parent.areasarray=',7*奧運,3*賽車,1*足球,5*其它 ,2*網球,6*高爾夫,4*桌球';
parent.itemsarray='<?=$leas?>';
var ordersFS=new Array();
var gidx=new Array();
var GameFT=new Array();
<?=$js?>;
<?=$js3?>
parent.GameFT=GameFT;
parent.gidx=gidx;
parent.ordersFS=ordersFS;
parent.showgame_table();
parent.ShowLeague('<?=$league_id?>');
parent.ShowArea('<?=$area_id?>');
parent.ShowItem('<?=$item_id?>');
</script>