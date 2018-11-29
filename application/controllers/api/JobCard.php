<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class JobCard extends Rest_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('JobcardModel');
	    $this->load->model('InvoiceModel');
	}

	public function getUserJobCard(){
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$job_cards = $this->JobcardModel->getUserAllJobCard($user_id);
			//dd($job_cards);
			$result= array();
			if(!empty($job_cards)) {
				    $newJobs = [];

			    foreach($job_cards as $value)
			    {
			        $key = $value['id'];//.$value['registration_no'];
			        if (!isset($newJobs[$key]))
			        {
			            $newJobs[$key] = [];
			            $newJobs[$key]['order_items'] = [];
			        }
			        	$newJobs[$key]['id'] = $value['id'];
			        	$newJobs[$key]['registration_no'] = $value['registration_no'];
                      	$newJobs[$key]['brand_name'] = $value['brand_name'];
                    	$newJobs[$key]['model_name'] = $value['model_name'];
			        	$newJobs[$key]['order_items'][] = [
			            'item_id' => $value['item_id'],
			            'item_name'=> $value['item_name'],
			            'item_price' => $value['item_price'],
			            'status'=>$value['status'],
			            'start_date'=>$value['start_date'],
			            'end_date'=>$value['end_date'],
			            'delay_reason'=>$value['delay_reason']
			        ];
			    }
			    $newJobs = array_values($newJobs);
			    if(!empty($newJobs)){
			    	$response = array('status'=>true,'message'=>"Detail found successfully",'data'=>$newJobs);
			    }
	        }else{
	        	$response = array('status'=>false, 'message'=>"No detail found");
	        }

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}




	public function getUserInvoices(){
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$invoices = $this->InvoiceModel->getInvoiceByUserId($user_id);
			//dd($invoices);
			if(!empty($invoices)){
				$newInvoices = array();
				$invoices = array_values(array_group_by($invoices,'id'));
				//dd($invoices);
				foreach ($invoices as $index => $invoice) {
					$invoice_items_keys =  array('item_id','item_name','price');
					$invoice_items = array_filter_by_value(array_unique(array_column_multi($invoice,$invoice_items_keys),SORT_REGULAR),'item_id','');


					$invoice = $invoice[0];

					$removeKeys = $invoice_items_keys;
					foreach($removeKeys as $key) {
					   unset($invoice[$key]);
					}

					$invoice['invoice_items'] = $invoice_items;
					$newInvoices[]=$invoice;	
				}

				$response = array('status'=>true,'message'=>'Record found successfully','data'=>$newInvoices);
			}else{
				$response = array('status'=>false,'message'=>"No record found!");
			}
		} else { 
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}// end of getUserrInvoices
}
