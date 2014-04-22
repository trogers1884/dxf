<?php
session_start();
if(file_exists('system/dxf.class.php')){
	header( 'Location: https://' . $_SERVER['SERVER_NAME'] . pathinfo($_SERVER['PHP_SELF'] , PATHINFO_DIRNAME) . '/dxf.php') ;
}	else {
	print 'file does not exist';
	session_destroy();
}
?>
