<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends MY_Controller {
		public function __construct(){
			parent::__construct();

			if (!$this->session->userdata['is_admin_login'] == TRUE)
			{
			   redirect('admin/auth/login'); //redirect to login page
			} 

			$this->load->model('DriverModel');
			$this->load->model('WorkshopModel');

			$this->load->model('UserModel');
			$this->load->model('ServiceEnquiryModel');
			$this->load->model('CarModel');

			
		}

		public function index(){
			$data=array();
			$criteria['returnType'] = 'count';
			$data['driverCount'] =  $this->DriverModel->search($criteria);
			$data['userCount'] =  $this->UserModel->search($criteria);	
			$data['workshopCount'] =  $this->WorkshopModel->search($criteria);
			$data['enquiryCount'] =  $this->ServiceEnquiryModel->search($criteria);	
			
			//$data['view'] = 'admin/dashboard/index';
			$this->render('admin/dashboard/index', $data);
			//$this->load->view('admin/layout', $data);
		}

	}

?>	
