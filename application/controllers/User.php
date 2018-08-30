<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('UserModel');
	}

	public function index(){
		redirect('user/login');
	}

	public function login(){
		//dd($_POST);die;
		//echo password_hash("password", PASSWORD_DEFAULT);die;
		$data =array();
		if($this->input->post('submit')){
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
						 	'is_user_login' => TRUE
						);
							$this->session->set_userdata($user_data);
							redirect(base_url('user/dashboard'), 'refresh');
						}else{
							$data['msg'] = 'Your password doesn\'t match!';
						}
				}else{
					$data['msg'] = 'Sorry, this account is not registered with us!';
					
				}
			}

		}
			$this->load->view('site/user',$data);
	}// end of login method

	public function dashboard() {

		die("You are signed in");
	}
}	
?>