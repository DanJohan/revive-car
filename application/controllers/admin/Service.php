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
	}

	public function index() {
		redirect('admin/service/add_carservice');
	}
	public function list(){
		$data['services'] = $this->CarServiceModel->getCarServicesWithCateogory();
		$data['view'] = 'admin/service/list';
		$this->load->view('admin/layout',$data);
	}

	public function add_carservice(){ //display add carservice page 

		$data=array();
		$data['all_carbrand'] =  $this->CarBrandModel->get_all();
		$data['all_carmodel'] =  $this->CarModelsModel->getModelsWithBrand();
		$data['all_carservice'] =  $this->CarServiceModel->getCarServicesWithCateogory();
		$data['view'] = 'admin/service/car_service';
		$this->load->view('admin/layout', $data);
			
	}

	public function insert_carservice(){  //insert carservice

		if($this->input->post('submit')) {
			$service_id =  $this->input->post('service');
			$data = array(
				//'brand_id' => $this->input->post('brand_id'),
				'model_id' => $this->input->post('model_id'),
				'price' => str_replace(',', '', $this->input->post('price')),
				'service_id' => $service_id,
				'created_at' => date('Y-m-d H:i:s')

			);
			//print_r($data);die;
			$result = $this->ServiceModel->insert($data);

		    if($result){
				$this->session->set_flashdata('success_msg', 'Car Service is Added Successfully!');
				redirect(base_url('admin/service/add_carservice'));
				//print_r($data);die;
			}
			
			else{
				$this->session->set_flashdata('error_msg', 'Some problem occur!');
				redirect(base_url('admin/service/add_carservice'));
				
			}
		}
	}

	public function car_services_list(){
		$data['services'] = $this->ServiceModel->getServices();
		$data['view'] = 'admin/service/car_service_list';
		//dd($data);
		$this->load->view('admin/layout',$data);
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
		$data['view'] = 'admin/service/add_coupan';
		$this->load->view('admin/layout',$data);
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

}// end of class
