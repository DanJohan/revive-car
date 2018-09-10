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
			$result= array();
			if(!empty($job_cards)) {
				    $newJobs = [];

			    foreach($job_cards as $value)
			    {
			        $key = $value['job_card_id'];//.$value['registration_no'];
			        if (!isset($newJobs[$key]))
			        {
			            $newJobs[$key] = [];
			            $newJobs[$key]['repair_order'] = [];
			        }
			        $newJobs[$key]['job_card_id'] = $value['job_card_id'];
			        $newJobs[$key]['registration_no'] = $value['registration_no'];
			        $newJobs[$key]['color'] =$value['color'];
                    $newJobs[$key]['brand_name'] = $value['brand_name'];
                    $newJobs[$key]['model_name'] = $value['model_name'];
			        $newJobs[$key]['repair_order'][] = [
			            'repair_order_id' => $value['repair_order_id'],
			            'customer_request'=> $value['customer_request'],
			            'qty' => $value['qty'],
			            'sa_remarks'=>$value['sa_remarks'],
			            'parts_name'=>$value['parts_name'],
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


	public function viewInvoice($id=null,$pdf=false) {
		if($id){
			$invoice = $this->InvoiceModel->getInvoiceById($id);
		}
		if(empty($invoice)){
			return;
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
		if($pdf){
			return $this->load->view('api/invoice_pdf',compact('invoice'),true);
		}
		$this->load->view('api/invoice',compact('invoice'));
	}

	public function printInvoicePdf($id=null) {
		$this->load->library('myPdf');
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetFont('times', 12);
		$pdf->AddPage();
		$html = self::viewInvoice($id,true);
		//dd($html);
		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('invoice.pdf', 'I');
		//print_r($pdf);
	}
}