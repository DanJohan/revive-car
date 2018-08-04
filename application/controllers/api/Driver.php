<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('ServiceEnquiryModel');
	    $this->load->model('JobcardModel');
	    $this->load->model('JobModel');
/*	    $this->load->helper('api');
	    $this->load->model('UserModel');
	    $this->load->library('mailer');
	    $this->load->library('textMessage');*/
	}

	/**
	 *  API DESCRIPTION : To login driver
	 *  API URL : http://localhost/car-service/api/driver/login
	 *  PARAMETER : phone (required), password (required)
	 */
	public function login() {

		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if ($this->form_validation->run() == true){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$user = $this->UserModel->check_user_exits(array('username'=>$username));
			if($user){
				$is_verified = password_verify($password,$user['password']);
				if($is_verified){
					$response = array('status'=>true,'message'=>'Login successfully','user'=>$user);
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
			$criteria['field'] = 'id';
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
		//dd($_POST);
		$this->form_validation->set_rules('enquiry_id', 'Enquiry id', 'trim|required');
		$this->form_validation->set_rules('date_of_accident','Date of accident','trim');
		$this->form_validation->set_rules('able_to_authorise','Able to authorise','trim');
		$this->form_validation->set_rules('taxable','Taxable','trim');
		$this->form_validation->set_rules('damage_area','Damage area','trim');
		$this->form_validation->set_rules('vehicle_status','Damage area','trim');
		$this->form_validation->set_rules('tyres','Tyres','trim');
		$this->form_validation->set_rules('jobs','Jobs','trim');
		if ($this->form_validation->run() == true){
			$insert_data = array(
				'enquiry_id' => $this->input->post('enquiry_id'),
				'date_of_accident' => $this->input->post('date_of_accident'),
				'able_to_authorise' => $this->input->post('able_to_authorise'),
				'taxable' => $this->input->post('taxable'),
				'damage_area' =>($this->input->post('damage_area')) ? json_encode($this->input->post('damage_area')) :'',
				'vehicle_status'=>($this->input->post('vehicle_status')) ? json_encode($this->input->post('vehicle_status')) :'',
				'tyres'=>$this->input->post('tyres'),
				'created_at' => date('Y-m-d H:i:s')
			);
			$insert_id = $this->JobcardModel->insert($insert_data);
			$jobs = $this->input->post('jobs');
			if(!empty($jobs) && $insert_id) {
				foreach ($jobs as $index => $job) {
					$jobs[$index]['job_card_id'] = $insert_id;
					$jobs[$index]['created_at'] = date('Y-m-d H:i:s');
				}
				$this->JobModel->insert_batch($jobs);
			}
			$response = array();

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

}// end of class
?>