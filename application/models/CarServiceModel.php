<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CarServiceModel extends MY_Model {

	protected $table = 'car_services';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getCarServiceById($id){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return (!empty($result))? $result :false;
	}

	public function getCarServicesWithCateogory(){
		$this->db->select('cs.id,cs.name,cs.image,csc.category,cs.created_at');
		$this->db->from($this->table.' AS cs');
		$this->db->join('car_service_category AS csc','cs.category_id = csc.id');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result)) ? $result : null;
	}

}
