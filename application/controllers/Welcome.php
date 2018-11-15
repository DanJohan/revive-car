<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		redirect('admin/auth/login');
		die;
		$this->load->view('user');
		
	}
	
	public function test(){
	}

	public function update_service(){
		die("Are you sure to run this script!");
		$services = $this->db->get('car_services')->result_array();
		$service_ids = array_column($services, 'id');

		$models = $this->db->get('car_models')->result_array();
		$model_ids = array_column($models, 'id');

		foreach ($service_ids as $key => $service_id) {
			foreach ($model_ids as $index => $model_id) {
				if($service_id == 3){

					$insert_data[] = array(
						'service_id'=>$service_id,
						'model_id' => $model_id,
						'category_id'=> 3,
						'price' => 25000,
						'created_at' =>date("Y-m-d H:i:s")
					);

				}else if($service_id == 16){
					$insert_data[] = array(
						'service_id'=>$service_id,
						'model_id' => $model_id,
						'category_id'=> 4,
						'price' => 14999,
						'created_at' =>date("Y-m-d H:i:s")
					);

					$insert_data[] = array(
						'service_id'=>$service_id,
						'model_id' => $model_id,
						'category_id'=> 5,
						'price' => 14999,
						'created_at' =>date("Y-m-d H:i:s")
					);

				}else if($service_id == 17){

					$insert_data[] = array(
						'service_id'=>$service_id,
						'model_id' => $model_id,
						'category_id'=> 4,
						'price' => 14999,
						'created_at' =>date("Y-m-d H:i:s")
					);

					$insert_data[] = array(
						'service_id'=>$service_id,
						'model_id' => $model_id,
						'category_id'=> 5,
						'price' => 14999,
						'created_at' =>date("Y-m-d H:i:s")
					);

				}else{

					$insert_data[] = array(
						'service_id'=>$service_id,
						'model_id' => $model_id,
						'category_id'=> 1,
						'price' => 14999,
						'created_at' =>date("Y-m-d H:i:s")
					);

					$insert_data[] = array(
						'service_id'=>$service_id,
						'model_id' => $model_id,
						'category_id'=> 2,
						'price' => 14999,
						'created_at' =>date("Y-m-d H:i:s")
					);
				}		
				
			}
		}
		//dd($insert_data);
		$insert_id = $this->db->insert_batch('services',$insert_data);
		var_dump($insert_id);
	}

	
}// END OF CLASS
