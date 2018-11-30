<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceList extends Rest_Controller {

	
	public function __construct()
	{
	    parent::__construct();
	    $this->load->helper('api');
	    $this->load->model('ServiceListModel');
	}

	public function getAllservices(){
			$data= array();
			$data= $this->ServiceListModel->getServiceList();
			//print_r($data);die;
			if(!empty($data)){
				foreach ($data as &$servicelist) {
						$servicelist['image']=base_url().'public/images/admin/car/'.$servicelist['image'];
			
				}
				$response = array('status'=>true,'message'=>'Services Listing','data' => $data);
			}else{
				$response = array('status'=>false,'message'=>'Something went wrong');
			}
	
		    $this->renderJson($response);
		
	}
		
}// end of class