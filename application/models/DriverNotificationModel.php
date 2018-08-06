<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DriverNotificationModel extends MY_Model {
	protected $table = 'driver_notifications';
	public function __construct()
	{
	    parent::__construct();
	}
	public function getById($user_id) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where(array('driver_id'=>$user_id));
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result : null;
	}
}// end of class