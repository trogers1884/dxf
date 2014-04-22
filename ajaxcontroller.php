<?php
session_start();
define("QUOTE","'");
define("DQUOTE",'"');
//include('system/incl.txtarea.php');
include('system/streamwrapper.class.php');
//include('system/df.class.php');


foreach($_POST as $key => $val){
	$$key = $val;
}
$dxajax = isset($dxajax) ? $dxajax : '';
$x = isset($x) ? $x : 0;
$y = isset($y) ? $y : '';

if($dxajax != ''){
	if($x > 0 && $y != ''){
		$sql = "SELECT pk ".
			", universalid as uuid ".
			"FROM public.app ".
			"WHERE pk = $x ".
			'';
		$row = $df->dba->GetRow($sql);
		$uuid = str_replace('-','_',$row['uuid']);
		$dxajax = $df->app_root.'/dfapp/'.$uuid.'/ajax/'.$dfajax;
		$dxajax = trim($dfajax);
	}
	include('system/incl.dbconn.php');
	include('system/fld.class.php');
	include_once('system/sql.class.php');
	include($dxajax);
}
?>