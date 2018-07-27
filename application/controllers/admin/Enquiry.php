<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->has_userdata('is_admin_login'))
		{
			redirect('admin/auth/login');
		}
		$this->load->model('ServiceEnquiryModel');
	}

	public function index(){
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
}