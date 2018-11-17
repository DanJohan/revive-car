<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserModel extends MY_Model {

	protected $table = 'users';

	public function __construct()
	{
	    parent::__construct();
	}

	private function getUserColumn(){
		return array("u.id", 'u.name', 'u.email', 'u.phone', 'u.created_at');
	}

	public function getUsers($start,$limit,$orders,$search){
		$this->db->select('SQL_CALC_FOUND_ROWS u.id,u.name ,u.email,u.phone, u.created_at',false);
		$this->db->from($this->table.' AS u');

		if(!empty($search['value'])){
			$this->db->or_like(
				array(
					'u.id'=>$search['value'],
					'u.name' =>$search['value'],
					'u.email' => $search['value'],
					'u.phone'=>$search['value'],
					'u.created_at' => $search['value'],
				)
			);
		}
	
		$columns = $this->getUserColumn();
		//dd($columns);
		foreach ($columns as $c_index => $column) {
			if($orders[0]['column'] == $c_index) {
				$this->db->order_by($column,$orders[0]['dir']);
			}
		}

		$this->db->limit($limit,$start);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}

	public function verifyOtp($data=array()) {
		$this->db->select('*');
		$this->db->where($data);
		$query=$this->db->get($this->table);
		$result=$query->result_array();
		return (!empty($result))?true:false;
	}

	public function check_user_exits($data = array()) {
		$this->db->select('id,name,phone,email,password,created_at',false);
		$this->db->where("(phone='".$data['username']."' OR email='".$data['username']."')");
		$query=$this->db->get($this->table);
		$result=$query->row_array();
		return (!empty($result))?$result:false;
	}

	public function checkEmailExistsExcept($id,$email){
		$this->db->select('*');
		$this->db->where(array('id !='=>$id,'email'=>$email));
		$query = $this->db->get($this->table);
		$result = $query->row_array();
		return (!empty($result))?true:false;
	}

	public function checkPhoneExistsExcept($id,$phone){
		$this->db->select('*');
		$this->db->where(array('id !='=>$id,'phone'=>$phone));
		$query = $this->db->get($this->table);
		$result = $query->row_array();
		return (!empty($result))?true:false;
	}

	public function checkEmailExists($email){
		$this->db->select('id,email');
		$this->db->where(array('email'=>$email));
		$query = $this->db->get($this->table);
		$result = $query->row_array();
		return (!empty($result))? $result : false;
	}

	public function checkPhoneExists($phone) {
		$this->db->select('id,phone,otp_verify');
		$this->db->where(array('phone'=>$phone));
		$query = $this->db->get($this->table);
		$result = $query->row_array();
		return (!empty($result))? $result :false;
	}


}
