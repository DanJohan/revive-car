<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CarModelsModel extends MY_Model {

	protected $table = 'car_models';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getModelsWithBrand(){
		$this->db->select('cm.*,cb.brand_name,ct.name AS car_type_name');
		$this->db->from($this->table.' AS cm');
		$this->db->join('car_brands AS cb','cm.brand_id=cb.id');
		$this->db->join('car_types AS ct','cm.car_type = ct.id','left');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}


	public function getModelsByBrandId($brand_id) {
		$this->db->select('id, model_name');
		$this->db->from($this->table);
		$this->db->where('brand_id',$brand_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}

}
