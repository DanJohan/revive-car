<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiExplore extends MY_Controller {

	public function __construct() {
		//session_start();
		parent::__construct();
		if(!isset($_SESSION['dev_login']) || $_SESSION['dev_login'] ==false) {
			if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])
			    && $_SERVER['PHP_AUTH_USER'] === 'admin'
			    && $_SERVER['PHP_AUTH_PW'] === 'password' && !isset($_SESSION['dev_login'])) {
				$_SESSION['dev_login'] =true;
				unset($_SERVER['PHP_AUTH_USER']);
				unset($_SERVER['PHP_AUTH_PW']);
			    // User is properly authenticated...

			} else {
			    header('WWW-Authenticate: Basic realm="Secure Site"');
			    header('HTTP/1.0 401 Unauthorized');
			    exit('This site requires authentication');
			}
		}
	}
	public function index()
	{

		echo "your are logged in";
		
	}



}
