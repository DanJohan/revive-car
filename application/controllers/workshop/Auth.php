<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Auth extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('workshop/AuthModel');
		}

		public function index(){
			redirect('workshop/auth/login');
		}

		public function login(){
		if ($this->session->has_userdata['is_manager_login'] == TRUE)

		{
		   redirect('workshop/dashboard'); //redirect to login page
		} 

		
			if($this->input->post('submit')){
				$this->form_validation->set_rules('m_email', 'Email', 'trim|required');
				$this->form_validation->set_rules('m_password', 'Password', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$this->load->view('workshop/auth/login');
				}
				else {
					$data = array(
					'm_email' => $this->input->post('m_email'),
					'm_password' => $this->input->post('m_password')
					);

					$result = $this->AuthModel->login($data);
					//print_r($result);die;
					if ($result == TRUE) {
						$manager_data = array(
							'id' => $result['id'],
						 	'm_email' => $result['m_email'],
							'm_name' => $result['m_name'],
							'm_photo' => $result['m_photo'],
						 	'is_manager_login' => TRUE
						);
						$this->session->set_userdata($manager_data);
						redirect(base_url('workshop/dashboard'), 'refresh');
					}
					else{
						$data['msg'] = 'Invalid Email or Password!';
						$this->load->view('workshop/auth/login', $data);
					}
				}
			}
			else{
				$this->load->view('workshop/auth/login');
			}
		}	

		public function change_pwd(){
			if (!$this->session->userdata['is_manager_login'] == TRUE)

		{
		   redirect('workshop/auth/login'); //redirect to login page
		} 
			$id = $this->session->userdata('id');
			if($this->input->post('submit')){
				$this->form_validation->set_rules('m_password', 'Password', 'trim|required');
				$this->form_validation->set_rules('confirm_pwd', 'Confirm Password', 'trim|required|matches[m_password]');
				if ($this->form_validation->run() == FALSE) {
					$data['view'] = 'workshop/auth/change_pwd';
					$this->load->view('workshop/layout', $data);
				}
				else{
					$data = array(
						'm_password' => password_hash($this->input->post('m_password'), PASSWORD_BCRYPT)
					);
					$result = $this->AuthModel->change_pwd($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Password has been changed successfully!');
						redirect(base_url('workshop/auth/change_pwd'));
					}
				}
			}
			else{
				$data['view'] = 'workshop/auth/change_pwd';
				$this->load->view('workshop/layout', $data);
			}
		}
				
		public function logout(){
			if (!$this->session->userdata['is_manager_login'] == TRUE)

		{
		   redirect('workshop/auth/login'); //redirect to login page
		} 
			$this->session->sess_destroy();
			redirect(base_url('workshop/auth/login'), 'refresh');
		}
			
	}  // end class


?>