<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('DriverModel');
	    $this->load->model('ServiceEnquiryModel');
/*	    $this->load->helper('api');
	    $this->load->model('UserModel');
	    $this->load->library('mailer');
	    $this->load->library('textMessage');*/
	}

	public function login() {

		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if ($this->form_validation->run() == true){
			$phone = $this->input->post('phone');
			$password = $this->input->post('password');
			$driver = $this->DriverModel->check_driver_exists(array('d_phone'=>$phone));
			if($driver){
				$is_verified = password_verify($password,$driver['d_password']);
				if($is_verified){
					unset($driver['d_password']);
					$response = array('status'=>true,'message'=>'Login successfully','driver'=>$driver);
				}else{
					$response = array('status'=>false,'message'=>'Your password doesn\'t match');
				}
			}else{
				$response = array('status'=>false,'message'=>'Detail not found');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}


	    $this->renderJson($response);
	}

	public function verifyCustomerCode(){
		$this->form_validation->set_rules('code', 'Verfication code', 'trim|required');
		if ($this->form_validation->run() == true){
			$code = $this->input->post('code');
			$criteria['field'] = 'id';
			$criteria['conditions'] = array('verification_code'=>$code);
			$criteria['returnType'] = 'single';
			$enquiry = $this->ServiceEnquiryModel->search($criteria);
			if($enquiry){
				$response = array('status'=>true,'message'=>'Record found successfully!','data'=>$enquiry);
			}else{
				$response = array('status'=>false,'message'=>'No detail found!');
			}
			
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function getEnquiryDetail(){
		
	}
}
?>