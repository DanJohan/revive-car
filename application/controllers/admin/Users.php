<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Users extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('UserModel');
			if (!$this->session->userdata['is_admin_login'] == TRUE)
			{
			   redirect('admin/auth/login'); //redirect to login page
			} 
		}
 
		public function index(){
			$data['all_users'] =  $this->UserModel->get_all(NULL,array('id','desc'));
			$data['view'] = 'admin/users/user_list';
			$this->load->view('admin/layout', $data);
		}
	
		public function edit($id = null){
			if(!$id){
				redirect('admin/users');
			}

			if($this->input->post('submit')){
				$this->form_validation->set_rules('name', 'Username', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('phone', 'Number', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) {
					$data['user'] = $this->UserModel->get(array('id'=>$id));
					$data['view'] = 'admin/users/user_edit';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'name' => $this->input->post('name'),
						'email' => $this->input->post('email'),
						'phone' => ($this->input->post('phone'))?'+91'.$this->input->post('phone'):'',
					);
					//$data = $this->security->xss_clean($data);
					$result = $this->UserModel->update($data, array('id'=>$id));
					$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
					redirect(base_url('admin/users'));
					
				}
			}
			else{
				$data['user'] = $this->UserModel->get(array('id'=>$id));
				$data['user']['phone'] = substr($data['user']['phone'],-10);
				$data['view'] = 'admin/users/user_edit';
				$this->load->view('admin/layout', $data);
			}
		}

			
		public function del($id = null){
			if(!id){
				redirect('admin/users');
			}
			$this->UserModel->delete(array('id' => $id));
			$this->session->set_flashdata('msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/users'));
		}

	}


?>