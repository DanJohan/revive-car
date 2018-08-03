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

}