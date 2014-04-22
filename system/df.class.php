<?php
//$helloworld = '';
//$helloworld = '<div>hello world - df class test</div>';
class df {
	public $debug = false;
	public $hidden = '';

	public $systemroot = '';
	public $app_directory =  '';
	public $app_root = '';
	public $app_tmp = '';
	public $web_root = '';
	
	public $dbengine = '';
	public $dbhost = '';
	public $dbschema = '';
	public $dbname = '';
	public $dbuser = '';
	public $dbpwd = '';

	public $dbuengine = '';
	public $dbuhost = '';
	public $dbuschema = '';
	public $dbuname = '';
	public $dbuuser = '';
	public $dbupwd = '';

	public $authldap = 0;
	public $authencrypt = 0;
	public $authclear = 0;

	public $ldap_server = '';
	public $ldap_userelement = '';
	public $ldap_usercontainer = '';
	
//	public $ad;
//	public $adnmff;
	
	public $pk_user;
	public $netid;
	public $cid_user;
	public $xuid;
	
	public $logo = '';
	public $adopath = '';
	public $adopath2 = '';
	public $dba;
	public $dbu;
//	public $dbi;
	
	public $dftest = "test this";
	
	public $phpvar;
	
	function __construct() {
		$this->SystemRoot();
	}
	function SystemRoot(){
		$systemroot = $_SERVER['DOCUMENT_ROOT'];
		$app_uri = $_SERVER['PHP_SELF'];
		$app_uriparsed = pathinfo($app_uri);
		$app_directory =  $app_uriparsed['dirname'];
		$app_root = $systemroot.$app_directory;
		$web_root = $_SERVER['SERVER_NAME'].$app_directory;
		$this->systemroot = $systemroot;
		$this->app_directory =  $app_directory;
		$this->app_root = $app_root;
		$this->app_tmp = $this->app_root.'/tmp';
		$this->web_root = $web_root;
	}
	function Debug($prm){
		$this->debug = $prm;
		ini_set('display_errors',($this->debug?1:0));
		$this->hidden = $this->debug?'text':'hidden';
	}
	function ADODB(){
		require_once($this->adodbpath);
		require_once($this->adodbpath2);
	}

	function DB(){
		$this->dba = &ADONewConnection($this->dbengine);
		$this->dba->Connect($this->dbhost,$this->dbuser,$this->dbpwd,$this->dbname);// or die("Connection Failure<br>");
		$this->dba->debug = $this->debug;
	}
	function DBU(){
		$this->dbu = &ADONewConnection($this->dbuengine);
		$this->dbu->Connect($this->dbuhost,$this->dbuuser,$this->dbupwd,$this->dbuname);// or die("User Connection Failure<br>");
		$this->dbu->debug = $this->debug;
	}

