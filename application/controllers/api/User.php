<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends MY_Controller {

	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->helper('api');
	    $this->load->model('UserModel');
	}

	
	public function registerPhone()
	{

		
		if($this->input->method()=='post') {
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_unique[users.phone]');
			$this->form_validation->set_message('is_unique', 'The phone is already taken');
			if ($this->form_validation->run() == true) {
				$phone= $this->input->post('phone');
				$otp = generate_otp();
				$data = array(
					'phone'=>$phone,
					'body' =>"Your one time password is ".$otp
				);
				$message = send_sms($data);
				//print_r($message);die;
				if($message->sid){
					$register_data = array(
						'phone'=>$phone,
						'otp' => $otp,
						'created_at' => date("Y-m-d H:m:s")
					);
					$user_id = $this->UserModel->insert($register_data);
					if($user_id){
						$criteria['field'] = 'id,created_at,updated_at';
						$criteria['conditions'] = array('id'=>$user_id);
						$criteria['returnType'] = 'single';

						$user= $this->UserModel->search($criteria);
						if($user){
							$response= array("status"=>true,'message'=>"Record inserted successfully!",'user'=>$user);
						}
					}
				}else{
					$response = array('status'=>false,'message'=>$message); 
				}
			}else{
				$errors = $this->form_validation->error_array();
				$response = array('status'=>false,'message'=>$errors);
			}

			$this->data= $response;
			$this->renderJson($this->data);
		}
	}// end of registerPhone method

	public function otpVerify()
	{
		if($this->input->method()=='post') {
		   $this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		   $this->form_validation->set_rules('device_type', 'Device type', 'trim|required');
		   $this->form_validation->set_rules('device_id', 'Device id', 'trim|required');
		   $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		   if ($this->form_validation->run() == true){
		   		$user_id = $this->input->post('user_id');
		   		$otp = $this->input->post('otp');
		   		

		   	   $is_verified = $this->UserModel->verifyOtp(array('user_id'=>$user_id,'otp'=>$otp));
		   	   if($is_verified){
		   	   		$update_data = array(
			   			'device_type' => $this->input->post('device_type'),
			   			'device_id'=>$this->input->post('device_id'),
			   			'otp_verify'=>1
			   		);
		   	   		$this->UserModel->update($update_data,array('id'=>$user_id));
		   	   		$user = $this->UserModel->get(array('id'=>$user_id));
		   	   		$response = array('status'=>true,'message'=>'OTP verified successfully','user'=>$user);
		   	   }else{

		   	   		$response = array('status'=>false,'message'=>array('otp'=>'OTP code doesn\'t match'));

		   	   }

		   }else{

		   		$errors = $this->form_validation->error_array();
				$response = array('status'=>false,'message'=>$errors);
		   }

		   $this->data= $response;
		   $this->renderJson($this->data);

		}
	}// end of otpVerify method

	public function register() {

		if($this->input->method()=='post') {
			$this->form_validation->set_rules('name', 'Name', 'trim|required');

		   $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]|valid_email');

		   $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');

		   $this->form_validation->set_rules('user_id', 'User id', 'trim|required');

		   if ($this->form_validation->run() == true){
		   		$user_id = $this->input->post('user_id');
		   		$options = [
				    'cost' => 12,
				];
		   		$update_data=array(
		   			'name'=>$this->input->post('name'),
		   			'email'=>$this->input->post('email'),
		   			'password'=>password_hash($this->input->post('password'),PASSWORD_BCRYPT,$options)
		   		);

		   		$this->UserModel->update($update_data,array('id'=>$user_id));
		   		$user = $this->UserModel->get(array('id'=>$user_id));
		   	   	$response = array('status'=>true,'message'=>'Record updated successfully','user'=>$user);

		   }else{

		   		$errors = $this->form_validation->error_array();
				$response = array('status'=>false,'message'=>$errors);
		   }
		   $this->data= $response;
		   $this->renderJson($this->data);
		}

	}// end of register method

	public function login() {

		if($this->input->method()=='post') {

			$this->form_validation->set_rules('username', 'Phone or email', 'trim|required');
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

			$this->data= $response;
		    $this->renderJson($this->data);
		}
	}// end of login method 

}// end of class
