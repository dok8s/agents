<?
@define('WWW_DIR', './');

function dmfilename($path){
	$domain = str_replace('www.','',$_SERVER['HTTP_HOST']);
	$path = str_replace('{domain}',$domain,$path);
	return $path;
}
?>