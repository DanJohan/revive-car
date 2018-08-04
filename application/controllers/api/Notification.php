<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {

	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('NotificationModel');
	}

	public function getUserNotification(){
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$notifications = $this->NotificationModel->getByUserId($user_id);
			if($notifications){
				$response = array('status'=>true,'message'=>'Record found successfully','data'=>$notifications);
			}else{
				$response = array('status'=>false,'message'=>'Detail not found');
			}
 
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}

		$this->renderJson($response);
	}

	public function markNotificationToSeen(){
		$this->form_validation->set_rules('notification_id', 'Notification id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$id = $this->input->post('notification_id');
			$this->NotificationModel->update(array('seen'=>1),array('id'=>$id));
			$response = array('status'=>true,'message'=>'Record updated successfully');
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function deleteNotification(){
		$this->form_validation->set_rules('notification_id', 'Notification id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$id = $this->input->post('notification_id');
			$this->NotificationModel->delete(array('id'=>$id));
			$response = array('status'=>true,'message'=>'Record deleted successfully');
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}

	public function deleteAllNotifications(){
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$this->NotificationModel->delete(array('user_id'=>$user_id));
			$response = array('status'=>true,'message'=>'Record deleted successfully');
		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}
}