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
		$this->load->model('WorkshopModel');

	}

	public function list() {

		$data= array();
		//$data['orders'] = $this->OrderModel->get_all();
		$this->render('admin/order/list',$data);
	}

	public function ajax_orders_list() {
		//dd($_POST);
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$order = $this->input->post('order');
		$search = $this->input->post('search');
		$services = $this->OrderModel->getOrders($start,$limit,$order,$search);
		//echo $this->db->last_query();die;
		$found_rows = $this->OrderModel->getFoundRows();
		$this->renderJson(array('draw'=>intval($this->input->post('draw')),'recordsTotal'=>intval($found_rows), 'recordsFiltered' => intval($found_rows),'data'=>$services));
	}

	public function show($id = null){
		if(!$id){
			$this->session->set_flashdata('error_msg','No detail found !');
			redirect('admin/order/list');
		}
		$data = array();
		$order = $this->OrderModel->getOrderById($id);

		if(empty($order)){
			$this->session->set_flashdata('error_msg','No detail found !');
			redirect('admin/order/list');
		}

		$order_item_keys = array('order_item_id', 'order_item_order_id', 'service_id', 'service_name','price');
		$order_item = array_filter_by_value(array_unique(array_column_multi($order,$order_item_keys),SORT_REGULAR),'order_item_id','');
		
		$image_key = array('car_image');
		$order_car_images =array_filter(array_unique(array_column($order,'car_image'),SORT_REGULAR));

		$order = $order[0];
		$removeKeys = array_merge($order_item_keys, $image_key);
		foreach($removeKeys as $key) {
		   unset($order[$key]);
		}

		$order['order_item'] = $order_item;
		$order['order_car_images'] = $order_car_images;
		$data['order'] = $order;
		//dd($order);
	
		$this->render('admin/order/show',$data);
	}

	public function getManagarListForm(){
		if($this->input->is_ajax_request()){
			$order_id = $this->input->post('order_id');

			$managers = $this->WorkshopModel->get_all();
			$template = $this->load->view('admin/order/forward_to_workshop',compact('order_id','managers'),true);
			$this->renderJson(array('status'=>true,'template'=>$template));
		}else{
			exit('No direct script access allowed');
		}
	}

	public function forworToWorkshop(){
		
		if(count($this->input->post())){
			$order_id = $this->input->post('order_id');
			$manager_id = $this->input->post('manager_id');

			$criteria['field'] = 'assign_workshop_id';
			$criteria['conditions'] = array('id'=>$order_id);
			$criteria['returnType'] = 'single';
			$result = $this->OrderModel->search($criteria);

			if(empty($result['assign_workshop_id'])){
				$this->OrderModel->update(array('assign_workshop_id'=>$manager_id),array('id'=>$order_id));
				$this->session->set_flashdata('success_msg','Forward to workshop successfully!');
			}else{
				$this->session->set_flashdata('error_msg','Order  is already forward to workshop!');
			}
		}
		redirect('admin/order/list');
		
	}



}// end of class
