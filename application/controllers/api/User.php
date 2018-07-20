<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends MY_Controller {

	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->helper('api');
	    $this->load->model('UserModel');
	    $this->load->library('mailer');
	}

	
	public function registerPhone()
	{

		
		if($this->input->method()!='post') {
			return;
		}
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

		$this->renderJson($response);
	}// end of registerPhone method

	public function otpVerify()
	{
		if($this->input->method()!='post') {
			return;
		}
	   $this->form_validation->set_rules('user_id', 'User id', 'trim|required');
	   $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
	   if ($this->form_validation->run() == true){
	   		$user_id = $this->input->post('user_id');
	   		$otp = $this->input->post('otp');
	   		

	   	   $is_verified = $this->UserModel->verifyOtp(array('id'=>$user_id,'otp'=>$otp));
	   	   if($is_verified){
	   	   		$update_data = array(
		   			'otp_verify'=>1
		   		);
	   	   		$this->UserModel->update($update_data,array('id'=>$user_id));
	   	   		$criteria['field'] = 'id,otp,otp_verify,created_at,updated_at';
				$criteria['conditions'] = array('id'=>$user_id);
				$criteria['returnType'] = 'single';

				$user= $this->UserModel->search($criteria);
	   	   		$response = array('status'=>true,'message'=>'OTP verified successfully','user'=>$user);
	   	   }else{

	   	   		$response = array('status'=>false,'message'=>array('otp'=>'OTP code doesn\'t match'));

	   	   }

	   }else{

	   		$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
	   }

	   $this->renderJson($response);

	}// end of otpVerify method

	public function register() {

		if($this->input->method()!='post') {
			return;
		}
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
		   		$criteria['field'] = 'id,otp,otp_verify,name,email,created_at,updated_at';
				$criteria['conditions'] = array('id'=>$user_id);
				$criteria['returnType'] = 'single';

				$user= $this->UserModel->search($criteria);
		   	   	$response = array('status'=>true,'message'=>'Record updated successfully','user'=>$user);

		   }else{

		   		$errors = $this->form_validation->error_array();
				$response = array('status'=>false,'message'=>$errors);
		   }

		   $this->renderJson($response);

	}// end of register method

	public function login() {

		if($this->input->method()!='post') {
			return;
		}

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


	    $this->renderJson($response);

	}// end of login method 


	public function  registerDevice() {
		if($this->input->method() != 'post'){
			return;
		}
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');

		$this->form_validation->set_rules('device_type', 'Device type', 'trim|required');

		$this->form_validation->set_rules('device_id', 'Device id', 'trim|required');

		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
			$update_data=array(
		   			'device_id'=>$this->input->post('device_id'),
		   			'device_type'=>$this->input->post('device_type')
		   	);

		   	$is_update = $this->UserModel->update($update_data,array('id'=>$user_id));
		   	if($is_update){
		   		$criteria['field'] = 'id,otp,otp_verify,name,device_id,device_type,email,created_at,updated_at';
				$criteria['conditions'] = array('id'=>$user_id);
				$criteria['returnType'] = 'single';

				$user= $this->UserModel->search($criteria);

		   		$response = array('status'=>true,'message'=>'Record updated successfully','user'=>$user);
		   	}else{
		   		$response = array('status'=>false,'message'=>'Something went wrong! Please try again');
		   	}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);

	}// end of registerDevice method

	public function sendOtpToChangePassword(){

		if($this->input->method() != 'post'){
			return;
		}

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true){

			$user_id = $this->input->post('user_id');

			$criteria['field'] = 'id,otp,otp_verify,name,device_id,device_type,email,created_at,updated_at';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';

			$user= $this->UserModel->search($criteria);

			if($user){
				$otp = generate_otp();
				$data = array(
					'phone'=>$user['phone'],
					'body' =>"Your one time password to change password is ".$otp
				);
				$message = send_sms($data);
				if($message->sid){
					$update_data=array(
						'change_password_otp'=>$otp,
					);
					$this->UserModel->update($update_data,array('id'=>$user_id));
					$response= array('status'=>true,'message'=>"OTP sent to your register phone",'user'=>$user);
				}else{
					$response = array('status'=>false,'message'=>$message); 
				}
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);

	}// end of sendOtpToChangePassword method






	public function verifyOtpToChangePassword() {

		if($this->input->method() != 'post'){
			return;
		}

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
			$otp = $this->input->post('otp');
			$is_verified = $this->UserModel->verifyOtp(array('id'=>$user_id,'change_password_otp'=>$otp));
			if($is_verified){

	   	   	$criteria['field'] = 'id,otp,otp_verify,name,device_id,device_type,email,created_at,updated_at';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';

			$user= $this->UserModel->search($criteria);
	   	   	$response = array('status'=>true,'message'=>'OTP verified successfully','user'=>$user);
	   	   }else{

	   	   		$response = array('status'=>false,'message'=>array('otp'=>'OTP code doesn\'t match'));

	   	   }
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);

	}


	public function changePassword() {

		if($this->input->method() != 'post'){
			return;
		}

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
	   		$options = [
			    'cost' => 12,
			];
	   		$update_data=array(
	   			'password'=>password_hash($this->input->post('password'),PASSWORD_BCRYPT,$options)
	   		);

	   		$this->UserModel->update($update_data,array('id'=>$user_id));
	   		$criteria['field'] = 'id,otp,otp_verify,name,device_id,device_type,email,created_at,updated_at';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';

			$user= $this->UserModel->search($criteria);

	   	   	$response = array('status'=>true,'message'=>'Password changed successfully','user'=>$user);

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}// end of changePassword method


	public function sendChangePasswordEmail(){

		if($this->input->method() != 'post'){
			return;
		}

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');

		if ($this->form_validation->run() == true){

			$user_id = $this->input->post('user_id');
			$user = $this->UserModel->get(array('id'=>$user_id));
			$password_hash= md5(uniqid(mt_rand(1000,9999),true));
			$link = base_url()."api/user/resetPassword/".$user['email']."/".$password_hash;

			$this->mailer->setFrom('info@revivecare.com');
			$this->mailer->addAddress($user['email']);
			$this->mailer->subject('Change password');
			$this->mailer->body($this->load->view('api/email/changePassword',array('user'=>$user,'link'=>$link),true));
			$this->mailer->isHTML();
			$mail=$this->mailer->send();
			$update_data = array(
				'password_reset_hash'=>$password_hash
			);

			$this->UserModel->update($update_data,array('id'=>$user_id));

	   		$criteria['field'] = 'id,otp,otp_verify,name,device_id,device_type,email,created_at,updated_at';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';

			$user= $this->UserModel->search($criteria);

	   	   	$response = array('status'=>true,'message'=>'Email has been sent successfully','user'=>$user);

		}else{

			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);

	}

	public function resetPassword($email,$hash) {

		if(!$email || !$hash){
			return ;
		}
		$data=array('email'=>$email,'hash'=>$hash);
		$this->load->view('api/passwordReset',$data);
	}

	public function changePasswordByEmail() {
		if($this->input->post('email')){
			$email= $this->input->post('email');
			$hash = $this->input->post('hash');
			$pwd = $this->input->post('pwd');

			$criteria['field'] = 'id,otp,otp_verify,name,device_id,device_type,email,created_at,updated_at';

			$criteria['conditions']=array('email'=>$email,'password_reset_hash'=>$hash);
			$criteria['returnType'] = 'single';
			$user = $this->UserModel->search($criteria);

			if($user){
				$user_id = $user['id'];
				$options = [
				    'cost' => 12,
				];

				$update_data= array(
					'password'=>password_hash($pwd,PASSWORD_BCRYPT,$options)
				);
				$this->UserModel->update($update_data,array('id'=>$user_id));
				$response = array('status'=>true,'message'=>'Password changed successfully!');
			}else{
				$response= array('status'=>false,'message'=>'User not found!');
			}
			
			$this->renderJson($response);
		}
	}// end of changePasswordByEmail method

	public function socialLogin() {

		if($this->input->method() != 'post'){
			return;
		}

		$login_type = $this->input->post('login_type');
		if($login_type=='G'){
			$this->form_validation->set_rules('gmail_id','Gmail id','trim|required');
		}elseif ($login_type=='F') {
			$this->form_validation->set_rules('facebook_id', 'Facebook_id', 'trim|required');
		}
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]|valid_email');

		$this->form_validation->set_rules('login_type', 'Login Type', 'trim|required');

		if ($this->form_validation->run() == true){

			$user_id = $this->input->post('user_id');

			$criteria['field'] = 'id,otp,otp_verify,gmail_id,facebook_id,name,device_id,device_type,email,created_at,updated_at';

			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';
			$user = $this->UserModel->search($criteria);


			$update_data= array(
				'name' => $this->input->post('name'),
				'email'=>$this->input->post('email'),
			);

			if($login_type=='G'){
				$update_data['gmail_id']= $this->input->post('gmail_id');
			}elseif ($login_type=='F') {
				$update_data['facebook_id']= $this->input->post('facebook_id');
			}
			$this->UserModel->update($update_data,array('id'=>$user_id));
			$user = $this->UserModel->search($criteria);

			$response = array('status'=>true,'message'=>"Login successfully",'user'=>$user);

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	} // end of socialLogin method

}// end of class
