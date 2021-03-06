<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_manager_login'] == TRUE)
		{
		   redirect('workshop/auth/login'); //redirect to login page
		}
		$this->load->model('OrderModel');
		$this->load->model('DriverModel');
		$this->load->model('RideModel');
		$this->load->model('DriverNotificationModel');
		$this->load->model('NotificationModel');
		$this->load->model('JobcardModel');
		$this->load->model('InvoiceModel');
		$this->load->model('InvoiceItemModel');

	}

	public function list() {

		$data= array();
		$manager_id = $this->session->userdata('id');
		$data['orders'] = $this->OrderModel->get_all(array('assign_workshop_id'=>$manager_id));
		$this->renderView('workshop/order/list',$data);
	}

	public function show($hash = null){
		if(!$hash){
			$this->session->set_flashdata('error_msg','No detail found !');
			redirect('workshop/order/list');
		}
		$criteria['field'] = 'id';
		$criteria['conditions'] = array('hash'=>$hash);
		$criteria['returnType'] = 'single';

		$order_result = $this->OrderModel->search($criteria);

		if(empty($order_result)) {
			$this->session->set_flashdata('error_msg','No detail found !');
			redirect('workshop/order/list');
		}

		$this->OrderModel->markOrderWorkshopSeen($order_result['id']);

		$data = array();
		$order = $this->OrderModel->getOrderById($order_result['id']);
		//dd($order);
		if(empty($order)){
			$this->session->set_flashdata('error_msg','No detail found !');
			redirect('workshop/order/list');
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
	
		$this->renderView('workshop/order/show',$data);
	}

	public function create_ride($hash=null){
		//dd($_POST);
		if(!$hash){
			$this->session->set_flashdata('error_msg','No detail found !');
			redirect('workshop/order/list');
		}

		$criteria['field'] = 'id,loaner_vehicle';
		$criteria['conditions'] = array('hash'=>$hash);
		$criteria['returnType'] = 'single';

		$order = $this->OrderModel->search($criteria);
		if(!$order){
			$this->session->set_flashdata('error_msg','No detail found !');
			redirect('workshop/order/list');
		}

		$this->load->helper('api');
		if($this->input->post('submit')){
			//dd($_POST);
			$factory = new RandomLib\Factory;
			$generator =$factory->getMediumStrengthGenerator();
			$randomInt = $generator->generateInt(100000, 999999);
			//$randomChar = $generator->generateString(3,'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$otp = $randomInt;
			$driver_id = $this->input->post('driver');
			$ride_type = $this->input->post('ride_type');
			$check_ride = $this->RideModel->checkRideExists($order['id'],$driver_id, $ride_type);
			if($check_ride) {
				$this->session->set_flashdata('error_msg','Ride is already scheduled for this order !');
				redirect('workshop/order/list');
			}
			$insert_data = array(
				'order_id' => $order['id'],
				'driver_id' => $this->input->post('driver'),
				'ride_date' => date('Y-m-d',strtotime(str_replace('/','-',$this->input->post('ride_date')))),
				'ride_time' => date('h:iA',strtotime($this->input->post('ride_time'))),
				'ride_type' => $this->input->post('ride_type'),
				'verfication_code' => $otp,
				'created_at' => date('Y-m-d H:i:s')
			);
			//dd($insert_data);
			$insert_id = $this->RideModel->insert($insert_data);
			if($insert_id){
				$update_order_data = array(
					'loaner_vehicle' => $this->input->post('loaner_vehicle'),
					'lv_reg_no'	=> ($this->input->post('lv_reg_no'))? $this->input->post('lv_reg_no') :null,
					'status' => 3,
				);
				
				$this->OrderModel->update($update_order_data,array('id'=>$order['id']));
				
				$ride = $this->RideModel->getCustomerDriverDetail($insert_id);
				//dd($ride);
				if($ride){
					// driver_message
					if($ride['ride_type'] == 1) {
						$ride_type = 'pickup';
					}else{
						$ride_type = 'delivery';
					}
					$driver_msg = "You are directed to provide your ".$ride_type." service on below mentioned Address:\nUser name : ".$ride['customer_name']."\nAddress : ".$ride['customer_address']."\nPhone No : ".$ride['customer_phone']."\nReg. No : ".$ride['registration_no'];

						$driver_notification = array(
							'driver_id' => $ride['driver_id'],
							'text'=>$driver_msg,
							'created_at'=>date('Y-m-d H:i:s')
						);

						$this->DriverNotificationModel->insert($driver_notification);

						$msg=array('body'=>$driver_msg,'title'=>'Revive auto care','icon'=> base_url().'public/images/app/notify_icon.png','sound'=> 1);
						$notifymsg=array(
							'notification'=>$msg,
							'to'  =>$ride['d_device_id']
						);

						$notification_result=send_push_notification($notifymsg,DRIVER_PUSH_AUTH_KEY);
						// user message
						$user_msg = 'Dear '.$ride['customer_name'].', On confirmation of your enquiry , REVIVE driver '.$ride['d_name'].' is coming to '.$ride_type.' your car. Insert OTP '.$otp.' for Confirmation to start assistance and service';

						$notification_data = array(
							'user_id'=>$ride['user_id'],
							'text' =>$user_msg,
							'created_at'=>date("Y-m-d H:i:s")
						);

						$this->NotificationModel->insert($notification_data);

						$user_notify_msg_data=array('body'=>$data['body'],'title'=>'Revive auto care','icon'=> base_url().'public/images/app/notify_icon.png','sound'=> 1);
						$usernotifymsg=array(
							'notification'=>$user_notify_msg_data,
							'to'  =>$ride['device_id']
						);
						if($ride['device_type'] == 'A'){
							$notification_result=send_push_notification($usernotifymsg,ANDRIOD_PUSH_AUTH_KEY);
						}else if($ride['device_type'] == 'I'){
							$notification_result=send_push_notification($usernotifymsg,IOS_PUSH_AUTH_KEY);
						}

						$this->session->set_flashdata('success_msg','Ride scheduled successfully!');
						redirect('workshop/order/create_ride/'.$hash);
				}
			}else{
				$this->session->set_flashdata('error_msg','Something went wrong!');
				redirect('workshop/order/create_ride/'.$hash);
			}
		}

		$data['hash'] = $hash;
		$data['order'] = $order;
		//dd($order);
		$manager_id = $this->session->userdata('id');
		$data['drivers'] = $this->DriverModel->get_all(array('d_workshop_assign'=>$manager_id));
		$this->renderView('workshop/order/create_ride',$data);

	}

	public function get_notifications() {
		
		$manager_id = $this->session->userdata('id');
		$data['orders'] = $this->OrderModel->getWorkshopOrderNotification($manager_id);
		//dd($data['enquiries']);
		if(!empty($data['orders'])) {
			$template = $this->load->view('workshop/order/notification',$data,true);
			$response = array('status'=>true,'template'=>$template,'total'=>count($data['orders']));
		}else{
			$response = array('status'=>false,"Detail not found");
		}
		$this->renderJson($response);
	}


}// end of class
