<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ServiceEnquiryModel extends MY_Model {

	protected $table = 'service_enquiries';

	public function __construct()
	{
	    parent::__construct();
	}

	// used in api
	public function getEnquiryById($id) {
		$this->db->select('e.id,e.car_id,e.address,e.loaner_vehicle,e.enquiry,e.created_at,GROUP_CONCAT(ei.id SEPARATOR "|") AS image_id,GROUP_CONCAT(ei.image SEPARATOR "|") AS image',false);
		$this->db->from($this->table.' AS e');
		$this->db->where(array('e.id'=>$id));
		$this->db->join('enquiry_images AS ei','e.id=ei.enquiry_id','left');
		$this->db->group_by('e.id');
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))? $result : false;
	}


	public function getAllEnquiries(){
		$this->db->select('e.*,cb.brand_name,cm.model_name,u.name');
		$this->db->from($this->table.' AS e');
		$this->db->join('cars AS c','e.car_id = c.id');
		$this->db->join('car_brands AS cb','c.brand_id = cb.id');
		$this->db->join('car_models AS cm','c.model_id = cm.id');
		$this->db->join('users AS u','c.user_id = u.id');
		$this->db->order_by('e.id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;

	}

	// used in crm
	public function getEnquiry($id){
		$this->db->select('e.id,e.address,e.loaner_vehicle,e.enquiry,e.confirmed,e.created_at,GROUP_CONCAT(em.id SEPARATOR "|")AS image_id,GROUP_CONCAT(em.image SEPARATOR "|") AS images,cb.brand_name,cm.model_name,u.name,u.phone,u.email,d.d_name,d.id AS driver_id');
		$this->db->from($this->table.' AS e');
		$this->db->join('cars AS c','e.car_id = c.id');
		$this->db->join('car_brands AS cb','c.brand_id = cb.id');
		$this->db->join('car_models AS cm','c.model_id = cm.id');
		$this->db->join('enquiry_images AS em','e.id = em.enquiry_id');
		$this->db->join('users AS u','c.user_id = u.id');
		$this->db->join('driver AS d','e.assign_driver= d.id','left');
		$this->db->where('e.id',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$result = $query->row_array();
		return (!empty($result))? $result : false;
	}

	public function getEnquiryNotification() {
		$this->db->select('e.id,e.address,e.loaner_vehicle,e.enquiry,e.seen,e.created_at,cb.brand_name,cm.model_name,u.name');
		$this->db->from($this->table.' AS e');
		$this->db->join('cars AS c','e.car_id = c.id');
		$this->db->join('car_brands AS cb','c.brand_id = cb.id');
		$this->db->join('car_models AS cm','c.model_id = cm.id');
		$this->db->join('users AS u','c.user_id = u.id');
		$this->db->where('e.seen',0);
		$this->db->order_by('e.id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}

	public function markEnquirySeen($id){
		$this->db->where(array('id'=>$id));
		$this->db->update($this->table, array('seen'=>1));
	}
}
