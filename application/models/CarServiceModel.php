<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CarServiceModel extends MY_Model {

	protected $table = 'car_services';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getCarServiceName(){
		$this->db->select('*');
		$this->db->from($this->table);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}

}
