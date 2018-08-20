<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class JobCard extends Rest_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('JobcardModel'); 
	}

	public function getUserJobCard(){
		$this->form_validation->set_rules('user_id', 'User id', 'trim|required');
		if ($this->form_validation->run() == true) {
			$user_id = $this->input->post('user_id');
			$job_cards = $this->JobcardModel->getUserAllJobCard($user_id);
			$result= array();
			if(!empty($job_cards)) {
				    $newJobs = [];

			    foreach($job_cards as $value)
			    {
			        $key = $value['job_card_id'];//.$value['registration_no'];
			        if (!isset($newJobs[$key]))
			        {
			            $newJobs[$key] = [];
			            $newJobs[$key]['repair_order'] = [];
			        }
			        $newJobs[$key]['job_card_id'] = $value['job_card_id'];
			        $newJobs[$key]['registration_no'] = $value['registration_no'];
			        $newJobs[$key]['color'] =$value['color'];
                    $newJobs[$key]['brand_name'] = $value['brand_name'];
                    $newJobs[$key]['model_name'] = $value['model_name'];
			        $newJobs[$key]['repair_order'][] = [
			            'repair_order_id' => $value['repair_order_id'],
			            'customer_request'=> $value['customer_request'],
			            'qty' => $value['qty'],
			            'sa_remarks'=>$value['sa_remarks'],
			            'parts_name'=>$value['parts_name'],
			            'status'=>$value['status'],
			            'start_date'=>$value['start_date'],
			            'end_date'=>$value['end_date'],
			            'delay_reason'=>$value['delay_reason']
			        ];
			    }
			    $newJobs = array_values($newJobs);
			    if(!empty($newJobs)){
			    	$response = array('status'=>true,'message'=>"Detail found successfully",'data'=>$newJobs);
			    }
	        }else{
	        	$response = array('status'=>false, 'message'=>"No detail found");
	        }

		}else{
			$errors = $this->form_validation->error_array();
			$response = array('status'=>false,'message'=>$errors);
		}
		$this->renderJson($response);
	}
}