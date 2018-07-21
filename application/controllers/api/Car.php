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
	}// end of getCarBrands method

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
	} // end of getCarModels method

	public function addCar(){

		if($this->input->method()!='post') {
			return;
		}
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('brand_id', 'Brand id', 'trim|required');
		$this->form_validation->set_rules('model_id', 'Model id', 'trim|required');
		$this->form_validation->set_rules('color', 'Color', 'trim|required');
		$this->form_validation->set_rules('year', 'Year', 'trim|required');
		$this->form_validation->set_rules('registration_no', 'Registration number', 'trim|required');
		$this->form_validation->set_rules('avg_mileage', 'Avg mileage', 'trim|required');

		if ($this->form_validation->run() == true) {
			$register_data=array(
				'user_id'=>$this->input->post('user_id'),
				'brand_id' => $this->input->post('brand_id'),
				'model_id' => $this->input->post('model_id'),
				'color' => $this->input->post('color'),
				'year' => $this->input->post('year'),
				'registration_no' => $this->input->post('registration_no'),
				'avg_mileage' => $this->input->post('avg_mileage'),
				'created_at' => date("Y-m-d H:i:s")
			);
			$insert_id = $this->CarModel->insert($register_data);
			//echo $this->db->last_query();die;
			if($insert_id){
				$car = $this->CarModel->getCarById($insert_id);
				$response = array('status'=>true,'message'=>'Record inserted successfully','data'=>$car);
			}else{
				$response = array('status'=> false,'message'=>'An error occured!Please try again' );
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}// end of addCar method

}