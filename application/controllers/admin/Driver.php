<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Driver extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('DriverModel');
			if (!$this->session->userdata['is_admin_login'] == TRUE)
			{
			   redirect('admin/auth/login'); //redirect to login page
			} 
		}

		public function add_driver(){ //display add driver page 
			$data=array();
			$data['view'] = 'admin/driver/add_driver';
			$this->load->view('admin/layout', $data);
			
		}
		
		public function insert_driver(){  //insert driver 
			if($this->input->post('submit')){  //inserting image in DB
					$file_name = '';
					if(isset($_FILES['d_photo']) && !empty($_FILES['d_photo']['name'])) {
						$path= FCPATH.'uploads/admin/';
						$upload= $this->do_upload('d_photo',$path);
						if(isset($upload['upload_data'])){
							$file_name = $upload['upload_data']['file_name'];
						}
					}
					$data = array(
						'd_name' => $this->input->post('d_name'),
						'd_email' => $this->input->post('d_email'),
						'd_password' => password_hash($this->input->post('d_password'), PASSWORD_BCRYPT),
						'd_phone' => ($this->input->post('d_phone')) ? '+91'.$this->input->post('d_phone') : '',
						'd_address' => $this->input->post('d_address'),
						'd_idproof' => $this->input->post('d_idproof'),
						'd_photo' => $file_name,
						'created_at' => date('Y-m-d H:i:s')
						
					);
					
					$result = $this->DriverModel->insert($data);
					
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

		public function view_driver(){ //view all drivers from db
			$data=array();
			$data['all_driver'] =  $this->DriverModel->get_all(NULL,array('id','desc'));

			$data['view'] = 'admin/driver/view_driver';
			$this->load->view('admin/layout', $data);

		  }

		public function edit_driver($id = null){  // display record of selected id
			if(!$id){
				redirect(base_url('admin/driver/view_driver'));
			}
			if($this->input->post('submit')){
				$this->form_validation->set_rules('d_name', 'Username', 'trim|required');
				$this->form_validation->set_rules('d_email', 'Email', 'trim|required');
				$this->form_validation->set_rules('d_phone', 'Number', 'trim|required');
				$this->form_validation->set_rules('d_address', 'Address', 'trim|required');
				 
				if ($this->form_validation->run() == FALSE) {
					$data['driver'] = $this->DriverModel->get(array('id'=>$id));
					$data['view'] = 'admin/driver/edit_driver';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'd_name' => $this->input->post('d_name'),
						'd_email' => $this->input->post('d_email'),
						'd_phone' => ($this->input->post('d_phone'))?'+91'.$this->input->post('d_phone'):'',
						'd_address' => $this->input->post('d_address')
					);
				
					$result = $this->DriverModel->update($data, array('id'=>$id));
					$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
					redirect(base_url('admin/driver/view_driver'));
				}
			}
			else{
				$data['driver'] = $this->DriverModel->get(array('id'=>$id));
				$data['driver']['d_phone'] = substr($data['driver']['d_phone'],-10);
				$data['view'] = 'admin/driver/edit_driver';
				$this->load->view('admin/layout', $data);
			}
		}


		public function del_driver($id = null){
			if(!id){
				redirect(base_url('admin/driver/view_driver'));
			}
			$this->DriverModel->delete(array('id' => $id));
			$this->session->set_flashdata('msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/driver/view_driver')); 
		}

	}


?>