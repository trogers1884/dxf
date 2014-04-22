<?php
session_start();
require_once('system/dbsys.php');
require_once('system/sessionmgr.php');
require_once('system/authenticationmgr.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<title id="pgtitle">DxF</title>
<?php
//process any app level css statements here
?>
<?php
//process any lib css statements here
?>
<?php
//process any page level css statements here
?>
<?php
//process any app level js statements here
?>
<?php
//process any lib js statements here
?>
<?php
//process any page level js statements here
?>
</head>
<body>
<?php
print "it's alive: " . date("Y-m-d h:m:s") . PHP_EOL;
print "<br>". $_COOKIE['PHPSESSID'] . PHP_EOL;
phpinfo();
?>
<?php
require_once('system/frmctrl.php');
?>
</body>
</html>

