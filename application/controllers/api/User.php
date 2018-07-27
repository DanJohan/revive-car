<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->helper('api');
	    $this->load->model('UserModel');
	    $this->load->library('mailer');
	    $this->load->library('textMessage');
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
				if($message->sid){
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

	public function sendOtpToChangePassword(){

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

				$this->UserModel->update($update_data,array('id'=>$user['id']));

		   		$criteria['field'] = 'id,otp,otp_verify,name,device_id,device_type,email,created_at,updated_at';
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

	public function resetPassword($email=null,$hash=null) {

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


	public function socialLogin() {

		$login_type = $this->input->post('login_type');
		if($login_type=='G'){
			$this->form_validation->set_rules('gmail_id','Gmail id','trim|required');
		}elseif ($login_type=='F') {
			$this->form_validation->set_rules('facebook_id', 'Facebook_id', 'trim|required');
		}
		//$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		$this->form_validation->set_rules('login_type', 'Login Type', 'trim|required');

		if ($this->form_validation->run() == true){

			//$user_id = $this->input->post('user_id');
			$email = $this->input->post('email');
			if($login_type =="G"){
				$social_id = $this->input->post('gmail_id');
				$criteria['conditions'] = array('gmail_id'=>$social_id);
			}else if($login_type == 'F'){
				$social_id = $this->input->post('facebook_id');
				$criteria['conditions'] = array('facebook_id'=>$social_id);
			}

			$criteria['field'] = 'id,phone,otp,otp_verify,gmail_id,facebook_id,name,device_id,device_type,email,created_at,updated_at';
			$criteria['returnType'] = 'single';
			$user = $this->UserModel->search($criteria);
			unset($criteria);
			if(!empty($user)){
				if($user['otp_verify']){
					$response = array('status'=>true,'otp_verify'=>true,'message'=>'Login successfully','user'=>$user);
				}else{
					$response = array('status'=>true,'otp_verify'=>false,'message'=>"Phone number not registerd",'user'=>$user);
				}
			}else{
				$email = $this->input->post('email');
				$is_exits_email = $this->UserModel->checkEmailExists($email);
				if($is_exits_email) {
					$response = array('status'=>false,'message'=>'User email already registered');
				}else{
					$register_data =array(
						'name' => $this->input->post('name'),
						'email'=>$email,
						'created_at'=>date("Y-m-d H:i:s")
					);
					if($login_type=='G'){
						$register_data['gmail_id']= $this->input->post('gmail_id');
					}elseif ($login_type=='F') {
						$register_data['facebook_id']= $this->input->post('facebook_id');
					}
					$user_id = $this->UserModel->insert($register_data);

					$criteria['field'] = 'id,phone,otp,otp_verify,gmail_id,facebook_id,name,device_id,device_type,email,created_at,updated_at';
					$criteria['conditions'] = array('id'=>$user_id);
					$criteria['returnType'] = 'single';
					$userInfo = $this->UserModel->search($criteria);
					if($userInfo['otp_verify']){
						$response = array('status'=>true,'otp_verify'=>true,'message'=>'Login successfully','user'=>$userInfo);
					}else{
						$response = array('status'=>true,'otp_verify'=>false,'message'=>"Phone number not registerd",'user'=>$userInfo);
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


	/*
	* Api : To edit a user profile
	* Parameter : user_id , name, email
	 */
	public function editProfile(){

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() == true){
			$user_id = $this->input->post('user_id');
			$email = $this->input->post('email');
			$is_email_exist = $this->UserModel->checkEmailExistsExcept($user_id,$email);

			if(!$is_email_exist) {
				$file_name = '';
				if(isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['name'])) {

					$url = FCPATH."uploads/app/";	
					$upload =$this->do_upload('profile_image',$url);
					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
					}
				}
				$user_id = $this->input->post('user_id');
				$update_data = array(
					'name' =>$this->input->post('name'),
					'email' =>$this->input->post('email')
				);
				if($file_name != ''){
					$update_data['profile_image']=$file_name;
				}

				$this->UserModel->update($update_data,array('id'=>$user_id));
				$criteria['field'] = 'id,otp,otp_verify,name,profile_image,email,created_at,updated_at';
				$criteria['conditions'] = array('id'=>$user_id);
				$criteria['returnType'] = 'single';

				$user= $this->UserModel->search($criteria);
				$user['profile_image'] = base_url()."uploads/app/".$user['profile_image'];
				$response =array('status'=>true,'message'=>'Record updated successfully','user'=>$user);
			}else{
				$response = array('status'=>false,'message'=>'Email is already registered!');
			}

		}else{

			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}// end of edit profile method

}// end of class
