<?php

$conditionedsid = $dbsys->quote($_SESSION['sid']);
$pst = '
PREPARE pst_authenticationstatus(text) AS
	SELECT COUNT(sid) as knt
	FROM session.session 
	WHERE sid = $1
		AND pkuser > 0 
		AND authenticated > 0;
';
$dbsys->exec($pst);
$arrSPErr = $dbsys->errorInfo();
if($arrSPErr[2]){
	print '<div>prepared statement ERR: ' . $arrSPErr[2] . '</div>';
	die('terminating script');
}
$sql = "EXECUTE pst_authenticationstatus ({$conditionedsid}) ";
$rs = $dbsys->query($sql);
$arrSSErr = $dbsys->errorInfo();
if($arrSSErr[2]){
	print '<div>sql script ERR: ' . $arrSSErr[2] . '</div>';
	die('terminating script');
}			
foreach($rs as $row){
	$knt = isset($row['knt']) ? $row['knt'] : 0;		
}
if($knt < 1){
	header( 'Location: https://' . $_SERVER['SERVER_NAME'] . pathinfo($_SERVER['PHP_SELF'] , PATHINFO_DIRNAME) . '/dxl.php') ;
}
?>
