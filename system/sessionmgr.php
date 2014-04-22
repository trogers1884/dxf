<?php
function fncRedirect($redirect){
		if($redirect){
			header( 'Location: https://' . $_SERVER['SERVER_NAME'] . pathinfo($_SERVER['PHP_SELF'] , PATHINFO_DIRNAME) . '/dxf.php') ;					
		}
}

function sessionvalid() {
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

$oldsid = isset($_SESSION['sid']) ? $_SESSION['sid'] : '';
if(sessionvalid()){
	if($oldsid != session_id()){
		$newsid = $_SESSION['sid'] = session_id();
		$newsid = $dbsys->quote($newsid);
		if($oldsid == ''){
			$newipaddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
			$newipaddr = $dbsys->quote($newipaddr);
			$pst = '
			PREPARE pst_addsession(text, text) AS 
				INSERT INTO session.session (
					sid, ipaddress, lastaccess
				) VALUES (
					$1, $2, now()
				);
			';
			$dbsys->exec($pst);
			$arrSPErr = $dbsys->errorInfo();
			if($arrSPErr[2]){
				print '<div>prepared statement ERR: ' . $arrSPErr[2] . '</div>';
				die('terminating script');
			}
			$sql = "EXECUTE pst_addsession ({$newsid}, {$newipaddr}) ";
			$dbsys->exec($sql);
			$arrSSErr = $dbsys->errorInfo();
			if($arrSSErr[2]){
				print '<div>sql script ERR: ' . $arrSSErr[2] . '</div>';
				die('terminating script');
			}			
		}	else {
			$pst = '
			PREPARE pst_updatesession (text, text) AS
				UPDATE session.session SET 
					sid = $1 
					, lastaccess = now() 
				WHERE sid = $2
			';
			$dbsys->exec($pst);
			$arrSPErr = $dbsys->errorInfo();
			if($arrSPErr[2]){
				print '<div>prepared statement ERR: ' . $arrSPErr[2] . '</div>';
				die('terminating script');
			}
			$sql = "EXECUTE pst_updatesession ({$newsid}, {$oldsid}) ";
			$dbsys->exec($sql);
			$arrSSErr = $dbsys->errorInfo();
			if($arrSSErr[2]){
				print '<div>sql script ERR: ' . $arrSSErr[2] . '</div>';
				die('terminating script');
			}
		}
	}	else {
		$conditionedsid = $dbsys->quote($oldsid);
		$pst = '
		PREPARE pst_updatesessiontime (text) AS
			UPDATE session.session SET 
				lastaccess = now() 
			WHERE sid = $1
		';
		$dbsys->exec($pst);
		$arrSPErr = $dbsys->errorInfo();
		if($arrSPErr[2]){
			print '<div>prepared statement ERR: ' . $arrSPErr[2] . '</div>';
			die('terminating script');
		}
		$sql = "EXECUTE pst_updatesessiontime ({$conditionedsid}) ";
		$dbsys->exec($sql);
		$arrSSErr = $dbsys->errorInfo();
		if($arrSSErr[2]){
			print '<div>sql script ERR: ' . $arrSSErr[2] . '</div>';
			print '<div>sql: ' . $sql . '</div>';
			die('terminating script');
		}
	}			
}	else {
	session_regenerate_id();
	fncRedirect(true);
}
?>
