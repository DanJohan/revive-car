<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends Rest_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('ServiceEnquiryModel');
	    $this->load->model('JobcardModel');
	    $this->load->model('JobCardImageModel');
	    $this->load->model('RepairOrderModel');
	    $this->load->model('DriverNotificationModel');
	    $this->load->model('DriverModel');
	}

	/**
	 *  API DESCRIPTION : To login driver
	 *  @link http://localhost/car-service/api/driver/login
	 *  @param : phone (required), password (required)
	 *  @return  json array of driver detail on success
	 */
	public function login() {

		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if ($this->form_validation->run() == true){
			$phone = $this->input->post('phone');
			$password = $this->input->post('password');
			$criteria['field']= 'id,d_name,d_phone,d_email,d_password';
			$criteria['conditions'] = array('d_phone'=>$phone);
			$criteria['returnType'] = 'single';
			$driver = $this->DriverModel->search($criteria);
			if($driver){
				$is_verified = password_verify($password,$driver['d_password']);
				if($is_verified){
					unset($driver['d_password']);
					$response = array('status'=>true,'message'=>'Login successfully','driver'=>$driver);
				}else{
					$response = array('status'=>false,'message'=>'Your password doesn\'t match');
				}
			}else{
				$response = array('status'=>false,'message'=>'User detail not found');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}


	    $this->renderJson($response);
	}

	/**
	 *  API DESCRIPTION : To verify customer given verification code
	 *  API URL : http://localhost/car-service/api/driver/verifyCustomerCode
	 *  PARAMETER : code (required)
	 */
	public function verifyCustomerCode(){
		$this->form_validation->set_rules('code', 'Verfication code', 'trim|required');
		if ($this->form_validation->run() == true){
			$code = $this->input->post('code');
			$criteria['field'] = 'id AS enquiry_id,car_id,user_id';
			$criteria['conditions'] = array('verification_code'=>$code);
			$criteria['returnType'] = 'single';
			$enquiry = $this->ServiceEnquiryModel->search($criteria);
			if($enquiry){
				$response = array('status'=>true,'message'=>'Record found successfully!','data'=>$enquiry);
			}else{
				$response = array('status'=>false,'message'=>'No detail found!');
			}
			
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	/**
	 *  API DESCRIPTION : To get enquiry detail for creating a job
	 *  API URL : http://localhost/car-service/api/driver/getEnquiryDetail
	 *  PARAMETER : enquiry_id (required)
	 */
	public function getEnquiryDetail(){
		$this->form_validation->set_rules('enquiry_id', 'Enquiry id', 'trim|required');
		if ($this->form_validation->run() == true){
			$enquiry_id = $this->input->post('enquiry_id');
			$enquiry_data= $this->ServiceEnquiryModel->getEnquiryWithUser($enquiry_id);

			if($enquiry_data) {
				$enquiry_data['image_id'] = explode('|', $enquiry_data['image_id']);
				$enquiry_data['image'] = explode('|',$enquiry_data['image']);
				$images =array();
				if(!empty($enquiry_data['image_id'][0])) {
					foreach ($enquiry_data['image_id'] as $index => $data) {
						$images[$index]['image_id'] = $data;
						$images[$index]['image'] = base_url()."uploads/app/".$enquiry_data['image'][$index];
					}
				}
				unset($enquiry_data['image_id']);
				unset($enquiry_data['image']);
				$enquiry_data['images'] = $images;
				$enquiry_data['profile_image']=(!empty($enquiry_data['profile_image'])) ?base_url()."uploads/app/".$enquiry_data['profile_image'] : '';
				$response = array('status'=>true,'message'=>'Record found successfully', 'data'=>$enquiry_data);
			}else{
				$response = array('status'=>false,'message'=>'No deatil found');
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function createJob(){
		//dd($_POST,false);
		//dd($_FILES);
		$this->form_validation->set_rules('enquiry_id', 'Enquiry id', 'trim|required');
		$this->form_validation->set_rules('car_id', 'Car id', 'trim|required');
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');

		if ($this->form_validation->run() == true){
			$insert_data = array(
				'enquiry_id' => $this->input->post('enquiry_id'),
				'car_id' =>$this->input->post('car_id'),
				'user_id' => $this->input->post('user_id'),
				'alternate_no'=>$this->input->post('alternate_no'),
				'vin_no' => $this->input->post('vin_no'),
				'sa_name_no'=> $this->input->post('sa_name_no'),
				'delivery_datetime'=>$this->input->post('delivery_datetime'),
				'reporting_datetime'=>$this->input->post('reporting_datetime'),
				'type_of_service' =>($this->input->post('type_of_service')) ? json_encode($this->input->post('type_of_service')) :'',
				'ride_kms'=>$this->input->post('ride_kms'),
				'lv_reg_no' => $this->input->post('lv_reg_no'),
				'damage_mark'=>($this->input->post('damage_mark')) ? json_encode($this->input->post('damage_mark')) :'',
				'car_properties'=>($this->input->post('car_properties'))? json_encode($this->input->post('car_properties')) :'',
				'vehicle_qty'=>($this->input->post('vehicle_qty'))? json_encode($this->input->post('vehicle_qty')) :'',
				'created_at' => date('Y-m-d H:i:s')
			);
			$insert_id = $this->JobcardModel->insert($insert_data);

			// insert jobs data
			$repair_orders= $this->input->post('repair_order');
			if(!empty($repair_orders) && $insert_id){
				foreach ($repair_orders as $index => $repair_order) {
					$repair_orders[$index]['job_card_id'] = $insert_id;
					$repair_orders[$index]['parts_name'] = $repair_order['parts_name'];
					$repair_orders[$index]['customer_request'] = $repair_order['customer_request'];
					$repair_orders[$index]['sa_remarks'] = $repair_order['sa_remarks'];
					$repair_orders[$index]['qty'] = $repair_order['qty'];
					$repair_orders[$index]['price_labour'] = $repair_order['price_labour'];
					$repair_orders[$index]['price_parts'] = $repair_order['price_parts'];
					$repair_orders[$index]['price_total'] = $repair_order['price_total'];
					$repair_orders[$index]['created_at'] = date('Y-m-d H:i:s');
				}
			}

			$this->RepairOrderModel->insert_batch($repair_orders);

			// insert job card images
			$files_data = array();
			if($insert_id){
				if(isset($_FILES['job_images']) && !empty($_FILES['job_images']['name'])){
					$filesCount = count($_FILES['job_images']['name']);
					for($i = 0; $i < $filesCount; $i++){
		                $_FILES['file']['name']     = $_FILES['job_images']['name'][$i];
		                $_FILES['file']['type']     = $_FILES['job_images']['type'][$i];
		                $_FILES['file']['tmp_name'] = $_FILES['job_images']['tmp_name'][$i];
		                $_FILES['file']['error']     = $_FILES['job_images']['error'][$i];
		                $_FILES['file']['size']     = $_FILES['job_images']['size'][$i];

		                $url = FCPATH.'uploads/app/';
		               	$upload = $this->do_upload('file',$url);
		                if(isset($upload['upload_data'])){
							chmod($upload['upload_data']['full_path'], 0777);
							$files_data[$i]['job_card_id'] = $insert_id;
							$files_data[$i]['image'] = $upload['upload_data']['file_name'];
							$files_data[$i]['created_at'] = date("Y-m-d H:i:s");
						}

		            }
				}
			}
			if(!empty($files_data)) {
				$this->JobCardImageModel->insert_batch($files_data);
			}
			
			// insert user digital signature
			if($insert_id && isset($_FILES['signature']) && !empty($_FILES['signature']['name'])) {
				$file_name = '';
				$url = FCPATH."uploads/app/";
				$upload =$this->do_upload('signature',$url);
				if(isset($upload['upload_data'])){
					chmod($upload['upload_data']['full_path'], 0777);
					$file_name = $upload['upload_data']['file_name'];
					$this->JobcardModel->update(array('signature'=>$file_name),array('id'=>$insert_id));
				}
			}

			$response = array('status'=>true,'message'=>'Job card created successfully','data'=>array('job_card_id'=>$insert_id));

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function getNotification(){
		$this->form_validation->set_rules('driver_id', 'Driver id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('driver_id');
			$notifications = $this->DriverNotificationModel->getById($user_id);
			if($notifications){
				$response = array('status'=>true,'message'=>'Record found successfully','data'=>$notifications);
			}else{
				$response = array('status'=>false,'message'=>'Detail not found');
			}
 
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}


	public function  registerDevice() {

		$this->form_validation->set_rules('driver_id', 'driver id', 'trim|required');
		$this->form_validation->set_rules('device_type', 'Device type', 'trim|required');
		$this->form_validation->set_rules('device_id', 'Device id', 'trim|required');

		if ($this->form_validation->run() == true){
			$driver_id = $this->input->post('driver_id');
			$update_data=array(
		   			'd_device_id'=>$this->input->post('device_id'),
		   			'd_device_type'=>$this->input->post('device_type')
		   	);

		   	$is_update = $this->DriverModel->update($update_data,array('id'=>$driver_id));
	   		$response = array('status'=>true,'message'=>'Record updated successfully');

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);

	}// end of registerDevice method


}// end of class
?>