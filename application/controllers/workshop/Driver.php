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
			//$data['view'] = 'workshop/driver/view_driver';
			//print_r($data['all_manager'][0]);die;
			$this->renderView('workshop/driver/view_driver', $data);

		}

		public function view_record_by_id($id){
			$data=array();
			$criteria['field'] = 'driver.*,workshop_manager.m_name,workshop_manager.m_workshop_location';
			$criteria['join'] = array(
				array('workshop_manager','driver.d_workshop_assign=workshop_manager.id','left'),
			);
			$criteria['conditions'] = array('driver.id'=>$id);
			$criteria['returnType'] = 'single';
			$data['driver_by_id'] =  $this->DriverModel->search($criteria);
			echo $this->load->view('workshop/driver/driver_view',$data,true);
			exit;
		  }


	}


?>
