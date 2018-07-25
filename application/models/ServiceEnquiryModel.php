<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ServiceEnquiryModel extends MY_Model {

	protected $table = 'service_enquiries';

	public function __construct()
	{
	    parent::__construct();
	}

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
}
