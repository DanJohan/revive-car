<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends MY_Controller {
		public function __construct(){
			parent::__construct();
		$this->load->model('DriverModel');
		$this->load->model('UserModel');
		$this->load->model('ServiceEnquiryModel');

		if (!$this->session->userdata['is_manager_login'] == TRUE)
		{
		   redirect('workshop/auth/login'); //redirect to login page
		} 
		
		}
		public function index(){

			$data=array();

			$criteria['returnType'] = 'count';
			$data['driverCount'] =  $this->DriverModel->search($criteria);
			$data['userCount'] =  $this->UserModel->search($criteria);
			$data['enquiryCount'] =  $this->ServiceEnquiryModel->search($criteria);	
			//$data['view'] = 'workshop/dashboard/index';
			$this->renderView('workshop/dashboard/index', $data);
		}

	}

?>	
