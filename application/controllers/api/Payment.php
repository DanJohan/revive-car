<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Payment extends Rest_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('InvoiceModel');
		$this->load->model('PaymentModel');
	}

	public function getPayuHash(){
		$this->load->library('payu');
		$this->form_validation->set_rules('key', 'Key', 'trim|required');
		$this->form_validation->set_rules('txnid', 'Transaction id', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		$this->form_validation->set_rules('productInfo', 'Product info', 'trim|required');
		$this->form_validation->set_rules('firstName', 'First name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		if ($this->form_validation->run() == true) {
			$hashParmas = array(
				'key' => $this->input->post('key'),
				'txnid'=>$this->input->post('txnid'),
				'amount'=>$this->input->post('amount'),
				'productinfo'=>$this->input->post('productInfo'),
				'firstname' => $this->input->post('firstName'),
				'email'=>$this->input->post('email')
			);
			$hash = $this->payu->getHash($hashParmas);
			if($hash){
				$response = array('status'=>true,'message'=>'Hash generated!','hash'=>$hash);
			}else{
				$response = array('status'=>false,'message'=>'Something went wrong!');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}// end of getPayuHash method

	public function getPaytmHash(){
		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");

		require_once(APPPATH . "/third_party/paytmlib/config_paytm.php");
		require_once(APPPATH . "/third_party/paytmlib/encdec_paytm.php");

		$this->form_validation->set_rules('order_id', 'Order id', 'trim|required');
		$this->form_validation->set_rules('cust_id', 'Cust id', 'trim|required');
		$this->form_validation->set_rules('industry_type_id', 'Industry type id', 'trim|required');
		$this->form_validation->set_rules('channel_id', 'Channel id', 'trim|required');
		$this->form_validation->set_rules('txn_amount', 'Txn amount', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('mobile_no', 'Mobile no', 'trim|required');

		if ($this->form_validation->run() == true) {
			$checkSum = "";
			$paramList = array();

			$ORDER_ID = $this->input->post('order_id');
			$CUST_ID = $this->input->post('cust_id');
			$INDUSTRY_TYPE_ID = $this->input->post('industry_type_id');
			$CHANNEL_ID = $this->input->post('channel_id');
			$TXN_AMOUNT =  $this->input->post('txn_amount');
			$EMAIL = $this->input->post('email');
			$MOBILE_NO = str_replace('+', '',$this->input->post('mobile_no'));

			$paramList["MID"] = PAYTM_MERCHANT_MID;
			$paramList["ORDER_ID"] = $ORDER_ID;
			$paramList["CUST_ID"] = $CUST_ID;
			$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
			$paramList["CHANNEL_ID"] = $CHANNEL_ID;
			$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
			$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
			//$paramList["CALLBACK_URL"] = "http://localhost/Projects/Paytm_Web_Sample_Kit_PHP-masterr/PaytmKit/pgResponse.php";
			$paramList["MSISDN"] = $MOBILE_NO;
			$paramList["EMAIL"] = $EMAIL;

			$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
			if($checkSum){
				$response = array('status'=>true,'message'=>'Checksum generated','hash'=>$checkSum);
			}else{
				$response = array('status'=>false,'message'=>'Something went wrong!');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function save() {

		$this->form_validation->set_rules('txn_id', 'Transaction id', 'trim|required');
		$this->form_validation->set_rules('client_txn_id', 'Client transaction id', 'trim|required');
		$this->form_validation->set_rules('payment_type', 'Payment type', 'trim|required');
		$this->form_validation->set_rules('invoice_id', 'Invoice id', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		if ($this->form_validation->run() == true) {
			$invoice_id = $this->input->post('invoice_id');
			$insert_data = array(
				'merchant_transaction_id'=>$this->input->post('txn_id'),
				'client_transaction_id' => $this->input->post('client_txn_id'),
				'payment_type_id' => $this->input->post('payment_type'),
				'invoice_id' =>$invoice_id,
				'amount' => $this->input->post('amount'),
				'status' =>$this->input->post('status'),
				'created_at'=>date("Y-m-d H:i:s")
			);
			$insert_id = $this->PaymentModel->insert($insert_data);
			if($insert_id){
				$this->InvoiceModel->update(array('paid'=>1,'payment_id'=>$insert_id),array('id'=>$invoice_id));
				$payment = $this->PaymentModel->getById($insert_id);
				if($payment){
					$response= array('status'=>true,'message'=>'Payment made successfully!','data'=>$payment);
				}else{
					$response = array('status'=>false,'message'=>'Something went wrong!Please try again');
				}
			}else{
				$response = array('status'=>false,'message'=>'Something went wrong!Please try again');
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

}// end of class

?>
