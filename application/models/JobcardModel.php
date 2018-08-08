<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JobcardModel extends MY_Model {

	protected $table = 'job_cards';

	public function __construct()
	{
	    parent::__construct();
	}

	public function JobcardDetails(){
		$this->db->select('jc.*,c.color,u.name,u.phone,cb.brand_name,cm.model_name');
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

	public function getJobCardById($id) {
		$this->db->select('jc.*,
			GROUP_CONCAT(DISTINCT jci.id SEPARATOR "|") AS image_ids,
			GROUP_CONCAT(DISTINCT jci.image SEPARATOR "|") AS images,
			GROUP_CONCAT(DISTINCT j.id SEPARATOR "|") AS job_ids,
			GROUP_CONCAT(DISTINCT j.name SEPARATOR "|") AS job_names,
			GROUP_CONCAT(DISTINCT j.description SEPARATOR "|") AS job_descriptions,
			c.color,cb.brand_name,cm.model_name,u.phone,u.email,u.name,se.address,
			GROUP_CONCAT(DISTINCT ei.id SEPARATOR "|") AS enquiry_image_ids,
			GROUP_CONCAT(DISTINCT ei.image SEPARATOR "|") AS enquiry_images,
			'
		);
		$this->db->from($this->table.' AS jc');
		$this->db->join('job_card_images AS jci','jc.id=jci.job_card_id','left');
		$this->db->join('jobs AS j','jc.id=j.job_card_id','left');
		$this->db->join('users AS u','jc.user_id = u.id');
		$this->db->join('cars AS c', 'jc.car_id = c.id');
		$this->db->join('car_brands AS cb', 'c.brand_id=cb.id');
		$this->db->join('car_models AS cm', 'c.model_id=cm.id');
		$this->db->join('service_enquiries AS se','jc.enquiry_id=se.id');
		$this->db->join('enquiry_images AS ei','se.id=ei.enquiry_id','left');
		$this->db->where('jc.id',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->row_array();
	}
}