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
		//$this->form_validation->set_rules('avg_mileage', 'Avg mileage', 'trim|required');

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
				//'avg_mileage' => $this->input->post('avg_mileage'),
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

	public function addUserTempCars() {
		$post_data = $this->input->post('cars');
		//dd($post_data);
		foreach ($post_data as $index => $data) {
			$this->form_validation->set_rules('cars['.$index.'][user_id]', 'User id', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][brand_id]', 'Brand id', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][model_id]', 'Model id', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][color]', 'Color', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][year]', 'Year', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][registration_no]', 'Registration number', 'trim|required');
		}

		if ($this->form_validation->run() == true) {
			foreach ($post_data as $index => $data) {
				$register_data[$index]=array(
					'user_id'=>$data['user_id'],
					'brand_id' => $data['brand_id'],
					'model_id' => $data['model_id'],
					'color' => $data['color'],
					'year' => $data['year'],
					'is_default' => ($index==0) ? 1 : 0 ,
					'registration_no' => $data['registration_no'],
					//'avg_mileage' => $this->input->post('avg_mileage'),
					'created_at' => date("Y-m-d H:i:s")
				);
			}

			$is_insert = $this->CarModel->insert_batch($register_data);
			//echo $this->db->last_query();die;
			if($is_insert){
				$response = array('status'=>true,'message'=>'Record inserted successfully');
			}else{
				$response = array('status'=> false,'message'=>'An error occured!Please try again' );
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

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
		//$this->renderJson(array('post'=>$_POST, 'files'=>$_FILES));
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
		$this->form_validation->set_rules('service_type', 'Service Type' ,'trim|required');
		//dd($_FILES);die;
		if ($this->form_validation->run() == true) {
			$register_data = array(
				'car_id' => $this->input->post('car_id'),
				'user_id' =>$this->input->post('user_id'),
				'enquiry_no'=>time(),
				'address' => $this->input->post('address'),
				'latitude' => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude'),
				'location' => $this->input->post('location'),
				'loaner_vehicle' => $this->input->post('loaner_vehicle'),
				'enquiry' => $this->input->post('enquiry'),
				'pick_up_date'=> $this->input->post('pick_up_date'),
				'service_type' => $this->input->post('service_type'),
				'pick_up_time' => $this->input->post('pick_up_time'),
				'created_at' => date("Y-m-d H:i:s") 
			);

			$insert_id = $this->ServiceEnquiryModel->insert($register_data);


			$service_images = $this->input->post('service_images');
			if(!empty($service_images) && $insert_id) {
				$this->EnquiryImagesModel->updateEnquiryImages($service_images,$insert_id);
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
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}// end of serviceEnquiry method


	public function uploadServiceImages() {
		if(isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
			$file_name = '';
			$url = FCPATH."uploads/app/";
			$config['new_name']=true;
			$upload =$this->do_upload('file',$url,$config);
			if(isset($upload['upload_data'])){
				chmod($upload['upload_data']['full_path'], 0777);
				$file_name = $upload['upload_data']['file_name'];
				$insert_data = array(
					'image' =>$file_name,
					'created_at' => date('Y-m-d H:i:s')
				);
				$insert_id = $this->EnquiryImagesModel->insert($insert_data);
				if($insert_id){
					$criteria['field'] = 'id,image';
					$criteria['conditions'] = array('id'=>$insert_id);
					$criteria['returnType'] = 'single';
					$image = $this->EnquiryImagesModel->search($criteria);
					if(!empty($image)){
						$image['image'] = base_url()."uploads/app/".$image['image'];
						$response = array('status'=>true,'message'=>'Image Uploaded successfully','data'=>$image);
					}else{
						$response = array('status'=>false,'message'=>'Somthing went wrong');
					}
				}else{
					$response = array('status'=>false,'message'=>'Somthing went wrong');
				}
			}else{
				$response = array('status'=>false,'message'=>strip_tags($upload['error']));
			}
		}
		$this->renderJson($response);
	}// end of  uploadServiceImages method


	public function deleteServiceImages(){
		$image_ids = $this->input->post('image_ids');

		if(!empty($image_ids)){	
			if(is_array($image_ids)){
				$images = $this->EnquiryImagesModel->getImagesById($image_ids);

				if(!empty($images)){
					foreach ($images as $index => $image) {
						$is_delete = $this->EnquiryImagesModel->delete(array('id'=>$image['id']));
						@unlink(FCPATH."uploads/app/".$image['image']);
					}
					$response = array('status'=>true,'message'=>'Images deleted successfully');
				}else{
					$response = array('status'=>false,'message'=>'Somthing went wrong!');
				}
			}else{
				$image = $this->EnquiryImagesModel->get(array('id'=>$image_ids));
				if(!empty($image)){
					$this->EnquiryImagesModel->delete(array('id'=>$image['id']));
					@unlink(FCPATH."uploads/app/".$image['image']);
					$response = array('status'=>true,'message'=>'Image deleted successfully');
				}else{
					$response = array('status'=>false,'message'=>'Somthing went wrong!');
				}
			}
		}else{
			$response = array('status'=>false,'message'=>'Images are required');
		}
		$this->renderJson($response);
	}


	public function getUserEnquiries() {
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$enquiries = $this->ServiceEnquiryModel->getEnquiryByUser($user_id);
			if(!empty($enquiries)){
				$response = array('status'=>true,'message'=>'Record found successfully!','data'=>$enquiries);
			}else{
				$response = array('status'=>true,'message'=>'No detail found!');
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

}
