<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends MY_Controller {

	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('UserModel');
	    $this->load->model('JobcardModel');
	    $this->load->model('InvoiceModel');

	}

	public function resetPassword($email=null,$hash=null) {

		if(!$email || !$hash){
			return ;
		}
		$data=array('email'=>$email,'hash'=>$hash);
		$this->load->view('api/passwordReset',$data);
	}



	public function changePasswordByEmail() {
		if($this->input->post('email')){
			$email= $this->input->post('email');
			$hash = $this->input->post('hash');
			$pwd = $this->input->post('pwd');

			$criteria['field'] = 'id,name,email';

			$criteria['conditions']=array('email'=>$email,'password_reset_hash'=>$hash);
			$criteria['returnType'] = 'single';
			$user = $this->UserModel->search($criteria);

			if($user){
				$user_id = $user['id'];
				$options = [
				    'cost' => 12,
				];

				$update_data= array(
					'password'=>password_hash($pwd,PASSWORD_BCRYPT,$options)
				);
				$this->UserModel->update($update_data,array('id'=>$user_id));
				$response = array('status'=>true,'message'=>'Password changed successfully!');
			}else{
				$response= array('status'=>false,'message'=>'User not found!');
			}
			
			$this->renderJson($response);
		}
	}// end of changePasswordByEmail method


	public function viewJobCard($id=null) {
		if($id){
			$job_card=$this->JobcardModel->getJobCardById($id);
		}else{
			show_error('No detail found!',404);
		}
		//dd($job_card);
		if(empty($job_card)){
			log_message('debug',"No detail found for ".$id);
			show_error('No detail found!',404);
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
		//$job_card['enquiry_images'] = $enquiry_images;
		$data['job_card'] = $job_card;
		//dd($data['job_card']);
		$this->load->view('api/job_card_detail',$data);
	}

	public function viewInvoice($id=null,$pdf=false) {
		if($id){
			$invoice = $this->InvoiceModel->getInvoiceById($id);
		}
		if(empty($invoice)){
			return;
		}
		$invoice_items_keys =  array('item_id','item_name','price');
		$invoice_items = array_filter_by_value(array_unique(array_column_multi($invoice,$invoice_items_keys),SORT_REGULAR),'item_id','');


		$invoice = $invoice[0];

		$removeKeys = $invoice_items_keys;
		foreach($removeKeys as $key) {
		   unset($invoice[$key]);
		}

		$invoice['invoice_items'] = $invoice_items;
		
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
		ob_end_clean();
		$pdf->Output('invoice.pdf', 'D');
		//print_r($pdf);
	}



}
