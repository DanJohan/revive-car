<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Driver extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('DriverModel');
			$this->load->model('WorkshopModel');
			if (!$this->session->userdata['is_admin_login'] == TRUE)
			{
			   redirect('admin/auth/login'); //redirect to login page
			} 
		}

		public function add_driver(){ //display add driver page 
			$data=array();
			$data['managers']=$this->WorkshopModel->get_all();
			//dd($data['managers']);
			$data['view'] = 'admin/driver/add_driver';

			$this->load->view('admin/layout', $data);
			
		}
		
		public function insert_driver(){  //insert driver 
			$this->session->set_flashdata('post_data',$this->input->post());
			if($this->input->post('submit')){  //inserting image in DB
					
					$phone= $this->input->post('d_phone');
					$phone = "+91".$phone;
					$email = $this->input->post('d_email');
				    $driverPhoneInfo =	$this->DriverModel->checkPhoneExists($phone);

				    $driverEmailInfo =	$this->DriverModel->checkEmailExists($email);
				    if(!$driverPhoneInfo && !$driverEmailInfo) {
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
							'd_location' => $this->input->post('d_location'),
							'd_address' => $this->input->post('d_address'),
							'd_workshop_assign' => $this->input->post('d_workshop_assign'),
							'd_license' => $this->input->post('d_license'),
							'd_idproof' => $this->input->post('d_idproof'),
							'd_photo' => $file_name,
							'created_at' => date('Y-m-d H:i:s')
							
						);
						
						$result = $this->DriverModel->insert($data);
						
						if($result){
							$this->session->set_flashdata('success_msg', 'Driver is Added Successfully!');
							redirect(base_url('admin/driver/view_driver'));

						}else{
						$this->session->set_flashdata('error_msg', 'Some problem occur!');
						redirect(base_url('admin/driver/add_driver'));
						
					   }
				}else{
					$errors ='';
					if(!empty($driverPhoneInfo)){
						$errors .= "<p>Phone number already exists</p>";
					}
					if(!empty($driverEmailInfo)){
						$errors .= "<p>Email already exists</p>";
					}
					$this->session->set_flashdata('validation_error',$errors);
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

		public function view_record_by_id($id){
			$data=array();
			$criteria['field'] = 'driver.*,workshop_manager.m_name,workshop_manager.m_workshop_location';
			$criteria['join'] = array(
				array('workshop_manager','driver.d_workshop_assign=workshop_manager.id','left'),
			);
			$criteria['conditions'] = array('driver.id'=>$id);
			$criteria['returnType'] = 'single';
			$data['driver_by_id'] =  $this->DriverModel->search($criteria);
			echo $this->load->view('admin/driver/driver_view',$data,true);
			
		}

		public function edit_driver($id = null){  // display record of selected id 
			if(!$id){
				redirect(base_url('admin/driver/view_driver'));
			}
			$data['driver'] = $this->DriverModel->get(array('id'=>$id));
			if($this->input->post('submit')){

				$this->form_validation->set_rules('d_name', 'Username', 'trim|required');
				$this->form_validation->set_rules('d_email', 'Email', 'trim|required');
				$this->form_validation->set_rules('d_phone', 'Number', 'trim|required');
				$this->form_validation->set_rules('d_location', 'Location', 'trim|required');
				$this->form_validation->set_rules('d_address', 'Address', 'trim|required');
				$this->form_validation->set_rules('d_workshop_assign', 'Location Assign', 'trim|required');
				$this->form_validation->set_rules('d_license', 'License', 'trim|required');
				 
				if ($this->form_validation->run() == FALSE) {
					$data['driver'] = $this->DriverModel->get(array('id'=>$id));
					redirect(base_url('admin/driver/edit_driver/'.$id));
				}
				else{
				
				$phone= $this->input->post('d_phone');
				$phone = "+91".$phone;
				$email = $this->input->post('d_email');
				$driverPhoneInfo =	$this->DriverModel->checkPhoneExistsExcept($id,$phone);

				$driverEmailInfo =	$this->DriverModel->checkEmailExistsExcept($id,$email);
				if(!$driverPhoneInfo && !$driverEmailInfo) {
					$file_name = $data['driver']['d_photo'];
					if(isset($_FILES['d_photo']) && !empty($_FILES['d_photo']['name'])) {
						$path= FCPATH.'uploads/admin/';
						$upload= $this->do_upload('d_photo',$path);
						if(isset($upload['upload_data'])){
							$file_name = $upload['upload_data']['file_name'];
							@unlink($path.$data['driver']['d_photo']);
						}
					}	
					$data = array(
						'd_name' => $this->input->post('d_name'),
						'd_email' => $this->input->post('d_email'),
						'd_phone' => ($this->input->post('d_phone'))?'+91'.$this->input->post('d_phone'):'',
						'd_location' => $this->input->post('d_location'),
						'd_address' => $this->input->post('d_address'),
						'd_workshop_assign' => $this->input->post('d_workshop_assign'),
						'd_license' => $this->input->post('d_license'),
						'd_photo' =>$file_name
					);
				
					$result = $this->DriverModel->update($data, array('id'=>$id));
					$this->session->set_flashdata('success_msg', 'Record is Updated Successfully!');
					redirect(base_url('admin/driver/view_driver'));
				}else{
					$errors ='';
					if(!empty($driverPhoneInfo)){
						$errors .= "<p>Phone number already exists</p>";
					}
					if(!empty($driverEmailInfo)){
						$errors .= "<p>Email already exists</p>";
					}
					$this->session->set_flashdata('validation_error',$errors);
					redirect(base_url('admin/driver/edit_driver/'.$id));
				}
			}
		}else{
			
			$data['driver']['d_phone'] = substr($data['driver']['d_phone'],-10);
			$data['managers']=$this->WorkshopModel->get_all();
			$data['view'] = 'admin/driver/edit_driver';
			$this->load->view('admin/layout', $data);
		}
	}


		public function del_driver($id = null){
			if(!id){
				redirect(base_url('admin/driver/view_driver'));
			}
			$this->DriverModel->delete(array('id' => $id));
			$this->session->set_flashdata('success_msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/driver/view_driver')); 
		}

	}


?>