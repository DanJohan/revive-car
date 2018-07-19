<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserModel extends MY_Model {

	protected $table = 'users';

	public function __construct()
	{
	    parent::__construct();
	}

	public function verifyOtp($data=array()) {
		$this->db->select('*');
		$this->db->where($data);
		$query=$this->db->get($this->table);
		$result=$query->result_array();
		return (!empty($result))?true:false;
	}

	public function check_user_exits($data = array()) {
		$this->db->select('*',false);
		$this->db->where("(phone='".$data['username']."' OR email='".$data['username']."')");
		$query=$this->db->get($this->table);
		$result=$query->row_array();
		return (!empty($result))?$result:false;
	}

}
