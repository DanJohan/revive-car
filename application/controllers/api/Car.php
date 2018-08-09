<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Car extends Rest_Controller {

	public function __construct()
	{
	    parent::__construct();
	   // $this->jwtauth->verify_request();
	    $this->load->helper('api');
	    $this->load->model('CarModel');
	    $this->load->model('CarBrandModel');
	    $this->load->model('CarModelsModel');
	    $this->load->model('ServiceEnquiryModel');
	    $this->load->model('EnquiryImagesModel');
	    //$this->load->library('mailer');
	}

	public function index(){
		//$this->load->view('api/test');
	}

	/**
	 *  API DESCRIPTION : To get all car brands
	 *  @link: http://localhost/car-service/api/car/getCarBrands
	 *  @param : not required
	 *  @return [json array] [car brands detail]
	 */
	public function getCarBrands(){

		$brands = $this->CarBrandModel->get_all();

		if(!empty($brands)){
			$response = array('status'=>true,'message'=>'Records get successfully','brands'=>$brands);
		}else{
			$response= array('status'=>false,'message'=>'Details not found');
		}
		$this->renderJson($response);		
	}// end of getCarBrands method

	/**
	 *  API DESCRIPTION : To get all car models via its brand id
	 *  @link : http://localhost/car-service/api/car/getCarModels
	 *  @param : brand_id(required)
	 *  @return : car models deatil
	 */
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


	/**
	 *  API DESCRIPTION : To add car of users
	 *  @link: http://localhost/car-service/api/car/getCarBrands
	 *  @param: see validation rules in method
	 *  @return  : user car deatial on successfully insert
	 */
	
	public function addCar(){
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('brand_id', 'Brand id', 'trim|required');
		$this->form_validation->set_rules('model_id', 'Model id', 'trim|required');
		$this->form_validation->set_rules('color', 'Color', 'trim|required');
		$this->form_validation->set_rules('year', 'Year', 'trim|required');
		$this->form_validation->set_rules('registration_no', 'Registration number', 'trim|required');
		$this->form_validation->set_rules('avg_mileage', 'Avg mileage', 'trim|required');

		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$have_cars = $this->CarModel->checkUserCarsExists($user_id);
			$register_data=array(
				'user_id'=>$this->input->post('user_id'),
				'brand_id' => $this->input->post('brand_id'),
				'model_id' => $this->input->post('model_id'),
				'color' => $this->input->post('color'),
				'year' => $this->input->post('year'),
				'is_default' => (!$have_cars) ? 1 : 0 ,
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

	/**
	 *  API DESCRIPTION : To get all car of user
	 *  @link  http://localhost/car-service/api/car/getUserCars
	 *  @param  user_id (required)
	 *  @return user cars detail
	 */
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

	public function setDefaultCar() {
		$this->form_validation->set_rules('car_id', 'Car id', 'trim|required');
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$car_id = $this->input->post('car_id');
			$user_id = $this->input->post('user_id');
			$this->CarModel->updateDefaultCar($user_id,$car_id);
			$user_cars = $this->CarModel->getUserAllCars($user_id);
			if(!empty($user_cars)){
				$response = array('status'=>true,'message'=>'Record updated successfully','data'=>$user_cars);
			}else{
				$response = array('status'=>false,'message'=>'No detail found'); 
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}

	public function getDefaultCar() {
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$user_car = $this->CarModel->getDefaultCar($user_id);
			if(!empty($user_car)){
				$response = array('status'=>true,'message'=>'Record found successfully','data'=>$user_car);
			}else{
				$response = array('status'=>false,'message'=>'No detail found!');
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}

	public function serviceEnquiry() {

		$this->form_validation->set_rules('car_id', 'Car id', 'trim|required');
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('location','Location','trim|required');
		$this->form_validation->set_rules('loaner_vehicle', 'Car id', 'trim|required');
		$this->form_validation->set_rules('enquiry', 'Enquiry', 'trim|required');
		$this->form_validation->set_rules('pick_up_date','Pickup Date','trim|required');
		$this->form_validation->set_rules('pick_up_time','Pickup Time', 'trim|required');
		//dd($_FILES);die;
		if ($this->form_validation->run() == true) {
			$register_data = array(
				'car_id' => $this->input->post('car_id'),
				'user_id' =>$this->input->post('user_id'),
				'address' => $this->input->post('address'),
				'latitude' => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude'),
				'location' => $this->input->post('location'),
				'loaner_vehicle' => $this->input->post('loaner_vehicle'),
				'enquiry' => $this->input->post('enquiry'),
				'pick_up_date'=> $this->input->post('pick_up_date'),
				'service_type' => 1,
				'pick_up_time' => $this->input->post('pick_up_time'),
				'created_at' => date("Y-m-d H:i:s") 
			);

			$insert_id = $this->ServiceEnquiryModel->insert($register_data);
			$file_data = array();
			if($insert_id){
				
				if(isset($_FILES['service_images']) && !empty($_FILES['service_images']['name'])){
					$filesCount = count($_FILES['service_images']['name']);
					for($i = 0; $i < $filesCount; $i++){
		                $_FILES['file']['name']     = $_FILES['service_images']['name'][$i];
		                $_FILES['file']['type']     = $_FILES['service_images']['type'][$i];
		                $_FILES['file']['tmp_name'] = $_FILES['service_images']['tmp_name'][$i];
		                $_FILES['file']['error']     = $_FILES['service_images']['error'][$i];
		                $_FILES['file']['size']     = $_FILES['service_images']['size'][$i];

		                $url = FCPATH.'uploads/app/';
		               	$upload = $this->do_upload('file',$url);

		                if(isset($upload['upload_data'])){
							chmod($upload['upload_data']['full_path'], 0777);
							$files_data[$i]['enquiry_id'] = $insert_id;
							$files_data[$i]['image'] = $upload['upload_data']['file_name'];
							$files_data[$i]['created_at'] = date("Y-m-d H:i:s");
						}

		            }
				}
				if(!empty($files_data)) {
					$this->EnquiryImagesModel->insert_batch($files_data);
				}
				$enquiry = $this->ServiceEnquiryModel->getEnquiryById($insert_id);
				$enquiry['image_id'] = explode('|', $enquiry['image_id']);
				$enquiry['image'] = explode('|',$enquiry['image']);
				$images =array();
				if(!empty($enquiry['image_id'][0])) {
					foreach ($enquiry['image_id'] as $index => $data) {
						$images[$index]['image_id'] = $data;
						$images[$index]['image'] = base_url()."uploads/app/".$enquiry['image'][$index];
					}
				}
				unset($enquiry['image_id']);
				unset($enquiry['image']);
				$enquiry['images'] = $images;
				$response = array('status'=>true,'message'=>'Record inserted successfully','data'=>$enquiry);
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