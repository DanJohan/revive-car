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

		if ($this->form_validation->run() == true ) {
			$this->load->library('sequence');
			$this->sequence->createSequence('order');
			$sequence = $this->sequence->getNextSequence();
			$order_data = array(
				'order_no' =>$sequence['sequence'],
				'hash'=> md5(uniqid(true)),
				'service_type'=>$this->input->post('service_type'),
				'pick_up_date'=>$this->input->post('pick_up_date'),
				'pick_up_time' => $this->input->post('pick_up_time'),
				'sub_total'=> $this->input->post('sub_total'),
				'discount_amount'=>$this->input->post('discount_amount'),
				'net_pay_amount' => $this->input->post('net_pay_amount'),
				'user_id'=>$this->input->post('user_id'),
				'car_id' => $this->input->post('car_id'),
				'created_at' =>date('Y-m-d H:i:s')
			);

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

				$order_detail = $this->OrderModel->getById($order_id);
				if(!empty($order_detail)){
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
					$image['image'] = ($image['image'])? base_url().'public/images/admin/car/'.$image['image']:'';
				}
				$response = array('status'=>true,'message'=>'Record get successfully','data'=>$images);
			}
		}else{
			$response = array('status'=>false,'message'=>"image ids are required");
		}

		$this->renderJson($response);
	}
}// end of class
