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
			if($this->input->post('submit')){
				
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
			//print_r($data['all_manager'][0]);die;
			$this->load->view('admin/layout', $data);

		  }

		}

    ?>