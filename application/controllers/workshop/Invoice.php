<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_manager_login'] == TRUE)
		{
		   redirect('workshop/auth/login'); //redirect to login page
		}
		$this->load->model('OrderModel');
		$this->load->model('DriverModel');
		$this->load->model('JobcardModel');
		$this->load->model('InvoiceModel');
		$this->load->model('InvoiceItemModel');

	}

	public function create($hash=null){

		if(!$hash){
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/order/list');
		}

		$criteria['field'] = 'id';
		$criteria['conditions'] = array('hash'=>$hash);
		$criteria['returnType'] = 'single';

		$order = $this->OrderModel->search($criteria);
		//dd($order);
		unset($criteria);
		if(empty($order)) {
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/order/list');

		}

		$criteria['field'] = 'id';
		$criteria['conditions'] = array('order_id'=>$order['id']);
		$criteria['returnType'] = 'single';

		$jobcard = $this->JobcardModel->search($criteria);

		if(empty($jobcard)){
			$this->session->set_flashdata('error_msg','Job card detail is required!');
			redirect('workshop/order/list');
		}

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
		
		$job_card=$this->JobcardModel->getJobCardFromId($jobcard['id'],$driver_ids);
	
		if(empty($job_card)){
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/order/list');
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
		//$data['view'] = 'workshop/jobcard/invoice';
		$this->renderView('workshop/invoice/create',$data);
	}


	public function save(){
		//dd($_POST);
		$this->load->library('sequence');
		$this->sequence->createSequence('invoice');
		$sequence = $this->sequence->getNextSequence();
		if($this->input->post('submit')){
			$insert_invoice_data = array(
				'invoice_number'=>$sequence['sequence'],
				'order_id' =>$this->input->post('order_id'),
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
				'date_created'=>date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('invoice_created_date')))),
				'due_date'=>date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('invoice_due_date')))),
				'sa_name'=>$this->input->post('sa_name'),
				'sub_total'=>$this->input->post('sub_total'),
				'gst' => $this->input->post('gst'),
				'gst_amount'=>$this->input->post('gst_amount'),
				'discount_amount'=>$this->input->post('discount_amount'),
				'total_amount'=>$this->input->post('total_amount'),
				'total_pay_amount'=>$this->input->post('total_pay_amount'),
				'notes'=> $this->input->post('notes'),
				'created_by'=>$this->session->userdata('id'),
				'created_at'=>date('Y-m-d H:i:s')
			);
			$invoice_id = $this->InvoiceModel->insert($insert_invoice_data);

			if($invoice_id){
				$this->sequence->updateSequence();
				$order_items = $this->input->post('order_items');
				$insert_order_items= array();
				foreach ($order_items as $index => $data) {
				
					if(!empty($data['service_name'])){
						$insert_order_items[$index]['invoice_id'] = $invoice_id;
						$insert_order_items[$index]['item_name'] = $data['service_name'];
						$insert_order_items[$index]['price'] = $data['price'];
					}
				}
				
				if(!empty($insert_order_items)) {
					$this->InvoiceItemModel->insert_batch($insert_order_items);
				}
				
				$this->session->set_flashdata('success_msg','Invoice generated successfully');
				redirect('workshop/invoice/show/'.$invoice_id);
			}

		}
		redirect('workshop/order/list');
	}

	public function show($invoice_id = null) {
		if(! $invoice_id) {
			redirect('workshop/invoice/list');
		}
		$manager_id = $this->session->userdata('id');
		$invoice = $this->InvoiceModel->getInvoiceById($invoice_id,$manager_id);

		if(empty($invoice)){
			redirect('workshop/invoice/list');
		}
		//dd($invoice);
		$invoice_items_keys =  array('item_id','item_name','price');
		$invoice_items = array_filter_by_value(array_unique(array_column_multi($invoice,$invoice_items_keys),SORT_REGULAR),'item_id','');


		$invoice = $invoice[0];

		$removeKeys = $invoice_items_keys;
		foreach($removeKeys as $key) {
		   unset($invoice[$key]);
		}

		$invoice['invoice_items'] = $invoice_items;
		$data['invoice'] = $invoice;
		//dd($invoice);
		$this->renderView('workshop/invoice/show',$data);

	}

	public function list($order_hash=null){

		if(!$order_hash){
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/order/list');
		}
		$criteria['field'] = 'id';
		$criteria['conditions'] = array('hash'=>$order_hash);
		$criteria['returnType'] = 'single';
		$order = $this->OrderModel->search($criteria);

		if(empty($order)) {
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/order/list');
		}

		$manager_id = $this->session->userdata('id');
		$invoices = $this->InvoiceModel->getAllInvoice($order['id'],$manager_id);
		//$invoices = $this->InvoiceModel->get_all(array('order_id'=>$order['id'],'created_by'=>$manager_id),array('id','desc'));

		if(empty($invoices)) {
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('workshop/order/list');
		}
		$data['invoices'] = $invoices;
		$this->renderView('workshop/invoice/list',$data);


	}

	public function invoiceFwdToCust($invoice_id=null,$hash){
		//die;
		if($invoice_id){
			$this->InvoiceModel->update(array('fwd_to_customer'=>1),array('id'=>$invoice_id));
			$this->session->set_flashdata('info_msg','Invoice has been forward to customer successfully');
		}
		redirect('workshop/invoice/list/'.$hash);
	}


}// end of class
