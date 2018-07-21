<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Driver extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('admin/DriverModel');
		}

		public function add_driver(){
			$data=array();
			$data['view'] = 'admin/driver/add_driver';
			$this->load->view('admin/layout', $data);
			
		}
		
		public function insert_driver(){
			if($this->input->post('submit')){
				
					$data = array(
						'd_name' => $this->input->post('d_name'),
						'd_email' => $this->input->post('d_email'),
						'd_phone' => $this->input->post('d_phone'),
						'd_address' => $this->input->post('d_address'),
						'd_idproof' => $this->input->post('d_idproof'),
						'created_at' => date('Y-m-d : h:m:s'),
						
					);
					$data = $this->security->xss_clean($data);
					
					$result = $this->DriverModel->insert($data);
					// $result= $this->db->last_query();
					// print_r($result);die;
					if($result){
						$this->session->set_flashdata('msg', 'Driver is Added Successfully!');
						redirect(base_url('admin/driver/view_driver'));

					}
				
				else{
					$this->session->set_flashdata('msg', 'Some problem occur!');
					redirect(base_url('admin/driver/add_driver'));
					
				   }
			}	
		}

		public function view_driver(){
			$data=array();
			$data['all_driver'][0] =  $this->DriverModel->get_all();
			$data['view'] = 'admin/driver/view_driver';
			//print_r($data['all_manager'][0]);die;
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
		}*/

	}


?>