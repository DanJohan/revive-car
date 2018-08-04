<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->has_userdata('is_manager_login'))
		{
			redirect('workshop/auth/login');
		}
		$this->load->helper('api');
		$this->load->model('ServiceEnquiryModel');
		$this->load->model('NotificationModel');
		$this->load->model('DriverModel');
		$this->load->model('WorkshopModel'); 
		$this->load->library('textMessage'); 


		
	}

	public function index( $id = null){
		$manager_id = $this->session->userdata('id');
		if($id){
			$this->ServiceEnquiryModel->markEnquiryManagerSeen($id);
		}
		$data['enquiries'] = $this->ServiceEnquiryModel->getWorkshopConfirmedEnquiries($manager_id);
		//dd($data['enquiries']);
		$data['view'] = 'workshop/enquiry/index';
		$this->load->view('workshop/layout', $data);
	}

	public function show($id=null){
		if($id){
			$data['enquiry'] = $this->ServiceEnquiryModel->getEnquiry($id);
		}
		if(empty($data['enquiry'])) {
			redirect('workshop/enquiry/index');
		}
		//dd($data);
		$data['view'] = 'workshop/enquiry/show';
		$this->load->view('workshop/layout', $data);
	}

	
	public function get_notifications() {
		
		$manager_id = $this->session->userdata('id');
		$data['enquiries'] = $this->ServiceEnquiryModel->getWorkshopEnquiryNotification($manager_id);
		//dd($data['enquiries']);
		if(!empty($data['enquiries'])) {
			$template = $this->load->view('workshop/enquiry/notification',$data,true);
			$response = array('status'=>true,'template'=>$template,'total'=>count($data['enquiries']));
		}else{
			$response = array('status'=>false,"Detail not found");
		}

		$this->renderJson($response);
	}
}