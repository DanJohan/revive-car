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
	    $this->load->model('RepairOrderModel');
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
		$manager_id = $this->session->userdata('id');
		$driver_ids = $this->DriverModel->getDriversByWorkshop($manager_id);
		if($driver_ids) {
			$driver_ids = array_column($driver_ids, 'id');
		}else{
			$driver_ids=array();
		}
		if($id){
			$job_card=$this->JobcardModel->getJobCardById($id,$driver_ids);
		}

		if(empty($job_card)){
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/jobCard/list');
		}
		$job_card_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('image','image_id')),SORT_REGULAR),'image_id','');
		$repair_orders = array_filter_by_value(array_unique(array_column_multi($job_card, array('repair_order_id','parts_name','customer_request','sa_remarks','qty','labour_price','parts_price','total_price','status')),SORT_REGULAR),'repair_order_id','');
		$enquiry_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('enquiry_image_id','enquiry_image')),SORT_REGULAR),'enquiry_image_id','');
		$job_card = $job_card[0];
		$removeKeys=array('image','image_id','repair_order_id','parts_name','customer_request','sa_remarks','labour_price','parts_price','total_price','enquiry_image_id','enquiry_image');
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

	public function completeJobs($id=null){
		$manager_id = $this->session->userdata('id');
		$driver_ids = $this->DriverModel->getDriversByWorkshop($manager_id);
		if($driver_ids) {
			$driver_ids = array_column($driver_ids, 'id');
		}else{
			$driver_ids=array();
		}
		if($id){
			$job_card=$this->JobcardModel->getJobCardById($id,$driver_ids);
		}

		if(empty($job_card)){
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/jobCard/list');
		}
		$job_card_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('image','image_id')),SORT_REGULAR),'image_id','');
		$repair_orders = array_filter_by_value(array_unique(array_column_multi($job_card, array('repair_order_id','parts_name','customer_request','sa_remarks','qty','labour_price','parts_price','total_price','status')),SORT_REGULAR),'repair_order_id','');
		$enquiry_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('enquiry_image_id','enquiry_image')),SORT_REGULAR),'enquiry_image_id','');
		$job_card = $job_card[0];
		$removeKeys=array('image','image_id','repair_order_id','parts_name','customer_request','sa_remarks','labour_price','parts_price','total_price','enquiry_image_id','enquiry_image');
		foreach($removeKeys as $key) {
		   unset($job_card[$key]);
		}
		$job_card['images_data']=$job_card_images;
		$job_card['repair_orders']=$repair_orders;
		$job_card['enquiry_images'] = $enquiry_images;
		$data['job_card'] = $job_card;
		$data['view'] = 'workshop/jobcard/complete-job';
		$this->load->view('workshop/layout',$data);
	}

	public function editRepairOrder(){
		if($this->input->post('submit')){
			$job_card_id = $this->input->post('job_card_id');
			$job_id = $this->input->post('job_id');
			//echo $job_id,$job_card_id;die;
			$update_data = array(
				'customer_request'=>$this->input->post('customer_request'),
				'sa_remarks'=>$this->input->post('sa_remarks'),
				'parts_name' => $this->input->post('parts_name'),
				'qty' => $this->input->post('quantity'),
				'parts_price' =>$this->input->post('parts_price'),
				'labour_price'=> $this->input->post('labour_price'),
				'total_price' => $this->input->post('total_price'),
			);
			$this->RepairOrderModel->update($update_data,array('id'=>$job_id));
			$this->session->set_flashdata('success_msg','Record updated successfully!');
		}else{
			$this->session->set_flashdata('error_msg','Something went wrong!');
		}
		redirect('workshop/jobCard/completeJobs/'.$job_card_id);
	}

	public function editRepairOrderView(){
		if($this->input->post('job_id')){
			$job_id = $this->input->post('job_id');
			$job_card_id = $this->input->post('job_card_id');
			$criteria['conditions'] = array('id'=>$job_id);
			$criteria['returnType'] = 'single';
			$data['job'] = $this->RepairOrderModel->search($criteria);
			$data['job_card_id'] = $job_card_id;
			$template = $this->load->view('workshop/jobcard/edit-repair-order',$data,true);
			$response = array('status'=>true,"message"=>"Record found successfully",'template'=>$template);
		}else{
			$response = array('status'=>false,'message'=>"No detail found");
		}
		$this->renderJson($response);
	}

	public function changeStatusView(){
		if($this->input->post('job_id')){
			$job_id = $this->input->post('job_id');
			$job_card_id = $this->input->post('job_card_id');
			$criteria['conditions'] = array('id'=>$job_id);
			$criteria['returnType'] = 'single';
			$data['job'] = $this->RepairOrderModel->search($criteria);
			$data['job_card_id'] = $job_card_id;
			$template = $this->load->view('workshop/jobcard/job-status',$data,true);
			$response = array('status'=>true,"message"=>"Record found successfully",'template'=>$template);
		}else{
			$response = array('status'=>false,'message'=>"No detail found");
		}
		$this->renderJson($response);
	}

	public function updateStatus(){
		if($this->input->post('submit')){
			$job_card_id = $this->input->post('job_card_id');
			$job_id = $this->input->post('job_id');
			//echo $job_id,$job_card_id;die;
			$update_data = array(
				'start_date'=>$this->input->post('start_date'),
				'end_date'=>$this->input->post('end_date'),
				'status' => $this->input->post('status'),
			);
			if($this->input->post('delay_reason')){
				$update_data['delay_reason']= $this->input->post('delay_reason');
			}
			$this->RepairOrderModel->update($update_data,array('id'=>$job_id));
			$this->session->set_flashdata('success_msg','Record updated successfully!');
		}else{
			$this->session->set_flashdata('error_msg','Something went wrong!');
		}
		redirect('workshop/jobCard/completeJobs/'.$job_card_id);
	}

	public function markJobComplete(){
		$job_id = $this->input->post('job_id');

		if($job_id){
			$this->RepairOrderModel->update(array('status'=>1),array('id'=>$job_id));
			$response = array('status'=>true,"message"=>"Record updated successfully!");
		}else{
			$response = array('status'=>false,"message"=>"Smothing went wrong");
		}
		$this->renderJson($response);
	}

	public function addOrder(){
		if(count($_POST)>0) {
			$insert_data = array(
				'job_card_id'=>$this->input->post('job_card_id'),
				'parts_name' => $this->input->post('parts_name'),
				'customer_request'=>$this->input->post('customer_request'),
				'sa_remarks'=>$this->input->post('sa_remarks'),
				'qty'=>$this->input->post('quantity'),
				'labour_price'=>$this->input->post('labour_price'),
				'parts_price'=>$this->input->post('parts_price'),
				'total_price' =>$this->input->post('total_price')
			);
			$this->RepairOrderModel->insert($insert_data);
			$this->session->set_flashdata('success_msg',"Record inserted successfully");
		}else{
			$this->session->set_flashdata('error_msg',"An error occured! Please try again");
		}
		redirect('workshop/jobCard/completeJobs/'.$this->input->post('job_card_id'));
	}
}// end of class
?>