<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		redirect('admin/auth/login');
		die;
		$this->load->view('user');
		
	}

	public function test(){
		if(!empty($_FILES) || $this->input->is_ajax_request()) {
			echo "here";
			dd($_POST['files'][0],false);
			dd($_FILES);

		}
		$this->load->view('test/file_upload');
	}

	public function testauth(){

		 // function authenticate() {
		    header('WWW-Authenticate: Basic realm="Sistema autentificaci�n UnoAutoSur"');
		    header('HTTP/1_0 401 Unauthorized');
		//    header("Status: 401 Access Denied"); 
		    echo "Unauthorized\n";
		    dd(getallheaders(),false);
		    dd($_SERVER);
		    exit;
		//  }

	}


}
