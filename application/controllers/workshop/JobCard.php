<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JobCard extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->has_userdata('is_manager_login'))
		{
			redirect('workshop/auth/login');
		}
		$this->load->model('JobcardModel');
	    $this->load->model('JobCardImageModel');
	    $this->load->model('DriverModel');
	}

	public function list(){
		$manager_id = $this->session->userdata('id');
		if(!$manager_id){
			redirect('workshop/auth/login');
		}
		$driver_ids = $this->DriverModel->getDriversByWorkshop($manager_id);
		if($driver_ids) {
			$driver_ids = array_column($driver_ids, 'id');
			$data['jobs'] = $this->JobcardModel->jobCardDetailsForWorkshop($driver_ids);
		}else{
			$data['jobs'] = array();
		}
		$data['view'] = 'workshop/jobcard/list';
	//	dd($data);
		$this->load->view('workshop/layout', $data);
	}

	public function show($id = null) {
		if($id){
			$job_card=$this->JobcardModel->getJobCardById($id);
		}

		if(empty($job_card)){
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('admin/jobCard/list');
		}
		$job_card_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('image','image_id')),SORT_REGULAR),'image_id','');
		$repair_orders = array_filter_by_value(array_unique(array_column_multi($job_card, array('repair_order_id','parts_name','customer_request','sa_remarks','qty','price_labour','price_parts','price_total')),SORT_REGULAR),'repair_order_id','');
		$enquiry_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('enquiry_image_id','enquiry_image')),SORT_REGULAR),'enquiry_image_id','');
		$job_card = $job_card[0];
		$removeKeys=array('image','image_id','repair_order_id','parts_name','customer_request','sa_remarks','price_labour','price_parts','price_total','enquiry_image_id','enquiry_image');
		foreach($removeKeys as $key) {
		   unset($job_card[$key]);
		}
		$job_card['images_data']=$job_card_images;
		$job_card['repair_orders']=$repair_orders;
		$job_card['enquiry_images'] = $enquiry_images;
		$data['job_card'] = $job_card;
		$data['view'] = 'workshop/jobcard/show';
		$this->load->view('workshop/layout',$data);
	}
}// end of class
?>