<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Car extends MY_Controller {

		public function __construct(){
			parent::__construct();
			if (!$this->session->userdata['is_admin_login'] == TRUE)
			{
				   redirect('admin/auth/login'); //redirect to login page
			} 
			$this->load->model('CarModel');
			$this->load->model('CarBrandModel');
			$this->load->model('CarModelsModel');
			$this->load->model('CarServiceModel');
			$this->load->model('ServiceModel');
			$this->load->model('CarTypeModel');

		}

		

		public function add_carbrand(){ //display add carbrand page 
			$data=array();
			$data['all_carbrand'] =  $this->CarBrandModel->get_all(NULL,array('id','asc'));
			//$data['view'] = 'admin/car/add_carbrand';
			//$this->load->view('admin/layout', $data);
			$this->render('admin/car/add_carbrand', $data);
			
		}

		public function add_carmodel(){ //display add carmodel page 
			$data=array();
			$data['all_carbrand'] =  $this->CarBrandModel->get_all();
			$data['all_carmodel'] =  $this->CarModelsModel->getModelsWithBrand();
			$data['car_types'] = $this->CarTypeModel->get_all();
			//$data['view'] = 'admin/car/add_carmodel';
			//dd($data);
			//$this->load->view('admin/layout', $data);
			$this->render('admin/car/add_carmodel', $data);
			
		}

		public function getCarModels(){
			if($this->input->post('brand_id')){
				$brand_id = $this->input->post('brand_id');
				$models = $this->CarModelsModel->getModelsByBrandId($brand_id);
				if(!empty($models)){
					$template = '';
					foreach ($models as $index => $data) {
						$template.='<option value="'.$data['id'].'">'.$data['model_name'].'</option>';
					}
					$this->renderJson(array('status'=>true,'template'=>$template));
				}else{

					$this->renderJson(array('status'=>false,'message'=>'data not found!'));
				}
			}
		}
		
		public function insert_carbrand(){  //insert carbrand

			if(count($_POST) >0 ) {
				$data = array(
					'brand_name' => $this->input->post('brand_name'),
					'created_at' => date('Y-m-d H:i:s')

				);

				$result = $this->CarBrandModel->insert($data);


				if($result){
					$this->session->set_flashdata('success_msg', 'Car Brand is Added Successfully!');
					redirect(base_url('admin/car/add_carbrand'));
					}

				else{
					$this->session->set_flashdata('error_msg', 'Some problem occur!');
					redirect(base_url('admin/car/add_carbrand'));

				}
			}
		}	

		public function insert_carmodel(){  //insert carmodel

				$file_name = '';
				if(isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
					$path= FCPATH.'uploads/admin/';
					$config['new_name']=true;
					$upload= $this->do_upload('image',$path,$config);
					//dd($upload);
					if(isset($upload['upload_data'])){
						$file_name = $upload['upload_data']['file_name'];

					}
				}
				
				$data = array(
					'brand_id' => $this->input->post('brand_id'),
					'model_name' => $this->input->post('model_name'),
					'car_type' => $this->input->post('car_type'),
					'image' => $file_name,
					'created_at' => date('Y-m-d H:i:s')

				);
				//print_r($data);die;
				$result = $this->CarModelsModel->insert($data);

			    if($result){
					$this->session->set_flashdata('success_msg', 'Car Model is Added Successfully!');
					redirect(base_url('admin/car/add_carmodel'));
					//print_r($data);die;
				}
				
				else{
					$this->session->set_flashdata('error_msg', 'Some problem occur!');
					redirect(base_url('admin/car/add_carmodel'));
					
				}
			}	

		public function edit_carmodel($id=null){
			if(!$id){
				redirect('admin/car/add_carmodel');
			}
			$data['model'] = $this->CarModelsModel->get(array('id'=>$id));
			
			if(empty($data['model'])) {
				redirect('admin/car/add_carmodel');
			}
			if($this->input->post('submit')){
				//dd($_POST);
				$file_name = $data['model']['image'];
				if(isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
					$path= FCPATH.'uploads/admin/';
					$config['new_name']=true;
					$upload= $this->do_upload('image',$path,$config);
					//dd($upload);
					if(isset($upload['upload_data'])){
						$file_name = $upload['upload_data']['file_name'];
						chmod($upload['upload_data']['full_path'], 0777);
						if(@file_exists($path.$data['model']['image'])) {
							@unlink($path.$data['model']['image']);
						}
					}
				}

				$update_data= array(
					'brand_id'=>$this->input->post('brand_id'),
					'model_name'=>$this->input->post('model_name'),
					'car_type' => $this->input->post('car_type'),
					'image'	=> $file_name,
				);
				$this->CarModelsModel->update($update_data,array('id'=>$data['model']['id']));
				redirect('admin/car/edit_carmodel/'.$data['model']['id']);
			}
			$data['all_carbrand'] =  $this->CarBrandModel->get_all();
			
			$data['car_types'] = $this->CarTypeModel->get_all();
			//$data['view'] = 'admin/car/edit_carmodel';
			//$this->load->view('admin/layout',$data);
			$this->render('admin/car/edit_carmodel', $data);
		}

		public function del_carbrand($id = 0){
			$this->db->delete('car_brands', array('id' => $id));
			$this->session->set_flashdata('success_msg', 'Brand name is Deleted Successfully!');
			redirect(base_url('admin/car/add_carbrand'));
		}
		public function del_carmodel($id = 0){
			$this->db->delete('car_models', array('id' => $id));
			$this->session->set_flashdata('success_msg', 'Model name is Deleted Successfully!');
			redirect(base_url('admin/car/add_carmodel'));
		}

	}


	?>
