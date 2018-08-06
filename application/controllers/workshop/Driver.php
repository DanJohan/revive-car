<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Driver extends MY_Controller {

		public function __construct(){
			parent::__construct();
		if (!$this->session->userdata['is_manager_login'] == TRUE)

		{
		   redirect('workshop/auth/login'); //redirect to login page
		} 
		
			$this->load->model('DriverModel');
		}

						
		public function view_driver(){
			$data=array();
			$mangar_id = $this->session->userdata('id');
			$data['driverData'] =  $this->DriverModel->get_all(array('d_workshop_assign'=>$mangar_id));
			//echo $this->db->last_query();die;
			$data['view'] = 'workshop/driver/view_driver';
			//print_r($data['all_manager'][0]);die;
			$this->load->view('workshop/layout', $data);

		  }


	}


?>