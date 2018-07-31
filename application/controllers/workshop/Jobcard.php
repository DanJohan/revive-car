<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Jobcard extends MY_Controller {

		public function __construct(){
			parent::__construct();
		/* if (!$this->session->userdata['is_manager_login'] == TRUE)

		{
		   redirect('workshop/auth/login'); //redirect to login page
		}  */
		
			$this->load->model('JobcardModel');
		}

						
		public function view_jobcard(){
			$data=array();
			//$data['jobcardData'][0] =  $this->JobcardModel->get_all();
			$data['view'] = 'workshop/jobcard/view_jobcard';
			$this->load->view('workshop/layout', $data);

		  }


	}


?>