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
		$this->db->select('jc.*,c.color,c.registration_no,u.name,u.phone,cb.brand_name,cm.model_name');
	    $this->db->from('job_cards AS jc');
	    $this->db->join('service_enquiries AS se', 'se.id = jc.enquiry_id'); 
	    $this->db->join('cars AS c','c.id = jc.car_id');
	    $this->db->join('car_brands AS cb','cb.id = c.brand_id');
	    $this->db->join('car_models AS cm','cm.id = c.model_id');
	    $this->db->join('users AS u','jc.user_id = u.id');
		$query = $this->db->get();
		//$this->db->last_query();
	    return $query->result_array();


	}

	// user in workshop crm
	public function jobCardDetailsForWorkshop($driver_ids){
		$this->db->select('jc.*,c.registration_no,u.name,u.phone,cb.brand_name,cm.model_name');
	    $this->db->from('job_cards AS jc');
	    $this->db->join('service_enquiries AS se', 'se.id = jc.enquiry_id'); 
	    $this->db->join('cars AS c','c.id = jc.car_id');
	    $this->db->join('car_brands AS cb','cb.id = c.brand_id');
	    $this->db->join('car_models AS cm','cm.id = c.model_id');
	    $this->db->join('users AS u','jc.user_id = u.id');
	    $this->db->where_in('jc.driver_id', $driver_ids);
		$query = $this->db->get();
		//$this->db->last_query();
	    return $query->result_array();


	}

	// user in api
	public function getJobCardById($id,$driver_ids=null) {
		$this->db->select('jc.id,jc.order_id,jc.driver_id,jc.alternate_no,jc.vin_no,jc.sa_name_no,jc.delivery_datetime,jc.reporting_datetime,jc.type_of_service,jc.ride_kms,jc.damage_mark,jc.car_properties,jc.fuel,jc.vehicle_qty,jc.signature,jc.created_at,cd.name as user_name,cd.phone as user_phone,cd.email as user_email,cd.address as user_address,cd.landmark,o.loaner_vehicle,c.registration_no,cb.brand_name,cm.model_name,jci.id AS job_card_image_id,jci.image AS job_card_image,oi.id as order_item_id,oi.order_id as order_item_order_id ,oi.service_id,,oi.name as service_name,oi.price');
		$this->db->from($this->table.' AS jc');
		$this->db->join('job_card_images AS jci','jc.id=jci.job_card_id','left');
		$this->db->join('placed_orders AS o','jc.order_id=o.id');
		$this->db->join('customer_details AS cd','jc.order_id=cd.order_id');
		$this->db->join('order_items AS oi','jc.order_id= oi.order_id');
		//$this->db->join('users AS u','jc.user_id = u.id');
		$this->db->join('cars AS c', 'o.car_id = c.id');
		$this->db->join('car_brands AS cb', 'c.brand_id=cb.id');
		$this->db->join('car_models AS cm', 'c.model_id=cm.id');
		//$this->db->join('service_enquiries AS se','jc.enquiry_id=se.id');
		//$this->db->join('enquiry_images AS ei','se.id=ei.enquiry_id','left');
		$this->db->where('jc.id',$id);
		if($driver_ids){
			$this->db->where_in('jc.driver_id', $driver_ids);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->result_array();
	}


	public function getUserAllJobCard($user_id){
		$this->db->select('jc.id as job_card_id,ro.id AS repair_order_id,ro.parts_name,ro.customer_request,ro.sa_remarks,ro.qty,ro.labour_price,ro.parts_price,ro.total_price,ro.status,ro.start_date,ro.end_date,ro.delay_reason,c.registration_no,c.color,cb.brand_name,cm.model_name');
		$this->db->from($this->table.' AS jc');
		$this->db->join('repair_orders AS ro','jc.id=ro.job_card_id','left');
		$this->db->join('cars AS c', 'jc.car_id = c.id');
		$this->db->join('car_brands AS cb', 'c.brand_id=cb.id');
		$this->db->join('car_models AS cm', 'c.model_id=cm.id');
		$this->db->where('jc.user_id',$user_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	// used in api
	public function getJobCardByDriverId($driver_id) {
		$this->db->select('jc.id, cd.name,c.registration_no,cd.address,jc.created_at');
		$this->db->from($this->table.' AS jc');
		$this->db->join('placed_orders AS o','jc.order_id=o.id');
		$this->db->join('customer_details AS cd','jc.order_id=cd.order_id');
		//$this->db->join('users AS u','jc.user_id=u.id');
		$this->db->join('cars AS c','o.car_id=c.id');
		//$this->db->join('service_enquiries AS e','jc.enquiry_id=e.id');
		$this->db->where('jc.driver_id', $driver_id);
		$query = $this->db->get();
		return $query->result_array();
	}
}
