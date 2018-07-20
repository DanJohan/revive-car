<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Car extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
	    //$this->load->helper('api');
	    $this->load->model('CarModel');
	    $this->load->model('CarBrandModel');
	    $this->load->model('CarModelsModel');
	    //$this->load->library('mailer');
	}

	public function getCarBrands(){
		if($this->input->method()!='get') {
			return;
		}
		$brands = $this->CarBrandModel->get_all();

		if(!empty($brands)){
			$response = array('status'=>true,'message'=>'Records get successfully','brands'=>$brands);
		}else{
			$response= array('status'=>false,'message'=>'Details not found');
		}
		$this->renderJson($response);		
	}

	public function getCarModels(){

		if($this->input->method()!='post') {
			return;
		}

		$this->form_validation->set_rules('brand_id', 'Brand id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$brand_id = $this->input->post('brand_id');
			$criteria['conditions'] = array('brand_id'=>$brand_id);
			$models=$this->CarModelsModel->search($criteria);

			if(!empty($models)){
				$response = array('status'=>true,'message'=>"Record get successfully",'models'=>$models);
			}else{
				$response = array('status'=>false,'message'=>'Detail not found');
			}

		}else{

			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}

}