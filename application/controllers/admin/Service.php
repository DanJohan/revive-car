<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_admin_login'] == TRUE)
		{
		   redirect('admin/auth/login'); //redirect to login page
		}
		$this->load->model('CarServiceModel');
		$this->load->model('CarBrandModel');
		$this->load->model('CarModelsModel');
		$this->load->model('ServiceModel');
		$this->load->model('ServiceDiscountModel');
		$this->load->model('ServiceCategoryModel');
		$this->load->model('CarTypeModel');
	}

	public function index() {
		redirect('admin/service/add_carservice');
	}
	public function list(){
		$data['services'] = $this->CarServiceModel->getCarServicesWithCateogory();
		//$data['view'] = 'admin/service/list';
		//$this->load->view('admin/layout',$data);
		$this->render('admin/service/list',$data);
	}

	public function add_carservice(){ //display add carservice page 

		$data=array();
		$data['all_carbrand'] =  $this->CarBrandModel->get_all();
		$data['all_carmodel'] =  $this->CarModelsModel->getModelsWithBrand();
		$data['all_carservice'] =  $this->CarServiceModel->getCarServices();
		$data['categories'] = $this->ServiceCategoryModel->get_all();
		//$data['view'] = 'admin/service/car_service';
		//$this->load->view('admin/layout', $data);
		$this->render('admin/service/car_service', $data);
			
	}

	public function insert_carservice(){  //insert carservice

		if($this->input->post('submit')) {
			$model_id = $this->input->post('model_id');
			$service_id =  $this->input->post('service');
			$category_id = $this->input->post('service_category');
			$is_exists = $this->ServiceModel->checkServiceExists($model_id,$service_id,$category_id);
			if(!is_exists) {
				$data = array(
					'model_id' =>$model_id,
					'price' => str_replace(',', '', $this->input->post('price')),
					'service_id' => $service_id,
					'category_id' =>$category_id,
					'created_at' => date('Y-m-d H:i:s')

				);
				//print_r($data);die;
				$result = $this->ServiceModel->insert($data);

			    if($result){
					$this->session->set_flashdata('success_msg', 'Car Service is Added Successfully!');
					redirect(base_url('admin/service/add_carservice'));
					//print_r($data);die;
				}else{
					$this->session->set_flashdata('error_msg', 'Some problem occur!');
					redirect(base_url('admin/service/add_carservice'));
					
				}
			}else{
				$this->session->set_flashdata('error_msg', 'Sorry, This service already exists!');
				redirect(base_url('admin/service/add_carservice'));
			}
		}
	}

	public function car_services_list(){
		$data['services'] = $this->ServiceModel->getServices();
		//$data['view'] = 'admin/service/car_service_list';
		//dd($data);
		//$this->load->view('admin/layout',$data);
		$this->render('admin/service/car_service_list',$data);
	}

	public function add_coupan($id){
		if(!$id){
			$this->session->set_flashdata('error_msg','Service not found');
			redirect('admin/service/list');
		}
		$data['service'] =  $this->ServiceModel->getServiceById($id);
		if(empty($data['service'])){
			$this->session->set_flashdata('error_msg','Serivce not found');
			redirect('admin/service/car_services_list');
		}
		//$data['view'] = 'admin/service/add_coupan';
		//$this->load->view('admin/layout',$data);
		$this->render('admin/service/add_coupan',$data);
	}

	public function save_coupan(){
		//dd($_POST);
		if($this->input->post('submit')){
			$service_id = $this->input->post('service_id');
			$insert_data = array(
				'service_id' => $service_id,
				'discount_value'=>str_replace(',', '', $this->input->post('coupan_price')),
				'coupan_code' => strtoupper($this->input->post('coupan_code')),
				'valid_untill' => date('Y-m-d H:i:s',strtotime($this->input->post('expire_at'))),
				'created_at' => date('Y-m-d H:i:s')
			);
			
			$insert_id = $this->ServiceDiscountModel->insert($insert_data);
			if($insert_id){
				$this->session->set_flashdata('success_msg','Coupan added successfully!');
				redirect('admin/service/add_coupan/'.$service_id);
			}else{
				$this->session->set_flashdata('success_msg','Something went wrong!');
				redirect('admin/service/add_coupan/'.$service_id);
			}

		}

	}

	public function change_service_price(){
		if($this->input->post('submit')){
			$service_cat_id = $this->input->post('service_type');
			$car_type = $this->input->post('car_type');
			$price = str_replace(',','', $this->input->post('service_price'));
			$car_models_id = array();
			if($car_type){
				$criteria['field'] = 'id';
				$criteria['conditions'] = array('car_type'=>$car_type);
				$car_models = $this->CarModelsModel->search($criteria);
				if(!empty($car_models)){
					$car_models_id = array_column($car_models, 'id');
				}
			}
			if($service_cat_id == 4 || $service_cat_id == 5) {
				$car_models_id = array();
			}else{
				if(empty($car_models_id)) {
					$this->session->set_flashdata('error_msg','Service not found!');
					redirect('admin/service/change_service_price');
				}
			}
			$this->ServiceModel->updatePiceByServices($service_cat_id, $car_models_id,$price);
			//echo $this->db->last_query();die;
			$this->session->set_flashdata('success_msg','Prices has been changed successfully');
			redirect('admin/service/change_service_price');
			//echo $service_cat_id." ".$car_type." ".$price;die;
		}
		$data['service_categories'] = $this->ServiceCategoryModel->get_all();
		$data['car_types'] = $this->CarTypeModel->get_all();
		//$data['view'] = 'admin/service/change_service_price';
		//$this->load->view('admin/layout',$data);
		$this->render('admin/service/change_service_price',$data);
	}	

}// end of class
