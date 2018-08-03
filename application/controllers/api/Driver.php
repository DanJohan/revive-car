<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
/*	    $this->load->helper('api');
	    $this->load->model('UserModel');
	    $this->load->library('mailer');
	    $this->load->library('textMessage');*/
	}

	public function login() {

		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if ($this->form_validation->run() == true){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$user = $this->UserModel->check_user_exits(array('username'=>$username));
			if($user){
				$is_verified = password_verify($password,$user['password']);
				if($is_verified){
					$response = array('status'=>true,'message'=>'Login successfully','user'=>$user);
				}else{
					$response = array('status'=>false,'message'=>'Your password doesn\'t match');
				}
			}else{
				$response = array('status'=>false,'message'=>'User detail not found');
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
		// To Do
	}

	public function createJob(){
		//Todo
	}

}// end of class
?>