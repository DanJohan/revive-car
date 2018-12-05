<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Order extends Rest_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('ServiceDiscountModel');
	    $this->load->model('OrderModel');
	    $this->load->model('CustomerDetailModel');
	    $this->load->model('OrderCarImagesModel');
	    $this->load->model('OrderItemModel');

	}

	public function verifyCoupanCode(){
		$this->form_validation->set_rules('sub_total', 'Sub total', 'trim|required');
		$this->form_validation->set_rules('coupan_code', 'Coupan', 'trim|required');
		$service_ids = $this->input->post('service_ids');
		foreach ($service_ids as $index => $service_id) {
			$this->form_validation->set_rules('service_ids['.$index.']', 'Service id', 'trim|required');
		}

		if ($this->form_validation->run() == true ) {
			$sub_total = $this->input->post('sub_total');
			$coupan_code = $this->input->post('coupan_code');
			$service_ids = $this->input->post('service_ids');
			$coupan = $this->ServiceDiscountModel->getVerifiedCoupan($coupan_code,$service_ids);
			if(!empty($coupan)) {
				$net_total = $sub_total - $coupan['discount_value'];
				$discount_amount = $coupan['discount_value'];
				$response = array('status'=>true,'sub_total'=>$sub_total,'discount_amount'=>$discount_amount,'net_total'=>$net_total,'message'=>'Coupan applied successfully!');
			}else{
				$response = array('status'=>false,'message'=>'Coupan not found!');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}// end of verify coupan code

	public function createOrder()
	{
		$this->form_validation->set_rules('user_id','User id', 'trim|required');
		$this->form_validation->set_rules('car_id', 'Car id', 'trim|required');
		$this->form_validation->set_rules('service_type','Service type', 'trim|required');
		$this->form_validation->set_rules('pick_up_date', 'Pick up date', 'trim|required');
		$this->form_validation->set_rules('pick_up_time', 'Pick up time', 'trim|required');
		$this->form_validation->set_rules('sub_total', 'Sub total', 'trim|required');
		$this->form_validation->set_rules('net_pay_amount','Net pay amount', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('phone','Phone', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('paid_status','Paid status','trim|required');
		$this->form_validation->set_rules('payment_type', 'Payment type','trim|required');

		if ($this->form_validation->run() == true ) {
			$this->load->library('sequence');
			$this->sequence->createSequence('order');
			$sequence = $this->sequence->getNextSequence();
			$user_id = $this->input->post('user_id');
			$order_data = array(
				'order_no' =>$sequence['sequence'],
				'hash'=> md5(uniqid($user_id,true)),
				'service_type'=>$this->input->post('service_type'),
				'service_center' => $this->input->post('service_center'),
				'loaner_vehicle' => $this->input->post('loaner_vehicle'),
				'pick_up_date'=>date('Y-m-d',strtotime($this->input->post('pick_up_date'))),
				'pick_up_time' => $this->input->post('pick_up_time'),
				'sub_total'=> $this->input->post('sub_total'),
				'discount_amount'=>$this->input->post('discount_amount'),
				'net_pay_amount' => $this->input->post('net_pay_amount'),
				'paid' => $this->input->post('paid_status'),
				'payment_type_id'=>$this->input->post('payment_type'),
				'user_id'=>$user_id,
				'car_id' => $this->input->post('car_id'),
				'created_at' =>date('Y-m-d H:i:s')
			);
			if($this->input->post('payment_id')){
				$order_data['payment_id'] = $this->input->post('payment_id');
			}

			$order_id = $this->OrderModel->insert($order_data);
			if($order_id) {
				$this->sequence->updateSequence();
				$customer_data = array(
					'order_id' => $order_id,
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'address' => $this->input->post('address'),
					'latitude' => $this->input->post('latitude'),
					'longitude' => $this->input->post('longitude'),
				);
				$this->CustomerDetailModel->insert($customer_data);

				$order_items = $this->input->post('order_items');
				if(!empty($order_items)) {
					foreach ($order_items as $index => $order_item) {
						$order_item_data[] = array(
								'order_id'=>$order_id,
								'service_id'=> $order_item['id'],
								'name' => $order_item['name'],
								'price' => $order_item['price'],
						);
					}

					if(!empty($order_item_data)){
						$this->OrderItemModel->insert_batch($order_item_data);
					}
				}

				$image_ids = $this->input->post('order_images_id');
				if(!empty($image_ids)) {
					$this->OrderCarImagesModel->updateOrderImages($image_ids,$order_id);
				}

				/*$pusher = new Pusher\Pusher(PUSHER_KEY,PUSHER_SECRET,PUSHER_APP_ID,array('cluster' => PUSHER_CLUSTER,'useTLS' => true));
				 $data['message'] = 'You have new order received!';
  				 $pusher->trigger('order', 'receive-order', $data);*/

				$order_detail = $this->OrderModel->getById($order_id);
				if(!empty($order_detail)){
					$order_detail = $this->OrderModel->arrangeOrderData($order_detail);
					$response = array('status'=>true,'message'=>'Order placed successfully','data'=>$order_detail);
				}else{
					$response = array('status'=>false,'message'=>'Something went wrong!');
				}
			}else{
				$response = array('status'=>false,'message'=>'Something went wrong!');
			}

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}// end of create order method


	public function uploadOrderImages() {
		if(isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
			$file_name = '';
			$url = FCPATH."uploads/app/";
			$config['new_name']=true;
			$upload =$this->do_upload('file',$url,$config);
			if(isset($upload['upload_data'])){
				chmod($upload['upload_data']['full_path'], 0777);
				$file_name = $upload['upload_data']['file_name'];
				$insert_data = array(
					'image' =>$file_name,
					'created_at' => date('Y-m-d H:i:s')
				);
				$insert_id = $this->OrderCarImagesModel->insert($insert_data);
				if($insert_id){
					$criteria['field'] = 'id,image';
					$criteria['conditions'] = array('id'=>$insert_id);
					$criteria['returnType'] = 'single';
					$image = $this->OrderCarImagesModel->search($criteria);
					if(!empty($image)){
						$image['image'] = base_url()."uploads/app/".$image['image'];
						$response = array('status'=>true,'message'=>'Image Uploaded successfully','data'=>$image);
					}else{
						$response = array('status'=>false,'message'=>'Somthing went wrong');
					}
				}else{
					$response = array('status'=>false,'message'=>'Somthing went wrong');
				}
			}else{
				$response = array('status'=>false,'message'=>strip_tags($upload['error']));
			}
		}
		$this->renderJson($response);
	}// end of  uploadServiceImages method


	public function deleteOrderImages(){
		$image_ids = $this->input->post('image_ids');

		if(!empty($image_ids)){	
			if(is_array($image_ids)){
				$images = $this->OrderCarImagesModel->getImagesById($image_ids);

				if(!empty($images)){
					foreach ($images as $index => $image) {
						$is_delete = $this->OrderCarImagesModel->delete(array('id'=>$image['id']));
						@unlink(FCPATH."uploads/app/".$image['image']);
					}
					$response = array('status'=>true,'message'=>'Images deleted successfully');
				}else{
					$response = array('status'=>false,'message'=>'Somthing went wrong!');
				}
			}else{
				$image = $this->OrderCarImagesModel->get(array('id'=>$image_ids));
				if(!empty($image)){
					$this->OrderCarImagesModel->delete(array('id'=>$image['id']));
					@unlink(FCPATH."uploads/app/".$image['image']);
					$response = array('status'=>true,'message'=>'Image deleted successfully');
				}else{
					$response = array('status'=>false,'message'=>'Somthing went wrong!');
				}
			}
		}else{
			$response = array('status'=>false,'message'=>'Images are required');
		}
		$this->renderJson($response);
	}

	public function getOrderImages() {

		if($this->input->post('image_ids')){
			$image_ids = $this->input->post('image_ids');
			$images = $this->OrderCarImagesModel->getImagesById($image_ids);
			if(!empty($images)){
				foreach ($images as $index => &$image) {
					$image['image'] = ($image['image'])? base_url().'uploads/app/'.$image['image']:'';
				}
				$response = array('status'=>true,'message'=>'Record get successfully','data'=>$images);
			}
		}else{
			$response = array('status'=>false,'message'=>"image ids are required");
		}

		$this->renderJson($response);
	}

	public function getUserOrders(){
		
		$this->form_validation->set_rules('user_id','User id', 'trim|required');

		if ($this->form_validation->run() == true ) {
			$user_id = $this->input->post('user_id');
			$orders = $this->OrderModel->getOrdersByUser($user_id);
			//dd($orders,false);
			if(!empty($orders)){
				$new_orders = [];
				foreach ($orders as $order) {
					$key = $order['id'];
					if(!isset($new_orders[$key])){
						$new_orders[$key] = [];
						$new_orders[$key]['order_items'] = [];
					}

					$new_orders[$key]['id'] = $order['id'];
		            	$new_orders[$key]['order_no'] = $order['order_no'];
		            	$new_orders[$key]['service_type'] = $order['service_type'];
		            	$new_orders[$key]['service_center'] = $order['service_center'];
		            	$new_orders[$key]['loaner_vehicle'] = $order['loaner_vehicle'];
		            	$new_orders[$key]['pick_up_date'] = $order['pick_up_date'];
		            	$new_orders[$key]['pick_up_time'] = $order['pick_up_time'];
		            	$new_orders[$key]['sub_total'] = $order['sub_total'];
		            	$new_orders[$key]['discount_amount'] = $order['discount_amount'];
		            	$new_orders[$key]['net_pay_amount'] = $order['net_pay_amount'];
		            	$new_orders[$key]['paid'] = $order['paid'];
		            	$new_orders[$key]['payment_type'] = $order['payment_type'];
		            	$new_orders[$key]['status'] = $order['status'];
		            	$new_orders[$key]['created_at'] = $order['created_at'];
		            	$new_orders[$key]['customer_name'] = $order['customer_name'];
		            	$new_orders[$key]['customer_email'] = $order['customer_email'];
		            	$new_orders[$key]['customer_phone'] = $order['customer_phone'];
		            	$new_orders[$key]['customer_address'] = $order['customer_address'];
		            	$new_orders[$key]['latitude'] = $order['latitude'];
		            	$new_orders[$key]['longitude'] = $order['longitude'];
		            	$new_orders[$key]['brand_name'] = $order['brand_name'];
		            	$new_orders[$key]['model_name'] = $order['model_name'];
		            	$new_orders[$key]['registration_no'] = $order['registration_no'];
					$new_orders[$key]['order_items'][] = [
						  'id' => $order['order_item_id'],
				            'order_id'=> $order['order_item_order_id'],
				            'service_id' => $order['service_id'],
				            'service_name' => $order['service_name'],
				            'price' => $order['price'],
					];
					
				}
				$new_orders= array_values($new_orders);
				//dd($new_orders);
				$response = array('status'=>true,'message'=>'Record found successfully','data'=>$new_orders);
			}else{
				$response = array('status'=>false,'message'=>'No detail found!');
			}
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function cancelOrder(){
		$this->form_validation->set_rules('order_id','Order id', 'trim|required');
		if ($this->form_validation->run() == true ) {
			$order_id = $this->input->post('order_id');
			$is_update = $this->OrderModel->update(array('status'=>2),array('id'=>$order_id));
			$response = array('status'=>true,'message'=>'Order cancel successfully!');

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}



}// end of class
