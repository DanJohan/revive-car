<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->has_userdata('is_admin_login'))
		{
			redirect('admin/auth/login');
		}
		$this->load->model('ServiceEnquiryModel');
		$this->load->model('admin/DriverModel');
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
		if($id){
			$data['enquiry'] = $this->ServiceEnquiryModel->getEnquiry($id);
		}
		if(empty($data['enquiry'])) {
			redirect('admin/enquiry/index');
		}
		$data['drivers'] = $this->DriverModel->get_all();
		$data['view'] = 'admin/enquiry/confirm';
		$this->load->view('admin/layout', $data);
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