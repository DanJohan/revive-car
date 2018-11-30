<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ServiceListModel extends MY_Model {

	protected $table = 'car_services_list';

	public function __construct()
	{
	    parent::__construct();
	}


	//used in crm
	public function getServiceList() {
		$this->db->select('sl.image,sc.name AS category_name,cb.name AS body_name');
		$this->db->from($this->table." AS sl");
		$this->db->join('services_category AS sc','sc.id=sl.cat_id');
		$this->db->join('car_bodies AS cb','cb.id = sl.body_id');
		$result = $this->db->get()->result_array();
		return $result;
	}

}
