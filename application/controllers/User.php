<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->model('ServiceEnquiryModel');
	}

	public function index(){
		redirect('user/login');
	}

	public function login(){
		//dd($_POST);die;
		//echo password_hash("password", PASSWORD_DEFAULT);die;
		$data =array();
		if($this->input->post('submit')){
			//dd($_POST);die;
			$this->form_validation->set_rules('username', 'Email|Phone', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() == TRUE) {
				
				$username = $this->input->post('username');   
				$password = $this->input->post('password');
				
				$user = $this->UserModel->check_user_exits(array('username'=>$username));
				if($user){
					$is_verified = password_verify($password,$user['password']);
					if($is_verified){
						// set session
						$user_data = array(
							'id' => $user['id'],
							'name' => $user['name'],
							'pic'  => $user['profile_image'],
						 	'is_user_login' => TRUE
						);
						//print_r($user_data);die;
							$this->session->set_userdata($user_data);
							redirect(base_url('user/dashboard'), 'refresh');
						}else{
							$data['msg'] = 'Your password doesn\'t match!';
						}
				}else{
					$data['msg'] = 'Sorry, this account is not registered with us!';
					
				}
			}
				else {
						$data['msg'] = 'Missing Email/Phone Or Password';
					 }

		}
			$this->load->view('user/login',$data);
	}// end of login method

	public function dashboard() {
		$data['view'] = 'user/dashboard';
		$this->load->view('user/layout',$data);

	}
	public function enquiry_by_user() {
	
		$data['enquiries'] = $this->ServiceEnquiryModel->getEnquiryByUser($this->session->userdata('id'));
		
		if(!empty($data['enquiries'])) {
			$data['view'] = 'user/enquiry';
			$this->load->view('user/layout',$data);
			
		}else{
			$data['msg'] = 'No Enquiry Found';
		}
	}
		
	public function logout(){
			$this->session->sess_destroy();
			redirect(base_url('user/login'), 'refresh');
		}
  }
?>