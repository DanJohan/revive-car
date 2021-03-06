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
	    $this->load->model('ServiceModel');
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
		$this->form_validation->set_rules('body', 'Body', 'trim|required');
		$this->form_validation->set_rules('registration_no', 'Registration number', 'trim|required');

		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$have_cars = $this->CarModel->checkUserCarsExists($user_id);
			$file_name = '';
			if(isset($_FILES['car_image']) && !empty($_FILES['car_image']['name'])) {

					$url = FCPATH."uploads/app/";	
					$config['new_name']=true;
					$upload =$this->do_upload('car_image',$url,$config);

					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
				}
			}
			$register_data=array(
				'user_id'=>$this->input->post('user_id'),
				'brand_id' => $this->input->post('brand_id'),
				'model_id' => $this->input->post('model_id'),
				'body'=>$this->input->post('body'),
				'image'=>$file_name,
				'is_default' => (!$have_cars) ? 1 : 0 ,
				'registration_no' => $this->input->post('registration_no'),
				'created_at' => date("Y-m-d H:i:s")
			);
			$insert_id = $this->CarModel->insert($register_data);
			//echo $this->db->last_query();die;
			if($insert_id){
				$car = $this->CarModel->getCarById($insert_id);
				if(!empty($car['image'])){
					$car['image'] = base_url().'uploads/app/'.$car['image'];
				}
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


	public function edit_car(){
		$this->form_validation->set_rules('car_id','Car id', 'trim|required');
		$this->form_validation->set_rules('brand_id', 'Brand id', 'trim|required');
		$this->form_validation->set_rules('model_id', 'Model id', 'trim|required');
		$this->form_validation->set_rules('body', 'Body', 'trim|required');
		$this->form_validation->set_rules('registration_no', 'Registration number', 'trim|required');

		if ($this->form_validation->run() == true) {
			$car_id = $this->input->post('car_id');
			$file_name = '';
			if(isset($_FILES['car_image']) && !empty($_FILES['car_image']['name'])) {

					$url = FCPATH."uploads/app/";	
					$config['new_name']=true;
					$upload =$this->do_upload('car_image',$url,$config);

					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
						$criteria['field'] = 'image';
						$criteria['conditions'] = array('id'=>$car_id);
						$criteria['returnType'] = 'single';
						$car_data = $this->CarModel->search($criteria);
						if(@file_exists($url.$car_data['image'])) {
							@unlink($url.$car_data['image']);
						}
					}
			}

			$update_data=array(
				'brand_id' => $this->input->post('brand_id'),
				'model_id' => $this->input->post('model_id'),
				'body'=>$this->input->post('body'),
				'registration_no' => $this->input->post('registration_no'),
			);

			if(!empty($file_name)) {
				$update_data['image'] = $file_name;
			}

			$this->CarModel->update($update_data,array('id' => $car_id));
			$car = $this->CarModel->getCarById($car_id);
			$response = array('status'=>true,'message'=>'Record updated successfully','data'=>$car);

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}

	public function addUserTempCars() {
		$post_data = $this->input->post('cars');

		foreach ($post_data as $index => $data) {
			$this->form_validation->set_rules('cars['.$index.'][user_id]', 'User id', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][brand_id]', 'Brand id', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][model_id]', 'Model id', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][body]', 'Body', 'trim|required');
			$this->form_validation->set_rules('cars['.$index.'][registration_no]', 'Registration number', 'trim|required');
		}

		if ($this->form_validation->run() == true) {
			$have_cars = $this->CarModel->checkUserCarsExists($post_data[0]['user_id']);
			foreach ($post_data as $index => $data) {
				$file_name = '';
				if(isset($_FILES['images']['name'][$index]) && !empty($_FILES['images']['name'][$index])) {

					$_FILES['car_image']['name'] = $_FILES['images']['name'][$index];
					 $_FILES['car_image']['type']     = $_FILES['images']['type'][$index];
		                $_FILES['car_image']['tmp_name'] = $_FILES['images']['tmp_name'][$index];
		                $_FILES['car_image']['error']     = $_FILES['images']['error'][$index];
		                $_FILES['car_image']['size']     = $_FILES['images']['size'][$index];

					$url = FCPATH."uploads/app/";	
					$config['new_name']=true;
					$upload =$this->do_upload('car_image',$url,$config);

					if(isset($upload['upload_data'])){
						chmod($upload['upload_data']['full_path'], 0777);
						$file_name = $upload['upload_data']['file_name'];
					}
				}

				$register_data[$index]=array(
					'user_id'=>$data['user_id'],
					'brand_id' => $data['brand_id'],
					'model_id' => $data['model_id'],
					'body' => $data['body'],
					'image' => $file_name,
					'is_default' => (!$have_cars) ? ($index == 0) ? '1' : '0' : '0' ,
					'registration_no' => $data['registration_no'],
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
	 *  @param  user_id (required)
	 *  @return user cars detail
	 */
	public function getUserCars() {
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$user_cars = $this->CarModel->getUserAllCars($user_id);
			if(!empty($user_cars)){
				foreach ($user_cars as $index => &$user_car) {
					$user_car['image'] = ($user_car['image'])? base_url().'uploads/admin/'.$user_car['image']:'';
				}
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
				$user_car['image'] = ($user_car['image']) ? base_url().'uploads/app/'.$user_car['image']:'';
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

	public function service(){
		$this->form_validation->set_rules('model_id', 'Model id', 'trim|required');
		$this->form_validation->set_rules('cat_id','Category_id','trim|required');
		if ($this->form_validation->run() == true) {
			$model_id = $this->input->post('model_id');
			$cat_id = $this->input->post('cat_id');
			$services = $this->ServiceModel->getServicesByCategory($model_id,$cat_id);
			if(!empty($services)){
				foreach ($services as $index => &$service) {
					$service['image'] = ($service['image'])? base_url().'public/images/admin/car/'.$service['image']:'';
				}

				$response = array('status'=>true,'message'=>'Record get successfully','data'=>$services);
			}else{
				$response = array('status'=>false,'message'=>'No service found!');
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}


	public function getServiceImages() {

		if($this->input->post('image_ids')){
			$image_ids = $this->input->post('image_ids');
			$images = $this->EnquiryImagesModel->getImagesById($image_ids);
			if(!empty($images)){
				foreach ($images as $index => &$image) {
					$image['image'] = ($image['image'])? base_url().'public/images/admin/car/'.$image['image']:'';
				}
				$response = array('status'=>true,'message'=>'Record get successfully','data'=>$images);
			}
		}else{
			$response = array('status'=>false,'message'=>"image ids are required");
		}

		$this->renderJson($response);
	}

}// end of class
