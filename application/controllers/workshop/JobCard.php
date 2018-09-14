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
	    $this->load->model('InvoiceModel');
	    $this->load->model('InvoiceLabourItemModel');
	    $this->load->model('InvoicePartsItemModel');
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


	public function invoice($id=null){

		$this->load->library('sequence');
		$this->sequence->createSequence('invoice');
		$data['sequence']=$this->sequence->getNextSequence();
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
		$job_card = $job_card[0];
		$removeKeys=array('image','image_id','repair_order_id','parts_name','customer_request','sa_remarks','labour_price','parts_price','total_price','enquiry_image_id','enquiry_image');
		foreach($removeKeys as $key) {
		   unset($job_card[$key]);
		}
		$data['job_card'] = $job_card;
		$data['view'] = 'workshop/jobcard/invoice';
		$this->load->view('workshop/layout',$data);
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

	public function createInvoice(){
		//dd($_POST);
		$this->load->library('sequence');
		$this->sequence->createSequence('invoice');
		$sequence = $this->sequence->getNextSequence();
		if($this->input->post('submit')){
			$insert_invoice_data = array(
				'invoice_number'=>$sequence['sequence'],
				'job_card_id' =>$this->input->post('job_card_id'),
				'user_id' => $this->input->post('user_id'),
				'client_name' => $this->input->post('client_name'),
				'client_phone' => $this->input->post('client_phone'),
				'client_email' => $this->input->post('client_email'),
				'client_address'=> $this->input->post('client_address'),
				'vehicle_reg_no'=> $this->input->post('vehicle_reg_no'),
				'vehicle_brand_name'=>$this->input->post('vehicle_brand_name'),
				'vehicle_model_name'=>$this->input->post('vehicle_model_name'),
				'vehicle_vin_no'=>$this->input->post('vehicle_vin_no'),
				'vehicle_kms'=>$this->input->post('vehicle_kms'),
				'date_created'=>$this->input->post('invoice_created_date'),
				'due_date'=>$this->input->post('invoice_due_date'),
				'sa_name'=>$this->input->post('sa_name'),
				'labour_total'=> $this->input->post('labour_total'),
				'parts_total'=> $this->input->post('parts_total'),
				'gst_total'=>$this->input->post('gst_total'),
				'discount'=>$this->input->post('discount'),
				'total_amount_after_discount'=>$this->input->post('total_amount_after_discount'),
				'total_amount'=>$this->input->post('total_amount'),
				'discount_amount'=>$this->input->post('discount_amount'),
				'notes'=> $this->input->post('notes'),
				'created_by'=>$this->session->userdata('id'),
				'created_at'=>date('Y-m-d H:i:s')
			);
			$invoice_id = $this->InvoiceModel->insert($insert_invoice_data);
			if($invoice_id){
				$this->sequence->updateSequence();
				$labour_items = $this->input->post('labour');
				$insert_labour_items= array();
				foreach ($labour_items as $index => $data) {
					if(!empty($data['item'])){
						$insert_labour_items[$index]['invoice_id'] = $invoice_id;
						$insert_labour_items[$index]['item'] = $data['item'];
						$insert_labour_items[$index]['hour'] = $data['hour'];
						$insert_labour_items[$index]['rate'] = $data['rate'];
						$insert_labour_items[$index]['cost'] = $data['cost'];
						$insert_labour_items[$index]['gst'] = $data['gst'];
						$insert_labour_items[$index]['gst_amount'] = $data['gst_amount'];
						$insert_labour_items[$index]['total'] = $data['total'];
					}
				}
				if(!empty($insert_labour_items)) {
					$this->InvoiceLabourItemModel->insert_batch($insert_labour_items);
				}
				$part_items = $this->input->post('parts');
				$insert_part_items = array();
				foreach ($part_items as $index => $data) {
					if(!empty($data['item'])) {
						$insert_part_items[$index]['invoice_id'] = $invoice_id;
						$insert_part_items[$index]['item'] = $data['item'];
						$insert_part_items[$index]['quantity'] = $data['qty'];
						$insert_part_items[$index]['cost'] = $data['cost'];
						$insert_part_items[$index]['gst'] = $data['gst'];
						$insert_part_items[$index]['gst_amount'] = $data['gst_amount'];
						$insert_part_items[$index]['total'] = $data['total'];
						//unset($part_items[$index]['qty']);
					}
				}
				if(!empty($insert_part_items)) {
					$this->InvoicePartsItemModel->insert_batch($insert_part_items);
				}
				$this->session->set_flashdata('success_msg','Invoice generated successfully');
			}

		}
		redirect('workshop/jobCard/invoiceShow/'.$invoice_id);
	}

	public function invoiceList($job_card_id=null){
		if(!$job_card_id){
			redirect('workshop/jobCard/list');
		}
		$manager_id = $this->session->userdata('id');
		$invoices = $this->InvoiceModel->get_all(array('job_card_id'=>$job_card_id,'created_by'=>$manager_id),array('id','desc'));
		//dd($invoices);
		//echo $this->db->last_query();die;
		if(empty($invoices)) {
			redirect('workshop/jobCard/list');
		}
		//dd($invoices);
		$this->load->view('workshop/layout',array(
			'invoices'=> $invoices,
			'view'	  => 'workshop/jobcard/invoice_list'
		));

	}


	public function invoiceShow($invoice_id = null) {
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
		$invoice['labour'] = $invoice_labour;
		$invoice['parts'] = $invoice_parts;
		$this->load->view('workshop/layout',array(
			'invoice'=> $invoice,
			'view'	  => 'workshop/jobcard/invoice_show'
		));

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

	public function invoiceFwdToCust($invoice_id=null,$job_card_id){
		if($invoice_id){
			$this->InvoiceModel->update(array('fwd_to_customer'=>1),array('id'=>$invoice_id));
			$this->session->set_flashdata('info_msg','Invoice has been forward to customer successfully');
		}
		redirect('workshop/jobCard/invoiceList/'.$job_card_id);
	}

}// end of class
?>