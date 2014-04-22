<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<title id="pgtitle">DxF Logon</title>
<link REL="StyleSheet" TYPE="text/css" HREF="system/css/logon.css">
<link REL="StyleSheet" TYPE="text/css" HREF="system/css/basebrand.css">
<link REL="StyleSheet" TYPE="text/css" HREF="system/css/workspace.css">
	<script type="text/javascript" src="/javascript/jquery/current/jquery.js"></script>
	<script type="text/javascript" src="system/js/dxl.js"></script>
	
</head>
<body>
<?php
include('system/branding/basebrand.php');
?>
<div id="workspace">
<form id="login">
    <h1>Log In</h1>
    <fieldset id="inputs">
        <input id="username" type="text" placeholder="Username" autofocus required>   
        <input id="password" type="password" placeholder="Password" required>
    </fieldset>
    <fieldset id="actions">
        <input type="submit" id="submit" value="Log in">
        <a href="">Forgot your password?</a><a href="">Register</a>
    </fieldset>
</form>
</div>
<?php
include('system/branding/footer.php');
?>
<?php
$dxfid = 1;
require_once('system/frmctrl.php');
?>
</body>
</html>