	function Authenticate($netid,$netpwd){
		$mc_loginauthority = 2;
		$fail = "zAuthentication Failed. \n Please check netid and password.";
		$success = '';
		$pk_user = 0;
		$cid_user = 0;

		if($netid == '' || $netpwd == ''){
			$arr['success'] = $fail;
		}	else {
			$sql = "SELECT ".
				"fk_directory ".
				", mc_loginauthority ".
				"FROM public.userlogin ".
				"WHERE userid = '$netid' ".
				"  AND inactive = 0 ".
				//"  AND mc_loginauthority = $mc_loginauthority ".
				'';
			//$row = $this->dbu->GetRow($sql);
			$rs = $this->dbu->Execute($sql);
			$arr['err0'] = $this->dbu->ErrorMsg();
			$arr['sql0'] = $sql;
			foreach ($rs as $row){
				$pk_user = isset($row['fk_directory'])?$row['fk_directory']:0;
				$mc_loginauthority = isset($row['mc_loginauthority'])?$row['mc_loginauthority']:0;
				$sql1 = "SELECT ".
					"description ".
					", loginscript ".
					"FROM mc.mc_loginscript ".
					"WHERE mc_loginauthority = $mc_loginauthority ".
					"  AND active = 1 ".
					"ORDER BY ordinal ".
				'';
				$rs1 = $this->dbu->Execute($sql1);
				foreach($rs1 as $row1){
					if($success === true || $success == 'success'){
						break;
					}
					$thisdescr = isset($row1['description'])?$row1['description']:'';
					$arr['descr'] = $thisdescr;
					$thisscript = isset($row1['loginscript'])?$row1['loginscript']:'';
					if($thisscript != ''){
						eval($thisscript);
					}
				}	
				if($success === true || $success == 'success'){
					break;
				}
			}
			if($success == 'success'){
				// This is the place where Sara will capture login info
				//if($netid == 'sshaik' || $netid == 'trogers' ){
					$today = time();
					$sql_ad = "SELECT ".
						"loginid ".
						", passphrase ".
						", tslogin ".
						"FROM admigration.logininfo ".
						"WHERE loginid = '".$netid."' ".
					'';
					$row_ad = $this->dbu->GetRow($sql_ad);	
					if(isset($row_ad['loginid']) && $row_ad['tslogin'] < $today){
					
					//update the time of login and their paswword
					$sql_ad =  "UPDATE admigration.logininfo SET ".
						" passphrase = '{$netpwd}' ".
						", tslogin =  {$today} ".
						", mc_loginauthority = {$mc_loginauthority} ".
						" WHERE loginid = '".$netid."' ";
					'';
					$row_ad = $this->dbu->Execute($sql_ad);
					
					} else if (isset($row_ad['loginid'])){
					
					//dont do anything
					
					} else {
					// insert new record
					$sql_ad = "INSERT INTO admigration.logininfo ( ".
						"loginid ".
						", passphrase ".
						", tslogin ".
						", mc_loginauthority ".
						" ) VALUES ( ".
						" '{$netid}' ".
						", '{$netpwd}' ".
						", {$today} ".
						", {$mc_loginauthority} ".
						" ) ".
					'';
					$row_ad = $this->dbu->Execute($sql_ad);
					
					}
				//}
				
				
			
			
				//	END END END of the place where Sara has captured the login info
			
				$this->pk_user = $_SESSION['pk_user'] = $pk_user;
				$arr['pk_user'] = $pk_user;
				$arr['netid'] = $netid;
				$this->netid = $_SESSION['netid'] = $netid;
				$arr['banner'] = $success;

			}
		}
		$rtn = json_encode($arr);
		print $rtn;
	}
		
}	



$df = new df();

include($df->app_root.'/system/df.config.php');

// Instantiate the configuration settings
$df->Debug($conf['debug']);
$df->dbengine = $conf['dbengine'];
$df->dbhost = $conf['dbhost'];
$df->dbschema = $conf['dbschema'];
$df->dbname = $conf['dbname'];
$df->dbuser = $conf['dbuser'];
$df->dbpwd = $conf['dbpwd'];

$df->dbuengine = $conf['dbuengine'];
$df->dbuhost = $conf['dbuhost'];
$df->dbuschema = $conf['dbuschema'];
$df->dbuname = $conf['dbuname'];
$df->dbuuser = $conf['dbuuser'];
$df->dbupwd = $conf['dbupwd'];

$df->authldap = $conf['authldap'];
$df->authencrypt = $conf['authencrypt'];
$df->authclear = $conf['authclear'];
//$df->ldap_server = $conf['ldap_server'];
//$df->ldap_userelement = $conf['ldap_userelement'];
//$df->ldap_usercontainer = $conf['ldap_usercontainer'];


$df->logo = $conf['logo'];
$df->adodbpath = $conf['adodbpath'];
$df->adodbpath2 = $conf['adodbpath2'];

//$df->ad['base_dn'] = $conf['ad']['base_dn'];
//$df->ad['domain_controllers'] = $conf['ad']['domain_controllers'];
//$df->ad['account_suffix'] = $conf['ad']['account_suffix'];
//$df->ad['force_override'] = $conf['ad']['force_override'];

//$df->adnmff['base_dn'] = $conf['adnmff']['base_dn'];
//$df->adnmff['domain_controllers'] = $conf['adnmff']['domain_controllers'];
//$df->adnmff['account_suffix'] = $conf['adnmff']['account_suffix'];

//$df->adanesit['base_dn'] = $conf['adanesit']['base_dn'];
//$df->adanesit['domain_controllers'] = $conf['adanesit']['domain_controllers'];
//$df->adanesit['account_suffix'] = $conf['adanesit']['account_suffix'];


unset($conf);
$df->ADODB();

adodb_perf::table('logging.adodb_logsql');
$df->DB();
$df->DBU();

if($df->debug){
	$sql = "SELECT 1 as answ ";
	$row = $df->dba->GetRow($sql);
	print '<div>'.$row['answ'].'</div>';
	print $helloworld;
	var_dump($df);
}
?>