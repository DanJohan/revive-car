<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DriverModel extends MY_Model {

	protected $table = 'driver';

	public function __construct()
	{
	    parent::__construct();
	}

	public function check_driver_exists($data=array()) {
		$this->db->select('id,d_phone,d_password,created_at');
		$this->db->where($data);
		$query=$this->db->get($this->table);
		$result=$query->row_array();
		return (!empty($result))?$result:false;
	}

}
