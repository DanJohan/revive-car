<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Car extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('CarBrandModel');
		$this->load->model('CarModelsModel');
		if (!$this->session->userdata['is_admin_login'] == TRUE)
		{
			   redirect('admin/auth/login'); //redirect to login page
			} 
		}

		public function add_carbrand(){ //display add carbrand page 
			$data=array();
			$data['all_carbrand'] =  $this->CarBrandModel->get_all(NULL,array('id','asc'));
			$data['view'] = 'admin/car/add_carbrand';
			$this->load->view('admin/layout', $data);
			
		}

		public function add_carmodel(){ //display add carmodel page 
			$data=array();
			$data['all_carbrand'] =  $this->CarBrandModel->get_all();

			/*$c['field'] = 'car_models.*,car_brands.brand_name';
			$c['join'] = array(
				array('car_brands','car_models.brand_id=car_brands.id','inner'),
			);
			$data['all_carmodel'] =  $this->CarModelsModel->search($c);
			echo $this->db->last_query()*/;

			$data['all_carmodel'] =  $this->CarModelsModel->getModelsWithBrand();
			//dd($data['all_carmodel']);
			$data['view'] = 'admin/car/add_carmodel';
			$this->load->view('admin/layout', $data);
			
		}
		
		public function insert_carbrand(){  //insert carbrand

			if(count($_POST) >0 ) {
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
		}	

			public function insert_carmodel(){  //insert carmodel

				$data = array(
					'brand_id' => $this->input->post('brand_id'),
					'model_name' => $this->input->post('model_name'),
					'created_at' => date('Y-m-d H:i:s')

				);
				
				$result = $this->CarModelsModel->insert($data);
			    if($result){
					$this->session->set_flashdata('msg', 'Car Model is Added Successfully!');
					redirect(base_url('admin/car/add_carmodel'));

				}
				
				else{
					$this->session->set_flashdata('msg', 'Some problem occur!');
					redirect(base_url('admin/car/add_carmodel'));
					
				}
			}	

			public function del_carbrand($id = 0){
			$this->db->delete('car_brands', array('id' => $id));
			$this->session->set_flashdata('msg', 'Brand name is Deleted Successfully!');
			redirect(base_url('admin/car/add_carbrand'));
		}
		public function del_carmodel($id = 0){
			$this->db->delete('car_models', array('id' => $id));
			$this->session->set_flashdata('msg', 'Model name is Deleted Successfully!');
			redirect(base_url('admin/car/add_carmodel'));
		}


	}


	?>