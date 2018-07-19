<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Workshop extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('admin/workshop_model', 'workshop_model');
		}

		public function add_manager(){
			$data=array();
			$data['view'] = 'admin/workshop/add_manager';
			$this->load->view('admin/layout', $data);
			
		}
		public function insertManager(){
			if($this->input->post('submit')){
				//print_r($_POST);die;
				//print_r($this->input->post('submit'));die;

				$this->form_validation->set_rules('m_name', 'trim|required');
				$this->form_validation->set_rules('m_email', 'trim|required');
				$this->form_validation->set_rules('m_password', 'trim|required');
				$this->form_validation->set_rules('m_phone','trim|required');
				$this->form_validation->set_rules('m_address', 'trim|required');
				$this->form_validation->set_rules('m_workshop_location','trim|required');
				$this->form_validation->set_rules('m_id_proof','trim|required');
 
				if ($this->form_validation->run() == FALSE) {
					$data['view'] = 'admin/workshop/add_manager';
					$this->load->view('admin/layout', $data);
					echo "validation"; die;
				}
				else{
					$data = array(
						'm_name' => $this->input->post('m_name'),
						'm_email' => $this->input->post('m_email'),
						'm_password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'm_phone' => $this->input->post('m_phone'),
						'm_address' => $this->input->post('m_address'),
						'm_workshop_location' => $this->input->post('m_workshop_location'),
						'm_id_proof' => $this->input->post('m_id_proof'),
						'created_at' => date('Y-m-d : h:m:s'),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->workshop_model->insertManager($data);
					if($result){
						$this->session->set_flashdata('msg', 'Manager is Added Successfully!');
						redirect(base_url('admin/workshop/view_manager'));
					}
				}
			}
			else{
				$data['view'] = 'admin/workshop/add_manager';
				$this->load->view('admin/layout', $data);
			}
			
		}

		public function view_manager(){
			$data['all_manager'] =  $this->workshop_model->viewManager();
			$data['view'] = 'admin/workshop/view_manager';
			$this->load->view('admin/layout', $data);
		}




		/*public function edit($id = 0){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('username', 'Username', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('phone', 'Number', 'trim|required');
				/*$this->form_validation->set_rules('user_role', 'User Role', 'trim|required');
*/
				/*if ($this->form_validation->run() == FALSE) {
					$data['user'] = $this->user_model->get_user_by_id($id);
					$data['view'] = 'admin/users/user_edit';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'is_admin' => $this->input->post('user_role'),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->user_model->edit_user($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else{
				$data['user'] = $this->user_model->get_user_by_id($id);
				$data['view'] = 'admin/users/user_edit';
				$this->load->view('admin/layout', $data);
			}
		}*/

		/*public function del($id = 0){
			$this->db->delete('users', array('id' => $id));
			$this->session->set_flashdata('msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/users'));
		}
*/
	}


?>