<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Workshop extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('admin/WorkshopModel');
		}

		public function add_manager(){
			$data=array();
			$data['view'] = 'admin/workshop/add_manager';
			$this->load->view('admin/layout', $data);
			
		}
		public function insert_manager(){
			if($this->input->post('submit')){  //inserting image in DB
					$file_name = '';
					if(isset($_FILES['m_photo']) && !empty($_FILES['m_photo']['name'])) {
						$path= FCPATH.'uploads/admin/';
						$upload= $this->do_upload('m_photo',$path);
						if(isset($upload['upload_data'])){
							$file_name = $upload['upload_data']['file_name'];
						}
					}
					$data = array(
						'm_name' => $this->input->post('m_name'),
						'm_email' => $this->input->post('m_email'),
						'm_password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT,array('cost'=>12)),
						'm_phone' => $this->input->post('m_phone'),
						'm_address' => $this->input->post('m_address'),
						'm_workshop_location' => $this->input->post('m_workshop_location'),
						'm_id_proof' => $this->input->post('m_id_proof'),
						'm_photo' => $file_name,
						'created_at' => date('Y-m-d H:i:s')
					
					);

					$data = $this->security->xss_clean($data);
					$result = $this->WorkshopModel->insert($data);

					if($result){
						$this->session->set_flashdata('msg', 'Manager is Added Successfully!');
						redirect(base_url('admin/workshop/view_manager'));

					}
				
				else{
					$this->session->set_flashdata('msg', 'Some problem occur!');
					redirect(base_url('admin/workshop/add_manager'));
					
				   }
			}	
		}

		public function view_manager(){
			$data=array();
			$data['all_manager'][0] =  $this->WorkshopModel->get_all();
			$data['view'] = 'admin/workshop/view_manager';
			$this->load->view('admin/layout', $data);

		  }

		public function edit_manager($id = 0){  // display record of selected id 
			if($this->input->post('submit')){
				$this->form_validation->set_rules('m_name', 'Username', 'trim|required');
				$this->form_validation->set_rules('m_email', 'Email', 'trim|required');
				$this->form_validation->set_rules('m_phone', 'Number', 'trim|required');
				$this->form_validation->set_rules('m_address', 'Address', 'trim|required');
				$this->form_validation->set_rules('m_workshop_location', 'Workshop Location', 'trim|required');
				$this->form_validation->set_rules('m_id_proof', 'ID Proof', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) {
					$data['manager'] = $this->WorkshopModel->get_manager_by_id($id);
					$data['view'] = 'admin/workshop/edit_workshop';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'm_name' => $this->input->post('m_name'),
						'm_email' => $this->input->post('m_email'),
						'm_phone' => $this->input->post('m_phone'),
						'm_address' => $this->input->post('m_address'),
						'm_workshop_location' => $this->input->post('m_workshop_location'),
						'm_id_proof' => $this->input->post('m_id_proof')
					);
				
					$result = $this->WorkshopModel->edit($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
						redirect(base_url('admin/workshop/view_manager'));
					}
				}
			}
			else{
				$data['manager'] = $this->WorkshopModel->get_manager_by_id($id);
				$data['view'] = 'admin/workshop/edit_manager';
				$this->load->view('admin/layout', $data);
			}
		}


		public function del_manager($id = 0){
			$this->db->delete('workshop_manager', array('id' => $id));
			$this->session->set_flashdata('msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/workshop/view_manager'));
		}

	}
    ?>