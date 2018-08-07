<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class WorkshopModel extends MY_Model {

	protected $table = 'workshop_manager';
	
	public function __construct()
	{
	    parent::__construct();
	}


	public function checkEmailExistsExcept($id,$email){
		$this->db->select('*');
		$this->db->where(array('id !='=>$id,'m_email'=>$email));
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return (!empty($result))?true:false;
	}

	public function checkPhoneExistsExcept($id,$phone){
		$this->db->select('*');
		$this->db->where(array('id !='=>$id,'m_phone'=>$phone));
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return (!empty($result))?true:false;
	}



	public function checkEmailExists($email){
		$this->db->select('m_email');
		$this->db->where(array('m_email'=>$email));
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		return (!empty($result))? $result : false;
	}

	public function checkPhoneExists($phone) {
		$this->db->select('id,m_phone');
		$this->db->where(array('m_phone'=>$phone));
		$query = $this->db->get($this->table);
		$result = $query->row_array();
		return (!empty($result))? $result :false;
	}

}