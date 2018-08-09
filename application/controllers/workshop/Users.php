<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Users extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('UserModel');
		if (!$this->session->userdata['is_manager_login'] == TRUE)

		{
		   redirect('workshop/auth/login'); //redirect to login page
		} 

		}

		public function index(){
			$criteria['field'] = 'id,name,phone,email,created_at';

			$data['userData'] =  $this->UserModel->search($criteria);
			//$data['userData'] =array();
			$data['view'] = 'workshop/users/user_list';
			$this->load->view('workshop/layout', $data);
		}

		public function view_record_by_id($id){
			$data=array();
			$criteria['field'] = 'phone,name,email,profile_image';
			$criteria['conditions'] = array('id'=>$id);
			$criteria['returnType'] = 'single';
			$data['user'] =  $this->UserModel->search($criteria);
			echo $this->load->view('admin/users/user_view',$data,true);
			exit;
		  }
		
		
	}


?>