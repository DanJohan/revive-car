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
		$this->db->select('jc.*,c.color,c.registration_no,u.name,u.phone,cb.brand_name,cm.model_name');
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

	public function getJobCardById($id,$driver_ids=null) {
		$this->db->select('jc.*,jci.id AS image_id,jci.image,ro.id AS repair_order_id,ro.parts_name,ro.customer_request,ro.sa_remarks,ro.qty,ro.price_labour,ro.price_parts,ro.price_total,ro.status,c.registration_no,c.color,cb.brand_name,cm.model_name,u.phone,u.email,u.name,u.profile_image,se.loaner_vehicle,se.address,ei.id AS enquiry_image_id,ei.image AS enquiry_image'
		);
		$this->db->from($this->table.' AS jc');
		$this->db->join('job_card_images AS jci','jc.id=jci.job_card_id','left');
		$this->db->join('repair_orders AS ro','jc.id=ro.job_card_id','left');
		$this->db->join('users AS u','jc.user_id = u.id');
		$this->db->join('cars AS c', 'jc.car_id = c.id');
		$this->db->join('car_brands AS cb', 'c.brand_id=cb.id');
		$this->db->join('car_models AS cm', 'c.model_id=cm.id');
		$this->db->join('service_enquiries AS se','jc.enquiry_id=se.id');
		$this->db->join('enquiry_images AS ei','se.id=ei.enquiry_id','left');
		$this->db->where('jc.id',$id);
		if($driver_ids){
			$this->db->where_in('jc.driver_id', $driver_ids);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->result_array();
	}
}