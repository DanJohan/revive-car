<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends MY_Controller {

	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('UserModel');
	    $this->load->model('JobcardModel');

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
			return ;
		}

		if(empty($job_card)){
			log_message('debug',"No detail found for ".$id);
			show_error('No detail found!',404);
		}
		$job_card_images_key = array('job_card_image_id','job_card_image');
		$job_card_images = array_filter_by_value(array_unique(array_column_multi($job_card, $job_card_images_key),SORT_REGULAR),'job_card_image_id','');
		//$repair_orders = array_filter_by_value(array_unique(array_column_multi($job_card, array('repair_order_id','parts_name','customer_request','sa_remarks','qty','labour_price','parts_price','total_price')),SORT_REGULAR),'repair_order_id','');
		//$enquiry_images = array_filter_by_value(array_unique(array_column_multi($job_card, array('enquiry_image_id','enquiry_image')),SORT_REGULAR),'enquiry_image_id','');
		$job_card = $job_card[0];
		$removeKeys=array_merge($job_card_images_key);
		foreach($removeKeys as $key) {
		   unset($job_card[$key]);
		}
		$job_card['images_data']=$job_card_images;
		//$job_card['repair_orders']=$repair_orders;
		//$job_card['enquiry_images'] = $enquiry_images;
		$data['job_card'] = $job_card;
		//dd($data['job_card']);
		$this->load->view('api/job_card_detail',$data);
	}

}
