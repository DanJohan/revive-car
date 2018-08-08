<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JobCard extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->has_userdata('is_admin_login'))
		{
			redirect('admin/auth/login');
		}
		$this->load->model('JobcardModel');
	    $this->load->model('JobCardImageModel');
	}

	public function list(){

		$data['jobs'] = $this->JobcardModel->JobcardDetails();
		$data['view'] = 'admin/jobcard/list';
	//	dd($data);
		$this->load->view('admin/layout', $data);
	}
}// end of class
?>