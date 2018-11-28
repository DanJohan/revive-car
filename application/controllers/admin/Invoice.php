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



	public function show($invoice_id = null) {
		if(! $invoice_id) {
			redirect('admin/invoice/list');
		}
		$manager_id = $this->session->userdata('id');
		$invoice = $this->InvoiceModel->getInvoiceById($invoice_id,$manager_id);

		if(empty($invoice)){
			redirect('admin/invoice/list');
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
		$this->render('admin/invoice/show',$data);

	}

	public function list(){


		$manager_id = $this->session->userdata('id');
		$invoices = $this->InvoiceModel->get_all(array('fwd_to_customer'=>1));
		//$invoices = $this->InvoiceModel->get_all(array('order_id'=>$order['id'],'created_by'=>$manager_id),array('id','desc'));

		if(empty($invoices)) {
			$this->session->set_flashdata('error_msg','No detail found!');
			redirect('admin/dashbord/index');
		}
		$data['invoices'] = $invoices;
		$this->render('admin/invoice/list',$data);


	}




}// end of class
