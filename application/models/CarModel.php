<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CarModel extends MY_Model {

	protected $table = 'cars';

	public function __construct()
	{
	    parent::__construct();
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


}