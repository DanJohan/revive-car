<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ManageAddressModel extends MY_Model {

	protected $table = 'manage_address';

	public function __construct()
	{
	    parent::__construct();
	}

		public function checkUserIdExists($user_id) {
		$this->db->select('id,user_id,location_type,address');
		$this->db->where(array('user_id'=>$user_id));
		$query = $this->db->get($this->table);
		$result = $query->row_array();
		return (!empty($result))? $result :false;
	}

}
