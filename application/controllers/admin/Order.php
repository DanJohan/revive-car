<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_admin_login'] == TRUE)
		{
		   redirect('admin/auth/login'); //redirect to login page
		}
		$this->load->model('OrderModel');

	}

	public function list() {

		$data= array();
		$data['orders'] = $this->OrderModel->get_all();
		$this->render('admin/order/list',$data);
	}

	public function view($id = null){
		if(!$id){
			$this->session->set_flashdata('error_msg','No detail found !');
			redirect('admin/order/list');
		}
	}



}// end of class
