<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Driver extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('workshop/DriverModel');
		}

						
		public function view_driver(){
			$data=array();
			$data['driverData'][0] =  $this->DriverModel->get_all();
			$data['view'] = 'workshop/driver/view_driver';
			//print_r($data['all_manager'][0]);die;
			$this->load->view('workshop/layout', $data);

		  }


	}


?>