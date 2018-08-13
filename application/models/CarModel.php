<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CarModel extends MY_Model {

	protected $table = 'cars';

	public function __construct()
	{
	    parent::__construct();
	}


	//used in crm
	public function getCarWithUserByUserId($user_id) {
		$this->db->select('c.*,cb.brand_name,cm.model_name,u.name,u.email,u.phone,u.profile_image');
		$this->db->from($this->table." AS c");
		$this->db->join('car_brands AS cb','cb.id=c.brand_id');
		$this->db->join('car_models AS cm','cm.id = c.model_id');
		$this->db->join('users AS u','c.user_id = u.id');
		$this->db->where(array('c.user_id'=>$user_id));
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function getCarById($id) {
		$this->db->select('c.*,cb.brand_name,cm.model_name');
		$this->db->from($this->table." AS c");
		$this->db->join('car_brands AS cb','cb.id=c.brand_id');
		$this->db->join('car_models AS cm','cm.id = c.model_id');
		$this->db->where(array('c.id'=>$id));
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function getUserAllCars($id){
		$this->db->select('c.*,cb.brand_name,cm.model_name');
		$this->db->from($this->table." AS c");
		$this->db->join('car_brands AS cb','cb.id=c.brand_id');
		$this->db->join('car_models AS cm','cm.id = c.model_id');
		$this->db->where(array('c.user_id'=>$id));
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function updateDefaultCar($user_id,$car_id){
		$this->db->set('is_default',1);
		$this->db->where(array('id'=>$car_id,'user_id'=>$user_id));
		$this->db->update($this->table);
		$this->db->set('is_default',0);
		$this->db->where(array('id !='=>$car_id,'user_id'=>$user_id));
		$this->db->update($this->table);

	}

	public function getDefaultCar($user_id) {
		$this->db->select('c.*,cb.brand_name,cm.model_name');
		$this->db->from($this->table." AS c");
		$this->db->join('car_brands AS cb','cb.id=c.brand_id');
		$this->db->join('car_models AS cm','cm.id = c.model_id');
		$this->db->where(array('c.user_id'=>$user_id,'is_default'=>1));
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function checkUserCarsExists($user_id) {
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where(array('user_id'=>$user_id));
		$result= $this->db->get()->result_array();
		return (!empty($result)) ? true : false ;
	}


}