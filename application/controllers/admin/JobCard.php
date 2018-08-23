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

		$data['jobs'] = $this->JobcardModel->jobCardDetails();
		$data['view'] = 'admin/jobcard/list';
	//	dd($data);
		$this->load->view('admin/layout', $data);
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
		$repair_orders = array_filter_by_value(array_unique(array_column_multi($job_card, array('repair_order_id','parts_name','customer_request','sa_remarks','qty','labour_price','parts_price','total_price')),SORT_REGULAR),'repair_order_id','');
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
		$data['view'] = 'admin/jobcard/show';
		$this->load->view('admin/layout',$data);
	}
}// end of class
?>