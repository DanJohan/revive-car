<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->has_userdata('is_admin_login'))
		{
			redirect('admin/auth/login');
		}
		$this->load->helper('api');
		$this->load->model('ServiceEnquiryModel');
		$this->load->model('NotificationModel');
		$this->load->model('DriverNotificationModel');
		$this->load->model('DriverModel');
		$this->load->model('WorkshopModel'); 
		$this->load->library('textMessage'); 

		
	}

	public function index( $id = null){
		if($id){
			$this->ServiceEnquiryModel->markEnquirySeen($id);
		}
		$data['enquiries'] = $this->ServiceEnquiryModel->getAllEnquiries();
		//dd($data['enquiries']);
		$data['view'] = 'admin/enquiry/index';
		$this->load->view('admin/layout', $data);
	}

	public function show($id=null){
		if($id){
			$this->ServiceEnquiryModel->markEnquirySeen($id);
			$data['enquiry'] = $this->ServiceEnquiryModel->getEnquiry($id);
		}
		if(empty($data['enquiry'])) {
			redirect('admin/enquiry/index');
		}
		$data['view'] = 'admin/enquiry/show';
		$this->load->view('admin/layout', $data);
	}

	public function confirm($id=null) {
		//dd($_POST);
		if($id){
			$data['enquiry'] = $this->ServiceEnquiryModel->getEnquiry($id);
		}

		if(empty($data['enquiry'])) {
			$this->renderJson(array('status'=>false,'message'=>'No detail found!'));

		}

		if($data['enquiry']['confirmed']) {
			$this->renderJson(array('status'=>false,'message'=>'Enquiry already confirmed!'));
		}

		//$data['drivers'] = $this->DriverModel->get_all();
		$data['wmanagers'] = $this->WorkshopModel->get_all();

		$template = $this->load->view('admin/enquiry/confirm', $data,true);
		$this->renderJson(array('status'=>true,'message'=>'Record found successfully','template'=>$template));
		
	}

	public function save_enquiry_confirm() {
		//dd($_POST);
		if(count($_POST) > 0) {

			$enquiry_id = $this->input->post('enquiry_id');
			$factory = new RandomLib\Factory;
			$generator =$factory->getMediumStrengthGenerator();
			$randomInt = $generator->generateInt(100000, 999999);
			$randomChar = $generator->generateString(3,'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$otp = $randomChar.$randomInt;
			$update_data = array(
				'assign_driver' => ($this->input->post('driver'))?$this->input->post('driver'):null,
				'assign_manager' => ($this->input->post('wmanager'))?$this->input->post('wmanager'):null,
				'loaner_vehicle' => $this->input->post('loaner_vehicle'),
				'loaner_vehicle_cost' => str_replace(',', '', $this->input->post('loaner_vehicle_cost')),
				'estimated_cost' => str_replace(',','',$this->input->post('estimated_cost')),
				'confirmed' => 1,
				'verification_code' =>$otp
			);
			//dd($update_data);
			$is_update = $this->ServiceEnquiryModel->update($update_data,array('id'=>$enquiry_id));
			$enquiry = $this->ServiceEnquiryModel->getEnquiry($enquiry_id);

			$data['phone'] = $enquiry['phone'];
			$loaner_cost_msg = '';
			if($enquiry['loaner_vehicle_cost'] != '0.00'){
				$loaner_cost_msg = " and loaner vehicle cost will be ".$enquiry['loaner_vehicle_cost']." per day.";
			}
			if(!empty($enquiry['driver_id'])) {
				
				$data['body'] = 'Dear '.$enquiry['name'].', On confirmation of your enquiry , REVIVE driver '.$enquiry['d_name'].' is coming to pick your car. Estimated cost for your car services will be INR '.$enquiry['estimated_cost'].$loaner_cost_msg.' Insert OTP '.$otp.' for Confirmation to start assistance and service';
			}else{
				$data['body'] = 'Dear '.$enquiry['name'].', Thanks for Choosing Revive car care Service , we will glad to welcome you on our service center.Estimated cost for your car services will be INR '.$enquiry['estimated_cost'].$loaner_cost_msg.' Please enter '.$otp.' , when you reach to our workshop manager to start service.';
			}
			//$message = $this->textmessage->send($data);
			

			$notification_data = array(
				'user_id'=>$enquiry['user_id'],
				'text' =>$data['body'],
				'type'=>'enquiry_confirm',
				'created_at'=>date("Y-m-d H:i:s")
			);
			$this->NotificationModel->insert($notification_data);


			$msg=array('body'=>$data['body'],'title'=>'Revive auto car','icon'=> base_url().'public/images/app/notify_icon.png','sound'=> 1);
			$notifymsg=array(
				'notification'=>$msg,
				'to'  =>$enquiry['device_id']
			);
			if($enquiry['device_type'] == 'A'){
				$notification_result=send_push_notification($notifymsg,ANDRIOD_PUSH_AUTH_KEY);
			}else if($enquiry['device_type'] == 'I'){
				$notification_result=send_push_notification($notifymsg,IOS_PUSH_AUTH_KEY);
			}
			// notify to driver
			if(!empty($enquiry['driver_id'])){
				$driver_msg = "You are directed to provide your pickup service on below mentioned Address:\nUser name : ".$enquiry['name']."\nAddress : ".$enquiry['address']."\nPhone No : ".$enquiry['phone']."\nReg. No : ".$enquiry['registration_no'];

				$driver_notification = array(
					'driver_id' => $enquiry['driver_id'],
					'text'=>$driver_msg,
					'type'=>'enquiry_confirm',
					'enquiry_id'=>$enquiry['id'],
					'created_at'=>date('Y-m-d H:i:s')
				);

				$this->DriverNotificationModel->insert($driver_notification);

				$msg=array('body'=>$driver_msg,'title'=>'Revive auto car','icon'=> base_url().'public/images/app/notify_icon.png','sound'=> 1,'enquiry_id'=>$enquiry['id']);
					$notifymsg=array(
						'notification'=>$msg,
						'to'  =>$enquiry['d_device_id']
					);
				$notification_result=send_push_notification($notifymsg,DRIVER_PUSH_AUTH_KEY);

			}

			$this->session->set_flashdata('success_msg', 'Enquiry confirmed successfully!');


		}
		redirect('admin/enquiry/index');
	}

	public function get_notifications() {
		$data['enquiries'] = $this->ServiceEnquiryModel->getEnquiryNotification();
		if(!empty($data['enquiries'])) {
			$template = $this->load->view('admin/enquiry/notification',$data,true);
			$response = array('status'=>true,'template'=>$template,'total'=>count($data['enquiries']));
		}else{
			$response = array('status'=>false,"Detail not found");
		}

		$this->renderJson($response);
	}

	public function get_AssignDriver() {
		$manager_id = $this->input->post('manager_id');
		$criteria['field'] ="id,d_name";
		$criteria['conditions'] = array('d_workshop_assign'=>$manager_id);
		$drivers = $this->DriverModel->search($criteria);
		echo "<option value=''>Select driver</option>";
		if(!empty($drivers)){
			foreach ($drivers as $index => $driver) {
				echo "<option value='".$driver['id']."'>".$driver['d_name']."</option>";
			}
		}
		exit;
		
	}


}