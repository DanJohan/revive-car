<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DriverModel extends MY_Model {

	protected $table = 'driver';

	public function __construct()
	{
	    parent::__construct();
	}

	public function check_user_exits($data = array()) {
		$this->db->select('id,d_name,d_phone,d_email,d_password',false);
		$this->db->where($data);
		$query=$this->db->get($this->table);
		$result=$query->row_array();
		return (!empty($result))?$result:false;
	}


	public function checkEmailExistsExcept($id,$email){
		$this->db->select('*');
		$this->db->where(array('id !='=>$id,'d_email'=>$email));
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return (!empty($result))?true:false;
	}

	public function checkPhoneExistsExcept($id,$phone){
		$this->db->select('*');
		$this->db->where(array('id !='=>$id,'d_phone'=>$phone));
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return (!empty($result))?true:false;
	}



	public function checkEmailExists($email){
		$this->db->select('d_email');
		$this->db->where(array('d_email'=>$email));
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}

	public function checkPhoneExists($phone) {
		$this->db->select('id,d_phone');
		$this->db->where(array('d_phone'=>$phone));
		$query = $this->db->get($this->table);
		$result = $query->row_array();
		return (!empty($result))? $result :false;
	}

	public function getDriversByWorkshop($manager_id) {
		$this->db->select('id');
		$this->db->where(array('d_workshop_assign'=>$manager_id));
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return (!empty($result))? $result :null;
	}


}
