<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JobcardModel extends MY_Model {

	protected $table = 'job_cards';

	public function __construct()
	{
	    parent::__construct();
	}

	// user in admin crm
	public function jobcardDetails(){
		$this->db->select('jc.id,o.order_no,o.user_id,jc.created_at,c.registration_no,u.name,u.phone,cb.brand_name,cm.model_name');
	    	$this->db->from('job_cards AS jc');
	  	$this->db->join('placed_orders AS o', 'jc.order_id = o.id'); 
	  	//$this->db->join('customer_details AS cd', 'jc.order_id = cd.order_id');
	    	$this->db->join('cars AS c','c.id = o.car_id');
	    	$this->db->join('car_brands AS cb','cb.id = c.brand_id');
	    	$this->db->join('car_models AS cm','cm.id = c.model_id');
	    	$this->db->join('users AS u','o.user_id = u.id');
		$query = $this->db->get();
		//$this->db->last_query();
	    	return $query->result_array();


	}

	// user in workshop crm
	public function jobCardDetailsForWorkshop($driver_ids){
		$this->db->select('jc.id,o.order_no,o.user_id,jc.created_at,c.registration_no,u.name,u.phone,cb.brand_name,cm.model_name');
	    	$this->db->from('job_cards AS jc');
	  	$this->db->join('placed_orders AS o', 'jc.order_id = o.id'); 
	  	$this->db->join('customer_details AS cd', 'jc.order_id = cd.order_id');
	    	$this->db->join('cars AS c','c.id = o.car_id');
	    	$this->db->join('car_brands AS cb','cb.id = c.brand_id');
	    	$this->db->join('car_models AS cm','cm.id = c.model_id');
	    	$this->db->join('users AS u','o.user_id = u.id');
	    $this->db->where_in('jc.driver_id', $driver_ids);
		$query = $this->db->get();
		//$this->db->last_query();
	    return $query->result_array();


	}

	// used in crm admin
	public function getJobCardFromId($id,$driver_ids = array()) {
		$this->db->select('jc.id,jc.order_id,jc.driver_id,jc.alternate_no,jc.vin_no,jc.sa_name_no,jc.delivery_datetime,jc.reporting_datetime,jc.type_of_service,jc.ride_kms,jc.damage_mark,jc.car_properties,jc.fuel,jc.vehicle_qty,jc.signature,jc.created_at,jc.user_name,jc.user_phone,jc.user_email,jc.user_address,o.loaner_vehicle,o.user_id,o.sub_total,o.discount_amount,o.net_pay_amount,c.registration_no,cb.brand_name,cm.model_name,jci.id AS job_card_image_id,jci.image AS job_card_image,oi.id as order_item_id,oi.order_id as order_item_order_id ,oi.service_id,,oi.name as service_name,oi.price,oi.status as service_status');
		$this->db->from($this->table.' AS jc');
		$this->db->join('job_card_images AS jci','jc.id=jci.job_card_id','left');
		$this->db->join('placed_orders AS o','jc.order_id=o.id');
		//$this->db->join('customer_details AS cd','jc.order_id=cd.order_id');
		$this->db->join('order_items AS oi','jc.order_id= oi.order_id');
		$this->db->join('cars AS c', 'o.car_id = c.id');
		$this->db->join('car_brands AS cb', 'c.brand_id=cb.id');
		$this->db->join('car_models AS cm', 'c.model_id=cm.id');
		$this->db->where('jc.id',$id);
		if(!empty($driver_ids)){
			$this->db->where_in('jc.driver_id',$driver_ids);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->result_array();
	}

	// used in api web
	public function getJobCardById($id) {

		$this->db->select('jc.id,jc.order_id,jc.driver_id,jc.alternate_no,jc.vin_no,jc.sa_name_no,jc.delivery_datetime,jc.reporting_datetime,jc.type_of_service,jc.ride_kms,jc.damage_mark,jc.car_properties,jc.fuel,jc.vehicle_qty,jc.signature,jc.created_at,jc.user_name,jc.user_phone,jc.user_email,jc.user_address,o.loaner_vehicle,c.registration_no,cb.brand_name,cm.model_name,jci.id AS job_card_image_id,jci.image AS job_card_image,oi.id as order_item_id,oi.order_id as order_item_order_id ,oi.service_id,,oi.name as service_name,oi.price');
		$this->db->from($this->table.' AS jc');
		$this->db->join('job_card_images AS jci','jc.id=jci.job_card_id','left');
		$this->db->join('placed_orders AS o','jc.order_id=o.id');
		//$this->db->join('customer_details AS cd','jc.order_id=cd.order_id');
		$this->db->join('order_items AS oi','jc.order_id= oi.order_id');
		$this->db->join('cars AS c', 'o.car_id = c.id');
		$this->db->join('car_brands AS cb', 'c.brand_id=cb.id');
		$this->db->join('car_models AS cm', 'c.model_id=cm.id');
		$this->db->where('jc.id',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->result_array();
	}


	public function getUserAllJobCard($user_id){
		$this->db->select('jc.id,oi.id AS item_id,oi.name as item_name,oi.price as item_price,oi.status,oi.start_date,oi.end_date,oi.delay_reason,c.registration_no,cb.brand_name,cm.model_name');
		$this->db->from($this->table.' AS jc');
		$this->db->join('placed_orders AS o','jc.order_id=o.id');
		$this->db->join('order_items AS oi','o.id=oi.order_id');
		$this->db->join('cars AS c', 'o.car_id = c.id');
		$this->db->join('car_brands AS cb', 'c.brand_id=cb.id');
		$this->db->join('car_models AS cm', 'c.model_id=cm.id');
		$this->db->where('o.user_id',$user_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	// used in api
	public function getJobCardByDriverId($driver_id) {
		$this->db->select('jc.id, jc.user_name as name,c.registration_no,jc.user_address as address,jc.created_at');
		$this->db->from($this->table.' AS jc');
		$this->db->join('placed_orders AS o','jc.order_id=o.id');
		//$this->db->join('customer_details AS cd','jc.order_id=cd.order_id');
		//$this->db->join('users AS u','jc.user_id=u.id');
		$this->db->join('cars AS c','o.car_id=c.id');
		//$this->db->join('service_enquiries AS e','jc.enquiry_id=e.id');
		$this->db->where('jc.driver_id', $driver_id);
		$query = $this->db->get();
		return $query->result_array();
	}
}
