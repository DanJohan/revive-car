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
	    $this->load->model('ServiceEnquiryModel');
	    //$this->load->library('mailer');
	}

	public function getCarBrands(){

		$brands = $this->CarBrandModel->get_all();

		if(!empty($brands)){
			$response = array('status'=>true,'message'=>'Records get successfully','brands'=>$brands);
		}else{
			$response= array('status'=>false,'message'=>'Details not found');
		}
		$this->renderJson($response);		
	}// end of getCarBrands method

	public function getCarModels(){

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

	public function getUserCars() {

		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$user_cars = $this->CarModel->getUserAllCars($user_id);
			if(!empty($user_cars)){
				$response = array('status'=>true,'message'=>'Detail found successfully','data'=>$user_cars);
			}else{
				$response = array('status'=>false,'message'=>'No detail found'); 
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}// end of getUserCars method

	public function deleteCar(){

		$this->form_validation->set_rules('car_id', 'Car id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$car_id = $this->input->post('car_id');
			$is_updated = $this->CarModel->delete(array('id'=>$car_id));
			if($is_updated){
				$response = array('status'=>true,'message'=>'Record deleted successfully');
			}else{
				$response = array('status'=>false,'message'=>'Record not found');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}// end of deleteCar method

	public function serviceEnquiry() {
		$this->form_validation->set_rules('car_id', 'Car id', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('loaner_vehicle', 'Car id', 'trim|required');
		$this->form_validation->set_rules('enquiry', 'Enquiry', 'trim|required');

		if ($this->form_validation->run() == true) {
			$register_data = array(
				'car_id' => $this->input->post('cat_id'),
				'address' => $this->input->post('address'),
				'loaner_vehicle' => $this->input->post('loaner_vehicle'),
				'enquiry' => $this->input->post('enquiry')
			);

			$insert_id = $this->ServiceEnquiryModel->insert($register_data);
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
	}// end of serviceEnquiry method

}