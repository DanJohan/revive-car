<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CarModelsModel extends MY_Model {

	protected $table = 'car_models';

	public function __construct()
	{
	    parent::__construct();
	}

	public function getModelsWithBrand(){
		$this->db->select('cm.*,cb.brand_name');
		$this->db->from($this->table.' AS cm');
		$this->db->join('car_brands AS cb','cm.brand_id=cb.id');
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}


	public function getModelsByBrandId($brand_id) {
		$this->db->select('id, model_name,CASE WHEN fuel_type = 1 THEN "Petrol" WHEN fuel_type =2 THEN "CNG" WHEN fuel_type = 3 THEN "Diesel" ELSE "" END AS fuel_type',false);
		$this->db->from($this->table);
		$this->db->where('brand_id',$brand_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return (!empty($result))? $result :false;
	}

}