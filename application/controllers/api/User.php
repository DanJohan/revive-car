<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Rest_Controller {

	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->helper('api');
	    $this->load->model('UserModel');
	    $this->load->library('mailer');
	    $this->load->library('textMessage');
	    $this->load->model('UserExternalLoginModel');
	}

	
	public function registerPhone()
	{	
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		if ($this->form_validation->run() == true) {
			$phone= $this->input->post('phone');
			$userInfo = $this->UserModel->checkPhoneExists($phone);

			$otp = generate_otp();
			$data = array(
					'phone'=>$phone,
					'body' =>$otp." otp for your mobile verification"
			);
			if(!$userInfo){
				
				$message = $this->textmessage->send($data);
				//print_r($message);die;
				if(is_object($message) && $message->sid){
					$register_data = array(
						'phone'=>$phone,
						'otp' => $otp,
						'created_at' => date("Y-m-d H:i:s")
					);
					$user_id = $this->UserModel->insert($register_data);
					if($user_id){
						$criteria['field'] = 'id,phone,created_at,updated_at';
						$criteria['conditions'] = array('id'=>$user_id);
						$criteria['returnType'] = 'single';

						$user= $this->UserModel->search($criteria);
						if($user){
							$response= array("status"=>true,'message'=>"Phone register successfully!",'user'=>$user);
						}
					}
				}else{
					$response= array("status"=>false,'message'=>'An error occured!Please try again!',);
				}
			}else{
				if($userInfo['otp_verify']){
					$response = array('status'=>true,'otp_verify'=>true,'message'=>'Phone number already registered','user'=>$userInfo);
				}else{
					$message = $this->textmessage->send($data);
					if($message->sid){
						$update_data = array(
							'otp'=>$otp
						);
						$this->UserModel->update($update_data,array('id'=>$userInfo['id']));
						$response = array('status'=>true,'otp_verify'=>false,'sms_send'=>true,'user'=>$userInfo,'message'=>'OTP send successfully');
					}else{
						$response = array('status'=>false,'otp_verify'=>false,'sms_send'=>false,'message'=>'Message not send! Please try again');
					}
				}
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}// end of registerPhone method

	public function otpVerify()
	{
	   $this->form_validation->set_rules('user_id', 'User id', 'trim|required');
	   $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
	   if ($this->form_validation->run() == true){
	   		$user_id = $this->input->post('user_id');
	   		$otp = $this->input->post('otp');
	   		
	   	   $is_verified = $this->UserModel->verifyOtp(array('id'=>$user_id,'otp'=>$otp));
	   	   if($is_verified){
	   	   		$update_data = array(
		   			'otp_verify'=>1,
		   			'otp'=>null,
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
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]|valid_email');
		$this->form_validation->set_rules('phone','Phone','trim|required|is_unique[users.phone]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		   if ($this->form_validation->run() == true){
				$file_name = '';
				if(isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['name'])) {
					$url = FCPATH."uploads/app/";	
					$config['new_name']=true;
					$upload =$this->do_upload('profile_image',$url,$config);
					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
					}
				}
		   		$insert_data=array(
		   			'name'=>$this->input->post('name'),
		   			'email'=>$this->input->post('email'),
		   			'phone' => $this->input->post('phone'),
		   			'profile_image'=>$file_name,
		   			'password'=>password_hash($this->input->post('password'),PASSWORD_BCRYPT),
		   			'created_at'=>date('Y-m-d H:i:s')
		   		);
		   		$insert_id = $this->UserModel->insert($insert_data);
		   		if($insert_id) {
			   		$criteria['field'] = 'id,phone,name,email,profile_image,created_at';
					$criteria['conditions'] = array('id'=>$insert_id);
					$criteria['returnType'] = 'single';
					$user= $this->UserModel->search($criteria);
					if(!empty($user['profile_image'])){
						$user['profile_image']=base_url().'uploads/app/'.$user['profile_image'];
					}
			   	   	$response = array('status'=>true,'message'=>'Record inserted successfully','user'=>$user);
				}else{
					$response = array('status'=>false,'message'=>'Something went wrong! Please try again.');
				}
		   }else{
		   		$errors = $this->form_validation->error_array();
				$response = array('status'=>false,'message'=>$errors);
		   }
		   $this->renderJson($response);
	}// end of register method

	public function login() {
		$this->form_validation->set_rules('username', 'Phone or email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == true){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$user = $this->UserModel->check_user_exits(array('username'=>$username));
			if($user){
				$is_verified = password_verify($password,$user['password']);
				if($is_verified){
					unset($user['password']);
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

	public function otpLogin(){
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		if ($this->form_validation->run() == true){
			$phone = $this->input->post('phone');
			$result = $this->UserModel->checkPhoneExists($phone);
			if($result){
				$otp = generate_otp();
				$data = array(
					'phone'=>$phone,
					'body' =>$otp." otp to login into your Revive auto care acccount."
				);
				$message = $this->textmessage->send($data);
				if(is_object($message) && $message->sid){
					$update_data = array(
						'otp'=>$otp,
					);
					$this->UserModel->update($update_data,array('phone'=>$phone));
					$response = array('status'=>true,'message'=>'OTP send successfully!');

				}else{
					$response= array("status"=>false,'message'=>'An error occured!Please try again!',);
				}
			}else{
				$response = array('status'=>false,'message'=>'Sorry,this phone number is not registerd with us!');
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function verifyLoginOtp(){
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		if ($this->form_validation->run() == true){
			$criteria ['field'] = "id,name,email,phone,created_at";
			$criteria['conditions'] = array('phone'=>$this->input->post('phone'),'otp'=>$this->input->post('otp'));
			$criteria['returnType'] ='single';
			$user = $this->UserModel->search($criteria);
			if($user){
				$this->UserModel->update(array('otp'=>null),array('id'=>$user['id']));
				$response = array('status'=>true,'message'=>'Login successfully','user'=>$user);
			}else{
				$response = array('status'=>false, 'message'=>'Otp not valid');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function comleteUserProfile() {
		$this->form_validation->set_rules('user_id', 'User_id', 'trim|required');
		$this->form_validation->set_rules('phone','Phone','trim|required|is_unique_update[users.phone@id@'.$this->input->post('user_id').']');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique_update[users.email@id@'.$this->input->post('user_id').']|valid_email');
		//die;
		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
			die($user_id);
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');

			$this->UserModel->update(array('phone'=>$phone,'email'=>$email),array('id'=>$user_id));

			$criteria['field'] = 'id,phone,name,email,created_at';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';
			$user= $this->UserModel->search($criteria);
			
			if(!empty($user)) {
				$user_status = $this->getUserProfileStatus($user['id']);
				$response = array('status'=>true,'message_send'=>$user_status['message_send'],'otp_verify'=>$user_status['otp_verify'],'profile_status'=>$user_status['profile_status'],'message'=>'Login successfully','user'=>$user);
			}else{
				$response = array('status'=>false,'message'=>'User not found!');
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}


	public function  registerDevice() {

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
	   		$criteria['field'] = 'id,otp,otp_verify,name,device_id,device_type,email,created_at,updated_at';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';

			$user= $this->UserModel->search($criteria);

	   		$response = array('status'=>true,'message'=>'Record updated successfully','user'=>$user);

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);

	}// end of registerDevice method
	/**
	 * [sendOtpToChangePassword description]
	 * @param int  $user_id [id of user]
	 * @return json array of otp send to user with user detail
	 */
	public function sendOtpToChangePassword(){

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true){

			$user_id = $this->input->post('user_id');

			$criteria['field'] = 'id,phone,change_password_otp,created_at,updated_at';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';

			$user= $this->UserModel->search($criteria);

			if($user){
				$otp = generate_otp();
				$data = array(
					'phone'=>$user['phone'],
					'body' =>"Your one time password to change password is ".$otp
				);
				$message = $this->textmessage->send($data);

				//dd(is_object($message));
				if(is_object($message) && $message->sid){
					$update_data=array(
						'change_password_otp'=>$otp,
					);
					$this->UserModel->update($update_data,array('id'=>$user_id));
					$user= $this->UserModel->search($criteria);
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
	   	   		$response = array('status'=>false,'message'=>'OTP code doesn\'t match');
	   	   }
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);

	}


	public function changePassword() {


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

	/* Api : To send an email for change parameter
	*  parameter : email (required) 
	*/

	public function sendChangePasswordEmail(){
	
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() == true){

			$email = $this->input->post('email');
			$user = $this->UserModel->get(array('email'=>$email));
			if(!empty($user)) {
				$password_hash= md5(uniqid(mt_rand(1000,9999),true));
				$link = base_url()."api/web/resetPassword/".$user['email']."/".$password_hash;

				$this->mailer->setFrom(MAIL_USERNAME);
				$this->mailer->addAddress($user['email']);
				$this->mailer->subject('Change password');
				$this->mailer->body($this->load->view('api/email/changePassword',array('user'=>$user,'link'=>$link),true));
				$this->mailer->isHTML();
				$mail=$this->mailer->send();
				$update_data = array(
					'password_reset_hash'=>$password_hash
				);

				$this->UserModel->update($update_data,array('id'=>$user['id']));

		   		$criteria['field'] = 'id,email,created_at,updated_at';
				$criteria['conditions'] = array('id'=>$user['id']);
				$criteria['returnType'] = 'single';

				$user= $this->UserModel->search($criteria);

		   	   	$response = array('status'=>true,'message'=>'Email has been sent successfully','user'=>$user);
	   	   	}else{
	   	   		$response = array('status'=>false,'message'=>'Sorry this email is not registered with us!');
	   	   	}

		}else{

			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);

	}



	public function socialPhoneRegister() {
		$login_type = $this->input->post('login_type');

		$this->form_validation->set_rules('user_id','User id' ,'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		if ($this->form_validation->run() == true){
				$user_id = $this->input->post('user_id');
				$phone = $this->input->post('phone');
				$is_phone_exists = $this->UserModel->checkPhoneExists($phone);

				if(empty($is_phone_exists)) {
					$otp = generate_otp();
					$data = array(
							'phone'=>$phone,
							'body' =>$otp." otp for your mobile verification"
					);
					$message = $this->textmessage->send($data);
					//print_r($message);die;
					if($message->sid){
						$update_data = array(
							'phone'=>$phone,
							'otp' => $otp,
						);
						$this->UserModel->update($update_data,array('id'=>$user_id));

						$criteria['field'] = 'id,phone,otp_verify,created_at,updated_at';
						$criteria['conditions'] = array('id'=>$user_id);
						$criteria['returnType'] = 'single';

						$user= $this->UserModel->search($criteria);
						if($user){
							$response= array("status"=>true,'message'=>"OTP code send successfully!",'user'=>$user);
						}

					}else{
						$response = array('status'=>false,'message'=>'Message not send! Please try again');
					}
				}else{
					$response = array('status'=>false,'message'=>'Phone number already registered');
				}

		}else{

			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);

	}// end of socialPhoneRegister method


	private function getUserProfileStatus($user_id = null) {
		if(! $user_id) {
			return false;  
		}

		$criteria['field'] = 'id,phone,otp_verify,email';
		$criteria['conditions'] = array('id'=>$user_id);
		$criteria['returnType'] = 'single';
		$user= $this->UserModel->search($criteria);

		if(empty($user['phone'])) {
			$message_send = false;
			$otp_verify = false;
		}else if(! $user['otp_verify']) {
			$otp = generate_otp();
			$data = array(
					'phone'=>$user['phone'],
					'body' =>$otp." otp for your mobile verification"
			);
			$message = $this->textmessage->send($data);
			$this->UserModel->update(array('otp'=>$otp),array('id'=>$user['id']));
			$message_send = (is_object($message) && $message->sid) ? true : false;
			$otp_verify = false;
		}else{
			$message_send = false;
			$otp_verify =true;
		}

		if(empty($user['email']) && empty($user['phone'])) {
			$profile_status = "EMAIL_PHONE_REQUIRED";
		}else if(empty($user['email'])) {
			$profile_status = "EMAIL_REQUIRED";
		}else if(empty($user['phone'])) {
			$profile_status = "PHONE_REQUIRED";
		}else{
			$profile_status = "COMPLETED";
		}

		return array('message_send'=>$message_send,'otp_verify'=>$otp_verify,'profile_status'=>$profile_status);
	}


	public function socialLogin() {
		$login_type = $this->input->post('login_type');
		if($login_type=='G'){
			$this->form_validation->set_rules('gmail_id','Gmail id','trim|required');
		}elseif ($login_type=='F') {
			$this->form_validation->set_rules('facebook_id', 'Facebook_id', 'trim|required');
		}
		//$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim');
		if($this->input->post('email')){
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
		}
		$this->form_validation->set_rules('login_type', 'Login Type', 'trim|required');
		if ($this->form_validation->run() == true){
			//$user_id = $this->input->post('user_id');
			$email = $this->input->post('email');
			if($login_type =="G"){
				$social_id = $this->input->post('gmail_id');
				$auth_provider = 1;
				$criteria['conditions'] = array('external_user_id'=>$social_id,'external_authentication_provider'=>$auth_provider);
			}elseif($login_type == 'F'){
				$social_id = $this->input->post('facebook_id');
				$auth_provider = 2;
				$criteria['conditions'] = array('external_user_id'=>$social_id,'external_authentication_provider'=>$auth_provider);
			}
			$criteria['field'] = 'id,user_id';
			$criteria['returnType'] = 'single';
			$user = $this->UserExternalLoginModel->search($criteria);
			//echo $this->db->last_query();die;
			unset($criteria);
			if(!empty($user)){
				$user_id= $user['user_id'];
				$criteria['field'] = 'id,name,phone,email,created_at';
				$criteria['conditions'] = array('id'=>$user_id);
				$criteria['returnType'] = 'single';
				$user_data = $this->UserModel->search($criteria);
				if(!empty($user_data)){
					$response = array('status'=>true,'message'=>'Login successfully','user'=>$user_data);
				}else{
					$response = array('status'=>false,'message'=>"User not found!");
				}
			}else{
				$email = $this->input->post('email');
				$is_exists_email = $this->UserModel->checkEmailExists($email);
				//dd($is_exists_email);
				if(!empty($is_exists_email)){
					$user_id = $is_exists_email['id'];
		 			 $insert_data= array(
		 			 	'user_id' =>$user_id,
		 			 	'external_authentication_provider' => $auth_provider,
		 			 	'external_user_id' => $social_id,
		 			 	'name'=>$this->input->post('name'),
		 			 	'email'=>$this->input->post('email'),
		 			 	'created_at' => date("Y-m-d H:i:s")
		 			 );
					$this->UserExternalLoginModel->insert($insert_data);

					$criteria['field'] = 'id,name,phone,email,created_at';
					$criteria['conditions'] = array('id'=>$user_id);
					$criteria['returnType'] = 'single';
					$user_data = $this->UserModel->search($criteria);
					unset($criteria);
					if(!empty($user_data)){
						$response = array('status'=>true,'message'=>'Login successfully','user'=>$user_data);
					}else{
						$response = array('status'=>false,'message'=>"User not found");
					}
				}else{
					$register_data =array(
						'name' => $this->input->post('name'),
						'email'=>$email,
						'created_at'=>date("Y-m-d H:i:s")
					);
					$insert_id = $this->UserModel->insert($register_data);
					if($insert_id) {
						$insert_data= array(
			 			 	'user_id' =>$insert_id,
			 			 	'external_authentication_provider' => $auth_provider,
			 			 	'external_user_id' => $social_id,
			 			 	'name'=>$this->input->post('name'),
			 			 	'email'=>$this->input->post('email'),
			 			 	'created_at' => date("Y-m-d H:i:s")
			 			 );
						//dd($insert_data);
						$this->UserExternalLoginModel->insert($insert_data);

						$criteria['field'] = 'id,name,phone,email,created_at';
						$criteria['conditions'] = array('id'=>$insert_id);
						$criteria['returnType'] = 'single';
						$userInfo = $this->UserModel->search($criteria);
						unset($criteria);
						if(!empty($userInfo)){
							$response = array('status'=>true,'message'=>'Login successfully','user'=>$userInfo);
						}else{
							$response = array('status'=>false,'message'=>"User not found");
						}
					}else{
						$response = array('status'=>false,'message'=>'An error occured!Please try again');
					}
				}
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	} // end of socialLogin method

	public function changeMobile() {	

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
	   		$otp = $this->input->post('otp');
	   		$criteria['field'] = 'changed_phone';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';

			$user= $this->UserModel->search($criteria);
	   	   	$is_verified = $this->UserModel->verifyOtp(array('id'=>$user_id,'otp'=>$otp));

	   	   if($is_verified){
	   	   		if($user['changed_phone']) {
	   	   			
		   	   		$update_data = array(
			   			'phone'=>$user['changed_phone'],
			   			'changed_phone'=>null
			   		);


		   	   		$this->UserModel->update($update_data,array('id'=>$user_id));
	   	   		}

	   	   		$criteria['field'] = 'id,phone,name,email,profile_image,created_at,updated_at';
	   	   		$user= $this->UserModel->search($criteria);
	   	   		$response = array('status'=>true,'message'=>'Phone no changed successfully','user'=>$user);
	   	   }else{

	   	   		$response = array('status'=>false,'message'=>array('otp'=>'OTP code doesn\'t match'));

	   	   }
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}// end of change mobile method


	public function sendOtpToChangeMobile() {

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|is_unique[users.phone]');
		$this->form_validation->set_message('is_unique', 'The phone is already taken');

		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
			$phone= $this->input->post('phone');
			$otp = generate_otp();
			$data = array(
				'phone'=>$phone,
				'body' =>$otp." otp for your mobile verification"
			);
			$message = send_sms($data);

			if($message->sid){
				$update_data = array(
					'otp' => $otp,
					'changed_phone' =>$phone
				);
				$this->UserModel->update($update_data,array('id'=>$user_id));

				$criteria['field'] = 'id,created_at,updated_at';
				$criteria['conditions'] = array('id'=>$user_id);
				$criteria['returnType'] = 'single';

				$user= $this->UserModel->search($criteria);
				if($user){
					$response= array("status"=>true,'message'=>"OTP send succussfully !",'user'=>$user);
				}

			}else{
				$response = array('status'=>false,'message'=>$message); 
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}// end of sendOtpToChangeMobile method 


	/**
	* Api : To edit a user profile
	* @link http://localhost/car-service/api/user/editProfile
	* @param  int $user_id  id of user 
	* @param string $name  name of user
	* @param string $email email of user
	* @param file $profile_image profile image of user
	* @return jsonarry Updated record of user
	*/

	public function editProfile(){

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');

		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			$is_email_exist = $this->UserModel->checkEmailExistsExcept($user_id,$email);
			$is_phone_exist = $this->UserModel->checkPhoneExistsExcept($user_id,$phone);
			if(!$is_email_exist && !$is_phone_exist) {
				$file_name = '';
				if(isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['name'])) {

					$url = FCPATH."uploads/app/";	
					$config['new_name']=true;
					$upload =$this->do_upload('profile_image',$url,$config);
					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
					}
				}
				$user_id = $this->input->post('user_id');
				$criteria['field'] = 'profile_image';
				$criteria['conditions'] = array('id'=>$user_id);
				$criteria['returnType'] = 'single';
				$user_img = $this->UserModel->search($criteria);
				unset($criteria);

				$update_data = array(
					'name' =>$this->input->post('name'),
					'email' =>$this->input->post('email'),
					'phone' => $this->input->post('phone')
				);
				if($file_name != ''){
					$update_data['profile_image']=$file_name;
					if(@file_exists($url.$user_img['profile_image'])) {
						@unlink($url.$user_img['profile_image']);
					}
				}

				$this->UserModel->update($update_data,array('id'=>$user_id));
				$criteria['field'] = 'id,phone,name,profile_image,email,created_at';
				$criteria['conditions'] = array('id'=>$user_id);
				$criteria['returnType'] = 'single';

				$user= $this->UserModel->search($criteria);
				if(!empty($user['profile_image'])) {
					$user['profile_image'] = base_url()."uploads/app/".$user['profile_image'];
				}
				$response =array('status'=>true,'message'=>'Record updated successfully','user'=>$user);
			}else{
				$errors = array();
				if(!empty($is_email_exist)){
					$errors['email'] = "Email is already registered!"; 
					
				}
				if(!empty($is_phone_exist)){
					$errors['phone'] = "Phone number is already registered!"; 
					
				}
				$response = array('status'=>false,'message'=>$errors);
			}

		}else{

			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}// end of edit profile method

	/**
	* Api : To get a user profile
	* @link http://localhost/car-service/api/user/getUserProfile
	* @param  int $user_id  id of user 
	* @return jsonarry record of user
	*/

	public function getUserProfile(){
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
			$criteria['field'] = 'id,name,phone,password,profile_image,email,created_at';
			$criteria['conditions'] = array('id'=>$user_id);
			$criteria['returnType'] = 'single';
			$user= $this->UserModel->search($criteria);
			if(!empty($user)) {
				$user['profile_image'] = (!empty($user['profile_image'])) ? base_url()."uploads/app/".$user['profile_image']:'';
				$response =array('status'=>true,'message'=>'Record found successfully','user'=>$user);
			}else{
				$response =array('status'=>false,'message'=>'Record not found');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

}// end of class
