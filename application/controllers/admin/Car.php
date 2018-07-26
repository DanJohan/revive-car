<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Car extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('CarBrandModel');
			$this->load->model('CarModelsModel');
		}

		public function add_carbrand(){ //display add carbrand page 
			$data=array();
			$data['view'] = 'admin/car/add_carbrand';
			$this->load->view('admin/layout', $data);
			
		}

		public function add_carmodel(){ //display add carmodel page 
			$data=array();
			$data['all_carbrand'][0] =  $this->CarBrandModel->get_all();
			$data['view'] = 'admin/car/add_carmodel';
			$this->load->view('admin/layout', $data);
			
		}
		
		public function insert_carbrand(){  //insert carbrand
					$data = array(
						'brand_name' => $this->input->post('brand_name'),
						'created_at' => date('Y-m-d H:i:s')
						
					);
					
					$result = $this->CarBrandModel->insert($data);
					
					if($result){
						$this->session->set_flashdata('msg', 'Car Brand is Added Successfully!');
						redirect(base_url('admin/car/add_carbrand'));

					}
				
				else{
					$this->session->set_flashdata('msg', 'Some problem occur!');
					redirect(base_url('admin/car/add_carbrand'));
					
				   }
			}	
			
			public function insert_carmodel(){  //insert carmodel

					$data = array(
						'brand_id' => $this->input->post('brand_id'),
						'model_name' => $this->input->post('model_name'),
						'created_at' => date('Y-m-d H:i:s')
						
					);
					//print_r($data);die;

					$result = $this->CarModelsModel->insert($data);
					//print_r($result);die;
					//echo $this->db->last_query();die;

					if($result){
						$this->session->set_flashdata('msg', 'Car Model is Added Successfully!');
						redirect(base_url('admin/car/add_carmodel'));

					}
				
				else{
					$this->session->set_flashdata('msg', 'Some problem occur!');
					redirect(base_url('admin/car/add_carmodel'));
					
				   }
			}	
					



			/*public function view_carbrand(){ //view all car brand names from db
				$data=array();
				$data['all_carbrand'][0] =  $this->CarBrandModel->get_all();
				print_r($data['all_carbrand'][0]);die;
				$data['view'] = 'admin/car/add_carmodel';
				$this->load->view('admin/layout', $data);

			  }
*/

			 
		/*public function edit_driver($id = 0){  // display record of selected id 
			if($this->input->post('submit')){
				$this->form_validation->set_rules('d_name', 'Username', 'trim|required');
				$this->form_validation->set_rules('d_email', 'Email', 'trim|required');
				$this->form_validation->set_rules('d_phone', 'Number', 'trim|required');
				$this->form_validation->set_rules('d_address', 'Address', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) {
					$data['driver'] = $this->DriverModel->get_driver_by_id($id);
					$data['view'] = 'admin/driver/edit_driver';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'd_name' => $this->input->post('d_name'),
						'd_email' => $this->input->post('d_email'),
						'd_phone' => $this->input->post('d_phone'),
						'd_address' => $this->input->post('d_address')
					);
				
					$result = $this->DriverModel->edit($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
						redirect(base_url('admin/driver/view_driver'));
					}
				}
			}
			else{
				$data['driver'] = $this->DriverModel->get_driver_by_id($id);
				$data['view'] = 'admin/driver/edit_driver';
				$this->load->view('admin/layout', $data);
			}
		}


		public function del_driver($id = 0){
			$this->db->delete('driver', array('id' => $id));
			$this->session->set_flashdata('msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/driver/view_driver'));
		}
*/
	}


?>