<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends MY_Controller {
		public function __construct(){
			parent::__construct();
			
		if (!$this->session->userdata['is_manager_login'] == TRUE)
		{
		   redirect('workshop/auth/login'); //redirect to login page
		} 
		}
		public function index(){
			$data['view'] = 'workshop/dashboard/index';
			$this->load->view('workshop/layout', $data);
		}

		 public function index2(){
			$data['view'] = 'workshop/dashboard/index2';
			$this->load->view('workshop/layout', $data);
		} 
	}

?>	