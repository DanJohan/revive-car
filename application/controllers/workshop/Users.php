<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Users extends MY_Controller {

		public function __construct(){
			parent::__construct();
			if (!$this->session->userdata['is_manager_login'] == TRUE)

			{
			   redirect('workshop/auth/login'); //redirect to login page
			}
			$this->load->model('CarModel');
			$this->load->model('UserModel');

		}

		public function index(){
			$data['userData'] =  $this->UserModel->get_all();

			$this->renderView('workshop/users/user_list', $data);
		}

		public function show($id){
			$data=array();
			$criteria['field'] = 'id,phone,name,email,profile_image';
			$criteria['conditions'] = array('id'=>$id);
			$criteria['returnType'] = 'single';
			$data['user'] =  $this->UserModel->search($criteria);
			$data['cars'] = $this->CarModel->getCarWithUserByUserId($id);
			$this->renderView('workshop/users/user_view',$data);
		  }
		
		
	}


?>
