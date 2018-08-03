<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->has_userdata('is_admin_login'))
		{
			redirect('admin/auth/login');
		}
		$this->load->helper('api');
		$this->load->model('ServiceEnquiryModel');
		$this->load->model('DriverModel');
		$this->load->library('textMessage'); 
	}

	public function index( $id = null){
		if($id){
			$this->ServiceEnquiryModel->markEnquirySeen($id);
		}
		$data['enquiries'] = $this->ServiceEnquiryModel->getAllEnquiries();
		
		$data['view'] = 'admin/enquiry/index';
		$this->load->view('admin/layout', $data);
	}

	public function show($id=null){
		if($id){
			$data['enquiry'] = $this->ServiceEnquiryModel->getEnquiry($id);
		}
		if(empty($data['enquiry'])) {
			redirect('admin/enquiry/index');
		}
		//dd($data);
		$data['view'] = 'admin/enquiry/show';
		$this->load->view('admin/layout', $data);
	}

	public function confirm($id=null) {
		//dd($_POST);
		if($id){
			$data['enquiry'] = $this->ServiceEnquiryModel->getEnquiry($id);
		}

		if(empty($data['enquiry'])) {
			redirect('admin/enquiry/index');
		}

		if($data['enquiry']['confirmed']) {
			$this->session->set_flashdata('success_msg', 'This enquiry is alredy confirmed!');
			redirect('admin/enquiry/index');
		}

		$data['drivers'] = $this->DriverModel->get_all();
		$data['view'] = 'admin/enquiry/confirm';
		$this->load->view('admin/layout', $data);
	}

	public function save_enquiry_confirm() {
		if(count($_POST) > 0) {
			$enquiry_id = $this->input->post('enquiry_id');
			$otp = getRandomString(6);
			$update_data = array(
				'assign_driver' => ($this->input->post('driver'))?$this->input->post('driver'):null,
				'loaner_vehicle_cost' => ($this->input->post('loaner_vehicle_cost'))? $this->input->post('loaner_vehicle_cost') : null,
				'estimated_cost' => $this->input->post('estimated_cost'),
				'confirmed' => 1,
				'verification_code' =>$otp
			);
			$is_update = $this->ServiceEnquiryModel->update($update_data,array('id'=>$enquiry_id));
			$enquiry = $this->ServiceEnquiryModel->getEnquiry($enquiry_id);

			$data['phone'] = $enquiry['phone'];
			if(!empty($enquiry['driver_id'])) {
				$data['body'] = 'Dear '.$enquiry['name'].', On confirmation of your enquiry , REVIVE driver '.$enquiry['d_name'].' is coming to pick your car. Insert OTP '.$otp.' for Confirmation to start assistance and service';
			}else{
				$data['body'] = 'Dear '.$enquiry['name'].', Thanks for Choosing Revive car care Service , we will glad to welcome you on our service center, please enter '.$otp.' , when you reach to our workshop manager to start service.';
			}
			$message = $this->textmessage->send($data);
			//$criteria['field'] = 
			if($is_update){
				$this->session->set_flashdata('success_msg', 'Enquiry confirmed successfully!');
			}
		}
		redirect('admin/enquiry/index');
	}

	public function get_notifications() {
		$data['enquiries'] = $this->ServiceEnquiryModel->getEnquiryNotification();
		if(!empty($data['enquiries'])) {
			$template = $this->load->view('admin/enquiry/notification',$data,true);
			$response = array('status'=>true,'template'=>$template,'total'=>count($data['enquiries']));
		}else{
			$response = array('status'=>false,"Detail not found");
		}

		$this->renderJson($response);
	}
}