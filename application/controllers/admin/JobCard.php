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
	    	$this->load->model('InvoiceModel');
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
		$repair_orders = array_filter_by_value(array_unique(array_column_multi($job_card, array('repair_order_id','parts_name','customer_request','sa_remarks','qty','labour_price','parts_price','total_price','status')),SORT_REGULAR),'repair_order_id','');
		$enquiry_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('enquiry_image_id','enquiry_image')),SORT_REGULAR),'enquiry_image_id','');
		$job_card = $job_card[0];
		$removeKeys=array('image','image_id','repair_order_id','parts_name','customer_request','sa_remarks','price_labour','price_parts','price_total','enquiry_image_id','enquiry_image');
		foreach($removeKeys as $key) {
		   unset($job_card[$key]);
		}
		$job_card['images_data']=$job_card_images;
		$job_card['repair_orders']=$repair_orders;
		$job_card['enquiry_images'] = $enquiry_images;
		//dd($job_card);
		$data['job_card'] = $job_card;
		$data['view'] = 'admin/jobcard/show';
		$this->load->view('admin/layout',$data);
	}

	public function invoiceList(){

		$manager_id = $this->session->userdata('id');
		$invoices = $this->InvoiceModel->get_all(array('fwd_to_customer'=>1),array('id','desc'));

		$this->load->view('admin/layout',array(
			'invoices'=> $invoices,
			'view'	  => 'admin/jobcard/invoice_list'
		));

	}

	public function invoiceShow($invoice_id = null) {
		if(! $invoice_id) {
			redirect('admin/jobCard/invoiceList');
		}
		$invoice = $this->InvoiceModel->getInvoiceById($invoice_id);

		if(empty($invoice)){
			redirect('admin/jobCard/invoiceList');
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
		//dd($invoice);
		$this->load->view('admin/layout',array(
			'invoice'=> $invoice,
			'view'	  => 'admin/jobcard/invoice_show'
		));

	}

}// end of class
?>
