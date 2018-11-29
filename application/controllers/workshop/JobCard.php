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
	     $this->load->model('OrderItemModel');
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
		$this->renderView('workshop/jobcard/list', $data);
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
			$job_card=$this->JobcardModel->getJobCardFromId($id,$driver_ids);
			//dd($job_card);
		}

		if(empty($job_card)){
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/jobCard/list');
		}
		$job_card_images_key = array('job_card_image_id','job_card_image');
		$job_card_images = array_filter_by_value(array_unique(array_column_multi($job_card, $job_card_images_key),SORT_REGULAR),'job_card_image_id','');

		$order_item_keys = array('order_item_id', 'order_item_order_id', 'service_id', 'service_name','price');
		$order_items = array_filter_by_value(array_unique(array_column_multi($job_card,$order_item_keys),SORT_REGULAR),'order_item_id','');

		$job_card = $job_card[0];
		$removeKeys=array_merge($job_card_images_key,$order_item_keys);
		foreach($removeKeys as $key) {
		   unset($job_card[$key]);
		}

		$job_card['images_data']=$job_card_images;
		$job_card['order_items']=$order_items;
		//dd($job_card);
		$data['job_card'] = $job_card;

		$this->renderView('workshop/jobcard/show',$data);
	}

	public function completeJobs($id=null){
		$manager_id = $this->session->userdata('id');
		$driver_ids = $this->DriverModel->getDriversByWorkshop($manager_id);
		if($driver_ids) {
			$driver_ids = array_column($driver_ids, 'id');
		}else{
			$driver_ids=array();
		}
		//dd($driver_ids);
		if($id){
			$job_card=$this->JobcardModel->getJobCardFromId($id,$driver_ids);
		}

		if(empty($job_card)){
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/jobCard/list');
		}
		$job_card_images_key = array('job_card_image_id','job_card_image');
		$job_card_images = array_filter_by_value(array_unique(array_column_multi($job_card, $job_card_images_key),SORT_REGULAR),'job_card_image_id','');

		$order_item_keys = array('order_item_id', 'order_item_order_id', 'service_id', 'service_name','price','service_status');
		$order_items = array_filter_by_value(array_unique(array_column_multi($job_card,$order_item_keys),SORT_REGULAR),'order_item_id','');

		$job_card = $job_card[0];
		$removeKeys=array_merge($job_card_images_key,$order_item_keys);
		foreach($removeKeys as $key) {
		   unset($job_card[$key]);
		}

		$job_card['images_data'] = $job_card_images;
		$job_card['order_items'] = $order_items;
		//dd($job_card);
		$data['job_card'] = $job_card;
		//dd($job_card);
		$this->renderView('workshop/jobcard/complete-job',$data);
	}




	public function changeStatusView(){
		if($this->input->post('item_id')){
			$item_id = $this->input->post('item_id');
			$order_id = $this->input->post('order_id');
			$data['jobcard_id'] = $this->input->post('jobcard_id');
			$criteria['conditions'] = array('id'=>$item_id,'order_id'=>$order_id);
			$criteria['returnType'] = 'single';
			$data['order_item'] = $this->OrderItemModel->search($criteria);
			//$data['job_card_id'] = $job_card_id;
			$template = $this->load->view('workshop/jobcard/job-status',$data,true);
			$response = array('status'=>true,"message"=>"Record found successfully",'template'=>$template);
		}else{
			$response = array('status'=>false,'message'=>"No detail found");
		}
		$this->renderJson($response);
	}

	public function updateStatus(){
		//dd($_POST);
		$jobcard_id = $this->input->post('jobcard_id');
		if($this->input->post('submit')){
			$item_id = $this->input->post('item_id');
			$order_id = $this->input->post('order_id');

			//echo $job_id,$job_card_id;die;
			$update_data = array(
				'start_date'=>date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('start_date')))),
				'end_date'=>date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('end_date')))),
				'status' => $this->input->post('status'),
			);
			if($this->input->post('delay_reason')){
				$update_data['delay_reason']= $this->input->post('delay_reason');
			}
			$this->OrderItemModel->update($update_data,array('id'=>$item_id,'order_id'=>$order_id));
			$this->session->set_flashdata('success_msg','Record updated successfully!');
		}else{
			$this->session->set_flashdata('error_msg','Something went wrong!');
		}
		redirect('workshop/jobCard/completeJobs/'.$jobcard_id);
	}







	public function searchJobs(){
		if($this->input->post('job_card_id')){
			$job_card_id = $this->input->post('job_card_id');
			$jobs = $this->RepairOrderModel->searchJobs($job_card_id);

			if(!empty($jobs)) {
				$data = array_column($jobs, 'customer_request');
				$this->withStatus(200)->renderJson(array('status'=>true,'message'=>'Record found successfully','data'=>$data));
			}else{
				$this->withStatus(404)->renderJson(array('status'=>false,'message'=>'No data found'));
			}
		}
	}



	public function invoiceEdit($invoice_id = null) {
		//dd($_POST);
		if(! $invoice_id) {
			redirect('workshop/jobCard/list');
		}
		$manager_id = $this->session->userdata('id');
		$invoice = $this->InvoiceModel->getInvoiceById($invoice_id,$manager_id);

		if(empty($invoice)){
			redirect('workshop/jobCard/list');
		}
		$invoice_labour_keys =  array('invoice_labour_id','invoice_labour_item','invoice_labour_hour','invoice_labour_rate','invoice_labour_cost','invoice_labour_gst','invoice_labour_gst_amount','invoice_labour_total');
		$invoice_labour = array_filter_by_value(array_unique(array_column_multi($invoice,$invoice_labour_keys),SORT_REGULAR),'invoice_labour_id','');

		$invoice_parts_keys =  array('invoice_parts_id','invoice_parts_item','invoice_parts_quantity','invoice_parts_cost','invoice_parts_gst','invoice_parts_gst_amount','invoice_parts_total');
		$invoice_parts = array_filter_by_value(array_unique(array_column_multi($invoice,$invoice_parts_keys),SORT_REGULAR),'invoice_parts_id','');

		$invoice = $invoice[0];

		$removeKeys = array_merge($invoice_parts_keys,$invoice_labour_keys);
		foreach($removeKeys as $key) {
		   unset($invoice[$key]);
		}
		//dd($invoice_parts);
		$invoice['labour'] = array_values($invoice_labour);
		$invoice['parts'] = array_values($invoice_parts);
		//dd($invoice);
		$this->load->view('workshop/layout',array(
			'invoice'=> $invoice,
			'view'	  => 'workshop/jobcard/invoice_edit'
		));

	}

	public function invoiceUpdate(){
		//dd($_POST);
		if($this->input->post('submit')){
			$invoice_id = $this->input->post('invoice_id');
			$update_data = array(
				'date_created'=>$this->input->post('invoice_created_date'),
				'due_date'=>$this->input->post('invoice_due_date'),
				'sa_name' => $this->input->post('sa_name'),
				'notes' => $this->input->post('notes'),
				'labour_total' => $this->input->post('labour_total'),
				'parts_total' => $this->input->post('parts_total'),
				'gst_total' => $this->input->post('gst_total'),
				'discount' => $this->input->post('discount'),
				'discount_amount'=> $this->input->post('discount_amount'),
				'total_amount' => $this->input->post('total_amount'),
				'total_amount_after_discount'=>$this->input->post('total_amount_after_discount'),
			);

			$this->InvoiceModel->update($update_data,array('id'=>$invoice_id));

			$labour_items = $this->input->post('labour');
			$labour_items_ids = array_column($labour_items, 'id');
			if(!empty($labour_items_ids)){
				$this->InvoiceLabourItemModel->deleteItems($invoice_id,$labour_items_ids);
			}
			$insert_labour_items= array();
			$update_labour_items = array();
				foreach ($labour_items as $index => $data) {
					if(!empty($data['item'])){
						if(isset($data['id'])){
							$items = 'update_labour_items';
							${$items}[$index]['id'] = $data['id']; 
						}else{
							$items = 'insert_labour_items';
						}
						${$items}[$index]['invoice_id'] = $invoice_id;
						${$items}[$index]['item'] = $data['item'];
						${$items}[$index]['hour'] = $data['hour'];
						${$items}[$index]['rate'] = $data['rate'];
						${$items}[$index]['cost'] = $data['cost'];
						${$items}[$index]['gst'] = $data['gst'];
						${$items}[$index]['gst_amount'] = $data['gst_amount'];
						${$items}[$index]['total'] = $data['total'];
					}
				}
				if(!empty($update_labour_items)){
					$this->InvoiceLabourItemModel->update_batch($update_labour_items,'id');
				}
				if(!empty($insert_labour_items)) {
					$this->InvoiceLabourItemModel->insert_batch($insert_labour_items);
				}

				$part_items = $this->input->post('parts');
				$part_items_ids = array_column($part_items, 'id');
				if(!empty($part_items_ids)) {
					$this->InvoicePartsItemModel->deleteItems($invoice_id,$part_items_ids);
				}
				//echo $this->db->last_query();die;
				$insert_part_items = array();
				$update_part_items = array();
				foreach ($part_items as $index => $data) {
					if(!empty($data['item'])) {
						if(isset($data['id'])){
							$items = 'update_part_items';
							${$items}[$index]['id'] = $data['id']; 
						}else{
							$items = 'insert_part_items';
						}
						${$items}[$index]['invoice_id'] = $invoice_id;
						${$items}[$index]['item'] = $data['item'];
						${$items}[$index]['quantity'] = $data['qty'];
						${$items}[$index]['cost'] = $data['cost'];
						${$items}[$index]['gst'] = $data['gst'];
						${$items}[$index]['gst_amount'] = $data['gst_amount'];
						${$items}[$index]['total'] = $data['total'];
						//unset($part_items[$index]['qty']);
					}
				}
				if(!empty($update_part_items)){
					$this->InvoicePartsItemModel->update_batch($update_part_items);
				}
				if(!empty($insert_part_items)) {
					$this->InvoicePartsItemModel->insert_batch($insert_part_items);
				}
		}
		redirect('workshop/jobCard/invoiceShow/'.$invoice_id);
	}



	public function save_ride(){
		$this->load->model('RideModel');
		if($this->input->post('submit')){
			$insert_data = array(
				'driver_id' => $this->input->post('driver'),
				'job_card_id' => $this->input->post('job_card_id'),
				'customer_name' => $this->input->post('c_name'),
				'customer_phone' => ($this->input->post('c_phone')) ? '+91'.$this->input->post('c_phone'):'',
				'customer_address' => $this->input->post('c_address'),
				'delivery_date' => $this->input->post('deliver_date'),
				'delivery_time' => $this->input->post('deliver_time'),
				'ride_type' =>'delivery',
				'created_at' => date("Y-m-d H:i:s")
			);
			$insert_id = $this->RideModel->insert($insert_data);
			if($insert_id) {
				$this->session->set_flashdata('success_msg','Car delivery scheduled successfully!');
			}else{
				$this->session->set_flashdata('error_msg','Something went wrong! Please try again!');
			}
		}
		redirect('workshop/jobCard/list');
	}

}// end of class
?>
