<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DriverModel extends MY_Model {

	protected $table = 'driver';

	public function __construct()
	{
	    parent::__construct();
	}

	public function get_driver_by_id($id){
			$query = $this->db->get_where($this->table, array('id' => $id));
			return $result = $query->row_array();
		}

		public function edit($data, $id){
			$this->db->where('id', $id);
			$this->db->update($this->table, $data);
			return true;
		}
}
