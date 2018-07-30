<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends MY_Controller {
		public function __construct(){
			parent::__construct();
		$this->load->model('workshop/DriverModel');
		$this->load->model('UserModel');
		
		if (!$this->session->userdata['is_manager_login'] == TRUE)
		{
		   redirect('workshop/auth/login'); //redirect to login page
		} 
		
		}
		public function index(){

			$data=array();
			//$data['driverData'] =  $this->DriverModel->get_all();
//dd($data['driverData']);
			//$data['userData'][0] =  $this->UserModel->get_all();*/
			$criteria['returnType'] = 'count';
			$data['driverCount'] =  $this->DriverModel->search($criteria);
			$data['userCount'] =  $this->UserModel->search($criteria);
			$data['view'] = 'workshop/dashboard/index';
			$this->load->view('workshop/layout', $data);
		}

		/* public function index2(){
			$data['view'] = 'workshop/dashboard/index2';
			$this->load->view('workshop/layout', $data);
		} */
	}

?>	