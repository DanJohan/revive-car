<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata['is_admin_login'] == TRUE)
		{
			   redirect('admin/auth/login'); //redirect to login page
		} 
		$this->load->model('BlogModel');

	}
}// end of class
