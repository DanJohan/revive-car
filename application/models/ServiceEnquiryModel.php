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
		$this->db->select('e.id,e.car_id,e.user_id,e.address,e.location,e.loaner_vehicle,e.enquiry,CASE WHEN e.service_type =1 THEN "Denting" WHEN e.service_type=2 THEN "Painting" ELSE "Denting and Painting" END AS service_type,e.pick_up_date,e.pick_up_time,e.created_at,GROUP_CONCAT(ei.id SEPARATOR "|") AS image_id,GROUP_CONCAT(ei.image SEPARATOR "|") AS image',false);
		$this->db->from($this->table.' AS e');
		$this->db->where(array('e.id'=>$id));
		$this->db->join('enquiry_images AS ei','e.id=ei.enquiry_id','left');
		$this->db->group_by('e.id');
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))? $result : false;
	}

	// user in api
	public function getEnquiryWithUser($id){
		$this->db->select('e.id,e.car_id,e.user_id,e.address,e.location,e.loaner_vehicle,e.latitude,e.longitude,e.enquiry,c.registration_no,cb.brand_name,cm.model_name,CASE WHEN e.service_type =1 THEN "Denting" WHEN e.service_type=2 THEN "Painting" ELSE "Denting and Painting" END AS service_type,e.pick_up_date,e.pick_up_time,e.created_at,GROUP_CONCAT(ei.id SEPARATOR "|") AS image_id,GROUP_CONCAT(ei.image SEPARATOR "|") AS image,u.phone,u.name,u.email,u.profile_image',false);
		$this->db->from($this->table.' AS e');
		$this->db->where(array('e.id'=>$id));
		$this->db->join('enquiry_images AS ei','e.id=ei.enquiry_id','left');
		$this->db->join('cars AS c','e.car_id=c.id');
		$this->db->join('car_brands AS cb','c.brand_id=cb.id');
		$this->db->join('car_models AS cm','c.model_id=cm.id');
		$this->db->join('users AS u','c.user_id= u.id');
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
		$this->db->join('users AS u','e.user_id = u.id');
		$this->db->order_by('e.id','desc');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : false;

	}

	// used in crm
	public function getEnquiry($id){
		$this->db->select('e.id,e.address,e.location,e.loaner_vehicle,e.enquiry,e.service_type,e.pick_up_date,e.pick_up_time,e.confirmed,e.created_at,(loaner_vehicle_cost + estimated_cost) AS total_cost,GROUP_CONCAT(em.id SEPARATOR "|")AS image_id,GROUP_CONCAT(em.image SEPARATOR "|") AS images,cb.brand_name,cm.model_name,c.color,c.year,c.registration_no,u.id as user_id,u.name,u.phone,u.email,u.profile_image,u.device_id,u.device_type,d.d_name,d.id AS driver_id,d.d_phone,d.d_device_id,d.d_device_type');
		$this->db->from($this->table.' AS e');
		$this->db->join('cars AS c','e.car_id = c.id');
		$this->db->join('car_brands AS cb','c.brand_id = cb.id');
		$this->db->join('car_models AS cm','c.model_id = cm.id');
		$this->db->join('enquiry_images AS em','e.id = em.enquiry_id');
		$this->db->join('users AS u','c.user_id = u.id');
		$this->db->join('driver AS d','e.assign_driver= d.id','left');
		$this->db->where('e.id',$id);
		$query = $this->db->get();
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
	
	
//Confirm enquiries used in workshop crm
	public function getWorkshopConfirmedEnquiries($manager_id){
		$this->db->select('e.*,cb.brand_name,cm.model_name,u.name');
		$this->db->from($this->table.' AS e');
		$this->db->join('cars AS c','e.car_id = c.id');
		$this->db->join('car_brands AS cb','c.brand_id = cb.id');
		$this->db->join('car_models AS cm','c.model_id = cm.id');
		$this->db->join('users AS u','c.user_id = u.id');
		$this->db->order_by('e.id','DESC');
	    $this->db->where('e.confirmed=1 AND e.assign_manager='.$manager_id);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$result = $query->result_array();
		return (!empty($result))? $result : false;

	}

//Confirm enquiries used in workshop crm

//Workshop Enquiry notification workshop crm
	public function getWorkshopEnquiryNotification($manager_id) {
		$this->db->select('e.id,e.address,e.loaner_vehicle,e.enquiry,e.seen,e.created_at,cb.brand_name,cm.model_name,u.name');
		$this->db->from($this->table.' AS e');
		$this->db->join('cars AS c','e.car_id = c.id');
		$this->db->join('car_brands AS cb','c.brand_id = cb.id');
		$this->db->join('car_models AS cm','c.model_id = cm.id');
		$this->db->join('users AS u','c.user_id = u.id');
		$this->db->where('e.manager_seen=0 AND e.confirmed=1 AND e.assign_manager='.$manager_id);
		$this->db->order_by('e.id','DESC');
 		$query = $this->db->get();

		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}
	
	public function markEnquiryManagerSeen($id){
		$this->db->where(array('id'=>$id));
		$this->db->update($this->table, array('manager_seen'=>1));
	}

	//Workshop Enquiry notification End
	
	// used in user panel(user enquiries)
	public function getEnquiryByUser($id){
		$this->db->select('u.id AS user_id,e.enquiry,e.service_type,e.address,e.updated_at,c.registration_no,c.id AS car_id,m.model_name,b.brand_name');
		$this->db->from($this->table.' AS e');
		$this->db->join('users AS u', 'e.user_id=u.id');
		$this->db->join('cars AS c', 'c.user_id=u.id');
		$this->db->join('car_models AS m', 'c.model_id=m.id');
		$this->db->join('car_brands AS b', 'c.brand_id=b.id');
		$this->db->where(array('c.user_id'=>$id));
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}

		
}
