<?php
class dxf {
	public $systemroot = '';
	public $app_directory =  '';
	public $app_root = '';
	public $app_tmp = '';
	public $web_root = '';

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

}
?>
