<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JobcardModel extends MY_Model {

	protected $table = 'job_cards';

	public function __construct()
	{
	    parent::__construct();
	}

	public function JobcardDetails(){
		$this->db->select('jc.job_name,jc.created_at,se.id AS enquiry_id,c.color,u.name,cb.brand_name,cm.model_name');
	    $this->db->from('job_cards AS jc');
	    $this->db->join('service_enquiries AS se', 'se.id = jc.enquiry_id'); 
	    $this->db->join('cars AS c','c.id = se.car_id');
	    $this->db->join('car_brands AS cb','cb.id = c.brand_id');
	    $this->db->join('car_models AS cm','cm.id = c.model_id');
	    $this->db->join('users AS u','c.user_id = u.id');
		$query = $this->db->get();
		//$this->db->last_query();
	    return $query->result_array();


	}
}