<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_admin_login'] == TRUE)
		{
			   redirect('admin/auth/login'); //redirect to login page
		} 

	}

	public function list(){
		$data = array();
		$this->render('admin/blog/list',$data);
	}

	public function ajax_blog_list() {

	}

	public function create(){
		$data = array();
		if($this->input->post('submit')) {
			dd($_FILES,false);
			dd($_POST);
		}
		$this->render('admin/blog/create',$data);
	}
}
